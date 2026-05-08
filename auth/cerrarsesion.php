<?php
/**
 * MILLORA DE SEGURETAT: TANCAMENT DE SESSIÓ INTEGRAL
 * No només buidem les dades al servidor, sinó que eliminem qualsevol rastre al client
 * per complir amb els protocols moderns de gestió d'identitat.
 */

session_start();

// 1. Elimina totes les variables de sessió de l'array $_SESSION
$_SESSION = array();

// 2. IMPORTANT: Per destruir la sessió completament, cal esborrar la cookie de sessió
// al navegador. Si no es fa, l'ID de sessió (el "carret") podria quedar actiu i ser vulnerable.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    
    // Enviem una cookie amb el mateix nom però amb data de caducitat en el passat.
    // És vital que els paràmetres 'secure' i 'httponly' coincideixin amb els de iniciosesion.php.
    setcookie(
        session_name(), 
        '', 
        time() - 42000, 
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// 3. Destrueix la informació de la sessió al servidor
session_destroy();

/**
 * CAPA EXTRA: Redirecció neta.
 * Tornem a la pàgina principal amb un paràmetre per confirmar que el tancament ha estat correcte.
 */
header("Location: ../OpiumMainPage/OpiumMainPage.php?logout=1");

// 4. Finalitza l'execució del script de forma segura
exit;
?>