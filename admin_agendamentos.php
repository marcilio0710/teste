<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conecta usando db.php como nos outros arquivos
require_once('db.php');

// Garante que só admin acessa
if (!isset($_SESSION['email']) || $_SESSION['is_admin'] != 1) {
    header('Location: login.php?erro=nao_logado');
    exit();
}

// Mensagem de sucesso após exclusão
$mensagem = '';
if (isset($_GET['msg']) && $_GET['msg'] === 'excluido') {
    $mensagem = "Agendamento excluído com sucesso!";
}

// Excluir agendamento se solicitado por GET
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM agendamentos WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    // Redireciona para evitar re-execução ao atualizar página
    header("Location: admin_agendamentos.php?msg=excluido");
    exit();
}

// Buscar todos os agendamentos
try {
    $stmt = $pdo->query("SELECT * FROM agendamentos ORDER BY id DESC");
    $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $agendamentos = [];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração de Agendamentos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Lista de Agendamentos</h1>
    <?php if ($mensagem): ?>
        <p style="color:green;font-weight:bold;">
            <?php echo htmlspecialchars($mensagem); ?>
        </p>
    <?php endif; ?>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Horário</th>
                <th>Observações</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agendamentos as $agendamento): ?>
                <tr>
                    <td><?php echo htmlspecialchars($agendamento['id']); ?></td>
                    <td><?php echo htmlspecialchars($agendamento['nome']); ?></td>
                    <td><?php echo htmlspecialchars($agendamento['email']); ?></td>
                    <td><?php echo htmlspecialchars($agendamento['telefone']); ?></td>
                    <td><?php echo htmlspecialchars($agendamento['horario']); ?></td>
                    <td><?php echo htmlspecialchars($agendamento['observacoes']); ?></td>
                    <td>
                        <a href="admin_agendamentos.php?delete=<?php echo urlencode($agendamento['id']); ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                        <a href="editar_agendamento.php?id=<?php echo urlencode($agendamento['id']); ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="agendamentos.php">Voltar ao Painel</a>
</body>
</html>
