<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../utils/logs_config.php';
require_once 'conexion.php';

$data = json_decode(file_get_contents('php://input'), true);
$usuario = $data['usuario'] ?? '';
$contrasena = $data['contrasena'] ?? '';

if(!$usuario || !$contrasena){
    http_response_code(400);
    echo json_encode(["error" => "Faltan datos"]);
    exit;
}

// Buscar usuario
$sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
$stmt = $pdo->prepare($sql);
$stmt->execute(['usuario' => $usuario]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user){
    http_response_code(401);
    echo json_encode(["error" => "Usuario no encontrado"]);
    exit;
}

// Verificar contraseña (hash recomendado)
if(!password_verify($contrasena, $user['contrasena'])){
    http_response_code(401);
    echo json_encode(["error" => "Contraseña incorrecta"]);
    exit;
}

// Obtener roles
$sqlRoles = "SELECT r.nombre FROM roles r 
             INNER JOIN usuario_roles ur ON r.id = ur.rol_id
             WHERE ur.usuario_id = :id";
$stmtRoles = $pdo->prepare($sqlRoles);
$stmtRoles->execute(['id' => $user['id']]);
$roles = $stmtRoles->fetchAll(PDO::FETCH_COLUMN);

echo json_encode([
    "success" => true,
    "usuario" => [
        "id" => $user['id'],
        "nombres" => $user['nombres'],
        "correo" => $user['correo'],
        "roles" => $roles
    ]
]); 
