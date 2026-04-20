<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include 'conexion.php';

    // 1. Limpiar y validar el input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass  = $_POST['pass_hash']; // La contraseña que viene del formulario

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: forminiciosesion.php?error=1");
        exit;
    }

    // 2. SENTENCIA PREPARADA (Evita SQL Injection)
    // El "?" es un marcador de posición, el valor se envía separado de la lógica SQL
    $stmt = $conn->prepare("SELECT nom, pass FROM client WHERE email = ?");
    $stmt->bind_param("s", $email); // "s" significa que el parámetro es un String
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row  = $result->fetch_assoc();
        $hash = $row['pass'];

        if (password_verify($pass, $hash)) {
            
            // 3. REGENERAR ID DE SESIÓN (Seguridad de sesión)
            session_regenerate_id(true);

            $_SESSION['logued'] = true;
            $_SESSION['nom']    = $row['nom'];
            $_SESSION['email']  = $email;

            // Lógica de Admin (Correcta, pero mejor si viniera de una columna 'rol' en la BD)
            if ($email === 'admin@admin.com') {
                $_SESSION['admin'] = true;
            }

            header("Location: ../OpiumMainPage/OpiumMainPage.php");
            exit;
        }
    }

    // 4. Salida genérica (No damos pistas de si falló el mail o la pass)
    header("Location: forminiciosesion.php?error=1");
    exit;
}

header("Location: forminiciosesion.php");
exit;