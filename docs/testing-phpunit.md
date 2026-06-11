# Pruebas Unitarias con PHPUnit

## ¿Qué es PHPUnit?

PHPUnit es el framework estándar para escribir pruebas unitarias en PHP.

A diferencia de las pruebas E2E con Playwright (que prueban la aplicación completa desde el navegador), una prueba unitaria verifica **una función aislada**, sin servidor web, sin navegador, sin base de datos y sin sesiones.

Esto las hace:

* Muy rápidas (milisegundos).
* Precisas: si fallan, señalan exactamente qué función se rompió.
* Independientes del entorno: no necesitan levantar la tienda.

---

## ¿Qué se hizo en este proyecto?

### El problema

El código original era **procedural**: la lógica de negocio estaba mezclada con `$_SESSION`, `header('Location: ...')` y HTML directamente en cada página. Por ejemplo, en `agregar_carrito.php`:

```php
if (isset($_SESSION['carrito'][$producto_id])) {
    $_SESSION['carrito'][$producto_id]['cantidad'] += $cantidad;
} else {
    $_SESSION['carrito'][$producto_id] = array(...);
}
```

Ese código **no se puede probar de forma unitaria**, porque ejecutar el archivo dispara `session_start()`, redirecciones y consultas a la base de datos.

### La solución: extraer la lógica a funciones puras

Se creó el archivo `src/lib/funciones.php` con funciones **puras**: reciben datos por parámetro y devuelven un resultado, sin tocar `$_SESSION` ni hacer redirecciones.

| Función | Qué hace |
|---|---|
| `carrito_agregar($carrito, $producto, $cantidad)` | Agrega un producto al carrito. Si ya existe, suma las cantidades. |
| `carrito_actualizar_cantidad($carrito, $id, $cantidad)` | Cambia la cantidad de un producto existente (ignora cantidades inválidas o productos inexistentes). |
| `carrito_eliminar($carrito, $id)` | Quita un producto del carrito. |
| `carrito_total($carrito)` | Suma `precio × cantidad` de todos los items. |
| `carrito_contar_items($carrito)` | Cuenta el total de unidades en el carrito. |
| `sanitizar_texto($valor)` | Escapa HTML (`htmlspecialchars`) para prevenir XSS. |
| `validar_campos_requeridos($datos, $campos)` | Verifica que todos los campos requeridos estén completos. |
| `generar_numero_pedido()` | Genera un número con formato `PED-YYYYMMDD-NNNN`. |
| `crear_pedido($datos_envio, $carrito, $numero, $fecha)` | Arma el array del pedido con items y total calculado. |

### Archivos refactorizados

Las páginas ahora **usan estas funciones** en lugar de duplicar la lógica. El comportamiento de la aplicación es exactamente el mismo (las pruebas E2E lo siguen verificando):

* `src/agregar_carrito.php` → usa `carrito_agregar()`
* `src/actualizar_carrito.php` → usa `carrito_actualizar_cantidad()`
* `src/eliminar_carrito.php` → usa `carrito_eliminar()`
* `src/carrito.php` → usa `carrito_total()` y `carrito_contar_items()`
* `src/checkout.php` → usa `carrito_total()`
* `src/procesar_compra.php` → usa `sanitizar_texto()`, `validar_campos_requeridos()`, `generar_numero_pedido()` y `crear_pedido()`
* `src/procesar_contacto.php` → usa `sanitizar_texto()` y `validar_campos_requeridos()`

---

## Estructura agregada

```txt
composer.json              # Dependencias PHP (PHPUnit)
composer.lock              # Versiones exactas instaladas
phpunit.xml                # Configuración de PHPUnit
src/
  lib/
    funciones.php          # Lógica de negocio extraída (lo que se testea)
tests/
  Unit/
    CarritoTest.php        # 12 tests del carrito
    PedidoTest.php         # 3 tests del pedido
    ValidacionTest.php     # 7 tests de sanitización y validación
vendor/                    # Dependencias instaladas (ignorado por git)
```

