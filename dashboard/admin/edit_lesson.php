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
// Obtener lección
$stmt = $conn->prepare('SELECT * FROM lecciones WHERE id = ? AND curso_id = ?');
$stmt->execute([$id, $curso_id]);
$leccion = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$leccion) {
    echo '<h2>Lección no encontrada.</h2>';
    exit;
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $contenido = trim($_POST['contenido'] ?? '');
    $orden = intval($_POST['orden'] ?? 1);
    if ($titulo && $contenido) {
        $stmt = $conn->prepare('UPDATE lecciones SET titulo = ?, contenido = ?, orden = ? WHERE id = ? AND curso_id = ?');
        $stmt->execute([$titulo, $contenido, $orden, $id, $curso_id]);
        $message = 'Lección actualizada correctamente.';
        // Refrescar datos
        $stmt = $conn->prepare('SELECT * FROM lecciones WHERE id = ? AND curso_id = ?');
        $stmt->execute([$id, $curso_id]);
        $leccion = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $message = 'Completa todos los campos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Lección</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f7fafc; margin:0; padding:0; }
        .container { max-width: 700px; margin: 2rem auto; background: #fff; border-radius: 12px; box-shadow: 0 4px 18px #b0bec5; padding: 2rem; }
        h2 { color: #1976d2; }
        form { margin-bottom: 2rem; }
        label { display:block; margin-bottom:0.3rem; color:#1976d2; font-weight:500; }
        input[type=text], textarea, input[type=number] { width:100%; padding:0.7rem; border-radius:7px; border:1px solid #b0bec5; margin-bottom:1rem; }
        button { background:#1976d2; color:#fff; border:none; border-radius:7px; padding:0.7rem 1.5rem; font-weight:600; cursor:pointer; }
        .msg { margin-bottom:1rem; color:#388e3c; }
        @media (max-width: 700px) {
            .container { max-width: 98vw; padding: 1rem 0.3rem; }
            h2 { font-size: 1.2rem; }
        }
        @media (max-width: 480px) {
            .container { padding: 0.5rem 0.1rem; }
            button { width: 100%; padding: 0.7rem 0; }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Editar Lección</h2>
    <?php if ($message): ?><div class="msg"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <form method="post">
        <label for="titulo">Título de la lección:</label>
        <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($leccion['titulo']) ?>" required>
        <label for="contenido">Contenido:</label>
        <textarea id="contenido" name="contenido" rows="4" required><?= htmlspecialchars($leccion['contenido']) ?></textarea>
        <label for="orden">Orden:</label>
        <input type="number" id="orden" name="orden" min="1" value="<?= $leccion['orden'] ?>" required>
        <button type="submit"><i class="fas fa-save"></i> Guardar Cambios</button>
    </form>
    <a href="/AprendePlus/dashboard/admin/manage_lessons.php?curso_id=<?= $curso_id ?>" style="color:#1976d2;text-decoration:none;font-weight:600;">&larr; Volver a lecciones</a>
</div>
</body>
</html>
