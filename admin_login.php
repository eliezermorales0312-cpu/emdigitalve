<?php
// Iniciamos sesión y conexión
session_start();
require_once 'conexion.php';

$error = '';
$mensaje_exito = '';

// Si ya inició sesión, redirigir al panel o mostrar opciones
// (Para simplificar, unificamos login y panel en este mismo archivo si ya está autenticado)
$autenticado = isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true;

// Procesar Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM administradores WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged'] = true;
            $_SESSION['admin_user'] = $admin['usuario'];
            header("Location: admin_login.php");
            exit;
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } catch (PDOException $e) {
        $error = "Error en el sistema: " . $e->getMessage();
    }
}

// Procesar Cerrar Sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin_login.php");
    exit;
}

// Procesar Actualizar Configuración (Teléfonos / Redes)
if ($autenticado && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_config') {
    $telefono = trim($_POST['telefono_whatsapp']);
    $instagram = trim($_POST['instagram_url']);

    try {
        $stmt = $pdo->prepare("UPDATE configuracion SET valor = ? WHERE clave = 'telefono_whatsapp'");
        $stmt->execute([$telefono]);

        $stmt = $pdo->prepare("UPDATE configuracion SET valor = ? WHERE clave = 'instagram_url'");
        $stmt->execute([$instagram]);

        $mensaje_exito = "¡Configuración actualizada con éxito!";
    } catch (PDOException $e) {
        $error = "Error al actualizar configuración: " . $e->getMessage();
    }
}

