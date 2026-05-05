<?php
/**
 * SEGURETAT MÀSTER: PROCÉS DE COMPRA TRANSACCIONAL - OPIUM MADRID
 * 1. Ús de Prepared Statements (Consultes Preparades) per evitar SQL Injection.
 * 2. Transaccions SQL (Commit/Rollback) per assegurar la integritat de les dades.
 * 3. Verificació d'estoc REAL i bloqueig de fila per evitar l'overbooking.
 */

include 'conexion.php';
session_start();

// Guardem el dia de l'esdeveniment per si hem de tornar a la pàgina anterior en cas d'error
$dia = isset($_POST['dia']) ? (int)$_POST['dia'] : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 1. RECOLLIDA I NETEJA ESTRICTA
    // Forçem l'ID a número enter (int) per desinfectar l'entrada de dades.
    $idlot = isset($_POST['id_lot']) ? (int)$_POST['id_lot'] : 0;
    $correo = strtolower(trim($_POST['email']));
    
    // NOTA DE SEGURETAT (PCI-DSS): Les dades de la targeta NO es guarden MAI a la BD.
    // Això és vital per complir amb les normatives de seguretat bancària.
    $titular = trim($_POST['titular_tarjeta']);

    // 2. VALIDACIÓ DE CAMPS BUITS
    if (empty($correo) || $idlot === 0 || empty($titular)) {
        header("Location: ../OpiumMadrid/entradasmad.php?dia=$dia&error=Por favor, completa todos los campos.#formulario");
        exit;
    }

    /**
     * 3. INICIAR TRANSACCIÓ SQL
     * Obrim un "bloc segur". Tots els canvis que fem a partir d'aquí 
     * estan en espera fins que confirmem que tot és correcte.
     */
    $conn->begin_transaction();

    try {
        // A. VERIFICAR EL CLIENT
        // Comprovem si el correu existeix a la base de dades.
        $stmt_c = $conn->prepare("SELECT id_client FROM client WHERE email = ? LIMIT 1");
        $stmt_c->bind_param("s", $correo);
        $stmt_c->execute();
        $res_c = $stmt_c->get_result();

        if ($res_c->num_rows === 0) {
            throw new Exception("El correo no está registrado. Por favor, regístrate antes de comprar.");
        }
        $idcliente = $res_c->fetch_assoc()['id_client'];

        /**
         * B. VERIFICAR ESTOC (BLOQUEIG DE SEGURETAT)
         * El 'FOR UPDATE' bloqueja temporalment aquesta fila específica.
         * Si una altra persona intenta comprar la mateixa entrada just ara, haurà d'esperar
         * a que nosaltres acabem. Així evitem vendre entrades que no existeixen.
         */
        $stmt_s = $conn->prepare("SELECT stock_disponible FROM lot_entrada WHERE id_lot = ? FOR UPDATE");
        $stmt_s->bind_param("i", $idlot);
        $stmt_s->execute();
        $res_s = $stmt_s->get_result();

        if ($res_s->num_rows === 0) {
            throw new Exception("Lote de entrada no encontrado.");
        }

        $lote = $res_s->fetch_assoc();
        if ($lote['stock_disponible'] <= 0) {
            throw new Exception("Lo sentimos, no quedan entradas disponibles para este lote.");
        }

        // C. REDUIR L'ESTOC
        // Si hi ha estoc, restem 1 entrada de forma segura.
        $stmt_u = $conn->prepare("UPDATE lot_entrada SET stock_disponible = stock_disponible - 1 WHERE id_lot = ?");
        $stmt_u->bind_param("i", $idlot);
        $stmt_u->execute();

        // D. REGISTRAR LA COMPRA
        // Creem oficialment el tiquet a la taula 'entrada_comprada' amb la data actual (NOW()).
        $stmt_i = $conn->prepare("INSERT INTO entrada_comprada (id_client, id_lot, data_compra, estat_entrada) VALUES (?, ?, NOW(), 'no_utilitzada')");
        $stmt_i->bind_param("ii", $idcliente, $idlot);
        $stmt_i->execute();

        /**
         * FINALITZACIÓ (COMMIT)
         * Com que no hi ha hagut cap error, guardem tots els canvis permanentment.
         */
        $conn->commit();
        
        header("Location: ../OpiumMadrid/entradasmad.php?dia=$dia&ok=Compra realizada con éxito. Revisa tu sección 'Mi Cuenta'.#formulario");
        exit;

    } catch (Exception $e) {
        /**
         * CANCEL·LACIÓ (ROLLBACK)
         * Si alguna cosa falla (ex: s'esgota l'estoc a l'últim mil·lisegon), 
         * desfem TOT perquè la base de dades quedi com si res hagués passat.
         */
        $conn->rollback();
        $msg = urlencode($e->getMessage());
        header("Location: ../OpiumMadrid/entradasmad.php?dia=$dia&error=$msg.#formulario");
        exit;
    }

} else {
    header("Location: ../OpiumMadrid/entradasmad.php");
    exit;
}
?>