# Guía de Playwright Recorder / Codegen

## ¿Qué es Playwright Recorder?

Playwright Recorder, también llamado `codegen`, es una herramienta que permite grabar acciones realizadas en el navegador y generar automáticamente código de pruebas end-to-end.

Sirve para crear rápidamente la base de un test sin escribir todo el código manualmente.

---

## Comando básico

```bash
pnpm exec playwright codegen
```

Este comando abre un navegador y una ventana con el código generado.

---

## Abrir una URL específica

```bash
pnpm exec playwright codegen http://localhost:8080
```

Abre directamente la aplicación indicada.

---

## Guardar el test en un archivo

```bash
pnpm exec playwright codegen -o tests/login.spec.ts http://localhost:8080
```

La opción `-o` indica el archivo donde se guardará el código generado.

---

## Error común con `-o`

Incorrecto:

```bash
pnpm exec playwright codegen -o http://localhost:8080
```

En este caso Playwright interpreta la URL como si fuera el archivo de salida.

Correcto:

```bash
pnpm exec playwright codegen -o tests/login.spec.ts http://localhost:8080
```

---

## Detener el recorder

Para detener Playwright Recorder:

```txt
CTRL + C
```

También se pueden cerrar las ventanas abiertas.

---

## Ejecutar el test grabado

```bash
pnpm exec playwright test tests/login.spec.ts
```

---

## Ejecutar el test mostrando el navegador

```bash
pnpm exec playwright test tests/login.spec.ts --headed
```

---

## Ejecutar el test más lento

```bash
pnpm exec playwright test tests/login.spec.ts --headed --slow-mo=1000
```

`1000` equivale a 1 segundo entre acciones.

---

# Opciones útiles de `codegen`

## `-o` o `--output`

Guarda el código generado en un archivo.

```bash
pnpm exec playwright codegen -o tests/login.spec.ts http://localhost:8080
```

---

## `--target`

Define el lenguaje o formato del código generado.

Ejemplo TypeScript:

```bash
pnpm exec playwright codegen --target=playwright-test http://localhost:8080
```

Otras opciones comunes:

```bash
--target=javascript
--target=python
--target=python-async
--target=csharp
--target=java
```

Para proyectos TypeScript con Playwright Test, se recomienda:

```bash
--target=playwright-test
```

---

## `--browser`

Indica qué navegador usar para grabar.

Chromium:

```bash
pnpm exec playwright codegen --browser=chromium http://localhost:8080
```

Firefox:

```bash
pnpm exec playwright codegen --browser=firefox http://localhost:8080
```

WebKit:

```bash
pnpm exec playwright codegen --browser=webkit http://localhost:8080
```

---

## `--device`

Permite simular un dispositivo.

Ejemplo iPhone:

```bash
pnpm exec playwright codegen --device="iPhone 13" http://localhost:8080
```

Ejemplo Pixel:

```bash
pnpm exec playwright codegen --device="Pixel 5" http://localhost:8080
```

---

## `--viewport-size`

Define el tamaño de la ventana del navegador.

```bash
pnpm exec playwright codegen --viewport-size=1280,720 http://localhost:8080
```

---

## `--color-scheme`

Simula el modo claro u oscuro.

Modo claro:

```bash
pnpm exec playwright codegen --color-scheme=light http://localhost:8080
```

Modo oscuro:

```bash
pnpm exec playwright codegen --color-scheme=dark http://localhost:8080
```

---

## `--geolocation`

Simula una ubicación geográfica.

```bash
pnpm exec playwright codegen --geolocation="-25.2867,-57.7185" http://localhost:8080
```

Formato:

```txt
latitud,longitud
```

---

## `--lang`

Define el idioma del navegador.

```bash
pnpm exec playwright codegen --lang=es-AR http://localhost:8080
```

---

## `--timezone`

Define la zona horaria.

```bash
pnpm exec playwright codegen --timezone=America/Argentina/Cordoba http://localhost:8080
```

---

## `--user-agent`

Define un user agent personalizado.

```bash
pnpm exec playwright codegen --user-agent="Mozilla/5.0 Custom" http://localhost:8080
```

---

## `--ignore-https-errors`

Ignora errores HTTPS.

Útil cuando se trabaja con certificados locales o de prueba.

```bash
pnpm exec playwright codegen --ignore-https-errors https://localhost:8080
```

---

## `--save-storage`

Guarda el estado de sesión del navegador.

Sirve para guardar cookies, localStorage y sesión iniciada.

```bash
pnpm exec playwright codegen --save-storage=auth.json http://localhost:8080
```

---

## `--load-storage`

Carga un estado de sesión previamente guardado.

```bash
pnpm exec playwright codegen --load-storage=auth.json http://localhost:8080
```

---

## `--timeout`

Define el tiempo máximo de espera.

```bash
pnpm exec playwright codegen --timeout=10000 http://localhost:8080
```

El valor se expresa en milisegundos.

```txt
10000 = 10 segundos
```

---

## `--help`

Muestra la ayuda oficial del comando.

```bash
pnpm exec playwright codegen --help
```

---

# Ejemplos prácticos

## Grabar un login

```bash
pnpm exec playwright codegen -o tests/login.spec.ts http://localhost:8080
```

---

## Grabar en modo mobile

```bash
pnpm exec playwright codegen -o tests/mobile-login.spec.ts --device="iPhone 13" http://localhost:8080
```

---

## Grabar usando Firefox

```bash
pnpm exec playwright codegen -o tests/firefox-login.spec.ts --browser=firefox http://localhost:8080
```

---

## Grabar con sesión guardada

Primero se graba el login y se guarda la sesión:

```bash
pnpm exec playwright codegen --save-storage=auth.json http://localhost:8080
```

Después se reutiliza esa sesión:

```bash
pnpm exec playwright codegen --load-storage=auth.json http://localhost:8080
```

---

# Flujo recomendado para estudiantes

## 1. Crear archivo de prueba con recorder

```bash
pnpm exec playwright codegen -o tests/login.spec.ts http://localhost:8080
```

## 2. Realizar las acciones en el navegador

Ejemplo:

* ingresar usuario
* ingresar contraseña
* hacer clic en ingresar
* verificar pantalla principal

## 3. Detener el recorder

```txt
CTRL + C
```

## 4. Ejecutar la prueba

```bash
pnpm exec playwright test tests/login.spec.ts
```

## 5. Ejecutarla mostrando el navegador

```bash
pnpm exec playwright test tests/login.spec.ts --headed
```

## 6. Depurarla más lento

```bash
pnpm exec playwright test tests/login.spec.ts --headed --slow-mo=1000
```

---

# Recomendaciones

El recorder es muy útil para generar una primera versión del test, pero luego conviene revisar y mejorar el código.

Se recomienda:

* eliminar pasos innecesarios
* agregar validaciones con `expect`
* usar nombres claros para los tests
* organizar los archivos por funcionalidad
* no depender únicamente del código generado automáticamente

---

# Resumen

Playwright Recorder permite grabar acciones reales dentro del navegador y convertirlas en código de pruebas automatizadas.

El comando más recomendado para comenzar es:

```bash
pnpm exec playwright codegen -o tests/nombre-del-test.spec.ts http://localhost:8080
```
