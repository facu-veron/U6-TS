<?php

/**
 * Lógica de negocio de la tienda, separada de las páginas
 * para poder probarla de forma unitaria con PHPUnit.
 */

function carrito_agregar(array $carrito, array $producto, int $cantidad): array
{
    $producto_id = $producto['id'];

    if (isset($carrito[$producto_id])) {
        $carrito[$producto_id]['cantidad'] += $cantidad;
    } else {
        $carrito[$producto_id] = array(
            'id'       => $producto['id'],
            'nombre'   => $producto['nombre'],
            'precio'   => $producto['precio'],
            'cantidad' => $cantidad
        );
    }

    return $carrito;
}

function carrito_actualizar_cantidad(array $carrito, int $producto_id, int $cantidad): array
{
    if ($cantidad > 0 && isset($carrito[$producto_id])) {
        $carrito[$producto_id]['cantidad'] = $cantidad;
    }

    return $carrito;
}

function carrito_eliminar(array $carrito, int $producto_id): array
{
    unset($carrito[$producto_id]);

    return $carrito;
}

function carrito_total(array $carrito): float
{
    $total = 0;
    foreach ($carrito as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }

    return $total;
}

function carrito_contar_items(array $carrito): int
{
    return array_sum(array_column($carrito, 'cantidad'));
}

function sanitizar_texto($valor): string
{
    return htmlspecialchars((string) $valor);
}

function validar_campos_requeridos(array $datos, array $campos): bool
{
    foreach ($campos as $campo) {
        if (empty($datos[$campo])) {
            return false;
        }
    }

    return true;
}

function generar_numero_pedido(): string
{
    return 'PED-' . date('Ymd') . '-' . rand(1000, 9999);
}

function crear_pedido(array $datos_envio, array $carrito, string $numero_pedido, string $fecha): array
{
    return array(
        'numero_pedido' => $numero_pedido,
        'fecha'         => $fecha,
        'nombre'        => $datos_envio['nombre'],
        'email'         => $datos_envio['email'],
        'telefono'      => $datos_envio['telefono'],
        'direccion'     => $datos_envio['direccion'],
        'ciudad'        => $datos_envio['ciudad'],
        'codigo_postal' => $datos_envio['codigo_postal'],
        'metodo_pago'   => $datos_envio['metodo_pago'],
        'items'         => $carrito,
        'total'         => carrito_total($carrito)
    );
}
