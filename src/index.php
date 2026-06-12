<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

require_once 'config/db.php';

$stmt = $pdo->query('SELECT * FROM productos WHERE activo = 1 AND destacado = 1 ORDER BY id ASC');
$productos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore - Tienda de Tecnología</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=IBM+Plex+Sans:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
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
        <section class="hero">
            <p class="hero-eyebrow">TechStore · Catálogo <?php echo date('Y'); ?></p>
            <h2>Bienvenido a TechStore</h2>
            <p>Los mejores productos tecnológicos al mejor precio</p>
            <a href="productos.php" class="btn-hero">Ver productos</a>
        </section>

        <section class="productos">
            <h2>Listado de Productos Destacados</h2>
            <div class="productos-grid">
                <?php foreach ($productos as $producto): ?>
                <div class="producto-card" data-producto-id="<?php echo $producto['id']; ?>">
                    <p class="producto-ref"><span>REF-<?php echo str_pad($producto['id'], 3, '0', STR_PAD_LEFT); ?></span><span class="en-stock">En stock</span></p>
                    <div class="producto-imagen">
                        <img src="images/placeholder.svg" alt="<?php echo $producto['nombre']; ?>">
                    </div>
                    <h3 class="producto-nombre"><?php echo $producto['nombre']; ?></h3>
                    <p class="producto-precio">$<?php echo number_format($producto['precio'], 2); ?></p>
                    <form action="agregar_carrito.php" method="POST">
                        <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                        <input type="number" name="cantidad" value="1" min="1" class="cantidad-input">
                        <button type="submit" class="btn-agregar">Agregar al Carrito</button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 TechStore. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
