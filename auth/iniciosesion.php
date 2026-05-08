<?php
/**
 * GESTIÓ D'IDENTITAT I SESSIONS SEGURES - OPIUM
 * Aquest fitxer configura les cookies de sessió amb paràmetres 'HttpOnly' i 'Secure'
 * per garantir que les dades viatgin xifrades i siguin invisibles a scripts maliciosos.
 */

// 1. CONFIGURACIÓ DE SEGURITAT DE LA COOKIE DE SESSIÓ (Abans de session_start)
session_set_cookie_params([
    'lifetime' => 0,            // La sessió s'esborra en tancar el navegador
    'path' => '/',
    'domain' => '',             // Dominis que poden llegir la cookie (Agafa el per defecte si '')
    'secure' => true,           // Només s'envia per HTTPS (Activa-ho en producció)
    'httponly' => true,         // Protecció contra XSS: la cookie és invisible per a JavaScript
    'samesite' => 'Strict'      // Protecció contra CSRF: evita peticions des d'altres llocs
]);

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include 'conexion.php';

    // 2. NETEJA I VALIDACIÓ DE LES DADES D'ENTRADA
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass  = $_POST['pass_hash']; // Contrasenya que ve del formulari

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: forminiciosesion.php?error=1");
        exit;
    }

    // 3. SENTÈNCIA PREPARADA (Protecció contra SQL Injection)
    $stmt = $conn->prepare("SELECT nom, pass FROM client WHERE email = ?");
    $stmt->bind_param("s", $email); // "s" indica que el paràmetre és una cadena (String)
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row  = $result->fetch_assoc();
        $hash = $row['pass'];

        // 4. VERIFICACIÓ DE LA CONTRASENYA (Utilitzant l'algoritme de hash segur)
        if (password_verify($pass, $hash)) {
            
            // 5. REGENERACIÓ DE L'ID DE SESSIÓ
            // Canviem el "carnet" de la sessió per evitar atacs de fixació de sessió
            session_regenerate_id(true);

            // Guardem les dades a la sessió (Xifrades al servidor)
            $_SESSION['logued'] = true;
            $_SESSION['nom']    = $row['nom'];
            $_SESSION['email']  = $email;
            
            // 6. FINGERPRINTING (Huella digital del navegador)
            // Guardem l'agent d'usuari per verificar que no ens robin la sessió des d'un altre navegador
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

            // Lògica per a l'administrador
            if ($email === 'admin@admin.com') {
                $_SESSION['admin'] = true;
            }

            // Redirecció a la pàgina principal
            header("Location: ../OpiumMainPage/OpiumMainPage.php");
            exit;
        }
    }

    // 7. SORTIDA GENÈRICA D'ERROR (Per seguretat, no diem si ha fallat el mail o la pass)
    header("Location: forminiciosesion.php?error=1");
    exit;
}

// Si s'intenta accedir directament sense POST, tornem al formulari
header("Location: forminiciosesion.php");
exit;