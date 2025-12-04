<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";

// Array de ramos de flores (12 productos)
$productos = [
    ["id" => 19, "imagen" => "./imagenes/ramoFlores.jpg", "nombre" => "Ramo colores pastel", "descripcion" => "Ramo colores pastel rosa, blanco y verde", "precio" => 143, "cantidad" => 1],
    ["id" => 20, "imagen" => "./imagenes/ramoFlores1.jpeg", "nombre" => "Ramo colores vivos", "descripcion" => "Ramo colores fuertes verde, burdeos, rosa, amarillo", "precio" => 100, "cantidad" => 1],
    ["id" => 21, "imagen" => "./imagenes/ramoFlores2.jpeg", "nombre" => "Ramo blanco y rosa", "descripcion" => "Ramo elegante blanco y diferentes tonos de rosa", "precio" => 150, "cantidad" => 1],
    ["id" => 40, "imagen" => "./imagenes/ramo3.jpg", "nombre" => "Ramo de rosas rojas", "descripcion" => "Clásico ramo de rosas rojas con follaje", "precio" => 120, "cantidad" => 1],
    ["id" => 41, "imagen" => "./imagenes/ramo4.jpg", "nombre" => "Ramo de peonías", "descripcion" => "Elegante ramo de peonías rosas y blancas", "precio" => 180, "cantidad" => 1],
    ["id" => 42, "imagen" => "./imagenes/ramo5.jpg", "nombre" => "Ramo de girasoles", "descripcion" => "Alegre ramo de girasoles y flores de campo", "precio" => 90, "cantidad" => 1],
    ["id" => 43, "imagen" => "./imagenes/ramo6.png", "nombre" => "Ramo de orquídeas", "descripcion" => "Sofisticado ramo de orquídeas blancas", "precio" => 200, "cantidad" => 1],
    ["id" => 44, "imagen" => "./imagenes/ramo7.webp", "nombre" => "Ramo de tulipanes", "descripcion" => "Delicado ramo de tulipanes multicolor", "precio" => 110, "cantidad" => 1],
    ["id" => 45, "imagen" => "./imagenes/ramo8.jpg", "nombre" => "Ramo de rosas blancas", "descripcion" => "Elegante ramo de rosas blancas con eucalipto", "precio" => 130, "cantidad" => 1],
    ["id" => 46, "imagen" => "./imagenes/ramo9.jpg", "nombre" => "Ramo de flores silvestres", "descripcion" => "Ramo campestre de flores silvestres variadas", "precio" => 85, "cantidad" => 1],
    ["id" => 47, "imagen" => "./imagenes/ramo10.webp", "nombre" => "Ramo de lirios", "descripcion" => "Espectacular ramo de lirios blancos", "precio" => 160, "cantidad" => 1],
    ["id" => 48, "imagen" => "./imagenes/ramo11.jpg", "nombre" => "Ramo de rosas y claveles", "descripcion" => "Combinación de rosas rojas y claveles blancos", "precio" => 140, "cantidad" => 1]
];

// Lógica para añadir al carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["producto_id"])) {
    $productoId = (int)$_POST["producto_id"];

    // Inicializar el carrito si no existe
    if (!isset($_SESSION["carrito"])) {
        $_SESSION["carrito"] = [];
    }

    // Buscar el producto en el array
    foreach ($productos as $producto) {
        if ($producto["id"] == $productoId) {
            // Verificar si el producto ya está en el carrito
            $encontrado = false;
            foreach ($_SESSION["carrito"] as &$item) {
                if (isset($item["producto_id"]) && $item["producto_id"] == $productoId) {
                    if (!isset($item["cantidad"])) {
                        $item["cantidad"] = 1;
                    } else {
                        $item["cantidad"]++;
                    }
                    $encontrado = true;
                    break;
                }
            }

            // Si no está en el carrito, agregarlo
            if (!$encontrado) {
                $_SESSION["carrito"][] = [
                    "producto_id" => $productoId,
                    "nombre" => $producto["nombre"],
                    "descripcion" => $producto["descripcion"],
                    "precio" => $producto["precio"],
                    "cantidad" => 1,
                    "imagen" => $producto["imagen"]
                ];
            }
            
            // Redirigir al carrito después de agregar
            header("Location: carrito.php");
            exit();
        }
    }
    
    header("Location: carrito.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ramos de Flores - Everlia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.2)),
                        url('https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.6) !important;
            border: none !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
            transition: transform 0.2s !important;
            height: 100% !important;
        }
        .card:hover {
            transform: translateY(-5px) !important;
        }
        .card-img-top {
            width: 100% !important;
            height: 300px !important;
            object-fit: cover !important;
        }
        .card-body {
            height: 250px !important;
            display: flex !important;
            flex-direction: column !important;
        }
        .card-text {
            flex-grow: 1 !important;
        }
    </style>
</head>
<body>
    <?php include_once "./views/menu.php"; ?>

    <div class="container my-5">
        <h1 class="text-center">Ramos de Flores</h1>
        <div class="row">
            <?php foreach ($productos as $producto): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                            <p class="card-text"><strong>Precio:</strong> <?php echo htmlspecialchars($producto['precio']); ?> €</p>
                            <form method="POST" class="mt-auto">
                                <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                                <button type="submit" class="btn btn-primary w-100">Añadir al Carrito</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include_once "./views/pie.php"; ?>
