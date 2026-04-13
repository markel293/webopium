<?php
$servidor = "localhost"; 
$usuari = "root"; 
$contrasenya = ""; 
$basedades = "bdopium";

// Crear connexió
$conn = mysqli_connect($servidor, $usuari, $contrasenya, $basedades);

// Verificar connexió
if (!$conn) {
    die("Error de conexió: " . mysqli_connect_error());
}
?>
