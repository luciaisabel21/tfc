<?php
session_start();
// Solo usuarios autenticados de tipo 'usuario' deben acceder
if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'usuario') {
    header('Location: login.php');
    exit;
}
include_once __DIR__ . '/database/funcionesBD.php';
include_once __DIR__ . '/database/invitaciones_ops.php';
crearTablasInvitaciones();

$serverMessage = '';
$tituloValue = '';
$emailsValue = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'guardar') {
    $usuarioId = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0;
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $diseno = isset($_POST['diseno_json']) ? $_POST['diseno_json'] : '';
    $emails = isset($_POST['emails']) ? $_POST['emails'] : '';
    $tituloValue = $titulo;
    $emailsValue = $emails;
    if ($usuarioId > 0) {
        $invId = crearInvitacion($usuarioId, $titulo, $diseno);
        agregarDestinatarios($invId, $emails);
        $serverMessage = '¡Invitación guardada! Comparte los enlaces desde Ver mis invitaciones → Ver detalles.';
    } else {
        $serverMessage = 'No se ha identificado el usuario. Vuelve a iniciar sesión.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diseñador de Invitaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./views/estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;700&family=Montserrat:wght@400;600&family=Lora:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .designer-wrapper { max-width: 1200px; margin: 20px auto; }
        .toolbar { background: #ffffff; border: 1px solid #e9ecef; border-radius: 10px; padding: 12px; }
        .canvas-container { border: 1px dashed #ced4da; border-radius: 8px; background: #fff; }
        .color-input { width: 40px; height: 40px; padding: 0; border: none; background: transparent; }
        .sidebar { min-width: 280px; }
        .btn-icon { display: inline-flex; align-items: center; gap: 6px; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/fabric@5.3.0/dist/fabric.min.js"></script>
</head>
<body>
<?php include_once "./views/menu.php"; ?>

<main class="designer-wrapper">
    <h2 class="mb-3 text-center">Diseñador de Invitaciones</h2>
    <?php if (!empty($serverMessage)): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($serverMessage); ?></div>
    <?php endif; ?>
    <p class="text-center text-muted mb-4">Crea tu tarjeta desde cero: añade textos, colores, imágenes y formas. Exporta y comparte.</p>

    <div class="row g-3 align-items-start">
        <div class="col-12 col-lg-9">
            <div class="toolbar d-flex flex-wrap align-items-center gap-2 mb-2">
                <button id="addText" class="btn btn-sm btn-outline-primary btn-icon">Añadir texto</button>
                <button id="addRect" class="btn btn-sm btn-outline-secondary btn-icon">Rectángulo</button>
                <button id="addCircle" class="btn btn-sm btn-outline-secondary btn-icon">Círculo</button>
                <button id="bringFront" class="btn btn-sm btn-outline-dark">Al frente</button>
                <button id="sendBack" class="btn btn-sm btn-outline-dark">Al fondo</button>
                <div class="vr"></div>
                <label class="ms-1 me-1">Color:</label>
                <input id="fillColor" type="color" class="color-input" value="#222222" />
                <label class="ms-2 me-1">Fuente:</label>
                <select id="fontFamily" class="form-select form-select-sm" style="width:auto; min-width: 180px;">
                    <option value="Georgia" style="font-family:Georgia">Georgia</option>
                    <option value="Times New Roman" style="font-family:'Times New Roman'">Times New Roman</option>
                    <option value="Arial" style="font-family:Arial">Arial</option>
                    <option value="Montserrat" style="font-family:Montserrat">Montserrat</option>
                    <option value="Playfair Display" style="font-family:'Playfair Display'">Playfair Display</option>
                    <option value="Lora" style="font-family:Lora">Lora</option>
                    <option value="Great Vibes" style="font-family:'Great Vibes'">Great Vibes (caligráfica)</option>
                </select>
                <label class="ms-2 me-1">Fondo:</label>
                <input id="bgColor" type="color" class="color-input" value="#ffffff" />
                <div class="vr"></div>
                <input id="imageUpload" type="file" accept="image/*" class="form-control form-control-sm" style="max-width:260px;" />
                <div class="ms-auto d-flex gap-2">
                    <button id="clearCanvas" class="btn btn-sm btn-outline-danger">Limpiar</button>
                    <button id="exportPng" class="btn btn-sm btn-primary">Exportar PNG</button>
                </div>
            </div>

            <div class="mb-2">
                <div class="canvas-container p-2 d-inline-block">
                    <canvas id="invitationCanvas"></canvas>
                </div>
            </div>
            <small class="text-muted">Tamaño lienzo por defecto: 600x800 px (vertical). Puedes cambiar el color de fondo.</small>
        </div>

        <div class="col-12 col-lg-3">
            <div class="toolbar sidebar">
                <div class="d-grid gap-2 mb-3">
                    <button id="downloadPngShare" class="btn btn-outline-secondary">Descargar PNG (adjuntar en email)</button>
                </div>
                <form method="post" class="d-grid gap-3">
                    <input type="hidden" name="action" value="guardar" />
                    <input type="hidden" name="diseno_json" id="diseno_json" />
                    <div>
                        <label class="form-label">Título del diseño</label>
                        <input name="titulo" class="form-control form-control-sm" placeholder="Nuestra invitación" value="<?php echo htmlspecialchars($tituloValue); ?>" />
                    </div>
                    <div>
                        <label class="form-label">Destinatarios (emails separados por coma)</label>
                        <textarea name="emails" id="emailsField" rows="2" class="form-control" placeholder="invitado1@mail.com, invitado2@mail.com"><?php echo htmlspecialchars($emailsValue); ?></textarea>
                    </div>
                    <button class="btn btn-primary w-100">Guardar y generar enlaces</button>
                </form>
                <a href="gestionar_invitaciones.php" class="btn btn-link w-100 mt-2">Ver mis invitaciones</a>
                <small class="text-muted d-block mt-2">Guarda tu invitación y compártela desde “Ver mis invitaciones → Ver detalles”. Allí podrás copiar o enviar cada enlace con su estado.</small>
            </div>
        </div>
    </div>
</main>

<?php include_once "./views/pie.php"; ?>

<script>
    const canvas = new fabric.Canvas('invitationCanvas', { preserveObjectStacking: true, backgroundColor: '#ffffff' });
    // Tamaño visual 600x800 (vertical)
    canvas.setWidth(600);
    canvas.setHeight(800);

    function setCanvasBg(color) {
        canvas.setBackgroundColor(color, canvas.renderAll.bind(canvas));
    }

    document.getElementById('bgColor').addEventListener('input', (e) => setCanvasBg(e.target.value));

    document.getElementById('addText').addEventListener('click', () => {
        const text = new fabric.IText('Doble clic para editar', {
            left: 100,
            top: 100,
            fill: document.getElementById('fillColor').value,
            fontFamily: document.getElementById('fontFamily').value || 'Georgia',
            fontSize: 36
        });
        canvas.add(text).setActiveObject(text);
    });

    document.getElementById('addRect').addEventListener('click', () => {
        const rect = new fabric.Rect({ left: 80, top: 80, width: 200, height: 120, fill: document.getElementById('fillColor').value, rx: 12, ry: 12 });
        canvas.add(rect).setActiveObject(rect);
    });

    document.getElementById('addCircle').addEventListener('click', () => {
        const circle = new fabric.Circle({ left: 120, top: 120, radius: 60, fill: document.getElementById('fillColor').value });
        canvas.add(circle).setActiveObject(circle);
    });

    document.getElementById('fillColor').addEventListener('input', (e) => {
        const obj = canvas.getActiveObject();
        if (!obj) return;
        if (obj.type === 'i-text') { obj.set('fill', e.target.value); }
        else { obj.set('fill', e.target.value); }
        canvas.requestRenderAll();
    });

    // Cambio de fuente para texto seleccionado
    document.getElementById('fontFamily').addEventListener('change', (e) => {
        const obj = canvas.getActiveObject();
        if (!obj || obj.type !== 'i-text') return;
        obj.set('fontFamily', e.target.value);
        canvas.requestRenderAll();
    });

    document.getElementById('bringFront').addEventListener('click', () => {
        const obj = canvas.getActiveObject();
        if (obj) { obj.bringToFront(); canvas.requestRenderAll(); }
    });

    document.getElementById('sendBack').addEventListener('click', () => {
        const obj = canvas.getActiveObject();
        if (obj) { obj.sendToBack(); canvas.requestRenderAll(); }
    });

    document.getElementById('imageUpload').addEventListener('change', (e) => {
        const file = e.target.files && e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(f) {
            fabric.Image.fromURL(f.target.result, function(img) {
                img.set({ left: 50, top: 50, scaleX: 0.5, scaleY: 0.5 });
                canvas.add(img).setActiveObject(img);
            }, { crossOrigin: 'anonymous' });
        };
        reader.readAsDataURL(file);
        e.target.value = '';
    });

    document.getElementById('clearCanvas').addEventListener('click', () => {
        if (confirm('¿Vaciar el lienzo?')) {
            canvas.clear();
            setCanvasBg(document.getElementById('bgColor').value || '#ffffff');
        }
    });

    function downloadInvitationImage() {
        const dataUrl = canvas.toDataURL({ format: 'png', multiplier: 2 });
        const a = document.createElement('a');
        a.href = dataUrl;
        a.download = 'invitacion.png';
        a.click();
    }

    document.getElementById('exportPng').addEventListener('click', downloadInvitationImage);
    document.getElementById('downloadPngShare').addEventListener('click', downloadInvitationImage);

    // Guardado: serializa canvas en el campo oculto antes de enviar
    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (form && form.querySelector('input[name="action"][value="guardar"]')) {
            const json = JSON.stringify(canvas.toJSON(['selectable','evented']));
            document.getElementById('diseno_json').value = json;
        }
    });
</script>

</body>
</html>


