<?php
// Comença a recordar qui és l'usuari mentre navega per la web
session_start();

// Comprova si l'usuari ha arribat aquí enviant el formulari (fent clic al botó)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Connecta amb el "magatzem" de dades (la base de dades)
    include 'conexion.php';

    // 1. NETEJA I VALIDACIÓ: Passem el correu per un filtre per treure caràcters estranys
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass  = $_POST['pass_hash']; // Agafem la contrasenya que l'usuari ha escrit

    // Si el correu no té un format real (com "persona@correu.com"), el fem fora
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: forminiciosesion.php?error=1");
        exit;
    }

    // 2. COMANDA BLINDADA (Sentència Preparada):
    // Preparem la pregunta per a la base de dades deixant un espai buit conegut com "?"
    // Això evita l'atac "SQL Injection" perquè el servidor no barreja l'ordre amb la dada
    $stmt = $conn->prepare("SELECT nom, pass FROM client WHERE email = ?");
    
    // Aquí "omplim" l'espai buit de la pregunta amb el correu de l'usuari de forma segura
    $stmt->bind_param("s", $email); 
    
    // Executem la pregunta
    $stmt->execute();
    
    // Agafem la resposta que ens dóna la base de dades
    $result = $stmt->get_result();

    // Si trobem exactament 1 usuari amb aquest correu...
    if ($result && $result->num_rows === 1) {
        $row  = $result->fetch_assoc();
        $hash = $row['pass']; // Aquesta és la contrasenya "triturada" que tenim guardada

        // Comprovem si la contrasenya escrita coincideix amb la "triturada" de la base de dades
        if (password_verify($pass, $hash)) {
            
            // 3. CANVI DE CARNET (Seguretat de sessió):
            // Un cop sabem que ets tu, et donem un número d'identificació nou i secret
            // Això evita que algú que t'estigués espiant pugui fer-se passar per tu
            session_regenerate_id(true);

            // Guardem les teves dades a la memòria del servidor per saber que ja estàs dins
            $_SESSION['logued'] = true;
            $_SESSION['nom']    = $row['nom'];
            $_SESSION['email']  = $email;

            // Si el correu és el de l'administrador, li donem permisos especials
            if ($email === 'admin@admin.com') {
                $_SESSION['admin'] = true;
            }

            // Si tot ha anat bé, l'enviem a la pàgina principal de la discoteca
            header("Location: ../OpiumMainPage/OpiumMainPage.php");
            exit;
        }
    }

    // 4. SORTIDA DE SEGURETAT: Si el correu no existeix o la clau és falsa, donem un error genèric
    // No diem què ha fallat exactament per no donar pistes als pirates informàtics
    header("Location: forminiciosesion.php?error=1");
    exit;
}

// Si algú intenta entrar a aquest fitxer sense omplir el formulari, el tornem a l'inici
header("Location: forminiciosesion.php");
exit;