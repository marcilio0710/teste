<?php
require_once('db.php'); // Incluindo o arquivo de conexão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $telefone = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_STRING);
    $data_nascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_STRING);
    $horario = filter_input(INPUT_POST, 'horario', FILTER_SANITIZE_STRING);
    $observacoes = filter_input(INPUT_POST, 'observacoes', FILTER_SANITIZE_STRING);

    if (!$email) {
        die("Email inválido.");
    }

    $sql = "INSERT INTO agendamentos (nome, email, telefone, data_nascimento, horario, observacoes)
            VALUES (:nome, :email, :telefone, :data_nascimento, :horario, :observacoes)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':data_nascimento', $data_nascimento);
    $stmt->bindParam(':horario', $horario);
    $stmt->bindParam(':observacoes', $observacoes);

    try {
        $stmt->execute();
        echo "Agendamento realizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao agendar: " . $e->getMessage();
    }
}
?>
