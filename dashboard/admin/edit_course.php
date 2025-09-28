<?php
// Verificar sesión de administrador
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /AprendePlus/frontend/login.html');
    exit();
}

// Simulación de obtención de datos del curso por ID (en producción, consulta a la base de datos)
$id = $_GET['id'] ?? 1;
$curso = [
    'id' => $id,
    'titulo' => 'Programación en PHP',
    'descripcion' => 'Aprende a programar en PHP desde cero hasta avanzado.'
];

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['title'] ?? '');
    $descripcion = trim($_POST['description'] ?? '');
    if ($titulo && $descripcion) {
        // Aquí iría la actualización en la base de datos
        $message = 'Curso actualizado correctamente (simulado).';
        $curso['titulo'] = $titulo;
        $curso['descripcion'] = $descripcion;
    } else {
        $message = 'Por favor, completa todos los campos.';
    }
}

require_once __DIR__ . '/../includes/bubble_background.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Curso | Aprende+</title>
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
            max-width: 430px;
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
        input[type="text"], textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #b0bec5;
            border-radius: 8px;
            font-size: 1rem;
            background: #f7fafc;
            margin-bottom: 1.2rem;
            transition: border 0.2s;
        }
        input[type="text"]:focus, textarea:focus {
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
        @media (max-width: 600px) {
            .glass-bubble-admin {
                padding: 1.2rem 0.7rem 1.2rem 0.7rem;
                margin: 1.2rem auto;
                max-width: 98vw;
            }
            .glass-bubble-admin h2 {
                font-size: 1.3rem;
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
    <form class="glass-bubble-admin" method="post">
        <h2><i class="fas fa-edit"></i> Editar Curso</h2>
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <label for="title">Título del Curso:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($curso['titulo']) ?>" required>

        <label for="description">Descripción:</label>
        <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($curso['descripcion']) ?></textarea>

        <label for="content">Contenido del Curso:</label>
        <textarea id="content" name="content" rows="8" required><?= htmlspecialchars($curso['contenido'] ?? 'Temario, lecciones o materiales aquí...') ?></textarea>

        <button type="submit"><i class="fas fa-save"></i> Guardar Cambios</button>
    </form>
</div>
</body>
</html>
