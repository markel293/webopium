<?php
/**
 * SEGURETAT MÀSTER: CONFIRMACIÓ DE PAGAMENT I REGISTRE
 * Aquest fitxer rep l'usuari després de pagar a Stripe.
 * 1. Verifica que el pagament és vàlid.
 * 2. Executa la transacció final (UPDATE estoc i INSERT entrada).
 */

include 'conexion.php';
session_start();

// 1. CARREGUEM STRIPE
require_once('../lib/stripe-php/init.php');
\Stripe\Stripe::setApiKey('sk_test_51TU7Y2CRRg7EldpQn0eWxiSKcUW6IZdRRGs4re75BigUwMeVWZhgO78UbALbJcyMkVlvgCozt3fnLcmqszmjlTFz00J7zhZCTZ'); 

// Recollim les dades que hem passat per la URL
$session_id = $_GET['session_id'];
$id_client = (int)$_GET['id_client'];
$id_lot = (int)$_GET['id_lot'];
$dia = (int)$_GET['dia'];
$club = $_GET['club']; // Pot ser 'bcn' o 'mad'

// Decidim on redirigir en cas d'error o èxit segons el club
$url_retorn = ($club == 'mad') ? "../OpiumMadrid/entradasmad.php" : "../OpiumBarcelona/entradasbcn.php";

try {
    // 2. VERIFICACIÓ REAL AMB STRIPE
    // Consultem a Stripe l'estat d'aquesta sessió de pagament
    $session = \Stripe\Checkout\Session::retrieve($session_id);

    if ($session->payment_status !== 'paid') {
        throw new Exception("El pago no se ha completado correctamente.");
    }

    /**
     * 3. INICI DE LA TRANSACCIÓ SQL 
     * Ara que sabem que han pagat, fem els canvis a la base de dades.
     */
    $conn->begin_transaction();

    // A. REDUIR L'ESTOC AMB BLOQUEIG (FOR UPDATE)
    // Tornem a comprovar l'estoc per seguretat darrera hora
    $stmt_s = $conn->prepare("SELECT stock_disponible FROM lot_entrada WHERE id_lot = ? FOR UPDATE");
    $stmt_s->bind_param("i", $id_lot);
    $stmt_s->execute();
    $res_s = $stmt_s->get_result();
    $lote = $res_s->fetch_assoc();

    if ($lote['stock_disponible'] <= 0) {
        throw new Exception("Lo sentimos, ha habido SOLD OUT, se más rápido para la proxima");
    }

    // B. RESTEM 1 UNITAT D'ESTOC
    $stmt_u = $conn->prepare("UPDATE lot_entrada SET stock_disponible = stock_disponible - 1 WHERE id_lot = ?");
    $stmt_u->bind_param("i", $id_lot);
    $stmt_u->execute();

    // C. REGISTREM L'ENTRADA COMPRADA
    $stmt_i = $conn->prepare("INSERT INTO entrada_comprada (id_client, id_lot, data_compra, estat_entrada) VALUES (?, ?, NOW(), 'no_utilitzada')");
    $stmt_i->bind_param("ii", $id_client, $id_lot);
    $stmt_i->execute();

    // TOT HA ANAT BÉ: Confirmem els canvis permanentment
    $conn->commit();

    // Redirigim a la pàgina d'entradas amb el missatge d'èxit
    header("Location: $url_retorn?dia=$dia&ok=1#formulario");
    exit;

} catch (Exception $e) {
    // Si alguna cosa falla, desfem els canvis de la base de dades
    if ($conn->in_transaction()) {
        $conn->rollback();
    }
    
    $msg = urlencode($e->getMessage());
    header("Location: $url_retorn?dia=$dia&error=$msg#formulario");
    exit;
}