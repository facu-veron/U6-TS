<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - TechStore</title>
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
                    <li><a href="carrito.php" id="nav-carrito">Carrito (<?php echo isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; ?>)</a></li>
                    <li><a href="contacto.php" id="nav-contacto">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <h1>Contáctanos</h1>

        <?php if (isset($_SESSION['contacto_mensaje'])): ?>
        <div class="mensaje-exito" id="mensaje-contacto">
            <?php 
            echo $_SESSION['contacto_mensaje']; 
            unset($_SESSION['contacto_mensaje']);
            ?>
        </div>
        <?php endif; ?>

        <div class="contacto-contenedor">
            <div class="contacto-formulario">
                <h2>Envíanos un Mensaje</h2>
                <form action="procesar_contacto.php" method="POST" id="form-contacto">
                    <div class="form-group">
                        <label for="nombre-contacto">Nombre *</label>
                        <input type="text" id="nombre-contacto" name="nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="email-contacto">Email *</label>
                        <input type="email" id="email-contacto" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="asunto">Asunto *</label>
                        <input type="text" id="asunto" name="asunto" required>
                    </div>

                    <div class="form-group">
                        <label for="mensaje">Mensaje *</label>
                        <textarea id="mensaje" name="mensaje" rows="6" required></textarea>
                    </div>

                    <button type="submit" class="btn-enviar" id="btn-enviar-contacto">Enviar Mensaje</button>
                </form>
            </div>

            <div class="contacto-info">
                <h2>Información de Contacto</h2>
                <div class="info-item">
                    <h3>Dirección</h3>
                    <p>Calle Principal 123<br>Ciudad, País 12345</p>
                </div>

                <div class="info-item">
                    <h3>Teléfono</h3>
                    <p>+1 234 567 890</p>
                </div>

                <div class="info-item">
                    <h3>Email</h3>
                    <p>info@techstore.com</p>
                </div>

                <div class="info-item">
                    <h3>Horario de Atención</h3>
                    <p>Lunes a Viernes: 9:00 - 18:00<br>Sábado: 10:00 - 14:00<br>Domingo: Cerrado</p>
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
