<?php
/**
 * PLANTILLA · UT04 · P07 · Funciones de sesión, autenticación y seguridad
 * Se incluye al principio de todas las páginas, antes de cualquier salida.
 * Documenta cada función con PHPDoc.
 */

date_default_timezone_set('Europe/Madrid');

const INACTIVIDAD_MAXIMA = 10 * 60;   // segundos sin peticiones antes de cerrar la sesión
const MAX_INTENTOS = 5;               // fallos seguidos antes de bloquear el login
const TIEMPO_BLOQUEO = 2 * 60;        // segundos de bloqueo

// TODO: inicia la sesión (si no lo está) con cookie_httponly, cookie_samesite Lax y use_strict_mode

/**
 * Escapa un texto para mostrarlo en HTML.
 */
function h(?string $texto): string
{
    // TODO
    return '';
}

/**
 * Guarda un mensaje para mostrarlo en la siguiente petición.
 */
function flash(string $tipo, string $texto): void
{
    // TODO
}

/**
 * Devuelve los mensajes pendientes y los borra de la sesión.
 */
function obtenerFlash(): array
{
    // TODO
    return [];
}

/**
 * Devuelve los datos del usuario identificado o null si no hay nadie.
 */
function usuarioActual(): ?array
{
    // TODO
    return null;
}

/**
 * Si no hay ningún usuario identificado, redirige al login (¡con exit!).
 */
function requiereLogin(): void
{
    // TODO
}

/**
 * Exige estar identificado y tener un rol concreto. Si no se tiene, responde 403.
 */
function requiereRol(string $rol): void
{
    // TODO
}

/**
 * Cierra la sesión por completo: datos, cookie del navegador y fichero del servidor.
 */
function cerrarSesion(): void
{
    // TODO
}

/**
 * Devuelve el token anti-CSRF de la sesión; lo crea si no existe.
 */
function tokenCsrf(): string
{
    // TODO
    return '';
}

/**
 * Detiene la petición (código 400) si el token enviado no coincide con el de la sesión.
 */
function comprobarCsrf(): void
{
    // TODO: usa hash_equals()
}

// TODO: comprueba la inactividad en cada petición. Si hay usuario y han pasado más de
//       INACTIVIDAD_MAXIMA segundos desde $_SESSION['ultimo_acceso'], cierra la sesión y
//       redirige a login.php?motivo=caducada. Si no, actualiza $_SESSION['ultimo_acceso'].
