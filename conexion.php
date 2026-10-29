<?php
// Configuración definitiva para EM Digital VE (Compatible con Render y Local)
$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'emdigitalve';
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';
$port = getenv('DB_PORT') ?: '3306';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Si falla, detenemos todo y mostramos exactamente el error para corregirlo de golpe
    die("<div style='background: #111; color: #ff5555; padding: 20px; font-family: monospace; border: 2px solid #ff5555;'>
        <h3>[EM Digital VE] Error Crítico de Conexión:</h3>
        <p>" . $e->getMessage() . "</p>
        <p><b>Verifica en Render (Environment):</b> DB_HOST, DB_NAME, DB_USER, DB_PASS</p>
    </div>");
}
?>