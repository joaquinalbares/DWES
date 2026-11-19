<?php
/**
 * PLANTILLA · UT04 · P07 · Administración: solo el rol admin
 */
require __DIR__ . '/includes/auth.php';
// TODO 1: protege la página: sin sesión → login; sin rol admin → 403

$usuarios = require __DIR__ . '/datos/usuarios.php';
$titulo = 'Administración';
require __DIR__ . '/includes/cabecera.php';
?>
<h1 class="title"><i class="fa fa-users"></i> Usuarios de la intranet</h1>
<table class="table is-fullwidth is-striped">
    <thead>
    <tr><th>Usuario</th><th>Nombre</th><th>Rol</th></tr>
    </thead>
    <tbody>
    <!-- TODO 2: una fila por usuario (nunca el hash) -->
    <tr><td>ana</td><td>Ana Pérez Gil</td><td><span class="tag is-info is-light">usuario</span></td></tr>
    </tbody>
</table>
<?php require __DIR__ . '/includes/pie.php'; ?>
