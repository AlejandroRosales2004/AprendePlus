<?php
session_start();

// 1. Destruir todas las variables de sesión
$_SESSION = array();

// 2. Borrar la cookie de sesión (opcional pero recomendado)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Destruir la sesión completamente
session_destroy();

// 4. Redirigir al login con mensaje de éxito
header('Location: /AprendePlus/frontend/login.html?logout=success');
exit;
?>