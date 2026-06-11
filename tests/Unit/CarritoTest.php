<?php

use PHPUnit\Framework\TestCase;

class CarritoTest extends TestCase
{
    private array $notebook = array(
        'id'     => 1,
        'nombre' => 'Notebook Lenovo',
        'precio' => 850000.50,
        'stock'  => 10
    );

    private array $mouse = array(
        'id'     => 2,
        'nombre' => 'Mouse Logitech',
        'precio' => 15000.00,
        'stock'  => 50
    );

    public function testAgregarProductoNuevoAlCarritoVacio(): void
    {
        $carrito = carrito_agregar(array(), $this->notebook, 2);

        $this->assertCount(1, $carrito);
        $this->assertSame('Notebook Lenovo', $carrito[1]['nombre']);
        $this->assertSame(850000.50, $carrito[1]['precio']);
        $this->assertSame(2, $carrito[1]['cantidad']);
    }

    public function testAgregarProductoExistenteSumaCantidades(): void
    {
        $carrito = carrito_agregar(array(), $this->notebook, 2);
        $carrito = carrito_agregar($carrito, $this->notebook, 3);

        $this->assertCount(1, $carrito);
        $this->assertSame(5, $carrito[1]['cantidad']);
    }

    public function testAgregarDosProductosDistintos(): void
    {
        $carrito = carrito_agregar(array(), $this->notebook, 1);
        $carrito = carrito_agregar($carrito, $this->mouse, 4);

        $this->assertCount(2, $carrito);
        $this->assertSame(1, $carrito[1]['cantidad']);
        $this->assertSame(4, $carrito[2]['cantidad']);
    }

    public function testActualizarCantidadDeProductoExistente(): void
    {
        $carrito = carrito_agregar(array(), $this->notebook, 1);
        $carrito = carrito_actualizar_cantidad($carrito, 1, 7);

        $this->assertSame(7, $carrito[1]['cantidad']);
    }

    public function testActualizarProductoInexistenteNoModificaElCarrito(): void
    {
        $carrito = carrito_agregar(array(), $this->notebook, 1);
        $resultado = carrito_actualizar_cantidad($carrito, 99, 5);

        $this->assertSame($carrito, $resultado);
    }

    public function testActualizarConCantidadInvalidaNoModificaElCarrito(): void
    {
        $carrito = carrito_agregar(array(), $this->notebook, 3);
        $resultado = carrito_actualizar_cantidad($carrito, 1, 0);

        $this->assertSame(3, $resultado[1]['cantidad']);
    }

    public function testEliminarProductoDelCarrito(): void
    {
        $carrito = carrito_agregar(array(), $this->notebook, 1);
        $carrito = carrito_agregar($carrito, $this->mouse, 1);
        $carrito = carrito_eliminar($carrito, 1);

        $this->assertCount(1, $carrito);
        $this->assertArrayNotHasKey(1, $carrito);
        $this->assertArrayHasKey(2, $carrito);
    }

    public function testEliminarProductoInexistenteNoFalla(): void
    {
        $carrito = carrito_agregar(array(), $this->notebook, 1);
        $resultado = carrito_eliminar($carrito, 99);

        $this->assertSame($carrito, $resultado);
    }

    public function testTotalDeCarritoVacioEsCero(): void
    {
        $this->assertSame(0.0, carrito_total(array()));
    }

    public function testTotalSumaPrecioPorCantidadDeCadaItem(): void
    {
        $carrito = carrito_agregar(array(), $this->notebook, 2);
        $carrito = carrito_agregar($carrito, $this->mouse, 3);

        // 850000.50 * 2 + 15000.00 * 3 = 1745001.00
        $this->assertSame(1745001.0, carrito_total($carrito));
    }

    public function testContarItemsDeCarritoVacioEsCero(): void
    {
        $this->assertSame(0, carrito_contar_items(array()));
    }

    public function testContarItemsSumaLasCantidades(): void
    {
        $carrito = carrito_agregar(array(), $this->notebook, 2);
        $carrito = carrito_agregar($carrito, $this->mouse, 3);

        $this->assertSame(5, carrito_contar_items($carrito));
    }
}