Los tests unitarios viven en `tests/Unit/` y **no interfieren con Playwright**: Playwright solo ejecuta archivos `*.spec.ts`, y PHPUnit solo ejecuta los `*Test.php` de `tests/Unit/`.

---

## Archivo `composer.json`

```json
{
    "require": {
        "php": ">=8.0"
    },
    "require-dev": {
        "phpunit/phpunit": "^9.6"
    },
    "scripts": {
        "test": "phpunit"
    }
}
```

### Explicación

* `require-dev`: PHPUnit es una dependencia **de desarrollo**, no se necesita en producción.
* `^9.6`: se usa PHPUnit 9.6 porque es compatible con PHP 8.0 (PHPUnit 10+ requiere PHP 8.1).
* `scripts.test`: permite ejecutar las pruebas con `composer test`.

---

## Archivo `phpunit.xml`

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="https://schema.phpunit.de/9.6/phpunit.xsd"
         bootstrap="src/lib/funciones.php"
         colors="true"
         failOnWarning="true">
    <testsuites>
        <testsuite name="Unit">
            <directory>tests/Unit</directory>
        </testsuite>
    </testsuites>
    <coverage>
        <include>
            <directory suffix=".php">src/lib</directory>
        </include>
    </coverage>
</phpunit>
```

### Explicación

* `bootstrap`: archivo que se carga antes de los tests. Acá se cargan las funciones a probar.
* `testsuites`: indica que las pruebas están en `tests/Unit/`.
* `colors`: muestra la salida con colores en la terminal.
* `coverage`: define qué código se mide cuando se genera un reporte de cobertura (`src/lib`).

---

## Pruebas escritas (22 tests, 38 aserciones)

### `tests/Unit/CarritoTest.php`

* Agregar un producto nuevo a un carrito vacío.
* Agregar un producto que ya existe suma las cantidades.
* Agregar dos productos distintos.
* Actualizar la cantidad de un producto existente.
* Actualizar un producto inexistente no modifica el carrito.
* Actualizar con cantidad inválida (0) no modifica el carrito.
* Eliminar un producto del carrito.
* Eliminar un producto inexistente no falla.
* El total de un carrito vacío es cero.
* El total suma `precio × cantidad` de cada item.
* Contar items de un carrito vacío da cero.
* Contar items suma las cantidades de todos los productos.

### `tests/Unit/PedidoTest.php`

* El número de pedido tiene el formato `PED-YYYYMMDD-NNNN`.
* `crear_pedido()` incluye los datos de envío, los items y el total calculado.
* Un pedido con carrito vacío tiene total cero.

### `tests/Unit/ValidacionTest.php`

* `sanitizar_texto()` escapa HTML (previene XSS con `<script>`).
* `sanitizar_texto()` escapa comillas.
* `sanitizar_texto()` no modifica texto plano.
* La validación pasa cuando todos los campos están completos.
* La validación falla con un campo vacío.
* La validación falla con un campo ausente.
* La validación ignora campos extra no requeridos.

---

## Anatomía de un test

```php
use PHPUnit\Framework\TestCase;

class CarritoTest extends TestCase
{
    public function testAgregarProductoNuevoAlCarritoVacio(): void
    {
        $carrito = carrito_agregar(array(), $this->notebook, 2);

        $this->assertCount(1, $carrito);
        $this->assertSame(2, $carrito[1]['cantidad']);
    }
}
```

### Explicación

* La clase extiende `TestCase`, la clase base de PHPUnit.
* Cada método que empieza con `test` es una prueba independiente.
* `assertCount(1, $carrito)` verifica que el carrito tenga exactamente 1 producto.
* `assertSame(2, ...)` verifica valor **y tipo** (es más estricto que `assertEquals`).

Aserciones usadas en el proyecto:

| Aserción | Verifica |
|---|---|
| `assertSame($esperado, $real)` | Igualdad estricta (`===`), valor y tipo. |
| `assertCount($n, $array)` | Cantidad de elementos. |
| `assertTrue()` / `assertFalse()` | Valores booleanos. |
| `assertArrayHasKey()` / `assertArrayNotHasKey()` | Existencia de una clave. |
| `assertMatchesRegularExpression()` | Que un texto cumpla un patrón. |
| `assertStringContainsString()` | Que un texto contenga otro. |

---

## Pasos para ejecutar los tests

### Requisitos

* **PHP 8.0 o superior** — verificar con `php --version`
* **Composer** — verificar con `composer --version` ([instalación](https://getcomposer.org/download/))

### 1. Instalar las dependencias (solo la primera vez)

```bash
composer install
```

Esto descarga PHPUnit dentro de la carpeta `vendor/` (ignorada por git).

### 2. Ejecutar todas las pruebas

```bash
composer test
```

También funciona cualquiera de estas alternativas equivalentes:

```bash
pnpm test:unit
```

```bash
./vendor/bin/phpunit
```

Salida esperada:

```txt
PHPUnit 9.6.34 by Sebastian Bergmann and contributors.

