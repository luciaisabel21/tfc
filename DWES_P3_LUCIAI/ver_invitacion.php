<?php
session_start();
if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'usuario') {
    header('Location: login.php');
    exit;
}
include_once __DIR__ . '/database/invitaciones_ops.php';
include_once __DIR__ . '/database/funcionesBD.php';
crearTablasInvitaciones();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$detalles = [];
if ($id > 0) {
    $detalles = obtenerDestinatariosPorInvitacion($id);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Invitación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include_once "./views/menu.php"; ?>
<main class="container py-4">
    <a href="gestionar_invitaciones.php" class="btn btn-link">← Volver</a>
    <h3>Destinatarios</h3>
    <div class="mb-3">
        <label class="form-label">Mensaje para compartir</label>
        <input id="shareMessageGlobal" class="form-control" placeholder="¡Nos encantaría contar contigo! Confirma tu asistencia en el enlace." />
    </div>
    <div class="d-flex gap-2 align-items-end mb-3">
        <div>
            <label class="form-label">Filtro</label>
            <select id="copyFilter" class="form-select">
                <option value="pendiente">Solo pendientes</option>
                <option value="todos">Todos</option>
            </select>
        </div>
        <div class="ms-auto">
            <label class="form-label d-block" style="visibility:hidden;">&nbsp;</label>
            <button id="copyAllBtn" type="button" class="btn btn-outline-secondary">Copiar todos</button>
        </div>
    </div>
    <?php if (empty($detalles)): ?>
        <div class="alert alert-info">No hay destinatarios para esta invitación.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Estado</th>
                        <th>Respondido</th>
                        <th>Enlace</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detalles as $d): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($d['email']); ?></td>
                            <td><?php echo htmlspecialchars($d['estado']); ?></td>
                            <td><?php echo htmlspecialchars($d['respondido_en'] ?: '-'); ?></td>
                            <td><a target="_blank" class="invite-link" href="rsvp.php?token=<?php echo urlencode($d['token']); ?>">Abrir</a></td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-secondary btn-copy" data-email="<?php echo htmlspecialchars($d['email']); ?>" data-token="<?php echo htmlspecialchars($d['token']); ?>">Copiar enlace</button>
                                    <button type="button" class="btn btn-outline-primary btn-email" data-email="<?php echo htmlspecialchars($d['email']); ?>" data-token="<?php echo htmlspecialchars($d['token']); ?>">Email (cliente)</button>
                                    <button type="button" class="btn btn-outline-danger btn-gmail" data-email="<?php echo htmlspecialchars($d['email']); ?>" data-token="<?php echo htmlspecialchars($d['token']); ?>">Gmail</button>
                                    <button type="button" class="btn btn-outline-success btn-wa" data-token="<?php echo htmlspecialchars($d['token']); ?>">WhatsApp</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>
<?php include_once "./views/pie.php"; ?>
<script>
    function buildLink(token) {
        const base = window.location.origin;
        const path = window.location.pathname.replace('ver_invitacion.php', 'rsvp.php');
        const url = new URL(base + path);
        url.searchParams.set('token', token);
        return url.toString();
    }

    function getShareMessage() {
        return document.getElementById('shareMessageGlobal')?.value || '¡Nos encantaría contar contigo!';
    }

    function copyToClipboard(text) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            return navigator.clipboard.writeText(text);
        }
        const ta = document.createElement('textarea');
        ta.value = text; document.body.appendChild(ta); ta.select();
        try { document.execCommand('copy'); } catch (e) {}
        document.body.removeChild(ta);
        return Promise.resolve();
    }

    document.addEventListener('click', function(e) {
        const target = e.target;
        if (target.classList.contains('btn-copy')) {
            const token = target.getAttribute('data-token');
            const link = buildLink(token);
            copyToClipboard(link).then(() => {
                target.textContent = 'Copiado!';
                setTimeout(() => target.textContent = 'Copiar enlace', 1200);
            });
        }
        if (target.classList.contains('btn-email')) {
            const token = target.getAttribute('data-token');
            const email = target.getAttribute('data-email') || '';
            const subject = encodeURIComponent('Invitación a nuestra boda');
            const msg = getShareMessage();
            const link = buildLink(token);
            const body = encodeURIComponent(msg + '\n\nConfirma asistencia: ' + link);
            const mailto = `mailto:${email}?subject=${subject}&body=${body}`;
            window.location.href = mailto;
        }
        if (target.classList.contains('btn-gmail')) {
            const token = target.getAttribute('data-token');
            const email = encodeURIComponent(target.getAttribute('data-email') || '');
            const subject = encodeURIComponent('Invitación a nuestra boda');
            const msg = getShareMessage();
            const link = buildLink(token);
            const body = encodeURIComponent(msg + '\n\nConfirma asistencia: ' + link);
            const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=${email}&su=${subject}&body=${body}`;
            window.open(gmailUrl, '_blank');
        }
        if (target.classList.contains('btn-wa')) {
            const token = target.getAttribute('data-token');
            const msg = getShareMessage();
            const link = buildLink(token);
            const text = encodeURIComponent(msg + '\n\nConfirma asistencia: ' + link);
            window.open(`https://wa.me/?text=${text}`, '_blank');
        }
    });

    // Copiar todos los enlaces con filtro
    document.getElementById('copyAllBtn')?.addEventListener('click', () => {
        const rows = Array.from(document.querySelectorAll('table tbody tr'));
        const filter = document.getElementById('copyFilter').value; // 'pendiente' | 'todos'
        const header = getShareMessage();
        const lines = [];
        if (header) lines.push(header, '');
        rows.forEach((row) => {
            const tds = row.querySelectorAll('td');
            if (tds.length < 5) return;
            const email = tds[0].textContent.trim();
            const estado = tds[1].textContent.trim();
            if (filter === 'pendiente' && estado !== 'pendiente') return;
            const token = row.querySelector('.btn-copy')?.getAttribute('data-token');
            if (!token) return;
            const link = buildLink(token);
            lines.push(`${email}: ${link}`);
        });
        const text = lines.join('\n');
        copyToClipboard(text).then(() => {
            const btn = document.getElementById('copyAllBtn');
            const prev = btn.textContent;
            btn.textContent = 'Copiado!';
            setTimeout(() => btn.textContent = prev, 1200);
        });
    });
</script>
</body>
</html>


