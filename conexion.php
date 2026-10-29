<?php
// Conexión directa a la base de datos de Clever Cloud para producción en Render
$host     = 'b9i5qmm2v08v6n88j9lj-mysql.services.clever-cloud.com';
$dbname   = 'b9i5qmm2v08v6n88j9lj';
$user     = 'uz8w9y5f46t47ca1';
$password = 'Tg1LjpdvH7wJV53sfMV4';
$port     = '3306';

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