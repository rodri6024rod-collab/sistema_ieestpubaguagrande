<?php
declare(strict_types=1);
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
verify_csrf();
$existe = (int)$pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn() > 0;
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$existe) {
    $nombre = trim($_POST['nombre'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($nombre === '' || $usuario === '' || strlen($password) < 10) {
        $mensaje = 'Completa todos los campos. La contraseña debe tener al menos 10 caracteres.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, usuario, password_hash, rol) VALUES (?, ?, ?, 'administrador')");
        $stmt->execute([$nombre, $usuario, password_hash($password, PASSWORD_DEFAULT)]);
        $mensaje = 'Administrador creado. Elimina setup.php del servidor y entra por login.php.';
        $existe = true;
    }
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Configuración inicial</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body class="login-page"><main class="login-card"><img class="login-logo" src="assets/img/logo_iestp.png" alt="Logo IESTP Utcubamba"><h1>Configuración inicial</h1>
<?php if ($mensaje): ?><p class="notice"><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
<?php if (!$existe): ?><form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label>Nombre completo</label><input name="nombre" required><label>Usuario</label><input name="usuario" required><label>Contraseña (mínimo 10 caracteres)</label><input type="password" name="password" minlength="10" required><button class="btn" type="submit">Crear administrador</button></form>
<?php else: ?><p>Ya existe un usuario administrador o se completó la configuración. Por seguridad, elimina este archivo del servidor.</p><a class="btn" href="login.php">Ir al inicio de sesión</a><?php endif; ?></main></body></html>
