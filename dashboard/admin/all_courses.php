<?php
// Verificar sesión de administrador
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: /AprendePlus/frontend/login.html');
    exit();
}

require_once __DIR__ . '/../../backend/db/db.php';
require_once __DIR__ . '/../includes/bubble_background.php';

// Obtener cursos reales de la base de datos
$courses = [];
try {
    $stmt = $conn->query('SELECT id, titulo, estado FROM cursos ORDER BY id DESC');
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo '<div style="color:red;text-align:center;">Error al obtener cursos: ' . htmlspecialchars($e->getMessage()) . '</div>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Cursos | Admin</title>
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
        .courses-table-container {
            max-width: 900px;
            margin: 3rem auto;
            background: var(--blanco);
            border-radius: 15px;
            box-shadow: var(--sombra);
            padding: 2.5rem 2rem;
            position: relative;
            z-index: 2;
        }
        h1 {
            color: var(--azul-oscuro);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
        }
        th, td {
            padding: 0.9rem 0.5rem;
            text-align: left;
        }
        th {
            background: var(--azul-oscuro);
            color: #fff;
            font-weight: 600;
        }
        tr:nth-child(even) {
            background: #f7fafc;
        }
        tr:hover {
            background: #e3f2fd;
        }
        .actions a {
            margin-right: 10px;
            color: var(--azul-oscuro);
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.2s;
        }
        .actions a:hover {
            color: #388e3c;
        }
        .add-btn {
            display: inline-block;
            background: linear-gradient(90deg, var(--verde-suave), var(--azul-oscuro));
            color: #333;
            padding: 0.6rem 1.3rem;
            border-radius: 20px;
            font-weight: 600;
            text-decoration: none;
            margin-bottom: 1.2rem;
            transition: all 0.3s;
        }
        .add-btn:hover {
            color: #fff;
            background: var(--azul-oscuro);
        }
        @media (max-width: 600px) {
            .courses-table-container {
                padding: 1rem 0.3rem;
            }
            table, th, td {
                font-size: 0.95rem;
            }
        }
    </style>
    <script src="/AprendePlus/dashboard/admin/assets/js/admin_session.js"></script>
</head>
<body>
<?php renderBubbleBackground(); ?>
    <nav style="width:100%;text-align:right;margin-bottom:1rem;">
        <a href="/AprendePlus/backend/auth/logout.php" id="logoutBtn" style="display:none;color:#e74a3b;font-weight:600;text-decoration:none;margin-right:1.5rem;">Cerrar Sesión</a>
    </nav>
    <div class="courses-table-container">
        <h1><i class="fas fa-book"></i> Todos los Cursos</h1>
        <a href="/AprendePlus/dashboard/admin/create_course.php" class="add-btn"><i class="fas fa-plus-circle"></i> Nuevo Curso</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($courses)): ?>
                    <tr><td colspan="4" style="text-align:center;">No hay cursos registrados.</td></tr>
                <?php else: ?>
                <?php foreach ($courses as $curso): ?>
                <tr>
                    <td><?= $curso['id'] ?></td>
                    <td><?= htmlspecialchars($curso['titulo']) ?></td>
                    <td><?= htmlspecialchars($curso['estado']) ?></td>
                    <td class="actions">
                        <a href="/AprendePlus/dashboard/admin/edit_course.php?id=<?= $curso['id'] ?>" title="Editar"><i class="fas fa-edit"></i></a>
                        <a href="/AprendePlus/dashboard/admin/delete_course.php?id=<?= $curso['id'] ?>" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
                        <a href="/AprendePlus/dashboard/admin/manage_lessons.php?curso_id=<?= $curso['id'] ?>" title="Lecciones"><i class="fas fa-list"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
