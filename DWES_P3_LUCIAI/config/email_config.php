<?php
// Configuración SMTP para PHPMailer. Rellena con tus credenciales.
return [
    'enabled' => true,
    'host' => 'smtp.tu_proveedor.com',
    'port' => 587,
    'encryption' => 'tls', // 'ssl' o 'tls'
    'username' => 'tu_usuario_smtp',
    'password' => 'tu_password_smtp',
    'from_email' => 'no-reply@tu_dominio.com',
    'from_name' => 'Everlia',
];




