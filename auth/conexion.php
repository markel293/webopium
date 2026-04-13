<?php
// Usamos variables de entorno para mayor seguridad en el despliegue (Docker)
// Si no existen, usamos los valores por defecto de tu XAMPP actual
$servidor = getenv('DB_HOST') ?: "localhost"; 
$usuari   = getenv('DB_USER') ?: "root"; 
$contrasenya = getenv('DB_PASS') ?: ""; 
$basedades   = getenv('DB_NAME') ?: "bdopium";

try {
    // Configuración de la conexión con PDO
    $dsn = "mysql:host=$servidor;dbname=$basedades;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Reportar errores como excepciones
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Devolver datos como arrays asociativos
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Desactivar emulación para mayor seguridad SQLi
    ];

    $pdo = new PDO($dsn, $usuari, $contrasenya, $options);
    
    // Para mantener compatibilidad con tus archivos actuales si usan $conn
    $conn = $pdo; 

} catch (\PDOException $e) {
    // En producción, nunca mostrar $e->getMessage() al usuario
    error_log($e->getMessage()); // Guardamos el error en un log interno
    die("Error de conexión. Por favor, contacte con el administrador.");
}
?>
