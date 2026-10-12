# Relación de Prácticas: UT02 - Introducción al Lenguaje PHP

## Práctica 1: Embebido de PHP, Directivas y Salida Dinámica

Crea una página web dinámica que muestre información del servidor e interactúe con el cliente modificando las directivas por defecto de PHP.

### Enunciado y Requisitos

1. Crea un fichero llamado `p1_servidor.php`.
2. Habilita la visualización de errores y advertencias al inicio del script mediante las directivas `ini_set('display_errors', 1)` y `error_reporting(E_ALL)`.
3. Integra código PHP dentro de la maquetación HTML5 mediante etiquetas `<?php ... ?>` y la sintaxis corta de impresión `<?= ... ?>`.
4. Muestra dinámicamente en una tarjeta estilizada:
    * La fecha y hora actual del servidor en formato local español.
    * La versión activa de PHP (`phpversion()`).
    * El agente de usuario (*User Agent*) recuperado de la superglobal `$_SERVER`.
5. Abre el navegador web, inspecciona el código fuente recibido (`Ctrl + U`) y verifica la ausencia de etiquetas PHP en el HTML final.


## Práctica 2: Tipos de Datos, Operadores, Constantes y Ámbitos

Diseña una calculadora de facturación laboral aplicando constantes, operadores lógicos y aritméticos, paso por referencia y gestión del ámbito global.

### Enunciado y Requisitos

1. Crea el fichero `p2_facturacion.php`.
2. Define dos constantes: `IVA` con valor `0.21` y `RETENCION_IRPF` con valor `0.15`.
3. Declara una variable global `$tarifaHora = 25.50` y otra `$horasTrabajadas = 160`.
4. Crea una función `calcularNomina(&$totalBruto)` que:
    * Acceda a la variable global `$tarifaHora` mediante la palabra reservada `global`.
    * Calcule el salario bruto multiplicando las horas trabajadas por la tarifa.
    * Asigne el resultado a `$totalBruto` modificando el valor por **referencia** (`&`).
    * Devuelva el salario neto restando las retenciones y sumando el IVA aplicable.
5. Imprime en pantalla una comparación estricta (`===`) entre dos comprobaciones de tipo utilizando `var_dump()`.

### Solución Propuesta

=== "fichero `p2_facturacion.php`"
    ```php title="p2_facturacion.php" lineno="1"
    <?php
    /* 
       Práctica 2: Cálculo de nómina y facturación
       Demostración de tipos de datos, constantes, operadores y ámbitos
    */

    // Definición de constantes
    define("IVA", 0.21);
    const RETENCION_IRPF = 0.15;

    // Variables en ámbito global
    $tarifaHora = 25.50;      // float
    $horasTrabajadas = 160;   // integer
    $brutoCalculado = 0.0;     // float

    /**
     * Calcula la nómina modificando el bruto por referencia y usando global
     */
    function calcularNomina(float &$totalBruto, int $horas): float {
        global $tarifaHora; // Acceso explícito al ámbito global
        
        $totalBruto = $tarifaHora * $horas; // Asignación por referencia
        $irpf = $totalBruto * RETENCION_IRPF;
        $impuestos = $totalBruto * IVA;
        
        return $totalBruto - $irpf + $impuestos;
    }

    $neto = calcularNomina($brutoCalculado, $horasTrabajadas);
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Práctica 2 - Facturación</title>
    </head>
    <body>
        <h1>Resumen de Facturación Semanal</h1>
        <p><strong>Tarifa por hora:</strong> <?= $tarifaHora ?> €</p>
        <p><strong>Horas trabajadas:</strong> <?= $horasTrabajadas ?> h</p>
        <p><strong>Total Bruto (Modificado por Ref):</strong> <?= number_format($brutoCalculado, 2) ?> €</p>
        <p><strong>Total Neto a Recibir:</strong> <?= number_format($neto, 2) ?> €</p>

        <hr>
        <h3>Comprobación de Tipos y Operadores</h3>
        <pre><?php
            // Comparación débil vs estricta
            echo "Comparación (100 == '100'): ";
            var_dump(100 == '100');

            echo "Comparación estricta (100 === '100'): ";
            var_dump(100 === '100');
        ?></pre>
    </body>
    </html>
    ```

---

## Práctica 3: Estructuras Condicionales y Toma de Decisiones

!!! info "Ficha de la Práctica 3"
    * **Duración estimada:** 30 minutos
    * **Objetivo:** Construir un motor de clasificación de envíos y tarifas de transporte utilizando expresiones `match` y bloques `if-elseif-else`.
    * **Criterios de Evaluación:** RA3 (Mecanismos de decisión, sintaxis de control, comentarios en código).

### Enunciado y Requisitos

