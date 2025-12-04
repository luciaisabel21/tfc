-- Esquema inicial para invitaciones y RSVP

CREATE TABLE IF NOT EXISTS invitaciones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  titulo VARCHAR(200) NULL,
  diseno_json LONGTEXT NULL,
  imagen_path VARCHAR(255) NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (usuario_id)
);

CREATE TABLE IF NOT EXISTS invitacion_destinatarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  invitacion_id INT NOT NULL,
  email VARCHAR(180) NULL,
  telefono VARCHAR(32) NULL,
  token VARCHAR(128) NOT NULL UNIQUE,
  estado ENUM('pendiente','aceptado','rechazado') DEFAULT 'pendiente',
  respondido_en TIMESTAMP NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_dest_invitacion FOREIGN KEY (invitacion_id) REFERENCES invitaciones(id) ON DELETE CASCADE
);

-- Para rsvp.php: buscar por token en invitacion_destinatarios y actualizar estado/fecha
-- UPDATE invitacion_destinatarios SET estado = 'aceptado', respondido_en = NOW() WHERE token = :token;
-- UPDATE invitacion_destinatarios SET estado = 'rechazado', respondido_en = NOW() WHERE token = :token;


