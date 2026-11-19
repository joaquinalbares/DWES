<?php
/**
 * UT04 · P08 · Intranet de la academia: administración
 * ¡ATENCIÓN! Esta aplicación tiene fallos de seguridad a propósito.
 */
session_start();

if (($_COOKIE['rol'] ?? '') !== 'admin') {
    header('Location: privado.php');
    exit;
}

$usuarios = require 'usuarios.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia · Administración</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
</head>
<body>
<section class="section">
    <div class="container">
        <h1 class="title">Administración de usuarios</h1>
        <table class="table is-fullwidth is-striped">
            <thead><tr><th>Usuario</th><th>Nombre</th><th>Rol</th><th>Contraseña</th></tr></thead>
            <tbody>
            <?php foreach ($usuarios as $u => $d): ?>
                <tr><td><?= $u ?></td><td><?= $d['nombre'] ?></td><td><?= $d['rol'] ?></td><td><?= $d['clave'] ?></td></tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a class="button" href="privado.php">Volver</a>
    </div>
</section>
</body>
</html>
