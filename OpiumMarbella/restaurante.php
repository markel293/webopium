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

    <!-- ----------------------------------------------- FOTO RESTAURANTE MARBELLA ----------------------------------------------- -->  
    <div class="divpromoclub">
      <img src="../img/fotorestaurante1.jpg" alt="Foto Marbella" class="videopromo" />
    </div>

    <!-- ----------------------------------------------- INFO RESTAURANTE ----------------------------------------------- -->
    <div class="divtitulos colorfondomarbella">
      <h2 class="textoh2marbella">EL RESTAURANTE</h2>
    </div>

    <div class="cuadroshundidos">
      ¿Buscas una experiencia culinaria? Nuestro restaurante es perfecto para ti. Con un diseño moderno y chic, ofrece la oportunidad de probar cocinas internacionales en un ambiente ecléctico. Parcialmente cubierto y parcialmente al aire libre, captura las frescas brisas marinas mientras disfrutas de la atmósfera del club con comida exquisita y un servicio excelente. ¡Visitar nuestro restaurante solo puede describirse como una experiencia de amor a primer bocado!
    </div>

    <div class="divpromoclub">
      <img src="../img/fotorestaurante2.jpg" alt="Foto Marbella" class="videopromo" />
    </div>

    <!-- ----------------------------------------------- INFO COMIDA ----------------------------------------------- -->
    <div class="divtitulos colorfondomarbella">
      <h2 class="textoh2marbella">LA COMIDA</h2>
    </div>

    <div class="cuadroshundidos">
      Nuestro equipo culinario fue seleccionado cuidadosamente por su habilidad, creatividad y capacidad para crear un menú que combina sabores de todo el mundo, con un énfasis en los gustos mediterráneos. Nuestros platos están preparados con los ingredientes más exquisitos, obtenidos localmente para garantizar una experiencia gastronómica auténtica. Con vistas al mar y a la piscina, el restaurante ofrece todo tipo de comida: desde una lujosa experiencia de alta cocina y catas de vino opulentas hasta una amplia selección de deliciosos aperitivos o nuestros platos firmemente saludables y también deliciosos.
    </div>

    <div class="divpromoclub">
      <img src="../img/fotorestaurante3.jpg" alt="Foto Marbella" class="videopromo" />
    </div>

    <!-- ----------------------------------------------- INFO RESERVA ----------------------------------------------- -->
    <div class="divtitulos colorfondomarbella">
      <h2 class="textoh2marbella">RESERVA UNA MESA</h2>
    </div>

    <div class="cuadroshundidos">
      Rellena este formulario para completar la reserva de tu mesa y disfruta de una experiencia gastronómica única con nosotros. <br>
	  El horario de nuestra cocina es: 12:00 - 17:00 // 20:00 - 02:00. <br>
	  Nuestras mesas tienen una capacidad entre 1-10 personas, según su elección se le asignará la mesa correspondiente al número de personas.
    </div>

    <!-- ----------------------------------------------- FORMULARIO DE RESERVA ----------------------------------------------- -->
    <div class="divformregistro">
      <form class="formregistro" action="reservarestaurante.php" method="POST" id="formulario" >

        <div class="formfilas">
          <div class="cuadrosform2">
            <label for="personas">¿Cuántas personas son?</label>
            <select id="personas" name="personas" required>
              <option value="">Personas</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
            </select>
          </div>

          <div class="cuadrosform2">
            <label for="hora">¿Hora de la reserva?</label>
            <select id="hora" name="hora" required>
              <option value="">¿Mediodía o Noche?</option>
              <option value="12:00">12:00</option>
              <option value="13:00">13:00</option>
              <option value="14:00">14:00</option>
              <option value="15:00">15:00</option>
              <option value="16:00">16:00</option>
              <option value="17:00">17:00</option>
              <option value="20:00">20:00</option>
              <option value="21:00">21:00</option>
              <option value="22:00">22:00</option>
              <option value="23:00">23:00</option>
              <option value="00:00">00:00</option>
              <option value="01:00">01:00</option>
              <option value="02:00">02:00</option>
            </select>
          </div>
        </div>

        <div class="formfilas">
          <div class="cuadrosform2">
            <label for="email">Email del/la encargado/a de la reserva (Se guardará la reserva en esta cuenta y quedará a su nombre)</label>
            <input type="email" id="email" name="email" placeholder="doloresfuertes@gmail.com" required pattern="^[^@\s]+@[^@\s]+\.[^@\s]+$" title="Introduce un correo válido" />
          </div>
          <div class="cuadrosform2">
            <label for="telefon">Teléfono (Para cualquier cambio de última hora, este será el teléfono de contacto, no se usará el de la cuenta especificada)</label>
            <input type="tel" id="telefon" name="telefon" placeholder="612365378" required />
          </div>
        </div>

        <div class="formfilas">
          <div class="cuadroform1">
            <label for="fecha">Fecha de la reserva</label>
            <input type="date" id="fecha" name="fecha" required min="2025-06-01" max="2025-09-30" />
          </div>
        </div>

        <button type="submit">RESERVAR</button>

        <?php
          // Muestra el mensaje de error si el formulario ha sido redirigido con el parámetro 'error' en la URL
          if (isset($_GET['error'])) {
            echo '<p style="color: white; text-align: center; margin-top: 10px;">' . $_GET['error'] . '</p>';
          }

          // Muestra el mensaje de éxito si el formulario ha sido redirigido con el parámetro 'ok' en la URL
          if (isset($_GET['ok'])) {
            echo '<p style="color: white; text-align: center; margin-top: 10px;">Reserva realizada correctamente, para ver los detalles, accede a la cuenta proporcionada en la reserva.</p>';
          }
        ?> 

      </form>
    </div>

    <!-- ----------------------------------------------- FOOTER ----------------------------------------------- -->
    <?php $colorfooter = 'footer-marbella'; ?>
    <?php include '../footer.php'; ?>

    <!-- ----------------------------------------------- DERECHOS ----------------------------------------------- -->	
    <p class="textoderechos colorletramarbella">Opium Beach Club © 2025 Costa Este – Todos los derechos reservados</p>
    <br />
  </body>
</html>
