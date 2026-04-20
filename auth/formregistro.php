<?php
/**
 * MEJORA DE SEGURIDAD: CONTROL DE ACCESO
 * Si un usuario ya está logueado, no tiene sentido que pueda registrar otra cuenta.
 */
session_start();
if (isset($_SESSION['logued']) && $_SESSION['logued'] === true) {
    header("Location: micuenta.php");
    exit;
}
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
      <img class="fotofondoVIP" src="../img/headerclubbcn.jpg" alt="Opium Barcelona CLUB" />
    </div>

    <div class="divpresentacionvip">
      <h1>ÚNETE A NUESTRA FAMILIA, CREA TU CUENTA</h1>
      <p>Rellena este formulario detalladamente para crear tu cuenta profesional.</p>
    </div>

    <div class="divformregistro" style="display: flex; flex-direction: column; align-items: center; width: 100%; padding: 20px 0;">
      
      <?php if (isset($_GET['error'])): ?>
          <div style="width: 90%; max-width: 600px; margin-bottom: 20px; box-sizing: border-box;">
              <div style="background-color: rgba(231, 76, 60, 0.15); border-left: 5px solid #e74c3c; padding: 15px; border-radius: 4px; display: flex; align-items: center; width: 100%; box-sizing: border-box;">
                  <span style="margin-right: 15px; font-size: 20px;">⚠️</span>
                  <span style="color: #ff6b6b; font-weight: bold; font-family: Arial, sans-serif; font-size: 14px; line-height: 1.4;">
                      <?php 
                          // Usamos match o switch para evitar inyección de texto desde la URL
                          switch($_GET['error']) {
                              case "email_exists": echo "Este correo ya está registrado."; break;
                              case "invalid_email": echo "El formato del correo electrónico no es válido."; break;
                              case "short_pass": echo "La contraseña es demasiado débil (mínimo 6 caracteres)."; break;
                              case "system": echo "Error de conexión. Inténtalo más tarde."; break;
                              default: echo "Ha ocurrido un error inesperado al procesar el registro.";
                          }
                      ?>
                  </span>
              </div>
          </div>
      <?php endif; ?>

      <form class="formregistro" action="registro.php" method="POST" style="width: 90%; max-width: 600px; margin: 0 auto;" autocomplete="off">
        <div class="formfilas">
          <div class="cuadrosform2">
            <label for="nom">Nombre</label>
            <input type="text" id="nom" name="nom" placeholder="Ej: Dolores" required maxlength="50" />
          </div>
          <div class="cuadrosform2">
            <label for="cognom">Apellido</label>
            <input type="text" id="cognom" name="cognom" placeholder="Ej: Fuertes" required maxlength="50" />
          </div>
        </div>

        <div class="formfilas">
          <div class="cuadrosform2">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" placeholder="bolarrin@hacina.com" required 
                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
          </div>
          <div class="cuadrosform2">
            <label for="telefon">Teléfono</label>
            <input type="tel" id="telefon" name="telefon" placeholder="600000000" required 
                   pattern="[0-9]{9,15}" title="Introduce un número de teléfono válido" />
          </div>
        </div>

        <div class="formfilas">
          <div class="cuadroform1" style="width: 100%;">
            <label for="pass_hash">Contraseña</label>
            <input type="password" id="pass_hash" name="pass_hash" placeholder="Mínimo 6 caracteres" 
                   required minlength="6" style="width: 100%; box-sizing: border-box;">
          </div>
        </div>

        <button type="submit" style="cursor: pointer; font-weight: bold;">CREAR MI CUENTA</button>
        
        <p style="color: white; text-align: center; margin-top: 20px;"><b>
          ¿Ya tienes cuenta? <a href="forminiciosesion.php" style="color: #d4af37; text-decoration: underline;">Inicia sesión aquí</a>
        </p></b>
      </form>
    </div>

    <?php $colorfooter = 'footer-main'; include '../footer.php'; ?>
    <p class="textoh5MP" style="text-align: center; padding-bottom: 20px;">Opium © 2026 Costa Este – Todos los derechos reservados</p>
</body>
</html>