<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";

/**
 * Inserta un nuevo registro en la tabla especificada.
 * @param string $tabla
 * @param array $datos
 * @return bool
 */
function insertarElemento($tabla, $datos)
{
    $conexion = conectar();
    $columnas = implode(", ", array_keys($datos));
    $placeholders = ':' . implode(', :', array_keys($datos));

    $sql = "INSERT INTO $tabla ($columnas) VALUES ($placeholders)";
    $stmt = $conexion->prepare($sql);
    return $stmt->execute($datos);
}

/**
 * Selecciona todos los registros de una tabla.
 * @param string $tabla
 * @return array
 */
function seleccionarTodo($tabla)
{
    $conexion = conectar();
    $sql = "SELECT * FROM $tabla";
    $stmt = $conexion->query($sql);
    return $stmt->fetchAll();
}

/**
 * Selecciona registros que coincidan con ciertos criterios.
 * @param string $tabla
 * @param array $criterio (ej: ['email' => 'user@example.com'])
 * @return array
 */
function seleccionarPorCriterio($tabla, $criterio)
{
    $conexion = conectar();
    $condiciones = [];
    $valores = [];

    foreach ($criterio as $columna => $valor) {
        $condiciones[] = "$columna = :$columna";
        $valores[$columna] = $valor;
    }

    $where = implode(" AND ", $condiciones);
    $sql = "SELECT * FROM $tabla WHERE $where";
    $stmt = $conexion->prepare($sql);
    $stmt->execute($valores);
    return $stmt->fetchAll();
}

/**
 * Modifica un registro por su ID.
 * @param string $tabla
 * @param int|string $id
 * @param array $datos
 * @return bool
 */
function modificarElemento($tabla, $id, $datos)
{
    $conexion = conectar();
    $updates = [];
    foreach ($datos as $columna => $valor) {
        $updates[] = "$columna = :$columna";
    }

    $set = implode(", ", $updates);
    $sql = "UPDATE $tabla SET $set WHERE id = :id";
    
    $stmt = $conexion->prepare($sql);
    $datos['id'] = $id; // Añadimos el ID al array de parámetros
    return $stmt->execute($datos);
}

/**
 * Elimina un registro por su ID.
 * @param string $tabla
 * @param int|string $id
 * @return bool
 */
function eliminarElemento($tabla, $id)
{
    $conexion = conectar();
    $sql = "DELETE FROM $tabla WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    return $stmt->execute(['id' => $id]);
}