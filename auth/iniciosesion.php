<?php
// Inicia la sesión
session_start();

// Verifica si el formulario ha sido enviado por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Incluir archivo de conexión
    include 'conexion.php';

    // Recoge los valores enviados del formulario
    $email = $_POST['email'];
    $pass  = $_POST['pass_hash'];

    // Consulta para comprobar el mail puesto en el formulario
    $sql    = "SELECT nom, pass FROM client WHERE email = '$email'";
    $result = $conn->query($sql);

    // Verifica que la consulta se ha ejecutado bien y que haya encontrado resultado con ese email
    if ($result && $result->num_rows === 1) {

        // Guarda los datos del usuario encontrado (nombre y hash de contraseña)
        $row  = $result->fetch_assoc();
        $hash = $row['pass'];

        // Verifica si la contraseña proporcionada coincide con el hash guardado en la base de datos
        if (password_verify($pass, $hash)) {

            // Si la contraseña es correcta, guarda la sesión del usuario
            $_SESSION['logued'] = true;
            $_SESSION['nom']    = $row['nom'];
            $_SESSION['email']  = $email;

            // Si es admin, marca la sesión como tal
            if ($email === 'admin@admin.com') {
                $_SESSION['admin'] = true;
            }

            // Redirige a la página principal
            header("Location: ../OpiumMainPage/OpiumMainPage.php");
            exit;
        }
    }

    // Si no se ha encontrado el usuario o la contraseña es incorrecta
    header("Location: forminiciosesion.php?error=1");
    exit;
}

// Si se accede directamente al archivo desde la url
header("Location: forminiciosesion.php");
exit;
