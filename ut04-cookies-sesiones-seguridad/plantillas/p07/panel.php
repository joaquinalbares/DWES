<?php
/**
 * PLANTILLA · UT04 · P07 · Panel: cualquier usuario identificado
 */
require __DIR__ . '/includes/auth.php';
// TODO 1: protege la página para cualquier usuario identificado

$titulo = 'Panel';
require __DIR__ . '/includes/cabecera.php';
?>
<!-- TODO 2: muestra los datos del usuario identificado -->
<h1 class="title">Hola, Ana Pérez Gil</h1>
<div class="box">
    <p><strong>Usuario:</strong> ana</p>
    <p><strong>Rol:</strong> usuario</p>
    <p><strong>Sesión iniciada a las:</strong> 10:35:12</p>
</div>
<?php require __DIR__ . '/includes/pie.php'; ?>
