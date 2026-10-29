# UT 03 - EJEMPLO DE PROCESAMIENTO DE FORMULARIOS

## ARHCHIVO DE FORMULARIO

El archivo 'formulario.html' muestra una serie de campos de formulario diferentes y llama a 'ejemplo-res.php' como accción del formulario:

```php
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio de Ejemplo - Elementos de Entrada</title>
    <style>
        @import "https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css";
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <section class="section">
        <div class="container" style="max-width: 700px;">
            <div class="card">
                <header class="card-header has-background-info">
                    <p class="card-header-title has-text-white">
                        <i class="fa fa-list-alt mr-2"></i> Elementos de Entrada
                    </p>
                </header>
                <div class="card-content">
                    
                    <!-- ATENCIÓN ALUMNO: enctype es obligatorio cuando enviamos archivos con $_FILES -->
                    <form action="ejemplo-res.php" method="POST" enctype="multipart/form-data">
                        
                        <!-- Campo oculto (HIDDEN) -->
                        <input type="hidden" name="token_sesion" value="XYZ987654321">

                        <h2 class="title is-5 has-text-info">Elementos de tipo INPUT</h2>

                        <!-- INPUT TEXT -->
                        <div class="field">
                            <label class="label">TEXT</label>
                            <label class="subtitle is-6" for="cadena">Introduzca la cadena a buscar:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" id="cadena" name="cadena" value="valor por defecto">
                                <span class="icon is-small is-left"><i class="fa fa-font"></i></span>
                            </div>
                        </div>

                        <!-- INPUT RADIO -->
                        <div class="field">
                            <label class="label">RADIO</label>
                            <div class="control">
                                <span class="mr-3">Sexo:</span>
                                <label class="radio">
                                    <input type="radio" name="sexo" value="Mujer" checked> Mujer
                                </label>
                                <label class="radio">
                                    <input type="radio" name="sexo" value="Hombre"> Hombre
                                </label>
                            </div>
                        </div>

                        <!-- INPUT CHECKBOX (Array extras[]) -->
                        <div class="field">
                            <label class="label">CHECKBOX</label>
                            <div class="control">
                                <span class="mr-3">Extras:</span>
                                <label class="checkbox mr-2">
                                    <input type="checkbox" name="extras[]" value="Garaje"> Garaje
                                </label>
                                <label class="checkbox mr-2">
                                    <input type="checkbox" name="extras[]" value="Piscina"> Piscina
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" name="extras[]" value="Jardín"> Jardín
                                </label>
                            </div>
                        </div>

                        <!-- INPUT FILE -->
                        <div class="field">
                            <label class="label">FILE</label>
                            <div class="file has-name is-fullwidth">
                                <label class="file-label">
                                    <input class="file-input" type="file" name="fichero">
                                    <span class="file-cta">
                                        <span class="file-icon"><i class="fa fa-upload"></i></span>
                                        <span class="file-label">Examinar…</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- INPUT PASSWORD -->
                        <div class="field">
                            <label class="label">PASSWORD</label>
                            <label class="subtitle is-6" for="password">Contraseña:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="password" id="password" name="password" placeholder="••••••••">
                                <span class="icon is-small is-left"><i class="fa fa-lock"></i></span>
                            </div>
                        </div>

                        <hr>
                        <h2 class="title is-5 has-text-info">Elemento SELECT</h2>

                        <!-- SELECT SIMPLE -->
                        <div class="field">
                            <label class="label">SELECT SIMPLE</label>
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label" for="color">Color:</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select">
                                                <select name="color" id="color">
                                                    <option value="Rojo" selected>Rojo</option>
                                                    <option value="Verde">Verde</option>
                                                    <option value="Azul">Azul</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SELECT MÚLTIPLE (Array idiomas[]) -->
                        <div class="field">
                            <label class="label">SELECT MÚLTIPLE</label>
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label" for="idiomas">Idiomas:</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select is-multiple">
                                                <select name="idiomas[]" id="idiomas" multiple size="3">
                                                    <option value="Inglés" selected>Inglés</option>
                                                    <option value="Francés">Francés</option>
                                                    <option value="Alemán">Alemán</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h2 class="title is-5 has-text-info">Elemento TEXTAREA</h2>

                        <!-- TEXTAREA -->
                        <div class="field">
                            <label class="label" for="comentario">Comentario:</label>
                            <div class="control">
                                <textarea class="textarea" id="comentario" name="comentario" rows="3">Este libro me parece ...</textarea>
                            </div>
                        </div>

                        <!-- BOTONES DE ENVÍO Y BORRADO -->
                        <div class="field is-grouped mt-5">
                            <div class="control">
                                <button type="submit" class="button is-link">
                                    <i class="fa fa-paper-plane mr-2"></i> Enviar datos
                                </button>
                            </div>
                            <div class="control">
                                <button type="reset" class="button is-light">
                                    <i class="fa fa-eraser mr-2"></i> Borrar datos
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
```
## PROCESADO DEL FORMULARIO

