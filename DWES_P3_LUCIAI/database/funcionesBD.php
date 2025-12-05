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

// Configuración de rutas base
define('BASE_PATH', __DIR__);
define('BASE_URL', 'https://tfc-cmct.onrender.com');

// Habilitar modo debug en desarrollo
define('DEBUG', true);  // Cambiar a false en producción

// Configuración de errores
if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/error.log');
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
function conectar(){
    // Configuración para PostgreSQL
    $host = getenv('DB_HOST') ?: 'dpg-d4om0ui4d50c73909keg-a';
    $port = getenv('DB_PORT') ?: '5432';
    $dbname = getenv('DB_NAME') ?: 'everlia';
    $user = getenv('DB_USER') ?: 'everlia_user';
    $password = getenv('DB_PASSWORD') ?: '2mIbsUXJxMFFSIc15ZAbphqlC6Z4wX0c';

    try {
        // Cadena de conexión para PostgreSQL (formato separado)
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        
        // Opciones de conexión
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        // Crear conexión PDO
        $conexion = new PDO($dsn, $user, $password, $options);
        
        // Configurar el juego de caracteres
        $conexion->exec("SET NAMES 'UTF8'");
        
        return $conexion;
        
    } catch (PDOException $e) {
        // Registrar el error en el log del servidor con más detalles
        error_log("Error de conexión a la base de datos - " . date('Y-m-d H:i:s') . ": " . $e->getMessage());
        error_log("Intentando conectar a: pgsql://$user:*****@$host:$port/$dbname");
        
        // Mostrar un mensaje genérico al usuario pero con más detalles en modo debug
        if (defined('DEBUG') && DEBUG === true) {
            die("Error de conexión a la base de datos: " . $e->getMessage() . ". DSN: pgsql://$user:*****@$host:$port/$dbname");
        } else {
            die("Error al conectar con la base de datos. Por favor, inténtalo más tarde o contacta al administrador.");
        }
    }
}

function crearTablaPersona() {
    $c = conectar();

    // Primero creamos un tipo ENUM si no existe
    $c->exec("
        DO $$
        BEGIN
            IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'tipo_persona') THEN
                CREATE TYPE tipo_persona AS ENUM ('usuario', 'invitado');
            END IF;
        END
        $$;
    ");

    // TABLA PERSONA
    $sql = "CREATE TABLE IF NOT EXISTS persona (
        id SERIAL PRIMARY KEY,  
        nombre VARCHAR(100) NOT NULL,
        email VARCHAR(115),
        password_hash VARCHAR(255) NOT NULL, 
        tipo tipo_persona NOT NULL
    )";

    $c->exec($sql);
}

function crearTablaUsuario() {
    $c = conectar();

    // Crear tipo ENUM para género si no existe
    $c->exec("
        DO $$
        BEGIN
            IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'genero_enum') THEN
                CREATE TYPE genero_enum AS ENUM ('Masculino', 'Femenino', 'Otro');
            END IF;
        END
        $$;
    ");

    // TABLA USUARIO
    $sql = "CREATE TABLE IF NOT EXISTS usuario (
        id INT PRIMARY KEY,
        telefono VARCHAR(20),
        genero genero_enum,
        FOREIGN KEY (id) REFERENCES persona(id)
    )";

    $c->exec($sql);
}
function crearTablaInvitado() {
    $c = conectar();

    // Crear tipo ENUM para género si no existe
    $c->exec("
        DO $$
        BEGIN
            IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'genero_enum') THEN
                CREATE TYPE genero_enum AS ENUM ('Masculino', 'Femenino', 'Otro');
            END IF;
        END
        $$;
    ");

    // TABLA INVITADO
    $sql = "CREATE TABLE IF NOT EXISTS invitado (
        id INT PRIMARY KEY,
        relacion VARCHAR(50),
        telefono VARCHAR(20),
        genero genero_enum,
        FOREIGN KEY (id) REFERENCES persona(id)
    )";

    $c->exec($sql);
}
   function crearTablaListaBoda() {
    $c = conectar();
    
    // TABLA LISTA BODA
    $sql = "CREATE TABLE IF NOT EXISTS lista_boda (
        id SERIAL PRIMARY KEY,
        usuario_id INT NOT NULL,
        nombre_lista VARCHAR(100),
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuario(id)
    )";
    
    $c->exec($sql);
}
   function crearTablaRegalo() {
    $c = conectar();

    // TABLA REGALO
    $sql = "CREATE TABLE IF NOT EXISTS regalo (
        id SERIAL PRIMARY KEY,
        lista_boda_id INT NOT NULL,
        nombre VARCHAR(100) NOT NULL,
        descripcion TEXT,
        precio DECIMAL(10,2),
        url_imagen VARCHAR(255),
        estado VARCHAR(50) DEFAULT 'disponible',
        FOREIGN KEY (lista_boda_id) REFERENCES lista_boda(id)
    )";
    
    $c->exec($sql);
}

    
   function crearTablaVenta() {
    $c = conectar();

    // TABLA VENTA
    $sql = "CREATE TABLE IF NOT EXISTS venta (
        id SERIAL PRIMARY KEY,
        usuario_id INT NOT NULL,
        fecha_venta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        monto_total DECIMAL(10,2) NOT NULL,
        estado VARCHAR(50) DEFAULT 'pendiente',
        FOREIGN KEY (usuario_id) REFERENCES usuario(id)
    )";
    
    $c->exec($sql);
}
    
   function crearTablaViaje() {
    $c = conectar();

    // TABLA VIAJE
    $sql = "CREATE TABLE IF NOT EXISTS viaje (
        id SERIAL PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        descripcion TEXT,
        fecha_inicio DATE,
        fecha_fin DATE,
        precio DECIMAL(10,2),
        plazas_totales INT,
        plazas_disponibles INT,
        imagen_url VARCHAR(255)
    )";
    
    $c->exec($sql);
}    function crearTablaProducto() {
    $c = conectar();

    // Crear tipo ENUM para categoría si no existe
    $c->exec("
        DO $$
        BEGIN
            IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'categoria_enum') THEN
                CREATE TYPE categoria_enum AS ENUM ('flores', 'decoracion', 'vestuario');
            END IF;
        END
        $$;
    ");

    // TABLA PRODUCTO
    $sql = "CREATE TABLE IF NOT EXISTS producto (
        id SERIAL PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        descripcion TEXT,
        precio DECIMAL(10,2) NOT NULL,
        stock INT DEFAULT 0,
        categoria categoria_enum,
        imagen_url VARCHAR(255)
    )";
    
    $c->exec($sql);
}
    function crearTablaCarrito() {
    $c = conectar();

    // TABLA CARRITO
    $sql = "CREATE TABLE IF NOT EXISTS carrito (
        id SERIAL PRIMARY KEY,
        usuario_id INT NOT NULL,
        producto_id INT NOT NULL,
        cantidad INT DEFAULT 1,
        fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuario(id),
        FOREIGN KEY (producto_id) REFERENCES producto(id)
    )";
    
    $c->exec($sql);
}

