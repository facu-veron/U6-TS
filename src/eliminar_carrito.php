<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto_id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;

    if ($producto_id > 0 && isset($_SESSION['carrito'][$producto_id])) {
        unset($_SESSION['carrito'][$producto_id]);
        $_SESSION['mensaje'] = 'Producto eliminado del carrito';
    }
}

header('Location: carrito.php');
exit();
?>
