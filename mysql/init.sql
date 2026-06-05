CREATE DATABASE IF NOT EXISTS mi_base
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE mi_base;

CREATE TABLE IF NOT EXISTS productos (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(200)   NOT NULL,
    precio      DECIMAL(10,2)  NOT NULL,
    descripcion TEXT,
    imagen      VARCHAR(255)   DEFAULT 'placeholder.png',
    stock       INT            DEFAULT 0,
    destacado   TINYINT(1)     DEFAULT 0,
    activo      TINYINT(1)     DEFAULT 1,
    created_at  DATETIME       DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS pedidos (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(100)  NOT NULL,
    email        VARCHAR(150)  NOT NULL,
    telefono     VARCHAR(20),
    direccion    TEXT,
    ciudad       VARCHAR(100),
    codigo_postal VARCHAR(20),
    metodo_pago  ENUM('tarjeta','paypal','transferencia') DEFAULT 'tarjeta',
    total        DECIMAL(10,2) NOT NULL,
    fecha        DATETIME      DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS pedido_items (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id        INT           NOT NULL,
    producto_id      INT           NOT NULL,
    nombre_producto  VARCHAR(200)  NOT NULL,
    precio           DECIMAL(10,2) NOT NULL,
    cantidad         INT           NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
