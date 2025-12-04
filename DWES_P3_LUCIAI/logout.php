<?php
session_start();
session_unset();
session_destroy();

// Elimina la cookie
setcookie("usuario_token", "", time() - 3600, "/");

header("Location: login.php?mensaje=Cerraste sesión exitosamente.");
exit();