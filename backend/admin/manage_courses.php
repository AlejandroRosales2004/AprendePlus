<?php
// Simulación de cursos para la tabla
$courses = [
    ["id" => 1, "titulo" => "Programación en PHP", "estado" => "Activo"],
    ["id" => 2, "titulo" => "Introducción a Python", "estado" => "Inactivo"],
    ["id" => 3, "titulo" => "Diseño Web", "estado" => "Activo"],
    ["id" => 4, "titulo" => "JavaScript Moderno", "estado" => "Activo"],
];
// Simulación: títulos de lecciones por curso
$lecciones_por_curso = [
    1 => ["Introducción a PHP", "Variables y Tipos de Datos", "Estructuras de Control", "Funciones"],
    2 => ["Presentación", "Primeros pasos"],
    3 => ["HTML", "CSS", "JS", "Diseño responsivo", "Proyecto final"],
    4 => ["Sintaxis", "Funciones flecha", "Fetch API"]
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Cursos | Admin</title>
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
            <a href="/AprendePlus/backend/admin/manage_courses.php" class="active">Cursos</a>
            <a href="#" style="pointer-events:none;opacity:0.5;">Usuarios</a>
            <a href="#" style="pointer-events:none;opacity:0.5;">Ajustes</a>
            <span style="flex:1"></span>
            <a href="/AprendePlus/backend/auth/logout.php" class="btn" style="background:#e57373;font-weight:600;"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
        </nav>
    </div>
    <div class="container">
        <h1><i class="fas fa-cogs"></i> Gestionar Cursos</h1>
        <a href="/AprendePlus/backend/admin/create_course.php" class="add-btn"><i class="fas fa-plus-circle"></i> Nuevo Curso</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Estado</th>
                    <th>Lecciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $curso):
                    $lecciones = $lecciones_por_curso[$curso['id']] ?? [];
                    $num_lecciones = count($lecciones);
                    $tooltip = $num_lecciones ? htmlspecialchars(implode("\n", $lecciones)) : "Sin lecciones";
                ?>
                <tr>
                    <td><?= $curso['id'] ?></td>
                    <td><?= htmlspecialchars($curso['titulo']) ?></td>
                    <td><?= htmlspecialchars($curso['estado']) ?></td>
                    <td class="lecciones-tooltip" title="<?= $tooltip ?>">
                        <?= $num_lecciones ?>
                    </td>
                    <td class="actions">
                        <a href="/AprendePlus/backend/admin/edit_course.php?id=<?= $curso['id'] ?>" class="edit" title="Editar"><i class="fas fa-edit"></i></a>
                        <a href="/AprendePlus/backend/admin/delete_course.php?id=<?= $curso['id'] ?>" class="delete" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
                        <a href="/AprendePlus/backend/admin/course_detail.php?id=<?= $curso['id'] ?>" class="view" title="Ver contenido"><i class="fas fa-eye"></i></a>
                        <a href="/AprendePlus/backend/admin/manage_lessons.php?id=<?= $curso['id'] ?>" class="edit" title="Gestionar lecciones"><i class="fas fa-list"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <footer>
        &copy; 2023 Aprende+. Todos los derechos reservados.
    </footer>
</body>
</html>
