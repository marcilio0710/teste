<?php
// Certifique-se de pegar as variáveis corretamente:
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASS');

// ATENÇÃO para ponto e vírgula antes de sslmode
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
//                                ^ aqui está o ponto e vírgula!

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão bem-sucedida!";
} catch (PDOException $e) {
    echo "Erro na conexão com o banco: " . $e->getMessage();
    exit();
}

?>
