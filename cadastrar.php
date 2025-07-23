<?php
require_once 'db.php'; // Conexão PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitização e validação
    $nome = trim($_POST['nome'] ?? '');
    $sobrenome = trim($_POST['sobrenome'] ?? '');
    $data_nascimento = trim($_POST['data_nascimento'] ?? '');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = trim($_POST['senha'] ?? '');

    // Verificações básicas
    if (!$nome || !$sobrenome || !$data_nascimento || !$email || !$senha) {
        echo "<script>alert('Todos os campos são obrigatórios.'); window.location.href='cadastro.html';</script>";
        exit;
    }

    try {
        // Verifica se o e-mail já existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->fetchColumn() > 0) {
            echo "<script>alert('E-mail já cadastrado!'); window.location.href='cadastro.html';</script>";
            exit;
        }

        // Criptografa a senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Insere o novo usuário
        $sql = "INSERT INTO usuarios (nome, sobrenome, data_nascimento, email, senha)
                VALUES (:nome, :sobrenome, :data_nascimento, :email, :senha)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':sobrenome', $sobrenome);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha_hash);

        $stmt->execute();

        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='login.html';</script>";
    } catch (PDOException $e) {
        error_log("Erro no cadastro: " . $e->getMessage());
        echo "<script>alert('Erro ao cadastrar. Tente novamente mais tarde.'); window.location.href='cadastro.html';</script>";
    }
}
?>
