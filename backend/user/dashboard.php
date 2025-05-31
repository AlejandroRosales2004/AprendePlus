<?php
require_once '../db/db.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: /AprendePlus/frontend/login.html');
    exit;
}

// Verificar el rol del usuario
if ($_SESSION['role'] !== 'student') {
    header('Location: /AprendePlus/frontend/login.html');
    exit;
}

// Mostrar mensaje de bienvenida si el registro fue exitoso
if (isset($_GET['registration']) && $_GET['registration'] === 'success') {
    echo "<div class='welcome-message'>¡Bienvenido {$_SESSION['username']}! Tu registro fue exitoso.</div>";
}

// Agregar un mensaje de prueba para verificar la redirección
if (isset($_SESSION['user_id'])) {
    echo "<p>Sesión activa para el usuario: {$_SESSION['username']} con rol: {$_SESSION['role']}</p>";
} else {
    echo "<p>No hay sesión activa.</p>";
}

// Cambiar consultas que usaban usuario_cursos por:
$stmt = $pdo->prepare("\n    SELECT c.*, i.porcentaje_completado as progress, i.ultima_actualizacion \n    FROM inscripciones i\n    JOIN cursos c ON i.curso_id = c.id\n    WHERE i.usuario_id = ?\n");
?>