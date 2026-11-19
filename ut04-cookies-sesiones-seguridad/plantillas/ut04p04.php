<?php
/**
 * PLANTILLA · UT04 · P04: Carrito de la compra con sesiones
 * Busca los comentarios TODO para saber dónde tienes que escribir el código PHP.
 */

// TODO 1: inicia la sesión (cookie_httponly, cookie_samesite Lax y use_strict_mode)

$catalogo = require __DIR__ . '/catalogo.php';

// TODO 2: escribe las funciones h(), euros() (formato 1.234,56 €), flash() y obtenerFlash()

// TODO 3: si $_SESSION['carrito'] no existe, créalo como array vacío (código => unidades)

// TODO 4: procesa las acciones POST ('anadir', 'quitar', 'vaciar'):
//         - valida el código con la lista blanca (claves de $catalogo)
//         - valida la cantidad con filter_input() (entero de 1 a 10)
//         - máximo 20 unidades por producto
//         - guarda un mensaje flash y redirige a esta misma página (POST/Redirect/GET)

// TODO 5: prepara los datos para la vista: líneas del carrito, total y número total de unidades
$totalUnidades = 0;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UT04 · P04: Carrito de la compra</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<nav class="navbar is-dark">
    <div class="navbar-brand">
        <span class="navbar-item has-text-weight-bold"><i class="fa fa-desktop mr-2"></i> TecnoAlbares</span>
    </div>
    <div class="navbar-end">
        <span class="navbar-item">
            <i class="fa fa-shopping-cart mr-2"></i>
            <span class="tag is-warning is-rounded"><?= $totalUnidades ?></span>
        </span>
    </div>
</nav>

<section class="section">
    <div class="container">
        <!-- TODO 6: muestra los mensajes flash -->
        <div class="notification is-success is-light">Has añadido 2 × Teclado mecánico.</div>

        <div class="columns">
            <!-- Catálogo -->
            <div class="column is-7">
                <h2 class="title is-4">Catálogo</h2>
                <!-- TODO 7: repite esta caja para cada producto de $catalogo -->
                <div class="box">
                    <form method="post" class="is-flex is-align-items-center is-justify-content-space-between">
                        <div>
                            <p class="has-text-weight-semibold">Teclado mecánico</p>
                            <p class="has-text-grey">69,90 €</p>
                        </div>
                        <div class="field has-addons mb-0">
                            <input type="hidden" name="accion" value="anadir">
                            <input type="hidden" name="codigo" value="TEC01">
                            <div class="control">
                                <input class="input" type="number" name="cantidad" value="1" min="1" max="10" style="width: 5rem;">
                            </div>
                            <div class="control">
                                <button class="button is-link"><i class="fa fa-cart-plus"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Carrito -->
            <div class="column is-5">
                <h2 class="title is-4">Tu carrito</h2>
                <!-- TODO 8: si el carrito está vacío, muestra solo este aviso -->
                <div class="notification">Tu carrito está vacío.</div>

                <!-- TODO 9: si no, muestra la tabla con una fila por producto del carrito -->
                <table class="table is-fullwidth is-striped">
                    <thead>
                    <tr><th>Producto</th><th class="has-text-right">Ud.</th><th class="has-text-right">Subtotal</th><th></th></tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Teclado mecánico<br><small class="has-text-grey">69,90 €</small></td>
                        <td class="has-text-right">2</td>
                        <td class="has-text-right">139,80 €</td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="accion" value="quitar">
                                <input type="hidden" name="codigo" value="TEC01">
                                <button class="button is-small is-danger is-light" title="Quitar"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr><th colspan="2">Total</th><th class="has-text-right">139,80 €</th><th></th></tr>
                    </tfoot>
                </table>
                <form method="post">
                    <input type="hidden" name="accion" value="vaciar">
                    <button class="button is-light is-fullwidth"><i class="fa fa-times mr-2"></i> Vaciar carrito</button>
                </form>
            </div>
        </div>
    </div>
</section>
</body>

</html>
