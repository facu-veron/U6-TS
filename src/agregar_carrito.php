<?php
session_start();

require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto_id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
    $cantidad    = isset($_POST['cantidad'])    ? intval($_POST['cantidad'])    : 1;

    if ($producto_id > 0 && $cantidad > 0) {
        $stmt = $pdo->prepare('SELECT id, nombre, precio, stock FROM productos WHERE id = ? AND activo = 1');
        $stmt->execute([$producto_id]);
        $producto = $stmt->fetch();

        if ($producto) {
            if (isset($_SESSION['carrito'][$producto_id])) {
                $_SESSION['carrito'][$producto_id]['cantidad'] += $cantidad;
            } else {
                $_SESSION['carrito'][$producto_id] = array(
                    'id'       => $producto['id'],
                    'nombre'   => $producto['nombre'],
                    'precio'   => $producto['precio'],
                    'cantidad' => $cantidad
                );
            }

            $_SESSION['mensaje'] = 'Producto agregado al carrito exitosamente';
            header('Location: carrito.php');
            exit();
        }
    }
}

header('Location: index.php');
exit();
?>
