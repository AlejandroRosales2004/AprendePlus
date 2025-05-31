<?php
// Verificar sesión de administrador
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../frontend/login.html');
    exit();
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    if ($title && $description) {
        $message = 'Curso creado exitosamente (falta integración con la base de datos).';
    } else {
        $message = 'Por favor, completa todos los campos.';
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
    <style>
        :root {
            --verde-suave: #a8e6cf;
            --azul-claro: #dcedc1;
            --azul-oscuro: #64b5f6;
            --blanco: #ffffff;
            --sombra: 0 10px 20px rgba(0,0,0,0.1);
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: linear-gradient(135deg, var(--verde-suave), var(--azul-claro));
            min-height: 100vh;
            color: #333;
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
        }
        .card-form h2 {
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
        @media (max-width: 500px) {
            .card-form {
                padding: 1.2rem 0.5rem 1rem 0.5rem;
            }
            .card-form h2 {
                font-size: 1.3rem;
            }
        }
    </style>
    <script src="../assets/js/admin_session.js"></script>
</head>
<body>
    <nav style="width:100%;text-align:right;margin-bottom:1rem;">
        <a href="../../backend/auth/logout.php" id="logoutBtn" style="display:none;color:#e74a3b;font-weight:600;text-decoration:none;margin-right:1.5rem;">Cerrar Sesión</a>
    </nav>
    <form class="card-form" method="post">
        <h2><i class="fas fa-plus-circle"></i> Crear Nuevo Curso</h2>
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <label for="title">Título del Curso:</label>
        <input type="text" id="title" name="title" placeholder="Ejemplo: Programación en PHP" required>

        <label for="description">Descripción:</label>
        <textarea id="description" name="description" rows="4" placeholder="Describe brevemente el curso..." required></textarea>

        <label for="content">Contenido del Curso:</label>
        <textarea id="content" name="content" rows="8" placeholder="Agrega aquí el temario, lecciones o materiales del curso..." required></textarea>

        <button type="submit"><i class="fas fa-save"></i> Crear Curso</button>
    </form
