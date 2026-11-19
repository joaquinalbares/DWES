<?php
/**
 * PLANTILLA · UT04 · P06: Panel con autenticación HTTP Basic
 * Busca los comentarios TODO para saber dónde tienes que escribir el código PHP.
 */

date_default_timezone_set('Europe/Madrid');

// TODO 1: usuarios autorizados: usuario => hash de la contraseña.
//         Genera los hashes con crear-hash.php:  php crear-hash.php "Tecnico#2026"
$usuarios = [
    'tecnico' => '',   // Tecnico#2026
    'jefa'    => '',   // Jefa#2026
];

// TODO 2: lee $_SERVER['PHP_AUTH_USER'] y $_SERVER['PHP_AUTH_PW'] y comprueba la contraseña
//         con password_verify(). Si no son válidas, envía la cabecera
//         WWW-Authenticate: Basic realm="Panel del servidor", el código 401, un mensaje y exit.

// TODO 3: prepara los datos del panel: usuario, fecha y hora, PHP_VERSION,
//         $_SERVER['SERVER_SOFTWARE'] y $_SERVER['REMOTE_ADDR']
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UT04 · P06: Panel del servidor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<section class="section">
    <div class="container" style="max-width: 600px;">
        <div class="box">
            <h1 class="title"><i class="fa fa-server"></i> Panel del servidor</h1>
            <!-- TODO 4: genera las filas recorriendo los datos y escápalos -->
            <table class="table is-fullwidth">
                <tr><th>Usuario identificado</th><td>tecnico</td></tr>
                <tr><th>Fecha y hora</th><td>06/11/2026 10:35:12</td></tr>
            </table>
        </div>
    </div>
</section>
</body>

</html>
<?php
/*
 * RESPUESTAS
 *
 * 1. Valor de Authorization y resultado de atob():
 *
 * 2. ¿Cómo se cierra la sesión? ¿Qué pasa al cerrar la pestaña y volver a entrar?
 *
 * 3. Código de estado con -u y sin -u:
 */
