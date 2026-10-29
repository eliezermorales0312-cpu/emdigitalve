<?php
// Conexión local definitiva para XAMPP - EM Digital VE
$host     = '127.0.0.1';
$dbname   = 'emdigitalve_db';
$user     = 'admin';
$password = 'Eliezer26072104';
$port     = '3306';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<div style='background: #111; color: #ff5555; padding: 20px; font-family: monospace; border: 2px solid #ff5555;'>
        <h3>[EM Digital VE] Error de Conexión Local:</h3>
        <p>" . $e->getMessage() . "</p>
    </div>");
}
?>