El archivo 'ejemplo-res.php' procesa el formulario anterior:

```php
<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ejemplo.php");
    exit();
}

// 1. Recepción del texto e input hidden
$cadena = htmlspecialchars($_POST['cadena'] ?? '', ENT_QUOTES, 'UTF-8');
$tokenHidden = htmlspecialchars($_POST['token_sesion'] ?? '', ENT_QUOTES, 'UTF-8');

// 2. Recepción del sexo (Radio Button)
$sexo = htmlspecialchars($_POST['sexo'] ?? 'No especificado', ENT_QUOTES, 'UTF-8');

// 3. Recepción de Checkboxes (Array 'extras')
// Si el usuario no marca ninguna opción, la clave no estará definida en $_POST.
$extras = $_POST['extras'] ?? [];
$extrasTexto = !empty($extras) ? implode(', ', array_map('htmlspecialchars', $extras)) : 'Ningún extra seleccionado';

// 4. Recepción de contraseña
$password = $_POST['password'] ?? '';
$passwordOculta = str_repeat('•', mb_strlen($password));

// 5. Recepción del Select Simple
$color = htmlspecialchars($_POST['color'] ?? 'No seleccionado', ENT_QUOTES, 'UTF-8');

// 6. Recepción del Select Múltiple (Array 'idiomas')
$idiomas = $_POST['idiomas'] ?? [];
$idiomasTexto = !empty($idiomas) ? implode(', ', array_map('htmlspecialchars', $idiomas)) : 'Ningún idioma seleccionado';

// 7. Recepción del Textarea
$comentario = htmlspecialchars($_POST['comentario'] ?? '', ENT_QUOTES, 'UTF-8');

// 8. Recepción del archivo mediante la superglobal $_FILES
$ficheroInfo = "No se ha subido ningún archivo";
if (isset($_FILES['fichero']) && $_FILES['fichero']['error'] === UPLOAD_ERR_OK) {
    $nombreOriginal = htmlspecialchars($_FILES['fichero']['name'], ENT_QUOTES, 'UTF-8');
    $tamanoBytes = $_FILES['fichero']['size'];
    $tipoMime = htmlspecialchars($_FILES['fichero']['type'], ENT_QUOTES, 'UTF-8');
    
    $ficheroInfo = "Archivo: <strong>$nombreOriginal</strong> ($tamanoBytes bytes, Tipo: $tipoMime)";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2 - Resultados</title>
    <style>
        @import "https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css";
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <section class="section">
        <div class="container" style="max-width: 800px;">
            <div class="card">
                <header class="card-header has-background-success">
                    <p class="card-header-title has-text-white">
                        <i class="fa fa-database mr-2"></i> Datos Recibidos del Formulario
                    </p>
                </header>
                <div class="card-content">
                    
                    <table class="table is-bordered is-striped is-hoverable is-fullwidth">
                        <thead>
                            <tr class="has-background-link-light">
                                <th>Elemento</th>
                                <th>Valor Recibido</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Campo Oculto (HIDDEN)</strong></td>
                                <td><code><?= $tokenHidden ?></code></td>
                            </tr>
                            <tr>
                                <td><strong>Cadena a buscar (TEXT)</strong></td>
                                <td><?= $cadena ?></td>
                            </tr>
                            <tr>
                                <td><strong>Sexo (RADIO)</strong></td>
                                <td><?= $sexo ?></td>
                            </tr>
                            <tr>
                                <td><strong>Extras (CHECKBOX)</strong></td>
                                <td><?= $extrasTexto ?></td>
                            </tr>
                            <tr>
                                <td><strong>Fichero (FILE)</strong></td>
                                <td><?= $ficheroInfo ?></td>
                            </tr>
                            <tr>
                                <td><strong>Contraseña (PASSWORD)</strong></td>
                                <td><?= $passwordOculta ?> <em>(Enmascarada por seguridad)</em></td>
                            </tr>
                            <tr>
                                <td><strong>Color (SELECT SIMPLE)</strong></td>
                                <td><span class="tag is-info"><?= $color ?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Idiomas (SELECT MÚLTIPLE)</strong></td>
                                <td><?= $idiomasTexto ?></td>
                            </tr>
                            <tr>
                                <td><strong>Comentario (TEXTAREA)</strong></td>
                                <td><blockquote class="p-2"><?= nl2br($comentario) ?></blockquote></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="field mt-5">
                        <a href="ejemplo.php" class="button is-link is-outlined is-fullwidth">
                            <i class="fa fa-arrow-left mr-2"></i> Volver al formulario
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
</body>
</html>
```
