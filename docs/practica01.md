# PRÁCTICA GUIADA 01: ```python
import docx
from docx.shared import Inches, Pt, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_TABLE_ALIGNMENT
from docx.oxml import OxmlElement, parse_xml
from docx.oxml.ns import nsdecls, qn

doc = docx.Document()

# Margins
for section in doc.sections:
    section.top_margin = Inches(1)
    section.bottom_margin = Inches(1)
    section.left_margin = Inches(1)
    section.right_margin = Inches(1)

COLOR_PRIMARY = RGBColor(0x1A, 0x36, 0x5D)
COLOR_SECONDARY = RGBColor(0x2B, 0x6C, 0xB0)
COLOR_TEXT = RGBColor(0x2D, 0x37, 0x48)

def set_cell_background(cell, fill_hex):
    tcPr = cell._element.get_or_add_tcPr()
    shd = parse_xml(f'<w:shd {nsdecls("w")} w:fill="{fill_hex}"/>')
    tcPr.append(shd)

def set_cell_margins(cell, top=100, bottom=100, left=150, right=150):
    tcPr = cell._element.get_or_add_tcPr()
    tcMar = OxmlElement('w:tcMar')
    for m, val in [('top', top), ('bottom', bottom), ('left', left), ('right', right)]:
        node = OxmlElement(f'w:{m}')
        node.set(qn('w:w'), str(val))
        node.set(qn('w:type'), 'dxa')
        tcMar.append(node)
    tcPr.append(tcMar)

# Title Banner
table = doc.add_table(rows=1, cols=1)
table.alignment = WD_TABLE_ALIGNMENT.CENTER
cell = table.cell(0, 0)
set_cell_background(cell, "1A365D")
set_cell_margins(cell, top=200, bottom=200, left=200, right=200)

p = cell.paragraphs[0]
p.alignment = WD_ALIGN_PARAGRAPH.CENTER
run = p.add_run("DESARROLLO WEB EN ENTORNO SERVIDOR (DWES)\nPRÁCTICA DE AULA (1 HORA): CONFIGURACIÓN ENTORNO PROFESIONAL VS CODE PARA PHP")
run.font.name = 'Arial'
run.font.size = Pt(12)
run.font.bold = True
run.font.color.rgb = RGBColor(0xFF, 0xFF, 0xFF)

doc.add_paragraph()
p_meta = doc.add_paragraph()
p_meta.paragraph_format.space_after = Pt(8)

def add_meta(label, val):
    r1 = p_meta.add_run(f"{label}: ")
    r1.bold = True
    r1.font.size = Pt(9.5)
    r1.font.color.rgb = COLOR_PRIMARY
    r2 = p_meta.add_run(f"{val}\n")
    r2.font.size = Pt(9.5)
    r2.font.color.rgb = COLOR_TEXT

add_meta("Centro", "IES Los Albares (Cieza, Región de Murcia)")
add_meta("Curso Escolar", "2026 / 2027 | 2º DAW (4PAW)")
add_meta("Módulo", "Desarrollo Web en Entorno Servidor (DWES) - UT1")
add_meta("Duración", "60 minutos (1 sesión lectiva)")
add_meta("Herramientas", "VS Code, PHP 8.x, Lerd/Herd, Extensiones de Mercado y Libreta de Clase")

def add_h(text, level=1):
    h = doc.add_paragraph()
    h.paragraph_format.space_before = Pt(10)
    h.paragraph_format.space_after = Pt(4)
    h.paragraph_format.keep_with_next = True
    r = h.add_run(text)
    r.font.name = 'Arial'
    r.bold = True
    if level == 1:
        r.font.size = Pt(11)
        r.font.color.rgb = COLOR_PRIMARY
    else:
        r.font.size = Pt(10)
        r.font.color.rgb = COLOR_SECONDARY
    return h

add_h("1. Objetivos de la Práctica")
p_obj = doc.add_paragraph()
p_obj.paragraph_format.space_after = Pt(4)
for b in [
    "Instalar y personalizar Visual Studio Code para un flujo de trabajo optimizado en PHP 8.x.",
    "Configurar el ejecutable del intérprete de PHP y las reglas de formateo automático (PSR-12).",
    "Instalar extensiones clave: PHP Intelephense, PHP Executable Code, PHP Debug y PHP CS Fixer.",
    "Crear y probar un workspace con variables de entorno de depuración básica y Snippets personalizados."
]:
    p = doc.add_paragraph(style='List Bullet')
    p.paragraph_format.space_after = Pt(2)
    r = p.add_run(b)
    r.font.size = Pt(9)

