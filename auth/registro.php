<?php

// 1. CONTROL DE FALLADES: Configurem el sistema perquè ens avisi si la base de dades comet algun error.
// Això permet que el bloc "catch" (el nostre pla d'emergència) s'activi si alguna cosa va malament.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include 'conexion.php';

try {
    // 2. DESINFECTAR DADES: Netegem tot el que l'usuari ha escrit al formulari.
    // L'ordre 'htmlspecialchars' evita que si algú escriu codi maliciós (com un virus), aquest s'executi a la web.
    $nom      = htmlspecialchars(trim($_POST['nom']));
    $cognom   = htmlspecialchars(trim($_POST['cognom']));
    
    // Filtrem el correu per assegurar-nos que no té símbols prohibits.
    $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    // En el telèfon, només deixem números i el símbol '+', la resta ho esborrem.
    $telefon  = preg_replace('/[^0-9+]/', '', $_POST['telefon']); 
    $pass     = $_POST['pass_hash'];

    // 3. SEGONA REVISIÓ: Encara que el formulari ja ho miri, el servidor torna a comprovar-ho tot.
    // Verifiquem que el correu sigui real i que la contrasenya tingui almenys 6 lletres o números.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: formregistro.php?error=invalid_email");
        exit;
    }

    if (strlen($pass) < 6) {
        header("Location: formregistro.php?error=short_pass");
        exit;
    }

    // 4. TRITURADORA DE CLAUS (Hashing): No guardem la clau real ("1234").
    // La convertim en un codi secret i irreversible. Si un hacker robés la llista, no sabria quina és la clau.
    $pass_cifrada = password_hash($pass, PASSWORD_DEFAULT);

    // 5. COMANDA BLINDADA (Sentència Preparada): 
    // Preparem el lloc on guardarem les dades usant interrogants "?". 
    // Això fa que el servidor sàpiga separar les ordres del nom de l'usuari, evitant l'atac "SQL Injection".
    $stmt = $conn->prepare("INSERT INTO client (nom, cognom, email, pass, telefon, data_registre) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $nom, $cognom, $email, $pass_cifrada, $telefon);

    // Si la comanda s'executa correctament...
    if ($stmt->execute()) {
        // 6. CREAR EL CARNET D'IDENTITAT: Iniciem la sessió i li donem un número nou i segur a l'usuari.
        session_start();
        session_regenerate_id(true); // Això fa que la clau de sessió sigui única i difícil de robar.

        $_SESSION['logued'] = true;
        $_SESSION['nom']    = $nom;
        $_SESSION['email']  = $email;

        // Ja està registrat! L'enviem a la pàgina principal.
        header("Location: ../OpiumMainPage/OpiumMainPage.php");
        exit;
    }

} catch (mysqli_sql_exception $e) {
    // 7. GESTIÓ D'ERRORS SENSE DONAR PISTES: Si hi ha un error, no ensenyem dades tècniques.
    if ($e->getCode() === 1062) { 
        // Si el codi és 1062, vol dir que el correu ja està registrat a la nostra base de dades.
        header("Location: formregistro.php?error=email_exists");
    } else {
        // Si és un altre error, el guardem en un fitxer secret del servidor i donem un missatge genèric.
        error_log("Fallo crítico DB en registro: " . $e->getMessage());
        header("Location: formregistro.php?error=system");
    }
    exit;
} finally {
    // NETEJA FINAL: Tanquem la connexió amb la base de dades per no gastar recursos del servidor.
    if (isset($stmt)) { $stmt->close(); }
    if (isset($conn)) { $conn->close(); }
}
?>