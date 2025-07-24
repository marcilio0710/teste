<?php
require_once 'conexao.php'; // Conexão PDO
try {
    $sql = "SELECT email FROM usuarios";
    $stmt = $pdo->query($sql);
    echo "<!DOCTYPE html>
    <html>
    <head>
        <meta charset='utf-8'>
        <title>Usuários cadastrados</title>
    </head>
    <body>
        <h2>Usuários cadastrados:</h2>
        <ul>";
    while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>Email: " . htmlspecialchars($linha['email'], ENT_QUOTES, 'UTF-8') . "</li>";
    }
    echo " </ul>
    </body>
    </html>";
} catch (PDOException $e) {
    error_log("Erro na consulta: " . $e->getMessage());
    echo "Erro ao recuperar os dados. Tente novamente mais tarde.";
}
?>
