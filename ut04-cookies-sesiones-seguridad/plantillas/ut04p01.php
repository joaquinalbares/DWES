<?php
/**
 * PLANTILLA · UT04 · P01: Contador de visitas con cookies
 * Busca los comentarios TODO para saber dónde tienes que escribir el código PHP.
 * Recuerda: setcookie() y header() van ANTES de cualquier salida (antes del DOCTYPE).
 */

date_default_timezone_set('Europe/Madrid');

// TODO 1: si llega un POST con accion = 'olvidar', borra las cookies 'visitas' y 'ultima_visita'
//         (caducidad en el pasado, misma ruta) y redirige a esta misma página. No olvides exit.

// TODO 2: lee las cookies y valídalas con filter_var():
//         - 'visitas' debe ser un entero >= 0 (si no, 0)
//         - 'ultima_visita' debe ser un entero positivo (si no, null)

// TODO 3: calcula $visitaActual y guarda las dos cookies durante 30 días.
//         Usa las opciones 'path' => '/', 'httponly' => true y 'samesite' => 'Lax'.

$visitaActual = 1;       // TODO: sustituye por el valor calculado
$ultimaVisita = null;    // TODO: sustituye por el valor leído de la cookie
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UT04 · P01: Contador de visitas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<section class="section">
    <div class="container" style="max-width: 550px;">
        <div class="box has-text-centered">
            <h1 class="title"><i class="fa fa-eye"></i> Contador de visitas</h1>

            <!-- TODO 4: muestra un mensaje u otro según sea la primera visita o no -->
            <p class="is-size-4">¡Bienvenido! Es la primera vez que entras.</p>
            <p class="is-size-4">Es tu visita número <strong>4</strong>.</p>
            <p class="mt-2">Tu última visita fue el <strong>06/11/2026 a las 10:35</strong>.</p>

            <form method="post" class="mt-5">
                <input type="hidden" name="accion" value="olvidar">
                <button class="button is-danger is-light">
                    <span class="icon"><i class="fa fa-trash"></i></span>
                    <span>Olvidarme</span>
                </button>
            </form>
        </div>
    </div>
</section>
</body>

</html>
