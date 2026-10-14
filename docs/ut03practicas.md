# BOLETÍN DE PRÁCTICAS: UT 03 - PHP INTEGRADO EN HTML

**Asignatura:** Desarrollo Web en Entorno Servidor

**Unidad Temática:** UT 03 - Programación en PHP integrado en HTML

**Duración Total Estimada:** 2.5 Horas (5 prácticas de 30 minutos)

---

## PRÁCTICA 1: Tarjeta de Perfil Dinámica con Sintaxis Alternativa

**Duración estimada:** 30 minutos

**Objetivos:** Practicar la sintaxis alternativa de estructuras condicionales (`if/endif`, `match`) y la etiqueta corta de impresión (`<?= ?>`) integrada en código HTML.

### Enunciado

Crea un script PHP denominado `perfil.php` que simule la visualización de la tarjeta de un usuario en un panel de administración.

1. Define al inicio del script las variables `$nombre` (cadena), `$edad` (entero) y `$rol` (cadena con valores posibles: `'admin'`, `'editor'`, `'autor'`, `'invitado'`).
2. Mediante una expresión `match`, asigna una clase CSS de tipo badge (`'bg-danger'`, `'bg-warning'`, `'bg-info'`, `'bg-secondary'`) y una etiqueta descriptiva según el rol.
3. Genera la estructura HTML de una tarjeta (*card*) de usuario utilizando la **sintaxis alternativa** (`<?php if (...): ?> ... <?php endif; ?>`) para:
* Mostrar el nombre del usuario con la etiqueta corta `<?= $nombre ?>`.
* Mostrar un mensaje especial si el usuario es mayor de edad ($\ge 18$).
* Renderizar el badge con el rol del usuario utilizando la clase CSS obtenida con `match`.



---

## PRÁCTICA 2: Catálogo Dinámico con Arrays y Bucles Embebidos

**Duración estimada:** 30 minutos

**Objetivos:** Manipular arrays multidimensionales asociativos y recorrerlos en HTML mediante `foreach: ... endforeach;`.

### Enunciado

Crea un fichero `catalogo.php` que muestre una tabla HTML con el inventario de una tienda de informática.

1. Define un array multidimensional `$productos` donde cada elemento sea un array asociativo con las claves: `'nombre'`, `'categoria'`, `'precio'` y `'stock'`. Añade al menos 4 productos.
2. Utiliza funciones de arrays para:
* Obtener el número total de productos con `count()`.
* Ordenar el array por precio de menor a mayor con una función de ordenación o `usort()`.


3. Construye la tabla HTML embebiendo PHP mediante la sintaxis alternativa `foreach`:
* Muestra las filas alternando un estilo si el producto está **Agotado** (`stock == 0`).
* Formatea el precio agregando el símbolo de la moneda (`€`).
* Al final de la tabla, incluye un pie de tabla (`<tfoot>`) que muestre la cantidad total de artículos listados.



---

## PRÁCTICA 3: Calculadora de Presupuestos con Funciones y Arrow Functions

**Duración estimada:** 30 minutos

**Objetivos:** Declarar e invocar funciones con tipado estricto, parámetros por defecto y hacer uso de *Arrow Functions*.

### Enunciado

Crea el archivo `presupuesto.php` para calcular el coste final de un servicio web.

1. Activa el modo estricto de tipos (`declare(strict_types=1);`).
2. Crea una función llamada `calcularPresupuesto` con la siguiente firma:
```php
function calcularPresupuesto(float $precioBase, float $descuento = 0.0, float $iva = 0.21): float

```


* La función debe aplicar el descuento al precio base y, sobre el subtotal resultante, aplicar el IVA.


3. Define una *Arrow Function* (`fn`) asignada a una variable `$formatearMoneda` que reciba un `float` y devuelva el número formateado con 2 decimales y el sufijo `€`.
4. Invoca a la función con tres casos distintos (ej. sin descuento, con 10% de descuento y con IVA reducido al 10%) y muestra los resultados dentro de una lista ordenada HTML (`<ol>`).

---

## PRÁCTICA 4: Formulario de Contacto Seguro y Validación

**Duración estimada:** 30 minutos

**Objetivos:** Capturar peticiones HTTP POST, aplicar el patrón PRG, sanitizar entradas con `filter_input()` y prevenir ataques XSS.

### Enunciado

Crea una página de registro/contacto en un único archivo PHP denominado `contacto.php` (o separado en `contacto.html` y `procesar.php`).

1. Comprueba si la petición se ha realizado mediante el método `POST` usando `$_SERVER['REQUEST_METHOD']`.
2. Si es una petición `POST`:
* Sanitiza el campo `'nombre'` usando `FILTER_SANITIZE_SPECIAL_CHARS`.
* Valida el campo `'email'` con `FILTER_VALIDATE_EMAIL`.
* Valida el campo `'edad'` con `FILTER_VALIDATE_INT` asegurando que esté en el rango de 18 a 99 años.
* Si hay errores de validación, almacénalos en un array `$errores` y muéstralos en una lista roja HTML sobre el formulario.
* Si los datos son válidos, muestra un mensaje de éxito escapando la salida con `htmlspecialchars()`.


3. Si la petición es `GET`, muestra el formulario HTML de entrada limpio.

---

## PRÁCTICA 5: Subida Segura de Archivos al Servidor

**Duración estimada:** 30 minutos

**Objetivos:** Procesar envíos `multipart/form-data`, interactuar con la superglobal `$_FILES` y verificar tipos MIME reales con `finfo`.

### Enunciado

Desarrolla un módulo de subida de avatares/documentos en `subida.php`.

1. Crea un formulario HTML con el atributo `enctype="multipart/form-data"` que contenga un campo de tipo `file` llamado `'documento'`.
2. Al recibir el formulario en PHP:
* Comprueba que no haya habido errores de transferencia (`$_FILES['documento']['error'] === UPLOAD_ERR_OK`).
* Limita el tamaño máximo permitido a **2 MB** (`2 * 1024 * 1024` bytes).
* Verifica el tipo MIME **real** del archivo temporal utilizando la extensión `finfo` (solo se deben permitir imágenes `image/jpeg` y `image/png`).
* Genera un nombre de archivo único e impredecible utilizando `bin2hex(random_bytes(16))` y conserva su extensión original.
* Mueve el archivo a la carpeta `uploads/` mediante `move_uploaded_file()` y confirma la operación al usuario en pantalla.
