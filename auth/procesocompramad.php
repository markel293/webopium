<?php
/**
 * SEGURETAT MÀSTER: CONNEXIÓ AMB STRIPE - OPIUM MADRID
 * Aquest fitxer ja no registra la compra directament.
 * Ara comprova que tot estigui OK i envia l'usuari a la passarel·la de pagament segura.
 */

include 'conexion.php';
session_start();

// 1. CARREGUEM LA LLIBRERIA DE STRIPE
require_once('../lib/stripe-php/init.php');

// 2. CONFIGURACIÓ DE LES CLAUS
\Stripe\Stripe::setApiKey('sk_test_51TU7Y2CRRg7EldpQn0eWxiSKcUW6IZdRRGs4re75BigUwMeVWZhgO78UbALbJcyMkVlvgCozt3fnLcmqszmjlTFz00J7zhZCTZ');

// Guardem el dia de l'esdeveniment per si hem de tornar enrere.
$dia = isset($_POST['dia']) ? (int)$_POST['dia'] : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 3. RECOLLIDA I NETEJA DE DADES
    $idlot = isset($_POST['id_lot']) ? (int)$_POST['id_lot'] : 0;
    $correo = strtolower(trim($_POST['email']));
    // Recollim la data que ve del formulari 
    $fecha_evento = isset($_POST['fecha_evento']) ? $_POST['fecha_evento'] : "";
    
    if (empty($correo) || $idlot === 0) {
        header("Location: ../OpiumMadrid/entradasmad.php?dia=$dia&error=Datos incompletos.#formulario");
        exit;
    }

    try {
        // A. VERIFICAR EL CLIENT I OBTENIR EL SEU NOM
        $stmt_c = $conn->prepare("SELECT id_client, nom, cognom FROM client WHERE email = ? LIMIT 1");
        $stmt_c->bind_param("s", $correo);
        $stmt_c->execute();
        $res_c = $stmt_c->get_result();

        if ($res_c->num_rows === 0) {
            throw new Exception("Este correo no está registrado, hazlo antes de comprar");
        }
        
        $client = $res_c->fetch_assoc();
        $idcliente = $client['id_client'];
        $nom_complet = $client['nom'] . " " . $client['cognom'];

        // B. VERIFICAR ESTOC I OBTENIR PREU
        $stmt_s = $conn->prepare("SELECT le.stock_disponible, le.preu, e.nom_event, le.nom_lot 
                                  FROM lot_entrada le 
                                  JOIN event e ON le.id_event = e.id_event 
                                  WHERE le.id_lot = ?");
        $stmt_s->bind_param("i", $idlot);
        $stmt_s->execute();
        $res_s = $stmt_s->get_result();

        if ($res_s->num_rows === 0) {
            throw new Exception("Entrada no encontrada.");
        }

        $lote = $res_s->fetch_assoc();
        
        if ($lote['stock_disponible'] <= 0) {
            throw new Exception("SOLD OUT");
        }

        // C. PREPARAR EL PAGAMENT A STRIPE
        $preu_centims = $lote['preu'] * 100;

        $checkout_session = \Stripe\Checkout\Session::create([
            'customer_email' => $correo,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => "Opium Madrid - " . $lote['nom_event'],
                        // Afegim Nom del Lot, Data i Titular a la descripció (igual que a BCN)
                        'description' => $lote['nom_lot'] . " | Fecha del evento: " . $dia . "/" . date("m/Y") . " | Titular: " . $nom_complet,
                    ],
                    'unit_amount' => $preu_centims,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => "http://192.168.77.111/auth/exito.php?session_id={CHECKOUT_SESSION_ID}&id_client=$idcliente&id_lot=$idlot&dia=$dia&club=mad",
            'cancel_url' => "http://192.168.77.111/OpiumMadrid/entradasmad.php?dia=$dia",
        ]);

        header("HTTP/1.1 303 See Other");
        header("Location: " . $checkout_session->url);
        exit;

    } catch (Exception $e) {
        $msg = urlencode($e->getMessage());
        header("Location: ../OpiumMadrid/entradasmad.php?dia=$dia&error=$msg.#formulario");
        exit;
    }

} else {
    header("Location: ../OpiumMadrid/entradasmad.php");
    exit;
}
?>