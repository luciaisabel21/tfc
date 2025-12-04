<?php
session_start();

// Tiempo de expiración de la sesión 15 min
$tiempoExpiracion = 15 * 60;

// Verifico si hay una sesión activa y actualizo el tiempo de acceso
if (isset($_SESSION['ultimo_acceso'])) {
    $tiempoInactivo = time() - $_SESSION['ultimo_acceso'];
    if ($tiempoInactivo > $tiempoExpiracion) {
        // Si el tiempo inactivo supera el límite, destruyo la sesión
        session_unset();
        session_destroy();
        header("Location: login.php?mensaje=Sesión expirada. Por favor, inicia sesión nuevamente.");
        exit();
    }
    $_SESSION['ultimo_acceso'] = time();
}

// Verifico si no hay sesión pero existe una cookie de usuario
if (!isset($_SESSION['usuario_id']) && isset($_COOKIE['usuario_token'])) {
    $conexion = conectar(); 

    $token = $_COOKIE['usuario_token'];

    // Verifico el token en la base de datos
    $sql = $conexion->prepare("SELECT id FROM persona WHERE token = ?");
    $sql->bind_param("s", $token);
    $sql->execute();
    $resultado = $sql->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['ultimo_acceso'] = time();
    } else {
        // Si el token no es válido, elimino la cookie
        setcookie("usuario_token", "", time() - 3600, "/");
    }
}

// Verifico si el usuario está autenticado para acceder a la página
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php?mensaje=Debes iniciar sesión para acceder a esta página.");
    exit();
}
?>