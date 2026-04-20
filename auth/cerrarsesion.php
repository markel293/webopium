<?php
/**
 * MEJORA DE SEGURIDAD: CIERRE DE SESIÓN INTEGRAL
 * No solo vaciamos los datos en el servidor, sino que eliminamos el rastro en el cliente.
 */

session_start();

// 1. Elimina todas las variables de sesión del array $_SESSION
$_SESSION = array();

// 2. IMPORTANTE: Si se desea destruir la sesión completamente, también hay que borrar
// la cookie de sesión en el navegador. Si no, el ID de sesión podría ser reutilizado.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000, // Ponemos una fecha de expiración en el pasado para que el navegador la borre
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// 3. Destruye la información de la sesión en el servidor
session_destroy();

/**
 * CAPA EXTRA: Redirección limpia.
 * Usamos un parámetro opcional para que la página de destino sepa que se ha cerrado sesión correctamente.
 */
header("Location: ../OpiumMainPage/OpiumMainPage.php?logout=1");

// 4. Finaliza el script de forma segura
exit;
?>