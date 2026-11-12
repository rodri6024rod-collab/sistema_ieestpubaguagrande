<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/config/database.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT id, nombre, usuario, password_hash, rol FROM usuarios WHERE usuario = ? AND estado = 1 LIMIT 1");
    $stmt->execute([$usuario]);
    $row = $stmt->fetch();
    if ($row && password_verify($password, $row['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['usuario'] = ['id'=>$row['id'], 'nombre'=>$row['nombre'], 'usuario'=>$row['usuario'], 'rol'=>$row['rol']];
        header('Location: index.php'); exit;
    }
    $error = 'Usuario o contraseña incorrectos.';
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Acceso | Tesorería IESTP Utcubamba</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body class="login-page"><main class="login-card"><img class="login-logo" src="assets/img/logo_iestp.png" alt="Logo IESTP Utcubamba"><p class="eyebrow">INSTITUTO DE EDUCACIÓN SUPERIOR TECNOLÓGICO PÚBLICO</p><h1>UT CUBAMBA</h1><h2>Sistema de Tesorería</h2>
<?php if ($error): ?><p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
<form method="post"><label>Usuario</label><input name="usuario" autocomplete="username" required autofocus><label>Contraseña</label><input type="password" name="password" autocomplete="current-password" required><button class="btn" type="submit">Ingresar al sistema</button></form><small>Bagua Grande – Amazonas · 2026</small></main></body></html>