// Procesar Agregar Nuevo Demo
if ($autenticado && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_demo') {
    $titulo = trim($_POST['titulo']);
    $categoria = trim($_POST['categoria']);
    $url_demo = trim($_POST['url_demo']);
    $imagen = trim($_POST['imagen']);
    $descripcion = trim($_POST['descripcion']);

    try {
        $stmt = $pdo->prepare("INSERT INTO demos (titulo, categoria, url_demo, imagen, descripcion) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $categoria, $url_demo, $imagen, $descripcion]);
        $mensaje_exito = "¡Demo agregado correctamente!";
    } catch (PDOException $e) {
        $error = "Error al agregar demo: " . $e->getMessage();
    }
}

// Procesar Borrar Demo
if ($autenticado && isset($_GET['delete_demo'])) {
    $id_demo = intval($_GET['delete_demo']);
    try {
        $stmt = $pdo->prepare("DELETE FROM demos WHERE id = ?");
        $stmt->execute([$id_demo]);
        $mensaje_exito = "¡Demo eliminado con éxito!";
    } catch (PDOException $e) {
        $error = "Error al eliminar demo.";
    }
}

// Obtener configuración actual para mostrar en el panel
$config_actual = [];
if ($autenticado) {
    $stmt = $pdo->query("SELECT clave, valor FROM configuracion");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $config_actual[$row['clave']] = $row['valor'];
    }
    // Obtener lista de demos para administrar
    $stmtDemos = $pdo->query("SELECT * FROM demos ORDER BY id DESC");
    $lista_demos = $stmtDemos->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - EM Digital VE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --neon-orange: #FF5500;
            --neon-orange-glow: rgba(255, 85, 0, 0.4);
            --dark-bg: #0B0F17;
        }
        body { background-color: var(--dark-bg); color: #F1F5F9; font-family: 'Segoe UI', system-ui, sans-serif; }
        .text-neon-orange { color: var(--neon-orange); }
        .bg-neon-orange { background-color: var(--neon-orange); }
        .card-cyber {
            background: rgba(17, 24, 39, 0.9);
            border: 1px solid rgba(255, 85, 0, 0.3);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between">

    <!-- NAV ADMIN -->
    <nav class="bg-gray-900 border-b border-orange-600/30 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded bg-orange-600 flex items-center justify-center text-black font-black text-xl">EM</div>
            <span class="text-xl font-bold text-white">Panel <span class="text-neon-orange">Administrador</span></span>
        </div>
        <div class="flex items-center space-x-4">
            <a href="index.php" class="text-sm text-gray-300 hover:text-neon-orange transition-colors"><i class="fa-solid fa-globe mr-1"></i>Ver Sitio Web</a>
            <?php if ($autenticado): ?>
                <a href="admin_login.php?logout=true" class="px-4 py-2 bg-red-600/20 text-red-400 border border-red-500/40 rounded-lg text-sm font-bold hover:bg-red-600 hover:text-white transition-all">
                    <i class="fa-solid fa-right-from-bracket mr-1"></i>Cerrar Sesión
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="max-w-5xl mx-auto px-4 py-12 flex-grow w-full">

        <?php if (!empty($error)): ?>
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500 text-red-300 rounded-xl text-sm flex items-center">
                <i class="fa-solid fa-triangle-exclamation mr-3 text-lg"></i><?= $error ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($mensaje_exito)): ?>
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500 text-green-300 rounded-xl text-sm flex items-center">
                <i class="fa-solid fa-circle-check mr-3 text-lg"></i><?= $mensaje_exito ?>
            </div>
        <?php endif; ?>

        <?php if (!$autenticado): ?>
            <!-- FORMULARIO DE LOGIN -->
            <div class="max-w-md mx-auto card-cyber p-8 rounded-2xl shadow-2xl">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-orange-500/20 border border-neon-orange rounded-full flex items-center justify-center mx-auto mb-4 text-neon-orange text-2xl">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <h2 class="text-2xl font-black text-white">Acceso Restringido</h2>
                    <p class="text-xs text-gray-400 mt-1">Ingresa tus credenciales de administrador</p>
                </div>

                <form action="admin_login.php" method="POST" class="space-y-5">
                    <input type="hidden" name="action" value="login">
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Usuario</label>
                        <input type="text" name="usuario" required class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-orange-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Contraseña</label>
                        <input type="password" name="password" required class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-orange-500 focus:outline-none">
                    </div>
                    <button type="submit" class="w-full py-3.5 bg-neon-orange text-black font-black rounded-xl hover:bg-orange-600 transition-all shadow-lg shadow-orange-600/30">
                        Entrar al Panel
                    </button>
                </form>
                <div class="mt-6 text-center text-xs text-gray-500">
                    Usuario por defecto: <span class="text-gray-300">admin</span> | Clave: <span class="text-gray-300">admin123</span>
                </div>
            </div>

        <?php else: ?>
            <!-- PANEL DE CONTROL AUTENTICADO -->
            <div class="space-y-12">
                <div class="card-cyber p-8 rounded-2xl">
                    <h2 class="text-2xl font-black text-white mb-2">Bienvenido, Administrador</h2>
                    <p class="text-gray-400 text-sm">Desde aquí puedes configurar tus datos de contacto en vivo y gestionar los proyectos o demos de la web.</p>
                </div>

                <!-- SECCIÓN 1: CONFIGURACIÓN DE CONTACTO Y REDES -->
                <div class="card-cyber p-8 rounded-2xl">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                        <i class="fa-solid fa-gear text-neon-orange mr-2"></i> Configuración de Contacto y Redes
                    </h3>
                    <form action="admin_login.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <input type="hidden" name="action" value="update_config">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Número de WhatsApp</label>
                            <input type="text" name="telefono_whatsapp" value="<?= htmlspecialchars($config_actual['telefono_whatsapp'] ?? '04223770933') ?>" required class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-orange-500 focus:outline-none">
                            <span class="text-xs text-gray-500 mt-1 block">Ej: 04223770933</span>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Enlace de Instagram</label>
                            <input type="text" name="instagram_url" value="<?= htmlspecialchars($config_actual['instagram_url'] ?? 'https://instagram.com/EM.digital.ve') ?>" required class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-orange-500 focus:outline-none">
                            <span class="text-xs text-gray-500 mt-1 block">Ej: https://instagram.com/EM.digital.ve</span>
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="px-6 py-3 bg-neon-orange text-black font-bold rounded-xl hover:bg-orange-600 transition-all">
                                Guardar Cambios de Contacto
                            </button>
                        </div>
                    </form>
                </div>

                <!-- SECCIÓN 2: AGREGAR NUEVO DEMO -->
                <div class="card-cyber p-8 rounded-2xl">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                        <i class="fa-solid fa-circle-plus text-neon-orange mr-2"></i> Agregar Nuevo Demo o Proyecto
                    </h3>
                    <form action="admin_login.php" method="POST" class="space-y-4">
                        <input type="hidden" name="action" value="add_demo">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Título del Proyecto</label>
                                <input type="text" name="titulo" placeholder="Ej: Tienda de Ropa Online" required class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:border-orange-500 focus:outline-none text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Categoría</label>
                                <input type="text" name="categoria" placeholder="Ej: E-commerce / Landing" required class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:border-orange-500 focus:outline-none text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-400 mb-2">URL del Demo en Vivo</label>
                                <input type="text" name="url_demo" placeholder="https://tusitio.com/demo1" required class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:border-orange-500 focus:outline-none text-sm">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-400 mb-2">URL de la Imagen (Opcional)</label>
                                <input type="text" name="imagen" placeholder="https://imagen.com/foto.jpg" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:border-orange-500 focus:outline-none text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Breve Descripción</label>
                                <input type="text" name="descripcion" placeholder="Plataforma interactiva con pasarela de pago..." class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2.5 text-white focus:border-orange-500 focus:outline-none text-sm">
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="px-6 py-3 bg-neon-orange text-black font-bold rounded-xl hover:bg-orange-600 transition-all text-sm">
                                Publicar Demo
                            </button>
                        </div>
                    </form>
                </div>

                <!-- SECCIÓN 3: LISTADO DE DEMOS ACTUALES -->
                <div class="card-cyber p-8 rounded-2xl">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                        <i class="fa-solid fa-list text-neon-orange mr-2"></i> Demos Publicados Actualmente
                    </h3>
                    <?php if (empty($lista_demos)): ?>
                        <p class="text-gray-400 text-sm">No hay demos registrados en la base de datos todavía.</p>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-300">
                                <thead class="bg-gray-900 text-gray-400 uppercase text-xs">
                                    <tr>
                                        <th class="p-3">Título</th>
                                        <th class="p-3">Categoría</th>
                                        <th class="p-3">Enlace</th>
                                        <th class="p-3 text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-800">
                                    <?php foreach ($lista_demos as $d): ?>
                                        <tr>
                                            <td class="p-3 font-bold text-white"><?= htmlspecialchars($d['titulo']) ?></td>
                                            <td class="p-3"><span class="px-2.5 py-1 bg-orange-500/10 text-neon-orange rounded text-xs"><?= htmlspecialchars($d['categoria']) ?></span></td>
                                            <td class="p-3"><a href="<?= htmlspecialchars($d['url_demo']) ?>" target="_blank" class="text-blue-400 hover:underline">Ver enlace</a></td>
                                            <td class="p-3 text-right">
                                                <a href="admin_login.php?delete_demo=<?= $d['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este demo?');" class="px-3 py-1 bg-red-500/20 text-red-400 rounded hover:bg-red-500 hover:text-white transition-all text-xs font-bold">
                                                    Eliminar
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-950 border-t border-gray-800 py-6 text-center text-xs text-gray-600">
        &copy; <?= date('Y') ?> EM Digital VE - Panel de Control Admin.
    </footer>

</body>
</html>