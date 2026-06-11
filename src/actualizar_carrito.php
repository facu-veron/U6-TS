<?php
session_start();

require_once 'lib/funciones.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto_id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
    $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;

    if ($producto_id > 0 && $cantidad > 0 && isset($_SESSION['carrito'][$producto_id])) {
        $_SESSION['carrito'] = carrito_actualizar_cantidad($_SESSION['carrito'], $producto_id, $cantidad);
        $_SESSION['mensaje'] = 'Cantidad actualizada correctamente';
    }
}

header('Location: carrito.php');
exit();
?>
