<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $asunto = isset($_POST['asunto']) ? htmlspecialchars($_POST['asunto']) : '';
    $mensaje = isset($_POST['mensaje']) ? htmlspecialchars($_POST['mensaje']) : '';

    // Validar campos
    if (!empty($nombre) && !empty($email) && !empty($asunto) && !empty($mensaje)) {
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
