# Pruebas End-to-End con Playwright

## ¿Qué es Playwright?

Playwright es una herramienta para realizar pruebas automatizadas de aplicaciones web. Permite simular el comportamiento real de un usuario dentro del navegador, por ejemplo:

* Abrir una página.
* Hacer clic en botones.
* Completar formularios.
* Validar textos visibles.
* Navegar entre pantallas.
* Probar la aplicación en distintos navegadores.

Este tipo de pruebas se conocen como **E2E**, o **End-to-End**, porque prueban el sistema completo desde la interfaz hasta el resultado final.

---

## ¿Para qué sirve Playwright?

Playwright sirve para verificar que una aplicación web funciona correctamente desde el punto de vista del usuario.

Por ejemplo, permite probar automáticamente casos como:

* Que la página principal cargue correctamente.
* Que un formulario permita ingresar datos.
* Que un botón realice la acción esperada.
* Que una búsqueda muestre resultados.
* Que un mensaje de error aparezca cuando corresponde.

---

## Instalación realizada

El proyecto fue configurado con Playwright usando TypeScript.

Comando utilizado:

```bash
pnpm create playwright
```

Durante la instalación se seleccionaron las siguientes opciones:

```txt
TypeScript
Carpeta de tests: tests
Agregar workflow de GitHub Actions: Sí
Instalar navegadores de Playwright: Sí
```

---

## Dependencias instaladas

### `@playwright/test`

Es la librería principal de Playwright para escribir y ejecutar pruebas.

Instalación:

```bash
pnpm add --save-dev @playwright/test
```

### `@types/node`

Agrega tipos de Node.js para trabajar correctamente con TypeScript.

Instalación:

```bash
pnpm add --save-dev @types/node
```

---

## Estructura generada

Después de instalar Playwright, se agregaron archivos como:

```txt
tests/
  example.spec.ts

playwright.config.ts

.github/
  workflows/
    playwright.yml

package.json
```

---

## Archivo `tests/example.spec.ts`

Este archivo contiene una prueba de ejemplo.

Ejemplo básico:

```ts
import { test, expect } from '@playwright/test';

test('has title', async ({ page }) => {
  await page.goto('https://playwright.dev/');

  await expect(page).toHaveTitle(/Playwright/);
});
```

### Explicación

```ts
import { test, expect } from '@playwright/test';
```

Importa las herramientas necesarias para crear pruebas y validar resultados.

```ts
test('has title', async ({ page }) => {
```

Define una prueba. El texto `'has title'` es el nombre de la prueba.

```ts
await page.goto('https://playwright.dev/');
```

Abre una página web en el navegador.

```ts
await expect(page).toHaveTitle(/Playwright/);
```

Verifica que el título de la página contenga la palabra `Playwright`.

---

## Archivo `playwright.config.ts`

Este archivo contiene la configuración principal de Playwright.

Ejemplo:

```ts
import { defineConfig, devices } from '@playwright/test';

export default defineConfig({
  testDir: './tests',

  fullyParallel: true,

  forbidOnly: !!process.env.CI,

  retries: process.env.CI ? 2 : 0,

  workers: process.env.CI ? 1 : undefined,

  reporter: 'html',

  use: {
    trace: 'on-first-retry',
  },

  projects: [
    {
      name: 'chromium',
      use: { ...devices['Desktop Chrome'] },
    },

    {
      name: 'firefox',
      use: { ...devices['Desktop Firefox'] },
    },

    {
      name: 'webkit',
      use: { ...devices['Desktop Safari'] },
    },
  ],
});
```

---

## Explicación de las configuraciones

### `testDir`

```ts
testDir: './tests'
```

Indica en qué carpeta estarán las pruebas.

En este caso, Playwright buscará los tests dentro de:

```txt
tests/
```

---

### `fullyParallel`

```ts
fullyParallel: true
```

Permite ejecutar pruebas en paralelo para que sean más rápidas.

---

### `forbidOnly`

```ts
forbidOnly: !!process.env.CI
```

Evita que se suban pruebas marcadas con `.only` cuando se ejecutan en integración continua.

Ejemplo peligroso:

```ts
test.only('solo esta prueba', async ({ page }) => {
  // ...
});
```

`test.only` hace que solo se ejecute esa prueba y se ignoren las demás.

---

### `retries`

```ts
retries: process.env.CI ? 2 : 0
```

Indica cuántas veces se debe reintentar una prueba si falla.

