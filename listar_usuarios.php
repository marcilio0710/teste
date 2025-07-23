<?php
require_once 'db.php'; // inclui conexão PDO
try {
    $sql = "SELECT email FROM usuarios";
    $stmt = $pdo->query($sql);
    echo "<h2>Usuários cadastrados:</h2>";
    echo "<ul>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>Email: " . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . "</li>";
    }
    echo "</ul>";
} catch (PDOException $e) {
    error_log("Erro na consulta de usuários: " . $e->getMessage());
    echo "Erro ao acessar os dados. Tente novamente mais tarde.";
}
?>
