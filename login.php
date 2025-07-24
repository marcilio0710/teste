<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'db.php'; // sua conexão PDO/Postgres

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var(strtolower(trim($_POST['email'] ?? '')), FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'] ?? '';
    if (!$email) {
        echo "<script>alert('Email inválido'); window.location.href='login.php';</script>";
        exit;
    }
    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['nome'] = $usuario['nome'];
                $_SESSION['sobrenome'] = $usuario['sobrenome'];
                $_SESSION['nascimento'] = $usuario['nascimento'] ?? '';
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
    } catch (PDOException $e) {
        error_log("Erro no login: " . $e->getMessage());
        echo "Erro interno. Tente novamente mais tarde.";
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