......................                                            22 / 22 (100%)

Time: 00:00.029, Memory: 6.00 MB

OK (22 tests, 38 assertions)
```

### Ejecutar un archivo de tests específico

```bash
./vendor/bin/phpunit tests/Unit/CarritoTest.php
```

### Ejecutar un solo test por nombre

```bash
./vendor/bin/phpunit --filter testTotalSumaPrecioPorCantidadDeCadaItem
```

### Ver el detalle de cada test ejecutado

```bash
./vendor/bin/phpunit --testdox
```

Muestra los nombres de los tests en formato legible:

```txt
Carrito
 ✔ Agregar producto nuevo al carrito vacio
 ✔ Agregar producto existente suma cantidades
 ...
```

### Generar reporte de cobertura (opcional)

Requiere tener Xdebug o PCOV instalado:

```bash
./vendor/bin/phpunit --coverage-text
```

---

## Integración continua (GitHub Actions)

Se agregó el job `unit` al workflow `.github/workflows/playwright.yml`, que corre **en paralelo** con las pruebas E2E en cada `push` y `pull_request` a `main`/`master`:

```yml
unit:
  name: Run Unit Tests
  runs-on: ubuntu-latest
  timeout-minutes: 10

  steps:
    - name: Checkout repository
      uses: actions/checkout@v4

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        coverage: none

    - name: Install Composer dependencies
      run: composer install --no-interaction --prefer-dist

    - name: Run PHPUnit tests
      run: composer test
```

### Explicación

* `shivammathur/setup-php`: instala PHP 8.2 en el runner (la misma versión que usa el `Dockerfile` del proyecto).
* `coverage: none`: desactiva Xdebug para que los tests corran más rápido.
* `composer install`: instala PHPUnit usando las versiones exactas de `composer.lock`.
* `composer test`: ejecuta la suite completa.

---

## Pirámide de testing del proyecto

```txt
        /  E2E  \        Playwright — flujo completo en el navegador (lento, integral)
       /---------\
      /  Unitarios \     PHPUnit — lógica de negocio aislada (rápido, preciso)
     /--------------\
```

* **Unitarios (PHPUnit)**: validan la lógica de carrito, pedido y validaciones en milisegundos. Se corren constantemente mientras se desarrolla.
* **E2E (Playwright)**: validan que toda la aplicación (PHP + sesiones + HTML + navegador) funcione integrada. Ver [testing-playwright.md](testing-playwright.md).

---

## Flujo recomendado

Antes de subir cambios al repositorio:

```bash
composer test      # rápido: corre primero
pnpm test:e2e      # lento: corre después
```

Si un test unitario falla, el error indica la función y la línea exacta del problema, por ejemplo:

```txt
1) CarritoTest::testTotalSumaPrecioPorCantidadDeCadaItem
Failed asserting that 1745001.0 is identical to 1746001.0.
```

---

## Resumen

* Se extrajo la lógica de negocio de las páginas PHP a funciones puras en `src/lib/funciones.php`.
* Se escribieron 22 tests unitarios con PHPUnit en `tests/Unit/`.
* Se configuró Composer, `phpunit.xml` y un job de CI que corre los tests en cada push.
* Para ejecutarlos: `composer install` (una vez) y luego `composer test`.
