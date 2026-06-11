<?php

use PHPUnit\Framework\TestCase;

class ValidacionTest extends TestCase
{
    public function testSanitizarTextoEscapaHtml(): void
    {
        $this->assertSame(
            '&lt;script&gt;alert(1)&lt;/script&gt;',
            sanitizar_texto('<script>alert(1)</script>')
        );
    }

    public function testSanitizarTextoEscapaComillas(): void
    {
        $this->assertSame('Juan &quot;el Tano&quot;', sanitizar_texto('Juan "el Tano"'));
    }

    public function testSanitizarTextoNoModificaTextoPlano(): void
    {
        $this->assertSame('Hola mundo', sanitizar_texto('Hola mundo'));
    }

    public function testValidarPasaCuandoTodosLosCamposEstanCompletos(): void
    {
        $datos = array('nombre' => 'Ana', 'email' => 'ana@example.com');

        $this->assertTrue(validar_campos_requeridos($datos, array('nombre', 'email')));
    }

    public function testValidarFallaConCampoVacio(): void
    {
        $datos = array('nombre' => 'Ana', 'email' => '');

        $this->assertFalse(validar_campos_requeridos($datos, array('nombre', 'email')));
    }

    public function testValidarFallaConCampoAusente(): void
    {
        $datos = array('nombre' => 'Ana');

        $this->assertFalse(validar_campos_requeridos($datos, array('nombre', 'email')));
    }

    public function testValidarIgnoraCamposExtraNoRequeridos(): void
    {
        $datos = array('nombre' => 'Ana', 'comentario' => '');

        $this->assertTrue(validar_campos_requeridos($datos, array('nombre')));
    }
}
