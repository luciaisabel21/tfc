<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";

crearTablaVenta();
crearTablaProducto();

$productos = [
    ["id" => 10, "imagen" => "./imagenes/decoracion.jpg", "nombre" => "Luces blancas", "descripcion" => "decora la zona que desees con luces blancas", "precio" => 50, "cantidad" => 1],
    ["id" => 11, "imagen" => "./imagenes/decoracionProducto1.jpeg", "nombre" => "Velas con flores", "descripcion" => "decora la mesa con velas y flores", "precio" => 30, "cantidad" => 1],
    ["id" => 12, "imagen" => "./imagenes/decoracionProducto2.jpg", "nombre" => "Accesorio para silla", "descripcion" => "decora las sillas con flores", "precio" => 20, "cantidad" => 1],
    ["id" => 13, "imagen" => "./imagenes/vestidoNovia.jpg", "nombre" => "Vestido palabra de honor", "descripcion" => "vestido encaje palabra de honor", "precio" => 2000, "cantidad" => 1],
    ["id" => 14, "imagen" => "./imagenes/vestidoNovia2.webp", "nombre" => "Vestido encaje con estampado de flores ", "descripcion" => "vestido escote en V ", "precio" => 2850, "cantidad" => 1],
    ["id" => 15, "imagen" => "./imagenes/vestidoNovia3.jpg", "nombre" => "Vestido blanco sencillo", "descripcion" => "vestido escote en V sencillo", "precio" => 1100, "cantidad" => 1],
    ["id" => 16, "imagen" => "./imagenes/TrajeHombre1.jpeg", "nombre" => "Traje azul", "descripcion" => "Traje azul con camisa y corbata color claro", "precio" => 380, "cantidad" => 1],
    ["id" => 17, "imagen" => "./imagenes/TrajeHombre2.jpeg", "nombre" => "Traje negro", "descripcion" => "Traje negro con camisa y corbata blancas", "precio" => 700, "cantidad" => 1],
    ["id" => 18, "imagen" => "./imagenes/TrajeHombre3.jpeg", "nombre" => "Traje negro", "descripcion" => "Traje negro con camisa blanca y corbata negra", "precio" => 650, "cantidad" => 1],
    ["id" => 19, "imagen" => "./imagenes/ramoFlores.jpg", "nombre" => "Ramo colores pastel", "descripcion" => "Ramo colores pastel rosa, blanco y verde", "precio" => 143, "cantidad" => 1],
    ["id" => 20, "imagen" => "./imagenes/ramoFlores1.jpeg", "nombre" => "Ramo colores vivos", "descripcion" => "Ramo colores fuertes verde, burdeos, rosa, amarillo ", "precio" => 100, "cantidad" => 1],
    ["id" => 21, "imagen" => "./imagenes/ramoFlores2.jpeg", "nombre" => "Ramo blanco y rosa", "descripcion" => "Ramo elegante blanco y diferentes tonos de rosa", "precio" => 150, "cantidad" => 1]
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["producto_id"])) {
    $productoId = $_POST["producto_id"];

    // Creo el carrito en la sesión si no existe
    if (!isset($_SESSION["carrito"])) {
        $_SESSION["carrito"] = [];
    }

    // Busco el producto por ID
    // Buscp el producto por ID
    foreach ($productos as $producto) {
        if ($producto["id"] == $productoId) {
            // Verifico si el producto ya está en el carrito
            $encontrado = false;
            foreach ($_SESSION["carrito"] as &$item) {
                if ($item["producto_id"] == $productoId) {
                    $item["cantidad"]++;
                    $encontrado = true;
                    break;
                }
            }

            // Si no está en el carrito,lo agrego
            if (!$encontrado) {
                $_SESSION["carrito"][] = [
                    "producto_id" => $productoId,
                    "nombre" => $producto["nombre"],
                    "imagen" => $producto["imagen"],
                    "descripcion" => $producto["descripcion"],
                    "precio" => $producto["precio"],
                    "cantidad" => 1,
                ];
            }

            break;
        }
    }

   
    header("Location: carrito.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
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
        <h1 class="text-center">Productos a la venta </h1>
        <div class="row">
            <?php $contador = 0; ?>
            <?php foreach ($productos as $producto): ?>
                
                <?php if ($contador % 3 == 0): ?>
                    <div class="row mb-4">
                <?php endif; ?>

                <!-- Tarjeta de producto -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" class="card-img-top" alt="Imagen de <?php echo htmlspecialchars($producto['nombre']); ?>">
                        <div class="card-body">
                            <h5 class="card-title">Nombre: <?php echo htmlspecialchars($producto["nombre"]); ?></h5>
                            <p class="card-text"><strong>Descripción:</strong> <?php echo htmlspecialchars($producto["descripcion"]); ?></p>
                            <p class="card-text"><strong>Precio:</strong> <?php echo htmlspecialchars($producto["precio"]); ?> € /persona</p>
                            <p class="card-text"><strong>Cantidad disponible:</strong> <?php echo htmlspecialchars($producto["cantidad"]); ?></p>
                            <form method="POST" class="mt-auto">
                                <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                                <button type="submit" class="btn btn-primary w-100">Añadir al Carrito</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- cierro la fila después de 3 productos -->
                <?php if ($contador % 3 == 2): ?>
                    </div>
                <?php endif; ?>

                <?php $contador++; ?>
            <?php endforeach; ?>

            <!-- cierro la última fila si tiene menos de 3 productos -->
            <?php if ($contador % 3 != 0): ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include_once "./views/pie.php"; ?>