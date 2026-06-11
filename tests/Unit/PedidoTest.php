<?php

use PHPUnit\Framework\TestCase;

class PedidoTest extends TestCase
{
    private array $datos_envio = array(
        'nombre'        => 'Juan Pérez',
        'email'         => 'juan@example.com',
        'telefono'      => '1122334455',
        'direccion'     => 'Av. Siempre Viva 742',
        'ciudad'        => 'Buenos Aires',
        'codigo_postal' => '1414',
        'metodo_pago'   => 'tarjeta'
    );

    private array $carrito = array(
        1 => array('id' => 1, 'nombre' => 'Notebook', 'precio' => 100000.0, 'cantidad' => 2),
        2 => array('id' => 2, 'nombre' => 'Mouse', 'precio' => 5000.0, 'cantidad' => 1)
    );

    public function testNumeroDePedidoTieneElFormatoEsperado(): void
    {
        $numero = generar_numero_pedido();

        $this->assertMatchesRegularExpression('/^PED-\d{8}-\d{4}$/', $numero);
        $this->assertStringContainsString(date('Ymd'), $numero);
    }

    public function testCrearPedidoIncluyeDatosDeEnvioItemsYTotal(): void
    {
        $pedido = crear_pedido($this->datos_envio, $this->carrito, 'PED-20260611-1234', '2026-06-11 10:00:00');

        $this->assertSame('PED-20260611-1234', $pedido['numero_pedido']);
        $this->assertSame('2026-06-11 10:00:00', $pedido['fecha']);
        $this->assertSame('Juan Pérez', $pedido['nombre']);
        $this->assertSame('juan@example.com', $pedido['email']);
        $this->assertSame('tarjeta', $pedido['metodo_pago']);
        $this->assertSame($this->carrito, $pedido['items']);
        $this->assertSame(205000.0, $pedido['total']);
    }

    public function testCrearPedidoConCarritoVacioTieneTotalCero(): void
    {
        $pedido = crear_pedido($this->datos_envio, array(), 'PED-20260611-0001', '2026-06-11 10:00:00');

        $this->assertSame(0.0, $pedido['total']);
        $this->assertSame(array(), $pedido['items']);
    }
}
