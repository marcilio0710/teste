<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('db.php'); // Certifique-se que está correto e sem nenhum echo

// Inicializa mensagem de erro (se houver)
$mensagem_erro = '';
if (isset($_GET['erro'])) {
    if ($_GET['erro'] === 'credenciais_invalidas') {
        $mensagem_erro = 'Email ou senha inválidos.';
    }
    elseif ($_GET['erro'] === 'campos_obrigatorios') {
        $mensagem_erro = 'Preencha todos os campos do formulário.';
    }
    elseif ($_GET['erro'] === 'nao_logado') {
        $mensagem_erro = 'Por favor, faça login para acessar.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($email) || empty($senha)) {
        header("Location: login.php?erro=campos_obrigatorios");
        exit();
    }

    // Consulta usuário
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Troque por password_verify se suas senhas já estiverem no formato hash!
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['is_admin'] = $usuario['is_admin'];

        // Redirecionamento conforme o tipo de usuário
        if ($_SESSION['is_admin'] == 1) {
            header("Location: agendamentos.php");
        } else {
            header("Location: usuario_home.php");
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
    <title>Área de Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <header>
        <!-- Seu cabeçalho como quiser -->
    </header>
    <main>
        <div class="container">
            <form method="POST" action="login.php">
                <h1>Login</h1>
                <?php if ($mensagem_erro): ?>
                    <div style="color:red;font-weight:bold;padding:8px 0;">
                        <?php echo htmlspecialchars($mensagem_erro); ?>
                    </div>
                <?php endif; ?>
                <div class="input-box">
                    <input placeholder="usuário" type="email" name="email" required>
                    <i class="fa-regular fa-user"></i>
                </div>
                <div class="input-box">
                    <input placeholder="senha" type="password" name="senha" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="remember-forgot">
                    <label>
                        <input type="checkbox"> Lembrar minha senha
                    </label>
                    <a href="recuperar_senha.html">Esqueci a senha</a>
                </div>
                <button type="submit" class="login-page">Entrar</button>
                <div class="register-link">
                    <p>Não tem uma conta? <a href="cadastro.html">Cadastre-se</a></p>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
