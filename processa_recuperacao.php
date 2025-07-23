<?php
session_start();
require_once 'db.php'; // conexão PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $data_nascimento = trim($_POST['data_nascimento'] ?? '');
    if (!$email || !$data_nascimento) {
        echo "<script>alert('Preencha todos os campos corretamente.'); window.location.href='recuperar_senha.html';</script>";
        exit;
    }
    try {
        $sql = "SELECT * FROM usuarios WHERE email = :email AND data_nascimento = :nasc LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':nasc', $data_nascimento);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario) {
            $_SESSION['email_recuperacao'] = $email;
            header("Location: nova_senha.php");
            exit;
        } else {
            echo "<script>alert('E-mail ou data de nascimento incorretos!'); window.location.href='recuperar_senha.html';</script>";
            exit;
        }
    } catch (PDOException $e) {
        error_log("Erro ao buscar usuário: " . $e->getMessage());
        echo "<script>alert('Erro interno. Tente novamente mais tarde.'); window.location.href='recuperar_senha.html';</script>";
        exit;
    }
} else {
    echo "<script>alert('Método inválido.'); window.location.href='recuperar_senha.html';</script>";
    exit;
}
?>
