<?php
require_once 'conexion.php';

// Generar un hash fresco, limpio y 100% válido para 'admin123' usando PHP
$nuevo_hash = password_hash('admin123', PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("UPDATE administradores SET password = ? WHERE usuario = 'admin'");
    $stmt->execute([$nuevo_hash]);
    
    echo "<h2 style='color:green; font-family: sans-serif;'>¡Listo, mano! Contraseña reparada y actualizada con éxito.</h2>";
    echo "<p style='font-family: sans-serif;'>Ya puedes ir a <a href='admin_login.php' style='color:#FF5500; font-weight:bold;'>Iniciar Sesión en el Panel Admin</a>.</p>";
    echo "<p style='font-family: sans-serif; color:gray;'>Usa usuario: <b>admin</b> y clave: <b>admin123</b></p>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>