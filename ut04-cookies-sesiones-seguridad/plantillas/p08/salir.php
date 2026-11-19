<?php
/**
 * UT04 · P08 · Intranet de la academia: cerrar sesión
 * ¡ATENCIÓN! Esta aplicación tiene fallos de seguridad a propósito.
 */
session_start();
unset($_SESSION['usuario']);
header('Location: login.php?msg=Has salido de la intranet');
exit;
