<?php
// Script para generar hash seguro de contraseña
if (isset($_GET['password'])) {
    $password = $_GET['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    echo "<b>Contraseña:</b> $password<br>";
    echo "<b>Hash generado:</b> $hash";
} else {
    echo '<form method="get"><input type="text" name="password" placeholder="Contraseña"><button type="submit">Generar hash</button></form>';
}
?>
<?php
// Script para generar hash seguro de contraseña
$password = '12345678'; // Cambia aquí la contraseña que deseas hashear
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash generado para '$password':\n$hash\n";
?>
