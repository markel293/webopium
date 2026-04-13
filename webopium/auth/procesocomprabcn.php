<?php

// Conexión a la base de datos
include 'conexion.php';
require_once '../auth/fpdf/fpdf.php';
require_once '../auth/phpqrcode/qrlib.php';

// Obtener el día del evento desde la URL (GET)
$dia = isset($_POST['dia']) ? (int)$_POST['dia'] : 0;

// Verifica si el formulario se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Recoge y limpia los datos del formulario
	$idlot = isset($_POST['id_lot']) ? (int)$_POST['id_lot'] : 0;
    $correo = strtolower(trim($_POST['email']));
    $titular = trim($_POST['titular_tarjeta']);
    $tarjeta = trim($_POST['numero_tarjeta']);
    $expiracion = trim($_POST['fecha_expiracion']);
    $codigo = trim($_POST['codigo_seguridad']);
    

    // Validación básica
    if (empty($correo) || $idlot === 0) {
        header("Location: ../OpiumBarcelona/entradasbcn.php?dia=$dia&error=Por favor completa todos los campos.#formulario");
        exit;
    }

    // Verificar si el correo electrónico existe en la base de datos
    $consulta_correo = "SELECT id_client FROM client WHERE LOWER(email) = '$correo' LIMIT 1";
    $resultado_correo = mysqli_query($conn, $consulta_correo);

    if (!$resultado_correo || mysqli_num_rows($resultado_correo) === 0) {
        header("Location: ../OpiumBarcelona/entradasbcn.php?dia=$dia&error=El correo introducido no está registrado, por favor regístrate antes de comprar cualquier entrada.#formulario");
        exit;
    }

    $cliente = mysqli_fetch_assoc($resultado_correo);
    $idcliente = $cliente['id_client'];

    // Obtener id_event y precio desde el lote seleccionado
    $consulta_entrada = "SELECT id_event, preu FROM lot_entrada WHERE id_lot = $idlot LIMIT 1";
    $resultado_entrada = mysqli_query($conn, $consulta_entrada);

    if (!$resultado_entrada || mysqli_num_rows($resultado_entrada) === 0) {
        header("Location: ../OpiumBarcelona/entradasbcn.php?dia=$dia&error=Lote de entrada no encontrado.#formulario");
        exit;
    }

    $entrada = mysqli_fetch_assoc($resultado_entrada);
    $idevento = $entrada['id_event'];
    $precio = $entrada['preu'];

    // Reducir el stock sin verificar disponibilidad
    $actualizar_stock = "UPDATE lot_entrada SET stock_disponible = stock_disponible - 1 WHERE id_lot = $idlot";
    mysqli_query($conn, $actualizar_stock);

    // Registrar la compra
    $insertar = "INSERT INTO entrada_comprada (id_client, id_lot, data_compra, estat_entrada) 
                 VALUES ($idcliente, $idlot, NOW(), 'no_utilitzada')";
    mysqli_query($conn, $insertar);

    // Redirigir con éxito
    header("Location: ../OpiumBarcelona/entradasbcn.php?dia=$dia&ok=Compra realizada con éxito.#formulario");
    exit;

} else {
    header("Location: ../OpiumBarcelona/entradasbcn.php");
    exit;
}
?>
