<?php
// Simulación de obtención de datos del curso y lecciones
$id = $_GET['id'] ?? 1;
$curso = [
    'id' => $id,
    'titulo' => 'Programación en PHP',
    'descripcion' => 'Aprende a programar en PHP desde cero hasta avanzado.'
];
$lessons = [
    ["id" => 1, "titulo" => "Introducción a PHP"],
    ["id" => 2, "titulo" => "Variables y Tipos de Datos"],
    ["id" => 3, "titulo" => "Estructuras de Control"],
    ["id" => 4, "titulo" => "Funciones"],
];
// Simulación de progreso del estudiante (lecciones completadas)
$lecciones_completadas = [1, 3]; // IDs de lecciones completadas
$progreso = count($lessons) ? round(count($lecciones_completadas) / count($lessons) * 100) : 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($curso['titulo']) ?> | Aprende+</title>
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
        <h1><i class="fas fa-book"></i> <?= htmlspecialchars($curso['titulo']) ?></h1>
        <div class="descripcion">
            <strong>Descripción:</strong> <?= htmlspecialchars($curso['descripcion']) ?>
        </div>
        <div class="progreso">
            <strong>Progreso del Curso:</strong>
            <div class="progress-bar">
                <div class="progress-bar-inner"></div>
            </div>
            <span><?= $progreso ?>% completado</span>
        </div>
        <ul class="lessons-list">
            <?php foreach ($lessons as $lesson): ?>
            <li>
                <input type="checkbox" disabled <?= in_array($lesson['id'], $lecciones_completadas) ? 'checked' : '' ?>>
                <label><?= htmlspecialchars($lesson['titulo']) ?></label>
                <?php if (in_array($lesson['id'], $lecciones_completadas)): ?>
                    <span class="completada"><i class="fas fa-check-circle"></i> Completada</span>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <a href="/AprendePlus/backend/admin/manage_courses.php" class="volver">&larr; Volver a cursos</a>
    </div>
    <footer>
        &copy; 2023 Aprende+. Todos los derechos reservados.
    </footer>
</body>
</html>
