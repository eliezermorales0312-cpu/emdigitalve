<?php
// Incluimos la conexión a la base de datos
require_once 'conexion.php';

// Cargar configuración de contacto desde la BD
$config = [];
try {
    $stmt = $pdo->query("SELECT clave, valor FROM configuracion");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $config[$row['clave']] = $row['valor'];
    }
} catch (PDOException $e) {
    // Si hay error, valores por defecto
}

// Datos por defecto si no existen en la BD aún
$telefono_ws = isset($config['telefono_whatsapp']) && !empty($config['telefono_whatsapp']) 
    ? $config['telefono_whatsapp'] 
    : '04223770933';

$instagram = isset($config['instagram_url']) && !empty($config['instagram_url']) 
    ? $config['instagram_url'] 
    : 'https://instagram.com/EM.digital.ve';

// Cargar demos desde la BD
$demos = [];
try {
    $stmtDemos = $pdo->query("SELECT * FROM demos ORDER BY id DESC");
    $demos = $stmtDemos->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $demos = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EM Digital VE - Desarrollo Web & Soluciones Digitales</title>
    <!-- Tailwind CSS desde CDN para estilos modernos -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome para Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --neon-orange: #FF5500;
            --neon-orange-glow: rgba(255, 85, 0, 0.4);
            --silver-neon: #E2E8F0;
            --silver-glow: rgba(226, 232, 240, 0.3);
            --dark-bg: #0B0F17;
            --card-bg: #111827;
        }

        body {
            background-color: var(--dark-bg);
            color: #F1F5F9;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .border-neon-orange { border-color: var(--neon-orange); }
        .text-neon-orange { color: var(--neon-orange); }
        .bg-neon-orange { background-color: var(--neon-orange); }

        .glow-orange {
            box-shadow: 0 0 20px var(--neon-orange-glow);
        }
        
        .glow-orange-text {
            text-shadow: 0 0 10px var(--neon-orange-glow);
        }

        .glow-silver {
            box-shadow: 0 0 15px var(--silver-glow);
        }

        .card-cyber {
            background: rgba(17, 24, 39, 0.8);
            border: 1px solid rgba(255, 85, 0, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .card-cyber:hover {
            border-color: var(--neon-orange);
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px var(--neon-orange-glow);
        }

        .silver-card {
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border: 1px solid rgba(226, 232, 240, 0.2);
        }

        .silver-card:hover {
            border-color: var(--silver-neon);
            box-shadow: 0 0 20px var(--silver-glow);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between">

    <!-- BARRA DE NAVEGACIÓN -->
    <nav class="sticky top-0 z-50 bg-gray-900/90 backdrop-blur-md border-b border-orange-600/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-lg bg-orange-600 flex items-center justify-center text-black font-black text-2xl shadow-lg shadow-orange-600/50">
                    EM
                </div>
                <span class="text-2xl font-extrabold tracking-wider text-white">
                    DIGITAL<span class="text-neon-orange glow-orange-text">.VE</span>
                </span>
            </div>

            <div class="hidden md:flex items-center space-x-8 text-sm font-semibold text-gray-300">
                <a href="#cobertura" class="hover:text-neon-orange transition-colors">Cobertura</a>
                <a href="#planes" class="hover:text-neon-orange transition-colors">Planes</a>
                <a href="#demos" class="hover:text-neon-orange transition-colors">Demos</a>
                <a href="#contacto" class="hover:text-neon-orange transition-colors">Contacto</a>
            </div>

            <div>
                <a href="admin_login.php" class="px-5 py-2.5 rounded-lg border border-neon-orange text-neon-orange font-bold text-sm hover:bg-neon-orange hover:text-black transition-all duration-300 glow-orange">
                    <i class="fa-solid fa-lock mr-2"></i>Acceso Admin
                </a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="relative py-20 px-4 max-w-7xl mx-auto text-center">
        <div class="inline-block px-4 py-1.5 rounded-full border border-orange-500/30 bg-orange-500/10 text-orange-400 font-semibold text-xs tracking-widest uppercase mb-6">
            <i class="fa-solid fa-bolt mr-2"></i>Desarrollo Web Profesional en Anzoátegui
        </div>
        <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight leading-tight mb-6">
            Lleva tu Negocio al Siguiente Nivel <br/>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 via-amber-400 to-slate-200">
                Con Tecnologías Neón de Alta Eficiencia
            </span>
        </h1>
        <p class="max-w-2xl mx-auto text-gray-400 text-base md:text-lg mb-8">
            Diseño, desarrollo y optimización de sitios web modernos, rápidos y adaptados a tu negocio.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="https://wa.me/58<?= preg_replace('/[^0-9]/', '', $telefono_ws) ?>?text=Hola,%20quisiera%20informaci%C3%B3n%20sobre%20sus%20servicios%20web" 
               target="_blank"
               class="px-8 py-4 bg-neon-orange text-black font-black text-base rounded-xl hover:bg-orange-600 transition-all shadow-lg shadow-orange-600/40 flex items-center justify-center gap-2">
                <i class="fa-brands fa-whatsapp text-xl"></i> WhatsApp
            </a>
            <a href="<?= htmlspecialchars($instagram) ?>" 
               target="_blank"
               class="px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-black text-base rounded-xl hover:opacity-90 transition-all shadow-lg shadow-pink-600/30 flex items-center justify-center gap-2">
                <i class="fa-brands fa-instagram text-xl"></i> Instagram
            </a>
            <a href="#demos" class="px-8 py-4 bg-gray-800 text-slate-200 font-bold text-base rounded-xl border border-gray-700 hover:border-slate-300 transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-laptop-code"></i> Ver Demos
            </a>
        </div>
    </section>

    <!-- SECCIÓN COBERTURA -->
    <section id="cobertura" class="py-16 bg-gray-900/50 border-y border-gray-800">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold text-white mb-2">Zona de Cobertura Principal</h2>
            <p class="text-gray-400 mb-10">Atención presencial y personalizada en el Estado Anzoátegui</p>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="card-cyber p-6 rounded-2xl text-center">
                    <i class="fa-solid fa-location-dot text-3xl text-neon-orange mb-3"></i>
                    <h3 class="font-bold text-lg text-white">Puerto La Cruz</h3>
                    <p class="text-xs text-gray-400 mt-1">Soporte y atención local</p>
                </div>
                <div class="card-cyber p-6 rounded-2xl text-center">
                    <i class="fa-solid fa-location-dot text-3xl text-neon-orange mb-3"></i>
                    <h3 class="font-bold text-lg text-white">Guanta</h3>
                    <p class="text-xs text-gray-400 mt-1">Atención rápida y directa</p>
                </div>
                <div class="card-cyber p-6 rounded-2xl text-center">
                    <i class="fa-solid fa-location-dot text-3xl text-neon-orange mb-3"></i>
                    <h3 class="font-bold text-lg text-white">Lechería</h3>
                    <p class="text-xs text-gray-400 mt-1">Desarrollo a medida</p>
                </div>
                <div class="card-cyber p-6 rounded-2xl text-center">
                    <i class="fa-solid fa-location-dot text-3xl text-neon-orange mb-3"></i>
                    <h3 class="font-bold text-lg text-white">Barcelona</h3>
                    <p class="text-xs text-gray-400 mt-1">Proyectos corporativos</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PLANES DE SERVICIO -->
    <section id="planes" class="py-20 max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">Nuestros Planes Web</h2>
            <p class="text-gray-400">Escoge el paquete ideal para impulsar tu marca hoy mismo</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Plan Emprendedor -->
            <div class="card-cyber rounded-2xl p-8 flex flex-col justify-between">
                <div>
                    <div class="text-neon-orange font-bold text-sm tracking-widest uppercase mb-2">Plan Inicial</div>
                    <h3 class="text-2xl font-extrabold text-white mb-4">Emprendedor</h3>
                    <div class="text-3xl font-black text-white mb-6">$80 - $120 <span class="text-sm font-normal text-gray-400">/ según requerimientos</span></div>
                    <ul class="space-y-3 text-sm text-gray-300 mb-8">
                        <li class="flex items-center"><i class="fa-solid fa-check text-neon-orange mr-2"></i> Landing Page de 1 Sección</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-neon-orange mr-2"></i> Diseño 100% Responsivo</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-neon-orange mr-2"></i> Botón Directo a WhatsApp</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-neon-orange mr-2"></i> Enlaces a Redes Sociales</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-neon-orange mr-2"></i> Opción de Facturación Legal</li>
                    </ul>
                </div>
                <a href="https://wa.me/58<?= preg_replace('/[^0-9]/', '', $telefono_ws) ?>?text=Hola,%20me%20interesa%20el%20Plan%20Emprendedor" target="_blank" class="w-full py-3 bg-orange-500/20 text-neon-orange font-bold text-center rounded-xl border border-neon-orange hover:bg-neon-orange hover:text-black transition-all">
                    Solicitar Plan
                </a>
            </div>

            <!-- Plan PyME / Negocio -->
            <div class="silver-card rounded-2xl p-8 flex flex-col justify-between relative transform md:-translate-y-4">
                <div class="absolute -top-4 right-6 bg-slate-200 text-black font-black text-xs px-3 py-1 rounded-full uppercase">
                    Más Popular
                </div>
                <div>
                    <div class="text-slate-300 font-bold text-sm tracking-widest uppercase mb-2">Plan Recomendado</div>
                    <h3 class="text-2xl font-extrabold text-white mb-4">PyME / Negocio</h3>
                    <div class="text-3xl font-black text-white mb-6">$150 - $220 <span class="text-sm font-normal text-gray-400">/ según requerimientos</span></div>
                    <ul class="space-y-3 text-sm text-gray-300 mb-8">
                        <li class="flex items-center"><i class="fa-solid fa-check text-slate-300 mr-2"></i> Sitio Web Multi-sección (Hasta 5)</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-slate-300 mr-2"></i> Catálogo de Productos / Servicios</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-slate-300 mr-2"></i> Optimización SEO Básica</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-slate-300 mr-2"></i> Integración con Google Maps</li>
                        <li class="flex items-center font-semibold text-white"><i class="fa-solid fa-check text-slate-300 mr-2"></i> Incluye Factura Fiscal / SENIAT</li>
                    </ul>
                </div>
                <a href="https://wa.me/58<?= preg_replace('/[^0-9]/', '', $telefono_ws) ?>?text=Hola,%20me%20interesa%20el%20Plan%20PyME" target="_blank" class="w-full py-3 bg-slate-200 text-black font-extrabold text-center rounded-xl hover:bg-white transition-all shadow-lg shadow-slate-200/20">
                    Solicitar Plan
                </a>
            </div>

            <!-- Plan Corporativo -->
            <div class="card-cyber rounded-2xl p-8 flex flex-col justify-between">
                <div>
                    <div class="text-neon-orange font-bold text-sm tracking-widest uppercase mb-2">Plan Avanzado</div>
                    <h3 class="text-2xl font-extrabold text-white mb-4">Corporativo</h3>
                    <div class="text-3xl font-black text-white mb-6">$300+ <span class="text-sm font-normal text-gray-400">/ cotización a medida</span></div>
                    <ul class="space-y-3 text-sm text-gray-300 mb-8">
                        <li class="flex items-center"><i class="fa-solid fa-check text-neon-orange mr-2"></i> Sistema Web a la Medida</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-neon-orange mr-2"></i> Panel Admin Autoadministrable</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-neon-orange mr-2"></i> Base de Datos Integrada</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-neon-orange mr-2"></i> Autenticación y Seguridad</li>
                        <li class="flex items-center font-semibold text-white"><i class="fa-solid fa-check text-neon-orange mr-2"></i> Facturación Jurídica / SENIAT</li>
                    </ul>
                </div>
                <a href="https://wa.me/58<?= preg_replace('/[^0-9]/', '', $telefono_ws) ?>?text=Hola,%20me%20interesa%20el%20Plan%20Corporativo" target="_blank" class="w-full py-3 bg-orange-500/20 text-neon-orange font-bold text-center rounded-xl border border-neon-orange hover:bg-neon-orange hover:text-black transition-all">
                    Solicitar Plan
                </a>
            </div>
        </div>
    </section>

    <!-- SECCIÓN DEMOS -->
    <section id="demos" class="py-20 bg-gray-900/40 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-black text-white mb-3">Nuestras Demos & Proyectos</h2>
                <p class="text-gray-400">Explora algunos ejemplos del trabajo que podemos hacer para tu empresa</p>
            </div>

            <?php if (empty($demos)): ?>
                <!-- Estado vacío cuando no hay demos cargados en la BD -->
                <div class="card-cyber p-12 text-center rounded-2xl max-w-xl mx-auto">
                    <i class="fa-solid fa-folder-open text-5xl text-gray-600 mb-4"></i>
                    <h3 class="text-xl font-bold text-white mb-2">No hay demos registrados aún</h3>
                    <p class="text-gray-400 text-sm mb-6">Inicia sesión en el panel de administración para comenzar a publicar tus proyectos.</p>
                    <a href="admin_login.php" class="px-6 py-2.5 bg-neon-orange text-black font-bold text-sm rounded-lg hover:bg-orange-600 transition-all">
                        Ir al Admin para Agregar Demos
                    </a>
                </div>
            <?php else: ?>
                <!-- Grid de Demos traídos desde la Base de Datos -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($demos as $demo): ?>
                        <div class="card-cyber rounded-2xl overflow-hidden flex flex-col justify-between">
                            <div>
                                <div class="h-48 bg-gray-800 relative overflow-hidden flex items-center justify-center">
                                    <?php if (!empty($demo['imagen'])): ?>
                                        <img src="<?= htmlspecialchars($demo['imagen']) ?>" alt="<?= htmlspecialchars($demo['titulo']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <i class="fa-solid fa-laptop-code text-5xl text-gray-600"></i>
                                    <?php endif; ?>
                                    <span class="absolute top-3 right-3 bg-black/80 text-neon-orange border border-neon-orange/40 text-xs font-bold px-2.5 py-1 rounded-md">
                                        <?= htmlspecialchars($demo['categoria'] ?? 'Proyecto') ?>
                                    </span>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-white mb-2"><?= htmlspecialchars($demo['titulo']) ?></h3>
                                    <p class="text-gray-400 text-sm mb-4">
                                        <?= htmlspecialchars($demo['descripcion'] ?? 'Demo funcional interactiva lista para personalizar.') ?>
                                    </p>
                                </div>
                            </div>
                            <div class="p-6 pt-0">
                                <a href="<?= htmlspecialchars($demo['url_demo']) ?>" target="_blank" class="w-full block text-center py-2.5 bg-gray-800 text-slate-200 font-bold rounded-xl border border-gray-700 hover:border-orange-500 hover:text-neon-orange transition-all">
                                    <i class="fa-solid fa-arrow-up-right-from-square mr-2"></i>Ver Demo En Vivo
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- FOOTER / CONTACTO -->
    <footer id="contacto" class="bg-gray-950 border-t border-gray-800 py-12 text-gray-400 text-sm">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div>
                <span class="text-xl font-extrabold text-white tracking-wider block mb-3">
                    EM DIGITAL<span class="text-neon-orange">.VE</span>
                </span>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Soluciones digitales profesionales, desarrollo de software web y portales de alta respuesta en Anzoátegui.
                </p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-3 uppercase tracking-wider text-xs">Contacto Directo</h4>
                <p class="mb-2"><i class="fa-brands fa-whatsapp text-neon-orange mr-2"></i> WhatsApp: <a href="https://wa.me/58<?= preg_replace('/[^0-9]/', '', $telefono_ws) ?>" class="text-white hover:underline"><?= htmlspecialchars($telefono_ws) ?></a></p>
                <p><i class="fa-brands fa-instagram text-neon-orange mr-2"></i> Instagram: <a href="<?= htmlspecialchars($instagram) ?>" target="_blank" class="text-white hover:underline">@EM.digital.ve</a></p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-3 uppercase tracking-wider text-xs">Ubicación</h4>
                <p class="text-xs text-gray-400 leading-relaxed">
                    <i class="fa-solid fa-map-pin text-neon-orange mr-2"></i> Cobertura en Puerto La Cruz, Guanta, Lechería y Barcelona, Estado Anzoátegui.
                </p>
            </div>
        </div>
        <div class="border-t border-gray-900 pt-6 text-center text-xs text-gray-600">
            &copy; <?= date('Y') ?> EM Digital VE. Todos los derechos reservados.
        </div>
    </footer>

</body>
</html>