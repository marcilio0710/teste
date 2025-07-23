<?php
session_start();
require_once 'conexao.php'; // conexão PDO

// Verifica se o usuário é admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    echo "Você não tem permissão para acessar esta página.";
    exit;
}

// Verifica se o ID foi passado e é válido
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    try {
        $query = "DELETE FROM agendamentos WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Redireciona após exclusão
        header("Location: agendamentos.php?msg=deletado");
        exit;
    } catch (PDOException $e) {
        error_log("Erro ao deletar agendamento: " . $e->getMessage());
        echo "Erro ao excluir o agendamento. Tente novamente mais tarde.";
    }
} else {
    echo "ID inválido.";
}
?>
