<?php
$host   = getenv('DB_HOST') ?: 'db';
$dbname = getenv('DB_NAME') ?: 'mi_base';
$user   = getenv('DB_USER') ?: 'usuario';
$pass   = getenv('DB_PASS') ?: 'password';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    die('<p style="color:red;font-family:monospace">Error de conexión a la base de datos: ' . htmlspecialchars($e->getMessage()) . '</p>');
}