1. Crea el fichero `p3_envios.php`.
2. Define las variables del paquete: `$pesoKg = 4.5`, `$zonaDestino = 'B'` y `$esSocio = true`.
3. Implementa una estructura `match` (introducida en PHP 8) para determinar el precio base según la zona:
    * Zona `'A'`: 5.00 €
    * Zona `'B'`: 10.00 €
    * Zona `'C'`: 18.00 €
    * Otra zona: Lanzar o registrar una opción no válida.
4. Mediante una estructura `if-elseif-else`, aplica un recargo por peso:
    * Si el peso es inferior a 2 kg: Sin recargo.
    * Si el peso está entre 2 kg y 5 kg: Recargo de 3.50 €.
    * Si el peso supera los 5 kg: Recargo de 7.00 €.
5. Si `$esSocio` es `true`, aplica un descuento global del 15% al coste total mediante un operador ternario.

### Solución Propuesta

=== "fichero `p3_envios.php`"
    ```php title="p3_envios.php" lineno="1"
    <?php
    // Práctica 3: Motor de cálculo de gastos de envío mediante estructuras condicionales

    $pesoKg = 4.5;
    $zonaDestino = 'B';
    $esSocio = true;

    // 1. Determinación del precio base mediante la expresión match
    $precioBase = match ($zonaDestino) {
        'A' => 5.00,
        'B' => 10.00,
        'C' => 18.00,
        default => 0.00,
    };

    // 2. Determinación del recargo por peso con if-elseif-else
    $recargo = 0.0;
    if ($pesoKg < 2.0) {
        $recargo = 0.00;
    } elseif ($pesoKg >= 2.0 && $pesoKg <= 5.0) {
        $recargo = 3.50;
    } else {
        $recargo = 7.00;
    }

    // 3. Subtotal antes de descuento
    $subtotal = $precioBase + $recargo;

    // 4. Aplicación de descuento a socios con operador ternario
    $descuento = $esSocio ? ($subtotal * 0.15) : 0.0;
    $precioFinal = $subtotal - $descuento;
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Práctica 3 - Cotizador de Envíos</title>
        <style>
            .ticket { font-family: monospace; border: 1px dashed #333; padding: 15px; width: 320px; background: #fffde7; }
        </style>
    </head>
    <body>

        <h2>Desglose de Envío Logístico</h2>
        <div class="ticket">
            <p>Zona Destino: <?= $zonaDestino ?></p>
            <p>Peso registrado: <?= $pesoKg ?> kg</p>
            <hr>
            <p>Precio Base: <?= number_format($precioBase, 2) ?> €</p>
            <p>Recargo por Peso: <?= number_format($recargo, 2) ?> €</p>
            <p>Descuento Socio (15%): -<?= number_format($descuento, 2) ?> €</p>
            <hr>
            <h3>TOTAL: <?= number_format($precioFinal, 2) ?> €</h3>
        </div>

    </body>
    </html>
    ```

---

## Práctica 4: Procesamiento de Arrays Multidimensionales y Bucles

!!! info "Ficha de la Práctica 4"
    * **Duración estimada:** 30 minutos
    * **Objetivo:** Gestionar un catálogo de productos empleando arrays asociativos multidimensionales e iterando con el bucle `foreach`.
    * **Criterios de Evaluación:** RA3 (Arrays, bucles `foreach`, renderizado de colecciones).

### Enunciado y Requisitos

1. Crea el fichero `p4_catalogo.php`.
2. Define un array multidimensional asociativo llamado `$inventario` con al menos 4 productos. Cada producto debe contener: `id`, `nombre`, `precio`, `stock` y `categoria`.
3. Recorre el array con un bucle `foreach` para renderizar los datos en una tabla HTML.
4. Aplica lógica condicional dentro de la iteración para:
    * Resaltar en color rojo las filas cuyo `stock` sea menor que 5 (Aviso de Stock Bajo).
    * Calcular el valor total del inventario acumulado ($\text{precio} \times \text{stock}$).
5. Imprime al final de la tabla el número total de productos en catálogo mediante `count()` y el valor financiero total.

### Solución Propuesta

