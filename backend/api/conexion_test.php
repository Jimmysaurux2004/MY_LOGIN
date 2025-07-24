<?php
header('Content-Type: application/json');

$host = getenv("MYSQL_HOST");
$port = getenv("MYSQL_PORT") ?: 3306;
$db   = getenv("MYSQL_DATABASE");
$user = getenv("MYSQL_USER");
$pass = getenv("MYSQL_PASSWORD");

$response = [
    "env" => [
        "host" => $host,
        "port" => $port,
        "db" => $db,
        "user" => $user
    ]
];

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ]);
    $response["status"] = "✅ Conexión OK";
} catch (Exception $e) {
    $response["status"] = "❌ Error de conexión";
    $response["error"]  = $e->getMessage();
}

echo json_encode($response);
