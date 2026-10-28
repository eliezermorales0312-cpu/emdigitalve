<?php
$host = 'localhost';
$usuario = 'root';
$password = ''; // Si le pusiste clave a tu XAMPP local, escríbela aquí
$base_de_datos = 'emdigitalve_db';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$base_de_datos;charset=utf8mb4", $usuario, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexión exitosa"; // Descomenta esta línea si quieres probar en el navegador
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>