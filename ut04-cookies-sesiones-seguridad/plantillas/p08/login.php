<?php
/**
 * UT04 · P08 · Intranet de la academia: inicio de sesión
 * ¡ATENCIÓN! Esta aplicación tiene fallos de seguridad a propósito. Es el material de la auditoría.
 */
session_start();
$usuarios = require 'usuarios.php';

$error = '';

// Entrada automática con la cookie "recordar"
if (!isset($_SESSION['usuario']) && isset($_COOKIE['recordar'])) {
    [$u, $c] = explode(':', base64_decode($_COOKIE['recordar']), 2) + [1 => ''];
    if (isset($usuarios[$u]) && $usuarios[$u]['clave'] == $c) {
        $_SESSION['usuario'] = $u;
        $_SESSION['nombre'] = $usuarios[$u]['nombre'];
        header('Location: privado.php');
        exit;
    }
}

if (isset($_GET['usuario'])) {
    $u = $_GET['usuario'];
    $c = $_GET['clave'] ?? '';

    if (!isset($usuarios[$u])) {
        $error = 'El usuario no existe.';
    } elseif ($usuarios[$u]['clave'] != $c) {
        $error = 'La contraseña no es correcta.';
    } else {
        $_SESSION['usuario'] = $u;
        $_SESSION['nombre'] = $usuarios[$u]['nombre'];
        setcookie('rol', $usuarios[$u]['rol'], time() + 3600);

        if (isset($_GET['recordar'])) {
            setcookie('recordar', base64_encode("$u:$c"), time() + 60 * 60 * 24 * 30);
        }
        header('Location: privado.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia · Iniciar sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<section class="section">
    <div class="container" style="max-width: 420px;">
        <form class="box" method="get">
            <h1 class="title"><i class="fa fa-book"></i> Academia</h1>

            <?php if (isset($_GET['msg'])): ?>
                <div class="notification is-info is-light"><?= $_GET['msg'] ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="notification is-danger is-light"><?= $error ?></div>
            <?php endif; ?>

            <div class="field">
                <label class="label" for="usuario">Usuario</label>
                <input class="input" id="usuario" name="usuario">
            </div>
            <div class="field">
                <label class="label" for="clave">Contraseña</label>
                <input class="input" type="password" id="clave" name="clave">
            </div>
            <div class="field">
                <label class="checkbox"><input type="checkbox" name="recordar"> Recordarme</label>
            </div>
            <button class="button is-primary is-fullwidth">Entrar</button>
        </form>
    </div>
</section>
</body>
</html>
