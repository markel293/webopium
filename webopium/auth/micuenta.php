<?php
session_start();
include '../auth/conexion.php'; // Incluye la conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Opium © 2025 Costa Este</title>
    <link rel="stylesheet" href="../StyleMainPage.css" />
    <link rel="icon" href="../img/logogeneral.png" type="image/png" />
  </head>

  <body class="bodymainpage">

    <!-- CABECERA PRINCIPAL -->
    <header class="cabecera">
      <div class="logos">
        <a href="../OpiumBarcelona/opiumbarcelona.php">
          <img src="../img/logobcn.png" alt="Opium Barcelona" />
        </a>
        <a href="../OpiumMadrid/opiummadrid.php">
          <img src="../img/logomad.png" alt="Opium Madrid" />
        </a>
        <a href="../OpiumMarbella/opiumbeachclub.php">
          <img src="../img/logomarbella.png" alt="Opium Marbella" class="logomarbella" />
        </a>
      </div>

      <div class="usuarioheader">
        <?php
        if (isset($_SESSION['logued']) && $_SESSION['logued'] === true) {
          if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
            echo '<a href="../auth/administracion.php" class="botoncuenta">' . $_SESSION['nom'] . '</a>';
          } else {
            echo '<a href="../auth/micuenta.php" class="botoncuenta">' . $_SESSION['nom'] . '</a>';
          }
          echo '<a href="../auth/cerrarsesion.php" class="botoncuenta">Cerrar sesión</a>';
        } else {
          echo '<a href="../auth/forminiciosesion.php" class="botoncuenta">Iniciar sesión</a>';
          echo '<a href="../auth/formregistro.php" class="botoncuenta">Registrarse</a>';
        }
        ?>
      </div>
    </header>

    <!-- VIDEO PROMOCIONAL -->
    <div class="divvideopromoMP">
      <video class="videoMP" autoplay loop muted>
        <source src="../img/videopromoMP.mp4" type="video/mp4" />
        Tu navegador no soporta la etiqueta de video.
      </video>
    </div>

    <!-- TEXTO DE PRESENTACIÓN GENERAL -->
    <div class="divpresentacionvip">
      <p>
        Revisa aquí tus entradas compradas, o reservas para nuestro restaurante 
        de Opium Marbella Beach Club.
      </p>
    </div>

    <!-- ENTRADAS BARCELONA -->
    <div class="divpresentacionvip">
      <h1>Entradas Opium Barcelona</h1>
    </div>

<?php
if (isset($_SESSION['logued']) && $_SESSION['logued'] === true) {
  $nom = $_SESSION['nom'];
  $email = $_SESSION['email'];

  // Obtener el ID del cliente desde la base de datos usando nombre y email
  $sql_cliente = "SELECT id_client FROM client WHERE nom = '$nom' AND email = '$email'";
  $res_cliente = mysqli_query($conn, $sql_cliente);

  if ($res_cliente && mysqli_num_rows($res_cliente) > 0) {
    $fila = mysqli_fetch_assoc($res_cliente);
    $id_client = $fila['id_client'];

    // Consulta modificada para incluir el nombre del evento y la fecha del evento
    $sql_entradas = "SELECT ec.data_compra, le.nom_lot, le.preu, e.nom_event, e.data_event
                     FROM entrada_comprada ec
                     JOIN lot_entrada le ON ec.id_lot = le.id_lot
                     JOIN event e ON le.id_event = e.id_event
                     WHERE ec.id_client = $id_client AND e.id_local = 1";

    $res_entradas = mysqli_query($conn, $sql_entradas);

    echo '<div class="cuadroentradaGRIS">';
    if (mysqli_num_rows($res_entradas) > 0) {
      while ($entrada = mysqli_fetch_assoc($res_entradas)) {
        echo '<div>';
        echo '<p>Nombre: ' . $nom . '</p>';
        echo '<p>Email: ' . $email . '</p>';

        // Mostrar nombre del evento y fecha del evento
        echo '<p>Evento: ' . $entrada['nom_event'] . '</p>';
        echo '<p>Fecha del evento: ' . $entrada['data_event'] . '</p>';

        // Mostrar el resto de la información
        echo '<p>Lote: ' . $entrada['nom_lot'] . '</p>';
        echo '<p>Precio: ' . $entrada['preu'] . '€</p>';
        echo '<p>Fecha de compra: ' . $entrada['data_compra'] . '</p>';

        // Formulario para generar el QR
        echo '<form action="qr.php" method="post">';
        echo '<input type="hidden" name="id_client" value="' . $id_client . '">';
        echo '<input type="hidden" name="nom_lot" value="' . $entrada['nom_lot'] . '">';
        echo '<button type="submit" class="botonentradasENT">QR</button>';
        echo '</form>';

        echo '</div>';
      }
    } else {
      echo '<p style="text-align:center;">No tienes entradas compradas para Opium Barcelona.</p>';
    }
    echo '</div>';
  } else {
    echo '<p style="text-align:center;">No se encontró información del cliente.</p>';
  }
}
?>

    <!-- ENTRADAS MADRID -->
    <div class="divpresentacionvip">
      <h1>Entradas Opium Madrid</h1>
    </div>

