<?php
// Conexion bd
include '../auth/conexion.php';

// Variable evento en null (Guarda los datos del evento para mostrar al hacer clic en el día)
$evento = null;

// Array vacío para guardar las entradas disponibles para el evento
$entradasDisponibles = [];

// Comprueba si en la URL hay un parámetro 'dia' (es decir, ya se ha seleccionado el día en el calendario)
if (isset($_GET['dia'])) {
    // Convierte el parámetro 'dia' en número int para evitar errores
    $dia = (int)$_GET['dia'];

    // Crea la fecha completa en formato YYYY-MM-DD 
    $fecha = "2025-06-" . sprintf("%02d", $dia);

    // Consulta para obtener los datos del evento de Opium Barcelona (id_local = 1) en la fecha seleccionada
    $consultaevento = "SELECT id_event, nom_event, data_event, hora_inici, foto 
                       FROM event 
                       WHERE id_local = 1 AND data_event = '$fecha'
                       LIMIT 1";

    // Ejecuta la consulta
    $result = $conn->query($consultaevento);

    // Si hay resultados 
    if ($result && $result->num_rows > 0) {
        // Guarda los datos del evento
        $evento = $result->fetch_assoc();

        // Guarda la id del evento para usarla después en la consulta de las entradas
        $id_event = $evento['id_event'];

        // Consulta para obtener las entradas disponibles (stock > 0) para el evento seleccionado
        $consultaprecios = "SELECT id_lot, nom_lot, preu, stock_disponible 
                            FROM lot_entrada 
                            WHERE id_event = $id_event AND stock_disponible > 0";

        // Ejecuta la consulta de entradas
        $res = $conn->query($consultaprecios);

        // Si hay entradas disponibles
        if ($res && $res->num_rows > 0) {
            // Recorre los registros y los guarda en el array
		
            while ($fila = $res->fetch_assoc()) {
                $entradasDisponibles[] = $fila;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Opium Barcelona ENTRADAS © 2025 Costa Este</title>
    <link rel="stylesheet" href="../StyleMainPage.css" />
    <link rel="icon" href="../img/logogeneral.png" type="image/png" />
</head>
<body class="bodymainpage">

    <!-- CABECERA CON LOGOS -->
    <header class="cabecera">
        <div class="logos">
            <a href="../OpiumMadrid/opiummadrid.php"><img src="../img/logomad.png" alt="Opium Madrid" /></a>
            <a href="../OpiumBarcelona/opiumbarcelona.php"><img src="../img/logobcn.png" alt="Opium Barcelona" /></a>
            <a href="../OpiumMarbella/opiumbeachclub.php"><img src="../img/logomarbella.png" alt="Opium Marbella" class="logomarbella" /></a>
        </div>
    </header>

    <!-- IMAGEN DE FONDO -->
    <div class="divfotofondoVIP">
        <img class="fotofondoVIP" src="../img/fondocalendario.png" alt="Opium Barcelona CALENDARIO" />
    </div>

    <!-- PRESENTACIÓN -->
    <div class="divpresentacionvip">
        <h1>ENTRADAS</h1>
        <p>Haz clic en un número del calendario para ver el evento de ese día</p>
        <p>Opium Barcelona © 2025 Costa Este</p>
    </div>

    <!-- SECCIÓN DEL CALENDARIO -->
    <div class="calendarioentradas">
        <div class="headercalendario">Calendario</div>
        <div>Junio 2025</div>

        <div class="dias-semana">
            <div>LUN</div><div>MAR</div><div>MIÉ</div><div>JUE</div><div>VIE</div><div>SÁB</div><div>DOM</div>
        </div>

        <div class="dias-mes">
            <?php
            $primerDia = date("N", strtotime("2025-06-01"));
            $diasEnJunio = 30;

            // Espacios vacíos al principio del mes
            for ($i = 1; $i < $primerDia; $i++) {
                echo '<div class="dia-vacio"></div>';
            }

            // Días del mes con enlaces
            for ($dia = 1; $dia <= $diasEnJunio; $dia++) {
                echo '<a href="?dia=' . $dia . '" class="dia-enlace">';
                echo '<div class="dia-solo">' . $dia . '</div>';
                echo '</a>';
            }
            ?>
        </div>
    </div>

    <!-- EVENTO DEL DÍA SELECCIONADO -->
    <?php if ($evento): ?>
        <div class="diveventosENT">
            <div class="cuadroseventosENT">
                <p class="textoeventoENT"><?php echo date('D d M', strtotime($evento['data_event'])); ?></p>

                <?php if (!empty($evento['foto'])): ?>
                    <div class="flyerseventosENT" style="background-image: url('data:image/jpeg;base64,<?php echo base64_encode($evento['foto']); ?>');"></div>
                <?php endif; ?>

                <p class="textoeventoENT"><?php echo $evento['nom_event']; ?></p>
                <p class="textoeventoENT"><?php echo $evento['hora_inici']; ?></p>
                <a href="../OpiumBarcelona/reservavipbcn.php" class="botonentradasENT">RESERVA VIP</a>
            </div>
        </div>

        <!-- ENTRADAS DISPONIBLES -->
        <?php if (!empty($entradasDisponibles)): ?>
            <div class="diveventosENT">
                <?php foreach ($entradasDisponibles as $entrada): ?>
                    <div class="cuadroentradaGRIS">
                        <p class="textoeventoENT">
                            <?php echo $entrada['nom_lot']; ?> — <?php echo number_format($entrada['preu'], 2); ?>€
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="textoeventoENT">Todas las entradas para este evento se encuentran AGOTADAS.</p>
        <?php endif; ?>

    <?php elseif (isset($_GET['dia'])): ?>
        <p class="textoeventoENT">No hay evento programado para ese día.</p>
    <?php endif; ?>

    <!-- FORMULARIO DE COMPRA -->
    <?php if (!empty($entradasDisponibles)): ?>
        <div class="divformregistro">
            <form class="formregistro" action="../auth/procesocomprabcn.php" method="POST" id="formulario">
                <!-- Día seleccionado (para procesar o mostrar errores) -->
                <input type="hidden" name="dia" value="<?php echo $_GET['dia']; ?>">

                <!-- Tipo de entrada -->
                <div class="formfilas">
                    <div class="cuadroform1">
                        <label for="tipo_entrada">Selecciona tipo de entrada</label>
                        <select id="tipo_entrada" name="id_lot" required>
                            <option value="">-- Elige una entrada --</option>
                            <?php foreach ($entradasDisponibles as $entrada): ?>
                                <option value="<?php echo $entrada['id_lot']; ?>">
                                    <?php echo $entrada['nom_lot'] . " — " . number_format($entrada['preu'], 2) . "€"; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Email del comprador -->
                <div class="formfilas">
                    <div class="cuadroform1">
                        <label for="email">Email de la persona que asistirá con la entrada</label>
                        <input type="email" id="email" name="email" placeholder="jiunfeng@gmail.com" required pattern="^[^@\s]+@[^@\s]+\.[^@\s]+$" title="Introduce un correo válido" />
                    </div>
                </div>

                <!-- Titular tarjeta -->
                <div class="formfilas">
                    <div class="cuadroform1">
                        <label for="titular_tarjeta">Titular de la Tarjeta</label>
                        <input type="text" id="titular_tarjeta" name="titular_tarjeta" placeholder="Carlos Manzanera Figueras" required />
                    </div>
                </div>

                <!-- Número de tarjeta -->
                <div class="formfilas">
                    <div class="cuadroform1">
                        <label for="numero_tarjeta">Número de la Tarjeta</label>
                        <input type="text" id="numero_tarjeta" name="numero_tarjeta" placeholder="5489 8473 8568 2935" />
                    </div>
                </div>

                <!-- Fecha de expiración -->
                <div class="formfilas">
                    <div class="cuadroform1">
                        <label for="fecha_expiracion">Fecha de Expiración</label>
                        <input type="date" id="fecha_expiracion" name="fecha_expiracion" required />
                    </div>
                </div>

                <!-- Código de seguridad -->
                <div class="formfilas">
                    <div class="cuadroform1">
                        <label for="codigo_seguridad">Código de Seguridad</label>
                        <input type="text" id="codigo_seguridad" name="codigo_seguridad" placeholder="CVV" required pattern="\d{3,4}" title="Introduce el código CVV de 3 o 4 dígitos" />
                    </div>
                </div>

                <!-- Botón de compra -->
                <button type="submit">COMPRAR ENTRADA</button>

                <!-- Mensajes -->
                <?php
                if (isset($_GET['error'])) {
                    echo '<p style="color: white; text-align: center; margin-top: 10px;">' . $_GET['error'] . '</p>';
                }

                if (isset($_GET['ok'])) {
                    echo '<p style="color: white; text-align: center; margin-top: 10px;">Compra realizada correctamente. Puedes ver tus entradas en tu cuenta.</p>';
                }
                ?>
            </form>
        </div>
    <?php endif; ?>

    <!-- FOOTER -->
    <?php $colorfooter = 'footer-main'; ?>
    <?php include '../footer.php'; ?>
    <p class="textoh5MP">Opium Barcelona © 2025 Costa Este – Todos los derechos reservados</p>
    <br>

</body>
</html>


