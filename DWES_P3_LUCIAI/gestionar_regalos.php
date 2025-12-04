<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/operacionesUsuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/securizar.php";
crearTablaListaBoda();
crearTablaRegalo();
crearTablaContribucionRegalo();


// Verifio que el usuario esté autenticado y sea de tipo "usuario"
if (!isset($_SESSION["usuario_tipo"]) || $_SESSION["usuario_tipo"] != "usuario") {
    header("Location: index.php");
    exit();
}


// Obtengo el ID de la lista de bodas desde la URL
if (!isset($_GET["lista_id"])) {
    echo "Error: No se proporcionó el ID de la lista de bodas.";
    exit();
}

$listaId = $_GET["lista_id"];
$regalos = obtenerRegalosPorLista($listaId); // Función para obtener regalos por lista


$nombre = $descripcion = $precio = $urlProducto = "";
$nombreErr = $descripcionErr = $precioErr = $urlProductoErr = "";
$errores = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = securizar($_POST["nombre"]);
    $descripcion = securizar($_POST["descripcion"]);
    $precio = securizar($_POST["precio"]);
    $urlProducto = securizar($_POST["urlProducto"]);

    
    if (isset($_POST["nombre"]) && isset($_POST["descripcion"]) && isset($_POST["precio"]) && isset($_POST["url_producto"])) {
        // Validación del nombre
        if (!empty($_POST["nombre"])) {
            $nombre = htmlspecialchars($_POST["nombre"]);
        } else {
            $nombreErr = "El nombre del regalo es obligatorio.";
            $errores = true;
        }

        // Validación de la descripción
        if (!empty($_POST["descripcion"])) {
            $descripcion = htmlspecialchars($_POST["descripcion"]);
        } else {
            $descripcionErr = "La descripción es obligatoria.";
            $errores = true;
        }

        // Validación del precio
        if (!empty($_POST["precio"])) {
            $precio = htmlspecialchars($_POST["precio"]);
            if (!is_numeric($precio) || $precio <= 0) {
                $precioErr = "El precio debe ser un número positivo.";
                $errores = true;
            }
        } else {
            $precioErr = "El precio es obligatorio.";
            $errores = true;
        }

        // Validación del enlace del producto
        if (!empty($_POST["url_producto"])) {
            $urlProducto = htmlspecialchars($_POST["url_producto"]);
            if (!filter_var($urlProducto, FILTER_VALIDATE_URL)) {
                $urlProductoErr = "El enlace del producto no es válido.";
                $errores = true;
            }
        } else {
            $urlProductoErr = "El enlace del producto es obligatorio.";
            $errores = true;
        }

        // Si no hay errores, añado el regalo
        if (!$errores) {
            $regaloId = uniqid(); // Genero un ID único para el regalo
            añadirRegaloALista($listaId, $regaloId, $nombre, $descripcion, $precio, $urlProducto);
            header("Location: gestionar_regalos.php?lista_id=$listaId");
            exit();
        }
    }

    // eliminación de regalos
    if (isset($_POST["eliminar_regalo_id"])) {
        $regaloId = $_POST["eliminar_regalo_id"];
        eliminarRegaloDeLista($regaloId);
        header("Location: gestionar_regalos.php?lista_id=$listaId");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Regalos</title>
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
        .error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <?php include_once "./views/menu.php"; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4 text-center">Gestionar Regalos para la Lista</h1>

                <!-- Formulario para añadir regalo -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Añadir Nuevo Regalo</h5>
                        <form method="POST" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre del regalo:</label>
                                <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                                <?php if (!empty($nombreErr)) echo "<p class='error'>$nombreErr</p>"; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Precio:</label>
                                <input type="text" class="form-control" name="precio" value="<?php echo htmlspecialchars($precio); ?>" required>
                                <?php if (!empty($precioErr)) echo "<p class='error'>$precioErr</p>"; ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Descripción:</label>
                                <textarea class="form-control" name="descripcion" rows="3" required><?php echo htmlspecialchars($descripcion); ?></textarea>
                                <?php if (!empty($descripcionErr)) echo "<p class='error'>$descripcionErr</p>"; ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Enlace del producto:</label>
                                <input type="url" class="form-control" name="url_producto" value="<?php echo htmlspecialchars($urlProducto); ?>" required>
                                <?php if (!empty($urlProductoErr)) echo "<p class='error'>$urlProductoErr</p>"; ?>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Añadir Regalo</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Lista de regalos -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Lista de Regalos</h5>
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            <?php foreach ($regalos as $regalo): ?>
                                <div class="col">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title"><?php echo htmlspecialchars($regalo["nombre"]); ?></h6>
                                            <p class="card-text">
                                                <strong>Precio:</strong> <?php echo htmlspecialchars($regalo["precio"]); ?> €<br>
                                                <strong>Descripción:</strong> <?php echo htmlspecialchars($regalo["descripcion"]); ?><br>
                                                <a href="<?php echo htmlspecialchars($regalo["url_producto"]); ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Ver Producto</a>
                                            </p>
                                            <form method="POST" class="mt-2">
                                                <input type="hidden" name="eliminar_regalo_id" value="<?php echo $regalo["id"]; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm w-100">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include_once "./views/pie.php"; ?>
<?php 