En CI/CD se reintenta 2 veces.

Localmente no se reintenta.

---

### `workers`

```ts
workers: process.env.CI ? 1 : undefined
```

Controla cuántos procesos ejecutan pruebas al mismo tiempo.

En CI/CD se usa `1` para evitar errores por concurrencia.

---

### `reporter`

```ts
reporter: 'html'
```

Genera un reporte visual en HTML con el resultado de las pruebas.

---

### `use`

```ts
use: {
  trace: 'on-first-retry',
}
```

Permite generar trazas cuando una prueba falla y se vuelve a intentar.

Las trazas ayudan a ver qué ocurrió durante la ejecución de una prueba.

---

### `projects`

```ts
projects: [
  {
    name: 'chromium',
    use: { ...devices['Desktop Chrome'] },
  },
  {
    name: 'firefox',
    use: { ...devices['Desktop Firefox'] },
  },
  {
    name: 'webkit',
    use: { ...devices['Desktop Safari'] },
  },
]
```

Define en qué navegadores se ejecutarán las pruebas.

Playwright permite probar en:

* Chromium
* Firefox
* WebKit

Esto ayuda a verificar que la aplicación funcione correctamente en distintos navegadores.

---

## Comandos principales

### Ejecutar todas las pruebas

```bash
pnpm exec playwright test
```

Ejecuta todos los tests ubicados en la carpeta `tests`.

---

### Ejecutar pruebas con interfaz visual

```bash
pnpm exec playwright test --ui
```

Abre una interfaz gráfica para ejecutar y analizar las pruebas de forma visual.

Es útil para aprender, depurar y entender cómo se ejecutan los tests.

---

### Ejecutar pruebas en modo visible

```bash
pnpm exec playwright test --headed
```

Ejecuta las pruebas mostrando el navegador.

Por defecto, Playwright ejecuta las pruebas en modo oculto o `headless`.

---

### Ejecutar una prueba específica

```bash
pnpm exec playwright test tests/example.spec.ts
```

Ejecuta solamente el archivo indicado.

---

### Ejecutar pruebas en un navegador específico

```bash
pnpm exec playwright test --project=chromium
```

Ejecuta las pruebas solo en Chromium.

Otros ejemplos:

```bash
pnpm exec playwright test --project=firefox
```

```bash
pnpm exec playwright test --project=webkit
```

---

### Ver el último reporte HTML

```bash
pnpm exec playwright show-report
```

Abre el último reporte generado por Playwright.

---

### Instalar navegadores de Playwright

```bash
pnpm exec playwright install
```

Descarga los navegadores necesarios para ejecutar las pruebas.

---

### Instalar dependencias del sistema operativo

```bash
pnpm exec playwright install-deps
```

Instala dependencias necesarias del sistema operativo.

Importante: este comando está pensado principalmente para sistemas basados en Debian o Ubuntu.

En sistemas basados en Arch Linux, como CachyOS, se recomienda instalar las dependencias manualmente con `pacman`.

---

## Scripts recomendados para `package.json`

Se recomienda agregar estos scripts:

```json
{
  "scripts": {
    "test:e2e": "playwright test",
    "test:e2e:ui": "playwright test --ui",
    "test:e2e:headed": "playwright test --headed",
    "test:e2e:report": "playwright show-report"
  }
}
```

---

## Uso de los scripts

### Ejecutar pruebas E2E

```bash
pnpm test:e2e
```

### Ejecutar pruebas con interfaz visual

```bash
pnpm test:e2e:ui
```

### Ejecutar pruebas mostrando el navegador

```bash
pnpm test:e2e:headed
```

### Ver reporte de pruebas

```bash
pnpm test:e2e:report
```

---

## Archivo `.github/workflows/playwright.yml`

Este archivo permite ejecutar las pruebas automáticamente en GitHub Actions.

Ejemplo:

```yml
name: Playwright Tests

on:
  push:
    branches: [main, master]
  pull_request:
    branches: [main, master]

jobs:
  test:
    timeout-minutes: 60
    runs-on: ubuntu-latest

    steps:
      - uses: actions/checkout@v4

      - uses: actions/setup-node@v4
        with:
          node-version: lts/*

      - name: Install pnpm
        run: npm install -g pnpm

      - name: Install dependencies
        run: pnpm install

      - name: Install Playwright Browsers
        run: pnpm exec playwright install --with-deps

      - name: Run Playwright tests
        run: pnpm exec playwright test

      - uses: actions/upload-artifact@v4
        if: always()
        with:
          name: playwright-report
          path: playwright-report/
          retention-days: 30
```

