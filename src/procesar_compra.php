<?php
session_start();

require_once 'lib/funciones.php';

// Verificar que el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: checkout.php');
    exit();
}

// Verificar que hay productos en el carrito
if (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) == 0) {
    header('Location: carrito.php');
    exit();
}

// Obtener datos del formulario
$datos_envio = array();
foreach (array('nombre', 'email', 'telefono', 'direccion', 'ciudad', 'codigo_postal', 'metodo_pago') as $campo) {
    $datos_envio[$campo] = isset($_POST[$campo]) ? sanitizar_texto($_POST[$campo]) : '';
}

// Validar campos requeridos
if (!validar_campos_requeridos($datos_envio, array('nombre', 'email', 'telefono', 'direccion', 'ciudad', 'codigo_postal'))) {
    $_SESSION['error'] = 'Por favor complete todos los campos requeridos';
    header('Location: checkout.php');
    exit();
}

// Guardar información del pedido en sesión
$_SESSION['pedido'] = crear_pedido($datos_envio, $_SESSION['carrito'], generar_numero_pedido(), date('Y-m-d H:i:s'));

// Limpiar carrito
$_SESSION['carrito'] = array();

// Redirigir a página de confirmación
header('Location: confirmacion.php');
exit();
?>
