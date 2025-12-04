<?php
session_start();
if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'usuario') {
    header('Location: login.php');
    exit;
}
include_once __DIR__ . '/database/invitaciones_ops.php';
include_once __DIR__ . '/database/funcionesBD.php';
crearTablasInvitaciones();

$usuarioId = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0;
$invitaciones = $usuarioId ? obtenerInvitacionesPorUsuario($usuarioId) : [];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Invitaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include_once "./views/menu.php"; ?>
<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Mis Invitaciones</h3>
        <a class="btn btn-primary" href="invitaciones.php">Crear nueva</a>
    </div>
    <?php if (!$usuarioId): ?>
        <div class="alert alert-warning">No se ha identificado el usuario.</div>
    <?php elseif (empty($invitaciones)): ?>
        <div class="alert alert-info">Aún no tienes invitaciones creadas.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Aceptados</th>
                        <th>Rechazados</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invitaciones as $inv): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($inv['titulo'] ?: 'Sin título'); ?></td>
                            <td><?php echo htmlspecialchars($inv['creado_en']); ?></td>
                            <td><?php echo intval($inv['total']); ?></td>
                            <td><?php echo intval($inv['aceptados']); ?></td>
                            <td><?php echo intval($inv['rechazados']); ?></td>
                            <td><a class="btn btn-sm btn-outline-secondary" href="ver_invitacion.php?id=<?php echo intval($inv['id']); ?>">Ver detalles</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>
<?php include_once "./views/pie.php"; ?>
</body>
</html>


