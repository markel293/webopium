<!-- CÓDIGO PHP COMPLETO CORREGIDO DENTRO DE TU HTML -->
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Opium Madrid CALENDARIO © 2025 Costa Este</title>
    <link rel="stylesheet" href="../StyleMainPage.css" />
    <link rel="icon" href="../img/logogeneral.png" type="image/png" />
  </head>
  <body class="bodymainpage">

    <!-- -------------------------------- CABECERA -------------------------------- -->
    <header class="cabecera">
      <div class="logos">
        <a href="../OpiumMadrid/opiummadrid.php"><img src="../img/logomad.png" alt="Opium Madrid" /></a>
        <a href="../OpiumBarcelona/opiumbarcelona.php"><img src="../img/logobcn.png" alt="Opium Barcelona" /></a>
        <a href="../OpiumMarbella/opiumbeachclub.php"><img src="../img/logomarbella.png" alt="Opium Marbella" class="logomarbella" /></a>
      </div>
    </header>

    <!-- -------------------------- FONDO DE IMAGEN -------------------------- -->
    <div class="divfotofondoVIP">
      <img class="fotofondoVIP" src="../img/fondocalendario.png" alt="Opium Barcelona CALENDARIO" />
    </div>

    <!-- ---------------------- PRESENTACIÓN CALENDARIO ---------------------- -->
    <div class="divpresentacionvip">
      <h1>Calendario completo de eventos</h1>
      <p>
        Echa un vistazo a nuestro extenso calendario de eventos y disfruta de nuestras fiestas legendarias!
      </p>
      <p>Opium Madrid © 2025 Costa Este</p>
    </div>

    <!-- -------------------------- CALENDARIO -------------------------- -->
    <?php
      // Conexión a la base de datos
      include '../auth/conexion.php';

      // Consulta para guardar eventos de Opium Madrid (id_local=2) en junio de 2025
      $sql = "SELECT nom_event, data_event, hora_inici, foto 
              FROM event 
              WHERE id_local = 2 
                AND MONTH(data_event) = 6 
                AND YEAR(data_event) = 2025
              ORDER BY data_event ASC";

      // Ejecutamos la consulta
      $result = $conn->query($sql);

      // Si hay resultados
      if ($result && $result->num_rows > 0) {
          $contador = 0;

          while ($evento = $result->fetch_assoc()) {
              // Abrir nueva fila cada 7 eventos
              if ($contador % 7 === 0) {
                  if ($contador > 0) echo '</div>'; // Cierra fila anterior
                  echo '<div class="diveventosCAL">'; // Nueva fila
              }

              // Formatear fecha como "FRI 07 JUN"
              $fecha = strtoupper(date('D d M', strtotime($evento['data_event'])));

              // Cuadro del evento
              echo '<div class="cuadroseventosCAL">';
              echo '<p class="fechaevento">' . $fecha . '</p>';

              // Imagen del evento
              if (!empty($evento['foto'])) {
                  $fotoBase64 = base64_encode($evento['foto']);
                  echo '<div class="flyerseventosCAL" style="background-image: url(\'data:image/jpeg;base64,' . $fotoBase64 . '\');"></div>';
              }

              // Nombre del evento y hora
              echo '<p class="textoeventoCAL">' . $evento['nom_event'] . '</p>';
              echo '<p class="textoeventoCAL">' . $evento['hora_inici'] . '</p>';

              echo '</div>'; // Fin del cuadro del evento

              $contador++;
          }

          // Cierra la última fila si fue abierta
          if ($contador > 0) echo '</div>';
      } else {
          // No hay eventos
          echo '<p class="textoeventoCAL">No hay eventos programados para junio.</p>';
      }

      // Cierra la conexión
      $conn->close();
    ?>

    <!-- ----------------------------- FOOTER ----------------------------- -->
    <?php $colorfooter = 'footer-main'; ?>
    <?php include '../footer.php'; ?>

    <!-- ----------------------------- DERECHOS ----------------------------- -->
    <p class="textoh5MP">Opium Madrid © 2025 Costa Este – Todos los derechos reservados</p>
    <br>

  </body>
</html>