function crearTablaContribucionRegalo() {
    $c = conectar();

    // TABLA CONTRIBUCIÓN REGALO
    $sql = "CREATE TABLE IF NOT EXISTS contribucion_regalo (
        id SERIAL PRIMARY KEY,
        usuario_id INT NOT NULL,
        regalo_id INT NOT NULL,
        monto_contribuido DECIMAL(10,2) NOT NULL,
        fecha_contribucion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        mensaje TEXT,
        anonimo BOOLEAN DEFAULT false,
        FOREIGN KEY (usuario_id) REFERENCES usuario(id),
        FOREIGN KEY (regalo_id) REFERENCES regalo(id)
    )";
    
    $c->exec($sql);
}
function crearTablasInvitaciones() {
    $c = conectar();

    // TABLA INVITACION
    $sql = "CREATE TABLE IF NOT EXISTS invitacion (
        id SERIAL PRIMARY KEY,
        codigo_invitacion VARCHAR(50) UNIQUE NOT NULL,
        lista_boda_id INT NOT NULL,
        nombre_invitado VARCHAR(100),
        email VARCHAR(100),
        confirmacion_asistencia BOOLEAN DEFAULT NULL,
        fecha_confirmacion TIMESTAMP,
        mensaje TEXT,
        FOREIGN KEY (lista_boda_id) REFERENCES lista_boda(id)
    )";
    
    $c->exec($sql);

    // TABLA ASISTENTE
    $sql = "CREATE TABLE IF NOT EXISTS asistente (
        id SERIAL PRIMARY KEY,
        invitacion_id INT NOT NULL,
        nombre VARCHAR(100) NOT NULL,
        alergias TEXT,
        restricciones_alimentarias TEXT,
        FOREIGN KEY (invitacion_id) REFERENCES invitacion(id)
    )";
    
    $c->exec($sql);
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

    try {
        // Iniciar transacción
        $conexion->beginTransaction();

        // Hash de la contraseña
        $password_hash = password_hash($pass, PASSWORD_DEFAULT);

        // Insertar en la tabla persona
        $sqlPersona = "INSERT INTO persona (id, nombre, email, password_hash, tipo) VALUES (?, ?, ?, ?, ?)";
        $stmtPersona = $conexion->prepare($sqlPersona);
        $stmtPersona->execute([$id, $nombre, $email, $password_hash, $tipo_usuario]);

        // Obtener el ID generado para persona
        $idPersona = $conexion->lastInsertId();

        if ($tipo_usuario === 'usuario') {
            // Insertar en la tabla usuario
            $sqlUsuario = "INSERT INTO usuario (id, telefono, genero) VALUES (?, ?, ?)";
            $stmtUsuario = $conexion->prepare($sqlUsuario);
            $stmtUsuario->execute([$idPersona, $telefono, $genero]);
        } else {
            // Insertar en la tabla invitado
            $sqlInvitado = "INSERT INTO invitado (id) VALUES (?)";
            $stmtInvitado = $conexion->prepare($sqlInvitado);
            $stmtInvitado->execute([$idPersona]);
        }

        // Confirmar la transacción
        $conexion->commit();
        return true;

    } catch (PDOException $e) {
        // En caso de error, deshacer la transacción
        if ($conexion->inTransaction()) {
            $conexion->rollBack();
        }
        
        // Registrar el error
        error_log("Error en registrarUsuario: " . $e->getMessage());
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}
?>