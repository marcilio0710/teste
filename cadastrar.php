<?php
require_once 'db.php'; // Conexão PDO/PostgreSQL

$nome = trim($_POST['nome'] ?? '');
$sobrenome = trim($_POST['sobrenome'] ?? '');
$data_nascimento = trim($_POST['data_nascimento'] ?? '');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$senha = trim($_POST['senha'] ?? '');

if (!$nome || !$sobrenome || !$data_nascimento || !$email || !$senha) {
    echo "<script>alert('Preencha todos os campos corretamente!'); window.location.href='cadastro.html';</script>";
    exit;
}

// Verifica se o e-mail já está cadastrado
$stmt = $pdo->prepare("SELECT 1 FROM usuarios WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();

if ($stmt->fetch()) {
    echo "<script>alert('E-mail já cadastrado!'); window.location.href='cadastro.html';</script>";
} else {
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nome, sobrenome, data_nascimento, email, senha)
            VALUES (:nome, :sobrenome, :data_nascimento, :email, :senha)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':sobrenome', $sobrenome);
    $stmt->bindParam(':data_nascimento', $data_nascimento);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha_hash);
    if ($stmt->execute()) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar!'); window.location.href='cadastro.html';</script>";
    }
}
?>
