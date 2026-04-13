<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Opium Barcelona © 2025 Costa Este</title>
    <link rel="stylesheet" href="../StyleMainPage.css" />
    <link rel="icon" href="../img/logogeneral.png" type="image/png" />
  </head>
  <body class="bodys">

    <!-- ----------------------------------------------- CABECERA ----------------------------------------------- -->
    <?php include 'headerbarcelona.php'; ?>

    <!-- ----------------------------------------------- VIDEO PROMO BCN ----------------------------------------------- -->  
    <div class="divvideopromo colorfondobarcelona">
      <video class="videopromo" autoplay muted loop playsinline>
        <source src="../img/videopromoMP.mp4" type="video/mp4">
        Tu navegador no soporta el vídeo.
      </video>
      <div class="textovideopromo">NIGHTS ARE BETTER AT OPIUM</div>
    </div>

    <!-- ----------------------------------------------- PROXIMOS EVENTOS ----------------------------------------------- -->
    <div class="divtitulos colorfondobarcelona">
      <h2 class="textoh2bcn">PRÓXIMOS EVENTOS</h2>
    </div>

    <div class="diveventos">
      <div class="cuadroseventosbcn">
        <p class="fechaevento">MON 28 ABR</p>
        <div class="flyerseventos" style="background-image: url('../img/flyermondaysbcn.jpg');"></div>
        <p class="textoevento">BLACKOUT MONDAYS</p>
        <p class="textoevento">23:30 - 06:00</p>
        <button class="botonentradasbcn">ENTRADAS Y VIP</button>
      </div>
      <div class="cuadroseventosbcn">
        <p class="fechaevento">TUE 29 ABR</p>
        <div class="flyerseventos" style="background-image: url('../img/flyertuesdaysbcn.jpg');"></div>
        <p class="textoevento">LADIES NIGHT</p>
        <p class="textoevento">23:30 - 06:00</p>
        <button class="botonentradasbcn">ENTRADAS Y VIP</button>
      </div>
      <div class="cuadroseventosbcn">
        <p class="fechaevento">WED 30 ABR</p>
        <div class="flyerseventos" style="background-image: url('../img/flyerwednesdaysbcn.jpg');"></div>
        <p class="textoevento">EUPHORIA</p>
        <p class="textoevento">23:30 - 06:00</p>
        <button class="botonentradasbcn">ENTRADAS Y VIP</button>
      </div>
      <div class="cuadroseventosbcn">
        <p class="fechaevento">THU 01 MAY</p>
        <div class="flyerseventos" style="background-image: url('../img/flyerthursdaysbcn.jpg');"></div>
        <p class="textoevento">JET LAG</p>
        <p class="textoevento">23:30 - 06:00</p>
        <button class="botonentradasbcn">ENTRADAS Y VIP</button>
      </div>
      <div class="cuadroseventosbcn">
        <p class="fechaevento">FRI 02 MAY</p>
        <div class="flyerseventos" style="background-image: url('../img/flyerfridaysbcn.jpg');"></div>
        <p class="textoeventotextoevento">ADDICTED</p>
        <p class="textoeventotextoevento">23:30 - 06:00</p>
        <button class="botonentradasbcn">ENTRADAS Y VIP</button>
      </div>
    </div>

    <!-- ----------------------------------------------- BOTON CALENDARIO COMPLETO ----------------------------------------------- -->
    <div class="divbotones">
      <a href="calendariobcn.php" class="botonesbcn">VER CALENDARIO COMPLETO</a>
    </div>

    <!-- ----------------------------------------------- PROMO CLUB ----------------------------------------------- -->
    <div class="divtitulos colorfondobarcelona">
      <h2 class="textoh2bcn">CLUB</h2>
    </div>

    <div class="divpromoclub colorfondobarcelona">
      <img src="../img/promoclubbcn.jpg" alt="Promo Club BCN" class="imgpromoclub">
    </div>

    <div class="cuadroshundidos">
      "Con una larga trayectoria de excelencia en el ámbito del ocio nocturno y el entretenimiento, Opium Barcelona se ha convertido en el club más icónico de la ciudad y se ha consolidado como uno de los principales destinos de ocio gracias a una programación repleta de actuaciones y artistas de renombre internacional."
    </div>

    <div class="divbotones">
      <a href="infoclubbcn.php" class="botonesbcn">MÁS INFORMACIÓN</a>
    </div>

    <!-- ----------------------------------------------- PROMO VIP ----------------------------------------------- -->
    <div class="divtitulos colorfondobarcelona">
      <h2 class="textoh2bcn">VIP</h2>
    </div>

    <div>
      <h3 class="textoh3bcn">LLEVA TU NOCHE AL SIGUIENTE NIVEL</h3>
    </div>

    <div class="divpromoclub colorfondobarcelona">
      <img src="../img/promovipbcn.jpg" alt="Promo VIP BCN" class="imgpromoclub">
    </div>

	<br>
    <div class="divbotones">
      <a href="vipbarcelona.php" class="botonesbcn">RESERVAS VIP</a>
    </div>

    <!-- ----------------------------------------------- FOOTER ----------------------------------------------- -->
    <?php $colorfooter = 'footer-barcelona'; ?>
    <?php include '../footer.php'; ?>

    <!-- ----------------------------------------------- DERECHOS ----------------------------------------------- -->	
    <p class="textoderechos colorletrabarcelona">Opium Barcelona © 2025 Costa Este – Todos los derechos reservados</p>
    <br>

  </body>
</html>
