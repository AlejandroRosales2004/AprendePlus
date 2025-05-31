<?php
// Verificar sesión de administrador
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../frontend/login.html');
    exit();
}

// Configuración general de la plataforma (simulado)
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $platform_name = trim($_POST['platform_name'] ?? '');
    $contact_email = trim($_POST['contact_email'] ?? '');
    // Aquí iría la lógica para guardar la configuración
    $message = 'Configuración guardada correctamente (simulado).';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración | Admin</title>
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
        .settings-form {
            background-color: var(--blanco);
            padding: 2.5rem 2rem 2rem 2rem;
            border-radius: 15px;
            box-shadow: var(--sombra);
            max-width: 400px;
            width: 100%;
            margin: 2rem auto;
        }
        .settings-form h2 {
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
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #b0bec5;
            border-radius: 8px;
            font-size: 1rem;
            background: #f7fafc;
            margin-bottom: 1.2rem;
            transition: border 0.2s;
        }
        input[type="text"]:focus, input[type="email"]:focus {
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
            .settings-form {
                padding: 1.2rem 0.5rem 1rem 0.5rem;
            }
            .settings-form h2 {
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
    <form class="settings-form" method="post">
        <h2><i class="fas fa-cog"></i> Configuración General</h2>
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <label for="platform_name">Nombre de la Plataforma:</label>
        <input type="text" id="platform_name" name="platform_name" placeholder="Aprende+" required>

        <label for="contact_email">Email de Contacto:</label>
        <input type="email" id="contact_email" name="contact_email" placeholder="contacto@aprendeplus.com" required>

        <button type="submit"><i class="fas fa-save"></i> Guardar Cambios</button>
    </form>
</body>
</html>
