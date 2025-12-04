<?php
session_start();

// Verificar si se recibió el índice del ítem a eliminar
if (isset($_POST['item_key']) && isset($_SESSION['carrito'][$_POST['item_key']])) {
    // Eliminar el ítem del carrito
    unset($_SESSION['carrito'][$_POST['item_key']]);
    // Reindexar el array para evitar problemas con los índices
    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
}

// Redirigir de vuelta al carrito
header('Location: carrito.php');
exit();
