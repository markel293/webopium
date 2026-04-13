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

    <!-- ----------------------------------------------- CABECERA ----------------------------------------------- -->
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

    <!-- ----------------------------------------------- FONDO HEADER ----------------------------------------------- -->
    <div class="divfotofondoVIP">
      <img class="fotofondoVIP" src="../img/headerclubbcn.jpg" alt="Opium Barcelona CLUB" />
    </div>

    <!-- ----------------------------------------------- TEXTO PRESENTACIÓN REGISTRO ----------------------------------------------- -->
    <div class="divpresentacionvip">
      <h1>UNETE A NUESTRA FAMILIA, CREA TU CUENTA</h1>
      <p>
        Rellena este formulario detalladamente para crear tu cuenta, con ella podrás gestionar tus entradas, vips, y reservas en nuestro restaurante.
      </p>
    </div>

    <!-- ----------------------------------------------- FORMULARIO DE REGISTRO ----------------------------------------------- -->
    <div class="divformregistro">
      <form class="formregistro" action="registro.php" method="POST">

        <div class="formfilas">
          <div class="cuadrosform2">
            <label for="nom">Nombre</label>
            <input type="text" id="nom" name="nom" placeholder="Dolores" required />
          </div>
          <div class="cuadrosform2">
            <label for="cognom">Apellido</label>
            <input type="text" id="cognom" name="cognom" placeholder="Fuertes" required />
          </div>
        </div>

        <div class="formfilas">
          <div class="cuadrosform2">
            <label for="email">Correo electrónico</label>
            <!-- EMAIL: debe contener un @ obligatoriamente -->
            <input type="email" id="email" name="email" placeholder="doloresfuertes@gmail.com" required pattern="^[^@\s]+@[^@\s]+\.[^@\s]+$" title="Introduce un correo válido">
          </div>
          <div class="cuadrosform2">
            <label for="telefon">Teléfono</label>
            <input type="tel" id="telefon" name="telefon" placeholder="612365378" required />
          </div>
        </div>

        <div class="formfilas">
          <div class="cuadroform1">
            <label for="pass_hash">Contraseña</label>
            <!-- CONTRASEÑA: mínimo 7 caracteres -->
            <input type="password" id="pass_hash" name="pass_hash" placeholder="Mínimo 6 caracteres" required pattern=".{7,}" title="La contraseña debe tener más de 6 caracteres">
          </div>
        </div>

        <button type="submit">CREAR CUENTA</button>
      </form>
    </div>

    <!-- ----------------------------------------------- FOOTER ----------------------------------------------- -->
    <?php $colorfooter = 'footer-main'; ?>
    <?php include '../footer.php'; ?>

    <!-- ----------------------------------------------- DERECHOS ----------------------------------------------- -->
    <p class="textoh5MP">Opium © 2025 Costa Este – Todos los derechos reservados</p>
    <br />

  </body>
</html>
