<?php

require_once __DIR__ . '/../model/Persona.php';
require_once __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../model/Invitado.php';
require_once __DIR__ . '/../model/ListaBoda.php';
require_once __DIR__ . '/../model/Regalo.php';
require_once __DIR__ . '/../model/Venta.php';
require_once __DIR__ . '/../model/Producto.php';
require_once __DIR__ . '/../model/Viaje.php';
require_once __DIR__ . '/../model/Carrito.php';

// Añadir el archivo de configuración
require_once __DIR__ . '/../config.php';

function conectar(){
    // Configuración para PostgreSQL
    $host = getenv('DB_HOST') ?: 'dpg-d4om0ui4d50c73909keg-a';
    $port = getenv('DB_PORT') ?: '5432';
    $dbname = getenv('DB_NAME') ?: 'everlia';
    $user = getenv('DB_USER') ?: 'everlia_user';
    $password = getenv('DB_PASSWORD') ?: '2mIbsUXJxMFFSIc15ZAbphqlC6Z4wX0c';

    // Cadena de conexión para PostgreSQL
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

    try {
        // Crear conexión PDO
        $conexion = new PDO($dsn);
        
        // Configurar el modo de error para que lance excepciones
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Configurar el juego de caracteres
        $conexion->exec("SET NAMES 'UTF8'");
        
        return $conexion;
        
    } catch (PDOException $e) {
        // Registrar el error en el log del servidor
        error_log("Error de conexión a la base de datos: " . $e->getMessage());
        
        // Mostrar un mensaje genérico al usuario
        die("Error al conectar con la base de datos. Por favor, inténtalo más tarde.");
    }
}

function crearTablaPersona() {
    $c = conectar();

    // TABLA PERSONA
    $sql = "CREATE TABLE IF NOT EXISTS persona (
        id INT AUTO_INCREMENT PRIMARY KEY,  
        nombre VARCHAR(100) NOT NULL,
        email VARCHAR(115),
        password_hash VARCHAR(255) NOT NULL, 
        tipo ENUM('usuario', 'invitado') NOT NULL
        
    )";

    if (!$c->query($sql)) {
        die("Error al crear tabla persona: " . $c->error);
    }
}

    function crearTablaUsuario() {
        $c = conectar();

    // TABLA USUARIO
    $sql = "CREATE TABLE IF NOT EXISTS usuario (
        id INT AUTO_INCREMENT PRIMARY KEY,
        telefono VARCHAR(20),
        genero ENUM('Masculino', 'Femenino', 'Otro'),
        FOREIGN KEY (id) REFERENCES persona(id)
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla usuario: " . $c->error);
    }
}
function crearTablaInvitado() {
    $c = conectar();

    // TABLA INVITADO
    $sql = "CREATE TABLE IF NOT EXISTS invitado (
        id INT AUTO_INCREMENT PRIMARY KEY,
        relacion VARCHAR(50),
        FOREIGN KEY (id) REFERENCES persona(id)
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla invitado: " . $c->error);
    }

    }

    function crearTablaListaBoda() {
        $c = conectar();
    // TABLA LISTA BODA
    $sql = "CREATE TABLE IF NOT EXISTS lista_boda (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        nombre_lista VARCHAR(100),
        fecha_creacion DATETIME,
        FOREIGN KEY (usuario_id) REFERENCES usuario(id)
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla lista_boda: " . $c->error);
    }
    }
    function crearTablaRegalo() {
        $c = conectar();

    // TABLA REGALO
    $sql = "CREATE TABLE IF NOT EXISTS regalo (
        id INT AUTO_INCREMENT PRIMARY KEY,
        lista_boda_id INT NOT NULL,
        nombre VARCHAR(100),
        descripcion TEXT,
        precio DECIMAL(10, 2),
        url_producto VARCHAR(1024),
        comprado BOOLEAN DEFAULT FALSE,
        FOREIGN KEY (lista_boda_id) REFERENCES lista_boda(id)
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla regalo: " . $c->error);
    }

    }
    function crearTablaVenta() {
        $c = conectar();
    // TABLA VENTA
    $sql = "CREATE TABLE IF NOT EXISTS venta (
        id INT AUTO_INCREMENT PRIMARY KEY,
        precio DECIMAL(10, 2),
        descripcion TEXT
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla venta: " . $c->error);
    }
    }
    function crearTablaViaje() {
        $c = conectar();

    // TABLA VIAJE
    $sql = "CREATE TABLE IF NOT EXISTS viaje (
        id INT AUTO_INCREMENT PRIMARY KEY,
        destino VARCHAR(100),
        fecha_disponible DATETIME,
        FOREIGN KEY (id) REFERENCES venta(id)
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla viaje: " . $c->error);
    }
    }
    function crearTablaProducto() {
        $c = conectar();

    // TABLA PRODUCTO
    $sql = "CREATE TABLE IF NOT EXISTS producto (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100),
        cantidad INT,
        FOREIGN KEY (id) REFERENCES venta(id)
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla producto: " . $c->error);
    }
    }
    function crearTablaCarrito() {
        $c = conectar();

    // TABLA CARRITO
    $sql = "CREATE TABLE IF NOT EXISTS carrito (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        FOREIGN KEY (usuario_id) REFERENCES usuario(id)
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla carrito: " . $c->error);
    }
    }

