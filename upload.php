<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['document'])) {
    $user_id = $_SESSION['user_id'];
    $file = $_FILES['document'];
    $file_name = basename($file['name']);
    $target_file = __DIR__ . '/uploads/' . $file_name; // Caminho absoluto

    // Verificar se o arquivo é um PDF
    if ($file['type'] == 'application/pdf' && $file['error'] == UPLOAD_ERR_OK) {
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $stmt = $pdo->prepare("INSERT INTO documents (user_id, file_name) VALUES (?, ?)");
            if ($stmt->execute([$user_id, $file_name])) {
                $message = "Documento enviado com sucesso!";
            } else {
                $message = "Erro ao salvar documento no banco de dados.";
            }
        } else {
            $message = "Erro ao mover o arquivo para o diretório de uploads.";
        }
    } else {
        $message = "O arquivo deve ser um PDF válido.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload de Documento</title>
</head>
<body>
    <h2>Upload de Documento</h2>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <label>Escolha o arquivo PDF:</label>
        <input class="arquivo" type="file" name="document" accept=".pdf" required><br>
        <input class="enviar" type="submit" value="Enviar">
    </form>
    <a href="view_documents.php">Ver seus arquivos registrados</a>
    <a href="logout.php">Sair</a>
</body>
</html>
