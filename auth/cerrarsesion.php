<?php
/**
 * MILLORA DE SEGURETAT: TANCAMENT DE SESSIÓ TOTAL
 * No només buidem les dades al servidor, sinó que esborrem qualsevol rastre a l'ordinador de l'usuari.
 */

// Iniciem la sessió per poder identificar quina és la que volem tancar
session_start();

// 1. BUIDAT DE DADES: Borrem totes les variables del calaix de la sessió.
// És com si buidéssim una motxilla i la deixéssim totalment buida.
$_SESSION = array();

// 2. ELIMINAR LA "CLAU" DEL NAVEGADOR (Cookie):
// Si el navegador fa servir cookies (que és el més normal), hem de destruir la "clau" 
// que guarda l'usuari. Si no la borrem, algú podria intentar fer-la servir més tard.
if (ini_get("session.use_cookies")) {
    // Agafem la configuració actual de la clau
    $params = session_get_cookie_params();
    
    // Ordenem al navegador que la clau caduqui immediatament.
    // Li posem una data de fa 42.000 segons (una data passada) perquè el navegador l'esborri al moment.
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

// 3. DESTRUCCIÓ FINAL: matem oficialment la sessió al servidor.
// Ja no existeix cap connexió entre aquest usuari i el nostre sistema.
session_destroy();

/**
 * CAPA EXTRA: Redirecció neta.
 * Enviem l'usuari a la pàgina principal. Afegim un avís a l'adreça (?logout=1) 
 * perquè la web sàpiga que hem sortit correctament.
 */
header("Location: ../OpiumMainPage/OpiumMainPage.php?logout=1");

// 4. Finalitza el procés de forma segura per no gastar més recursos
exit;
?>