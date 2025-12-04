<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/estilos.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php">Everlia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/DWES_P3_LUCIAI/index.php">Inicio</a>
                </li>
                <!-- si el usuario es de tipo usuario, saldria la opcion Gestionar lista -->
                <?php if (isset($_SESSION['usuario_tipo'])): ?>
                    <?php if ($_SESSION['usuario_tipo'] == 'usuario'): ?>
                        <!-- Opciones para usuarios -->
                        <li class="nav-item"><a class="nav-link" href="gestionar_listas.php">Gestionar Lista</a></li>
                        <li class="nav-item"><a class="nav-link" href="invitaciones.php">Invitaciones</a></li>
                        <li class="nav-item"><a class="nav-link" href="/DWES_P3_LUCIAI/carrito.php">Carrito</a></li>
                        <li class="nav-item"><a class="nav-link" href="/DWES_P3_LUCIAI/productos.php">Productos</a></li>
                        <li class="nav-item"><a class="nav-link" href="/DWES_P3_LUCIAI/viajes.php">Viajes</a></li>
                <!-- si el usuario es de tipo invitado, saldria la opcion Ver Listas -->    
                        <?php elseif ($_SESSION['usuario_tipo'] == 'invitado'): ?>
                        <!-- Opciones para invitados -->
                        <li class="nav-item"><a class="nav-link" href="ver_listas_invitado.php">Ver Listas</a></li>
                    <?php endif; ?>
                    <!-- si el usuario se ha  logueado -->
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <!-- si el usuario no se ha logueado -->
                    <li class="nav-item"><a class="nav-link" href="/DWES_P3_LUCIAI/login.php">Iniciar Sesión</a></li>
                    <li class="nav-item"><a class="nav-link" href="/DWES_P3_LUCIAI/SignUp.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
</body>
</html>
