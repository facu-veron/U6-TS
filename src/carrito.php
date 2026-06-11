<?php
session_start();

require_once 'lib/funciones.php';

// Calcular total
$total = carrito_total(isset($_SESSION['carrito']) ? $_SESSION['carrito'] : array());
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - TechStore</title>
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
        <h1>Mi Carrito de Compras</h1>

        <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="mensaje-exito" id="mensaje-exito">
            <?php 
            echo $_SESSION['mensaje']; 
            unset($_SESSION['mensaje']);
            ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0): ?>
        <div class="carrito-contenido">
            <table class="tabla-carrito" id="tabla-carrito">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['carrito'] as $id => $item): ?>
                    <tr data-producto-id="<?php echo $id; ?>">
                        <td class="nombre-producto"><?php echo $item['nombre']; ?></td>
                        <td class="precio-producto">$<?php echo number_format($item['precio'], 2); ?></td>
                        <td>
                            <form action="actualizar_carrito.php" method="POST" class="form-cantidad">
                                <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
                                <input type="number" name="cantidad" value="<?php echo $item['cantidad']; ?>" min="1" class="cantidad-input">
                                <button type="submit" class="btn-actualizar">Actualizar</button>
                            </form>
                        </td>
                        <td class="subtotal">$<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></td>
                        <td>
                            <form action="eliminar_carrito.php" method="POST">
                                <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
                                <button type="submit" class="btn-eliminar">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="carrito-resumen">
                <h2>Resumen del Pedido</h2>
                <p class="total-items">Total de items: <span id="total-items"><?php echo carrito_contar_items($_SESSION['carrito']); ?></span></p>
                <p class="total-precio">Total: <span id="total-precio">$<?php echo number_format($total, 2); ?></span></p>
                <a href="checkout.php" class="btn-checkout" id="btn-checkout">Proceder al Pago</a>
                <a href="productos.php" class="btn-continuar">Continuar Comprando</a>
                <form action="vaciar_carrito.php" method="POST" style="margin-top: 10px;">
                    <button type="submit" class="btn-vaciar" id="btn-vaciar">Vaciar Carrito</button>
                </form>
            </div>
        </div>
        <?php else: ?>
        <div class="carrito-vacio" id="carrito-vacio">
            <p>Tu carrito está vacío</p>
            <a href="productos.php" class="btn-continuar">Ver Productos</a>
        </div>
        <?php endif; ?>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 TechStore. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
