<?php

function getEmailConfig() {
    $configPath = __DIR__ . '/../config/email_config.php';
    if (file_exists($configPath)) {
        return include $configPath;
    }
    return ['enabled' => false];
}

function sendEmail($to, $subject, $body) {
    $cfg = getEmailConfig();

    // Intentar usar PHPMailer si está disponible y habilitado
    if (!empty($cfg['enabled']) && class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        try {
            $mailer = new PHPMailer\PHPMailer\PHPMailer(true);
            $mailer->isSMTP();
            $mailer->Host = $cfg['host'] ?? '';
            $mailer->SMTPAuth = true;
            $mailer->Username = $cfg['username'] ?? '';
            $mailer->Password = $cfg['password'] ?? '';
            if (!empty($cfg['encryption'])) { $mailer->SMTPSecure = $cfg['encryption']; }
            $mailer->Port = (int)($cfg['port'] ?? 587);
            $fromEmail = $cfg['from_email'] ?? 'no-reply@example.com';
            $fromName = $cfg['from_name'] ?? 'Everlia';
            $mailer->setFrom($fromEmail, $fromName);
            // Soporta múltiples destinatarios separados por coma
            foreach (array_filter(array_map('trim', explode(',', $to))) as $addr) {
                $mailer->addAddress($addr);
            }
            $mailer->Subject = $subject;
            $mailer->Body = $body;
            $mailer->AltBody = strip_tags($body);
            return $mailer->send();
        } catch (Throwable $e) {
            // Si PHPMailer falla, intentar mail() como fallback
        }
    }

    // Fallback: mail() nativo (puede requerir configuración del servidor)
    $headers = '';
    if (!empty($cfg['from_email'])) {
        $from = $cfg['from_name'] ? $cfg['from_name'] . ' <' . $cfg['from_email'] . '>' : $cfg['from_email'];
        $headers .= 'From: ' . $from . "\r\n";
    }
    return @mail($to, $subject, $body, $headers);
}




