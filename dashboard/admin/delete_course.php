<?php
// Verificar sesión de administrador
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../frontend/login.html');
    exit();
}

// Simulación de eliminación de curso por ID
$id = $_GET['id'] ?? 1;
$deleted = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí iría la lógica real de eliminación en la base de datos
    $deleted = true;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Curso | Aprende+</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --verde-suave: #a8e6cf;
            --azul-claro: #dcedc1;
            --azul-oscuro: #64b5f6;
            --blanco: #ffffff;
            --sombra: 0 10px 20px rgba(0,0,0,0.1);
        }
        body {
            background: linear-gradient(135deg, var(--verde-suave), var(--azul-claro));
            min-height: 100vh;
            color: #333;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-form {
            background-color: var(--blanco);
            padding: 2.5rem 2rem 2rem 2rem;
            border-radius: 15px;
            box-shadow: var(--sombra);
            max-width: 400px;
            width: 100%;
            margin: 2rem auto;
            text-align: center;
        }
        .card-form h2 {
            color: #e74a3b;
            margin-bottom: 1.5rem;
            font-size: 2rem;
            font-weight: 600;
        }
        .card-form p {
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
    </style>
    <script src="../assets/js/admin_session.js"></script>
</head>
<body>
    <nav style="width:100%;text-align:right;margin-bottom:1rem;">
        <a href="../../backend/auth/logout.php" id="logoutBtn" style="display:none;color:#e74a3b;font-weight:600;text-decoration:none;margin-right:1.5rem;">Cerrar Sesión</a>
    </nav>
    <div class="card-form">
        <?php if ($deleted): ?>
            <h2><i class="fas fa-check-circle"></i> Curso Eliminado</h2>
            <div class="message">El curso con ID <?= htmlspecialchars($id) ?> ha sido eliminado (simulado).</div>
            <a href="all_courses.php" class="btn-cancel">Volver a Cursos</a>
        <?php else: ?>
            <h2><i class="fas fa-trash-alt"></i> Eliminar Curso</h2>
            <p>¿Estás seguro de que deseas eliminar el curso con ID <strong><?= htmlspecialchars($id) ?></strong>? Esta acción no se puede deshacer.</p>
            <form method="post" style="display:inline;">
                <button type="submit"><i class="fas fa-trash"></i> Eliminar</button>
            </form>
            <a href="all_courses.php" class="btn-cancel">Cancelar</a>
        <?php endif; ?>
    </div>
</body>
</html>
