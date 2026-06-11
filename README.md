# TechStore - Tienda Online de Tecnología

Proyecto de tienda en línea creado con PHP y HTML para testing con Katalon Studio.

## Estructura del Proyecto

```
tienda/
├── index.php                 # Página principal
├── productos.php            # Catálogo de productos
├── carrito.php              # Carrito de compras
├── checkout.php             # Página de checkout
├── confirmacion.php         # Confirmación de pedido
├── contacto.php             # Formulario de contacto
├── agregar_carrito.php      # Script para agregar productos
├── actualizar_carrito.php   # Script para actualizar cantidades
├── eliminar_carrito.php     # Script para eliminar productos
├── vaciar_carrito.php       # Script para vaciar carrito
├── procesar_compra.php      # Script para procesar compra
├── procesar_contacto.php    # Script para procesar contacto
├── lib/
│   └── funciones.php        # Lógica de negocio (testeada con PHPUnit)
├── css/
│   └── estilos.css          # Estilos CSS
└── images/
    └── placeholder.png      # Imagen placeholder
```

## Instalación

### Requisitos
- PHP 7.0 o superior
- Servidor web (Apache, Nginx, o PHP built-in server)

### Configuración Rápida

1. Copiar los archivos al directorio del servidor web
2. Asegurarse de que PHP esté instalado
3. Iniciar el servidor

#### Opción 1: Usando el servidor integrado de PHP
```bash
cd tienda
php -S localhost:8000
```

#### Opción 2: Usando XAMPP/WAMP
- Copiar la carpeta `tienda` a `htdocs/` (XAMPP) o `www/` (WAMP)
- Acceder a: http://localhost/tienda/

## Testing

El proyecto tiene dos niveles de pruebas automatizadas, que también corren en GitHub Actions en cada push/PR:

### Tests unitarios (PHPUnit)

Prueban la lógica de negocio (`src/lib/funciones.php`): carrito, totales, validaciones y armado de pedidos.

```bash
composer install   # solo la primera vez
composer test
```

Documentación completa: [docs/testing-phpunit.md](docs/testing-phpunit.md)

### Tests end-to-end (Playwright)

Prueban la aplicación completa desde el navegador (Chromium, Firefox y WebKit).

```bash
pnpm install       # solo la primera vez
pnpm test:e2e
```

Documentación completa: [docs/testing-playwright.md](docs/testing-playwright.md)

## Funcionalidades

### Para Usuario
- ✅ Ver catálogo de productos
- ✅ Agregar productos al carrito
- ✅ Modificar cantidades en el carrito
- ✅ Eliminar productos del carrito
- ✅ Vaciar carrito completo
- ✅ Proceso de checkout completo
- ✅ Formulario de contacto
- ✅ Confirmación de pedido

### Elementos Testeables con Katalon

#### IDs y Selectores Principales

**Navegación:**
- `#logo` - Logo de la tienda
- `#nav-inicio` - Enlace a inicio
- `#nav-productos` - Enlace a productos
- `#nav-carrito` - Enlace al carrito
- `#nav-contacto` - Enlace a contacto

**Productos:**
- `.producto-card` - Tarjeta de producto
- `.producto-nombre` - Nombre del producto
- `.producto-precio` - Precio del producto
- `.cantidad-input` - Input de cantidad
- `.btn-agregar` - Botón agregar al carrito

**Carrito:**
- `#tabla-carrito` - Tabla del carrito
- `#total-items` - Total de items
- `#total-precio` - Precio total
- `#btn-checkout` - Botón proceder al pago
- `#btn-vaciar` - Botón vaciar carrito
- `.btn-eliminar` - Botón eliminar producto
- `.btn-actualizar` - Botón actualizar cantidad

**Checkout:**
- `#form-checkout` - Formulario de checkout
- `#nombre` - Campo nombre
- `#email` - Campo email
- `#telefono` - Campo teléfono
- `#direccion` - Campo dirección
- `#ciudad` - Campo ciudad
- `#codigo_postal` - Campo código postal
- `#pago-tarjeta` - Radio button tarjeta
- `#pago-paypal` - Radio button PayPal
- `#pago-transferencia` - Radio button transferencia
- `#terminos` - Checkbox términos
- `#btn-finalizar` - Botón finalizar compra
- `#checkout-total` - Total del checkout

**Confirmación:**
- `#titulo-confirmacion` - Título confirmación
- `#numero-pedido` - Número de pedido
- `#total-confirmacion` - Total confirmación
- `#btn-volver-inicio` - Botón volver al inicio

**Contacto:**
- `#form-contacto` - Formulario de contacto
- `#nombre-contacto` - Campo nombre
- `#email-contacto` - Campo email
- `#asunto` - Campo asunto
- `#mensaje` - Campo mensaje
- `#btn-enviar-contacto` - Botón enviar

## Casos de Prueba Sugeridos para Katalon

### 1. Test de Navegación
- Verificar que todos los enlaces del menú funcionan
- Verificar que el contador del carrito se actualiza

### 2. Test de Agregar Productos
- Agregar un producto al carrito
- Verificar que el producto aparece en el carrito
- Verificar que el contador se incrementa

### 3. Test de Carrito
- Modificar cantidad de un producto
- Eliminar un producto
- Vaciar el carrito completo
- Verificar cálculo del total

### 4. Test de Checkout
- Completar formulario con datos válidos
- Verificar campos requeridos
- Verificar selección de método de pago
- Verificar checkbox de términos

### 5. Test de Flujo Completo
- Agregar múltiples productos
- Ir al carrito
- Modificar cantidades
- Proceder al checkout
- Completar compra
- Verificar página de confirmación

### 6. Test de Formulario de Contacto
- Enviar mensaje con datos válidos
- Verificar campos requeridos
- Verificar mensaje de confirmación

### 7. Test de Validaciones
- Intentar checkout con carrito vacío
- Intentar agregar cantidad negativa
- Verificar validación de email

## Datos de Prueba

### Productos Disponibles
1. Laptop HP - $899.99
2. Mouse Logitech - $29.99
3. Teclado Mecánico - $79.99
4. Monitor 24" - $199.99
5. Auriculares Gaming - $59.99
6. Webcam HD - $49.99
7. SSD 500GB - $89.99
8. Router WiFi 6 - $129.99

### Datos de Prueba para Checkout
```
Nombre: Juan Pérez
Email: juan.perez@example.com
Teléfono: +1 234 567 890
Dirección: Calle Principal 123
Ciudad: Ciudad de Ejemplo
Código Postal: 12345
```

## Notas Técnicas

- Las sesiones PHP se utilizan para mantener el carrito
- No requiere base de datos (todo en memoria de sesión)
- Los productos son datos estáticos en arrays PHP
- Ideal para testing automatizado sin dependencias externas

## Soporte

Este proyecto es solo para fines de testing y demostración.
No incluye funcionalidades de pago real ni base de datos.
