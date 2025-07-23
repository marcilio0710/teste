<?php
session_start();
require_once 'conexao.php'; // conexão PDO

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitiza e valida email
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'] ?? '';

    if (!$email || !$senha) {
        echo "Preencha corretamente email e senha.";
        exit;
    }

    try {
        // Busca usuário pelo email
        $query = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Dados na sessão
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['is_admin'] = $usuario['is_admin'];

            // Redireciona conforme permissão
            if ($usuario['is_admin'] == 1) {
                header('Location: agendamentos.php');
                exit;
            } else {
                echo "Você não tem permissão para acessar esta página.";
                exit;
            }
        } else {
            echo "Email ou senha incorretos.";
            exit;
        }
    } catch (PDOException $e) {
        error_log("Erro no login: " . $e->getMessage());
        echo "Erro ao processar o login. Tente novamente mais tarde.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <header><h1>Login</h1></header>
    <main>
        <form method="POST" action="login.php">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required />

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required />

            <button type="submit">Entrar</button>
        </form>
    </main>
</body>
</html>
