<?php
include('db.php'); // Incluindo o arquivo de conexão

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar os dados do formulário e sanitizá-los
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $telefone = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_STRING);
    $data_nascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_STRING);
    $horario = filter_input(INPUT_POST, 'horario', FILTER_SANITIZE_STRING);
    $observacoes = filter_input(INPUT_POST, 'observacoes', FILTER_SANITIZE_STRING);

    // Verifica se o e-mail é válido
    if (!$email) {
        die("Email inválido.");
    }

    // Prepara a consulta para inserir os dados na tabela agendamentos
    $sql = "INSERT INTO agendamentos (nome, email, telefone, data_nascimento, horario, observacoes)
            VALUES (:nome, :email, :telefone, :data_nascimento, :horario, :observacoes)";
    
    // Preparar o statement
    $stmt = $pdo->prepare($sql);

    // Executar a consulta com os dados recebidos
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':data_nascimento', $data_nascimento);
    $stmt->bindParam(':horario', $horario);
    $stmt->bindParam(':observacoes', $observacoes);
    
    try {
        // Executa a inserção no banco de dados
        $stmt->execute();
        echo "Agendamento realizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao agendar: " . $e->getMessage();
    }
}
?>
