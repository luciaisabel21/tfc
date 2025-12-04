<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";

function crearInvitacion($usuarioId, $titulo, $disenoJson) {
    crearTablasInvitaciones();
    $c = conectar();
    $stmt = $c->prepare("INSERT INTO invitaciones (usuario_id, titulo, diseno_json) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $usuarioId, $titulo, $disenoJson);
    $stmt->execute();
    $id = $c->insert_id;
    $stmt->close();
    $c->close();
    return $id;
}

function generarToken() {
    return bin2hex(random_bytes(8)) . dechex(time());
}

function agregarDestinatarios($invitacionId, $emailsCsv) {
    $c = conectar();
    $emails = array_filter(array_map('trim', explode(',', $emailsCsv)));
    $result = [];
    foreach ($emails as $email) {
        $token = generarToken();
        $stmt = $c->prepare("INSERT INTO invitacion_destinatarios (invitacion_id, email, token) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $invitacionId, $email, $token);
        $stmt->execute();
        $stmt->close();
        $result[] = [ 'email' => $email, 'token' => $token ];
    }
    $c->close();
    return $result;
}

function obtenerInvitacionesPorUsuario($usuarioId) {
    $c = conectar();
    $sql = "SELECT i.*, 
        (SELECT COUNT(*) FROM invitacion_destinatarios d WHERE d.invitacion_id = i.id) as total,
        (SELECT COUNT(*) FROM invitacion_destinatarios d WHERE d.invitacion_id = i.id AND d.estado = 'aceptado') as aceptados,
        (SELECT COUNT(*) FROM invitacion_destinatarios d WHERE d.invitacion_id = i.id AND d.estado = 'rechazado') as rechazados
        FROM invitaciones i WHERE i.usuario_id = ? ORDER BY i.creado_en DESC";
    $stmt = $c->prepare($sql);
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    $res = $stmt->get_result();
    $rows = [];
    while ($row = $res->fetch_assoc()) { $rows[] = $row; }
    $stmt->close();
    $c->close();
    return $rows;
}

function obtenerDestinatariosPorInvitacion($invitacionId) {
    $c = conectar();
    $stmt = $c->prepare("SELECT * FROM invitacion_destinatarios WHERE invitacion_id = ? ORDER BY creado_en DESC");
    $stmt->bind_param("i", $invitacionId);
    $stmt->execute();
    $res = $stmt->get_result();
    $rows = [];
    while ($row = $res->fetch_assoc()) { $rows[] = $row; }
    $stmt->close();
    $c->close();
    return $rows;
}

function actualizarRSVPPorToken($token, $estado) {
    $c = conectar();
    $stmt = $c->prepare("UPDATE invitacion_destinatarios SET estado = ?, respondido_en = NOW() WHERE token = ?");
    $stmt->bind_param("ss", $estado, $token);
    $stmt->execute();
    $ok = $stmt->affected_rows > 0;
    $stmt->close();
    $c->close();
    return $ok;
}


