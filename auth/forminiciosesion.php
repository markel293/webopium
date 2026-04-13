<?php
// Si hay el error de contraseña o usuario incorrecto, se guarda para mostrarlo abajo del formulario
$error = isset($_GET['error']) ? true : false;
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

    <!-- CABECERA -->
    <header class="cabecera">
      <div class="logos">
        <a href="../OpiumMadrid/opiummadrid.php">
          <img src="../img/logomad.png" alt="Opium Madrid" />
        </a>
        <a href="../OpiumBarcelona/opiumbarcelona.php">
          <img src="../img/logobcn.png" alt="Opium Barcelona" />
        </a>
        <a href="../OpiumMarbella/opiumbeachclub.php">
          <img src="../img/logomarbella.png" alt="Opium Marbella" class="logomarbella" />
        </a>
      </div>
    </header>

    <!-- FONDO HEADER -->
    <div class="divfotofondoVIP">
      <img class="fotofondoVIP" src="../img/headerclubmad.jpg" alt="Opium Madrid CLUB" />
    </div>

    <!-- TEXTO INICIO SESIÓN -->
    <div class="divpresentacionvip">
      <h1>GESTIONA TUS DÍAS DE FIESTA, REVISA TU CUENTA</h1>
      <p>
        Rellena este formulario para iniciar sesión en nuestra web. Una vez dentro,
        podrás gestionar tus entradas, VIPs y reservas en nuestro restaurante.
      </p>
    </div>

    <!-- FORMULARIO DE INICIO DE SESIÓN -->
    <div class="divformregistro">
      <form class="formregistro" action="iniciosesion.php" method="POST">
        <div class="formfilas">

          <!-- Campo email -->
          <div class="cuadrosform2">
            <label for="email">Correo electrónico</label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="doloresfuertes@gmail.com"
              required
              pattern="^[^@\s]+@[^@\s]+\.[^@\s]+$"
              title="Introduce un correo válido"
            />
          </div>

          <!-- Campo contraseña -->
          <div class="cuadrosform2">
            <label for="pass_hash">Contraseña</label>
            <input
              type="password"
              id="pass_hash"
              name="pass_hash"
              placeholder="Mínimo 6 caracteres"
              required
              pattern=".{7,}"
              title="La contraseña debe tener más de 6 caracteres"
            />
          </div>

        </div>

        <!-- Botón de envío -->
        <button type="submit">INICIAR SESIÓN</button>

        <!-- Enlace a pagina de registro -->
        <p style="color: white; text-align: center;">
          ¿No tienes cuenta?
          <a href="formregistro.php" style="color: white; text-decoration: underline;">
            Crea una
          </a>
        </p>

        <!-- Mensaje de error si la contraseña o el usuario son incorrectos -->
        <?php if ($error): ?>
          <p style="color: white; text-align: center; font-weight: bold;">
            ⚠️ Comprueba el usuario o la contraseña, son incorrectos.
          </p>
        <?php endif; ?>

      </form>
    </div>

    <!-- FOOTER -->
    <?php
      $colorfooter = 'footer-main';
      include '../footer.php';
    ?>

    <!-- DERECHOS -->
    <p class="textoh5MP">Opium © 2025 Costa Este – Todos los derechos reservados</p>
    <br />

  </body>
</html>
