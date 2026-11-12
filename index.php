<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_login();
require_once __DIR__ . '/config/database.php';
$totales = ['ingresos'=>0, 'egresos'=>0, 'movimientos'=>0];
try {
    $totales['ingresos'] = (float)$pdo->query("SELECT COALESCE(SUM(monto),0) FROM movimientos WHERE tipo='INGRESO' AND estado='CONFIRMADO'")->fetchColumn();
    $totales['egresos'] = (float)$pdo->query("SELECT COALESCE(SUM(monto),0) FROM movimientos WHERE tipo='EGRESO' AND estado='CONFIRMADO'")->fetchColumn();
    $totales['movimientos'] = (int)$pdo->query("SELECT COUNT(*) FROM movimientos")->fetchColumn();
} catch (PDOException $e) {}
$saldo = $totales['ingresos'] - $totales['egresos'];
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Dashboard | Tesorería IESTP Utcubamba</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body><div class="layout"><aside class="sidebar"><div class="brand"><img src="assets/img/logo_iestp.png" alt="Logo"><div><strong>IESTP UTCUBAMBA</strong><small>Tesorería · 2026</small></div></div><nav><a class="active" href="index.php">▦ Dashboard</a><a href="modules/movimientos.php?tipo=INGRESO">＋ Ingresos</a><a href="modules/movimientos.php?tipo=EGRESO">－ Egresos</a><a href="modules/movimientos.php">⇄ Movimientos</a><a href="modules/comprobantes.php">▤ Comprobantes</a><a href="modules/usuarios.php">♙ Usuarios</a></nav><div class="sidebar-bottom"><a href="logout.php">↪ Cerrar sesión</a></div></aside>
<main class="main"><header class="topbar"><div><span class="eyebrow">PANEL DE CONTROL</span><h1>Dashboard de Tesorería</h1><p>Resumen general de las operaciones institucionales.</p></div><div class="user-chip"><?= e($_SESSION['usuario']['nombre']) ?><small><?= e($_SESSION['usuario']['rol']) ?></small></div></header>
<section class="welcome"><div><span>GESTIÓN FINANCIERA INSTITUCIONAL</span><h2>Bienvenido al sistema de Tesorería</h2><p>Control y seguimiento de ingresos, egresos y movimientos.</p></div><img src="assets/img/logo_iestp.png" alt="Logo IESTP Utcubamba"></section>
<section class="stats"><article class="stat"><span>Ingresos confirmados</span><strong>S/ <?= number_format($totales['ingresos'],2) ?></strong><small>Acumulado registrado</small></article><article class="stat"><span>Egresos confirmados</span><strong>S/ <?= number_format($totales['egresos'],2) ?></strong><small>Acumulado registrado</small></article><article class="stat"><span>Saldo neto registrado</span><strong>S/ <?= number_format($saldo,2) ?></strong><small>Ingresos menos egresos</small></article><article class="stat"><span>Movimientos</span><strong><?= number_format($totales['movimientos']) ?></strong><small>Registros en el sistema</small></article></section>
<section class="panel"><div class="panel-head"><div><h3>Accesos rápidos</h3><p>Selecciona una operación para continuar.</p></div></div><div class="quick-links"><a href="modules/movimientos.php?tipo=INGRESO"><b>＋</b><span><strong>Registrar ingreso</strong><small>Registrar dinero recibido</small></span></a><a href="modules/movimientos.php?tipo=EGRESO"><b>－</b><span><strong>Registrar egreso</strong><small>Registrar pago o salida</small></span></a><a href="modules/movimientos.php"><b>⇄</b><span><strong>Ver movimientos</strong><small>Consultar operaciones</small></span></a></div></section>
<footer>IESTP Utcubamba · Sistema Web de Gestión y Control de Tesorería · 2026</footer></main></div></body></html>