add_h("2. Distribución de Tiempos (60 Minutos)")
tbl_t = doc.add_table(rows=5, cols=4)
tbl_t.alignment = WD_TABLE_ALIGNMENT.CENTER
headers_t = ["Paso", "Tiempo", "Actividad", "Herramienta"]
data_t = [
    ["Paso 1", "10 min", "Instalación de VS Code y vincular binario de PHP en settings.json", "Terminal / VS Code"],
    ["Paso 2", "20 min", "Instalación de extensiones imprescindibles (Intelephense, CS Fixer, Snippets)", "Marketplace VS Code"],
    ["Paso 3", "15 min", "Configuración de archivo settings.json (Format on Save, PSR-12)", "VS Code"],
    ["Paso 4", "15 min", "Prueba de snippet personalizado y registro en la libreta", "Libreta [LIBRETA]"]
]

for i, h in enumerate(headers_t):
    tbl_t.rows[0].cells[i].text = h
    set_cell_background(tbl_t.rows[0].cells[i], "1A365D")
    p = tbl_t.rows[0].cells[i].paragraphs[0]
    p.alignment = WD_ALIGN_PARAGRAPH.CENTER
    for run in p.runs:
        run.font.bold = True
        run.font.color.rgb = RGBColor(0xFF, 0xFF, 0xFF)
        run.font.size = Pt(8.5)

for row_idx, row in enumerate(data_t):
    for col_idx, val in enumerate(row):
        c = tbl_t.rows[row_idx+1].cells[col_idx]
        c.text = val
        set_cell_background(c, "F7FAFC" if row_idx % 2 == 0 else "FFFFFF")
        set_cell_margins(c, top=50, bottom=50, left=70, right=70)
        p = c.paragraphs[0]
        for run in p.runs:
            run.font.size = Pt(8)

add_h("3. Configuración del Archivo settings.json")
p_code = doc.add_paragraph()
p_code.paragraph_format.space_after = Pt(6)
r_code = p_code.add_run(
    "{\n"
    '  "php.validate.executablePath": "/usr/bin/php", // o C:/Users/usuario/.config/herd/bin/php.exe\n'
    '  "php.suggest.basic": false, // Desactiva el autocompletado nativo en favor de Intelephense\n'
    '  "[php]": {\n'
    '    "editor.defaultFormatter": "bmewburn.vscode-intelephense-client",\n'
    '    "editor.formatOnSave": true,\n'
    '    "editor.tabSize": 4\n'
    '  },\n'
    '  "intelephense.environment.phpVersion": "8.3.0"\n'
    "}"
)
r_code.font.name = 'Courier New'
r_code.font.size = Pt(8.5)

add_h("4. Trabajo y Registro en Libreta de Clase [LIBRETA]")
p_tests = doc.add_paragraph()
p_tests.paragraph_format.space_after = Pt(4)
r_tests = p_tests.add_run(
    "1. Copia en tu cuaderno la ruta absoluta de tu ejecutable PHP obtenida mediante 'which php' o 'where php'.\n"
    "2. Explica la función de la propiedad 'php.suggest.basic: false' y por qué se desactiva al usar Intelephense.\n"
    "3. Escribe en tu libreta el código JSON de un Snippet personalizado que genere automáticamente la cabecera HTML5 básica con bloques PHP."
)
r_tests.font.size = Pt(9)

path_out = "Practica_DWES_VSCode_PHP_Entorno_Profesional.docx"
doc.save(path_out)
print(f"File saved: {path_out}")


```

```text
File saved: Practica_DWES_VSCode_PHP_Entorno_Profesional.docx


