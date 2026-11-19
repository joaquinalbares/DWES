<?php
/**
 * PLANTILLA · UT04 · P02: Preferencias de aspecto
 * Busca los comentarios TODO para saber dónde tienes que escribir el código PHP.
 */

// Valores permitidos (lista blanca) y valores por defecto
$permitidos = [
    'tema'   => ['claro', 'oscuro'],
    'letra'  => ['pequena', 'normal', 'grande'],
    'idioma' => ['es', 'en'],
];
$porDefecto = ['tema' => 'claro', 'letra' => 'normal', 'idioma' => 'es'];

// Tamaño base de la página para cada opción de letra
$tamanos = ['pequena' => '14px', 'normal' => '16px', 'grande' => '18px'];

// Textos de la página. TODO: completa el idioma inglés con las mismas claves.
$textos = [
    'es' => [
        'titulo'      => 'Preferencias',
        'intro'       => 'Elige cómo quieres ver esta página. Lo recordaremos durante un año.',
        'tema'        => 'Tema',
        'claro'       => 'Claro',
        'oscuro'      => 'Oscuro',
        'letra'       => 'Tamaño de letra',
        'pequena'     => 'Pequeña',
        'normal'      => 'Normal',
        'grande'      => 'Grande',
        'idioma'      => 'Idioma',
        'guardar'     => 'Guardar',
        'restablecer' => 'Restablecer',
        'guardado'    => 'Preferencias guardadas.',
        'borrado'     => 'Se han restablecido las preferencias por defecto.',
    ],
    'en' => [
        'titulo' => 'Preferences',
        // TODO
    ],
];

// TODO 1: escribe la función validarPreferencias($datos, $permitidos, $porDefecto): array
//         Devuelve un array con las tres claves; cada valor que no esté en su lista blanca
//         (o que falte) se sustituye por su valor por defecto.

// TODO 2: si llega un POST:
//         - con accion = 'restablecer': borra la cookie y redirige con ?borrado=1
//         - si no: valida $_POST, guarda la cookie 'preferencias' con json_encode()
//           durante un año (httponly y samesite Lax) y redirige con ?guardado=1

// TODO 3: lee la cookie con json_decode(..., true) y valídala con tu función.
$prefs = $porDefecto;            // TODO: sustituye por las preferencias leídas
$t = $textos[$prefs['idioma']];  // textos del idioma elegido
?>
<!DOCTYPE html>
<!-- TODO 4: aplica el idioma (lang), el tema (data-theme="light" o "dark") y el tamaño de letra (style) -->
<html lang="es" data-theme="light" style="font-size: 16px;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UT04 · P02: Preferencias</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<section class="section">
    <div class="container" style="max-width: 550px;">
        <div class="box">
            <!-- TODO 5: muestra todos los textos desde $t, escapados -->
            <h1 class="title"><i class="fa fa-sliders"></i> Preferencias</h1>
            <p class="mb-4">Elige cómo quieres ver esta página. Lo recordaremos durante un año.</p>

            <!-- TODO 6: aviso si llega ?guardado=1 o ?borrado=1 -->
            <div class="notification is-success is-light">Preferencias guardadas.</div>

            <form method="post">
                <!-- TODO 7: genera las opciones con foreach desde $permitidos y marca las actuales
                             (checked / selected) para que el formulario sea persistente -->
                <div class="field">
                    <label class="label">Tema</label>
                    <div class="control">
                        <label class="radio mr-3"><input type="radio" name="tema" value="claro" checked> Claro</label>
                        <label class="radio"><input type="radio" name="tema" value="oscuro"> Oscuro</label>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="letra">Tamaño de letra</label>
                    <div class="select is-fullwidth">
                        <select name="letra" id="letra">
                            <option value="pequena">Pequeña</option>
                            <option value="normal" selected>Normal</option>
                            <option value="grande">Grande</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="idioma">Idioma</label>
                    <div class="select is-fullwidth">
                        <select name="idioma" id="idioma">
                            <option value="es" selected>Español</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                </div>

                <div class="field is-grouped mt-5">
                    <div class="control">
                        <button class="button is-link" name="accion" value="guardar">
                            <span class="icon"><i class="fa fa-save"></i></span><span>Guardar</span>
                        </button>
                    </div>
                    <div class="control">
                        <button class="button is-light" name="accion" value="restablecer">
                            <span class="icon"><i class="fa fa-undo"></i></span><span>Restablecer</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
</body>

</html>
