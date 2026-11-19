<?php
/**
 * PLANTILLA · UT04 · P07 · Cabecera común: HTML inicial, barra de navegación y mensajes flash.
 * Antes de incluirla, define $titulo.
 */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet · <?= h($titulo ?? '') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<nav class="navbar is-link">
    <div class="navbar-brand">
        <a class="navbar-item has-text-weight-bold" href="panel.php">
            <i class="fa fa-graduation-cap mr-2"></i> Intranet Informática
        </a>
    </div>

    <!-- TODO 1: muestra este menú solo si hay un usuario identificado -->
    <div class="navbar-menu is-active">
        <div class="navbar-start">
            <a class="navbar-item" href="panel.php">Panel</a>
            <!-- TODO 2: enlace solo para el rol admin -->
            <a class="navbar-item" href="admin.php">Administración</a>
        </div>
        <div class="navbar-end">
            <!-- TODO 3: nombre y rol del usuario identificado -->
            <span class="navbar-item">
                <i class="fa fa-user mr-2"></i> Ana Pérez Gil
                <span class="tag is-light ml-2">usuario</span>
            </span>
            <div class="navbar-item">
                <!-- TODO 4: añade el campo oculto con el token CSRF -->
                <form method="post" action="logout.php">
                    <button class="button is-small is-light"><i class="fa fa-sign-out mr-1"></i> Cerrar sesión</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<section class="section">
    <div class="container">
        <!-- TODO 5: muestra los mensajes flash (obtenerFlash) -->
