<?php
ob_start();
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/securizar.php";
crearTablaListaBoda();

//compruebo que la sesion este inicida y ya te deja acceder al resto,
//si no está iniciada no te deja

if (!isset($_SESSION["usuario_tipo"]) || $_SESSION["usuario_tipo"] != "usuario") {
    header("Location: index.php");
    exit();
}


include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/operacionesUsuario.php";
$usuarioId = $_SESSION["usuario_id"];

$listas = obtenerListasPorUsuario($usuarioId);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombre_lista"])) {
        crearListaBoda($usuarioId, $_POST["nombre_lista"]);
    } elseif (isset($_POST["modificar_lista_id"])) {
        modificarListaBoda($_POST["modificar_lista_id"], $_POST["nuevo_nombre"]);
    } elseif (isset($_POST["eliminar_lista_id"])) {
        eliminarListaBoda($_POST["eliminar_lista_id"]);
    }elseif (isset($_POST["ver_todas"]) && $_POST["ver_todas"] == "1") {
        $listas = obtenerTodasLasListas();
    }

    header("Location: gestionar_listas.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Listas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/estilos.css">
    <style>
        body {
            background: linear-gradient(rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.2)),
                        url('https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }
        .card, .card-body {
            background-color: rgba(255, 255, 255, 0.6) !important;
            border: none !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
            transition: transform 0.2s !important;
        }
        .card:hover {
            transform: translateY(-5px) !important;
        }
    </style>
</head>
<body>
    <?php include_once "./views/menu.php"; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4 text-center">Mis Listas de Bodas</h1>
                
                <!-- Formulario para crear nueva lista -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Crear Nueva Lista</h5>
                        <form method="POST" class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <label for="nombre_lista" class="form-label">Nombre de la lista:</label>
                                <input type="text" class="form-control" id="nombre_lista" name="nombre_lista" required>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">Crear Lista</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Lista de listas existentes -->
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <?php foreach ($listas as $lista): ?>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($lista["nombre_lista"]); ?></h5>
                                    
                                    <!-- Formulario para modificar -->
                                    <form method="POST" class="mb-3">
                                        <div class="input-group">
                                            <input type="hidden" name="modificar_lista_id" value="<?php echo $lista["id"]; ?>">
                                            <input type="text" class="form-control" name="nuevo_nombre" placeholder="Nuevo nombre" required>
                                            <button type="submit" class="btn btn-outline-primary">Modificar</button>
                                        </div>
                                    </form>

                                    <!-- Botones de acción -->
                                    <div class="d-flex gap-2">
                                        <form method="POST" class="flex-grow-1">
                                            <input type="hidden" name="eliminar_lista_id" value="<?php echo $lista["id"]; ?>">
                                            <button type="submit" class="btn btn-danger w-100">Eliminar</button>
                                        </form>
                                        <a href="gestionar_regalos.php?lista_id=<?php echo $lista["id"]; ?>" class="btn btn-success flex-grow-1">Añadir Regalos</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php ob_end_flush(); ?>