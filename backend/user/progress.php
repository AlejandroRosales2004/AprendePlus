<?php
// Devuelve el progreso real de los cursos del usuario autenticado en formato JSON
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'No autenticado']);
    exit;
}

require_once __DIR__ . '/../db/db.php';
$user_id = $_SESSION['user_id'];

// Mejor manejo de errores de conexión/preparación
if (!($conn instanceof mysqli)) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Error de conexión a la base de datos']);
    exit;
}

$stmt = $conn->prepare("SELECT c.id, c.titulo, IFNULL(p.porcentaje_completado,0) as progreso, IFNULL(p.ultima_actualizacion, NOW()) as ultima_actualizacion FROM inscripciones i JOIN cursos c ON i.curso_id = c.id LEFT JOIN progreso p ON p.usuario_id = i.usuario_id AND p.curso_id = i.curso_id WHERE i.usuario_id = ?");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Error en la consulta: ' . $conn->error]);
    exit;
}
$stmt->bind_param('i', $user_id);
if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Error al ejecutar la consulta']);
    $stmt->close();
    exit;
}
$result = $stmt->get_result();
$cursos = [];
while ($row = $result->fetch_assoc()) {
    $progreso = round((float)$row['progreso'], 2);
    $cursos[] = [
        'id' => (int)$row['id'],
        'titulo' => $row['titulo'],
        'progreso' => $progreso,
        'ultima_actualizacion' => $row['ultima_actualizacion'],
        'completado' => $progreso >= 100
    ];
}
$stmt->close();

// Respuesta
http_response_code(200);
echo json_encode(['ok' => true, 'cursos' => $cursos]);
