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
    <title>EM Digital VE - Eliezer Morales</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #07090f;
            color: #c0c0c0;
            background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 30px 30px;
        }
        
        /* Navbar */
        .navbar {
            background-color: #07090f;
            border-bottom: 1px solid #1e1e2f;
            padding: 15px 0;
        }
        .brand-logo {
            font-weight: 700;
            text-decoration: none;
            font-size: 1.1rem;
            letter-spacing: 1px;
        }
        .brand-brackets { color: #ff3300; text-shadow: 0 0 8px rgba(255,51,0,0.6); }
        .brand-e { color: #ff3300; text-shadow: 0 0 8px rgba(255,51,0,0.6); }
        .brand-m { color: #c0c0c0; text-shadow: 0 0 8px rgba(192,192,192,0.6); }
        .brand-name { color: #ffffff; font-weight: 600; margin-left: 8px; }
        .brand-sub { display: block; font-size: 0.6rem; color: #ff3300; letter-spacing: 2px; }

        .navbar-nav .nav-link {
            color: #c0c0c0 !important;
            font-weight: 500;
            font-size: 0.95rem;
            margin: 0 8px;
            transition: color 0.3s;
        }
        .navbar-nav .nav-link:hover {
            color: #ff3300 !important;
            text-shadow: 0 0 8px rgba(255,51,0,0.6);
        }
        .btn-agregar-demo {
            border: 1px solid #ff3300;
            color: #ff3300;
            background: transparent;
            border-radius: 6px;
            padding: 6px 15px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-agregar-demo:hover {
            background: #ff3300;
            color: #ffffff;
            box-shadow: 0 0 12px rgba(255,51,0,0.6);
        }

        /* Hero Section */
        .hero-section {
            padding: 80px 0 50px 0;
            text-align: center;
        }
        .badge-cobertura {
            display: inline-block;
            border: 1px solid #1e2e3d;
            background: #0d1424;
            color: #a0aec0;
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.85rem;
            margin-bottom: 30px;
        }
        .badge-cobertura span {
            color: #ff3300;
            margin-right: 5px;
        }
        .hero-title {
            font-weight: 800;
            font-size: 2.8rem;
            color: #ffffff;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }
        .hero-title-sub {
            font-weight: 800;
            font-size: 2.5rem;
            color: #ff3300;
            text-shadow: 0 0 15px rgba(255,51,0,0.5);
            margin-bottom: 25px;
            letter-spacing: 1px;
        }
        .hero-desc {
            color: #9ca3af;
            max-width: 650px;
            margin: 0 auto 35px auto;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Botones Principales */
        .btn-main-whatsapp {
            background-color: #00f3ff;
            color: #07090f;
            font-weight: 700;
            border: none;
            border-radius: 6px;
            padding: 12px 25px;
            font-size: 0.9rem;
            box-shadow: 0 0 15px rgba(0,243,255,0.4);
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-main-whatsapp:hover {
            background-color: #ffffff;
            box-shadow: 0 0 20px rgba(255,255,255,0.7);
            color: #07090f;
        }
        .btn-main-instagram {
            background: transparent;
            border: 1px solid #ff3300;
            color: #ffffff;
            font-weight: 600;
            border-radius: 6px;
            padding: 12px 25px;
            font-size: 0.9rem;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-main-instagram:hover {
            border-color: #ffffff;
            color: #ff3300;
            box-shadow: 0 0 12px rgba(255,51,0,0.5);
        }
        .link-ver-demos {
            color: #a0aec0;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s;
            display: inline-flex;
            align-items: center;
        }
        .link-ver-demos:hover {
            color: #ff3300;
        }

        /* Secciones y Tarjetas */
        .section-header-tag {
            color: #ff3300;
            font-size: 0.8rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 10px;
            display: block;
            font-weight: 600;
        }
        .section-title {
            text-align: center;
            font-weight: 700;
            font-size: 2.2rem;
            color: #ffffff;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }
        .section-desc {
            text-align: center;
            color: #9ca3af;
            font-size: 0.9rem;
            margin-bottom: 50px;
        }

        .card-custom {
            background: #0d121e;
            border: 1px solid #1a233a;
            border-radius: 10px;
            padding: 30px;
            height: 100%;
            transition: all 0.3s;
        }
        .card-custom:hover {
            border-color: #ff3300;
            box-shadow: 0 0 20px rgba(255,51,0,0.15);
        }
        .card-custom-popular {
            border: 1px solid #ff3300;
            box-shadow: 0 0 15px rgba(255,51,0,0.1);
        }

        .badge-plan {
            background: #00f3ff;
            color: #07090f;
            font-weight: 700;
            font-size: 0.7rem;
            padding: 4px 12px;
            border-radius: 4px;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 20px;
        }
        .badge-plan-popular {
            background: #ff3300;
            color: #ffffff;
        }

        .price-tag {
            font-size: 1.6rem;
            font-weight: 700;
            color: #ffffff;
            margin: 15px 0 20px 0;
        }
        .price-tag span {
            font-size: 0.9rem;
            color: #9ca3af;
            font-weight: 400;
        }

        .btn-plan {
            background: transparent;
            border: 1px solid #00f3ff;
            color: #00f3ff;
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: all 0.3s;
            margin-top: 25px;
        }
        .btn-plan:hover {
            background: #00f3ff;
            color: #07090f;
            box-shadow: 0 0 12px rgba(0,243,255,0.5);
        }
        .btn-plan-popular {
            border-color: #ff3300;
            color: #ff3300;
        }
        .btn-plan-popular:hover {
            background: #ff3300;
            color: #ffffff;
            box-shadow: 0 0 12px rgba(255,51,0,0.6);
        }

        /* Formulario Contacto */
        .contact-box {
            background: #0d121e;
            border: 1px solid #1a233a;
            border-radius: 10px;
            padding: 40px;
            max-width: 750px;
            margin: 0 auto;
        }
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
        .btn-enviar {
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
        .btn-enviar:hover {
            background-color: #ff4500;
            box-shadow: 0 0 20px rgba(255,51,0,0.7);
        }
        
        footer {
            padding: 40px 0;
            text-align: center;
            border-top: 1px solid #1a233a;
            margin-top: 80px;
            color: #6b7280;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="brand-logo d-flex align-items-center" href="#">
                <div>
                    <span class="brand-brackets">{</span><span class="brand-e">E</span><span class="brand-m">M</span><span class="brand-brackets">}</span>
                </div>
                <div class="ms-2">
                    <span class="brand-name">ELIEZER MORALES</span>
                    <span class="brand-sub">WEB DEVELOPER</span>
                </div>
            </a>
            <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#demos">Demos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#servicios">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="#planes">Planes</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <a href="admin_login.php" class="btn-agregar-demo">+ AGREGAR DEMO</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="inicio" class="hero-section" style="margin-top: 70px;">
        <div class="container">
            <div class="badge-cobertura">
                <span>●</span> Cobertura Norte Anzoátegui: Barcelona - Puerto La Cruz - Lechería
            </div>
            <h1 class="hero-title">DESARROLLO WEB</h1>
            <h2 class="hero-title-sub">&amp; SOLUCIONES DIGITALES</h2>
            <p class="hero-desc">Desarrollo de páginas web profesionales, sistemas a la medida y catálogos digitales para potenciar negocios locales y emprendimientos.</p>
            
            <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap mb-4">
                <a href="https://wa.me/<?php echo $telefono_ws; ?>?text=Hola,%20quiero%20más%20información%20sobre%20sus%20servicios" target="_blank" class="btn-main-whatsapp">
                    WHATSAPP DIRECTO
                </a>
                <a href="<?php echo $instagram; ?>" target="_blank" class="btn-main-instagram">
                    INSTAGRAM
                </a>
                <a href="#demos" class="link-ver-demos ms-2">
                    Ver Demos <i class="fas fa-arrow-right ms-1" style="font-size: 0.8rem;"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Demos Section -->
    <section id="demos" class="py-5">
        <div class="container">
            <span class="section-header-tag">// PROYECTOS DESTACADOS</span>
            <h2 class="section-title">DEMOS EN VIVO</h2>
            <p class="section-desc">Explora soluciones reales diseñadas para potenciar ventas y presencia digital.</p>
            
            <div class="row g-4">
                <?php if (!empty($demos)): ?>
                    <?php foreach ($demos as $demo): ?>
                        <div class="col-md-4">
                            <div class="card-custom d-flex flex-column">
                                <span class="badge-plan mb-3" style="width: fit-content;"><?php echo htmlspecialchars($demo['categoria'] ?? 'SISTEMA WEB'); ?></span>
                                <h4 class="fw-bold mb-3 text-white" style="font-size: 1.2rem;"><?php echo htmlspecialchars($demo['titulo']); ?></h4>
                                <p class="text-secondary flex-grow-1" style="font-size: 0.85rem;"><?php echo htmlspecialchars($demo['descripcion']); ?></p>
                                <a href="<?php echo htmlspecialchars($demo['enlace']); ?>" target="_blank" class="btn-plan mt-3">Ver Demo</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-md-4">
                        <div class="card-custom">
                            <span class="badge-plan mb-3">SISTEMA WEB</span>
                            <h4 class="fw-bold mb-3 text-white" style="font-size: 1.2rem;">E-Commerce Futurista</h4>
                            <p class="text-secondary" style="font-size: 0.85rem;">Tienda virtual interactiva con carrito dinámico, pasarela de pagos y diseño ultra rápido.</p>
                            <a href="#" class="btn-plan mt-3">Ver Demo</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-custom">
                            <span class="badge-plan mb-3">LANDING PAGE</span>
                            <h4 class="fw-bold mb-3 text-white" style="font-size: 1.2rem;">Plataforma Corporativa</h4>
                            <p class="text-secondary" style="font-size: 0.85rem;">Sitio corporativo optimizado para conversión, captación de clientes y presencia de marca.</p>
                            <a href="#" class="btn-plan mt-3">Ver Demo</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-custom">
                            <span class="badge-plan mb-3">PANEL / DASHBOARD</span>
                            <h4 class="fw-bold mb-3 text-white" style="font-size: 1.2rem;">Gestionador de Negocio</h4>
                            <p class="text-secondary" style="font-size: 0.85rem;">Panel de control administrativo para métricas en tiempo real y gestión de inventario.</p>
                            <a href="#" class="btn-plan mt-3">Ver Demo</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Planes Section -->
    <section id="planes" class="py-5">
        <div class="container">
            <span class="section-header-tag">// INVERSIÓN Y PLANES</span>
            <h2 class="section-title">TARIFAS Y SERVICIOS</h2>
            <p class="section-desc">Opciones claras y adaptadas al alcance de tu negocio o emprendimiento.</p>
            
            <div class="row g-4 align-items-stretch">
                <!-- Plan 1 -->
                <div class="col-md-4">
                    <div class="card-custom d-flex flex-column">
                        <span class="badge-plan">INICIAL</span>
                        <h3 class="fw-bold text-white mb-2" style="font-size: 1.3rem;">Landing Emprendedor</h3>
                        <p class="text-secondary" style="font-size: 0.85rem;">Ideal para presencia rápida y directa en Google y redes sociales.</p>
                        <div class="price-tag">80$ - 130$ <span>/ proyecto</span></div>
                        <ul class="list-unstyled text-secondary mb-4" style="font-size: 0.85rem;">
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i> Diseño Responsive (Móvil / PC)</li>
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i> Botones directos a WhatsApp</li>
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i> Ubicación Google Maps</li>
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i> Carga Ultra Rápida</li>
                        </ul>
                        <a href="https://wa.me/<?php echo $telefono_ws; ?>?text=Hola,%20estoy%20interesado%20en%20el%20Plan%20Landing%20Emprendedor" target="_blank" class="btn-plan mt-auto">CONSULTAR PLAN</a>
                    </div>
                </div>

                <!-- Plan 2 -->
                <div class="col-md-4">
                    <div class="card-custom card-custom-popular d-flex flex-column">
                        <span class="badge-plan badge-plan-popular">MÁS POPULAR</span>
                        <h3 class="fw-bold text-white mb-2" style="font-size: 1.3rem;">Catálogo / Negocios</h3>
                        <p class="text-secondary" style="font-size: 0.85rem;">Perfecto para ventas de repuestos, tiendas locales y servicios.</p>
                        <div class="price-tag">150$ - 230$ <span>/ proyecto</span></div>
                        <ul class="list-unstyled text-secondary mb-4" style="font-size: 0.85rem;">
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Todo lo del plan Inicial</li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Catálogo interactivo de productos</li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Buscador y filtros por categoría</li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Pedidos automáticos al WhatsApp</li>
                        </ul>
                        <a href="https://wa.me/<?php echo $telefono_ws; ?>?text=Hola,%20estoy%20interesado%20en%20el%20Plan%20Catálogo%20/%20Negocios" target="_blank" class="btn-plan btn-plan-popular mt-auto">CONSULTAR PLAN</a>
                    </div>
                </div>

                <!-- Plan 3 -->
                <div class="col-md-4">
                    <div class="card-custom d-flex flex-column">
                        <span class="badge-plan">AVANZADO</span>
                        <h3 class="fw-bold text-white mb-2" style="font-size: 1.3rem;">Sistema a Medida</h3>
                        <p class="text-secondary" style="font-size: 0.85rem;">Desarrollos complejos con paneles administrativos e inventario.</p>
                        <div class="price-tag">Desde 300$ <span>/ proyecto</span></div>
                        <ul class="list-unstyled text-secondary mb-4" style="font-size: 0.85rem;">
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i> Panel de Control / Dashboard</li>
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i> Gestión de datos local o en nube</li>
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i> Módulos personalizados</li>
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i> Soporte técnico directo</li>
                        </ul>
                        <a href="https://wa.me/<?php echo $telefono_ws; ?>?text=Hola,%20estoy%20interesado%20en%20el%20Plan%20Sistema%20a%20Medida" target="_blank" class="btn-plan mt-auto">CONSULTAR PLAN</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Servicios Anchor (Sección extra si la piden en el menú) -->
    <div id="servicios"></div>

    <!-- Contacto Section -->
    <section id="contacto" class="py-5">
        <div class="container">
            <span class="section-header-tag">// COMUNICACIÓN DIRECTA</span>
            <h2 class="section-title">SUGERENCIAS &amp; CONTACTO</h2>
            <p class="section-desc">¿Tienes un proyecto en mente o alguna pregunta? Escríbenos directamente.</p>
            
            <div class="contact-box">
                <form action="procesar_contacto.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nombre / Empresa</label>
                        <input type="text" class="form-control form-control-custom" placeholder="Ej: Repuestos El Pana" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">WhatsApp o Correo</label>
                        <input type="text" class="form-control form-control-custom" placeholder="Ej: 0412-1234567" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Mensaje / Sugerencia</label>
                        <textarea class="form-control form-control-custom" rows="4" placeholder="Cuéntame sobre tu proyecto..." required></textarea>
                    </div>
                    <button type="submit" class="btn-enviar">ENVIAR MENSAJE</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p class="mb-1">© 2026 EM Digital VE - Eliezer Morales. Todos los derechos reservados.</p>
            <p class="mb-0">
                <a href="<?php echo $instagram; ?>" target="_blank" style="color: #ff3300; text-decoration: none;">@EM.digital.ve</a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>