<?php
/**
 * PLANTILLA · UT04 · P07 · Inicio de sesión
 * Busca los comentarios TODO para saber dónde tienes que escribir el código PHP.
 */
require __DIR__ . '/includes/auth.php';
$usuarios = require __DIR__ . '/datos/usuarios.php';

// TODO 1: si ya hay un usuario identificado, redirige a panel.php

// TODO 2: aviso que llega en la URL: ?motivo=caducada o ?motivo=salida (lista cerrada de textos)

// TODO 3: comprueba si el formulario está bloqueado ($_SESSION['bloqueado_hasta'])

// TODO 4: procesa el POST:
//   - comprobarCsrf()
//   - si no está bloqueado y las credenciales son correctas (password_verify):
//       session_regenerate_id(true), guarda login, nombre, rol e inicio en $_SESSION['usuario'],
//       pon a cero los intentos, guarda $_SESSION['ultimo_acceso'] y redirige a panel.php
//   - si no: suma un intento; al llegar a MAX_INTENTOS, bloquea durante TIEMPO_BLOQUEO.
//     El mensaje de error es el mismo para usuario inexistente y contraseña incorrecta.

$titulo = 'Iniciar sesión';
require __DIR__ . '/includes/cabecera.php';
?>
<div class="columns is-centered">
    <div class="column is-5">
        <form method="post" class="box" novalidate>
            <h1 class="title"><i class="fa fa-lock"></i> Iniciar sesión</h1>

            <!-- TODO 5: aviso de la URL y mensaje de error (o del tiempo de bloqueo restante) -->
            <div class="notification is-danger is-light">Usuario o contraseña incorrectos.</div>

            <!-- TODO 6: campo oculto con el token CSRF -->

            <div class="field">
                <label class="label" for="usuario">Usuario</label>
                <div class="control has-icons-left">
                    <!-- TODO 7: conserva el usuario escrito (escapado) -->
                    <input class="input" id="usuario" name="usuario" value="" autocomplete="username" required>
                    <span class="icon is-left"><i class="fa fa-user"></i></span>
                </div>
            </div>
            <div class="field">
                <label class="label" for="clave">Contraseña</label>
                <div class="control has-icons-left">
                    <input class="input" type="password" id="clave" name="clave" autocomplete="current-password" required>
                    <span class="icon is-left"><i class="fa fa-key"></i></span>
                </div>
            </div>
            <!-- TODO 8: desactiva el botón (disabled) mientras dure el bloqueo -->
            <button class="button is-link is-fullwidth">Entrar</button>
        </form>
    </div>
</div>
<?php require __DIR__ . '/includes/pie.php'; ?>
