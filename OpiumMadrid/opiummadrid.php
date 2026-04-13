<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Opium Madrid © 2025 Costa Este</title>
    <link rel="stylesheet" href="../StyleMainPage.css" />
    <link rel="icon" href="../img/logogeneral.png" type="image/png" />
  </head>
  <body class="bodys">

    <!-- ----------------------------------------------- CABECERA ----------------------------------------------- -->
    <?php include 'headermadrid.php'; ?>

    <!-- ----------------------------------------------- VIDEO PROMO MADRID ----------------------------------------------- -->  
    <div class="divvideopromo colorfondomadrid">
      <video class="videopromo" autoplay muted loop playsinline>
        <source src="../img/videopromomad.mp4" type="video/mp4">
        Tu navegador no soporta el vídeo.
      </video>
      <div class="textovideopromo">NIGHTS ARE BETTER AT OPIUM</div>
    </div>

    <!-- ----------------------------------------------- PROXIMOS EVENTOS ----------------------------------------------- -->
    <div class="divtitulos colorfondomadrid">
      <h2 class="textoh2mad">PRÓXIMOS EVENTOS</h2>
    </div>

    <div class="diveventos">
      <div class="cuadroseventosmad">
        <p class="fechaevento">MON 12 MAY</p>
        <div class="flyerseventos" style="background-image: url('../img/flyermondaysmad.jpg');"></div>
        <p class="textoevento">URBAN CITY</p>
        <p class="textoevento">00:00 - 05:30</p>
        <button class="botonentradasmad">ENTRADAS Y VIP</button>
      </div>
      <div class="cuadroseventosmad">
        <p class="fechaevento">TUE 13 MAY</p>
        <div class="flyerseventos" style="background-image: url('../img/flyertuesdaysmad.jpg');"></div>
        <p class="textoevento">AMERICAN DREAM</p>
        <p class="textoevento">00:00 - 05:30</p>
        <button class="botonentradasmad">ENTRADAS Y VIP</button>
      </div>
      <div class="cuadroseventosmad">
        <p class="fechaevento">WED 14 MAY</p>
        <div class="flyerseventos" style="background-image: url('../img/flyerwednesdaysmad.jpg');"></div>
        <p class="textoevento">VERBENA</p>
        <p class="textoevento">00:00 - 05:30</p>
        <button class="botonentradasmad">ENTRADAS Y VIP</button>
      </div>
      <div class="cuadroseventosmad">
        <p class="fechaevento">THU 15 MAY</p>
        <div class="flyerseventos" style="background-image: url('../img/flyerthursdaysmad.jpg');"></div>
        <p class="textoevento">EUPHORIA</p>
        <p class="textoevento">00:00 - 05:30</p>
        <button class="botonentradasmad">ENTRADAS Y VIP</button>
      </div>
      <div class="cuadroseventosmad">
        <p class="fechaevento">FRI 16 MAY</p>
        <div class="flyerseventos" style="background-image: url('../img/flyerfridaysmad.jpg');"></div>
        <p class="textoevento">JOLGORIO</p>
        <p class="textoevento">00:00 - 06:00</p>
        <button class="botonentradasmad">ENTRADAS Y VIP</button>
      </div>
    </div>

    <!-- ----------------------------------------------- BOTON CALENDARIO COMPLETO ----------------------------------------------- -->
    <div class="divbotones">
      <a href="calendariomadrid.php" class="botonesmad">VER CALENDARIO COMPLETO</a>
    </div>

    <!-- ----------------------------------------------- PROMO CLUB ----------------------------------------------- -->
    <div class="divtitulos colorfondomadrid">
      <h2 class="textoh2mad">CLUB</h2>
    </div>

    <div class="divpromoclub colorfondomadrid">
      <img src="../img/promoclubmad.jpg" alt="Promo Club Madrid" class="imgpromoclub">
    </div>

    <div class="cuadroshundidos">
      "Opium Madrid, el epicentro de la vida nocturna madrileña. Aquí, cada noche es única e inolvidable gracias a nuestra variada oferta de eventos. Con un ambiente que te cautiva desde el primer instante y una producción de alta calidad, Opium se ha convertido en parada obligatoria para quienes buscan vivir una noche épica.."
    </div>

    <div class="divbotones">
      <a href="infoclubmad.php" class="botonesmad">MÁS INFORMACIÓN</a>
    </div>

    <!-- ----------------------------------------------- PROMO VIP ----------------------------------------------- -->
    <div class="divtitulos colorfondomadrid">
      <h2 class="textoh2mad">VIP</h2>
    </div>

    <div>
      <h3 class="textoh3mad">LLEVA TU NOCHE AL SIGUIENTE NIVEL</h3>
    </div>

    <div class="divpromoclub colorfondomadrid">
      <img src="../img/promovipmad.jpg" alt="Promo VIP Madrid" class="imgpromoclub">
    </div>

	<br>
    <div class="divbotones">
      <a href="vipmadrid.php" class="botonesmad">RESERVAS VIP</a>
    </div>

    <!-- ----------------------------------------------- FOOTER ----------------------------------------------- -->
    <?php $colorfooter = 'footer-madrid'; ?>
    <?php include '../footer.php'; ?>

    <!-- ----------------------------------------------- DERECHOS ----------------------------------------------- -->	
    <p class="textoderechos colorletramadrid">Opium Madrid © 2025 Costa Este – Todos los derechos reservados</p>
    <br>

  </body>
</html>
