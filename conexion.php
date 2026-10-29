<?php
// Lee las variables de entorno de Render (Clever Cloud) o usa los valores locales de XAMPP por defecto
$host     = getenv('DB_HOST')     ?: (getenv('MYSQLHOST')     ?: '127.0.0.1');
$dbname   = getenv('DB_NAME')     ?: (getenv('MYSQLDATABASE') ?: 'emdigitalve_db');
$user     = getenv('DB_USER')     ?: (getenv('MYSQLUSER')     ?: 'root');
$password = getenv('DB_PASSWORD') ?: (getenv('MYSQLPASSWORD') ?: '');
$port     = getenv('DB_PORT')     ?: (getenv('MYSQLPORT')     ?: '3306');

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<div style='background: #111; color: #ff5555; padding: 20px; font-family: monospace;'>
            <h3>[EM Digital VE] Error de Conexión:</h3>
            <p>" . $e->getMessage() . "</p>
         </div>");
}
?>