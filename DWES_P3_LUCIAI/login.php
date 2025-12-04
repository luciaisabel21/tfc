<?php
session_start();
require_once __DIR__ . '/database/funcionesBD.php';
require_once __DIR__ . '/database/operacionesUsuario.php';
require_once __DIR__ . '/database/securizar.php';

$email = $pass = $rol ="";
$emailErr = $passErr = $rolErr = "";
$errores = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = securizar($_POST["email"]);
    $pass = securizar($_POST["pass"]);
    $rol = securizar($_POST["rol"]);
    
    // Validación del email
    if (!empty($_POST["email"])) {
        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "El formato del email no es válido";
            $errores = true;
        }
    } else {
        $emailErr = "El email es obligatorio";
        $errores = true;
    }

    // Validación de la contraseña
    if (!empty($_POST["pass"])) {
        $pass = $_POST["pass"];
    } else {
        $passErr = "La contraseña es obligatoria";
        $errores = true;
    }

    // Validación del rol
    if (!empty($_POST["rol"])) {
        $rol = $_POST["rol"];
    } else {
        $rolErr = "Debe seleccionar un rol";
        $errores = true;
    }

    // Si no hay errores, realizar la autenticación
    if (!$errores) {
        // Llamar a la función para autenticar al usuario
        $persona = autenticarPersona($email, $pass, $rol);

        if ($persona) {
            // Si la autenticación funciona, almacenar los datos en la sesión
            $_SESSION["usuario_id"] = $persona["id"];
            $_SESSION["usuario_nombre"] = $persona["nombre"];
            $_SESSION["usuario_email"] = $persona["email"];
            $_SESSION["usuario_tipo"] = $persona["tipo"]; // usuario o invitado

            // Redirigir según el tipo de usuario
            if ($persona["tipo"] == "usuario") {
                header("Location: index.php");
            } else if ($persona["tipo"] == "invitado") {
                header("Location: index.php");
            }
            exit();
        } else {
            $passErr = "Email o contraseña incorrectos o rol no coincide.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Everlia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <div class="container-fluid">
        <!-- Sección de la imagen -->
        <div class="image-section">
            <div class="logo">EVERLIA</div>
        </div>

        <!-- Sección del formulario -->
        <div class="form-section">
            <div class="form-container">
                <h1>INICIAR SESIÓN</h1>
                
                <?php if (!empty($passErr) && $passErr !== "La contraseña es obligatoria" && $passErr !== "Email o contraseña incorrectos o rol no coincide."): ?>
                    <div class="alert alert-danger"><?php echo $passErr; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <!-- Email -->
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Correo electrónico" value="<?php echo htmlspecialchars($email); ?>">
                        <?php if (!empty($emailErr)) echo "<p class='error'>$emailErr</p>"; ?>
                    </div>

                    <!-- Contraseña -->
                    <div class="form-group">
                        <input type="password" class="form-control" name="pass" placeholder="Contraseña">
                        <?php if (!empty($passErr) && ($passErr === "La contraseña es obligatoria" || $passErr === "Email o contraseña incorrectos o rol no coincide.")) 
                            echo "<p class='error'>$passErr</p>"; 
                        ?>
                    </div>

                    <!-- Selección de rol -->
                    <div class="form-group">
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="rol" value="usuario" <?php echo (isset($_POST["rol"]) && $_POST["rol"] == "usuario") ? 'checked' : ''; ?>>
                                Organizador de Boda
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="rol" value="invitado" <?php echo (isset($_POST["rol"]) && $_POST["rol"] == "invitado") ? 'checked' : ''; ?>>
                                Invitado
                            </label>
                        </div>
                        <?php if (!empty($rolErr)) echo "<p class='error'>$rolErr</p>"; ?>
                    </div>

                    <!-- Botón de inicio de sesión -->
                    <button type="submit" name="enviar" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> INICIAR SESIÓN
                    </button>
                </form>

                <div class="register-link" style="text-align: center; margin-top: 1.5rem;">
                    ¿No tienes una cuenta? <a href="SignUp.php">Regístrate aquí</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>