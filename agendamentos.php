<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('db.php'); // Assumindo que $pdo já conecta seu banco

// Verifica se está logado
if (!isset($_SESSION['email'])) {
    header('Location: login.php?erro=nao_logado');
    exit();
}

// Só permite administradores
if ($_SESSION['is_admin'] != 1) {
    // Dica: pode redirecionar ou só bloquear:
    die("Acesso negado. Apenas administradores.");
}

// Busca os agendamentos
$stmt = $pdo->query("SELECT * FROM agendamentos");
$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de Agendamentos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="agendamento.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<header>
    <!-- Seu cabeçalho aqui -->
</header>
<main>
    <div class="agendamento-container container">
        <h1>Painel de Agendamentos</h1>
        <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?> (admin)!</p>

        <?php if (empty($agendamentos)): ?>
            <p>Nenhum agendamento encontrado.</p>
        <?php else: ?>
        <table border="1">
            <tr>
                <?php
                // Exibe os nomes de coluna
                foreach (array_keys($agendamentos[0]) as $coluna) {
                    echo '<th>' . htmlspecialchars($coluna) . '</th>';
                }
                ?>
            </tr>
            <?php foreach ($agendamentos as $linha): ?>
                <tr>
                    <?php foreach ($linha as $valor): ?>
                        <td><?php echo htmlspecialchars($valor); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>

        <a class="logout" href="logout.php">Sair</a>
    </div>
</main>
<script src="script.js"></script>
</body>
</html>
