<?php
session_start();
require_once 'conexion.php';

// Verificar que el administrador esté logueado
if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header("Location: admin_login.php");
    exit;
}

$mensaje = '';
$error = '';

// Manejo para agregar nuevos demos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_demo') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $categoria = trim($_POST['categoria'] ?? 'SISTEMA WEB');
    $enlace = trim($_POST['enlace'] ?? '#');

    if (!empty($titulo) && !empty($descripcion)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO demos (titulo, descripcion, categoria, enlace) VALUES (?, ?, ?, ?)");
            $stmt->execute([$titulo, $descripcion, $categoria, $enlace]);
            $mensaje = "¡Demo agregado con éxito!";
        } catch (PDOException $e) {
            $error = "Error al guardar el demo: " . $e->getMessage();
        }
    } else {
        $error = "El título y la descripción son obligatorios.";
    }
}

// Manejo para eliminar demo
if (isset($_GET['delete_demo'])) {
    $id_demo = (int)$_GET['delete_demo'];
    try {
        $stmt = $pdo->prepare("DELETE FROM demos WHERE id = ?");
        $stmt->execute([$id_demo]);
        $mensaje = "Demo eliminado correctamente.";
    } catch (PDOException $e) {
        $error = "Error al eliminar: " . $e->getMessage();
    }
}

// Obtener la lista de demos actual
$demos = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM demos ORDER BY id DESC");
        $demos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - EM Digital VE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #07090f;
            color: #c0c0c0;
            min-height: 100vh;
            background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 30px 30px;
        }
        .navbar-admin {
            background-color: #0d121e;
            border-bottom: 1px solid #1a233a;
            padding: 15px 0;
        }
        .brand-brackets { color: #ff3300; }
        .card-custom {
            background: #0d121e;
            border: 1px solid #1a233a;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }
        .form-control-custom {
            background: #07090f;
            border: 1px solid #1e293b;
            color: #ffffff;
            border-radius: 6px;
            padding: 10px;
        }
        .form-control-custom:focus {
            background: #07090f;
            border-color: #ff3300;
            color: #ffffff;
            box-shadow: 0 0 10px rgba(255,51,0,0.3);
        }
        .btn-custom {
            background-color: #ff3300;
            color: #ffffff;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            transition: all 0.3s;
        }
        .btn-custom:hover {
            background-color: #c0c0c0;
            color: #07090f;
        }
        .table-dark-custom {
            background: #07090f;
            color: #c0c0c0;
            border-radius: 8px;
            overflow: hidden;
        }
        .table-dark-custom th {
            background: #1a233a;
            color: #ffffff;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-admin">
        <div class="container d-flex justify-content-between align-items-center">
            <span class="navbar-brand fw-bold text-white mb-0">
                <span class="brand-brackets">{</span>EM<span class="brand-brackets">}</span> Dashboard Admin
            </span>
            <div>
                <a href="index.php" class="btn btn-outline-light btn-sm me-2" target="_blank"><i class="fas fa-eye me-1"></i> Ver Web</a>
                <a href="admin_login.php" class="btn btn-outline-danger btn-sm"><i class="fas fa-sign-out-alt me-1"></i> Salir</a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h2 class="fw-bold text-white mb-4">Gestión de Demos y Contenido</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-success bg-dark text-success border-success mb-4"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger bg-dark text-danger border-danger mb-4"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Formulario para agregar Demo -->
        <div class="card-custom">
            <h4 class="fw-bold text-white mb-3"><i class="fas fa-plus-circle text-warning me-2"></i> Agregar Nuevo Demo</h4>
            <form action="admin_dashboard.php" method="POST">
                <input type="hidden" name="action" value="add_demo">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-secondary small">Título del Proyecto</label>
                        <input type="text" name="titulo" class="form-control form-control-custom" placeholder="Ej: E-Commerce Repuestos" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small">Categoría</label>
                        <input type="text" name="categoria" class="form-control form-control-custom" placeholder="Ej: SISTEMA WEB, LANDING, CATALOGO" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label text-secondary small">Descripción corta</label>
                        <textarea name="descripcion" class="form-control form-control-custom" rows="2" placeholder="Detalles clave del sistema..." required></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label text-secondary small">Enlace / URL del Demo</label>
                        <input type="text" name="enlace" class="form-control form-control-custom" placeholder="https://..." required>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn-custom"><i class="fas fa-save me-1"></i> Guardar Demo</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de Demos existentes -->
        <div class="card-custom">
            <h4 class="fw-bold text-white mb-3"><i class="fas fa-list text-warning me-2"></i> Demos Registrados</h4>
            <div class="table-responsive">
                <table class="table table-dark table-dark-custom align-middle">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Categoría</th>
                            <th>Enlace</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($demos)): ?>
                            <?php foreach ($demos as $demo): ?>
                                <tr>
                                    <td class="fw-bold text-white"><?php echo htmlspecialchars($demo['titulo']); ?></td>
                                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($demo['categoria']); ?></span></td>
                                    <td><a href="<?php echo htmlspecialchars($demo['enlace']); ?>" target="_blank" class="text-warning small">Abrir Link</a></td>
                                    <td class="text-end">
                                        <a href="admin_dashboard.php?delete_demo=<?php echo $demo['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Seguro de eliminar este demo?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No hay demos agregados aún. Usa el formulario de arriba para crear el primero.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>