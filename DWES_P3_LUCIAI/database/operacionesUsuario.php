<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesClases.php";

/**
 * Autentica a una persona por email, contraseña y rol
 */
function autenticarPersona($email, $pass, $rol) {
    try {
        $conexion = conectar();
        $sql = "SELECT id, nombre, email, password_hash, tipo FROM persona WHERE email = ? AND tipo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$email, $rol]);
        $persona = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($persona && password_verify($pass, $persona["password_hash"])) {
            return $persona;
        }
        return false;
    } catch (PDOException $e) {
        error_log("Error en autenticarPersona: " . $e->getMessage());
        return false;
    }
}

// FUNCIONES LISTA BODA #####################################################

function crearListaBoda($usuarioId, $nombreLista) {
    try {
        $conexion = conectar();
        $sql = "INSERT INTO lista_boda (usuario_id, nombre_lista, fecha_creacion) VALUES (?, ?, NOW())";
        $stmt = $conexion->prepare($sql);
        return $stmt->execute([$usuarioId, $nombreLista]);
    } catch (PDOException $e) {
        error_log("Error en crearListaBoda: " . $e->getMessage());
        return false;
    }
}

function modificarListaBoda($listaId, $nuevoNombre) {
    try {
        $conexion = conectar();
        $sql = "UPDATE lista_boda SET nombre_lista = ? WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        return $stmt->execute([$nuevoNombre, $listaId]);
    } catch (PDOException $e) {
        error_log("Error en modificarListaBoda: " . $e->getMessage());
        return false;
    }
}

function obtenerListasPorUsuario($usuarioId) {
    try {
        $conexion = conectar();
        $sql = "SELECT * FROM lista_boda WHERE usuario_id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error en obtenerListasPorUsuario: " . $e->getMessage());
        return [];
    }
}

function obtenerTodasLasListas() {
    try {
        $conexion = conectar();
        $sql = "SELECT * FROM lista_boda";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error en obtenerTodasLasListas: " . $e->getMessage());
        return [];
    }
}

function obtenerListasPorEmail($email) {
    try {
        $conexion = conectar();
        $sql = "SELECT lb.* FROM lista_boda lb 
                JOIN persona p ON lb.usuario_id = p.id 
                WHERE p.email = ? AND p.tipo = 'usuario'";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error en obtenerListasPorEmail: " . $e->getMessage());
        return [];
    }
}

function eliminarListaBoda($listaId) {
    try {
        $conexion = conectar();
        $sql = "DELETE FROM lista_boda WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        return $stmt->execute([$listaId]);
    } catch (PDOException $e) {
        error_log("Error en eliminarListaBoda: " . $e->getMessage());
        return false;
    }
}

// REGALOS FUNCIONES ########################################################

function añadirRegaloALista($listaId, $nombre, $descripcion, $precio, $urlProducto) {
    try {
        $conexion = conectar();
        $sql = "INSERT INTO regalo (lista_boda_id, nombre, descripcion, precio, url_producto) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        return $stmt->execute([$listaId, $nombre, $descripcion, $precio, $urlProducto]);
    } catch (PDOException $e) {
        error_log("Error en añadirRegaloALista: " . $e->getMessage());
        return false;
    }
}

function obtenerRegalosPorLista($listaId) {
    try {
        $conexion = conectar();
        $sql = "SELECT * FROM regalo WHERE lista_boda_id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$listaId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error en obtenerRegalosPorLista: " . $e->getMessage());
        return [];
    }
}

function eliminarRegaloDeLista($regaloId) {
    try {
        $conexion = conectar();
        $sql = "DELETE FROM regalo WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        return $stmt->execute([$regaloId]);
    } catch (PDOException $e) {
        error_log("Error en eliminarRegaloDeLista: " . $e->getMessage());
        return false;
    }
}

function marcarRegaloComoComprado($regaloId) {
    try {
        $conexion = conectar();
        $sql = "UPDATE regalo SET comprado = TRUE WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        return $stmt->execute([$regaloId]);
    } catch (PDOException $e) {
        error_log("Error en marcarRegaloComoComprado: " . $e->getMessage());
        return false;
    }
}

function contribuirARegalo($regaloId, $cantidad, $invitadoId) {
    try {
        $conexion = conectar();
        $conexion->beginTransaction();

        // Verificar si ya está comprado
        $sql = "SELECT comprado FROM regalo WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$regaloId]);
        $regalo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($regalo && $regalo['comprado']) {
            $conexion->rollBack();
            return false;
        }

        // Insertar contribución
        $sql = "INSERT INTO contribucion_regalo (regalo_id, invitado_id, cantidad, fecha) VALUES (?, ?, ?, NOW())";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$regaloId, $invitadoId, $cantidad]);

        // Verificar si está completamente pagado
        $sql = "SELECT r.precio, COALESCE(SUM(c.cantidad), 0) as total_contribuido 
                FROM regalo r 
                LEFT JOIN contribucion_regalo c ON r.id = c.regalo_id 
                WHERE r.id = ? 
                GROUP BY r.id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$regaloId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && $row['total_contribuido'] >= $row['precio']) {
            marcarRegaloComoComprado($regaloId);
        }

        $conexion->commit();
        return true;
    } catch (PDOException $e) {
        $conexion->rollBack();
        error_log("Error en contribuirARegalo: " . $e->getMessage());
        return false;
    }
}

function obtenerContribucionesRegalo($regaloId) {
    try {
        $conexion = conectar();
        $sql = "SELECT c.*, p.nombre as nombre_invitado 
                FROM contribucion_regalo c 
                JOIN persona p ON c.invitado_id = p.id 
                WHERE c.regalo_id = ? 
                ORDER BY c.fecha DESC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$regaloId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error en obtenerContribucionesRegalo: " . $e->getMessage());
        return [];
    }
}

// CARRITO FUNCIONES ####################################################

function crearCarrito($usuarioId) {
    try {
        $conexion = conectar();
        $sql = "INSERT INTO carrito (usuario_id) VALUES (?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$usuarioId]);
        return $conexion->lastInsertId(); // ✅ Así se obtiene el ID en PDO
    } catch (PDOException $e) {
        error_log("Error en crearCarrito: " . $e->getMessage());
        return false;
    }
}

function obtenerRegalosDelCarrito($carritoId) {
    try {
        $conexion = conectar();
        $sql = "SELECT r.id, r.nombre, r.descripcion, r.precio 
                FROM carrito_producto cp
                JOIN regalo r ON cp.producto_id = r.id
                WHERE cp.carrito_id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$carritoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error en obtenerRegalosDelCarrito: " . $e->getMessage());
        return [];
    }
}

function finalizarCompra($carritoId) {
    try {
        $conexion = conectar();
        $conexion->beginTransaction();

        // Marcar regalos como comprados
        $sql = "UPDATE regalo SET comprado = TRUE 
                WHERE id IN (SELECT producto_id FROM carrito_producto WHERE carrito_id = ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$carritoId]);

        // Vaciar carrito
        $sql = "DELETE FROM carrito_producto WHERE carrito_id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$carritoId]);

        $conexion->commit();
    } catch (PDOException $e) {
        $conexion->rollBack();
        error_log("Error en finalizarCompra: " . $e->getMessage());
    }
}

function vaciarCarrito($carritoId) {
    try {
        $conexion = conectar();
        $sql = "DELETE FROM carrito_producto WHERE carrito_id = ?";
        $stmt = $conexion->prepare($sql);
        return $stmt->execute([$carritoId]);
    } catch (PDOException $e) {
        error_log("Error en vaciarCarrito: " . $e->getMessage());
        return false;
    }
}
?>