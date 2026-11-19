<?php
/**
 * UT04 · P07 · Usuarios de la intranet.
 * Las contraseñas están guardadas como hash (password_hash). En la UT6 estarán en una base de datos.
 *
 *   ana   / Ana#2026   (usuario)
 *   luis  / Luis#2026  (usuario)
 *   admin / Admin#2026 (admin)
 */
return [
    'ana' => [
        'nombre' => 'Ana Pérez Gil',
        'rol'    => 'usuario',
        'hash'   => '$2y$12$sY7v8Tbgz89e02xQN0uLDu6binsLw4HIf3O31VxJ6mwJZXEmqrsV.',
    ],
    'luis' => [
        'nombre' => 'Luis Martínez Ruiz',
        'rol'    => 'usuario',
        'hash'   => '$2y$12$n96dUAxgG4xbTNC7EiFSHu4RmfnSiOMS/Oex5a9m44kwFSmHeuBQy',
    ],
    'admin' => [
        'nombre' => 'Administración del departamento',
        'rol'    => 'admin',
        'hash'   => '$2y$12$zdpEX4D76gFFK3ndqjEgduengrdF4CpbBf32QUHSscP4GQRri6HSO',
    ],
];
