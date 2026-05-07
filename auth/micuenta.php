<?php
session_start(); // Inicia o reprenem la sessió de l'usuari per saber qui és
include '../auth/conexion.php'; // Connexió a la BD mitjançant la variable $conn

/**
 * CAPA 1: CONTROL D'ACCÉS (AUTORITZACIÓ)
 * Verifiquem si l'usuari ha iniciat sessió. Si no és així, el redirigim al formulari de login.
 * Això impedeix que qualsevol pugui escriure l'adreça de la pàgina i veure dades privades.
 */
if (!isset($_SESSION['logued']) || $_SESSION['logued'] !== true) {
    header("Location: ../auth/forminiciosesion.php");
    exit;
}

// Recuperem dades de la sessió per personalitzar la pàgina
$nom_session = $_SESSION['nom'];
$email_session = $_SESSION['email'];

/**
 * CAPA 2: OBTENCIÓ DE L'ID DEL CLIENT
 * Busquem l'identificador únic del client a la base de dades fent servir el seu correu.
 * Utilitzem una consulta preparada (?) per evitar que algú pugui manipular la petició.
 */
$stmt_c = $conn->prepare("SELECT id_client FROM client WHERE email = ?");
$stmt_c->bind_param("s", $email_session);
$stmt_c->execute();
$res_c = $stmt_c->get_result();
// Si el trobem, guardem el seu ID; si no, el posem a 0
$id_client = ($res_c->num_rows > 0) ? $res_c->fetch_assoc()['id_client'] : 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Opium © 2026 Costa Este</title>
    <link rel="stylesheet" href="../StyleMainPage.css" />
    <link rel="icon" href="../img/logogeneral.png" type="image/png" />
