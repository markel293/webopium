<?php
// Dades de configuració per trobar la BD
$servidor = "bdopium"; 
$usuari = "root"; 
$contrasenya = "MarkelPol"; 
$basedades = "bdopium";

// Intentem obrir el túnel de connexió
$conn = mysqli_connect($servidor, $usuari, $contrasenya, $basedades);

// MILLORA DE SEGURETAT: El "Vigilant Mut"
// Si la connexió falla, no volem que ningú sàpiga per què (per no donar pistes als hakers).
if (!$conn) {
    // Guardem el motiu real de l'error en un fitxer secret que només nosaltres podem llegir (log)
    error_log("Fallo crítico de conexión: " . mysqli_connect_error());
    
    // A la pantalla de l'usuari només li ensenyem un missatge educat i genèric.
    // Això evita la "Fuga d'Informació" (Information Leakage).
    die("Lo sentimos, hay un problema técnico. Inténtalo más tarde.");
}

// MILLORA DE SEGURETAT: Blindatge del llenguatge (UTF-8)
// Forçem que tota la comunicació es faci en un format de text segur i modern (utf8mb4).
// Això evita atacs estranys que intenten "enganyar" el servidor fent servir lletres o símbols d'altres idiomes.
mysqli_set_charset($conn, "utf8mb4");
?>