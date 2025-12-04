<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesClases.php";

/**
 * Summary of autenticarPersona
 * @param mixed $email
 * @param mixed $pass
 * @param mixed $rol
 * @return array|bool|null
 * funcion para que un usuario pueda loggearse tras haber iniciado sesion y tener un email, contraseña y rol
 */
function autenticarPersona($email, $pass, $rol) {
    $conexion = conectar();

    
    $sql = "SELECT id, nombre, email, password_hash, tipo FROM persona WHERE email = ? AND tipo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $email, $rol); 
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $persona = $resultado->fetch_assoc();
        if (password_verify($pass, $persona["password_hash"])) {
            // si los datos son correctos, devuelvo información del usuario
            return $persona;
        } else {
            // Contraseña incorrecta
            return false;
        }
    } else {
        // No se encontró el usuario o el rol no coincide
        return false;
    }

    $stmt->close();
    $conexion->close();
}

//FUNCIONES LISTA BODA#################################################################

/**
 * Summary of crearListaBoda
 * @param mixed $usuarioId
 * @param mixed $nombreLista
 * @return bool|mysqli_result
 * funcion para que un usuario con un id cree una lista de bodas con un nombre especiifoc
 */
function crearListaBoda($usuarioId, $nombreLista) {
    $datos = [
        'usuario_id' => $usuarioId,
        'nombre_lista' => $nombreLista,
        'fecha_creacion' => date('Y-m-d H:i:s')
    ];
    return insertarElemento('lista_boda', $datos);
}


/**
 * Summary of modificarListaBoda
 * @param mixed $listaId
 * @param mixed $nuevoNombre
 * @return bool
 * función para modificar el nombre de una lista segun su id 
 */
function modificarListaBoda($listaId, $nuevoNombre) {
    $c = conectar();

    $sql = $c->prepare("UPDATE lista_boda SET nombre_lista = ? WHERE id = ?");
    $sql->bind_param("ss", $nuevoNombre, $listaId);

    if ($sql->execute()) {
        $sql->close();
        $c->close();
        return true;
    } else {
        $sql->close();
        $c->close();
        return false;
    }
}

// Devuelve todas las listas de bodas de un usuario 
function obtenerListasPorUsuario($usuarioId) {
    return seleccionarPorCriterio('lista_boda', ['usuario_id' => $usuarioId]);
}

// Devuelve todas las listas de bodas disponibles en la base de datos.
function obtenerTodasLasListas() {
    return seleccionarTodo('lista_boda');
}

// Devuelve las listas de bodas de un organizador específico por su email
function obtenerListasPorEmail($email) {
    $conexion = conectar();
    $sql = "SELECT lb.* FROM lista_boda lb 
            JOIN persona p ON lb.usuario_id = p.id 
            WHERE p.email = ? AND p.tipo = 'usuario'";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $listas = [];
    while ($row = $result->fetch_assoc()) {
        $listas[] = $row;
    }
    $stmt->close();
    $conexion->close();
    return $listas;
}

 
/**
 * Summary of eliminarListaBoda
 * @param mixed $listaId
 * @return bool|mysqli_result
 * funcion para eliminar una lista de bodas según su id
 */
function eliminarListaBoda($listaId) {
    return eliminarElemento('lista_boda', $listaId);
}


//REGALOS FUNCIONES ##########################################################

