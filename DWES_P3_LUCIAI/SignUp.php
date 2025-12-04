<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/securizar.php";
crearTablaPersona();
crearTablaUsuario();
crearTablaInvitado();

$id = $nombre = $email = $telefono = $pass = $pass2 = $genero = $tipo_usuario = "";
$idErr = $nombreErr = $emailErr = $telefonoErr = $passErr = $pass2Err = $generoErr = $tipo_usuarioErr = "";
$errores = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = securizar($_POST["id"]);
    $nombre = securizar($_POST["nombre"]);
    $email = securizar($_POST["email"]);
    $telefono = securizar($_POST["telefono"]);
    $pass = securizar($_POST["pass"]);
    $pass2 = securizar($_POST["pass2"]); 
    $genero = securizar($_POST["genero"]);
    $tipo_usuario = securizar($_POST["tipo_usuario"]);
    
    // Validación de id
    if (empty($id)) {
        $idErr = "El id es obligatorio";
        $errores = true;
    }

    // Validación de nombre
    if (empty($nombre)) {
        $nombreErr = "El nombre es obligatorio";
        $errores = true;
    }

    // Validación de email
    if (empty($email)) {
        $emailErr = "El email es obligatorio";
        $errores = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "El formato del email no es válido";
        $errores = true;
    }

    // Validación de teléfono
    if (empty($telefono)) {
        $telefonoErr = "El teléfono es obligatorio";
        $errores = true;
    } elseif (!preg_match("/^[0-9]{9}$/", $telefono)) {
        $telefonoErr = "El teléfono debe contener 9 dígitos";
        $errores = true;
    }

    // Validación de contraseña
    if (empty($pass)) {
        $passErr = "La contraseña es obligatoria";
        $errores = true;
    }

    // Validación de repetir contraseña
    if (empty($pass2)) {
        $pass2Err = "Debe repetir la contraseña";
        $errores = true;
    } elseif ($pass !== $pass2) {
        $pass2Err = "Las contraseñas no coinciden";
        $errores = true;
    }

    // Validación de género
    if (empty($genero)) {
        $generoErr = "Debe seleccionar un género";
        $errores = true;
    }

    // Validación de tipo de usuario
    if (empty($tipo_usuario)) {
        $tipo_usuarioErr = "Debe seleccionar un tipo de usuario";
        $errores = true;
    }

    // Si no hay errores, registro al usuario
    if (!$errores) {
        if (registrarUsuario($id, $nombre, $email, $telefono, $pass, $genero, $tipo_usuario)) {
            header("Location: login.php?registro=exitoso");
            exit();
        } else {
            $error_registro = "Error al registrar. Inténtalo de nuevo más tarde.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Everlia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./css/signup.css">
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
                <h1>CREA UNA CUENTA</h1>
                
                <?php if (isset($error_registro)): ?>
                    <div class="alert alert-danger"><?php echo $error_registro; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <!-- Nombre -->
                    <div class="form-group">
                        <input type="text" class="form-control" name="nombre" placeholder="Nombre completo" value="<?php echo htmlspecialchars($nombre); ?>">
                        <?php if (!empty($nombreErr)) echo "<p class='error'>$nombreErr</p>"; ?>
                    </div>

                    <!-- ID -->
                    <div class="form-group">
                        <input type="text" class="form-control" name="id" placeholder="ID de usuario" value="<?php echo htmlspecialchars($id); ?>">
                        <?php if (!empty($idErr)) echo "<p class='error'>$idErr</p>"; ?>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Correo electrónico" value="<?php echo htmlspecialchars($email); ?>">
                        <?php if (!empty($emailErr)) echo "<p class='error'>$emailErr</p>"; ?>
                    </div>

                    <!-- Teléfono -->
                    <div class="form-group">
                        <input type="tel" class="form-control" name="telefono" placeholder="Teléfono" value="<?php echo htmlspecialchars($telefono); ?>">
                        <?php if (!empty($telefonoErr)) echo "<p class='error'>$telefonoErr</p>"; ?>
                    </div>

                    <!-- Contraseña -->
                    <div class="form-group">
                        <input type="password" class="form-control" name="pass" placeholder="Contraseña">
                        <?php if (!empty($passErr)) echo "<p class='error'>$passErr</p>"; ?>
                    </div>

                    <!-- Repetir contraseña -->
                    <div class="form-group">
                        <input type="password" class="form-control" name="pass2" placeholder="Repetir contraseña">
                        <?php if (!empty($pass2Err)) echo "<p class='error'>$pass2Err</p>"; ?>
                    </div>

                    <!-- Género -->
                    <div class="form-group">
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="genero" value="Masculino" <?php echo ($genero == "Masculino") ? 'checked' : ''; ?>>
                                Masculino
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="genero" value="Femenino" <?php echo ($genero == "Femenino") ? 'checked' : ''; ?>>
                                Femenino
                            </label>
                        </div>
                        <?php if (!empty($generoErr)) echo "<p class='error'>$generoErr</p>"; ?>
                    </div>

                    <!-- Tipo de usuario -->
                    <div class="form-group">
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="tipo_usuario" value="usuario" <?php echo ($tipo_usuario == "usuario") ? 'checked' : ''; ?>>
                                Organizador de Boda
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="tipo_usuario" value="invitado" <?php echo ($tipo_usuario == "invitado") ? 'checked' : ''; ?>>
                                Invitado
                            </label>
                        </div>
                        <?php if (!empty($tipo_usuarioErr)) echo "<p class='error'>$tipo_usuarioErr</p>"; ?>
                    </div>

                    <!-- Botón de registro -->
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> REGISTRARSE
                    </button>
                </form>

               
 