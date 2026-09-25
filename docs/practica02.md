# PRÁCTICA DE AULA 02: INICIACIÓN A POSTMAN Y PETICIONES HTTP (GET / POST)

## PASO 1: CREACIÓN DE ARCHIVO PHP

Abre la carpeta ```misitio```en VS Code y crea o modifica el archivo `index.php` con el siguiente código:

```php
<?php
// Indicamos al cliente que la respuesta siempre será en formato JSON
header("Content-Type: application/json; charset=UTF-8");

//Obtenemos el método de envío de datos del cliente
$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
    // Lectura de parámetros enviados por la URL (Query Params)
    $categoria = $_GET['categoria'] ?? 'todas';
    
    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "metodo" => "GET",
        "mensaje" => "Consulta realizada correctamente",
        "categoria_filtrada" => $categoria
    ]);

} elseif ($metodo === 'POST') {
    // Lectura del cuerpo de la petición enviado en JSON
    $input = json_decode(file_get_contents('php://input'), true);

    // Validación básica de campos obligatorios
    if (!isset($input['usuario']) || !isset($input['email'])) {
        http_response_code(400); // Bad Request
        echo json_encode([
            "status" => "error",
            "mensaje" => "Faltan datos obligatorios: 'usuario' y 'email'"
        ]);
    } else {
        http_response_code(201); // Created
        echo json_encode([
            "status" => "success",
            "metodo" => "POST",
            "mensaje" => "Usuario registrado con éxito",
            "datos_recibidos" => $input
        ]);
    }

} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["status" => "error", "mensaje" => "Método no soportado"]);
}

```

---

## PASO 2: PRUEBAS EN POSTMAN

Abre Postman y crea una nueva **Collection** llamada **"DWES - PRACTICA 01"**.

---

### Request 1: Petición `GET` con "Query Parameters"

1. Haz clic en **New Request** y ponle de nombre `01 - Obtener Categoria`.
2. Selecciona el método **`GET`**.
3. En la barra de URL introduce: `https://misitio.test`
4. Selecciona la pestaña **Params** debajo de la URL y añade la siguiente fila:
* **Key:** `categoria`
* **Value:** `portatiles`


5. Observa cómo la URL cambia automáticamente a `[http://misitio.test?categoria=portatiles](http://misitio.test?categoria=portatiles)`.
6. Haz clic en **Send**.

#### 🔍 Verificación:

* Código de respuesta: **`200 OK`**.
* En el panel de respuesta (*Body*), verás un JSON donde `"categoria_filtrada"` vale `"portatiles"`.

---

#### Request 2: Petición `POST` enviando un JSON (20 min)

1. Crea una nueva petición en la colección llamada `02 - Crear Usuario`.
2. Selecciona el método **`POST`**.
3. En la URL escribe: `https://misitio.test`
4. Ve a la pestaña **Body**, selecciona la opción **raw** y cambia el desplegable lateral a **JSON**.
5. Pega la siguiente estructura en el área de texto:
```json
{
  "usuario": "Carlos",
  "email": "carlos@ieslosalbares.es"
}

```

6. Haz clic en **Send**.

#### 🔍 Verificación y Pruebas de Fallo:
* **Prueba Correcta:** Devuelve un código **`201 Created`** confirmando que el servidor ha leído el usuario y el email.
* **Prueba de Error (Bad Request):** Borra la línea del `"email"` en tu JSON y reenvía la petición. Comprueba que el servidor responde con un código **`400 Bad Request`** y un mensaje de error.

---

### 5. TRABAJO Y REGISTRO EN LIBRETA DE CLASE `[LIBRETA]` 

Copia y responde en tu cuaderno personal las siguientes preguntas al finalizar la práctica:

1. **[LIBRETA]** ¿Cuál es la diferencia visual y técnica entre enviar el parámetro `categoria` mediante el método `GET` frente a enviar `usuario` y `email` en la petición `POST`?
2. **[LIBRETA]** ¿Por qué en PHP no se puede usar la variable `$_POST` para leer datos cuando los enviamos desde Postman en formato `JSON` (raw), y qué función usamos en su lugar?
3. **[LIBRETA]** Completa la tabla en tu cuaderno:

| Método | Pestaña usada en Postman | Código HTTP Correcto | Código HTTP cuando faltan datos |
| :--- | :--- | :--- | :--- |
| **GET** | *Params* (Query) | `200 OK` | N/A |
| **POST** | *Body* (raw JSON) | | |
