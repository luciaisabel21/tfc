<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/operacionesUsuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/securizar.php";

crearTablaListaBoda();
crearTablaRegalo();
crearTablaContribucionRegalo();

// Verificar que el usuario esté autenticado y sea de tipo "invitado"
if (!isset($_SESSION["usuario_tipo"]) || $_SESSION["usuario_tipo"] != "invitado") {
    header("Location: index.php");
    exit();
}

$invitadoId = $_SESSION["usuario_id"];
$listas = [];
$email_busqueda = "";
$mensaje = "";

// Procesar búsqueda por email
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["email"])) {
    $email_busqueda = securizar($_GET["email"]);
    $listas = obtenerListasPorEmail($email_busqueda);
    if (empty($listas)) {
        $mensaje = "No se encontraron listas de boda para el email proporcionado.";
    }
}

// Procesar contribución a regalo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["regalo_id"]) && isset($_POST["cantidad"])) {
    $regaloId = securizar($_POST["regalo_id"]);
    $cantidad = securizar($_POST["cantidad"]);
    
    if (is_numeric($cantidad) && $cantidad > 0) {
        contribuirARegalo($regaloId, $cantidad, $invitadoId);
        header("Location: ver_listas_invitado.php" . ($email_busqueda ? "?email=" . urlencode($email_busqueda) : ""));
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listas de Bodas</title>
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
        .progress {
            height: 25px;
        }
        .progress-bar {
            background-color: #ff69b4;
        }
        .search-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <?php include_once "./views/menu.php"; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4 text-center">Buscar Listas de Bodas</h1>

                <!-- Formulario de búsqueda -->
                <div class="search-container">
                    <form method="GET" class="row g-3 justify-content-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="email" class="form-control" name="email" 
                                       placeholder="Introduce el email del organizador de la boda" 
                                       value="<?php echo htmlspecialchars($email_busqueda); ?>" required>
                                <button class="btn btn-primary" type="submit">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <?php if ($mensaje): ?>
                    <div class="alert alert-info text-center">
                        <?php echo htmlspecialchars($mensaje); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($listas)): ?>
                    <h2 class="mb-4 text-center">Listas de Bodas Encontradas</h2>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php foreach ($listas as $lista): ?>
                            <div class="col">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($lista["nombre_lista"]); ?></h5>
                                        
                                        <?php 
                                        $regalos = obtenerRegalosPorLista($lista["id"]);
                                        foreach ($regalos as $regalo): 
                                            $contribuciones = obtenerContribucionesRegalo($regalo["id"]);
                                            $totalContribuido = array_sum(array_column($contribuciones, "cantidad"));
                                            $porcentaje = ($totalContribuido / $regalo["precio"]) * 100;
                                        ?>
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h6 class="card-title"><?php echo htmlspecialchars($regalo["nombre"]); ?></h6>
                                                    <p class="card-text">
                                                        <strong>Precio:</strong> <?php echo htmlspecialchars($regalo["precio"]); ?> €<br>
                                                        <strong>Descripción:</strong> <?php echo htmlspecialchars($regalo["descripcion"]); ?>
                                                    </p>
                                                    
                                                    <div class="progress mb-3">
                                                        <div class="progress-bar" role="progressbar" 
                                                             style="width: <?php echo min($porcentaje, 100); ?>%"
                                                             aria-valuenow="<?php echo $porcentaje; ?>" 
                                                             aria-valuemin="0" 
                                                             aria-valuemax="100">
                                                            <?php echo number_format($porcentaje, 1); ?>%
                                                        </div>
                                                    </div>
                                                    
                                                    <?php if (!$regalo["comprado"]): ?>
                                                        <div class="d-flex gap-2 mb-2">
                                                            <a href="<?php echo htmlspecialchars($regalo["url_producto"]); ?>" 
                                                               target="_blank" 
                                                               class="btn btn-success btn-sm flex-grow-1">
                                                                Comprar Producto
                                                            </a>
                                                            <button type="button" 
                                                                    class="btn btn-primary btn-sm flex-grow-1" 
                                                                    onclick="abrirModal(<?php echo $regalo["id"]; ?>)">
                                                                Contribuir
                                                            </button>
                                                        </div>
                                                        
                                                        <!-- Modal para contribuir -->
                                                        <div class="modal" id="contribuirModal<?php echo $regalo["id"]; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Contribuir a <?php echo htmlspecialchars($regalo["nombre"]); ?></h5>
                                                                        <button type="button" class="btn-close" onclick="cerrarModal(<?php echo $regalo["id"]; ?>)"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form id="contribuirForm<?php echo $regalo["id"]; ?>" method="POST">
                                                                            <input type="hidden" name="regalo_id" value="<?php echo $regalo["id"]; ?>">
                                                                            <div class="mb-3">
                                                                                <label for="cantidad<?php echo $regalo["id"]; ?>" class="form-label">Cantidad a contribuir (€):</label>
                                                                                <input type="number" class="form-control" id="cantidad<?php echo $regalo["id"]; ?>" name="cantidad" 
                                                                                       min="1" max="<?php echo $regalo["precio"] - $totalContribuido; ?>" 
                                                                                       step="0.01" required>
                                                                                <div class="form-text">
                                                                                    Precio total: <?php echo number_format($regalo["precio"], 2); ?> €<br>
                                                                                    Ya contribuido: <?php echo number_format($totalContribuido, 2); ?> €<br>
                                                                                    Restante: <?php echo number_format($regalo["precio"] - $totalContribuido, 2); ?> €
                                                                                </div>
                                                                            </div>
                                                                            <button type="submit" class="btn btn-primary">Contribuir</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="alert alert-success mb-0">
                                                            <i class="fas fa-check-circle"></i> ¡Regalo completado!
                                                            <?php if (!empty($contribuciones)): ?>
                                                                <div class="mt-2">
                                                                    <small>Contribuciones realizadas:</small>
                                                                    <ul class="list-unstyled mb-0">
                                                                        <?php foreach ($contribuciones as $contribucion): ?>
                                                                            <li>
                                                                                <small>
                                                                                    <?php echo htmlspecialchars($contribucion["nombre_invitado"]); ?> - 
                                                                                    <?php echo number_format($contribucion["cantidad"], 2); ?> €
                                                                                </small>
                                                                            </li>
                                                                        <?php endforeach; ?>
                                                                    </ul>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let modales = {};

        function abrirModal(regaloId) {
            const modalId = 'contribuirModal' + regaloId;
            if (!modales[modalId]) {
                modales[modalId] = new bootstrap.Modal(document.getElementById(modalId));
            }
            modales[modalId].show();
        }

        function cerrarModal(regaloId) {
            const modalId = 'contribuirModal' + regaloId;
            if (modales[modalId]) {
                modales[modalId].hide();
            }
        }

        // Prevenir el cierre accidental del modal
        document.addEventListener('DOMContentLoaded', function() {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        e.stopPropagation();
                    }
                });
            });
        });
    </script>
</body>
</html>
<?php include_once "./views/pie.php"; ?> 