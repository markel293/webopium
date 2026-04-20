<?php
/**
 * SEGURIDAD MASTER: PROCESO DE COMPRA TRANSACCIONAL
 * 1. Uso de Prepared Statements para evitar SQL Injection.
 * 2. Transacciones SQL (Commit/Rollback) para asegurar la integridad.
 * 3. Verificación de stock REAL antes de restar.
 */

include 'conexion.php';
session_start();

// El día del evento para la redirección
$dia = isset($_POST['dia']) ? (int)$_POST['dia'] : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 1. Recogida y limpieza estricta
    $idlot = isset($_POST['id_lot']) ? (int)$_POST['id_lot'] : 0;
    $correo = strtolower(trim($_POST['email']));
    
    // NOTA: Los datos de la tarjeta NO se guardan en BD (Cumplimiento PCI-DSS)
    // En el futuro, aquí iría el token de la pasarela de pago.
    $titular = trim($_POST['titular_tarjeta']);

    // 2. Validación de campos vacíos
    if (empty($correo) || $idlot === 0 || empty($titular)) {
        header("Location: ../OpiumBarcelona/entradasbcn.php?dia=$dia&error=Datos incompletos.#formulario");
        exit;
    }

    // 3. Iniciar Transacción (Para que no haya fallos parciales)
    $conn->begin_transaction();

    try {
        // A. Verificar si el correo existe (Consulta Preparada)
        $stmt_c = $conn->prepare("SELECT id_client FROM client WHERE email = ? LIMIT 1");
        $stmt_c->bind_param("s", $correo);
        $stmt_c->execute();
        $res_c = $stmt_c->get_result();

        if ($res_c->num_rows === 0) {
            throw new Exception("El correo no está registrado.");
        }
        $idcliente = $res_c->fetch_assoc()['id_client'];

        // B. Verificar Stock y Precio (FOR UPDATE bloquea la fila para evitar compras simultáneas sin stock)
        $stmt_s = $conn->prepare("SELECT stock_disponible, preu FROM lot_entrada WHERE id_lot = ? FOR UPDATE");
        $stmt_s->bind_param("i", $idlot);
        $stmt_s->execute();
        $res_s = $stmt_s->get_result();

        if ($res_s->num_rows === 0) {
            throw new Exception("Lote no encontrado.");
        }

        $lote = $res_s->fetch_assoc();
        if ($lote['stock_disponible'] <= 0) {
            throw new Exception("Lo sentimos, no quedan entradas disponibles.");
        }

        // C. Reducir Stock
        $stmt_u = $conn->prepare("UPDATE lot_entrada SET stock_disponible = stock_disponible - 1 WHERE id_lot = ?");
        $stmt_u->bind_param("i", $idlot);
        $stmt_u->execute();

        // D. Registrar la compra
        $stmt_i = $conn->prepare("INSERT INTO entrada_comprada (id_client, id_lot, data_compra, estat_entrada) VALUES (?, ?, NOW(), 'no_utilitzada')");
        $stmt_i->bind_param("ii", $idcliente, $idlot);
        $stmt_i->execute();

        // Si todo ha ido bien, confirmamos los cambios en la BD
        $conn->commit();
        
        header("Location: ../OpiumBarcelona/entradasbcn.php?dia=$dia&ok=Compra realizada con éxito. Ya puedes verla en tu cuenta.#formulario");
        exit;

    } catch (Exception $e) {
        // Si algo falla, deshacemos todo lo anterior (no se resta stock ni se crea entrada)
        $conn->rollback();
        $msg = urlencode($e->getMessage());
        header("Location: ../OpiumBarcelona/entradasbcn.php?dia=$dia&error=$msg.#formulario");
        exit;
    }

} else {
    header("Location: ../OpiumBarcelona/entradasbcn.php");
    exit;
}
?>