<?php
// Verificar sesión de administrador
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /AprendePlus/frontend/login.html');
    exit();
}

// Simulación de eliminación de curso por ID
$id = $_GET['id'] ?? 1;
$deleted = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí iría la lógica real de eliminación en la base de datos
    $deleted = true;
}

require_once __DIR__ . '/../includes/bubble_background.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Curso | Aprende+</title>
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
            color: #e74a3b;
            margin-bottom: 1.5rem;
            font-size: 2rem;
            font-weight: 600;
        }
        .glass-bubble-admin p {
            margin-bottom: 1.5rem;
        }
        button, .btn-cancel {
            padding: 0.8rem 1.5rem;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            margin: 0 0.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        button {
            background: #e74a3b;
            color: #fff;
        }
        button:hover {
            background: #c0392b;
        }
        .btn-cancel {
            background: #b0bec5;
            color: #333;
            text-decoration: none;
        }
        .btn-cancel:hover {
            background: #78909c;
            color: #fff;
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
    <div class="glass-bubble-admin">
        <?php if ($deleted): ?>
            <h2><i class="fas fa-check-circle"></i> Curso Eliminado</h2>
            <div class="message">El curso con ID <?= htmlspecialchars($id) ?> ha sido eliminado (simulado).</div>
            <a href="/AprendePlus/dashboard/admin/all_courses.php" class="btn-cancel">Volver a Cursos</a>
        <?php else: ?>
            <h2><i class="fas fa-trash-alt"></i> Eliminar Curso</h2>
            <p>¿Estás seguro de que deseas eliminar el curso con ID <strong><?= htmlspecialchars($id) ?></strong>? Esta acción no se puede deshacer.</p>
            <form method="post" style="display:inline;">
                <button type="submit"><i class="fas fa-trash"></i> Eliminar</button>
            </form>
            <a href="/AprendePlus/dashboard/admin/all_courses.php" class="btn-cancel">Cancelar</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
