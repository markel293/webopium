<?php
/**
 * SEGURETAT MÀSTER: PROCÉS DE COMPRA TRANSACCIONAL
 * Aquest fitxer gestiona els diners i l'estoc, per tant, és el més blindat.
 * 1. Consultes Preparades (Prepared Statements) contra SQL Injection.
 * 2. Transaccions SQL (Tot o Res) per evitar dades a mitges si falla la llum o el servidor.
 * 3. Bloqueig de fila (FOR UPDATE) per evitar que dues persones comprin l'última entrada alhora.
 */

include 'conexion.php';
session_start();

// Guardem el dia de l'esdeveniment per si hem de tornar a la pàgina anterior en cas d'error
$dia = isset($_POST['dia']) ? (int)$_POST['dia'] : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 1. RECOLLIDA I NETEJA ESTRICTA
    // Convertim a 'int' (enter) per assegurar que l'ID sigui un número i no codi maliciós.
    $idlot = isset($_POST['id_lot']) ? (int)$_POST['id_lot'] : 0;
    $correo = strtolower(trim($_POST['email']));
    
    // NOTA DE SEGURETAT (PCI-DSS): Les dades de la targeta NO es guarden mai a la base de dades.
    // Això ens protegeix legalment; només fem servir el nom del titular per a la transacció.
    $titular = trim($_POST['titular_tarjeta']);

    // 2. VALIDACIÓ DE CAMPS BUITS
    if (empty($correo) || $idlot === 0 || empty($titular)) {
        header("Location: ../OpiumBarcelona/entradasbcn.php?dia=$dia&error=Datos incompletos.#formulario");
        exit;
    }

    /**
     * 3. INICI DE LA TRANSACCIÓ
     * A partir d'aquí, el servidor guarda els canvis en "espera". 
     * Si alguna cosa falla, s'anul·la tot (Rollback). Si tot va bé, es confirma (Commit).
     */
    $conn->begin_transaction();

    try {
        // A. VERIFICAR EL CLIENT
        // Busquem si el correu existeix. Fem servir "?" per evitar injeccions SQL.
        $stmt_c = $conn->prepare("SELECT id_client FROM client WHERE email = ? LIMIT 1");
        $stmt_c->bind_param("s", $correo);
        $stmt_c->execute();
        $res_c = $stmt_c->get_result();

        if ($res_c->num_rows === 0) {
            throw new Exception("El correo no está registrado.");
        }
        $idcliente = $res_c->fetch_assoc()['id_client'];

        /**
         * B. VERIFICAR ESTOC I PREU (AMB BLOQUEIG)
         * El 'FOR UPDATE' és vital: "Congela" la fila de l'estoc perquè ningú més pugui 
         * mirar-la fins que nosaltres acabem. Això evita l'OVERBOOKING.
         */
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

        // C. REDUIR L'ESTOC
        // Restem una entrada del magatzem virtual.
        $stmt_u = $conn->prepare("UPDATE lot_entrada SET stock_disponible = stock_disponible - 1 WHERE id_lot = ?");
        $stmt_u->bind_param("i", $idlot);
        $stmt_u->execute();

        // D. REGISTRAR LA COMPRA
        // Creem oficialment el tiquet a la taula 'entrada_comprada' amb la data actual (NOW()).
        $stmt_i = $conn->prepare("INSERT INTO entrada_comprada (id_client, id_lot, data_compra, estat_entrada) VALUES (?, ?, NOW(), 'no_utilitzada')");
        $stmt_i->bind_param("ii", $idcliente, $idlot);
        $stmt_i->execute();

        /**
         * FINALITZACIÓ: Si hem arribat fins aquí sense errors, guardem els canvis 
         * de forma permanent a la base de dades.
         */
        $conn->commit();
        
        header("Location: ../OpiumBarcelona/entradasbcn.php?dia=$dia&ok=Compra realizada con éxito. Ya puedes verla en tu cuenta.#formulario");
        exit;

    } catch (Exception $e) {
        /**
         * GESTIÓ DE FALLADES (ROLLBACK):
         * Si el servidor cau o no hi ha estoc, desfem TOTES les operacions anteriors.
         * Així mai tindrem una entrada creada sense haver restat l'estoc, o viceversa.
         */
        $conn->rollback();
        $msg = urlencode($e->getMessage());
        header("Location: ../OpiumBarcelona/entradasbcn.php?dia=$dia&error=$msg.#formulario");
        exit;
    }

} else {
    // Si algú intenta entrar al fitxer sense enviar el formulari, el redirigim.
    header("Location: ../OpiumBarcelona/entradasbcn.php");
    exit;
}
?>