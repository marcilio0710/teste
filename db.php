<?php
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASS');
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // NÃO coloque NADA aqui!!!
} catch (PDOException $e) {
    // A saída de erro abaixo só deve ser usada para debug! O ideal seria tratar melhor em produção.
    die("Erro na conexão com o banco: " . $e->getMessage());
}
