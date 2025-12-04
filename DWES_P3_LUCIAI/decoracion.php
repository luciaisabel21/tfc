<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";

// Array de productos de decoración (12 productos)
$productos = [
    ["id" => 10, "imagen" => "./imagenes/decoracion.jpg", "nombre" => "Luces blancas", "descripcion" => "decora la zona que desees con luces blancas", "precio" => 50, "cantidad" => 1],
    ["id" => 11, "imagen" => "./imagenes/decoracionProducto1.jpeg", "nombre" => "Velas con flores", "descripcion" => "decora la mesa con velas y flores", "precio" => 30, "cantidad" => 1],
    ["id" => 12, "imagen" => "./imagenes/decoracionProducto2.jpg", "nombre" => "Accesorio para silla", "descripcion" => "decora las sillas con flores", "precio" => 20, "cantidad" => 1],
    ["id" => 22, "imagen" => "./imagenes/decoracion3.jpg", "nombre" => "Centro de mesa dorado", "descripcion" => "Elegante centro de mesa en tonos dorados", "precio" => 75, "cantidad" => 1],
    ["id" => 23, "imagen" => "./imagenes/decoracion4.webp", "nombre" => "Arco floral", "descripcion" => "Precioso arco decorado con flores naturales", "precio" => 200, "cantidad" => 1],
    ["id" => 24, "imagen" => "./imagenes/decoracion5.jpg", "nombre" => "Letras de madera", "descripcion" => "Letras grandes de madera para personalizar", "precio" => 90, "cantidad" => 1],
    ["id" => 25, "imagen" => "./imagenes/decoracion6.jpg", "nombre" => "Candelabros de cristal", "descripcion" => "Juego de candelabros para mesa principal", "precio" => 120, "cantidad" => 1],
    ["id" => 26, "imagen" => "./imagenes/decoracion7.avif", "nombre" => "Pompones de papel", "descripcion" => "Set de pompones decorativos colgantes", "precio" => 35, "cantidad" => 1],
    ["id" => 27, "imagen" => "./imagenes/decoracion8.jpg", "nombre" => "Alfombra roja", "descripcion" => "Alfombra de entrada para ceremonia", "precio" => 150, "cantidad" => 1],
    ["id" => 28, "imagen" => "./imagenes/decoracion9.jpeg", "nombre" => "Lámparas colgantes", "descripcion" => "Juego de lámparas para iluminación ambiental", "precio" => 180, "cantidad" => 1],
    ["id" => 29, "imagen" => "./imagenes/decoracion10.jpg", "nombre" => "Mesa de dulces", "descripcion" => "Decoración completa para mesa de dulces", "precio" => 220, "cantidad" => 1],
    ["id" => 30, "imagen" => "./imagenes/decoracion11.jpeg", "nombre" => "Piezas de cristalería", "descripcion" => "Juego de copas y jarrones de cristal", "precio" => 95, "cantidad" => 1]
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
            break;
        }
    }
    
    // Redirigir al carrito después de agregar
    header("Location: carrito.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decoración - Everlia</title>
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
        <h1 class="text-center">Productos de Decoración</h1>
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