//añado regalos a la lista
function añadirRegaloALista($listaId, $regaloId, $nombre, $descripcion, $precio, $urlProducto)
{
    $c = conectar();

    $sql = $c->prepare("INSERT INTO regalo (lista_boda_id, nombre, descripcion, precio, url_producto) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("issss", $listaId, $nombre, $descripcion, $precio, $urlProducto);
    $sql->execute();

    $c->close();
}
//Devuelve todos los regalos asociados a una lista de bodas.
function obtenerRegalosPorLista($listaId) {
    return seleccionarPorCriterio('regalo', ['lista_boda_id' => $listaId]);
}

//Elimina un regalo específico de una lista.
function eliminarRegaloDeLista($regaloId) {
    return eliminarElemento('regalo', $regaloId);
}
//Actualiza el campo comprado de un regalo para indicar que ha sido adquirido.
function marcarRegaloComoComprado($regaloId) {
    $conexion = conectar();
    $sql = "UPDATE regalo SET comprado = TRUE WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $regaloId);
    $resultado = $stmt->execute();
    $stmt->close();
    $conexion->close();
    return $resultado;
}

function contribuirARegalo($regaloId, $cantidad, $invitadoId) {
    $conexion = conectar();
    
    // Verificar si el regalo ya está comprado
    $sql = "SELECT comprado FROM regalo WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $regaloId);
    $stmt->execute();
    $result = $stmt->get_result();
    $regalo = $result->fetch_assoc();
    
    if ($regalo['comprado']) {
        $stmt->close();
        $conexion->close();
        return false; // El regalo ya está comprado
    }
    
    // Insertar la contribución
    $sql = "INSERT INTO contribucion_regalo (regalo_id, invitado_id, cantidad, fecha) VALUES (?, ?, ?, NOW())";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iid", $regaloId, $invitadoId, $cantidad);
    $resultado = $stmt->execute();
    
    // Verificar si el regalo está completamente pagado
    $sql = "SELECT r.precio, COALESCE(SUM(c.cantidad), 0) as total_contribuido 
            FROM regalo r 
            LEFT JOIN contribucion_regalo c ON r.id = c.regalo_id 
            WHERE r.id = ? 
            GROUP BY r.id";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $regaloId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['total_contribuido'] >= $row['precio']) {
        marcarRegaloComoComprado($regaloId);
    }
    
    $stmt->close();
    $conexion->close();
    return $resultado;
}

function obtenerContribucionesRegalo($regaloId) {
    $conexion = conectar();
    $sql = "SELECT c.*, p.nombre as nombre_invitado 
            FROM contribucion_regalo c 
            JOIN persona p ON c.invitado_id = p.id 
            WHERE c.regalo_id = ? 
            ORDER BY c.fecha DESC";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $regaloId);
    $stmt->execute();
    $result = $stmt->get_result();
    $contribuciones = [];
    while ($row = $result->fetch_assoc()) {
        $contribuciones[] = $row;
    }
    $stmt->close();
    $conexion->close();
    return $contribuciones;
}

//CARRITO FUNCIONES ####################################################

/**
 * Summary of crearCarrito
 * @param mixed $usuarioId
 * @return int|string
 * funcion para crear carrito segun el id delusuario 
 */
function crearCarrito($usuarioId) {
    $c = conectar();

    $sql = $c->prepare("INSERT INTO carrito (usuario_id) VALUES (?)");
    $sql->bind_param("s", $usuarioId);
    $sql->execute();

    
    $carritoId = $c->insert_id;
    $c->close();
    return $carritoId; 
}


function obtenerRegalosDelCarrito($carritoId) {
    $c = conectar();

    $sql = $c->prepare("SELECT r.id, r.nombre, r.descripcion, r.precio 
                        FROM carrito_producto cp
                        JOIN regalo r ON cp.producto_id = r.id
                        WHERE cp.carrito_id = ?");
    $sql->bind_param("s", $carritoId);
    $sql->execute();
    $resultado = $sql->get_result();

    $regalos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $regalos[] = $fila;
    }

    $c->close();
    return $regalos;
}

/**
 * Summary of finalizarCompra
 * @param mixed $carritoId
 * @return void
 * funcion para finalizar la compra con los productos que tengas en el carrito segun el id del carrito
 */
function finalizarCompra($carritoId) {
    $c = conectar();

    // Obtener los regalos del carrito
    $regalos = obtenerRegalosDelCarrito($carritoId);

    // Marcar cada regalo como comprado
    foreach ($regalos as $regalo) {
        $sql = $c->prepare("UPDATE regalo SET comprado = 1 WHERE id = ?");
        $sql->bind_param("s", $regalo["id"]);
        $sql->execute();
    }

    // Vaciar el carrito
    $sql = $c->prepare("DELETE FROM carrito_producto WHERE carrito_id = ?");
    $sql->bind_param("s", $carritoId);
    $sql->execute();

    $c->close();
}

/**
 * Summary of vaciarCarrito
 * @param mixed $carritoId
 * @return void
 * funcion para vaciar el carrito segun su id
 */
function vaciarCarrito($carritoId) {
    $c = conectar();

    $sql = $c->prepare("DELETE FROM carrito_producto WHERE carrito_id = ?");
    $sql->bind_param("s", $carritoId);
    $sql->execute();

    $c->close();
}

?>