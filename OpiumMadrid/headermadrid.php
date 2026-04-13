<?php
// Inicia la sesión 
session_start();

// Comprueba si el usuario está logueado
$logueado = isset($_SESSION['logued']) && $_SESSION['logued'] === true;

// Coge el nombre de usuario de la sesión si está logueado y lo guarda
$nombreUsuario = $_SESSION['nom'] ?? $_SESSION['nom_client'] ?? 'Usuario';
?>

<div class="header-madrid">

  <!-- LOGO GENERAL A LA IZQUIERDA -->
  <div class="logoO">
    <a href="../OpiumMainPage/OpiumMainPage.php">
      <img src="../img/logogeneral.png" alt="Logo General">
    </a>
  </div>

  <!-- NAVEGACIÓN PRINCIPAL IZQUIERDA -->
  <div class="cabeceraizqmad">
    <a href="infovipmad.php">VIP</a>
    <a href="entradasmad.php">ENTRADAS</a>
  </div>

  <!-- LOGO CENTRAL DE OPIUM MADRID -->
  <div class="cabeceracentromad">
    <a href="opiummadrid.php">
      <img src="../img/logomad.png" alt="Logo Opium Madrid" class="logo-madrid">
    </a>
  </div>

  <!-- NAVEGACIÓN PRINCIPAL DERECHA -->
  <div class="cabeceradermad">
    <a href="calendariomad.php">CALENDARIO</a>
    <a href="infoclubmad.php">CLUB</a>
  </div>

  <!-- USUARIO -->
  <div class="usuarioheader">
    <?php if ($logueado): ?>
      <!-- Usuario logueado, si es admin -->
      <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
        <a href="../auth/administracion.php" class="botoncuenta"><?= $nombreUsuario ?></a>
      <!-- Usuario logueado, si no es admin -->
      <?php else: ?>
        <a href="../auth/micuenta.php" class="botoncuenta"><?= $nombreUsuario ?></a>
      <?php endif; ?>
      <a href="../auth/cerrarsesion.php" class="botoncuenta">Cerrar sesión</a>
    <?php else: ?>
      <!-- Usuario no logueado -->
      <a href="../auth/forminiciosesion.php" class="botoncuenta">Iniciar sesión</a>
      <a href="../auth/formregistro.php" class="botoncuenta">Registrarse</a>
    <?php endif; ?>
  </div>

</div>
