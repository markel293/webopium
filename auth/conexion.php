<?php
$servidor = "localhost"; 
$usuari = "root"; 
$contrasenya = ""; 
$basedades = "bdopium";

// Intentar la conexión
$conn = mysqli_connect($servidor, $usuari, $contrasenya, $basedades);

// MEJORA CIBER: Comprobar error sin mostrar detalles sensibles
if (!$conn) {
    // Log interno del error real
    error_log("Fallo crítico de conexión: " . mysqli_connect_error());
    // Mensaje genérico al usuario
    die("Lo sentimos, hay un problema técnico. Inténtalo más tarde.");
}

// MEJORA CIBER: Forzar el charset para evitar ataques de codificación (UTF-8)
mysqli_set_charset($conn, "utf8mb4");
?>
