<?php
// Conexión directa y fija para EM Digital VE en Render
$host     = 'dpg-...'; // <--- Pega aquí el Host exacto que te da Render
$dbname   = 'emdigitalve'; // <--- Pega aquí el nombre exacto de la base de datos
$user     = '...'; // <--- Pega aquí el usuario exacto
$password = '...'; // <--- Pega aquí la contraseña exacta
$port     = '3306'; // <--- Puerto de MySQL

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<div style='background: #111; color: #ff5555; padding: 20px; font-family: monospace; border: 2px solid #ff5555;'>
        <h3>[EM Digital VE] Error Directo:</h3>
        <p>" . $e->getMessage() . "</p>
    </div>");
}
?>