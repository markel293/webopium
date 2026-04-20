<?php
/**
 * MEJORA DE SEGURIDAD: CONTROL DE ACCESO
 * Si el usuario ya está logueado, no debería ver el formulario de login.
 * Lo redirigimos a su cuenta directamente.
 */
session_start();
if (isset($_SESSION['logued']) && $_SESSION['logued'] === true) {
    header("Location: micuenta.php");
    exit;
}

// Sanitización del error para evitar inyecciones de cabecera o scripts en la URL
$error = isset($_GET['error']) ? true : false;
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
        <a href="../OpiumMadrid/opiummadrid.php"><img src="../img/logomad.png" alt="Opium Madrid" /></a>
        <a href="../OpiumBarcelona/opiumbarcelona.php"><img src="../img/logobcn.png" alt="Opium Barcelona" /></a>
        <a href="../OpiumMarbella/opiumbeachclub.php"><img src="../img/logomarbella.png" alt="Opium Marbella" class="logomarbella" /></a>
      </div>
    </header>

    <div class="divfotofondoVIP">
      <img class="fotofondoVIP" src="../img/headerclubmad.jpg" alt="Opium Madrid CLUB" />
    </div>

    <div class="divpresentacionvip">
      <h1>GESTIONA TUS DÍAS DE FIESTA, REVISA TU CUENTA</h1>
      <p>Rellena este formulario para iniciar sesión en nuestra web. Una vez dentro, podrás gestionar tus entradas, VIPs y reservas.</p>
    </div>

    <div class="divformregistro">
      <form class="formregistro" action="iniciosesion.php" method="POST" autocomplete="off">
        <div class="formfilas">

          <div class="cuadrosform2">
            <label for="email">Correo electrónico</label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="bol@alsinarro.com"
              required
              pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
              title="Introduce un correo válido"
            />
          </div>

          <div class="cuadrosform2">
            <label for="pass_hash">Contraseña</label>
            <input
              type="password"
              id="pass_hash"
              name="pass_hash"
              placeholder="******"
              required
            />
          </div>

        </div>

        <button type="submit">INICIAR SESIÓN</button>

        <p style="color: white; text-align: center; margin-top: 15px;"><b>
          ¿No tienes cuenta? 
          <a href="formregistro.php" style="color: #d4af37; text-decoration: underline;">Crea una</a>
        </p></b>

        <?php if ($error): ?>
          <div style="background: rgba(255,0,0,0.1); border: 1px solid red; padding: 10px; margin-top: -10px; border-radius: 5px;">
            <p style="color: white; text-align: center; font-weight: bold; margin: 0;">
              ⚠️ Los datos introducidos no son correctos.
            </p>
          </div>
        <?php endif; ?>

      </form>
    </div>

    <?php $colorfooter = 'footer-main'; include '../footer.php'; ?>

    <p class="textoh5MP">Opium © 2026 Costa Este – Todos los derechos reservados</p>
    <br />

  </body>
</html>