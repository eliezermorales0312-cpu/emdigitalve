<?php
// Incluimos la conexión a la base de datos (con protección anti-caídas para la nube)
require_once 'conexion.php';

// Cargar configuración de contacto por defecto o desde la BD si está disponible
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

// Datos por defecto para que la web luzca completa y profesional en la nube
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
    <title>EM Digital VE - Desarrollo Web y Soluciones Digitales</title>
    <!-- Google Fonts & Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0b0f19;
            color: #f8f9fa;
        }
        .navbar {
            background-color: rgba(11, 15, 25, 0.95);
            backdrop-filter: blur(10px);
        }
        .hero-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #0b0f19 0%, #1a1f2c 100%);
            text-align: center;
        }
        .hero-title {
            font-weight: 700;
            color: #00ffcc;
            text-shadow: 0 0 20px rgba(0, 255, 204, 0.4);
        }
        .card-plan {
            background: #161b22;
            border: 1px solid #30363d;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-plan:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 255, 204, 0.2);
            border-color: #00ffcc;
        }
        .btn-neon {
            background-color: #00ffcc;
            color: #0b0f19;
            font-weight: 600;
            border-radius: 50px;
            padding: 10px 25px;
            box-shadow: 0 0 15px rgba(0, 255, 204, 0.4);
            transition: all 0.3s ease;
        }
        .btn-neon:hover {
            background-color: #fff;
            color: #0b0f19;
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.8);
        }
        footer {
            background-color: #080b11;
            padding: 30px 0;
            text-align: center;
            border-top: 1px solid #21262d;
            color: #8b949e;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#" style="color: #00ffcc;">
                <i class="fas5 fa-code"></i> EM Digital VE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#planes">Planes</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
                    <li class="nav-item ms-3">
                        <a href="admin_login.php" class="btn btn-outline-light btn-sm px-3">
                            <i class="fas fa-lock"></i> Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header id="inicio" class="hero-section">
        <div class="container">
            <h1 class="hero-title display-4 mb-4">Lleva tu Negocio al Siglo Digital</h1>
            <p class="lead text-muted mb-5">Creamos páginas web profesionales, rápidas y adaptadas al mercado venezolano con especificaciones fiscales y legales.</p>
            <a href="https://wa.me/<?php echo $telefono_ws; ?>?text=Hola,%20quiero%20información%20sobre%20sus%20servicios%20web" target="_blank" class="btn btn-neon btn-lg">
                <i class="fab fa-whatsapp"></i> Contáctanos por WhatsApp
            </a>
        </div>
    </header>

    <!-- Planes Section -->
    <section id="planes" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold" style="color: #00ffcc;">Nuestros Planes</h2>
            <div class="row g-4">
                <!-- Plan 1 -->
                <div class="col-md-4">
                    <div class="card card-plan p-4 h-100 text-white">
                        <h3 class="fw-bold mb-3">Emprendedor</h3>
                        <p class="text-muted">Ideal para pequeños negocios que inician en internet.</p>
                        <ul class="list-unstyled mb-4">
                            <li><i class="fas fa-check text-success me-2"></i> Diseño 100% responsivo</li>
                            <li><i class="fas fa-check text-success me-2"></i> Botones de WhatsApp e Instagram</li>
                            <li><i class="fas fa-check text-success me-2"></i> Opción de facturación legal</li>
                        </ul>
                        <a href="https://wa.me/<?php echo $telefono_ws; ?>?text=Quiero%20el%20Plan%20Emprendedor" target="_blank" class="btn btn-neon mt-auto">¡Lo quiero!</a>
                    </div>
                </div>
                <!-- Plan 2 -->
                <div class="col-md-4">
                    <div class="card card-plan p-4 h-100 text-white border-primary" style="border-color: #00ffcc !important;">
                        <h3 class="fw-bold mb-3" style="color: #00ffcc;">Negocio</h3>
                        <p class="text-muted">Para marcas consolidadas que exigen mayor presencia.</p>
                        <ul class="list-unstyled mb-4">
                            <li><i class="fas fa-check text-success me-2"></i> Todo lo del plan emprendedor</li>
                            <li><i class="fas fa-check text-success me-2"></i> Incluye facturas fiscales y SENIAT</li>
                            <li><i class="fas fa-check text-success me-2"></i> Panel autoadministrable</li>
                        </ul>
                        <a href="https://wa.me/<?php echo $telefono_ws; ?>?text=Quiero%20el%20Plan%20Negocio" target="_blank" class="btn btn-neon mt-auto">¡Lo quiero!</a>
                    </div>
                </div>
                <!-- Plan 3 -->
                <div class="col-md-4">
                    <div class="card card-plan p-4 h-100 text-white">
                        <h3 class="fw-bold mb-3">Corporativo</h3>
                        <p class="text-muted">Solución avanzada para empresas de gran envergadura.</p>
                        <ul class="list-unstyled mb-4">
                            <li><i class="fas fa-check text-success me-2"></i> Diseño exclusivo a medida</li>
                            <li><i class="fas fa-check text-success me-2"></i> Facturación jurídica y SENIAT</li>
                            <li><i class="fas fa-check text-success me-2"></i> Soporte técnico prioritario</li>
                        </ul>
                        <a href="https://wa.me/<?php echo $telefono_ws; ?>?text=Quiero%20el%20Plan%20Corporativo" target="_blank" class="btn btn-neon mt-auto">¡Lo quiero!</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contacto">
        <div class="container">
            <p class="mb-2">© 2026 EM Digital VE. Todos los derechos reservados.</p>
            <p>
                Síguenos en Instagram: <a href="<?php echo $instagram; ?>" target="_blank" style="color: #00ffcc; text-decoration: none;">@EM.digital.ve</a>
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>