---

## Explicación del workflow

### `on`

```yml
on:
  push:
    branches: [main, master]
  pull_request:
    branches: [main, master]
```

Indica cuándo se ejecutarán las pruebas.

En este caso, se ejecutan cuando se hace:

* `push` a `main` o `master`.
* `pull_request` hacia `main` o `master`.

---

### `runs-on`

```yml
runs-on: ubuntu-latest
```

Indica que las pruebas se ejecutarán en un servidor Linux de GitHub Actions.

---

### `actions/checkout`

```yml
- uses: actions/checkout@v4
```

Descarga el código del repositorio dentro del servidor de GitHub Actions.

---

### `actions/setup-node`

```yml
- uses: actions/setup-node@v4
```

Instala Node.js en el entorno de ejecución.

---

### Instalar dependencias

```yml
- name: Install dependencies
  run: pnpm install
```

Instala las dependencias del proyecto.

---

### Instalar navegadores

```yml
- name: Install Playwright Browsers
  run: pnpm exec playwright install --with-deps
```

Instala los navegadores y las dependencias necesarias para ejecutar Playwright.

En GitHub Actions sí funciona correctamente porque el entorno usa Ubuntu.

---

### Ejecutar pruebas

```yml
- name: Run Playwright tests
  run: pnpm exec playwright test
```

Ejecuta las pruebas automatizadas.

---

### Subir reporte como artefacto

```yml
- uses: actions/upload-artifact@v4
```

Guarda el reporte generado por Playwright para poder descargarlo desde GitHub Actions.

---

## Conceptos importantes

### Test

Un test es una prueba automatizada que verifica que una parte de la aplicación funcione correctamente.

---

### E2E

E2E significa **End-to-End**.

Una prueba E2E simula el recorrido completo de un usuario dentro de la aplicación.

---

### Browser

Es el navegador donde se ejecutan las pruebas.

Playwright puede usar:

* Chromium
* Firefox
* WebKit

---

### Headless

Significa que el navegador se ejecuta sin mostrarse en pantalla.

Es el modo más usado en servidores y pipelines de CI/CD.

---

### Headed

Significa que el navegador se muestra visualmente mientras se ejecutan las pruebas.

Es útil para depurar.

---

### Locator

Un locator permite encontrar elementos en la pantalla.

Ejemplo:

```ts
await page.getByRole('button', { name: 'Guardar' }).click();
```

Este código busca un botón llamado `Guardar` y hace clic sobre él.

---

### Expect

`expect` permite validar resultados esperados.

Ejemplo:

```ts
await expect(page.getByText('Operación exitosa')).toBeVisible();
```

Este código verifica que el texto `Operación exitosa` sea visible en pantalla.

---

## Ejemplo de prueba básica

```ts
import { test, expect } from '@playwright/test';

test('la página principal carga correctamente', async ({ page }) => {
  await page.goto('http://localhost:3000');

  await expect(page).toHaveTitle(/Tienda/);
});
```

---

## Ejemplo de prueba con botón

```ts
import { test, expect } from '@playwright/test';

test('el usuario puede hacer clic en un botón', async ({ page }) => {
  await page.goto('http://localhost:3000');

  await page.getByRole('button', { name: 'Ingresar' }).click();

  await expect(page.getByText('Bienvenido')).toBeVisible();
});
```

---

## Buenas prácticas

* Escribir pruebas claras y simples.
* Usar nombres descriptivos.
* Probar acciones reales del usuario.
* Evitar depender de detalles internos de implementación.
* Preferir `getByRole`, `getByText`, `getByLabel` antes que selectores CSS complejos.
* Ejecutar las pruebas antes de subir cambios.
* Revisar el reporte cuando una prueba falle.

---

## Flujo recomendado

Antes de subir cambios al repositorio:

```bash
pnpm test:e2e
```

Si falla alguna prueba:

```bash
pnpm test:e2e:ui
```

Luego revisar el reporte:

```bash
pnpm test:e2e:report
```

---

## Resumen

Playwright permite automatizar pruebas desde el punto de vista del usuario.

En este proyecto se utiliza para validar que la aplicación web funcione correctamente en distintos navegadores y para ejecutar pruebas automáticas tanto de forma local como en GitHub Actions.
