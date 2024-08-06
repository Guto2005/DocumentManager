<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM documents WHERE user_id = ?");
$stmt->execute([$user_id]);
$documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Meus Documentos</title>
</head>
<body>
    <h2>Meus Documentos</h2>
    <ul>
        <?php foreach ($documents as $doc): ?>
            <li>
                <a href="uploads/<?php echo htmlspecialchars($doc['file_name']); ?>" target="_blank">
                    <?php echo htmlspecialchars($doc['file_name']); ?>
                </a> - Enviado em <?php echo htmlspecialchars($doc['upload_date']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="upload.php">Enviar Novo Documento</a>
    <a href="logout.php">Sair</a>
</body>
</html>
