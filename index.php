<?php
// Conexión segura para Render (si no hay BD en la nube, la web carga igual sin caerse)
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
    <title>EM Digital VE - Desarrollo Web y Soluciones Digitales</title>
    <!-- Google Fonts & Bootstrap -->
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
        .hero-section {
            padding: 120px 0 80px 0;
            background: linear-gradient(135deg, #0b0f19 0%, #161b22 100%);
            text-align: center;
        }
        .hero-title {
            font-weight: 700;
            color: #ff6600;
            text-shadow: 0 0 20px rgba(255, 102, 0, 0.5), 0 0 40px rgba(192, 192, 192, 0.2);
        }
        .hero-subtitle {
            color: #c0c0c0;
            text-shadow: 0 0 10px rgba(192, 192, 192, 0.3);
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
        .card-plan h3 {
            color: #ff6600;
            text-shadow: 0 0 10px rgba(255, 102, 0, 0.4);
        }
        .card-plan p, .card-plan li {
            color: #c0c0c0;
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
        .section-title {
            color: #ff6600;
            text-shadow: 0 0 15px rgba(255, 102, 0, 0.4);
        }
        .municipios-box {
            background: #121824;
            border: 1px solid #c0c0c0;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(192, 192, 192, 0.2);
            color: #c0c0c0;
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

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#" style="color: #ff6600; text-shadow: 0 0 10px rgba(255,102,0,0.5);">
                <i class="fas fa-code"></i> EM Digital VE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link text-light" href="#inicio">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="#municipios">Municipios</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="#planes">Planes</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="#demos">Demos</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="#contacto">Contacto</a></li>
                    <li class="nav-item ms-3">
                        <a href="admin_login.php" class="btn btn-outline-light btn-sm px-3" style="border-color: #c0c0c0; color: #c0c0c0;">
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
            <h1 class="hero-title display-4 mb-3">Lleva tu Negocio al Siglo Digital</h1>
            <p class="hero-subtitle lead mb-4" style="max-width: 700px; margin: 0 auto;">Páginas web profesionales, rápidas y adaptadas al mercado venezolano con especificaciones fiscales y legales.</p>
            <div class="mb-4">
                <span class="badge px-3 py-2 me-2" style="background-color: #ff6600; color: #0b0f19; font-weight: 600;">Teléfono: <?php echo $telefono_ws; ?></span>
                <span class="badge px-3 py-2" style="background-color: #c0c0c0; color: #0b0f19; font-weight: 600;">Cobertura en 4 Municipios</span>
            </div>
            <a href="https://wa.me/<?php echo $telefono_ws; ?>?text=Hola,%20quiero%20información%20sobre%20sus%20servicios%20web" target="_blank" class="btn btn-neon-orange btn-lg">
                <i class="fab fa-whatsapp"></i> Contáctanos por WhatsApp
            </a>
        </div>
    </header>

    <!-- Municipios Section -->
    <section id="municipios" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4 section-title fw-bold">Nuestra Cobertura</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="municipios-box text-center">
                        <p class="mb-0 fs-5">Brindamos soporte y soluciones digitales directas en los <strong>4 Municipios</strong> principales de la zona, garantizando atención personalizada y presencial o digital inmediata.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Planes Section -->
    <section id="planes" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 section-title fw-bold">Nuestros Planes</h2>
            <div class="row g-4">
                <!-- Plan 1 -->
                <div class="col-md-4">
                    <div class="card card-plan p-4 h-100">
                        <h3 class="fw-bold mb-3">Emprendedor</h3>
                        <p>Ideal para pequeños negocios que inician en internet.</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Diseño 100% responsivo</li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Botones de WhatsApp e Instagram</li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Facturación y normas fiscales</li>
                        </ul>
                        <a href="https://wa.me/<?php echo $telefono_ws; ?>?text=Quiero%20el%20Plan%20Emprendedor" target="_blank" class="btn btn-neon-orange mt-auto text-center">¡Lo quiero!</a>
                    </div>
                </div>
                <!-- Plan 2 -->
                <div class="col-md-4">
                    <div class="card card-plan p-4 h-100" style="border-color: #c0c0c0; box-shadow: 0 0 25px rgba(192,192,192,0.2);">
                        <h3 class="fw-bold mb-3" style="color: #c0c0c0; text-shadow: 0 0 10px rgba(192,192,192,0.5);">Negocio</h3>
                        <p>Para marcas consolidadas que exigen mayor presencia y nivel.</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check text-light me-2"></i> Todo lo del plan emprendedor</li>
                            <li class="mb-2"><i class="fas fa-check text-light me-2"></i> Facturas fiscales y adaptadas al SENIAT</li>
                            <li class="mb-2"><i class="fas fa-check text-light me-2"></i> Panel autoadministrable</li>
                        </ul>
                        <a href="https://wa.me/<?php echo $telefono_ws; ?>?text=Quiero%20el%20Plan%20Negocio" target="_blank" class="btn btn-neon-silver mt-auto text-center">¡Lo quiero!</a>
                    </div>
                </div>
                <!-- Plan 3 -->
                <div class="col-md-4">
                    <div class="card card-plan p-4 h-100">
                        <h3 class="fw-bold mb-3">Corporativo</h3>
                        <p>Solución avanzada para empresas de gran envergadura.</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Diseño exclusivo a medida</li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Facturación jurídica y SENIAT</li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Soporte técnico prioritario</li>
                        </ul>
                        <a href="https://wa.me/<?php echo $telefono_ws; ?>?text=Quiero%20el%20Plan%20Corporativo" target="_blank" class="btn btn-neon-orange mt-auto text-center">¡Lo quiero!</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Demos Section -->
    <section id="demos" class="py-5" style="background-color: #0e131f;">
        <div class="container">
            <h2 class="text-center mb-5 section-title fw-bold">Demos Disponibles</h2>
            <?php if (!empty($demos)): ?>
                <div class="row g-4">
                    <?php foreach ($demos as $demo): ?>
                        <div class="col-md-4">
                            <div class="card card-plan p-4 h-100">
                                <h4 class="fw-bold mb-2" style="color: #ff6600;"><?php echo htmlspecialchars($demo['titulo']); ?></h4>
                                <p><?php echo htmlspecialchars($demo['descripcion']); ?></p>
                                <a href="<?php echo htmlspecialchars($demo['enlace']); ?>" target="_blank" class="btn btn-neon-silver mt-auto text-center">Ver Demo</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-plan p-4 h-100">
                            <h4 class="fw-bold mb-2" style="color: #ff6600;">Demo Estética</h4>
                            <p class="text-muted">Plantilla de prueba optimizada para negocios de belleza y cuidado personal.</p>
                            <a href="#" class="btn btn-neon-silver mt-auto text-center">Ver Demo</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-plan p-4 h-100">
                            <h4 class="fw-bold mb-2" style="color: #ff6600;">Demo Delivery</h4>
                            <p class="text-muted">Sistema interactivo para restaurantes y pedidos rápidos.</p>
                            <a href="#" class="btn btn-neon-silver mt-auto text-center">Ver Demo</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-plan p-4 h-100">
                            <h4 class="fw-bold mb-2" style="color: #ff6600;">Demo Comercial</h4>
                            <p class="text-muted">Estructura corporativa para tiendas y servicios profesionales.</p>
                            <a href="#" class="btn btn-neon-silver mt-auto text-center">Ver Demo</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contacto">
        <div class="container">
            <p class="mb-2">© 2026 EM Digital VE. Todos los derechos reservados.</p>
            <p class="mb-0">
                Síguenos en Instagram: <a href="<?php echo $instagram; ?>" target="_blank" style="color: #ff6600; text-decoration: none; font-weight: 600;">@EM.digital.ve</a>
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>