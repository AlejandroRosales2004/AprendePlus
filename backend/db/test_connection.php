<?php
// Archivo para probar la conexión a la base de datos
require_once __DIR__ . '/db.php';

try {
    $stmt = $conn->query("SELECT 1");
    echo "Conexión a la base de datos exitosa.";
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>