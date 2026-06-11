import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {
  await page.goto('http://localhost:8080/');
  await page.getByRole('listitem').filter({ hasText: 'Carrito (0)' }).click();
  await page.getByRole('link', { name: 'Contacto' }).click();
  await page.getByRole('textbox', { name: 'Nombre *' }).click();
  await page.getByRole('textbox', { name: 'Nombre *' }).fill('Facundo');
  await page.getByRole('textbox', { name: 'Nombre *' }).press('Tab');
  await page.getByRole('textbox', { name: 'Email *' }).fill('Veron');
  await page.getByRole('textbox', { name: 'Email *' }).press('Tab');
  await page.getByRole('textbox', { name: 'Asunto *' }).fill('Computadora');
  await page.getByRole('textbox', { name: 'Asunto *' }).press('Tab');
  await page.getByRole('textbox', { name: 'Mensaje *' }).fill('Cuanto sale?\n');
  await page.getByRole('button', { name: 'Enviar Mensaje' }).click();
  await page.getByRole('textbox', { name: 'Email *' }).click();
  await page.getByRole('textbox', { name: 'Email *' }).fill('Veron@gmail.com');
  await page.getByRole('button', { name: 'Enviar Mensaje' }).click();
  await expect(page.locator('#mensaje-contacto')).toContainText('Gracias por contactarnos');
});