=== "fichero `p4_catalogo.php`"
    ```php title="p4_catalogo.php" lineno="1"
    <?php
    // Práctica 4: Gestión de catálogo con arrays multidimensionales y foreach

    $inventario = [
        ["id" => 101, "nombre" => "Teclado Mecánico RGB", "precio" => 59.99, "stock" => 12, "categoria" => "Periféricos"],
        ["id" => 102, "nombre" => "Ratón Inalámbrico Ergonomía", "precio" => 25.50, "stock" => 3, "categoria" => "Periféricos"],
        ["id" => 103, "nombre" => "Monitor 27'' UltraWide", "precio" => 210.00, "stock" => 2, "categoria" => "Pantallas"],
        ["id" => 104, "nombre" => "Auriculares Noise Cancelling", "precio" => 89.00, "stock" => 15, "categoria" => "Audio"]
    ];

    $valorTotalInventario = 0;
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Práctica 4 - Catálogo e Inventario</title>
        <style>
            table { width: 100%; border-collapse: collapse; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #2c3e50; color: white; }
            .alerta-stock { background-color: #ffcdd2; color: #b71c1c; font-weight: bold; }
        </style>
    </head>
    <body>

        <h2>Control de Stock de Inventario</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inventario as $prod): 
                    $subtotalProd = $prod['precio'] * $prod['stock'];
                    $valorTotalInventario += $subtotalProd;
                    $claseFila = ($prod['stock'] < 5) ? 'alerta-stock' : '';
                ?>
                    <tr class="<?= $claseFila ?>">
                        <td><?= $prod['id'] ?></td>
                        <td><?= htmlspecialchars($prod['nombre']) ?></td>
                        <td><?= htmlspecialchars($prod['categoria']) ?></td>
                        <td><?= number_format($prod['precio'], 2) ?> €</td>
                        <td><?= $prod['stock'] ?> <?= ($prod['stock'] < 5) ? '(¡Bajo!)' : '' ?></td>
                        <td><?= number_format($subtotalProd, 2) ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><strong>Total de referencias únicas:</strong> <?= count($inventario) ?></p>
        <p><strong>Valoración total del stock:</strong> <?= number_format($valorTotalInventario, 2) ?> €</p>

    </body>
    </html>
    ```

---

## Práctica 5: Funciones Reutilizables e Interacción Básica con Formularios

!!! info "Ficha de la Práctica 5"
    * **Duración estimada:** 30 minutos
    * **Objetivo:** Integrar la recogida de datos desde un formulario HTML mediante métodos `GET`/`POST` con funciones auxiliares modularizadas.
    * **Criterios de Evaluación:** RA3 (Creación de funciones, formularios web, captura de parámetros de entrada).

### Enunciado y Requisitos

1. Crea el fichero `p5_conversor.php`.
2. Incluye un formulario HTML en el mismo archivo con el método `POST` que contenga:
    * Un campo numérico para la cantidad.
    * Un desplegable `<select>` con opciones de conversión (EUR a USD, EUR a GBP).
    * Un botón de envío.
3. Escribe dos funciones PHP personalizadas:
    * `validarCantidad($valor)`: Comprueba que sea un dato numérico y positivo. Devuelve un valor booleano.
    * `convertirMoneda(float $cantidad, string $tipo)`: Devuelve el cálculo según el tipo seleccionado.
4. Captura la petición comprobando `$_SERVER['REQUEST_METHOD'] === 'POST'`, procesa la respuesta e imprime el resultado o el error correspondiente.

### Solución Propuesta

=== "fichero `p5_conversor.php`"
    ```php title="p5_conversor.php" lineno="1"
    <?php
    // Práctica 5: Conversor de divisa con funciones y procesamiento de formularios

    // Definición de funciones auxiliares
    function validarCantidad($valor): bool {
        return is_numeric($valor) && $valor > 0;
    }

    function convertirMoneda(float $cantidad, string $tipo): float {
        $tasas = [
            'USD' => 1.08, // 1 EUR -> 1.08 USD
            'GBP' => 0.85  // 1 EUR -> 0.85 GBP
        ];

        return $cantidad * ($tasas[$tipo] ?? 1.0);
    }

    $resultado = null;
    $error = null;

    // Recogida y procesamiento de la información introducida
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $monto = $_POST['monto'] ?? '';
        $divisa = $_POST['divisa'] ?? 'USD';

        if (validarCantidad($monto)) {
            $conversion = convertirMoneda((float)$monto, $divisa);
            $resultado = number_format((float)$monto, 2) . " EUR son " . number_format($conversion, 2) . " " . $divisa;
        } else {
            $error = "Por favor, introduce un importe numérico válido y mayor que cero.";
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Práctica 5 - Conversor de Divisas</title>
        <style>
            body { font-family: sans-serif; margin: 30px; }
            .form-box { background: #eef2f5; padding: 20px; border-radius: 6px; width: 300px; }
            .mensaje { padding: 10px; margin-top: 15px; border-radius: 4px; }
            .exito { background: #d4edda; color: #155724; }
            .error { background: #f8d7da; color: #721c24; }
        </style>
    </head>
    <body>

        <h2>Conversor de Divisas Dinámico</h2>

        <div class="form-box">
            <form action="p5_conversor.php" method="POST">
                <label for="monto">Cantidad en Euros (€):</label><br>
                <input type="number" step="0.01" id="monto" name="monto" required><br><br>

                <label for="divisa">Convertir a:</label><br>
                <select id="divisa" name="divisa">
                    <option value="USD">Dólar Estadounidense (USD)</option>
                    <option value="GBP">Libra Esterlina (GBP)</option>
                </select><br><br>

                <button type="submit">Calcular Conversión</button>
            </form>
        </div>

        <?php if ($resultado): ?>
            <div class="mensaje exito"><?= htmlspecialchars($resultado) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

    </body>
    </html>
    ```
