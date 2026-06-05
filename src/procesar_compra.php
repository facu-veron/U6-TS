<?php
session_start();

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
$nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
$telefono = isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : '';
$direccion = isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : '';
$ciudad = isset($_POST['ciudad']) ? htmlspecialchars($_POST['ciudad']) : '';
$codigo_postal = isset($_POST['codigo_postal']) ? htmlspecialchars($_POST['codigo_postal']) : '';
$metodo_pago = isset($_POST['metodo_pago']) ? htmlspecialchars($_POST['metodo_pago']) : '';

// Validar campos requeridos
if (empty($nombre) || empty($email) || empty($telefono) || empty($direccion) || empty($ciudad) || empty($codigo_postal)) {
    $_SESSION['error'] = 'Por favor complete todos los campos requeridos';
    header('Location: checkout.php');
    exit();
}

// Calcular total
$total = 0;
foreach ($_SESSION['carrito'] as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

// Generar número de pedido
$numero_pedido = 'PED-' . date('Ymd') . '-' . rand(1000, 9999);

// Guardar información del pedido en sesión
$_SESSION['pedido'] = array(
    'numero_pedido' => $numero_pedido,
    'fecha' => date('Y-m-d H:i:s'),
    'nombre' => $nombre,
    'email' => $email,
    'telefono' => $telefono,
    'direccion' => $direccion,
    'ciudad' => $ciudad,
    'codigo_postal' => $codigo_postal,
    'metodo_pago' => $metodo_pago,
    'items' => $_SESSION['carrito'],
    'total' => $total
);

// Limpiar carrito
$_SESSION['carrito'] = array();

// Redirigir a página de confirmación
header('Location: confirmacion.php');
exit();
?>
