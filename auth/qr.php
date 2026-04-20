<?php
session_start();
include '../auth/conexion.php';

if (!isset($_SESSION['logued']) || $_SESSION['logued'] !== true) {
    header("Location: ../auth/forminiciosesion.php");
    exit;
}

// Recogemos la información enviada por POST desde micuenta.php
$nom_session = $_SESSION['nom'];
$club_name   = isset($_POST['club_name']) ? htmlspecialchars($_POST['club_name']) : 'OPIUM CLUB';
$nom_event   = isset($_POST['nom_event']) ? htmlspecialchars($_POST['nom_event']) : 'Evento Especial';
$data_event  = isset($_POST['data_event']) ? htmlspecialchars($_POST['data_event']) : 'Pendiente';
$preu        = isset($_POST['preu']) ? htmlspecialchars($_POST['preu']) : '0.00';
$nom_lot     = isset($_POST['nom_lot']) ? htmlspecialchars($_POST['nom_lot']) : 'Entrada General';

// Generamos un ID de ticket único
$ticket_id = "OP-" . strtoupper(substr(md5($nom_session . $nom_event . $data_event), 0, 8));

// URL del QR
$qr_content = "TICKET:" . $ticket_id . "|CLUB:" . $club_name . "|EVENT:" . $nom_event;
$qr_url = "https://quickchart.io/qr?text=" . urlencode($qr_content) . "&size=300&dark=000000&light=ffffff&ecLevel=Q";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opium © 2026 Costa Este | <?php echo $club_name; ?></title>
    
    <link rel="icon" href="../img/logogeneral.png" type="image/png" />
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --wallet-bg: #1c1c1e;
            --gold: #d4af37;
            --label: #8e8e93;
        }

        body {
            margin: 0;
            background-color: #000;
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: white;
            padding: 20px;
        }

        .wallet-pass {
            width: 400px;
            background-color: var(--wallet-bg);
            border-radius: 28px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 50px 100px rgba(0,0,0,0.9);
            animation: slideUp 0.6s ease-out;
        }

        .pass-header {
            padding: 25px 30px;
            background: linear-gradient(to bottom, #2c2c2e, var(--wallet-bg));
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px dashed #3a3a3c;
        }

        .brand {
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 2px;
            color: var(--gold);
            text-transform: uppercase;
        }

        .pass-content { padding: 35px 30px; }

        .event-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 35px;
            display: block;
            color: #fff;
            letter-spacing: -1px;
            line-height: 1.1;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 40px;
        }

        .label {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--label);
            letter-spacing: 1px;
            margin-bottom: 6px;
            display: block;
        }

        .value {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .qr-area {
            text-align: center;
            background: rgba(255,255,255,0.03);
            padding: 30px;
            border-radius: 20px;
        }

        .qr-box {
            background: white;
            padding: 15px;
            border-radius: 15px;
            display: inline-block;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .qr-box img {
            display: block;
            width: 220px;
            height: 220px;
        }

        .wallet-pass::before, .wallet-pass::after {
            content: '';
            position: absolute;
            width: 30px;
            height: 30px;
            background-color: #000;
            border-radius: 50%;
            top: 65px;
        }
        .wallet-pass::before { left: -15px; }
        .wallet-pass::after { right: -15px; }

        .ticket-id {
            font-size: 0.75rem;
            color: #555;
            margin-top: 15px;
            font-family: monospace;
            letter-spacing: 2px;
        }

        .btn-close {
            margin-top: 40px;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 1.5px;
            transition: all 0.3s;
        }

        .btn-close:hover {
            color: white;
        }

        @keyframes slideUp {
            from { transform: translateY(80px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @media (max-width: 420px) {
            .wallet-pass { width: 100%; }
            .event-title { font-size: 1.5rem; }
            .qr-box img { width: 180px; height: 180px; }
        }
    </style>
</head>
<body>

    <div class="wallet-pass">
        <div class="pass-header">
            <span class="brand"><?php echo $club_name; ?></span>
            <span style="font-size: 0.75rem; color: var(--label); font-weight: 600;">ENTRY TICKET</span>
        </div>

        <div class="pass-content">
            <span class="event-title"><?php echo $nom_event; ?></span>

            <div class="info-grid">
                <div>
                    <span class="label">FECHA EVENTO</span>
                    <span class="value"><?php echo $data_event; ?></span>
                </div>
                <div>
                    <span class="label">PRECIO</span>
                    <span class="value"><?php echo $preu; ?>€</span>
                </div>
                <div>
                    <span class="label">TITULAR</span>
                    <span class="value"><?php echo htmlspecialchars($nom_session); ?></span>
                </div>
                <div>
                    <span class="label">TIPO</span>
                    <span class="value"><?php echo $nom_lot; ?></span>
                </div>
            </div>

            <div class="qr-area">
                <div class="qr-box">
                    <img src="<?php echo $qr_url; ?>" alt="QR">
                </div>
                <div class="ticket-id"><?php echo $ticket_id; ?></div>
            </div>
        </div>
    </div>

    <a href="micuenta.php" class="btn-close">MI CUENTA</a>

</body>
</html>