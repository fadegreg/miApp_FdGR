
<?php

$host = getenv('DB_HOST') ?: 'db';
$port = getenv('DB_PORT') ?: '5432';
$database = getenv('DB_NAME') ?: 'miapp';
$username = getenv('DB_USER') ?: 'miapp_user';
$password = getenv('DB_PASSWORD') ?: 'cambia_esta_password';

$dsn = "pgsql:host=$host;port=$port;dbname=$database";

try {
    $conn = new PDO(
        $dsn,
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

} catch (PDOException $e) {
    error_log($e->getMessage());
    die('Error al conectar con la base de datos.');
}
?>