<?php
session_start();

$_SESSION['carrito'] = array();
$_SESSION['mensaje'] = 'Carrito vaciado correctamente';

header('Location: carrito.php');
exit();
?>
