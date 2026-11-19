<?php
/**
 * UT04 · Utilidad: genera el hash de una contraseña.
 * Uso desde la terminal:  php crear-hash.php "Contraseña#2026"
 */
if (PHP_SAPI !== 'cli') {
    exit('Ejecuta este script desde la terminal.');   // no debe abrirse en el navegador
}

if (!isset($argv[1]) || $argv[1] === '') {
    fwrite(STDERR, 'Uso: php crear-hash.php "Contraseña"' . PHP_EOL);
    exit(1);
}

echo password_hash($argv[1], PASSWORD_DEFAULT), PHP_EOL;
