<?php
session_start();

require_once 'lib/funciones.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto_id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;

    if ($producto_id > 0 && isset($_SESSION['carrito'][$producto_id])) {
        $_SESSION['carrito'] = carrito_eliminar($_SESSION['carrito'], $producto_id);
        $_SESSION['mensaje'] = 'Producto eliminado del carrito';
    }
}

header('Location: carrito.php');
exit();
?>
