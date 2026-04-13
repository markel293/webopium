<?php
// COnexion bd
include '../auth/conexion.php';

// Verifica si el formulario se ha enviado por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Recoge los datos enviados del formulario
    $personas = $_POST['personas'];        // Personas de la reserva
    $hora = $_POST['hora'];                // Hora de la reserva
    $email = trim($_POST['email']);        // Email del usuario (el trim elimina espacios en inicio/final para que no haya errores en la revision del mail en la bd)
    $telefon = $_POST['telefon'];          // Teléfono
    $fecha = $_POST['fecha'];              // Fecha 

    // Consulta para comprobar si existe el cliente con el email puesto en el formulario
    $consulta = "SELECT id_client FROM client WHERE email = '$email'";
	
	// Ejecuta la consulta 
    $resultado = mysqli_query($conn, $consulta); 
	
    // Si no se encuentra ningún cliente con ese email
    if (mysqli_num_rows($resultado) == 0) {
        // Te mantiene en la misma pagina, a la altura del formulario, y te muestra un mensaje de error del email
        header("Location: restaurante.php?error=No existe ningún usuario con el email proporcionado, regístrate antes de hacer la reserva, o revisa si es correcto.#formulario");
        exit(); // Termina el script para que no se añada la reserva en la bd
    } else {
        // Si el email existe, guarda el id_client del cliente encontrado
        $fila = mysqli_fetch_assoc($resultado);  // Convierte la variable fila en array para guardar el valor en la bd
        $id_client = $fila['id_client'];         // Guarda en la variable id_client la variable que hemos convertido antes en array con el valor de la id del cliente 

        // Guarda la fecha y hora actual del sistema para guardarlo en el campo de data_registre
        $data_registre = date('Y-m-d H:i:s');

        // Consulta SQL para insertar la reserva en la bd
        $insertar = "INSERT INTO reserves_restaurant (data_reserva, hora_reserva, num_persones, estat, telefon, data_registre, id_client, id_local)
                     VALUES ('$fecha', '$hora', $personas, 'confirmada', '$telefon', '$data_registre', $id_client, 4)";

        // Si la inserción se realiza bien
        if (mysqli_query($conn, $insertar)) {
            // Redirige a la pagina con el mensaje de ok para que muestre el mensaje de Reserva correcta
            header("Location: restaurante.php?ok=1#formulario");
            exit();
        } else {
            // Si hay un error al insertar, redirige con mensaje de error
            header("Location: restaurante.php?error=Error al guardar la reserva#formulario");
            exit();
        }
    }
} else {
    // Si se accede directamente a este archivo por la url sin enviar el formulario (como da error), redirige al formulario de reserva
    header("Location: restaurante.php#formulario");
    exit();
}
?>
