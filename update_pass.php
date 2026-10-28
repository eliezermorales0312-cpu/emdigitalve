<?php
require_once 'conexion.php';

// Definimos tu clave personalizada exacta
$nueva_clave = 'Eliezer26072104';
$hash_seguro = password_hash($nueva_clave, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("UPDATE administradores SET password = ? WHERE usuario = 'admin'");
    $stmt->execute([$hash_seguro]);
    
    echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
    echo "<h2 style='color: #22c55e;'>¡Listo, mano! La clave del administrador fue actualizada con éxito.</h2>";
    echo "<p style='font-size: 18px;'>Tu nueva contraseña de acceso es: <b style='color: #FF5500;'>Eliezer26072104</b></p>";
    echo "<br><a href='admin_login.php' style='padding: 12px 24px; background: #FF5500; color: #000; text-decoration: none; font-weight: bold; border-radius: 8px;'>Ir al Panel de Administración</a>";
    echo "<p style='color: #64748b; font-size: 14px; margin-top: 20px;'>No olvides borrar este archivo <b>update_pass.php</b> de tu carpeta por seguridad.</p>";
    echo "</div>";
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>Error al actualizar: " . $e->getMessage() . "</h2>";
}
?>