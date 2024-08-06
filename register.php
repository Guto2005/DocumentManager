<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verificar se o nome de usuário já existe
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $userCount = $stmt->fetchColumn();

    if ($userCount > 0) {
        // Nome de usuário já existe
        echo "Nome de usuário já está em uso. Tente outro.";
    } else {
        // Inserir novo usuário
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        if ($stmt->execute([$username, $password])) {
            echo "Registro bem-sucedido! <a href='login.php'>Faça login</a>";
        } else {
            echo "Erro ao registrar.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
</head>
<body>
    <h2>Registro de Usuário</h2>
    <form method="post">
        <label>Nome de usuário:</label>
        <input class="usuario" type="text" name="username" required><br>
        <label>Senha:</label>
        <input type="password" name="password" required><br>
        <input class="registrar" type="submit" value="Registrar">
    </form>
    <a href="logout.php">Sair</a>
</body>
</html>

