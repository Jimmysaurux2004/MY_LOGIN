<?php
require_once __DIR__ . '/../../utils/logs_config.php';
$host = getenv('MYSQL_HOST') ?: '127.0.0.1';
$port = getenv('MYSQL_PORT') ?: '3306';
$dbname = getenv('MYSQL_DATABASE');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_PASSWORD');

// ✅ LOG PARA RAILWAY
error_log("🚀 Intentando conexión MySQL:");
error_log("Host: $host");
error_log("Port: $port");
error_log("DB: $dbname");
error_log("User: $user");

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    error_log("✅ Conexión MySQL OK");
} catch (Exception $e) {
    error_log("❌ Error MySQL: ".$e->getMessage());
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión: ".$e->getMessage()]);
    exit;
}
