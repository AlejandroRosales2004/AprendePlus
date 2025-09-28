<?php
// Verificar sesión de administrador
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /AprendePlus/frontend/login.html');
    exit();
}
require_once __DIR__ . '/../../backend/db/db.php';
require_once __DIR__ . '/../includes/bubble_background.php';

// Obtener instructores para el select
$instructores = [];
try {
    $stmt = $conn->query("SELECT id, username, nombre_completo FROM usuarios WHERE role = 'instructor'");
    $instructores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $instructores = [];
}

$message = '';
$error = '';

// Generar token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Token de seguridad inválido. Recarga la página.';
    } else {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $estado = trim($_POST['estado'] ?? 'borrador');
        $instructor_id = intval($_POST['instructor_id'] ?? 0);
        $nivel = trim($_POST['nivel'] ?? '');
        $duracion = trim($_POST['duracion'] ?? '');
        $requisitos = trim($_POST['requisitos'] ?? '');
        $imagen_portada = null;

        // Validar campos obligatorios
        if (!$title || !$description || !$content || !$categoria || !$instructor_id || !$nivel || !$duracion) {
            $error = 'Por favor, completa todos los campos obligatorios.';
        } else {
            // Manejar subida de imagen
            if (isset($_FILES['imagen_portada']) && $_FILES['imagen_portada']['error'] === UPLOAD_ERR_OK) {
                $imgTmp = $_FILES['imagen_portada']['tmp_name'];
                $imgName = basename($_FILES['imagen_portada']['name']);
                $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $maxSize = 2 * 1024 * 1024; // 2MB
                if (!in_array($imgExt, $allowed)) {
                    $error = 'Formato de imagen no permitido.';
                } elseif ($_FILES['imagen_portada']['size'] > $maxSize) {
                    $error = 'La imagen no debe superar los 2MB.';
                } else {
                    $newName = uniqid('curso_', true) . '.' . $imgExt;
                    $dest = __DIR__ . '/../../uploads/' . $newName;
                    if (move_uploaded_file($imgTmp, $dest)) {
                        $imagen_portada = 'uploads/' . $newName;
                    } else {
                        $error = 'Error al subir la imagen.';
                    }
                }
            }
            if (!$error) {
                try {
                    $stmt = $conn->prepare("INSERT INTO cursos (titulo, descripcion, instructor_id, imagen_portada, categoria, estado, nivel, duracion, requisitos) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$title, $description, $instructor_id, $imagen_portada, $categoria, $estado, $nivel, $duracion, $requisitos]);
                    $message = 'Curso creado exitosamente.';
                } catch (Exception $e) {
                    $error = 'Error al guardar el curso: ' . htmlspecialchars($e->getMessage());
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso | Aprende+</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/AprendePlus/assets/css/bubble-background.css">
    <style>
        :root {
            --verde-suave: #a8e6cf;
            --azul-claro: #dcedc1;
            --azul-oscuro: #64b5f6;
            --blanco: #ffffff;
            --sombra: 0 10px 20px rgba(0,0,0,0.1);
            --glass: rgba(255,255,255,0.82);
        }
        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: transparent;
            min-height: 100vh;
            color: #333;
            height: 100%;
        }
        body {
            min-height: 100vh;
            width: 100vw;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .admin-panel {
            min-height: 100vh;
            width: 100vw;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
        }
        .glass-bubble-admin {
            background: var(--glass);
            border-radius: 32px;
            box-shadow: 0 8px 40px 0 rgba(44,62,80,0.13);
            padding: 2.5rem 2.5rem 2.2rem 2.5rem;
            max-width: 480px;
            margin: 2.5rem auto;
            position: relative;
            z-index: 2;
            min-width: 320px;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .glass-bubble-admin h2 {
            text-align: center;
            color: var(--azul-oscuro);
            margin-bottom: 1.5rem;
            font-size: 2rem;
            font-weight: 600;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--azul-oscuro);
            font-weight: 500;
        }
        input[type="text"], textarea, select {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #b0bec5;
            border-radius: 8px;
            font-size: 1rem;
            background: #f7fafc;
            margin-bottom: 1.2rem;
            transition: border 0.2s;
        }
        input[type="file"] {
            margin-bottom: 1.2rem;
        }
        input[type="text"]:focus, textarea:focus, select:focus {
            border: 1.5px solid var(--azul-oscuro);
            outline: none;
            background: #fff;
        }
        button {
            width: 100%;
            padding: 0.9rem 0;
            background: linear-gradient(90deg, var(--verde-suave), var(--azul-oscuro));
            color: #333;
            border: none;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(100, 181, 246, 0.2);
        }
        .message {
            margin-bottom: 1.2rem;
            color: #388e3c;
            background: #e8f5e9;
            border-left: 4px solid #388e3c;
            padding: 10px 14px;
            border-radius: 4px;
            font-size: 1rem;
        }
        .error {
            margin-bottom: 1.2rem;
            color: #c62828;
            background: #ffebee;
            border-left: 4px solid #c62828;
            padding: 10px 14px;
            border-radius: 4px;
            font-size: 1rem;
        }
        @media (max-width: 900px) {
            .glass-bubble-admin {
                max-width: 98vw;
                min-width: unset;
                padding: 1.2rem 0.7rem 1.2rem 0.7rem;
                margin: 1.2rem auto;
            }
        }
        @media (max-width: 600px) {
            html, body {
                font-size: 15px;
            }
            .admin-panel {
                min-height: 100vh;
                width: 100vw;
                padding: 0;
                margin: 0;
                align-items: stretch;
                justify-content: flex-start;
            }
            .glass-bubble-admin {
                padding: 1.2rem 0.5rem 1.2rem 0.5rem;
                margin: 0.5rem auto;
                max-width: 100vw;
                border-radius: 0;
                box-shadow: none;
                min-width: unset;
            }
            .glass-bubble-admin h2 {
                font-size: 1.1rem;
            }
            label {
                font-size: 1rem;
            }
            input[type="text"], textarea, select {
                font-size: 1.05rem;
                padding: 0.7rem 0.7rem;
            }
            button {
                font-size: 1.08rem;
                padding: 1.1rem 0;
            }
        }
        @media (max-width: 400px) {
            .glass-bubble-admin {
                padding: 0.5rem 0.1rem 0.5rem 0.1rem;
            }
            input[type="text"], textarea, select {
                font-size: 0.98rem;
                padding: 0.6rem 0.4rem;
            }
            button {
                font-size: 1rem;
                padding: 0.9rem 0;
            }
        }
        /* Mejoras generales de accesibilidad y visualización */
        .glass-bubble-admin {
            overflow-y: auto;
            max-height: 95vh;
        }
        label, input, textarea, select, button {
            font-family: inherit;
        }
        input[type="file"] {
            font-size: 1rem;
        }
        .message, .error {
            font-size: 1.08rem;
            border-radius: 6px;
            margin-bottom: 1.3rem;
            word-break: break-word;
        }
        .message {
            color: #207c3a;
            background: #e0f7e9;
            border-left: 5px solid #207c3a;
        }
        .error {
            color: #b71c1c;
            background: #ffeaea;
            border-left: 5px solid #b71c1c;
        }
        /* Evitar solapamiento de labels y campos */
        label {
            margin-bottom: 0.3rem;
            font-size: 1.08rem;
        }
        input, textarea, select {
            margin-bottom: 1.1rem;
        }
        /* Scroll para formularios largos en móvil */
        @media (max-width: 600px) {
            .glass-bubble-admin {
                max-height: 98vh;
                overflow-y: auto;
            }
        }
    </style>
    <script src="/AprendePlus/dashboard/admin/assets/js/admin_session.js"></script>
</head>
<body>
<?php renderBubbleBackground(); ?>
<div class="admin-panel">
    <nav style="width:100%;text-align:right;margin-bottom:1rem;position:relative;z-index:2;">
        <a href="/AprendePlus/backend/auth/logout.php" id="logoutBtn" style="display:none;color:#e74a3b;font-weight:600;text-decoration:none;margin-right:1.5rem;">Cerrar Sesión</a>
    </nav>
    <form class="glass-bubble-admin" method="post" enctype="multipart/form-data">
        <h2><i class="fas fa-plus-circle"></i> Crear Nuevo Curso</h2>
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        <label for="title">Título del Curso: *</label>
        <input type="text" id="title" name="title" placeholder="Ejemplo: Programación en PHP" required>

        <label for="description">Descripción: *</label>
        <textarea id="description" name="description" rows="4" placeholder="Describe brevemente el curso..." required></textarea>

        <label for="content">Contenido/Temario: *</label>
        <textarea id="content" name="content" rows="8" placeholder="Agrega aquí el temario, lecciones o materiales del curso..." required></textarea>

        <label for="categoria">Categoría: *</label>
        <input type="text" id="categoria" name="categoria" placeholder="Ejemplo: Programación, Diseño, Idiomas" required>

        <label for="nivel">Nivel: *</label>
        <select id="nivel" name="nivel" required>
            <option value="">Selecciona el nivel</option>
            <option value="Básico">Básico</option>
            <option value="Intermedio">Intermedio</option>
            <option value="Avanzado">Avanzado</option>
        </select>

        <label for="duracion">Duración estimada (horas): *</label>
        <input type="text" id="duracion" name="duracion" placeholder="Ejemplo: 10, 20, 40" required>

        <label for="requisitos">Requisitos previos:</label>
        <textarea id="requisitos" name="requisitos" rows="2" placeholder="Ejemplo: Conocimientos básicos de computación"></textarea>

        <label for="estado">Estado: *</label>
        <select id="estado" name="estado" required>
            <option value="borrador">Borrador</option>
            <option value="publicado">Publicado</option>
            <option value="archivado">Archivado</option>
        </select>

        <label for="instructor_id">Instructor: *</label>
        <select id="instructor_id" name="instructor_id" required>
            <option value="">Selecciona un instructor</option>
            <?php foreach ($instructores as $inst): ?>
                <option value="<?= $inst['id'] ?>"><?= htmlspecialchars($inst['nombre_completo'] ?: $inst['username']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="imagen_portada">Imagen de Portada (máx 2MB):</label>
        <input type="file" id="imagen_portada" name="imagen_portada" accept="image/*">

        <button type="submit"><i class="fas fa-save"></i> Crear Curso</button>
    </form>
</div>
</body>
</html>
