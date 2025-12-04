<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";

// Array de vestidos y trajes (12 productos)
$productos = [
    ["id" => 13, "imagen" => "./imagenes/vestidoNovia.jpg", "nombre" => "Vestido palabra de honor", "descripcion" => "vestido encaje palabra de honor", "precio" => 2000, "cantidad" => 1],
    ["id" => 14, "imagen" => "./imagenes/vestidoNovia2.webp", "nombre" => "Vestido encaje con estampado de flores", "descripcion" => "vestido escote en V", "precio" => 2850, "cantidad" => 1],
    ["id" => 15, "imagen" => "./imagenes/vestidoNovia3.jpg", "nombre" => "Vestido blanco sencillo", "descripcion" => "vestido escote en V sencillo", "precio" => 1100, "cantidad" => 1],
    ["id" => 16, "imagen" => "./imagenes/TrajeHombre1.jpeg", "nombre" => "Traje azul", "descripcion" => "Traje azul con camisa y corbata color claro", "precio" => 380, "cantidad" => 1],
    ["id" => 17, "imagen" => "./imagenes/TrajeHombre2.jpeg", "nombre" => "Traje negro", "descripcion" => "Traje negro con camisa y corbata blancas", "precio" => 700, "cantidad" => 1],
    ["id" => 18, "imagen" => "./imagenes/TrajeHombre3.jpeg", "nombre" => "Traje negro clásico", "descripcion" => "Traje negro con camisa blanca y corbata negra", "precio" => 650, "cantidad" => 1],
    ["id" => 32, "imagen" => "./imagenes/vestido4.jpg", "nombre" => "Vestido princesa", "descripcion" => "Vestido de novia estilo princesa con cola", "precio" => 3200, "cantidad" => 1],
    ["id" => 33, "imagen" => "./imagenes/vestido5.webp", "nombre" => "Vestido sirena", "descripcion" => "Vestido ajustado estilo sirena con encaje", "precio" => 2750, "cantidad" => 1],
    ["id" => 34, "imagen" => "./imagenes/vestido6.jpg", "nombre" => "Vestido corto de novia", "descripcion" => "Vestido de novia corto para ceremonia civil", "precio" => 850, "cantidad" => 1],
    ["id" => 35, "imagen" => "./imagenes/traje4.webp", "nombre" => "Traje gris claro", "descripcion" => "Traje gris claro con chaleco a juego", "precio" => 920, "cantidad" => 1],
    ["id" => 36, "imagen" => "./imagenes/traje5.webp", "nombre" => "Traje azul marino", "descripcion" => "Traje azul marino de tres piezas", "precio" => 1100, "cantidad" => 1],
    ["id" => 37, "imagen" => "./imagenes/traje6.avif", "nombre" => "Traje negro de etiqueta", "descripcion" => "Traje negro de etiqueta para ceremonia formal", "precio" => 1500, "cantidad" => 1]
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
    <title>Vestidos y Trajes - Everlia</title>
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
        <h1 class="text-center">Vestidos y Trajes</h1>
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
