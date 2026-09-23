# PRÁCTICA GUIADA 01: DESPLIEGUE DE DOCUMENTACIÓN TÉCNICA CON PROPERDOCS Y TEMA "READTHEDOCS"

---

## 1. PREPARACIÓN DEL ENTORNO DE TRABAJO.

/// admonition | **REQUISITOS PREVIOS**
    type: warning

Esta práctica asume que se ha instalado y configurado [GIT](https://git-scm.com) en el equipo del alumno y que se está usando una máquina Windows.
///

### Paso 1: Crear el repositorio en GitHub.la carpeta del proyecto y el entorno virtual

Se debe crear con el nombre de ```proyecto2627``` y ser pública. El archivo ```README.md``` debe incluir infiormación básica del proyecto y la asignatura.

### Paso 2: instalar el cliente de GitHub para la terminal.

Entra en la página [cli.github.com](https://cli.github.com) y sigue los pasos para instalar el cliente de terminal en el equipo.

### Paso 3: configura las credenciales de GitHub para tu cliente

Ejecuta el comando ```gh auth login`` y sigue los pasos

Abre la terminal en tu equipo de trabajo o dentro de tu contenedor/entorno Lerd y crea el directorio donde alojarás la documentación:

```bash
# Crear directorio para la documentación del proyecto
mkdir -p ~/proyectos/documentacion-dwes
cd ~/proyectos/documentacion-dwes

# Crear un entorno virtual de Python para aislar dependencias
python3 -m venv venv

# Activar el entorno virtual
source venv/bin/activate

```

> **Nota:** Verás que la línea de comandos ahora muestra el prefijo `(venv)`. Esto confirma que cualquier paquete instalado mediante `pip` no afectará al sistema global de Linux.

---

## 3. INSTALACIÓN DE MKDOCS Y EL TEMA READTHEDOCS

### Paso 2: Instalación de paquetes con `pip`

Con el entorno virtual activado, instala el paquete principal de MkDocs y el paquete del tema Read the Docs:

```bash
# Actualizar pip
pip install --upgrade pip

# Instalar MkDocs y el tema readthedocs
pip install mkdocs mkdocs-readthedocs-theme

```

Para verificar que la instalación se ha realizado correctamente, ejecuta:

```bash
mkdocs --version

```

---

## 4. INICIALIZACIÓN Y CONFIGURACIÓN DEL PROYECTO

### Paso 3: Generar la estructura base

Inicializa un nuevo proyecto de MkDocs dentro de la carpeta actual:

```bash
mkdocs new .

```

Este comando habrá creado la siguiente estructura en tu directorio:

```text
documentacion-dwes/
├── docs/
│   └── index.md          # Página principal de la documentación
├── mkdocs.yml            # Archivo de configuración global
└── venv/                 # Entorno virtual de Python

```

### Paso 4: Configurar el archivo `mkdocs.yml`

Abre el archivo `mkdocs.yml` con tu editor preferido (VS Code, Nano, Vim) y sustituye su contenido por la siguiente configuración completa que activa el tema **`readthedocs`** y organiza la navegación del sitio:

```yaml
site_name: "Documentación Técnica DWES"
site_description: "Guía de estándares, arquitectura web y servidor para DAW"
site_author: "Alumno DAW - IES Los Albares"

# Selección del tema Read the Docs
theme:
  name: readthedocs
  highlightjs: true
  hljs_languages:
    - php
    - bash
    - json
    - html

# Estructura de navegación lateral
nav:
  - Inicio: index.php.md
  - Estándares y Nombrado:
      - Reglas de Directorios: estandares/nombrado.md
  - Servidor Web:
      - Protocolo HTTP: servidor/respuestas-http.md

# Opciones adicionales
markdown_extensions:
  - tables
  - codehilite

```

---

## 5. CREACIÓN DE CONTENIDOS EN MARKDOWN

### Paso 5: Generar los archivos de documentación

Crea las carpetas y los archivos especificados en la sección `nav` de tu archivo de configuración:

```bash
mkdir -p docs/estandares docs/servidor

```

#### A. Crear `docs/index.md`:

```markdown
# Documentación del Módulo DWES

Bienvenido a la documentación oficial del módulo **Desarrollo Web en Entorno Servidor**.

## Contenidos Principales
* Estándares de nombrado de archivos y directorios.
* Configuración de servidores web en Linux (Apache/Nginx/Lerd).
* Estructura y códigos de respuesta del protocolo HTTP.

```

#### B. Crear `docs/estandares/nombrado.md`:

```markdown
# Estándares de Nombrado de Archivos

En entornos de servidor Linux, el sistema de archivos es sensible a mayúsculas y minúsculas (*Case Sensitive*).

## Reglas de Oro
1. **kebab-case:** Usar minúsculas y guiones medios para archivos web (`mi-pagina.php`).
2. **Sin caracteres especiales:** Evitar espacios, tildes, eñes y símbolos (`$`, `%`, `@`).
3. **Imágenes y Assets:** Guardar imágenes en formato PNG/SVG con nombres claros (`assets/img/logo-oficial.png`).

```

#### C. Crear `docs/servidor/respuestas-http.md`:

```markdown
# Respuestas y Códigos HTTP

El protocolo HTTP utiliza códigos numéricos para indicar el estado de la petición.

| Código | Significado | Descripción |
| :--- | :--- | :--- |
| **200** | OK | Petición procesada correctamente. |
| **301** | Moved Permanently | Redirección permanente a una nueva URL. |
| **404** | Not Found | El recurso o archivo no existe en el servidor. |
| **500** | Internal Error | Excepción no capturada en el servidor (PHP/Python). |

```

---

## 6. PREVISUALIZACIÓN Y COMPILACIÓN

### Paso 6: Servir la documentación en tiempo real

Inicia el servidor interno de pruebas de MkDocs:

```bash
mkdocs serve

```

Abre tu navegador e introduce la dirección local indicada por la terminal (por defecto, `[http://127.0.0.1:8000/](http://127.0.0.1:8000/)`). Verás la interfaz temática de **Read the Docs** cargada con tu contenido. Cualquier cambio que guardes en los archivos `.md` se actualizará automáticamente en la pantalla.

### Paso 7: Compilar el sitio para producción (`site/`)

Para generar el sitio estático final compuesto únicamente por HTML, CSS, JavaScript e imágenes listas para subir a cualquier servidor web (como Apache o Nginx):

```bash
mkdocs build

```

Este comando creará la carpeta `site/`. Su contenido es el entregable final de producción de tu documentación.

---

## 7. ACTIVIDAD / TRABAJO PARA EL ALUMNADO (`[LIBRETA]`)

1. **[LIBRETA]** Copia en tu cuaderno el árbol final de directorios del proyecto generado tras ejecutar `mkdocs build`, indicando qué función cumple la carpeta `site/` frente a la carpeta `docs/`.
2. **[LIBRETA]** Explica qué ocurriría si intentas ejecutar el comando `mkdocs serve` en una terminal nueva sin haber activado previamente el entorno virtual (`source venv/bin/activate`).
3. **[PRÁCTICA EN EQUIPO]** Personaliza el archivo `mkdocs.yml` añadiendo una nueva sección en el menú lateral titulada `"Entorno Lerd"` que contenga una guía rápida con los comandos básicos de terminal para desplegar un contenedor web.