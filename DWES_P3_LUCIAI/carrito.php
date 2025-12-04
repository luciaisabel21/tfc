<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";

// Inicializar el carrito si no existe
if (!isset($_SESSION["carrito"])) {
    $_SESSION["carrito"] = [];
}

// Obtener el carrito de la sesión
$carrito = &$_SESSION["carrito"];

// Procesar acciones del carrito
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["finalizar_compra"])) {
        // Redirigir a la pantalla de pago
        header("Location: pago.php");
        exit();
    } elseif (isset($_POST["vaciar_carrito"])) {
        $_SESSION["carrito"] = []; // Vaciar el carrito
        header("Location: carrito.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1>Carrito de Compras</h1>
        <?php if (empty($carrito)): ?>
            <p>No hay productos en el carrito.</p>
        <?php else: ?>
            <ul class="list-group">
                <?php 
                $total = 0;
                foreach ($carrito as $key => $item): 
                    // Si el ítem no tiene la estructura esperada, lo saltamos
                    if (!isset($item["producto_id"]) || !isset($item["nombre"])) {
                        continue;
                    }
                ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <?php if (isset($item["imagen"])): ?>
                            <img src="<?php echo htmlspecialchars($item["imagen"]); ?>" alt="Imagen del producto" class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                            <?php endif; ?>
                            <div>
                                <h5 class="mb-1"><?php echo htmlspecialchars($item["nombre"]); ?></h5>
                                <?php if (isset($item["descripcion"])): ?>
                                <p class="mb-1 text-muted"><?php echo htmlspecialchars($item["descripcion"]); ?></p>
                                <?php endif; ?>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 me-3"><strong>Precio:</strong> <?php echo number_format($item["precio"], 2); ?> €</p>
                                    <p class="mb-0"><strong>Cantidad:</strong> <?php echo htmlspecialchars($item["cantidad"] ?? 1); ?></p>
                                </div>
                                <p class="mb-0 mt-1"><strong>Subtotal:</strong> <?php 
                                    $subtotal = $item["precio"] * ($item["cantidad"] ?? 1);
                                    $total += $subtotal;
                                    echo number_format($subtotal, 2); 
                                ?> €</p>
                            </div>
                        </div>
                        <form method="post" action="eliminar_del_carrito.php" class="ms-3">
                            <input type="hidden" name="item_key" value="<?php echo $key; ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </li>
                <?php 
                endforeach; 
                
                // Si el carrito está vacío después de procesar los ítems
                if ($total === 0 && !empty($carrito)) {
                    $_SESSION["carrito"] = [];
                    $carrito = [];
                }
                ?>
            </ul>

            <!-- Resumen del Total -->
            <?php 
            // Determinar la página de origen (por defecto productos.php)
            $pagina_origen = $_SERVER['HTTP_REFERER'] ?? 'productos.php';
            // Si venimos de alguna página específica que no sea el carrito
            if (strpos($pagina_origen, 'carrito.php') !== false) {
                $pagina_origen = 'productos.php';
            }
            ?>
            <div class="d-flex justify-content-between mt-4">
                <div>
                    <a href="<?php echo htmlspecialchars($pagina_origen); ?>" class="btn btn-secondary me-2">Seguir comprando</a>
                    <form method="POST" class="d-inline">
                        <button type="submit" name="vaciar_carrito" class="btn btn-danger">Vaciar Carrito</button>
                    </form>
                </div>
                <form method="POST">
                    <button type="submit" name="finalizar_compra" class="btn btn-success">Finalizar Compra</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>