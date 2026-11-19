<?php
/**
 * UT04 · P08 · Intranet de la academia: zona privada
 * ¡ATENCIÓN! Esta aplicación tiene fallos de seguridad a propósito.
 */
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php?msg=Inicia sesión para continuar');
}

$esAdmin = ($_COOKIE['rol'] ?? '') === 'admin';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia · Zona privada</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<nav class="navbar is-primary">
    <div class="navbar-brand"><span class="navbar-item"><i class="fa fa-book mr-2"></i> Academia</span></div>
    <div class="navbar-end">
        <?php if ($esAdmin): ?><a class="navbar-item" href="admin.php">Administración</a><?php endif; ?>
        <a class="navbar-item" href="salir.php">Salir</a>
    </div>
</nav>
<section class="section">
    <div class="container">
        <h1 class="title">Hola, <?= $_SESSION['nombre'] ?? '' ?></h1>
        <div class="box">
            <h2 class="subtitle">Tus notas del primer trimestre</h2>
            <table class="table">
                <tr><th>Programación</th><td>7,5</td></tr>
                <tr><th>Bases de datos</th><td>8,2</td></tr>
                <tr><th>Sistemas informáticos</th><td>6,9</td></tr>
            </table>
        </div>

        <!-- Información para el soporte técnico -->
        <pre class="is-size-7">Sesión: <?= session_id() ?>

<?php print_r($_SESSION); print_r($_COOKIE); ?></pre>
    </div>
</section>
</body>
</html>
