<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica se está logado e é admin
if (!isset($_SESSION['email'])) {
    die("Usuário não logado.");
}
if ($_SESSION['is_admin'] != 1) {
    die("Acesso negado. Apenas administradores.");
}

include('db.php'); // Incluindo o arquivo de conexão

$query = "SELECT * FROM agendamentos";
$stmt = $pdo->prepare($query);
$stmt->execute();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Agendamentos</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="agendamento.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    <a href="#"><span class="texto-login"><i class="fa-solid fa-circle-user"></i> Fazer Login</span></a>
                </button>
            </div>
        </div>
        <nav>
            <div class="logo">
                <a href="index.html"><h1>Logo</h1></a>
            </div>
            <div class="nav-list">
                <ul>
                    <li class="icone-home" id="home"><a href="#"><i class="fa-solid fa-house-chimney"></i></a></li>
                    <li><a href="#">O colégio</a></li>
                    <li><a href="#" class="quem-somos">Quem somos</a></li>
                    <li class="has-submenu"><a href="#">Galeria <span class="menu-arrow">▼</span></a>
                        <div class="sub-menu">
                            <ul>
                                <li><a href="#">Feira Literária</a></li>
                                <li><a href="#">Culturalmente</a></li>
                                <li><a href="#">Aprovados ENEM 2025</a></li>
                            </ul>
                        </div>
                    </li>
                    <li><a href="#">Agenda</a></li>
                    <li class="has-submenu"><a href="#">Contato <span class="menu-arrow">▼</span></a>
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
        <div class="agendamento-container container">
            <h1>Painel de Agendamentos</h1>
            <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?> (admin)!</p>
            <table>
                <tr>
                    <?php
                    $colunas = array_keys($stmt->fetch(PDO::FETCH_ASSOC));
                    foreach ($colunas as $coluna) {
                        echo "<th>" . htmlspecialchars($coluna) . "</th>";
                    }
                    ?>
                </tr>
                <?php
                $stmt->execute(); // Necessário para reiniciar a consulta
                while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    foreach ($linha as $valor) {
                        echo "<td>" . htmlspecialchars($valor) . "</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </table>
            <a class="logout" href="logout.php">Sair</a>
        </div>
    </main>
    <script src="script.js"></script>
</body>
</html>