</head>
<body class="bodymainpage">

    <header class="cabecera">
      <div class="logos">
        <a href="../OpiumBarcelona/opiumbarcelona.php"><img src="../img/logobcn.png" alt="Opium Barcelona" /></a>
        <a href="../OpiumMadrid/opiummadrid.php"><img src="../img/logomad.png" alt="Opium Madrid" /></a>
        <a href="../OpiumMarbella/opiumbeachclub.php"><img src="../img/logomarbella.png" alt="Opium Marbella" class="logomarbella" /></a>
      </div>
      <div class="usuarioheader">
          <a href="../auth/micuenta.php" class="botoncuenta"><?php echo htmlspecialchars($nom_session); ?></a>
          <a href="../auth/cerrarsesion.php" class="botoncuenta">Cerrar sesión</a>
      </div>
    </header>

    <div class="divvideopromoMP">
      <video class="videoMP" autoplay loop muted>
        <source src="../img/videopromoMP.mp4" type="video/mp4" />
      </video>
    </div>

    <div class="divpresentacionvip">
      <h3>Revisa y gestiona aquí tus reservas o entradas adquiridas para cualquiera de nuestros establecimientos.</h3>
    </div>

    <div class="divpresentacionvip"><h2>Entradas - Opium Barcelona</h2></div>
    <div class="cuadroentradaGRIS">
    <?php
    // Busquem les entrades de Barcelona (local 1) que pertanyen a aquest usuari
	// Tornem a fer servir la "Comanda Blindada" (?) per seguretat total.
    $stmt_bcn = $conn->prepare("SELECT ec.id_entrada, ec.estat_entrada, le.nom_lot, le.preu, e.nom_event, e.data_event 
                                FROM entrada_comprada ec 
                                JOIN lot_entrada le ON ec.id_lot = le.id_lot 
                                JOIN event e ON le.id_event = e.id_event 
                                WHERE ec.id_client = ? AND e.id_local = 1");
    $stmt_bcn->bind_param("i", $id_client);
    $stmt_bcn->execute();
    $res_bcn = $stmt_bcn->get_result();

    if ($res_bcn->num_rows > 0) {
        while ($entrada = $res_bcn->fetch_assoc()) {
            echo '<div>';
			// Mostrem les dades de l'entrada netejant el text amb 'htmlspecialchars' per seguretat.
            echo '<p>Nombre: ' . htmlspecialchars($nom_session) . '</p>';
            echo '<p>Email: ' . htmlspecialchars($email_session) . '</p>';
            echo '<p>Evento: ' . htmlspecialchars($entrada['nom_event']) . '</p>';
            echo '<p>Fecha del evento: ' . $entrada['data_event'] . '</p>';
            echo '<p>Lote: ' . htmlspecialchars($entrada['nom_lot']) . '</p>';
            echo '<p>Precio: ' . $entrada['preu'] . '€</p>';
            
            // Botó per generar el QR de BCN
            echo '<form action="qr.php" method="post">';
			echo '<input type="hidden" name="id_entrada" value="' . $entrada['id_entrada'] . '">';
            echo '<input type="hidden" name="club_name" value="OPIUM BARCELONA">';
            echo '<input type="hidden" name="nom_event" value="' . htmlspecialchars($entrada['nom_event']) . '">';
            echo '<input type="hidden" name="data_event" value="' . $entrada['data_event'] . '">';
            echo '<input type="hidden" name="preu" value="' . $entrada['preu'] . '">';
            echo '<input type="hidden" name="nom_lot" value="' . htmlspecialchars($entrada['nom_lot']) . '">';
			echo '<input type="hidden" name="estat_entrada" value="' . htmlspecialchars($entrada['estat_entrada']) . '">';
            echo '<button type="submit" class="botonentradasENT">QR</button>';
            echo '</form></div><br><hr><br>';
        }
    } else { echo '<p style="text-align:center;">No tienes entradas para Opium Barcelona.</p>'; }
    ?>
    </div>

    <div class="divpresentacionvip"><h2>Entradas - Opium Madrid</h2></div>
    <div class="cuadroentradaGRIS">
    <?php
    // Busquem les entrades de Madrid (local 2) que pertanyen a aquest usuari
	// Tornem a fer servir la "Comanda Blindada" (?) per seguretat total.
    $stmt_mad = $conn->prepare("SELECT ec.id_entrada, ec.estat_entrada, le.nom_lot, le.preu, e.nom_event, e.data_event 
                                FROM entrada_comprada ec 
                                JOIN lot_entrada le ON ec.id_lot = le.id_lot 
                                JOIN event e ON le.id_event = e.id_event 
                                WHERE ec.id_client = ? AND e.id_local = 2");
    $stmt_mad->bind_param("i", $id_client);
    $stmt_mad->execute();
    $res_mad = $stmt_mad->get_result();

    if ($res_mad->num_rows > 0) {
        while ($entrada = $res_mad->fetch_assoc()) {
            echo '<div>';
			// Mostrem les dades de l'entrada netejant el text amb 'htmlspecialchars' per seguretat.
            echo '<p>Nombre: ' . htmlspecialchars($nom_session) . '</p>';
            echo '<p>Email: ' . htmlspecialchars($email_session) . '</p>';
            echo '<p>Evento: ' . htmlspecialchars($entrada['nom_event']) . '</p>';
            echo '<p>Fecha del evento: ' . $entrada['data_event'] . '</p>';
            echo '<p>Lote: ' . htmlspecialchars($entrada['nom_lot']) . '</p>';
            echo '<p>Precio: ' . $entrada['preu'] . '€</p>';
            
			// Botó per generar el QR de Madrid
            echo '<form action="qr.php" method="post">';
			echo '<input type="hidden" name="id_entrada" value="' . $entrada['id_entrada'] . '">';
            echo '<input type="hidden" name="club_name" value="OPIUM MADRID">';
            echo '<input type="hidden" name="nom_event" value="' . htmlspecialchars($entrada['nom_event']) . '">';
            echo '<input type="hidden" name="data_event" value="' . $entrada['data_event'] . '">';
            echo '<input type="hidden" name="preu" value="' . $entrada['preu'] . '">';
            echo '<input type="hidden" name="nom_lot" value="' . htmlspecialchars($entrada['nom_lot']) . '">';
			echo '<input type="hidden" name="estat_entrada" value="' . htmlspecialchars($entrada['estat_entrada']) . '">';
            echo '<button type="submit" class="botonentradasENT">QR</button>';
            echo '</form></div><br><hr><br>';
        }
    } else { echo '<p style="text-align:center;">No tienes entradas para Opium Madrid.</p>'; }
    ?>
    </div>

    <div class="divpresentacionvip"><h2>Reservas Restaurante - Marbella Beach Club</h2></div>
    <div class="cuadroentradaGRIS">
    <?php
    // Busquem les reserves de restaurant fetes per l'usuari a Marbella
    $stmt_res = $conn->prepare("SELECT c.nom, r.data_reserva, r.hora_reserva, r.num_persones, r.telefon 
                                FROM reserves_restaurant r 
                                JOIN client c ON r.id_client = c.id_client 
                                WHERE r.id_client = ?");
    $stmt_res->bind_param("i", $id_client);
    $stmt_res->execute();
    $res_res = $stmt_res->get_result();

    if ($res_res->num_rows > 0) {
        while ($reserva = $res_res->fetch_assoc()) {
            echo '<div class="cuadroreserva">';
            echo '<p>Nombre: ' . htmlspecialchars($reserva['nom']) . '</p>';
            echo '<p>Fecha de la reserva: ' . $reserva['data_reserva'] . '</p>';
            echo '<p>Hora: ' . $reserva['hora_reserva'] . '</p>';
            echo '<p>Número de personas: ' . $reserva['num_persones'] . '</p>';
			// SEGURETAT: Neteja del telèfon per evitar visualitzacions de caràcters perillosos
            echo '<p>Teléfono: ' . htmlspecialchars($reserva['telefon']) . '</p>';
            echo '</div><br><hr><br>';
        }
    } else { echo '<p style="text-align:center;">No tienes reservas registradas en Marbella Beach Club.</p>'; }
    ?>
    </div>

    <?php $colorfooter = 'footer-main'; include '../footer.php'; ?>
    <p class="textoh5MP">Opium © 2026 Costa Este – Todos los derechos reservados</p>
    <br><br>
</body>
</html>