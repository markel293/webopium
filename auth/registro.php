<?php

// 1. Configuración de Seguridad: Forzamos excepciones en MySQLI para capturar errores de integridad (como duplicados)
// Sin esto, el bloque 'catch' no se activaría en muchas configuraciones de PHP.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include 'conexion.php';

try {
    // 2. Sanitización: Evitamos ataques XSS (Cross-Site Scripting) limpiando etiquetas HTML de los inputs
    $nom      = htmlspecialchars(trim($_POST['nom']));
    $cognom   = htmlspecialchars(trim($_POST['cognom']));
    // Sanitización específica para email
    $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    // Filtrado de caracteres no numéricos en teléfono
    $telefon  = preg_replace('/[^0-9+]/', '', $_POST['telefon']); 
    $pass     = $_POST['pass_hash'];

    // 3. Validación de Reglas de Negocio en Servidor (Segunda barrera tras el HTML5)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: formregistro.php?error=invalid_email");
        exit;
    }

    if (strlen($pass) < 6) {
        header("Location: formregistro.php?error=short_pass");
        exit;
    }

    // 4. Hashing: Aplicamos Algoritmo de Hashing Robusto (Argon2 o Bcrypt según versión de PHP)
    // El 'salt' se gestiona automáticamente, protegiendo contra ataques de Rainbow Tables.
    $pass_cifrada = password_hash($pass, PASSWORD_DEFAULT);

    // 5. Sentencia Preparada (Prepared Statements): 
    // Blindaje total contra SQL Injection. Los datos viajan separados de la lógica SQL.
    $stmt = $conn->prepare("INSERT INTO client (nom, cognom, email, pass, telefon, data_registre) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $nom, $cognom, $email, $pass_cifrada, $telefon);

    if ($stmt->execute()) {
        // 6. Gestión de Sesión Segura tras registro
        session_start();
        session_regenerate_id(true); // Previene el Session Fixation (Secuestro de sesión)

        $_SESSION['logued'] = true;
        $_SESSION['nom']    = $nom;
        $_SESSION['email']  = $email;

        header("Location: ../OpiumMainPage/OpiumMainPage.php");
        exit;
    }

} catch (mysqli_sql_exception $e) {
    // 7. Manejo de Errores sin Fuga de Información (Information Leakage)
    if ($e->getCode() === 1062) { 
        // Entrada duplicada: Informamos al usuario de forma controlada
        header("Location: formregistro.php?error=email_exists");
    } else {
        // Otros errores: Se registran en el log del servidor, no se muestran al cliente
        error_log("Fallo crítico DB en registro: " . $e->getMessage());
        header("Location: formregistro.php?error=system");
    }
    exit;
} finally {
    // Cerramos recursos para evitar fugas de memoria en el servidor
    if (isset($stmt)) { $stmt->close(); }
    if (isset($conn)) { $conn->close(); }
}
?>