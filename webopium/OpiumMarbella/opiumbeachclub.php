<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Opium Marbella © 2025 Costa Este</title>
    <link rel="stylesheet" href="../StyleMainPage.css" />
    <link rel="icon" href="../img/logogeneral.png" type="image/png" />
  </head>
  <body class="bodys">
    <!-- ----------------------------------------------- CABECERA ----------------------------------------------- -->
    <?php include 'headermarbella.php'; ?>

    <!-- ----------------------------------------------- VIDEO PROMO MARBELLA ----------------------------------------------- -->  
    <div class="divvideopromo colorfondomarbella">
      <video class="videopromo" autoplay muted loop playsinline>
        <source src="../img/videopromomarbella.mp4" type="video/mp4" />
        Tu navegador no soporta el vídeo.
      </video>
      <div class="textovideopromo">THE ULTIMATE BEACH CLUB EXPERIENCE</div>
    </div>

    <!-- ----------------------------------------------- PRÓXIMOS EVENTOS ----------------------------------------------- -->
    <div class="divtitulos colorfondomarbella">
      <h2 class="textoh2marbella">PRÓXIMOS EVENTOS</h2>
    </div>

    <div class="diveventos">
      <?php for ($i = 0; $i < 5; $i++): ?> <!-- Bucl, ya que la imagen es la misma para los 5 eventos, TBA -->
        <div class="cuadroseventosmarbella">
          <p class="fechaevento">TBA</p>
          <div class="flyerseventos" style="background-image: url('../img/flyerstba.png');"></div>
          <p class="textoevento">COMING SOON</p>
          <p class="textoevento">12:00</p>
          <button class="botonentradasmarbella">NO DISPONIBLE</button>
        </div>
      <?php endfor; ?>
    </div>

    <!-- ----------------------------------------------- BOTÓN CALENDARIO COMPLETO ----------------------------------------------- -->
    <div class="divbotones">
      <a href="calendariomarbella.php" class="botonesmarbella">VER CALENDARIO COMPLETO</a>
    </div>

    <!-- ----------------------------------------------- PROMO CLUB ----------------------------------------------- -->
    <div class="divtitulos colorfondomarbella">
      <h2 class="textoh2mad">BEACH CLUB</h2>
    </div>

    <div class="divpromoclub colorfondomarbella">
      <img src="../img/promoclubmarbella.jpg" alt="Promo Club Marbella" class="imgpromoclub" />
    </div>

    <div class="cuadroshundidos">
      "Opium Beach Marbella es reconocido por sus legendarias fiestas diurnas junto al mar, siendo el destino por excelencia y un ícono global del entretenimiento. Nuestra misión constante es despertar alegría, energía y autenticidad, asegurando experiencias de verano inolvidables para todos nuestros clientes."
    </div>

    <div class="divbotones">
      <a href="clubmarbella.php" class="botonesmarbella">MÁS INFORMACIÓN</a>
    </div>

    <!-- ----------------------------------------------- PROMO RESTAURANTE ----------------------------------------------- -->
    <div class="divtitulos colorfondomarbella">
      <h2 class="textoh2mad">RESTAURANTE</h2>
    </div>

    <div class="divpromoclub">
      <img src="../img/promorestaurante.jpg" alt="Promo Restaurante Marbella" class="imgpromoclub" />
    </div>

    <div class="cuadroshundidos">
      ¿Buscas una experiencia culinaria? Nuestro restaurante es perfecto para ti. Con un diseño moderno y chic, ofrece la oportunidad de probar cocinas internacionales en un ambiente ecléctico. Parcialmente cubierto y parcialmente al aire libre, captura las frescas brisas marinas mientras disfrutas de la atmósfera del club con comida exquisita y un servicio excelente. ¡Visitar nuestro restaurante solo puede describirse como una experiencia de amor a primer bocado!"
    </div>

    <div class="divbotones">
      <a href="restaurante.php" class="botonesmarbella">DESCUBRE EL RESTAURANTE</a>
    </div>

    <br />

    <div class="divbotones">
      <a href="clubmarbella.php" class="botonesmarbella">EXPLORA NUESTRA CARTA</a>
    </div>

    <!-- ----------------------------------------------- FOOTER ----------------------------------------------- -->
    <?php $colorfooter = 'footer-marbella'; ?>
    <?php include '../footer.php'; ?>

    <!-- ----------------------------------------------- DERECHOS ----------------------------------------------- -->	
    <p class="textoderechos colorletramarbella">Opium Beach Club © 2025 Costa Este – Todos los derechos reservados</p>
    <br />
  </body>
</html>
