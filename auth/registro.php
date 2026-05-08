<?php
/**
 * SISTEMA DE REGISTRE SEGUR - OPIUM
 * Implementa hashing de contrasenyes, sentències preparades i gestió de cookies segures
 * per complir amb els estàndards moderns de protecció de dades.
 */

// 1. Configuració de Seguretat: Forcem excepcions en MySQLI per capturar errors d'integritat (com duplicats)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include 'conexion.php';

try {
    // 2. Sanejaments: Evitem atacs XSS (Cross-Site Scripting) netejant etiquetes HTML dels inputs
    $nom      = htmlspecialchars(trim($_POST['nom']));
    $cognom   = htmlspecialchars(trim($_POST['cognom']));
    
    // Sanejament específic per a l'email
    $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    // Filtratge de caràcters no numèrics al telèfon
    $telefon  = preg_replace('/[^0-9+]/', '', $_POST['telefon']); 
    $pass     = $_POST['pass_hash'];

    // 3. Validació de Regles de Negoci al Servidor (Segona barrera després de l'HTML5)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: formregistro.php?error=invalid_email");
        exit;
    }

    if (strlen($pass) < 6) {
        header("Location: formregistro.php?error=short_pass");
        exit;
    }

    // 4. Hashing: Apliquem Algoritme de Hashing Robust (Bcrypt per defecte)
    // El 'salt' es gestiona automàticament, protegint contra atacs de Rainbow Tables.
    $pass_cifrada = password_hash($pass, PASSWORD_DEFAULT);

    // 5. Sentència Preparada (Prepared Statements): 
    // Blindatge total contra SQL Injection. Les dades viatgen separades de la lògica SQL.
    $stmt = $conn->prepare("INSERT INTO client (nom, cognom, email, pass, telefon, data_registre) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $nom, $cognom, $email, $pass_cifrada, $telefon);

    if ($stmt->execute()) {
        
        // 6. GESTIÓ DE SESSIÓ SEGURA TRAS REGISTRE (Adaptat a la proposta tècnica)
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => false,      // S'ha de canviar a 'false' si proves en localhost sense SSL
            'httponly' => true,    // Protegeix el token de robatoris per JavaScript
            'samesite' => 'Strict'
        ]);

        session_start();
        session_regenerate_id(true); // Prevé el Session Fixation (Secrest de sessió)

        $_SESSION['logued'] = true;
        $_SESSION['nom']    = $nom;
        $_SESSION['email']  = $email;
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT']; // Huella digital del navegador

        header("Location: ../OpiumMainPage/OpiumMainPage.php");
        exit;
    }

} catch (mysqli_sql_exception $e) {
    // 7. Gestió d'Errors sense Fuga d'Informació (Information Leakage)
    if ($e->getCode() === 1062) { 
        // Entrada duplicada: Informem l'usuari de forma controlada
        header("Location: formregistro.php?error=email_exists");
    } else {
        // Altres errors: Es registren al log del servidor, no es mostren al client
        error_log("Fallo crítico DB en registro: " . $e->getMessage());
        header("Location: formregistro.php?error=system");
    }
    exit;
} finally {
    // Tanquem recursos per evitar fugues de memòria al servidor
    if (isset($stmt)) { $stmt->close(); }
    if (isset($conn)) { $conn->close(); }
}
?>