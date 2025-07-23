<?php
session_start();
if (!isset($_SESSION['email_recuperacao'])) {
    header("Location: recuperar_senha.html");
    exit;
}
// Aqui segue o conteúdo da página para quem tem permissão
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="cadastro.css"> <!-- Reaproveitando o estilo de cadastro -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <div class="social-bar">
            <div class="social-icones">
                <a href="#" class="social-link" id="instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="social-link" id="facebook"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="social-link" id="youtube"><i class="fa-brands fa-youtube"></i></a>
            </div>
            <div class="social-login">
                <button class="login">
                    <a href="login.html">
                        <span class="texto-login">
                            <i class="fa-solid fa-circle-user"></i> Fazer Login
                        </span>
                    </a>
                </button>
            </div>
        </div>
        <nav>
            <div class="logo">Logo</div>
            <div class="nav-list">
                <ul>
                    <li class="icone-home" id="home"><a href="#"><i class="fa-solid fa-house-chimney"></i></a></li>
                    <li><a href="#">'O colégio'</a></li>
                    <li><a href="#" class="quem-somos">'Quem somos'</a></li>
                    <li class="has-submenu">
                        <a href="#">'Galeria'<span class="menu-arrow">▼</span></a>
                        <div class="sub-menu">
                            <ul>
                                <li><a href="#">Feira Literária</a></li>
                                <li><a href="#">Culturalmente</a></li>
                                <li><a href="#">Aprovados ENEM 2025</a></li>
                            </ul>
                        </div>
                    </li>
                    <li><a href="#">'Agenda'</a></li>
                    <li class="has-submenu">
                        <a href="#">'Contato'<span class="menu-arrow">▼</span></a>
                        <div class="sub-menu">
                            <ul>
                                <li><a href="#">Fale conosco</a></li>
                                <li><a href="#">Faça parte da equipe</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="texto-matricula"><a href="#">Matrículas</a></li>
                </ul>
            </div>
            <div class="mobile-menu">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <form action="atualiza_senha.php" method="POST">
                <h1>Redefinir Senha</h1>

                <div class="input-box">
                    <input type="password" name="nova_senha" placeholder="Nova senha" required>
                    <i class="fa-solid fa-lock"></i>
                </div>

                <button type="submit" class="cadastro-page">Atualizar Senha</button>

                <p>Lembrou sua senha? <a href="login.html">Fazer login</a></p>
            </form>
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>