<?php
if (isset($_SESSION['logued']) && $_SESSION['logued'] === true) {
  $nom = $_SESSION['nom'];
  $email = $_SESSION['email'];

  // Obtener el ID del cliente desde la base de datos usando nombre y email
  $sql_cliente = "SELECT id_client FROM client WHERE nom = '$nom' AND email = '$email'";
  $res_cliente = mysqli_query($conn, $sql_cliente);

  if ($res_cliente && mysqli_num_rows($res_cliente) > 0) {
    $fila = mysqli_fetch_assoc($res_cliente);
    $id_client = $fila['id_client'];

    // Consulta modificada para incluir el nombre del evento y la fecha del evento
    $sql_entradas = "SELECT ec.data_compra, le.nom_lot, le.preu, e.nom_event, e.data_event
                     FROM entrada_comprada ec
                     JOIN lot_entrada le ON ec.id_lot = le.id_lot
                     JOIN event e ON le.id_event = e.id_event
                     WHERE ec.id_client = $id_client AND e.id_local = 2";

    $res_entradas = mysqli_query($conn, $sql_entradas);

    echo '<div class="cuadroentradaGRIS">';
    if (mysqli_num_rows($res_entradas) > 0) {
      while ($entrada = mysqli_fetch_assoc($res_entradas)) {
        echo '<div>';
        echo '<p>Nombre: ' . $nom . '</p>';
        echo '<p>Email: ' . $email . '</p>';

        // Mostrar nombre del evento y fecha del evento
        echo '<p>Evento: ' . $entrada['nom_event'] . '</p>';
        echo '<p>Fecha del evento: ' . $entrada['data_event'] . '</p>';

        // Mostrar el resto de la información
        echo '<p>Lote: ' . $entrada['nom_lot'] . '</p>';
        echo '<p>Precio: ' . $entrada['preu'] . '€</p>';
        echo '<p>Fecha de compra: ' . $entrada['data_compra'] . '</p>';

        // Formulario para generar el QR
        echo '<form action="qr.php" method="post">';
        echo '<input type="hidden" name="id_client" value="' . $id_client . '">';
        echo '<input type="hidden" name="nom_lot" value="' . $entrada['nom_lot'] . '">';
        echo '<button type="submit" class="botonentradasENT">QR</button>';
        echo '</form>';

        echo '</div>';
      }
    } else {
      echo '<p style="text-align:center;">No tienes entradas compradas para Opium Madrid.</p>';
    }
    echo '</div>';
  } else {
    echo '<p style="text-align:center;">No se encontró información del cliente.</p>';
  }
}
?>

    <!-- RESERVAS MARBELLA -->
    <div class="divpresentacionvip">
      <h1>Reservas Restaurante Beach Club</h1>
    </div>
	
<?php
if (isset($_SESSION['logued']) && $_SESSION['logued'] === true) {
  $nom = $_SESSION['nom'];
  $email = $_SESSION['email'];

  // Obtener el ID del cliente
  $sql_cliente = "SELECT id_client FROM client WHERE nom = '$nom' AND email = '$email'";
  $res_cliente = mysqli_query($conn, $sql_cliente);

  if ($res_cliente && mysqli_num_rows($res_cliente) > 0) {
    $fila = mysqli_fetch_assoc($res_cliente);
    $id_client = $fila['id_client'];

    // Obtener las reservas del restaurante del cliente
    $sql_reservas = "SELECT c.nom, r.data_reserva, r.hora_reserva, r.num_persones, r.telefon
                     FROM reserves_restaurant r
                     JOIN client c ON r.id_client = c.id_client
                     WHERE r.id_client = $id_client";

    $res_reservas = mysqli_query($conn, $sql_reservas);

    echo '<div class="cuadroentradaGRIS">';

    if (mysqli_num_rows($res_reservas) > 0) {
      while ($reserva = mysqli_fetch_assoc($res_reservas)) {
        echo '<div class="cuadroreserva">';
        echo '<p>Nombre: ' . $reserva['nom'] . '</p>';
        echo '<p>Fecha de la reserva: ' . $reserva['data_reserva'] . '</p>';
        echo '<p>Hora: ' . $reserva['hora_reserva'] . '</p>';
        echo '<p>Número de personas: ' . $reserva['num_persones'] . '</p>';
        echo '<p>Teléfono: ' . $reserva['telefon'] . '</p>';
        echo '</div>';
		echo '<hr class="lineareserva">';
      }
    } else {
      echo '<p style="text-align:center;">No tienes reservas de restaurante registradas.</p>';
    }

    echo '</div>';
  } else {
    echo '<p style="text-align:center;">No se encontró información del cliente.</p>';
  }
}
?>

    <!-- FOOTER -->
    <?php $colorfooter = 'footer-main'; ?>
    <?php include '../footer.php'; ?>

    <!-- TEXTO FINAL -->
    <p class="textoh5MP">Opium © 2025 Costa Este – Todos los derechos reservados</p>
    <br><br><br>

  </body>
</html>
