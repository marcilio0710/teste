<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conexao = mysqli_connect("localhost", "root", "", "testes");
if (!$conexao) {
    die("Erro na conexão com o banco.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var(strtolower(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'];

    if (!$email) {
        echo "<script>alert('Email inválido'); window.location.href='login.php';</script>";
        exit;
    }

    $stmt = mysqli_prepare($conexao, "SELECT * FROM usuarios WHERE email = ?");
    if (!$stmt) {
        error_log("Erro na preparação da consulta: " . mysqli_error($conexao));
        echo "Erro interno. Tente novamente mais tarde.";
        exit;
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($usuario = mysqli_fetch_assoc($resultado)) {
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['sobrenome'] = $usuario['sobrenome'];
            $_SESSION['nascimento'] = $usuario['nascimento'];
            $_SESSION['is_admin'] = $usuario['is_admin'];

            if ($_SESSION['is_admin'] == 1) {
                header("Location: agendamentos.php");
                exit;
            } else {
                header("Location: home.php");
                exit;
            }
        } else {
            echo "<script>alert('Senha incorreta'); window.location.href='login.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Usuário não encontrado'); window.location.href='login.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="login.php">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required><br><br>

        <button type="submit">Entrar</button>
    </form>
</body>
</html>
