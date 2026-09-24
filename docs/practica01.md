# PRÁCTICA GUIADA 01:  CONFIGURACIÓN DE VS CODE PARA DESARROLLO EN PHP

## PASO 1: LOCALIZACIÓN DEL BINARIO DE PHP (10 MIN)

Antes de configurar el editor, debes conocer la ruta exacta donde está instalado el ejecutable de PHP en tu sistema operativo.

1. Abre la terminal de tu sistema y ejecuta:

  **En Linux / macOS:**
  ```bash
  which php
  ```
  **En Windows (CMD / PowerShell):**
  ```cmd
  where php
  ```

/// admonition | Ruta habitual
    type: hint

La ruta habitual en nuestro caso, ya que usamos Lerd/Herd con la versión 8.4 de PHP, es `C:\Users\usuario\.config\herd\bin\php84\php.exe`, donde `usuario` es tu nombre de usuario de Windows. 
///


2. **`[LIBRETA]`** Anota en tu cuaderno de clase la ruta exacta que te ha devuelto la terminal.

---

## 4. PASO 2: EXTENSIONES IMPRESCINDIBLES (20 MIN)

Abre la pestaña de extensiones en VS Code (`Ctrl + Shift + X` o `Cmd + Shift + X`) e instala las siguientes extensiones:

1. **PHP Intelephense** *(por Ben Mewburn)*:
* *Función:* El motor de Inteligencia de Código más potente para PHP. Proporciona autocompletado, navegación a definiciones (`F12`), verificación de tipos y detección de errores sintácticos en tiempo real.


2. **PHP Debug** *(por Xdebug)*:
* *Función:* Permite pausar la ejecución del código con puntos de interrupción (*breakpoints*) para inspeccionar variables.


3. **PHP CS Fixer** *(por junstyle)*:
* *Función:* Formatea el código PHP automáticamente según los estándares internacionales de codificación (**PSR-12**).

4. **PHP** *(por devsense)*:
* *Función:* Proporciona una serie de herramientas para PHP.

Una vez instaladas, verifica que aparecen en la lista de extensiones:

![Extensiones Instaladas](img/pr01-img03.png)

---

## 5. PASO 3: CONFIGURACIÓN DE `settings.json` (15 MIN)

Accede a la configuración avanzada de VS Code presionado `Ctrl + Shift + P` (o `Cmd + Shift + P`), escribe **`Preferences: Open User Settings (JSON)`** y pulsa Enter.

Añade las siguientes claves de configuración en tu archivo `settings.json`:

```json
{
  // 1. Ruta al ejecutable de PHP para validación de errores
  "php.validate.executablePath": "Users/usuario/.config/herd/bin/php84/php.exe",

  // 2. Desactivar el autocompletado nativo básico para evitar duplicados con Intelephense
  "php.suggest.basic": false,

  // 3. Configuración específica para archivos PHP
  "[php]": {
    "editor.defaultFormatter": "bmewburn.vscode-intelephense-client",
    "editor.formatOnSave": true,
    "editor.tabSize": 4,
    "editor.insertSpaces": true
  },

  // 4. Versión objetivo de PHP para Intelephense
  "intelephense.environment.phpVersion": "8.4",

  // 5. Configuración de formateo PSR-12
  "php-cs-fixer.rules": "@PSR12"
}

```

/// admonition | **Atención:**
    type: attention
    
Reemplaza la ruta de la primera línea por la ruta real anotada en el Paso 1.
///

---

## 6. PASO 4: CREACIÓN DE UN SNIPPET Y PRUEBA PRÁCTICA (15 MIN)

### Creación del Snippet

1. Ve a **File > Preferences > Configure User Snippets** (o *Archivo > Preferencias > Snippets de usuario*).
2. Selecciona **php**.
3. Pega la siguiente plantilla para generar estructuras base de páginas PHP:

```json
{
  "Plantilla Base PHP": {
    "prefix": "phpbase",
    "body": [
      "<?php",
      "declare(strict_types=1);",
      "",
      "// Módulo: DWES - IES Los Albares",
      "?>",
      "<!DOCTYPE html>",
      "<html lang=\"es\">",
      "<head>",
      "    <meta charset=\"UTF-8\">",
      "    <title>\${1:Título}</title>",
      "</head>",
      "<body>",
      "    <h1><?php echo \"\${2:Hola Mundo}\"; ?></h1>",
      "</body>",
      "</html>"
    ],
    "description": "Genera la estructura base de una página con PHP y HTML5"
  }
}

```

### Verificación

Crea un archivo de prueba llamado `test-entorno.php`, escribe `phpbase` y presiona `Tab`. Comprueba que la plantilla se despliega y que al guardar el archivo (`Ctrl + S`) el código se auto-formatea.

---

## 7. TRABAJO Y REGISTRO EN LIBRETA DE CLASE `[LIBRETA]`

Copia y responde en tu libreta las siguientes cuestiones al finalizar la práctica:

1. **[LIBRETA]** Escribe la línea exacta de `settings.json` que activa la opción para que el código PHP se formatee automáticamente al guardar el archivo.
2. **[LIBRETA]** Explica qué función cumple la directiva `declare(strict_types=1);` generada en nuestro *Snippet* y por qué es una buena práctica en PHP 8.x.
3. **[LIBRETA]** ¿Por qué deshabilitamos la opción `"php.suggest.basic": false` tras instalar la extensión **PHP Intelephense**?

---
