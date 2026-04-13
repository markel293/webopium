<?php
// Incluir conexión a la base de datos
include 'conexion.php';

// Recoger datos del formulario
$nom      = $_POST['nom'];
$cognom   = $_POST['cognom'];
$email    = $_POST['email'];
$telefon  = $_POST['telefon'];
$pass = $_POST['pass_hash'];

// Validaciones de correo y contraseña
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("El correo no es válido.");
}

if (strlen($pass) < 6) {
    die("La contraseña debe tener al menos 6 caracteres.");
}

// Encriptar contraseña
$pass_cifrada = password_hash($pass, PASSWORD_DEFAULT);

// Consulta SQL
$sql = "INSERT INTO client (nom, cognom, email, pass, telefon, data_registre)
        VALUES ('$nom', '$cognom', '$email', '$pass_cifrada', '$telefon', NOW())";

// Ejecuta la consulta y verifica el resultado
if ($conn->query($sql) === TRUE) {
    // Iniciar sesión automáticamente después del registro
    session_start();
    $_SESSION['logued'] = true;
    $_SESSION['nom']    = $nom;
    $_SESSION['email']  = $email;

    // Redirigir a la página principal
    header("Location: ../OpiumMainPage/OpiumMainPage.php");
    exit;
} else {
    echo "❌ Error al registrar: " . $conn->error;
}

// Cerrar conexión
$conn->close();
?>
