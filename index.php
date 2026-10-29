<?php
require_once 'conexion.php';

$config = [];
$demos = [];

if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT clave, valor FROM configuracion");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $config[$row['clave']] = $row['valor'];
        }
    } catch (PDOException $e) {}

    try {
        $stmtDemos = $pdo->query("SELECT * FROM demos ORDER BY id DESC");
        $demos = $stmtDemos->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {}
}

$telefono_ws = isset($config['telefono_whatsapp']) && !empty($config['telefono_whatsapp']) 
    ? $config['telefono_whatsapp'] 
    : '04223770933';

$instagram = isset($config['instagram_url']) && !empty($config['instagram_url']) 
    ? $config['instagram_url'] 
    : 'https://instagram.com/EM.digital.ve';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EM Digital VE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0b0f19;
            color: #e5e7eb;
        }
        .navbar {
            background-color: rgba(11, 15, 25, 0.95);
            border-bottom: 1px solid #ff6600;
        }
        .logo-em {
            font-weight: 700;
            text-decoration: none;
            font-size: 1.3rem;
        }
        .logo-e-orange { color: #ff6600; text-shadow: 0 0 10px rgba(255,102,0,0.6); }
        .logo-m-silver { color: #c0c0c0; text-shadow: 0 0 10px rgba(192,192,192,0.6); }
        .logo-digital { color: #ff6600; }
        .logo-v-orange { color: #ff6600; }
        .logo-e-silver { color: #c0c0c0; }

        .navbar-nav .nav-link {
            color: #c0c0c0 !important;
            font-weight: 500;
            transition: color 0.3s ease, text-shadow 0.3s ease;
        }
        .navbar-nav .nav-link:hover {
            color: #ff6600 !important;
            text-shadow: 0 0 10px rgba(255,102,0,0.8);
        }
        .hero-section {
            padding: 120px 0 80px 0;
            background: linear-gradient(135deg, #0b0f19 0%, #161b22 100%);
            text-align: center;
        }
        .hero-title {
            font-weight: 700;
            color: #ff6600;
            text-shadow: 0 0 20px rgba(255, 102, 0, 0.5);
        }
        .card-plan {
            background: #121824;
            border: 2px solid #ff6600;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(255, 102, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-plan:hover {
            transform: translateY(-8px);
            box-shadow: 0 0 30px rgba(192, 192, 192, 0.4);
            border-color: #c0c0c0;
        }
        .btn-neon-orange {
            background-color: #ff6600;
            color: #0b0f19;
            font-weight: 700;
            border-radius: 50px;
            padding: 12px 30px;
            box-shadow: 0 0 20px rgba(255, 102, 0, 0.6);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-neon-orange:hover {
            background-color: #c0c0c0;
            color: #0b0f19;
            box-shadow: 0 0 30px rgba(192, 192, 192, 0.9);
        }
        .btn-neon-silver {
            background-color: #c0c0c0;
            color: #0b0f19;
            font-weight: 700;
            border-radius: 50px;
            padding: 12px 30px;
            box-shadow: 0 0 20px rgba(192, 192, 192, 0.5);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-neon-silver:hover {
            background-color: #ff6600;
            color: #0b0f19;
            box-shadow: 0 0 30px rgba(255, 102, 0, 0.9);
        }
        footer {
            background-color: #070a0f;
            padding: 40px 0;
            text-align: center;
            border-top: 1px solid #ff6600;
            color: #c0c0c0;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="logo-em" href="#">
                <span class="logo-e-orange">[</span><span class="logo-e-orange">E</span><span class="logo-m-silver">M</span><span class="logo-e-orange">]</span> <span class="logo-digital">Digital</span> <span class="logo-v-orange">V</span><span class="logo-e-silver">E</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#planes">Planes</a></li>
                    <li class="nav-item"><a class="nav-link" href="#demos">Demos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
                    <li class="nav-item ms-3">
                        <a href="admin_login.php" class="btn btn-outline-light btn-sm px-3" style="border-color: #c0c0c0; color: #c0c0c0;">
                            <i class="fas fa-lock"></i> Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header id="inicio" class="hero-section">
        <div class="container">
            <h1 class="hero-title display-4 mb-3">Impulsa tu Presencia en la Web</h1>
            <p class="lead mb-4 text-light" style="max-width: 700px; margin: 0 auto;">Páginas web profesionales, rápidas y adaptadas al mercado venezolano con especificaciones fiscales y legales.</p>
            
            <div class="mb-4">
                <p class="text-secondary fs-5">Cobertura en los municipios Sotillo, Bolívar, Guanta y Urbaneja (Zona norte del estado Anzoátegui).</p>
            </div>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="https://wa.me/<?php echo $telefono_ws; ?>?text=Hola,%20quiero%20información%20sobre%20sus%20servicios%20web" target="_blank" class="btn btn-neon-orange">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
                <a href="<?php echo $instagram; ?>" target="_blank" class="btn btn-neon-silver">
                    <i class="fab fa-instagram"></i> Instagram
                </a>
            </div>
        </div>
    </header>

    <section id="planes" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold" style="color: #ff6600; text-shadow: 0 0 15px rgba(255,102,0,0.4);">Nuestros Planes</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card card-plan p-4 h-100">
                        <h3 class="fw-bold mb-3" style="color: #ff6600;">Emprendedor</h3>
                        <p class="text-secondary">Para pequeños negocios que inician.</p>
                        <ul class="list-unstyled mb-4 text-secondary">
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Diseño responsivo</li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Enlaces directos</li>
                        </ul>
                        <a href="https://wa.me/<?php echo $telefono_ws; ?>?text=Quiero%20el%20Plan%20Emprendedor" target="_blank" class="btn btn-neon-orange mt-auto text-center">¡Lo quiero!</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-plan p-4 h-100" style="border-color: #c0c0c0;">
                        <h3 class="fw-bold mb-3" style="color: #c0c0c0;">Negocio</h3>
                        <p class="text-secondary">Para marcas consolidadas.</p>
                        <ul class="list-unstyled mb-4 text-secondary">
                            <li class="mb-2"><i class="fas fa-check text-light me-2"></i> Todo lo del emprendedor</li>
                            <li class="mb-2"><i class="fas fa-check text-light me-2"></i> Panel autoadministrable</li>
                        </ul>
                        <a href="https://wa.me/<?php echo $telefono_ws; ?>?text=Quiero%20el%20Plan%20Negocio" target="_blank" class="btn btn-neon-silver mt-auto text-center">¡Lo quiero!</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-plan p-4 h-100">
                        <h3 class="fw-bold mb-3" style="color: #ff6600;">Corporativo</h3>
                        <p class="text-secondary">Solución avanzada para empresas.</p>
                        <ul class="list-unstyled mb-4 text-secondary">
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Diseño a medida</li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Soporte prioritario</li>
                        </ul>
                        <a href="https://wa.me/<?php echo $telefono_ws; ?>?text=Quiero%20el%2520Plan%20Corporativo" target="_blank" class="btn btn-neon-orange mt-auto text-center">¡Lo quiero!</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="demos" class="py-5" style="background-color: #0e131f;">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold" style="color: #ff6600; text-shadow: 0 0 15px rgba(255,102,0,0.4);">Demos</h2>
            <?php if (!empty($demos)): ?>
                <div class="row g-4">
                    <?php foreach ($demos as $demo): ?>
                        <div class="col-md-4">
                            <div class="card card-plan p-4 h-100">
                                <h4 class="fw-bold mb-2" style="color: #ff6600;"><?php echo htmlspecialchars($demo['titulo']); ?></h4>
                                <p class="text-secondary"><?php echo htmlspecialchars($demo['descripcion']); ?></p>
                                <a href="<?php echo htmlspecialchars($demo['enlace']); ?>" target="_blank" class="btn btn-neon-silver mt-auto text-center">Ver Demo</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center text-secondary py-4">
                    <p>Próximamente se cargarán las demos oficiales desde el panel de administración.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer id="contacto">
        <div class="container">
            <p class="mb-2">© 2026 EM Digital VE. Todos los derechos reservados.</p>
            <p class="mb-0">
                Instagram: <a href="<?php echo $instagram; ?>" target="_blank" style="color: #ff6600; text-decoration: none; font-weight: 600;">@EM.digital.ve</a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>