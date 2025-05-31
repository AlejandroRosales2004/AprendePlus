<?php
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $lessons = $_POST['lessons'] ?? [];
    $lesson_descs = $_POST['lesson_descs'] ?? [];
    $lecciones = [];
    foreach ($lessons as $i => $titulo_leccion) {
        $titulo_leccion = trim($titulo_leccion);
        $desc_leccion = trim($lesson_descs[$i] ?? '');
        if ($titulo_leccion) {
            $lecciones[] = ["titulo" => $titulo_leccion, "descripcion" => $desc_leccion];
        }
    }
    if ($title && $description && count($lecciones) > 0) {
        $message = 'Curso creado exitosamente con ' . count($lecciones) . ' lecciones (simulación, falta integración con la base de datos).';
    } else {
        $message = 'Por favor, completa todos los campos y agrega al menos una lección.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso | Admin</title>
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
        <h1><i class="fas fa-plus-circle"></i> Crear Nuevo Curso</h1>
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form method="post" id="courseForm">
            <label for="title">Título del Curso:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Descripción:</label>
            <input type="text" id="description" name="description" required>

            <label>Lecciones del Curso:</label>
            <div class="lessons-block" id="lessonsBlock">
                <div class="lesson-row">
                    <input type="text" name="lessons[]" placeholder="Título de la lección" required>
                    <textarea name="lesson_descs[]" placeholder="Descripción de la lección" required></textarea>
                </div>
            </div>
            <button type="button" class="add-lesson-btn" onclick="addLesson()"><i class="fas fa-plus"></i> Agregar lección</button>

            <button type="submit"><i class="fas fa-save"></i> Crear Curso</button>
        </form>
    </div>
    <footer>
        &copy; 2023 Aprende+. Todos los derechos reservados.
    </footer>
    <script>
    function addLesson() {
        const block = document.getElementById('lessonsBlock');
        const row = document.createElement('div');
        row.className = 'lesson-row';
        row.innerHTML = `<input type=\"text\" name=\"lessons[]\" placeholder=\"Título de la lección\" required> <textarea name=\"lesson_descs[]\" placeholder=\"Descripción de la lección\" required></textarea> <button type=\"button\" onclick=\"this.parentNode.remove();\" title=\"Eliminar\"><i class=\"fas fa-times\"></i></button>`;
        block.appendChild(row);
    }
    </script>
</body>
</html>
