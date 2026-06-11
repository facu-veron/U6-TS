<?php
session_start();

require_once 'lib/funciones.php';

// Verificar que hay productos en el carrito
if (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) == 0) {
    header('Location: carrito.php');
    exit();
}

// Calcular total
$total = carrito_total($_SESSION['carrito']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - TechStore</title>
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
                    <li><a href="carrito.php" id="nav-carrito">Carrito (<?php echo count($_SESSION['carrito']); ?>)</a></li>
                    <li><a href="contacto.php" id="nav-contacto">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <h1>Finalizar Compra</h1>

        <div class="checkout-contenedor">
            <div class="checkout-formulario">
                <h2>Información de Envío</h2>
                <form action="procesar_compra.php" method="POST" id="form-checkout">
                    <div class="form-group">
                        <label for="nombre">Nombre Completo *</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono *</label>
                        <input type="tel" id="telefono" name="telefono" required>
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección *</label>
                        <input type="text" id="direccion" name="direccion" required>
                    </div>

                    <div class="form-group">
                        <label for="ciudad">Ciudad *</label>
                        <input type="text" id="ciudad" name="ciudad" required>
                    </div>

                    <div class="form-group">
                        <label for="codigo_postal">Código Postal *</label>
                        <input type="text" id="codigo_postal" name="codigo_postal" required>
                    </div>

                    <h2>Método de Pago</h2>
                    
                    <div class="form-group">
                        <label>
                            <input type="radio" name="metodo_pago" value="tarjeta" id="pago-tarjeta" checked> 
                            Tarjeta de Crédito/Débito
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="radio" name="metodo_pago" value="paypal" id="pago-paypal"> 
                            PayPal
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="radio" name="metodo_pago" value="transferencia" id="pago-transferencia"> 
                            Transferencia Bancaria
                        </label>
                    </div>

                    <div id="datos-tarjeta">
                        <div class="form-group">
                            <label for="numero_tarjeta">Número de Tarjeta</label>
                            <input type="text" id="numero_tarjeta" name="numero_tarjeta" placeholder="1234 5678 9012 3456">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="fecha_expiracion">Fecha de Expiración</label>
                                <input type="text" id="fecha_expiracion" name="fecha_expiracion"  placeholder="MM/AA" required>
                            </div>

                            <div class="form-group">
                                <label for="cvv">CVV</label>
                                <input type="text" id="cvv" name="cvv" placeholder="123">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="terminos" name="terminos" required>
                            Acepto los términos y condiciones
                        </label>
                    </div>

                    <button type="submit" class="btn-finalizar" id="btn-finalizar">Finalizar Compra</button>
                </form>
            </div>

            <div class="checkout-resumen">
                <h2>Resumen del Pedido</h2>
                <div class="resumen-items">
                    <?php foreach ($_SESSION['carrito'] as $item): ?>
                    <div class="resumen-item">
                        <span><?php echo $item['nombre']; ?> x <?php echo $item['cantidad']; ?></span>
                        <span>$<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="resumen-total">
                    <strong>Total:</strong>
                    <strong id="checkout-total">$<?php echo number_format($total, 2); ?></strong>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 TechStore. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
