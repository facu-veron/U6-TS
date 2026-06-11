<?php
session_start();

require_once 'lib/funciones.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $datos = array();
    foreach (array('nombre', 'email', 'asunto', 'mensaje') as $campo) {
        $datos[$campo] = isset($_POST[$campo]) ? sanitizar_texto($_POST[$campo]) : '';
    }

    // Validar campos
    if (validar_campos_requeridos($datos, array('nombre', 'email', 'asunto', 'mensaje'))) {
        // Aquí normalmente enviarías un email o guardarías en base de datos
        // Para este ejemplo, solo guardamos un mensaje de éxito
        
        $_SESSION['contacto_mensaje'] = '¡Gracias por contactarnos! Tu mensaje ha sido enviado exitosamente. Te responderemos pronto.';
    } else {
        $_SESSION['contacto_mensaje'] = 'Por favor completa todos los campos del formulario.';
    }
}

header('Location: contacto.php');
exit();
?>
