<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - TechStore</title>
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
                        <input type="text" id="nombre-contacto" name="nombre" placeholder="Tu nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="email-contacto">Email *</label>
                        <input type="email" id="email-contacto" name="email" placeholder="tu@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="asunto">Asunto *</label>
                        <input type="text" id="asunto" name="asunto" placeholder="¿Sobre qué nos escribes?" required>
                    </div>

                    <div class="form-group">
                        <label for="mensaje">Mensaje *</label>
                        <textarea id="mensaje" name="mensaje" rows="6" placeholder="Cuéntanos en qué podemos ayudarte" required></textarea>
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
                    <p><a href="tel:+1234567890">+1 234 567 890</a></p>
                </div>

                <div class="info-item">
                    <h3>Email</h3>
                    <p><a href="mailto:info@techstore.com">info@techstore.com</a></p>
                </div>

                <div class="info-item">
                    <h3>Horario de Atención</h3>
                    <ul class="horario">
                        <li><span>Lunes a Viernes</span><span>9:00 – 18:00</span></li>
                        <li><span>Sábado</span><span>10:00 – 14:00</span></li>
                        <li><span>Domingo</span><span>Cerrado</span></li>
                    </ul>
                </div>

                <p class="info-nota">Respondemos dentro de las 24 horas hábiles.</p>
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
