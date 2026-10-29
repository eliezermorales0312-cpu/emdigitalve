<?php
// Incluimos la conexión de forma segura
require_once 'conexion.php';

$error = '';

// Verificamos si $pdo existe y no es nulo antes de hacer consultas
if (!isset($pdo) || $pdo === null) {
    $error = "Error crítico: No hay conexión con la base de datos. Revisa el archivo conexion.php o las credenciales en Render.";
}

// Lógica de inicio de sesión cuando envían el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo !== null) {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($usuario) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM administradores WHERE usuario = ?");
            $stmt->execute([$usuario]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificamos el usuario y la contraseña (compatible con texto plano o hash)
            if ($admin && (password_verify($password, $admin['password']) || $password === $admin['password'])) {
                session_start();
                $_SESSION['admin_logged'] = true;
                $_SESSION['admin_user'] = $admin['usuario'];
                header("Location: admin_dashboard.php");
                exit;
            } else {
                $error = "Usuario o contraseña incorrectos.";
            }
        } catch (PDOException $e) {
            $error = "Error en la base de datos: " . $e->getMessage();
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - EM Digital VE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #07090f;
            color: #c0c0c0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 30px 30px;
        }
        .login-box {
            background: #0d121e;
            border: 1px solid #ff3300;
            border-radius: 12px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 25px rgba(255,51,0,0.2);
        }
        .brand-brackets { color: #ff3300; text-shadow: 0 0 8px rgba(255,51,0,0.6); }
        .brand-e { color: #ff3300; text-shadow: 0 0 8px rgba(255,51,0,0.6); }
        .brand-m { color: #c0c0c0; text-shadow: 0 0 8px rgba(192,192,192,0.6); }
        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .form-control-custom {
            background: #07090f;
            border: 1px solid #1e293b;
            color: #ffffff;
            border-radius: 6px;
            padding: 12px;
            font-size: 0.9rem;
        }
        .form-control-custom:focus {
            background: #07090f;
            border-color: #ff3300;
            color: #ffffff;
            box-shadow: 0 0 10px rgba(255,51,0,0.3);
        }
        .btn-login {
            background-color: #ff3300;
            color: #ffffff;
            font-weight: 700;
            border: none;
            border-radius: 6px;
            padding: 12px;
            width: 100%;
            box-shadow: 0 0 15px rgba(255,51,0,0.4);
            transition: all 0.3s;
        }
        .btn-login:hover {
            background-color: #c0c0c0;
            color: #07090f;
            box-shadow: 0 0 20px rgba(192,192,192,0.8);
        }
        .back-home {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #9ca3af;
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.3s;
        }
        .back-home:hover {
            color: #ff3300;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-white mb-1">
                <span class="brand-brackets">{</span><span class="brand-e">E</span><span class="brand-m">M</span><span class="brand-brackets">}</span> Admin
            </h3>
            <p class="text-secondary" style="font-size: 0.85rem;">Panel de control EM Digital VE</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger py-2 px-3 mb-3" style="font-size: 0.85rem; background: rgba(255,0,0,0.1); border-color: #ff3300; color: #ff9999;">
                <i class="fas fa-exclamation-triangle me-1"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="admin_login.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" name="usuario" class="form-control form-control-custom" placeholder="Ingresa tu usuario" required autocomplete="off">
            </div>
            <div class="mb-4">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control form-control-custom" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-login">INGRESAR AL PANEL</button>
        </form>

        <a href="index.php" class="back-home">
            <i class="fas fa-arrow-left me-1"></i> Volver al inicio
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>