<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/securizar.php";

$nombre = $tarjeta = $direccion = "";
$nombreErr = $tarjetaErr = $direccionErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = securizar($_POST["nombre"]);
    $tarjeta = securizar($_POST["tarjeta"]);
    $direccion = securizar($_POST["direccion"]);
  
    // Validación de nombre
    if (!empty($_POST["nombre"])) {
        $nombre = $_POST["nombre"];
    } else {
        $nombreErr = "El nombre es obligatorio";
        $errores = true;
    }
    
    // Validación de tarjeta
    if (!empty($_POST["tarjeta"])) {
        $tarjeta = $_POST["tarjeta"];
    } else {
        $tarjetaErr = "La tarjeta es obligatoria";
        $errores = true;
    }

      // Validación de dierccion
      if (!empty($_POST["direccion"])) {
        $direccion = $_POST["direccion"];
    } else {
        $direccionErr = "La direccion es obligatoria";
        $errores = true;
    }
}
// Verifico si la compra fue realizada
if (!isset($_SESSION["resumen_compra"])) {
    header("Location: carrito.php");
    exit();
}

$resumen = $_SESSION["resumen_compra"];
$total = $_SESSION["total_compra"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulación de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h1>Simulación de Pago</h1>

        <h3>Resumen de tu Compra</h3>
        <ul class="list-group">
            <?php foreach ($resumen as $item): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?php echo htmlspecialchars($item["descripcion"]); ?></strong><br>
                        Precio: <?php echo htmlspecialchars($item["precio"]); ?> €<br>
                        Fecha seleccionada: <?php echo htmlspecialchars($item["fecha"]); ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="mt-3">
            <h4>Total de la compra: <?php echo htmlspecialchars($total); ?> €</h4>
        </div>

        <h3>Detalles de Pago</h3>
        <form method="POST">
            <div class="mb-3">
                <label > Nombre completo</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>"><br>
                <?php if (!empty($nombreErr)) echo "<label class='error'>$nombreErr</label>"; ?><br>
            </div>
            <div class="mb-3">
                <label>Número de tarjeta</label>
                <input type="text" name="tarjeta" value="<?php echo htmlspecialchars($tarjeta); ?>"><br>
                <?php if (!empty($tarjetaErr)) echo "<label class='error'>$tarjetaErr</label>"; ?><br>
            </div>
            <div class="mb-3">
                <label>Dirección de envío</label>
                <input type="text" name="direccion" value="<?php echo htmlspecialchars($direccion); ?>"><br>
                <?php if (!empty($direccionErr)) echo "<label class='error'>$direccionErr</label>"; ?><br>
            </div>
            <button type="submit" class="btn btn-primary">Pagar</button>
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="alert alert-success mt-3">
                ¡Compra realizada con éxito! Hemos simulado tu pago.
            </div>
            <?php
            
            session_unset();
            session_destroy();
            ?>
        <?php endif; ?>
    </div>
</body>

</html>