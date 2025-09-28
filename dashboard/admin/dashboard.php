<?php
// Verificar sesión de administrador
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /AprendePlus/frontend/login.html');
    exit();
}
// Panel principal para el administrador
require_once __DIR__ . '/../includes/bubble_background.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración | Aprende+</title>
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
        }
        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: transparent;
            min-height: 100vh;
            color: #333;
        }
        body {
            min-height: 100vh;
            width: 100vw;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .admin-dashboard {
            max-width: 900px;
            margin: 3rem auto;
            background: var(--blanco);
            border-radius: 15px;
            box-shadow: var(--sombra);
            padding: 2.5rem 2rem;
            position: relative;
            z-index: 2;
        }
        .admin-dashboard h1 {
            color: var(--azul-oscuro);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.2rem;
        }
        .admin-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
        }
        .admin-card {
            background: var(--blanco);
            border-radius: 12px;
            box-shadow: var(--sombra);
            padding: 1.5rem 1rem;
            text-align: center;
            transition: transform 0.2s;
        }
        .admin-card:hover {
            transform: translateY(-7px);
        }
        .admin-card i {
            font-size: 2.2rem;
            color: var(--azul-oscuro);
            margin-bottom: 0.7rem;
        }
        .admin-card h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: #333;
        }
        .admin-card a {
            display: inline-block;
            margin-top: 0.7rem;
            background: linear-gradient(90deg, var(--verde-suave), var(--azul-oscuro));
            color: #333;
            padding: 0.5rem 1.2rem;
            border-radius: 20px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        .admin-card a:hover {
            color: #fff;
            background: var(--azul-oscuro);
        }
        @media (max-width: 600px) {
            .admin-dashboard {
                padding: 1rem 0.3rem;
            }
            .admin-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <!-- Incluir control de sesión admin JS solo para módulos admin -->
    <script src="/AprendePlus/dashboard/admin/assets/js/admin_session.js"></script>
</head>
<body>
<?php renderBubbleBackground(); ?>
    <nav style="width:100%;text-align:right;margin-bottom:1rem;position:relative;z-index:2;">
        <a href="/AprendePlus/backend/auth/logout.php" id="logoutBtn" style="display:none;color:#e74a3b;font-weight:600;text-decoration:none;margin-right:1.5rem;">Cerrar Sesión</a>
    </nav>
    <div class="admin-dashboard">
        <h1><i class="fas fa-tools"></i> Panel de Administración</h1>
        <div class="admin-cards">
            <div class="admin-card">
                <i class="fas fa-book"></i>
                <h3>Todos los Cursos</h3>
                <a href="/AprendePlus/dashboard/admin/all_courses.php">Ver Cursos</a>
            </div>
            <div class="admin-card">
                <i class="fas fa-plus-circle"></i>
                <h3>Crear Curso</h3>
                <a href="/AprendePlus/dashboard/admin/create_course.php">Nuevo Curso</a>
            </div>
            <div class="admin-card">
                <i class="fas fa-users"></i>
                <h3>Usuarios</h3>
                <a href="/AprendePlus/dashboard/admin/users.php">Gestionar Usuarios</a>
            </div>
            <div class="admin-card">
                <i class="fas fa-cog"></i>
                <h3>Configuración</h3>
                <a href="/AprendePlus/dashboard/admin/settings.php">Ajustes</a>
            </div>
        </div>
    </div>
</body>
</html>
