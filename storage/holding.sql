-- ==========================================================
--           CREACIÓN DE BASE DE DATOS
-- ==========================================================
CREATE DATABASE IF NOT EXISTS tienda_virtual
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_general_ci;

USE tienda_virtual;

-- ==========================================================
--           TABLAS DE USUARIOS
-- ==========================================================
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    correo VARCHAR(150) UNIQUE NOT NULL,
    clave_hash VARCHAR(255) NOT NULL,
    nombres VARCHAR(120),
    apellidos VARCHAR(120),
    rol ENUM('administrador','vendedor','tecnico') DEFAULT 'vendedor',
    activo TINYINT DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_ultima_sesion TIMESTAMP NULL,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================================
--          TABLAS DE CLIENTES
-- ==========================================================
CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(120) NOT NULL,
    apellidos VARCHAR(120) NOT NULL,
    correo VARCHAR(150),
    telefono VARCHAR(20),
    tipo_documento ENUM('DNI','RUC','CE','PASAPORTE') DEFAULT 'DNI',
    numero_documento VARCHAR(20),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================================
--           CATEGORÍAS Y MARCAS
-- ==========================================================
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    slug VARCHAR(150) UNIQUE,
    id_padre INT NULL,
    orden INT DEFAULT 1,
    FOREIGN KEY (id_padre) REFERENCES categorias(id_categoria)
      ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE marcas (
    id_marca INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    slug VARCHAR(150) UNIQUE
) ENGINE=InnoDB;

-- ==========================================================
--            PRODUCTOS Y VARIANTES
-- ==========================================================
CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    codigo_maestro VARCHAR(50) UNIQUE,
    titulo VARCHAR(200) NOT NULL,
    descripcion_corta VARCHAR(255),
    descripcion_larga TEXT,
    id_marca INT,
    id_categoria INT,
    activo TINYINT DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_marca) REFERENCES marcas(id_marca),
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
) ENGINE=InnoDB;

CREATE TABLE variantes_producto (
    id_variante INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT NOT NULL,
    sku VARCHAR(50) UNIQUE NOT NULL,
    codigo_modelo VARCHAR(80),
    atributos JSON,
    precio DECIMAL(10,2) NOT NULL DEFAULT 0,
    costo DECIMAL(10,2) DEFAULT 0,
    codigo_barras VARCHAR(50),
    peso_gramos INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
      ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE imagenes_producto (
    id_imagen INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT,
    id_variante INT,
    url VARCHAR(300) NOT NULL,
    texto_alt VARCHAR(200),
    orden INT DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
      ON DELETE CASCADE,
    FOREIGN KEY (id_variante) REFERENCES variantes_producto(id_variante)
      ON DELETE CASCADE
) ENGINE=InnoDB;

-- ==========================================================
--           ALMACENES E INVENTARIO
-- ==========================================================
CREATE TABLE almacenes (
    id_almacen INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    es_predeterminado TINYINT DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE inventario (
    id_inventario INT AUTO_INCREMENT PRIMARY KEY,
    id_almacen INT NOT NULL,
    id_variante INT NOT NULL,
    cantidad_disponible INT DEFAULT 0,
    cantidad_reservada INT DEFAULT 0,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE (id_almacen, id_variante),
    FOREIGN KEY (id_almacen) REFERENCES almacenes(id_almacen),
    FOREIGN KEY (id_variante) REFERENCES variantes_producto(id_variante)
) ENGINE=InnoDB;

CREATE TABLE movimientos_inventario (
    id_movimiento INT AUTO_INCREMENT PRIMARY KEY,
    id_almacen INT NOT NULL,
    id_variante INT NOT NULL,
    cambio_cantidad INT NOT NULL,
    tipo_movimiento ENUM(
        'venta','compra','ajuste',
        'traslado_entrada','traslado_salida','pos'
    ) NOT NULL,
    referencia VARCHAR(200),
    id_usuario INT,
    nota TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_almacen) REFERENCES almacenes(id_almacen),
    FOREIGN KEY (id_variante) REFERENCES variantes_producto(id_variante),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- ==========================================================
--                PEDIDOS Y DETALLE
-- ==========================================================
CREATE TABLE pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    codigo_pedido VARCHAR(50) UNIQUE NOT NULL,
    id_cliente INT,
    monto_total DECIMAL(10,2) DEFAULT 0,
    moneda VARCHAR(10) DEFAULT 'PEN',
    estado ENUM('pendiente','confirmado','pagado','enviado','entregado','cancelado')
      DEFAULT 'pendiente',
    tipo_entrega ENUM('retiro','delivery') DEFAULT 'delivery',
    direccion_envio JSON,
    id_cupon INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_cupon) REFERENCES cupones(id_cupon)
) ENGINE=InnoDB;

CREATE TABLE detalle_pedido (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    id_variante INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_variante) REFERENCES variantes_producto(id_variante)
) ENGINE=InnoDB;

-- ==========================================================
--                     PAGOS
-- ==========================================================
CREATE TABLE pagos (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    moneda VARCHAR(10) DEFAULT 'PEN',
    metodo ENUM('tarjeta','yape','plin','transferencia','efectivo','paypal') NOT NULL,
    estado ENUM('pendiente','completado','fallido','reembolsado') DEFAULT 'pendiente',
    referencia_transaccion VARCHAR(255),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido)
) ENGINE=InnoDB;

-- ==========================================================
--                CUPONES / PROMOCIONES
-- ==========================================================
CREATE TABLE cupones (
    id_cupon INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(100) UNIQUE NOT NULL,
    descripcion VARCHAR(255),
    porcentaje_descuento DECIMAL(5,2),
    monto_descuento DECIMAL(10,2),
    valido_desde DATE,
    valido_hasta DATE,
    maximo_usos INT DEFAULT 0,
    usos_actuales INT DEFAULT 0,
    activo TINYINT DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================================
--          PRECIOS POR CANTIDAD
-- ==========================================================
CREATE TABLE precios_por_cantidad (
    id_precio INT AUTO_INCREMENT PRIMARY KEY,
    id_variante INT NOT NULL,
    cantidad_min INT NOT NULL,
    cantidad_max INT,
    precio DECIMAL(10,2) NOT NULL,
    grupo_cliente ENUM('general','mayorista','registrado') DEFAULT 'general',
    FOREIGN KEY (id_variante) REFERENCES variantes_producto(id_variante)
) ENGINE=InnoDB;
