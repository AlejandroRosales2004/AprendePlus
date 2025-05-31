<?php
// Verificar sesión de administrador
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../frontend/login.html');
    exit();
}

// Ejemplo de listado de cursos para el administrador
$courses = [
    ["id" => 1, "titulo" => "Programación en PHP", "estado" => "Activo"],
    ["id" => 2, "titulo" => "Introducción a Python", "estado" => "Inactivo"],
    ["id" => 3, "titulo" => "Diseño Web", "estado" => "Activo"],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Cursos | Admin</title>
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
            margin: 0;
        }
        .courses-table-container {
            max-width: 900px;
            margin: 3rem auto;
            background: var(--blanco);
            border-radius: 15px;
            box-shadow: var(--sombra);
            padding: 2.5rem 2rem;
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
    <script src="../assets/js/admin_session.js"></script>
</head>
<body>
    <nav style="width:100%;text-align:right;margin-bottom:1rem;">
        <a href="../../backend/auth/logout.php" id="logoutBtn" style="display:none;color:#e74a3b;font-weight:600;text-decoration:none;margin-right:1.5rem;">Cerrar Sesión</a>
    </nav>
    <div class="courses-table-container">
        <h1><i class="fas fa-book"></i> Todos los Cursos</h1>
        <a href="create_course.php" class="add-btn"><i class="fas fa-plus-circle"></i> Nuevo Curso</a>
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
                <?php foreach ($courses as $curso): ?>
                <tr>
                    <td><?= $curso['id'] ?></td>
                    <td><?= htmlspecialchars($curso['titulo']) ?></td>
                    <td><?= htmlspecialchars($curso['estado']) ?></td>
                    <td class="actions">
                        <a href="edit_course.php?id=<?= $curso['id'] ?>" title="Editar"><i class="fas fa-edit"></i></a>
                        <a href="delete_course.php?id=<?= $curso['id'] ?>" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
