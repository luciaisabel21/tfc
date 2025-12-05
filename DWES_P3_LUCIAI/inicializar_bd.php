<?php
// Habilitar visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/database/funcionesBD.php';

try {
    echo "Iniciando inicialización de la base de datos...<br>";
    
    // Crear tablas en el orden correcto
    echo "Creando tabla persona...<br>";
    crearTablaPersona();
    
    echo "Creando tabla usuario...<br>";
    crearTablaUsuario();
    
    echo "Creando tabla invitado...<br>";
    crearTablaInvitado();
    
    echo "Creando tabla viaje...<br>";
    crearTablaViaje();
    
    echo "Creando tabla producto...<br>";
    crearTablaProducto();
    
    echo "Creando tabla lista_boda...<br>";
    crearTablaListaBoda();
    
    echo "Creando tabla regalo...<br>";
    crearTablaRegalo();
    
    echo "Creando tabla venta...<br>";
    crearTablaVenta();
    
    echo "Creando tabla carrito...<br>";
    crearTablaCarrito();
    
    echo "Creando tabla contribucion_regalo...<br>";
    crearTablaContribucionRegalo();
    
    echo "Creando tablas de invitaciones...<br>";
    crearTablasInvitaciones();

    echo "<br>¡Base de datos inicializada correctamente!<br>";
    echo "Todas las tablas se han creado sin errores.";
    
} catch (Exception $e) {
    echo "<br><strong>Error durante la inicialización:</strong><br>";
    echo $e->getMessage() . "<br>";
    echo "En el archivo: " . $e->getFile() . "<br>";
    echo "En la línea: " . $e->getLine();
}