<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";

/**
 * Summary of insertarElemento
 * @param mixed $tabla
 * @param mixed $datos
 * @return bool|mysqli_result
 * funcion para insertarElementos en la tabla que quieras
 */
function insertarElemento($tabla, $datos)
{
    $conexion = conectar();
    $columnas = implode(", ", array_keys($datos));
    $valores = implode(", ", array_map(function ($item) use ($conexion) {
        return "'" . $conexion->real_escape_string($item) . "'";
    }, array_values($datos)));

    $sql = "INSERT INTO $tabla ($columnas) VALUES ($valores)";
    return $conexion->query($sql);
}

/**
 * Summary of seleccionarTodo
 * @param mixed $tabla
 * @return array
 * funcion para leer el contenido de un tabla
 */
function seleccionarTodo($tabla)
{
    $conexion = conectar();
    $sql = "SELECT * FROM $tabla";
    $resultado = $conexion->query($sql);

    $datos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }

    return $datos;
}

/**
 * Summary of seleccionarPorCriterio
 * @param mixed $tabla
 * @param mixed $criterio
 * @return array
 * funcion para leer de la tabla que quieras el valor que quieras
 */
function seleccionarPorCriterio($tabla, $criterio)
{
    $conexion = conectar();
    $condiciones = [];
    foreach ($criterio as $columna => $valor) {
        $condiciones[] = "$columna = '" . $conexion->real_escape_string($valor) . "'";
    }

    $where = implode(" AND ", $condiciones);
    $sql = "SELECT * FROM $tabla WHERE $where";
    $resultado = $conexion->query($sql);

    $datos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }

    return $datos;
}

/**
 * Summary of modificarElemento
 * @param mixed $tabla
 * @param mixed $id
 * @param mixed $datos
 * @return bool|mysqli_result
 * funcion para modificar los elementos de una tabla especifica son su id y datos especigicos
 */
function modificarElemento($tabla, $id, $datos)
{
    $conexion = conectar();
    $updates = [];
    foreach ($datos as $columna => $valor) {
        $updates[] = "$columna = '" . $conexion->real_escape_string($valor) . "'";
    }

    $set = implode(", ", $updates);
    $sql = "UPDATE $tabla SET $set WHERE id = '" . $conexion->real_escape_string($id) . "'";
    return $conexion->query($sql);
}


/**
 * Summary of eliminarElemento
 * @param mixed $tabla
 * @param mixed $id
 * @return bool|mysqli_result
 * funcion para eliminar un elemento de una tabla con un id concretos
 */
function eliminarElemento($tabla, $id)
{
    $conexion = conectar();
    $sql = "DELETE FROM $tabla WHERE id = '" . $conexion->real_escape_string($id) . "'";
    return $conexion->query($sql);
}


?>