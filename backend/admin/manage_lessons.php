<?php
// Simulación de obtención de lecciones para un curso
$course_id = $_GET['id'] ?? 1;
$course_title = 'Programación en PHP';
$lessons = [
    ["id" => 1, "titulo" => "Introducción a PHP"],
    ["id" => 2, "titulo" => "Variables y Tipos de Datos"],
    ["id" => 3, "titulo" => "Estructuras de Control"],
    ["id" => 4, "titulo" => "Funciones"],
];
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_title = trim($_POST['lesson_title'] ?? '');
    if ($new_title) {
        $message = 'Lección agregada (simulación, falta integración con la base de datos).';
        $lessons[] = ["id" => count($lessons) + 1, "titulo" => $new_title];
    } else {
        $message = 'Por favor, ingresa el título de la lección.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Lecciones | Admin</title>
    <link rel="stylesheet" href="/AprendePlus/backend/admin/dashboard-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="bg-particles">
      <span></span><span></span><span></span><span></span><span></span>
    </div>
    <div class="navbar">
        <div class="logo">
            <i class="fas fa-graduation-cap"></i> Aprende+ Admin
        </div>
        <nav style="flex:1;display:flex;align-items:center;gap:1.5rem;">
            <a href="/AprendePlus/backend/admin/manage_courses.php">Cursos</a>
            <a href="#" style="pointer-events:none;opacity:0.5;">Usuarios</a>
            <a href="#" style="pointer-events:none;opacity:0.5;">Ajustes</a>
            <span style="flex:1"></span>
            <a href="/AprendePlus/backend/auth/logout.php" class="btn" style="background:#e57373;font-weight:600;"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
        </nav>
    </div>
    <div class="container">
        <h1><i class="fas fa-list"></i> Lecciones de "<?= htmlspecialchars($course_title) ?>"</h1>
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form method="post" class="add-lesson">
            <input type="text" name="lesson_title" placeholder="Nueva lección..." required>
            <button type="submit"><i class="fas fa-plus"></i> Agregar</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Título de la Lección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lessons as $lesson): ?>
                <tr>
                    <td><?= $lesson['id'] ?></td>
                    <td><?= htmlspecialchars($lesson['titulo']) ?></td>
                    <td class="actions">
                        <a href="#" class="edit" title="Editar"><i class="fas fa-edit"></i></a>
                        <a href="#" class="delete" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="/AprendePlus/backend/admin/manage_courses.php" class="volver">&larr; Volver a cursos</a>
    </div>
    <footer>
        &copy; 2023 Aprende+. Todos los derechos reservados.
    </footer>
</body>
</html>
