<?php
session_start();
require_once 'conexao.php'; // deve conter a conexão PDO com PostgreSQL

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    echo "Você não tem permissão para acessar esta página.";
    exit;
}

// Se for POST: atualizar o agendamento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $nome = trim($_POST['nome'] ?? '');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $telefone = trim($_POST['telefone'] ?? '');
    $horario = trim($_POST['horario'] ?? '');
    $observacoes = trim($_POST['observacoes'] ?? '');
    if (!$id || !$nome || !$email || !$telefone || !$horario || !$observacoes) {
        echo "Todos os campos são obrigatórios.";
        exit;
    }
    try {
        $sql = "UPDATE agendamentos
                SET nome = :nome, email = :email, telefone = :telefone, horario = :horario, observacoes = :observacoes
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':horario', $horario);
        $stmt->bindParam(':observacoes', $observacoes);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: agendamentos.php?msg=atualizado");
        exit;
    } catch (PDOException $e) {
        error_log("Erro ao atualizar agendamento: " . $e->getMessage());
        echo "Erro ao atualizar o agendamento. Tente novamente mais tarde.";
    }
}

// Se for GET: buscar o agendamento
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    echo "ID inválido.";
    exit;
}
try {
    $stmt = $pdo->prepare("SELECT * FROM agendamentos WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $agendamento = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$agendamento) {
        echo "Agendamento não encontrado.";
        exit;
    }
} catch (PDOException $e) {
    error_log("Erro ao buscar agendamento: " . $e->getMessage());
    echo "Erro ao carregar o agendamento.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Agendamento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header><h1>Editar Agendamento</h1></header>
    <main>
        <form method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($agendamento['id'], ENT_QUOTES, 'UTF-8') ?>">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" required value="<?= htmlspecialchars($agendamento['nome'], ENT_QUOTES, 'UTF-8') ?>">
            <label for="email">Email:</label>
            <input type="email" name="email" required value="<?= htmlspecialchars($agendamento['email'], ENT_QUOTES, 'UTF-8') ?>">
            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" required value="<?= htmlspecialchars($agendamento['telefone'], ENT_QUOTES, 'UTF-8') ?>">
            <label for="horario">Horário:</label>
            <input type="time" name="horario" required value="<?= htmlspecialchars($agendamento['horario'], ENT_QUOTES, 'UTF-8') ?>">
            <label for="observacoes">Observações:</label>
            <textarea name="observacoes" required><?= htmlspecialchars($agendamento['observacoes'], ENT_QUOTES, 'UTF-8') ?></textarea>
            <button type="submit">Atualizar Agendamento</button>
        </form>
    </main>
</body>
</html>
