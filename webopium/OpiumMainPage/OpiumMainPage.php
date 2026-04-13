<?php session_start(); ?>
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
        // Verifica si el usuario está logueado
        if (isset($_SESSION['logued']) && $_SESSION['logued'] === true) {

          // Si es el administrador, te redirige a su página de gestión cuando cliques encima de el
          if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
            echo '<a href="../auth/administracion.php" class="botoncuenta">' . $_SESSION['nom'] . '</a>';
          } else { // Si no, te manda a la gestión de tu cuenta de usuario normal
            echo '<a href="../auth/micuenta.php" class="botoncuenta">' . $_SESSION['nom'] . '</a>';
          }

          echo '<a href="../auth/cerrarsesion.php" class="botoncuenta">Cerrar sesión</a>';
        } else { // Si no está logueado te muestra los botones de inicio de sesion y registrp
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

    <!-- EVENTOS DESTACADOS -->
    <div class="divtituloeventosMP">
      <h2 class="textoh2MP">EVENTOS DESTACADOS</h2>
    </div>

    <div class="diveventosMP">
      <div class="cuadroseventosMP">
        <div class="flyerseventosMP" style="background-image: url('../img/flyerjasonderulo.jpg');"></div>
        <p class="textoeventoMP">JASON DERULO</p>
        <p class="textoeventoMP">03/04/2024</p>
        <p class="textoeventoMP">OPIUM MADRID</p>
      </div>

      <div class="cuadroseventosMP">
        <div class="flyerseventosMP" style="background-image: url('../img/flyersteveaoki.jpg');"></div>
        <p class="textoeventoMP">STEVE AOKI</p>
        <p class="textoeventoMP">23/08/2023</p>
        <p class="textoeventoMP">OPIUM BARCELONA</p>
      </div>

      <div class="cuadroseventosMP">
        <div class="flyerseventosMP" style="background-image: url('../img/flyertyga.jpg');"></div>
        <p class="textoeventoMP">TYGA</p>
        <p class="textoeventoMP">01/12/2024</p>
        <p class="textoeventoMP">OPIUM BARCELONA</p>
      </div>

      <div class="cuadroseventosMP">
        <div class="flyerseventosMP" style="background-image: url('../img/flyerwizkhalifa.jpg');"></div>
        <p class="textoeventoMP">WIZ KHALIFA</p>
        <p class="textoeventoMP">08/07/2018</p>
        <p class="textoeventoMP">OPIUM BARCELONA</p>
      </div>

      <div class="cuadroseventosMP">
        <div class="flyerseventosMP" style="background-image: url('../img/flyermarshmello.jpg');"></div>
        <p class="textoeventoMP">MARSHMELLO</p>
        <p class="textoeventoMP">05/07/2017</p>
        <p class="textoeventoMP">OPIUM BARCELONA</p>
      </div>
    </div>

    <!-- SECCIÓN SOCIAL -->
    <div class="divtitulosocialMP">
      <h2 class="textoh2MP">SOCIAL</h2>
      <h4 class="textoh4MP">ÚNETE A LA FAMILIA OPIUM</h4>
    </div>

    <div class="promoig">
      <div class="divcuadroig">
        <img class="logoig" src="../img/logoig.png" alt="Logo Instagram" />
      </div>
      <p class="textoh5MP">@opiumbarcelona // @opiummadrid // @opiumbeachmarbella</p>
    </div>

    <!-- FILA 1 DE FOTOS SOCIAL -->
    <div class="divsocialMP">
      <div class="filas-socialMP">
        <div class="cuadros-socialMP">
          <div class="flyers-socialMP" style="background-image: url('../img/fotopromo1.jpg');"></div>
        </div>
        <div class="cuadros-socialMP">
          <div class="flyers-socialMP" style="background-image: url('../img/fotopromo2.jpg');"></div>
        </div>
        <div class="cuadros-socialMP">
          <div class="flyers-socialMP" style="background-image: url('../img/fotopromo3.jpg');"></div>
        </div>
        <div class="cuadros-socialMP">
          <div class="flyers-socialMP" style="background-image: url('../img/fotopromo4.jpg');"></div>
        </div>
        <div class="cuadros-socialMP">
          <div class="flyers-socialMP" style="background-image: url('../img/fotopromo5.jpg');"></div>
        </div>
      </div>

      <!-- FILA 2 DE FOTOS SOCIAL -->
      <div class="filas-socialMP">
        <div class="cuadros-socialMP">
          <div class="flyers-socialMP" style="background-image: url('../img/fotopromo6.jpg');"></div>
        </div>
        <div class="cuadros-socialMP">
          <div class="flyers-socialMP" style="background-image: url('../img/fotopromo7.jpg');"></div>
        </div>
        <div class="cuadros-socialMP">
          <div class="flyers-socialMP" style="background-image: url('../img/fotopromo8.jpg');"></div>
        </div>
        <div class="cuadros-socialMP">
          <div class="flyers-socialMP" style="background-image: url('../img/fotopromo9.jpg');"></div>
        </div>
        <div class="cuadros-socialMP">
          <div class="flyers-socialMP" style="background-image: url('../img/fotopromo10.jpg');"></div>
        </div>
      </div>
    </div>

    <!-- FOOTER -->
    <?php $colorfooter = 'footer-main'; ?>
    <?php include '../footer.php'; ?>

    <!-- TEXTO FINAL -->
    <p class="textoh5MP">Opium © 2025 Costa Este – Todos los derechos reservados</p>
    <br><br><br>

  </body>
</html>
