<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: upload.php');
        exit();
    } else {
        echo "Nome de usuário ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post">
        <label>Nome de usuário:</label>
        <input type="text" name="username" required><br>
        <label>Senha:</label>
        <input type="password" name="password" required><br>
        <input class="login" type="submit" value="Login">
    </form>
    <div class="register">
    <p>Não tem uma conta? <a href="register.php">Registre-se</a></p>
    </div>
    
</body>
</html>
