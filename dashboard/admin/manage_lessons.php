<?php
// Verificar sesión de administrador
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /AprendePlus/frontend/login.html');
    exit();
}
require_once __DIR__ . '/../../backend/db/db.php';

$curso_id = isset($_GET['curso_id']) ? intval($_GET['curso_id']) : 0;
if ($curso_id <= 0) {
    echo '<h2>Curso no especificado.</h2>';
    exit;
}
// Obtener curso
$stmt = $conn->prepare('SELECT titulo FROM cursos WHERE id = ?');
$stmt->execute([$curso_id]);
$curso = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$curso) {
    echo '<h2>Curso no encontrado.</h2>';
    exit;
}
// Procesar formulario de nueva lección
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $contenido = trim($_POST['contenido'] ?? '');
    $orden = intval($_POST['orden'] ?? 1);
    if ($titulo && $contenido) {
        $stmt = $conn->prepare('INSERT INTO lecciones (curso_id, titulo, contenido, orden) VALUES (?, ?, ?, ?)');
        $stmt->execute([$curso_id, $titulo, $contenido, $orden]);
        $message = 'Lección agregada correctamente.';
    } else {
        $message = 'Completa todos los campos.';
    }
}
// Obtener lecciones
$stmt = $conn->prepare('SELECT * FROM lecciones WHERE curso_id = ? ORDER BY orden ASC');
$stmt->execute([$curso_id]);
$lecciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Lecciones | <?= htmlspecialchars($curso['titulo']) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f7fafc; margin:0; padding:0; }
        .container { max-width: 700px; margin: 2rem auto; background: #fff; border-radius: 12px; box-shadow: 0 4px 18px #b0bec5; padding: 2rem; }
        h2 { color: #1976d2; }
        form { margin-bottom: 2rem; }
        label { display:block; margin-bottom:0.3rem; color:#1976d2; font-weight:500; }
        input[type=text], textarea, input[type=number] { width:100%; padding:0.7rem; border-radius:7px; border:1px solid #b0bec5; margin-bottom:1rem; }
        button { background:#1976d2; color:#fff; border:none; border-radius:7px; padding:0.7rem 1.5rem; font-weight:600; cursor:pointer; }
        table { width:100%; border-collapse:collapse; margin-top:1.5rem; }
        th, td { padding:0.7rem; border-bottom:1px solid #e0e0e0; }
        th { background:#e3f2fd; color:#1976d2; }
        tr:last-child td { border-bottom:none; }
        .actions a { color:#1976d2; margin-right:10px; text-decoration:none; }
        .actions a:hover { color:#388e3c; }
        .msg { margin-bottom:1rem; color:#388e3c; }
        @media (max-width: 700px) {
            .container { max-width: 98vw; padding: 1rem 0.3rem; }
            table, th, td { font-size: 0.97rem; }
            h2 { font-size: 1.2rem; }
        }
        @media (max-width: 480px) {
            .container { padding: 0.5rem 0.1rem; }
            th, td { padding: 0.4rem; }
            button { width: 100%; padding: 0.7rem 0; }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Lecciones de: <?= htmlspecialchars($curso['titulo']) ?></h2>
    <?php if ($message): ?><div class="msg"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <form method="post">
        <label for="titulo">Título de la lección:</label>
        <input type="text" id="titulo" name="titulo" required>
        <label for="contenido">Contenido:</label>
        <textarea id="contenido" name="contenido" rows="4" required></textarea>
        <label for="orden">Orden:</label>
        <input type="number" id="orden" name="orden" min="1" value="<?= count($lecciones)+1 ?>" required>
        <button type="submit"><i class="fas fa-plus"></i> Agregar Lección</button>
    </form>
    <table>
        <thead>
            <tr><th>#</th><th>Título</th><th>Acciones</th></tr>
        </thead>
        <tbody>
        <?php foreach ($lecciones as $lec): ?>
            <tr>
                <td><?= $lec['orden'] ?></td>
                <td><?= htmlspecialchars($lec['titulo']) ?></td>
                <td class="actions">
                    <a href="/AprendePlus/dashboard/admin/edit_lesson.php?id=<?= $lec['id'] ?>&curso_id=<?= $curso_id ?>" title="Editar"><i class="fas fa-edit"></i></a>
                    <a href="/AprendePlus/dashboard/admin/delete_lesson.php?id=<?= $lec['id'] ?>&curso_id=<?= $curso_id ?>" title="Eliminar" onclick="return confirm('¿Eliminar esta lección?')"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/AprendePlus/dashboard/admin/all_courses.php" style="display:inline-block;margin-top:1.5rem;color:#1976d2;text-decoration:none;font-weight:600;">&larr; Volver a cursos</a>
</div>
</body>
</html>
