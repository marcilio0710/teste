<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('db.php'); // seu arquivo de conexão PDO ($pdo)

// Só processa se for método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (!$email || !$senha) {
        // Retorne para login.html com erro (pode personalizar)
        header("Location: login.html?erro=campos_obrigatorios");
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Conferir senha (se já salva como hash no banco; ajuste se for texto puro)
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['is_admin'] = $usuario['is_admin'];

        // redireciona conforme o tipo
        if ($_SESSION['is_admin'] == 1) {
            header("Location: agendamentos.php");
        } else {
            header("Location: usuario_home.php"); // troque para sua página desejada
        }
        exit();
    } else {
        // login inválido
        header("Location: login.html?erro=credenciais_invalidas");
        exit();
    }
} else {
    // acesso indevido
    header("Location: login.html");
    exit();
}