```

Aquí tienes una **práctica guiada de 1 hora lectiva (60 minutos)** estructurada para la asignatura de **Desarrollo Web en Entorno Servidor (DWES)**.

Está enfocada en instalar, configurar y optimizar **Visual Studio Code** como IDE profesional para el desarrollo con **PHP 8.x**, enlazando la configuración de archivos JSON con el registro en la **Libreta de Clase `[LIBRETA]**`.

---

# PRÁCTICA DE AULA (60 MINUTOS): CONFIGURACIÓN DE VS CODE PARA DESARROLLO EN PHP

* **Módulo:** Desarrollo Web en Entorno Servidor (DWES)
* **Curso:** 2º DAW | Curso 2026/2027 | IES Los Albares (Cieza)
* **Duración:** 60 minutos (1 sesión lectiva)
* **Requisitos:** Equipo informático (Linux/Windows), VS Code, PHP 8.x y cuaderno de clase.

---

## 1. OBJETIVOS

1. Instalar y configurar **Visual Studio Code** vinculando el intérprete de PHP local.
2. Instalar el paquete de extensiones imprescindibles para análisis estático, autocompletado y formateo automático de código según la norma **PSR-12**.
3. Personalizar el archivo de configuración global `settings.json` y crear *Snippets* (plantillas de código) para acelerar la maquetación de archivos PHP dinámicos.

---

## 2. DISTRIBUCIÓN DE TIEMPOS (60 MINUTOS)

| Fase | Tiempo | Actividad | Herramienta |
| --- | --- | --- | --- |
| **Fase 1** | 10 min | Localización del binario PHP y vinculación con VS Code | Terminal / VS Code |
| **Fase 2** | 20 min | Instalación del pack de extensiones profesionales | Marketplace VS Code |
| **Fase 3** | 15 min | Configuración de `settings.json` (Format on Save, PSR-12) | VS Code |
| **Fase 4** | 15 min | Creación de *Snippets* y verificación en libreta | Libreta `[LIBRETA]` |

---

## 3. PASO 1: LOCALIZACIÓN DEL BINARIO DE PHP (10 MIN)

Antes de configurar el editor, debes conocer la ruta exacta donde está instalado el ejecutable de PHP en tu sistema operativo.

1. Abre la terminal de tu sistema y ejecuta:
* **En Linux / macOS:**
```bash
which php

```


*(Ruta habitual: `/usr/bin/php` o la ruta de tu entorno Lerd/Herd).*
* **En Windows (CMD / PowerShell):**
```cmd
where php

```


*(Ruta habitual: `C:\php\php.exe` o `C:\Users\usuario\.config\herd\bin\php.exe`).*


2. **`[LIBRETA]`** Anota en tu cuaderno de clase la ruta exacta que te ha devuelto la terminal.

---

## 4. PASO 2: EXTENSIONES IMPRESCINDIBLES (20 MIN)

Abre la pestaña de extensiones en VS Code (`Ctrl + Shift + X` o `Cmd + Shift + X`) e instala los siguientes paquetes esenciales:

1. **PHP Intelephense** *(por Ben Mewburn)*:
* *Función:* El motor de Inteligencia de Código más potente para PHP. Proporciona autocompletado, navegación a definiciones (`F12`), verificación de tipos y detección de errores sintácticos en tiempo real.


2. **PHP Debug** *(por Xdebug)*:
* *Función:* Permite pausar la ejecución del código con puntos de interrupción (*breakpoints*) para inspeccionar variables.


3. **PHP CS Fixer** *(por junstyle)*:
* *Función:* Formatea el código PHP automáticamente según los estándares internacionales de codificación (**PSR-12**).


4. **PHP Snippets** *(por devsense)*:
* *Función:* Proporciona atajos de teclado para escribir estructuras repetitivas (`try-catch`, `foreach`, estructuras de clases PDO).



---

## 5. PASO 3: CONFIGURACIÓN DE `settings.json` (15 MIN)

Accede a la configuración avanzada de VS Code presionado `Ctrl + Shift + P` (o `Cmd + Shift + P`), escribe **`Preferences: Open User Settings (JSON)`** y pulsa Enter.

Añade las siguientes claves de configuración en tu archivo `settings.json`:

```json
{
  // 1. Ruta al ejecutable de PHP para validación de errores
  "php.validate.executablePath": "/usr/bin/php",

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
  "intelephense.environment.phpVersion": "8.3.0",

  // 5. Configuración de formateo PSR-12
  "php-cs-fixer.rules": "@PSR12"
}

```

> **Atención:** Reemplaza `/usr/bin/php` por la ruta real anotada en el Paso 1.

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
