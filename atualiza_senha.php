<?php
session_start();
require_once 'db.php'; // Arquivo com a conexão PDO

if (!isset($_SESSION['email_recuperacao'])) {
    echo "Sessão expirada. Tente novamente.";
    exit;
}

$nova_senha_raw = trim($_POST['nova_senha'] ?? '');
if (empty($nova_senha_raw)) {
    echo "A nova senha não pode estar em branco.";
    exit;
}

$nova_senha = password_hash($nova_senha_raw, PASSWORD_DEFAULT);
$email = $_SESSION['email_recuperacao'];

try {
    $sql = "UPDATE usuarios SET senha = :senha WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':senha', $nova_senha);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    unset($_SESSION['email_recuperacao']);
    echo "<script>alert('Senha atualizada com sucesso!'); window.location.href='login.html';</script>";
} catch (PDOException $e) {
    error_log("Erro ao atualizar senha: " . $e->getMessage());
    echo "Erro ao atualizar a senha. Tente novamente mais tarde.";
}
?>
