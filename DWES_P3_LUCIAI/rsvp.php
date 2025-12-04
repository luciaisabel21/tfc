<?php
session_start();
include_once __DIR__ . '/database/invitaciones_ops.php';
include_once __DIR__ . '/database/funcionesBD.php';
crearTablasInvitaciones();
// Token recibido por enlace y validación en BD.
$token = isset($_GET['token']) ? trim($_GET['token']) : '';

// Manejar respuesta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = isset($_POST['token']) ? trim($_POST['token']) : '';
    $respuesta = isset($_POST['respuesta']) ? $_POST['respuesta'] : '';
    if ($token) {
        $estado = ($respuesta === 'si') ? 'aceptado' : 'rechazado';
        $ok = actualizarRSVPPorToken($token, $estado);
        $_SESSION['rsvp_msg'] = $ok
            ? (($estado === 'aceptado') ? '¡Gracias! Has confirmado tu asistencia.' : 'Hemos registrado que no podrás asistir. ¡Gracias por avisar!')
            : 'Enlace no válido o ya respondido.';
    }
    header('Location: rsvp.php?token=' . urlencode($token));
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de asistencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="card-title mb-3 text-center">Confirmación de asistencia</h3>
                        <?php if (!empty($_SESSION['rsvp_msg'])): ?>
                            <div class="alert alert-info" role="alert">
                                <?php echo htmlspecialchars($_SESSION['rsvp_msg']); unset($_SESSION['rsvp_msg']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!$token): ?>
                            <div class="alert alert-warning">Enlace no válido o incompleto.</div>
                        <?php else: ?>
                            <p class="text-muted">Has recibido una invitación. Por favor, confirma si asistirás a la boda.</p>
                            <form method="post" class="d-flex gap-2">
                                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>" />
                                <button name="respuesta" value="si" class="btn btn-success flex-fill">Sí, asistiré</button>
                                <button name="respuesta" value="no" class="btn btn-outline-secondary flex-fill">No podré asistir</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


