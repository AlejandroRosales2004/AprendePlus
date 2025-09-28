<?php
// Verificar sesión de administrador
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /AprendePlus/frontend/login.html');
    exit();
}
require_once __DIR__ . '/../../backend/db/db.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$curso_id = isset($_GET['curso_id']) ? intval($_GET['curso_id']) : 0;
if ($id <= 0 || $curso_id <= 0) {
    echo '<h2>Lección o curso no especificado.</h2>';
    exit;
}
// Eliminar lección
$stmt = $conn->prepare('DELETE FROM lecciones WHERE id = ? AND curso_id = ?');
$stmt->execute([$id, $curso_id]);
header('Location: manage_lessons.php?curso_id=' . $curso_id);
exit;
