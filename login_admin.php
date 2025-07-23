<?php
session_start();

// Verifica se está logado
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

// Verifica permissão admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: home.php');
    exit;
}

// Aqui você pode colocar o conteúdo da página para o admin
?>
