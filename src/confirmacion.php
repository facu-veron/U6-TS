<?php
session_start();

// Verificar que existe un pedido
if (!isset($_SESSION['pedido'])) {
    header('Location: index.php');
    exit();
}

$pedido = $_SESSION['pedido'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido - TechStore</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header>
        <div class="container">
            <h1 id="logo">TechStore</h1>
            <nav>
                <ul>
                    <li><a href="index.php" id="nav-inicio">Inicio</a></li>
                    <li><a href="productos.php" id="nav-productos">Productos</a></li>
                    <li><a href="carrito.php" id="nav-carrito">Carrito (0)</a></li>
                    <li><a href="contacto.php" id="nav-contacto">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="confirmacion-contenedor">
            <div class="confirmacion-icono">✓</div>
            <h1 id="titulo-confirmacion">¡Pedido Realizado con Éxito!</h1>
            <p class="confirmacion-mensaje">Gracias por tu compra. Tu pedido ha sido procesado correctamente.</p>

            <div class="confirmacion-detalles">
                <h2>Detalles del Pedido</h2>
                <p><strong>Número de Pedido:</strong> <span id="numero-pedido"><?php echo $pedido['numero_pedido']; ?></span></p>
                <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido['fecha'])); ?></p>
                <p><strong>Email:</strong> <?php echo $pedido['email']; ?></p>
                
                <h3>Dirección de Envío</h3>
                <p><?php echo $pedido['nombre']; ?></p>
                <p><?php echo $pedido['direccion']; ?></p>
                <p><?php echo $pedido['ciudad']; ?>, <?php echo $pedido['codigo_postal']; ?></p>
                <p>Tel: <?php echo $pedido['telefono']; ?></p>

                <h3>Productos</h3>
                <table class="tabla-confirmacion">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedido['items'] as $item): ?>
                        <tr>
                            <td><?php echo $item['nombre']; ?></td>
                            <td><?php echo $item['cantidad']; ?></td>
                            <td>$<?php echo number_format($item['precio'], 2); ?></td>
                            <td>$<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><strong>Total:</strong></td>
                            <td><strong id="total-confirmacion">$<?php echo number_format($pedido['total'], 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>

                <p class="metodo-pago"><strong>Método de Pago:</strong> <?php echo ucfirst($pedido['metodo_pago']); ?></p>
            </div>

            <div class="confirmacion-acciones">
                <a href="index.php" class="btn-continuar" id="btn-volver-inicio">Volver al Inicio</a>
                <a href="productos.php" class="btn-continuar">Seguir Comprando</a>
            </div>

            <p class="confirmacion-nota">Recibirás un email de confirmación en <?php echo $pedido['email']; ?></p>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 TechStore. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
