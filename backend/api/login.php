<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../utils/log_config.php';
require_once 'conexion.php';

// 📌 Leer el JSON recibido desde la app
$rawData = file_get_contents('php://input');

// ✅ Log para ver exactamente qué llega del móvil
error_log("📥 Datos crudos recibidos: " . $rawData);

// Convertir a array
$data = json_decode($rawData, true);
$usuario = $data['usuario'] ?? '';
$contrasena = $data['contrasena'] ?? '';

// ✅ Log para confirmar los datos extraídos
error_log("📥 Intento de login => usuario: {$usuario} | contraseña: {$contrasena}");

// Validar que llegaron datos
if (!$usuario || !$contrasena) {
    http_response_code(400);
    echo json_encode(["error" => "Faltan datos"]);
    exit;
}

// Buscar usuario
$sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
$stmt = $pdo->prepare($sql);
$stmt->execute(['usuario' => $usuario]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// ✅ Log para ver si encontró el usuario
if ($user) {
    error_log("✅ Usuario encontrado en la BD: {$user['usuario']}");
} else {
    error_log("❌ Usuario no encontrado: {$usuario}");
    http_response_code(401);
    echo json_encode(["error" => "Usuario no encontrado"]);
    exit;
}

// Verificar contraseña
if (!password_verify($contrasena, $user['contrasena'])) {
    error_log("❌ Contraseña incorrecta para usuario: {$usuario}");
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

// ✅ Log roles obtenidos
error_log("✅ Roles asignados: " . json_encode($roles));

// Respuesta final
echo json_encode([
    "success" => true,
    "usuario" => [
        "id" => $user['id'],
        "nombres" => $user['nombres'],
        "correo" => $user['correo'],
        "roles" => $roles
    ]
]);