function crearTablaContribucionRegalo() {
    $c = conectar();

    // TABLA CONTRIBUCIÓN REGALO
    $sql = "CREATE TABLE IF NOT EXISTS contribucion_regalo (
        id INT AUTO_INCREMENT PRIMARY KEY,
        regalo_id INT NOT NULL,
        invitado_id INT NOT NULL,
        cantidad DECIMAL(10, 2) NOT NULL,
        fecha DATETIME NOT NULL,
        FOREIGN KEY (regalo_id) REFERENCES regalo(id),
        FOREIGN KEY (invitado_id) REFERENCES persona(id)
    )";

    if (!$c->query($sql)) {
        die("Error al crear tabla contribucion_regalo: " . $c->error);
    }
}

function crearTablasInvitaciones() {
    $c = conectar();
    $sql1 = "CREATE TABLE IF NOT EXISTS invitaciones (
      id INT AUTO_INCREMENT PRIMARY KEY,
      usuario_id INT NOT NULL,
      titulo VARCHAR(200) NULL,
      diseno_json LONGTEXT NULL,
      imagen_path VARCHAR(255) NULL,
      creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      INDEX (usuario_id)
    )";
    if (!$c->query($sql1)) { die("Error al crear tabla invitaciones: " . $c->error); }

    $sql2 = "CREATE TABLE IF NOT EXISTS invitacion_destinatarios (
      id INT AUTO_INCREMENT PRIMARY KEY,
      invitacion_id INT NOT NULL,
      email VARCHAR(180) NULL,
      telefono VARCHAR(32) NULL,
      token VARCHAR(128) NOT NULL UNIQUE,
      estado ENUM('pendiente','aceptado','rechazado') DEFAULT 'pendiente',
      respondido_en TIMESTAMP NULL,
      creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      CONSTRAINT fk_dest_invitacion FOREIGN KEY (invitacion_id) REFERENCES invitaciones(id) ON DELETE CASCADE
    )";
    if (!$c->query($sql2)) { die("Error al crear tabla invitacion_destinatarios: " . $c->error); }
}

/**
 * Summary of registrarUsuario
 * @param mixed $id
 * @param mixed $nombre
 * @param mixed $email
 * @param mixed $telefono
 * @param mixed $pass
 * @param mixed $genero
 * @param mixed $tipo_usuario
 * @return bool
 * funcion para registrar a un usuario segun su id nombre emial telef contraseña y genero
 */
function registrarUsuario($id, $nombre, $email, $telefono, $pass, $genero, $tipo_usuario) {
    $conexion = conectar();

    // Hash de la contraseña
    $password_hash = password_hash($pass, PASSWORD_DEFAULT);

    // Insertar en la tabla persona
    $sqlPersona = "INSERT INTO persona (id, nombre, email, password_hash, tipo) VALUES (?, ?, ?, ?, ?)";
    $stmtPersona = $conexion->prepare($sqlPersona);
    $stmtPersona->bind_param("issss", $id, $nombre, $email, $password_hash, $tipo_usuario);
    $stmtPersona->execute();

    // Obtener el ID generado para persona
    $idPersona = $conexion->insert_id;

    if ($tipo_usuario === 'usuario') {
        // Insertar en la tabla usuario
        $sqlUsuario = "INSERT INTO usuario (id, telefono, genero) VALUES (?, ?, ?)";
        $stmtUsuario = $conexion->prepare($sqlUsuario);
        $stmtUsuario->bind_param("iss", $idPersona, $telefono, $genero);
        $stmtUsuario->execute();
        $stmtUsuario->close();
    } else {
        // Insertar en la tabla invitado
        $sqlInvitado = "INSERT INTO invitado (id) VALUES (?)";
        $stmtInvitado = $conexion->prepare($sqlInvitado);
        $stmtInvitado->bind_param("i", $idPersona);
        $stmtInvitado->execute();
        $stmtInvitado->close();
    }

    // Cerrar las declaraciones
    $stmtPersona->close();
    $conexion->close();

    return true;
}
?>