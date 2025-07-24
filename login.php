<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Inclua o db.php correto para Render, utilizando variáveis de ambiente:
require_once('db.php');

$mensagem_erro = '';
if (isset($_GET['erro'])) {
    if ($_GET['erro'] === 'credenciais_invalidas') {
        $mensagem_erro = 'Email ou senha inválidos.';
    } elseif ($_GET['erro'] === 'campos_obrigatorios') {
        $mensagem_erro = 'Preencha todos os campos.';
    } elseif ($_GET['erro'] === 'nao_logado') {
        $mensagem_erro = 'Faça login para acessar.';
    }
}

// PROCESSAR LOGIN
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        header("Location: login.php?erro=campos_obrigatorios");
        exit();
    }

    // PROCURA O USUARIO
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificação com hash. Se usa senha em texto puro troque pelo teste simples
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['sobrenome'] = $usuario['sobrenome'];
        $_SESSION['nascimento'] = $usuario['data_nascimento']; // Ajuste conforme seu banco!
        $_SESSION['is_admin'] = $usuario['is_admin'];

        // REDIRECIONA
        if ($_SESSION['is_admin'] == 1) {
            header("Location: agendamentos.php");
        } else {
            header("Location: home.php");
        }
        exit();
    } else {
        header("Location: login.php?erro=credenciais_invalidas");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Login</h2>
    <?php if ($mensagem_erro): ?>
        <div style="color:red;padding:8px 0;">
            <?php echo htmlspecialchars($mensagem_erro); ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="login.php" autocomplete="off">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required><br><br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
