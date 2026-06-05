import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {
  await page.goto('http://localhost:8080/');
  await page.getByRole('button', { name: 'Agregar al Carrito' }).nth(1).click();
  await page.getByRole('button', { name: 'Eliminar' }).click();
});