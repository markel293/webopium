<?php
// Inicia la sesión actual 
session_start();

// Elimina todas las variables de sesión
session_unset();

// Destruye la sesión actual
session_destroy();

// Redirige al usuario a la página principal después de cerrar sesión
header("Location: ../OpiumMainPage/OpiumMainPage.php");

// Finaliza el script para asegurarse de que no se ejecute ningún código después de la redirección
exit;
?>
