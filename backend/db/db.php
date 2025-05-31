<?php
// backend/db/db.php

$host = getenv('DB_HOST') ?: "localhost";
$user = getenv('DB_USER') ?: "root";       // Usuario de MySQL
$password = getenv('DB_PASSWORD') ?: "";  // Contraseña de MySQL
$database = getenv('DB_NAME') ?: "aprendeplus"; // Nombre de la base de datos

try {
    // Crear conexión usando PDO
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
    // Configurar PDO para lanzar excepciones en caso de error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mensaje opcional para depuración (descomentar para pruebas)
    // echo "Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    // Manejo de errores
    die("Error de conexión: " . $e->getMessage());
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>