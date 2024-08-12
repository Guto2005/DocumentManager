<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Obter o nome de usuário
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Obter os documentos do usuário
$stmt = $pdo->prepare("SELECT * FROM documents WHERE user_id = ?");
$stmt->execute([$user_id]);
$documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Meus Documentos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: #fff;
            padding-top: 10px;
            min-height: 70px;
            border-bottom: #ccc 1px solid;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        .welcome-message {
            background: #e2e2e2;
            color: #333;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 18px;
            text-align: center;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            background: #fff;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        a {
            color: #333;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .links {
            margin-top: 20px;
            text-align: center;
        }
        .links a {
            margin: 0 10px;
            color: #007bff;
            text-decoration: none;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Document Manager</h1>
    </header>
    <div class="container">
        <h2>Meus Documentos</h2>
        <?php if ($user): ?>
            <div class="welcome-message">
                Bem-vindo, <?php echo htmlspecialchars($user['username']); ?>!
            </div>
        <?php endif; ?>
        <ul>
            <?php foreach ($documents as $doc): ?>
                <li>
                    <a href="uploads/<?php echo htmlspecialchars($doc['file_name']); ?>" target="_blank">
                        <?php echo htmlspecialchars($doc['file_name']); ?>
                    </a> - Enviado em <?php echo htmlspecialchars($doc['upload_date']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="links">
            <a href="upload.php">Enviar Novo Documento</a>
            <a href="logout.php">Sair</a>
        </div>
    </div>
</body>
</html>
