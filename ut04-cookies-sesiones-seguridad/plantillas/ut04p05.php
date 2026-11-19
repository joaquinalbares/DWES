<?php
/**
 * PLANTILLA · UT04 · P05: Inscripción en tres pasos
 * Busca los comentarios TODO para saber dónde tienes que escribir el código PHP.
 * El paso actual llega por GET (?paso=1, 2 o 3) y los datos se guardan en $_SESSION['inscripcion'].
 */

// TODO 1: inicia la sesión de forma segura

$cursos = [
    'php'   => 'Iniciación a PHP',
    'git'   => 'Git y GitHub',
    'bulma' => 'Maquetación con Bulma',
    'ci4'   => 'CodeIgniter 4',
];
$modalidades = ['presencial' => 'Presencial', 'linea' => 'En línea'];

// TODO 2: escribe primerPasoPendiente(array $datos): int
//         Devuelve 1 si faltan nombre o email, 2 si faltan curso o modalidad y 3 en otro caso.

// TODO 3: lee el paso de $_GET y valídalo (1 a 3). Si es posterior al primer paso pendiente,
//         redirige a ese paso (control del flujo).

// TODO 4: procesa el POST:
//         - accion = 'cancelar': borra $_SESSION['inscripcion'] y vuelve al paso 1
//         - paso 1: valida nombre (2-60 caracteres) y email; si todo va bien, guarda y ve al paso 2
//         - paso 2: valida curso y modalidad con lista blanca; si todo va bien, guarda y ve al paso 3
//         - paso 3 con accion = 'confirmar': genera un número de inscripción, borra los datos
//           y muestra el mensaje final

$paso = 1;   // TODO: sustituye por el paso validado
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UT04 · P05: Inscripción en tres pasos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<section class="section">
    <div class="container" style="max-width: 600px;">
        <h1 class="title"><i class="fa fa-sun-o"></i> Cursos de verano 2027</h1>

        <!-- TODO 5: marca como activo (is-active) el paso actual y ajusta la barra de progreso -->
        <div class="tabs is-toggle is-fullwidth is-small mb-2">
            <ul>
                <li class="is-active"><a>1 · Datos personales</a></li>
                <li><a>2 · Curso</a></li>
                <li><a>3 · Confirmación</a></li>
            </ul>
        </div>
        <progress class="progress is-link is-small" value="0" max="100">0 %</progress>

        <div class="box">
            <!-- TODO 6: muestra solo el bloque del paso actual. Rellena los campos con lo que haya
                         en la sesión y muestra los errores debajo de cada campo (clase is-danger). -->
            <form method="post" novalidate>
                <!-- PASO 1 -->
                <div class="field">
                    <label class="label" for="nombre">Nombre y apellidos</label>
                    <input class="input" id="nombre" name="nombre" value="">
                    <p class="help is-danger">El nombre debe tener entre 2 y 60 caracteres.</p>
                </div>
                <div class="field">
                    <label class="label" for="email">Correo electrónico</label>
                    <input class="input" type="email" id="email" name="email" value="">
                </div>

                <!-- PASO 2 -->
                <div class="field">
                    <label class="label" for="curso">Curso</label>
                    <div class="select is-fullwidth">
                        <select id="curso" name="curso">
                            <option value="">Elige un curso…</option>
                            <option value="php">Iniciación a PHP</option>
                        </select>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Modalidad</label>
                    <label class="radio mr-3"><input type="radio" name="modalidad" value="presencial"> Presencial</label>
                    <label class="radio"><input type="radio" name="modalidad" value="linea"> En línea</label>
                </div>

                <!-- PASO 3 -->
                <h2 class="subtitle">Revisa tus datos</h2>
                <table class="table is-fullwidth">
                    <tr><th>Nombre</th><td>…</td></tr>
                    <tr><th>Correo</th><td>…</td></tr>
                    <tr><th>Curso</th><td>…</td></tr>
                    <tr><th>Modalidad</th><td>…</td></tr>
                </table>

                <div class="field is-grouped is-grouped-right mt-5">
                    <!-- "Atrás" es un enlace al paso anterior (no aparece en el paso 1) -->
                    <p class="control"><a class="button" href="?paso=1"><i class="fa fa-arrow-left mr-2"></i> Atrás</a></p>
                    <!-- En los pasos 1 y 2, "Siguiente"; en el 3, "Confirmar" -->
                    <p class="control"><button class="button is-link" name="accion" value="siguiente">Siguiente <i class="fa fa-arrow-right ml-2"></i></button></p>
                    <p class="control"><button class="button is-success" name="accion" value="confirmar"><i class="fa fa-check mr-2"></i> Confirmar</button></p>
                </div>
            </form>

            <!-- Cancelar va en su propio formulario POST -->
            <form method="post">
                <input type="hidden" name="accion" value="cancelar">
                <button class="button is-danger is-light is-small">Cancelar inscripción</button>
            </form>

            <!-- MENSAJE FINAL (tras confirmar) -->
            <div class="notification is-success mt-4">
                <p class="is-size-5"><i class="fa fa-check-circle"></i> ¡Inscripción completada!</p>
                <p>Tu número de inscripción es <strong>INS-2026-12345</strong>.</p>
            </div>
        </div>
    </div>
</section>
</body>

</html>
