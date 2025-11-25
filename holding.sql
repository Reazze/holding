-- =====================================================
-- BASE DE DATOS TIENDA VIRTUAL - NORMALIZADA (3FN)
-- Equipos de Cómputo, Electrónicos y Telecomunicaciones
-- =====================================================

-- ==================== MÓDULO DE SEGURIDAD ====================

CREATE TABLE usuario (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre_completo VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('administrador', 'vendedor', 'tecnico') NOT NULL ,
    estado ENUM('activo', 'inactivo', 'bloqueado') NOT NULL DEFAULT 'activo',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultimo_acceso TIMESTAMP NULL,
    token_recuperacion VARCHAR(100) NULL,
    token_expiracion TIMESTAMP NULL,
    INDEX idx_email (email),
    INDEX idx_tipo (tipo_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE permiso (
    id_permiso INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    modulo VARCHAR(50) NOT NULL,
    INDEX idx_modulo (modulo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE usuario_permiso (
    id_usuario_permiso INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_permiso INT NOT NULL,
    fecha_asignacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_permiso) REFERENCES permiso(id_permiso) ON DELETE CASCADE,
    UNIQUE KEY unique_usuario_permiso (id_usuario, id_permiso)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== MÓDULO DE cliente ====================

CREATE TABLE cliente (
    id_cliente INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NULL, -- NULL para compras como invitado
    tipo_cliente ENUM('retail', 'mayorista', 'corporativo') NOT NULL DEFAULT 'retail',
    razon_social VARCHAR(200) NULL,
    ruc VARCHAR(11) NULL,
    dni VARCHAR(8) NULL,
    telefono VARCHAR(20),
    direccion_fiscal TEXT,
    descuento_especial DECIMAL(5,2) DEFAULT 0.00,
    limite_credito DECIMAL(10,2) DEFAULT 0.00,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE SET NULL,
    INDEX idx_ruc (ruc),
    INDEX idx_dni (dni),
    INDEX idx_tipo (tipo_cliente)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== MÓDULO DE producto ====================

CREATE TABLE categoria (
    id_categoria INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    slug VARCHAR(120) UNIQUE NOT NULL,
    descripcion TEXT,
    id_categoria_padre INT NULL,
    icono VARCHAR(100) NULL,
    orden INT DEFAULT 0,
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categoria_padre) REFERENCES categoria(id_categoria) ON DELETE SET NULL,
    INDEX idx_slug (slug),
    INDEX idx_padre (id_categoria_padre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE marca (
    id_marca INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(120) UNIQUE NOT NULL,
    logo VARCHAR(255) NULL,
    descripcion TEXT,
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE proveedor (
    id_proveedor INT PRIMARY KEY AUTO_INCREMENT,
    razon_social VARCHAR(200) NOT NULL,
    ruc VARCHAR(11) UNIQUE NOT NULL,
    contacto VARCHAR(150),
    telefono VARCHAR(20),
    email VARCHAR(150),
    direccion TEXT,
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_ruc (ruc)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE almacen (
    id_almacen INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    direccion TEXT NOT NULL,
    responsable VARCHAR(150),
    telefono VARCHAR(20),
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE producto (
    id_producto INT PRIMARY KEY AUTO_INCREMENT,
    sku VARCHAR(50) UNIQUE NOT NULL,
    codigo_interno VARCHAR(50) NULL,
    nombre VARCHAR(255) NOT NULL,
    slug VARCHAR(300) UNIQUE NOT NULL,
    descripcion_corta TEXT,
    descripcion_larga TEXT,
    ficha_tecnica TEXT,
    modelo VARCHAR(100),
    id_marca INT NULL,
    id_categoria INT NOT NULL,
    precio_base DECIMAL(10,2) NOT NULL,
    precio_venta DECIMAL(10,2) NOT NULL,
    costo_unitario DECIMAL(10,2) DEFAULT 0.00,
    stock_minimo INT DEFAULT 5,total
    permite_venta_sin_stock BOOLEAN DEFAULT FALSE,
    peso DECIMAL(8,2) NULL COMMENT 'En kilogramos',
    dimensiones VARCHAR(50) NULL COMMENT 'LxWxH en cm',
    garantia_meses INT DEFAULT 0,
    destacado BOOLEAN DEFAULT FALSE,
    en_oferta BOOLEAN DEFAULT FALSE,
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_marca) REFERENCES marca(id_marca) ON DELETE SET NULL,
    FOREIGN KEY (id_categoria) REFERENCES categoria(id_categoria) ON DELETE RESTRICT,
    INDEX idx_sku (sku),
    INDEX idx_slug (slug),
    INDEX idx_marca (id_marca),
    INDEX idx_categoria (id_categoria),
    INDEX idx_destacado (destacado),
    INDEX idx_oferta (en_oferta),
    FULLTEXT idx_busqueda (nombre, descripcion_corta, modelo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE producto_imagen (
    id_imagen INT PRIMARY KEY AUTO_INCREMENT,
    id_producto INT NOT NULL,
    url_imagen VARCHAR(255) NOT NULL,
    orden INT DEFAULT 0,
    es_principal BOOLEAN DEFAULT FALSE,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto) ON DELETE CASCADE,
    INDEX idx_producto (id_producto)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE precios_por_cantidad (
    id_precio_cantidad INT PRIMARY KEY AUTO_INCREMENT,
    id_producto INT NOT NULL,
    cantidad_minima INT NOT NULL,
    cantidad_maxima INT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto) ON DELETE CASCADE,
    INDEX idx_producto (id_producto),
    CHECK (cantidad_minima > 0),
    CHECK (cantidad_maxima IS NULL OR cantidad_maxima >= cantidad_minima)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE precios_cliente_tipo (
    id_precio_cliente INT PRIMARY KEY AUTO_INCREMENT,
    id_producto INT NOT NULL,
    tipo_cliente ENUM('retail', 'mayorista', 'corporativo') NOT NULL,
    precio_especial DECIMAL(10,2) NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    fecha_inicio DATE,
    fecha_fin DATE,
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto) ON DELETE CASCADE,
    INDEX idx_producto_tipo (id_producto, tipo_cliente)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== MÓDULO DE INVENTARIO ====================

CREATE TABLE inventario (
    id_inventario INT PRIMARY KEY AUTO_INCREMENT,
    id_producto INT NOT NULL,
    id_almacen INT NOT NULL,
    cantidad_actual INT NOT NULL DEFAULT 0,
    cantidad_reservada INT NOT NULL DEFAULT 0,
    cantidad_disponible INT GENERATED ALWAYS AS (cantidad_actual - cantidad_reservada) STORED,
    ubicacion VARCHAR(50) NULL COMMENT 'Pasillo-Estante-Nivel',
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto) ON DELETE CASCADE,
    FOREIGN KEY (id_almacen) REFERENCES almacen(id_almacen) ON DELETE RESTRICT,
    UNIQUE KEY unique_producto_almacen (id_producto, id_almacen),
    INDEX idx_producto (id_producto),
    INDEX idx_almacen (id_almacen),
    CHECK (cantidad_actual >= 0),
    CHECK (cantidad_reservada >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE movimientos_inventario (
    id_movimiento INT PRIMARY KEY AUTO_INCREMENT,
    id_producto INT NOT NULL,
    id_almacen INT NOT NULL,
    tipo_movimiento ENUM('entrada', 'salida', 'ajuste', 'devolucion', 'transferencia') NOT NULL,
    cantidad INT NOT NULL,
    cantidad_anterior INT NOT NULL,
    cantidad_nueva INT NOT NULL,
    motivo VARCHAR(255) NOT NULL,
    id_usuario INT NOT NULL,
    id_pedido INT NULL,
    id_proveedor INT NULL,
    costo_unitario DECIMAL(10,2) NULL,
    numero_documento VARCHAR(50) NULL,
    fecha_movimiento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto) ON DELETE RESTRICT,
    FOREIGN KEY (id_almacen) REFERENCES almacen(id_almacen) ON DELETE RESTRICT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE RESTRICT,
    FOREIGN KEY (id_proveedor) REFERENCES proveedor(id_proveedor) ON DELETE SET NULL,
    INDEX idx_producto (id_producto),
    INDEX idx_almacen (id_almacen),
    INDEX idx_fecha (fecha_movimiento),
    INDEX idx_tipo (tipo_movimiento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== MÓDULO DE pedido ====================

CREATE TABLE pedido (
    id_pedido INT PRIMARY KEY AUTO_INCREMENT,
    numero_pedido VARCHAR(20) UNIQUE NOT NULL,
    id_cliente INT NULL,
    id_usuario INT NULL COMMENT 'Usuario que realizó el pedido (vendedor o el mismo cliente)',
    tipo_venta ENUM('online', 'tienda', 'telefono') NOT NULL DEFAULT 'online',
    estado ENUM('pendiente', 'confirmado', 'procesando', 'enviado', 'entregado', 'cancelado', 'devuelto') NOT NULL DEFAULT 'pendiente',
    subtotal DECIMAL(10,2) NOT NULL,
    descuento DECIMAL(10,2) DEFAULT 0.00,
    envio DECIMAL(10,2) DEFAULT 0.00,
    total DECIMAL(10,2) NOT NULL,
    metodo_pago ENUM('efectivo', 'tarjeta', 'yape', 'plin', 'transferencia', 'credito') NOT NULL,
    estado_pago ENUM('pendiente', 'pagado', 'parcial', 'reembolsado') NOT NULL DEFAULT 'pendiente',
    comprobante_tipo ENUM('boleta', 'factura', 'ticket') NULL,
    comprobante_serie VARCHAR(10) NULL,
    comprobante_numero VARCHAR(20) NULL,
    notas_cliente TEXT,
    notas_internas TEXT,
    ip_cliente VARCHAR(45) NULL,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_confirmacion TIMESTAMP NULL,
    fecha_envio TIMESTAMP NULL,
    fecha_entrega TIMESTAMP NULL,
    FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente) ON DELETE SET NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE SET NULL,
    INDEX idx_numero (numero_pedido),
    INDEX idx_cliente (id_cliente),
    INDEX idx_estado (estado),
    INDEX idx_fecha (fecha_pedido),
    INDEX idx_estado_pago (estado_pago)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE pedido_detalle (
    id_detalle INT PRIMARY KEY AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    id_producto INT NOT NULL,
    nombre_producto VARCHAR(255) NOT NULL COMMENT 'Snapshot del nombre',
    sku VARCHAR(50) NOT NULL COMMENT 'Snapshot del SKU',
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    descuento_unitario DECIMAL(10,2) DEFAULT 0.00,
    subtotal DECIMAL(10,2) NOT NULL,
    id_almacen INT NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto) ON DELETE RESTRICT,
    FOREIGN KEY (id_almacen) REFERENCES almacen(id_almacen) ON DELETE RESTRICT,
    INDEX idx_pedido (id_pedido),
    INDEX idx_producto (id_producto),
    CHECK (cantidad > 0),
    CHECK (precio_unitario >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE envio (
    id_envio INT PRIMARY KEY AUTO_INCREMENT,
    id_pedido INT NOT NULL UNIQUE,
    tipo_entrega ENUM('recojo_tienda', 'recojo_agencia', 'domicilio') NOT NULL,
    destinatario VARCHAR(150) NOT NULL,
    dni VARCHAR(8),
    telefono VARCHAR(20) NOT NULL,
    direccion TEXT NOT NULL,
    distrito VARCHAR(100) NOT NULL,
    provincia VARCHAR(100) NOT NULL,
    departamento VARCHAR(100) NOT NULL,
    referencia TEXT,
    fecha_estimada DATE NULL,
    codigo_seguimiento VARCHAR(100) NULL,
    transportadora VARCHAR(100) NULL,
    costo_envio DECIMAL(10,2) DEFAULT 0.00,
    fecha_envio TIMESTAMP NULL,
    fecha_entrega TIMESTAMP NULL,
    receptor_nombre VARCHAR(150) NULL,
    receptor_dni VARCHAR(8) NULL,
    evidencia_foto VARCHAR(255) NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido) ON DELETE CASCADE,
    INDEX idx_pedido (id_pedido),
    INDEX idx_fecha_estimada (fecha_estimada)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== MÓDULO DE pago ====================

CREATE TABLE pago (
    id_pago INT PRIMARY KEY AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    metodo_pago ENUM('efectivo', 'tarjeta', 'yape', 'plin', 'transferencia') NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    estado ENUM('pendiente', 'aprobado', 'rechazado', 'reembolsado') NOT NULL DEFAULT 'pendiente',
    referencia_externa VARCHAR(100) NULL COMMENT 'ID de transacción del gateway',
    numero_operacion VARCHAR(50) NULL,
    banco VARCHAR(100) NULL,
    fecha_pago TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    comprobante_imagen VARCHAR(255) NULL,
    notas TEXT,
    FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido) ON DELETE CASCADE,
    INDEX idx_pedido (id_pedido),
    INDEX idx_estado (estado),
    INDEX idx_fecha (fecha_pago)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== MÓDULO DE PROMOCIONES ====================

CREATE TABLE cupon (
    id_cupon INT PRIMARY KEY AUTO_INCREMENT,
    codigo VARCHAR(50) UNIQUE NOT NULL,
    descripcion VARCHAR(255),
    tipo_descuento ENUM('porcentaje', 'monto_fijo') NOT NULL,
    valor_descuento DECIMAL(10,2) NOT NULL,
    monto_minimo DECIMAL(10,2) DEFAULT 0.00,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    usos_maximos INT NULL,
    usos_actuales INT DEFAULT 0,
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_codigo (codigo),
    INDEX idx_fechas (fecha_inicio, fecha_fin),
    CHECK (valor_descuento > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE cupon_producto (
    id_cupon_producto INT PRIMARY KEY AUTO_INCREMENT,
    id_cupon INT NOT NULL,
    id_producto INT NULL,
    id_categoria INT NULL,
    FOREIGN KEY (id_cupon) REFERENCES cupon(id_cupon) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto) ON DELETE CASCADE,
    FOREIGN KEY (id_categoria) REFERENCES categoria(id_categoria) ON DELETE CASCADE,
    CHECK ((id_producto IS NOT NULL AND id_categoria IS NULL) OR 
           (id_producto IS NULL AND id_categoria IS NOT NULL))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE pedido_cupon (
    id_pedido_cupon INT PRIMARY KEY AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    id_cupon INT NOT NULL,
    descuento_aplicado DECIMAL(10,2) NOT NULL,
    fecha_aplicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_cupon) REFERENCES cupon(id_cupon) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== MÓDULO DE CONTENIDO WEB ====================

CREATE TABLE banner (
    id_banner INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(200) NOT NULL,
    subtitulo VARCHAR(255),
    imagen_desktop VARCHAR(255) NOT NULL,
    imagen_mobile VARCHAR(255) NULL,
    enlace VARCHAR(255),
    orden INT DEFAULT 0,
    activo BOOLEAN DEFAULT TRUE,
    fecha_inicio DATE,
    fecha_fin DATE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_orden (orden),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE pagina (
    id_pagina INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(200) NOT NULL,
    slug VARCHAR(220) UNIQUE NOT NULL,
    contenido TEXT NOT NULL,
    meta_titulo VARCHAR(200),
    meta_descripcion TEXT,
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== MÓDULO DE CONFIGURACIÓN ====================

CREATE TABLE configuracion (
    id_config INT PRIMARY KEY AUTO_INCREMENT,
    clave VARCHAR(100) UNIQUE NOT NULL,
    valor TEXT,
    tipo ENUM('texto', 'numero', 'booleano', 'json') DEFAULT 'texto',
    descripcion VARCHAR(255),
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_clave (clave)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== MÓDULO DE notificacion ====================

CREATE TABLE notificacion (
    id_notificacion INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NULL,
    tipo ENUM('pedido_nuevo', 'stock_bajo', 'pago_recibido', 'envio_actualizado', 'sistema') NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    mensaje TEXT NOT NULL,
    enlace VARCHAR(255) NULL,
    leida BOOLEAN DEFAULT FALSE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE,
    INDEX idx_usuario_leida (id_usuario, leida),
    INDEX idx_fecha (fecha_creacion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== MÓDULO DE AUDITORÍA ====================

CREATE TABLE auditoria (
    id_auditoria INT PRIMARY KEY AUTO_INCREMENT,
    tabla VARCHAR(50) NOT NULL,
    id_registro INT NOT NULL,
    accion ENUM('crear', 'actualizar', 'eliminar') NOT NULL,
    datos_anteriores JSON NULL,
    datos_nuevos JSON NULL,
    id_usuario INT NOT NULL,
    ip VARCHAR(45),
    fecha_accion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE RESTRICT,
    INDEX idx_tabla_registro (tabla, id_registro),
    INDEX idx_usuario (id_usuario),
    INDEX idx_fecha (fecha_accion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== ÍNDICES ADICIONALES PARA PERFORMANCE ====================

-- Índice compuesto para búsquedas de producto activos y destacados
CREATE INDEX idx_producto_activos_destacados ON producto(activo, destacado, fecha_creacion DESC);

-- Índice para búsqueda de pedido por rango de fechas y estado
CREATE INDEX idx_pedido_fecha_estado ON pedido(fecha_pedido, estado, estado_pago);

-- Índice para reportes de ventas por producto
CREATE INDEX idx_detalle_producto_fecha ON pedido_detalle(id_producto, id_pedido);

-- ==================== VISTAS ÚTILES ====================

-- Vista de productos con stock total
,
CREATE VIEW vista_producto_stock AS
SELECT 
    p.id_producto,
    p.sku,
    p.nombre,
    p.precio_venta,
    p.activo,
    COALESCE(SUM(i.cantidad_disponible), 0) AS stock_total,
    p.stock_minimo,
    CASE 
        WHEN COALESCE(SUM(i.cantidad_disponible), 0) <= p.stock_minimo THEN 'bajo'
        WHEN COALESCE(SUM(i.cantidad_disponible), 0) = 0 THEN 'agotado'
        ELSE 'disponible'
    END AS estado_stock
FROM producto p
LEFT JOIN inventario i ON p.id_producto = i.id_producto
GROUP BY p.id_producto;

-- Vista de resumen de pedido
CREATE VIEW vista_resumen_pedido AS
SELECT 
    p.id_pedido,
    p.numero_pedido,
    p.fecha_pedido,
    p.estado,
    p.estado_pago,
    p.total,
    p.tipo_venta,
    c.razon_social AS cliente,
    c.dni,
    COUNT(pd.id_detalle) AS total_items,
    SUM(pd.cantidad) AS total_producto
FROM pedido p
LEFT JOIN cliente c ON p.id_cliente = c.id_cliente
LEFT JOIN pedido_detalle pd ON p.id_pedido = pd.id_pedido
GROUP BY p.id_pedido;

-- ==================== DATOS INICIALES COMPLETOS ====================

-- ========== usuario ==========
INSERT INTO usuario (nombre_completo, email, password_hash, tipo_usuario, estado) VALUES
('Carlos Administrador', 'admin@tienda.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrador', 'activo'),
('María Vendedora', 'maria.vendedora@tienda.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vendedor', 'activo'),
('Juan Técnico', 'juan.tecnico@tienda.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tecnico', 'activo'),
('Ana Cliente', 'ana.cliente@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cliente', 'activo'),
('Pedro Ramírez', 'pedro.ramirez@hotmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cliente', 'activo'),
('Lucía Corporativa', 'lucia.torres@empresa.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cliente', 'activo');

-- ========== permiso ==========
INSERT INTO permiso (nombre, descripcion, modulo) VALUES
('ver_dashboard', 'Ver dashboard principal', 'dashboard'),
('gestionar_producto', 'Crear, editar y eliminar producto', 'producto'),
('gestionar_inventario', 'Administrar inventario y movimientos', 'inventario'),
('gestionar_pedido', 'Ver y gestionar pedido', 'pedido'),
('gestionar_cliente', 'Administrar base de cliente', 'cliente'),
('ver_reportes', 'Acceso a reportes y estadísticas', 'reportes'),
('configurar_sistema', 'Configuración general del sistema', 'configuracion'),
('usar_pos', 'Acceso al punto de venta', 'pos');

-- ========== usuario_permiso ==========
INSERT INTO usuario_permiso (id_usuario, id_permiso) VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7), (1, 8),
(2, 1), (2, 4), (2, 5), (2, 8),
(3, 1), (3, 2), (3, 3);

-- ========== cliente ==========
INSERT INTO cliente (id_usuario, tipo_cliente, razon_social, ruc, dni, telefono, direccion_fiscal, descuento_especial, limite_credito) VALUES
(4, 'retail', NULL, NULL, '72345678', '987654321', 'Av. Los Olivos 123, San Juan de Lurigancho', 0.00, 0.00),
(5, 'mayorista', 'Comercial Ramírez SAC', '20345678901', '45678901', '965432187', 'Jr. Comercio 456, La Victoria', 10.00, 5000.00),
(6, 'corporativo', 'Soluciones Tecnológicas Corp', '20456789012', '56789012', '998877665', 'Av. Javier Prado 789, San Isidro', 15.00, 15000.00);

-- ========== CATEGORÍAS ==========
INSERT INTO categoria (nombre, slug, descripcion, id_categoria_padre, orden, activo) VALUES
('Computadoras', 'computadoras', 'Laptops, PCs de escritorio y todo en uno', NULL, 1, TRUE),
('Componentes', 'componentes', 'Hardware y componentes internos', NULL, 2, TRUE),
('Periféricos', 'perifericos', 'Dispositivos externos y accesorios', NULL, 3, TRUE),
('Redes', 'redes', 'Equipos de red y conectividad', NULL, 4, TRUE),
('Laptops', 'laptops', 'Computadoras portátiles', 1, 1, TRUE),
('PC Escritorio', 'pc-escritorio', 'Computadoras de escritorio', 1, 2, TRUE),
('Procesadores', 'procesadores', 'CPUs Intel y AMD', 2, 1, TRUE),
('Memorias RAM', 'memorias-ram', 'Módulos de memoria', 2, 2, TRUE),
('Almacenamiento', 'almacenamiento', 'Discos duros y SSDs', 2, 3, TRUE),
('Monitores', 'monitores', 'Pantallas y displays', 3, 1, TRUE),
('Teclados', 'teclados', 'Teclados mecánicos y de membrana', 3, 2, TRUE),
('Mouse', 'mouse', 'Ratones gaming y oficina', 3, 3, TRUE);

-- ========== marca ==========
INSERT INTO marca (nombre, slug, descripcion, activo) VALUES
('Intel', 'intel', 'Procesadores y componentes Intel', TRUE),
('AMD', 'amd', 'Procesadores y tarjetas gráficas AMD', TRUE),
('ASUS', 'asus', 'Laptops, placas y periféricos', TRUE),
('HP', 'hp', 'Computadoras y periféricos HP', TRUE),
('Lenovo', 'lenovo', 'Laptops y equipos empresariales', TRUE),
('Kingston', 'kingston', 'Memorias y almacenamiento', TRUE),
('Logitech', 'logitech', 'Periféricos y accesorios', TRUE),
('Dell', 'dell', 'Computadoras y monitores Dell', TRUE),
('Samsung', 'samsung', 'Monitores y almacenamiento', TRUE),
('TP-Link', 'tp-link', 'Equipos de red', TRUE);

-- ========== proveedor ==========
INSERT INTO proveedor (razon_social, ruc, contacto, telefono, email, direccion, activo) VALUES
('Distribuidora Tech Lima SAC', '20123456789', 'Roberto Flores', '945123456', 'ventas@techlima.com', 'Av. Argentina 1234, Lima', TRUE),
('Importaciones Digitales EIRL', '20234567890', 'Carmen López', '956234567', 'contacto@impdigitales.com', 'Jr. Paruro 567, Centro de Lima', TRUE),
('Mayorista PC Store SAC', '20345678901', 'Miguel Ángel Torres', '967345678', 'compras@pcstore.pe', 'Av. Aviación 890, San Borja', TRUE);

-- ========== almacen ==========
INSERT INTO almacen (nombre, direccion, responsable, telefono, activo) VALUES
('Almacén Principal', 'Av. Industrial 1500, Ate', 'Carlos Ramírez', '987654321', TRUE),
('Almacén Centro', 'Jr. Azángaro 345, Cercado de Lima', 'María González', '965432187', TRUE),
('Almacén San Juan', 'Av. Próceres 890, SJL', 'José Pérez', '998877665', TRUE);

-- ========== producto ==========
INSERT INTO producto (sku, codigo_interno, nombre, slug, descripcion_corta, descripcion_larga, ficha_tecnica, modelo, id_marca, id_categoria, precio_base, precio_venta, costo_unitario, stock_minimo, peso, garantia_meses, destacado, en_oferta, activo) VALUES
('LAP-HP-001', 'HP-PAVILION-15', 'Laptop HP Pavilion 15-eg2001la', 'laptop-hp-pavilion-15-eg2001la', 'Laptop con procesador Intel Core i5, 8GB RAM, 512GB SSD', 
'Laptop HP Pavilion 15.6" con procesador Intel Core i5-1235U de 12va generación, 8GB de memoria RAM DDR4, disco sólido SSD de 512GB, pantalla FHD, teclado retroiluminado. Ideal para trabajo, estudio y entretenimiento.', 
'Procesador: Intel Core i5-1235U | RAM: 8GB DDR4 | Almacenamiento: 512GB SSD | Pantalla: 15.6" FHD | Sistema: Windows 11 Home | Peso: 1.75kg', 
'15-eg2001la', 4, 5, 2200.00, 2899.00, 2100.00, 3, 1.75, 12, TRUE, FALSE, TRUE),

('LAP-LEN-002', 'LEN-IP3-14', 'Laptop Lenovo IdeaPad 3 14"', 'laptop-lenovo-ideapad-3-14', 'Laptop compacta Ryzen 5, 16GB RAM, 512GB SSD', 
'Lenovo IdeaPad 3 con procesador AMD Ryzen 5 5500U, 16GB de RAM, 512GB SSD NVMe, pantalla 14" FHD antirreflejos. Perfecta para productividad y multitarea.', 
'Procesador: AMD Ryzen 5 5500U | RAM: 16GB DDR4 | Almacenamiento: 512GB NVMe SSD | Pantalla: 14" FHD | Sistema: Windows 11 Home | Peso: 1.4kg', 
'IdeaPad 3 14', 5, 5, 1800.00, 2499.00, 1700.00, 5, 1.40, 12, TRUE, TRUE, TRUE),

('CPU-INT-001', 'INT-I7-13700K', 'Procesador Intel Core i7-13700K', 'procesador-intel-core-i7-13700k', 'CPU Intel 13va Gen, 16 núcleos, hasta 5.4GHz', 
'Procesador Intel Core i7-13700K de 13va generación con 16 núcleos (8P+8E), 24 hilos, frecuencia turbo de hasta 5.4GHz. Socket LGA1700. Ideal para gaming extremo y creación de contenido.', 
'Núcleos: 16 (8P+8E) | Hilos: 24 | Frecuencia Base: 3.4GHz | Turbo: 5.4GHz | Socket: LGA1700 | TDP: 125W | Caché: 30MB', 
'Core i7-13700K', 1, 7, 1800.00, 2199.00, 1700.00, 8, 0.15, 36, TRUE, FALSE, TRUE),

('RAM-KIN-001', 'KIN-FUR-32GB', 'Kingston Fury Beast DDR4 32GB (2x16GB)', 'kingston-fury-beast-ddr4-32gb', 'Memoria RAM DDR4 3200MHz RGB', 
'Kit de memoria Kingston Fury Beast DDR4 32GB (2x16GB) a 3200MHz con iluminación RGB infrarroja. Latencia CL16. Compatible con Intel XMP. Ideal para gaming y estaciones de trabajo.', 
'Capacidad: 32GB (2x16GB) | Tipo: DDR4 | Frecuencia: 3200MHz | Latencia: CL16 | Voltaje: 1.35V | RGB: Si', 
'KF432C16BBAK2/32', 6, 8, 380.00, 549.00, 350.00, 10, 0.08, 24, FALSE, FALSE, TRUE),

('SSD-KIN-001', 'KIN-NV2-1TB', 'Kingston NV2 SSD 1TB NVMe M.2', 'kingston-nv2-ssd-1tb-nvme', 'SSD NVMe Gen4 hasta 3500MB/s', 
'Disco de estado sólido Kingston NV2 de 1TB con interfaz PCIe 4.0 NVMe M.2. Velocidades de lectura hasta 3500MB/s y escritura 2100MB/s. Formato M.2 2280.', 
'Capacidad: 1TB | Interfaz: PCIe 4.0 NVMe | Factor: M.2 2280 | Lectura: 3500MB/s | Escritura: 2100MB/s', 
'SNV2S/1000G', 6, 9, 280.00, 389.00, 250.00, 15, 0.05, 36, TRUE, FALSE, TRUE),

('MON-SAM-001', 'SAM-24-FHD', 'Monitor Samsung 24" FHD 75Hz', 'monitor-samsung-24-fhd-75hz', 'Monitor Full HD IPS 75Hz', 
'Monitor Samsung de 24 pulgadas con resolución Full HD 1920x1080, panel IPS, tasa de refresco de 75Hz, AMD FreeSync. HDMI y VGA. Ideal para oficina y gaming casual.', 
'Tamaño: 24" | Resolución: 1920x1080 FHD | Panel: IPS | Refresco: 75Hz | Conectividad: HDMI, VGA | Soporte VESA', 
'LF24T350FHL', 9, 10, 380.00, 549.00, 350.00, 8, 3.20, 24, FALSE, FALSE, TRUE),

('TEC-LOG-001', 'LOG-G213-RGB', 'Teclado Logitech G213 Prodigy RGB', 'teclado-logitech-g213-prodigy', 'Teclado gaming RGB resistente a salpicaduras', 
'Teclado Logitech G213 Prodigy con iluminación RGB personalizable, teclas de membrana de alto rendimiento, resistente a derrames, reposamanos integrado. Español Latino.', 
'Tipo: Membrana | Iluminación: RGB | Idioma: Español | Resistente: Salpicaduras | Conexión: USB', 
'G213', 7, 11, 150.00, 219.00, 130.00, 12, 1.00, 24, FALSE, FALSE, TRUE),

('MOU-LOG-001', 'LOG-G502-HERO', 'Mouse Logitech G502 HERO Gaming', 'mouse-logitech-g502-hero', 'Mouse gaming 25600 DPI ajustable', 
'Mouse gaming Logitech G502 HERO con sensor HERO 25K de hasta 25,600 DPI, 11 botones programables, sistema de pesos ajustable, iluminación RGB. Cable USB.', 
'Sensor: HERO 25K | DPI: 100-25600 | Botones: 11 programables | Iluminación: RGB | Conexión: USB | Pesos: Ajustables', 
'G502 HERO', 7, 12, 180.00, 269.00, 160.00, 15, 0.12, 24, TRUE, FALSE, TRUE);

-- ========== producto_imagen ==========
INSERT INTO producto_imagen (id_producto, url_imagen, orden, es_principal) VALUES
(1, '/images/producto/hp-pavilion-15-front.jpg', 1, TRUE),
(1, '/images/producto/hp-pavilion-15-side.jpg', 2, FALSE),
(2, '/images/producto/lenovo-ideapad-3-front.jpg', 1, TRUE),
(2, '/images/producto/lenovo-ideapad-3-open.jpg', 2, FALSE),
(3, '/images/producto/intel-i7-13700k-box.jpg', 1, TRUE),
(4, '/images/producto/kingston-fury-ram.jpg', 1, TRUE),
(5, '/images/producto/kingston-nv2-ssd.jpg', 1, TRUE),
(6, '/images/producto/samsung-monitor-24.jpg', 1, TRUE),
(7, '/images/producto/logitech-g213.jpg', 1, TRUE),
(8, '/images/producto/logitech-g502.jpg', 1, TRUE);

-- ========== PRECIOS_POR_CANTIDAD ==========
INSERT INTO precios_por_cantidad (id_producto, cantidad_minima, cantidad_maxima, precio_unitario, activo) VALUES
(1, 1, 2, 2899.00, TRUE),
(1, 3, 5, 2799.00, TRUE),
(1, 6, NULL, 2699.00, TRUE),
(4, 1, 4, 549.00, TRUE),
(4, 5, 9, 519.00, TRUE),
(4, 10, NULL, 489.00, TRUE),
(7, 1, 5, 219.00, TRUE),
(7, 6, NULL, 199.00, TRUE);

-- ========== PRECIOS_CLIENTE_TIPO ==========
INSERT INTO precios_cliente_tipo (id_producto, tipo_cliente, precio_especial, activo, fecha_inicio, fecha_fin) VALUES
(1, 'mayorista', 2599.00, TRUE, '2025-01-01', '2025-12-31'),
(1, 'corporativo', 2499.00, TRUE, '2025-01-01', '2025-12-31'),
(3, 'mayorista', 1999.00, TRUE, '2025-01-01', '2025-12-31'),
(5, 'corporativo', 349.00, TRUE, '2025-01-01', '2025-12-31');

-- ========== INVENTARIO ==========
INSERT INTO inventario (id_producto, id_almacen, cantidad_actual, cantidad_reservada, ubicacion) VALUES
(1, 1, 15, 2, 'A1-E3-N2'),
(1, 2, 8, 1, 'B2-E1-N1'),
(2, 1, 22, 3, 'A1-E3-N3'),
(2, 3, 12, 0, 'C1-E2-N1'),
(3, 1, 35, 5, 'A2-E1-N2'),
(3, 2, 18, 2, 'B1-E2-N3'),
(4, 1, 45, 8, 'A3-E2-N1'),
(5, 1, 60, 10, 'A3-E3-N2'),
(5, 2, 25, 3, 'B2-E3-N1'),
(6, 1, 28, 4, 'A4-E1-N2'),
(7, 1, 50, 5, 'A5-E2-N1'),
(7, 3, 30, 2, 'C2-E1-N2'),
(8, 1, 40, 6, 'A5-E3-N1');

-- ========== MOVIMIENTOS_INVENTARIO ==========
INSERT INTO movimientos_inventario (id_producto, id_almacen, tipo_movimiento, cantidad, cantidad_anterior, cantidad_nueva, motivo, id_usuario, id_proveedor, costo_unitario, numero_documento) VALUES
(1, 1, 'entrada', 20, 0, 20, 'Compra inicial', 1, 1, 2100.00, 'FC-001-2025'),
(2, 1, 'entrada', 25, 0, 25, 'Compra inicial', 1, 1, 1700.00, 'FC-001-2025'),
(3, 1, 'entrada', 40, 0, 40, 'Compra proveedor', 1, 2, 1700.00, 'FC-045-2025'),
(4, 1, 'entrada', 50, 0, 50, 'Stock inicial', 1, 2, 350.00, 'FC-046-2025'),
(5, 1, 'entrada', 70, 0, 70, 'Compra mayorista', 1, 3, 250.00, 'FC-089-2025'),
(1, 1, 'salida', 5, 20, 15, 'Venta tienda', 2, NULL, NULL, 'PED-001'),
(2, 1, 'salida', 3, 25, 22, 'Venta online', 2, NULL, NULL, 'PED-002'),
(3, 1, 'ajuste', -5, 40, 35, 'Ajuste por inventario físico', 3, NULL, NULL, 'AJ-001');

-- ========== pedido ==========
INSERT INTO pedido (numero_pedido, id_cliente, id_usuario, tipo_venta, estado, subtotal, descuento, envio, total, metodo_pago, estado_pago, comprobante_tipo, comprobante_serie, comprobante_numero, notas_cliente) VALUES
('PED-2025-00001', 1, 4, 'online', 'entregado', 2899.00, 0.00, 25.00, 2924.00, 'yape', 'pagado', 'boleta', 'B001', '00000001', 'Entrega en horario de oficina'),
('PED-2025-00002', 2, 5, 'tienda', 'entregado', 8697.00, 869.70, 0.00, 7827.30, 'transferencia', 'pagado', 'factura', 'F001', '00000001', 'Pago en dos partes'),
('PED-2025-00003', 3, 6, 'online', 'procesando', 21540.00, 3231.00, 50.00, 18359.00, 'credito', 'pendiente', 'factura', 'F001', '00000002', 'Envío a oficina principal'),
('PED-2025-00004', 1, 4, 'online', 'enviado', 549.00, 0.00, 15.00, 564.00, 'tarjeta', 'pagado', 'boleta', 'B001', '00000002', NULL),
('PED-2025-00005', NULL, 2, 'tienda', 'entregado', 488.00, 0.00, 0.00, 488.00, 'efectivo', 'pagado', 'ticket', 'T001', '00000001', 'Compra sin registro');

-- ========== pedido_detalle ==========     
INSERT INTO pedido_detalle (id_pedido, id_producto, nombre_producto, sku, cantidad, precio_unitario, descuento_unitario, subtotal, id_almacen) VALUES
(1, 1, 'Laptop HP Pavilion 15-eg2001la', 'LAP-HP-001', 1, 2899.00, 0.00, 2899.00, 1),
(2, 2, 'Laptop Lenovo IdeaPad 3 14"', 'LAP-LEN-002', 3, 2899.00, 289.90, 8697.00, 1),
(3, 1, 'Laptop HP Pavilion 15-eg2001la', 'LAP-HP-001', 10, 2699.00, 269.90, 26990.00, 1),
(3, 5, 'Kingston NV2 SSD 1TB NVMe M.2', 'SSD-KIN-001', 10, 389.00, 38.90, 3890.00, 1),                                                      
(4, 4, 'Kingston Fury Beast DDR4 32GB (2x16GB)', 'RAM-KIN-001', 1, 549.00, 0.00, 549.00, 1),
(5, 7, 'Teclado Logitech G213 Prodigy RGB', 'TEC-LOG-001', 1, 219.00, 0.00, 219.00, 1),
(5, 8, 'Mouse Logitech G502 HERO Gaming', 'MOU-LOG-001', 1, 269.00, 0.00, 269.00, 1);

-- ========== envio ==========
INSERT INTO envio (id_pedido, tipo_entrega, destinatario, dni, telefono, direccion, distrito, provincia, departamento, referencia, fecha_estimada, codigo_seguimiento, transportadora, costo_envio, fecha_envio, fecha_entrega, receptor_nombre, receptor_dni) VALUES
(1, 'domicilio', 'Ana Cliente', '72345678', '987654321', 'Av. Los Olivos 123', 'San Juan de Lurigancho', 'Lima', 'Lima', 'Casa color verde, segundo piso', '2025-11-10', 'OLVA-2025-1234', 'Olva Courier', 25.00, '2025-11-08 10:30:00', '2025-11-10 14:20:00', 'Ana Cliente', '72345678'),
(3, 'domicilio', 'Lucía Torres', '56789012', '998877665', 'Av. Javier Prado 789', 'San Isidro', 'Lima', 'Lima', 'Oficina 501, Edificio corporativo', '2025-11-18', NULL, NULL, 50.00, NULL, NULL, NULL, NULL),
(4, 'recojo_agencia', 'Ana Cliente', '72345678', '987654321', 'Agencia Olva - Av. Próceres', 'San Juan de Lurigancho', 'Lima', 'Lima', NULL, '2025-11-12', 'OLVA-2025-5678', 'Olva Courier', 15.00, '2025-11-10 08:00:00', NULL, NULL, NULL);

-- ========== pago ==========
INSERT INTO pago (id_pedido, metodo_pago, monto, estado, referencia_externa, numero_operacion, banco, comprobante_imagen, notas) VALUES
(1, 'yape', 2924.00, 'aprobado', 'YAPE-987654321-20251108', '987654321', 'BCP', '/comprobantes/yape_20251108_001.jpg', 'Pago confirmado automáticamente'),
(2, 'transferencia', 7827.30, 'aprobado', NULL, '002-456789123', 'Interbank', '/comprobantes/trans_20251108_002.jpg', 'Transferencia verificada manualmente'),
(4, 'tarjeta', 564.00, 'aprobado', 'VISA-4532********1234-AUTH789', NULL, 'BCP', NULL, 'Pago con tarjeta Visa'),
(5, 'efectivo', 488.00, 'aprobado', NULL, NULL, NULL, NULL, 'Pago en efectivo, venta en tienda');

-- ========== cupon ==========
INSERT INTO cupon (codigo, descripcion, tipo_descuento, valor_descuento, monto_minimo, fecha_inicio, fecha_fin, usos_maximos, usos_actuales, activo) VALUES
('BIENVENIDO10', 'Descuento de bienvenida para nuevos cliente', 'porcentaje', 10.00, 500.00, '2025-01-01', '2025-12-31', 100, 5, TRUE),
('BLACK2025', 'Black Friday 2025 - 20% de descuento', 'porcentaje', 20.00, 1000.00, '2025-11-28', '2025-11-30', 500, 0, TRUE),
('NAVIDAD50', 'Descuento de 50 soles en compras mayores', 'monto_fijo', 50.00, 1500.00, '2025-12-01', '2025-12-25', 200, 0, TRUE);

-- ========== CUPON_producto ==========
INSERT INTO cupon_producto (id_cupon, id_producto, id_categoria) VALUES
(1, NULL, 5),
(1, NULL, 6),
(2, NULL, NULL),
(3, 1, NULL),
(3, 2, NULL);

-- ========== banner ==========
INSERT INTO banner (titulo, subtitulo, imagen_desktop, imagen_mobile, enlace, orden, activo, fecha_inicio, fecha_fin) VALUES
('Gran Venta de Fin de Año', 'Descuentos de hasta 50% en productos seleccionados', '/banners/fin_de_ano_desktop.jpg', '/banners/fin_de_ano_mobile.jpg', '/ofertas/fin-de-ano', 1, TRUE, '2025-12-01', '2025-12-31'),
('Nuevos Lanzamientos de Laptops', 'Explora las últimas novedades en tecnología portátil', '/banners/nuevas_laptops_desktop.jpg', '/banners/nuevas_laptops_mobile.jpg', '/productos/laptops/nuevas', 2, TRUE, '2025-11-15', '2026-01-15'),
('Ofertas en Componentes de PC', 'Actualiza tu PC con descuentos exclusivos en componentes', '/banners/ofertas_componentes_desktop.jpg', '/banners/ofertas_componentes_mobile.jpg', '/ofertas/componentes-pc', 3, TRUE, '2025-11-01', '2025-11-30');
;('¡Black Friday 2025!', 'Hasta 30'); 

-- =====================================================
-- AÑADIDO: MÓDULO CARRITO INTEGRADO
-- =====================================================

-- =====================================================
-- MÓDULO ADICIONAL: CARRITO DE COMPRAS (Integración)
-- =====================================================

 TABLA: carrito (carrito por cliente o por sesión)
CREATE TABLE  carrito (
    id_carrito INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT NULL,
    session_token VARCHAR(100) NULL COMMENT 'Token para cliente invitado (cookie)',
    estado ENUM('activo','convertido','abandonado') NOT NULL DEFAULT 'activo',
    subtotal DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    descuento DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente) ON DELETE SET NULL,
    UNIQUE KEY unique_cliente_activo (id_cliente, estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA: carrito_detalles (una fila por producto; cantidad acumulada)
CREATE TABLE IF NOT EXISTS carrito_detalles (
    id_detalle INT PRIMARY KEY AUTO_INCREMENT,
    id_carrito INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    precio_unitario DECIMAL(10,2) NOT NULL COMMENT 'Precio tomado al momento de agregar/actualizar',
    subtotal DECIMAL(12,2) GENERATED ALWAYS AS (cantidad * precio_unitario) STORED,
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_carrito) REFERENCES carrito(id_carrito) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE RESTRICT,
    UNIQUE KEY unique_carrito_producto (id_carrito, id_producto),
    INDEX idx_producto (id_producto)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- PROCEDIMIENTO: recalcular totales del carrito
DROP PROCEDURE IF EXISTS sp_recalcular_carrito;
DELIMITER $$
CREATE PROCEDURE sp_recalcular_carrito(IN p_id_carrito INT)
BEGIN
    DECLARE v_subtotal DECIMAL(12,2) DEFAULT 0.00;
    SELECT IFNULL(SUM(subtotal),0) INTO v_subtotal
    FROM carrito_detalles
    WHERE id_carrito = p_id_carrito;

    UPDATE carrito
    SET subtotal = v_subtotal,
        total = v_subtotal - IFNULL(descuento,0)
    WHERE id_carrito = p_id_carrito;
END$$
DELIMITER ;

-- PROCEDIMIENTO: agregar o incrementar un producto en el carrito
DROP PROCEDURE IF EXISTS sp_add_to_cart;
DELIMITER $$
CREATE PROCEDURE sp_add_to_cart(
    IN p_id_carrito INT,
    IN p_id_producto INT,
    IN p_cantidad INT
)
BEGIN
    DECLARE v_existe INT DEFAULT 0;
    DECLARE v_precio DECIMAL(10,2);

    IF p_cantidad <= 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La cantidad debe ser mayor a 0';
    END IF;

    SELECT precio_venta INTO v_precio FROM productos WHERE id_producto = p_id_producto LIMIT 1;
    IF v_precio IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Producto no encontrado';
    END IF;

    SELECT COUNT(*) INTO v_existe
    FROM carrito_detalles
    WHERE id_carrito = p_id_carrito AND id_producto = p_id_producto;

    IF v_existe > 0 THEN
        UPDATE carrito_detalles
        SET cantidad = cantidad + p_cantidad,
            precio_unitario = v_precio,
            fecha_actualizacion = CURRENT_TIMESTAMP
        WHERE id_carrito = p_id_carrito AND id_producto = p_id_producto;
    ELSE
        INSERT INTO carrito_detalles (id_carrito, id_producto, cantidad, precio_unitario)
        VALUES (p_id_carrito, p_id_producto, p_cantidad, v_precio);
    END IF;

    CALL sp_recalcular_carrito(p_id_carrito);
END$$
DELIMITER ;


-- PROCEDIMIENTO: establecer cantidad (set) en un detalle del carrito
DROP PROCEDURE IF EXISTS sp_set_carrito_cantidad;
DELIMITER $$
CREATE PROCEDURE sp_set_carrito_cantidad(
    IN p_id_detalle INT,
    IN p_nueva_cantidad INT
)
BEGIN
    DECLARE v_id_carrito INT;

    SELECT id_carrito INTO v_id_carrito FROM carrito_detalles WHERE id_detalle = p_id_detalle;
    IF v_id_carrito IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Detalle no encontrado';
    END IF;

    IF p_nueva_cantidad < 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cantidad inválida';
    END IF;

    IF p_nueva_cantidad = 0 THEN
        DELETE FROM carrito_detalles WHERE id_detalle = p_id_detalle;
    ELSE
        UPDATE carrito_detalles
        SET cantidad = p_nueva_cantidad,
            fecha_actualizacion = CURRENT_TIMESTAMP
        WHERE id_detalle = p_id_detalle;
    END IF;

    CALL sp_recalcular_carrito(v_id_carrito);
END$$
DELIMITER ;

-- PROCEDIMIENTO: convertir carrito a pedido (básico, snapshot)
DROP PROCEDURE IF EXISTS sp_convertir_carrito_a_pedido;
DELIMITER $$
CREATE PROCEDURE sp_convertir_carrito_a_pedido(
    IN p_id_carrito INT,
    IN p_id_cliente INT,
    IN p_id_usuario INT,
    IN p_tipo_venta VARCHAR(20),
    IN p_metodo_pago VARCHAR(20),
    OUT p_id_pedido INT
)
BEGIN
    DECLARE v_subtotal DECIMAL(12,2) DEFAULT 0.00;
    DECLARE v_descuento DECIMAL(12,2) DEFAULT 0.00;
    DECLARE v_total DECIMAL(12,2) DEFAULT 0.00;

    SELECT IFNULL(SUM(cantidad * precio_unitario),0) INTO v_subtotal FROM carrito_detalles WHERE id_carrito = p_id_carrito;
    SELECT IFNULL(descuento,0) INTO v_descuento FROM carrito WHERE id_carrito = p_id_carrito;
    SET v_total = v_subtotal - v_descuento;

    START TRANSACTION;

    INSERT INTO pedidos (numero_pedido, id_cliente, id_usuario, tipo_venta, estado, subtotal, descuento, envio, total, metodo_pago, estado_pago)
    VALUES (CONCAT('PED-', DATE_FORMAT(NOW(),'%Y%m%d'), '-', LPAD(FLOOR(RAND()*99999),5,'0')),
            p_id_cliente, p_id_usuario, p_tipo_venta, 'pendiente', v_subtotal, v_descuento, 0.00, v_total, p_metodo_pago, 'pendiente');

    SET p_id_pedido = LAST_INSERT_ID();

    INSERT INTO pedido_detalles (id_pedido, id_producto, nombre_producto, sku, cantidad, precio_unitario, descuento_unitario, subtotal, id_almacen)
    SELECT p_id_pedido, cd.id_producto, prod.nombre, prod.sku, cd.cantidad, cd.precio_unitario, 0.00, (cd.cantidad * cd.precio_unitario), 1
    FROM carrito_detalles cd
    JOIN productos prod ON prod.id_producto = cd.id_producto
    WHERE cd.id_carrito = p_id_carrito;

    UPDATE carrito SET estado = 'convertido', fecha_actualizacion = CURRENT_TIMESTAMP WHERE id_carrito = p_id_carrito;

    COMMIT;
END$$
DELIMITER ;

-- TRIGGERS: ajustar totales automáticamente
DROP TRIGGER IF EXISTS trg_carrito_detalles_after_insert;
DELIMITER $$
CREATE TRIGGER trg_carrito_detalles_after_insert
AFTER INSERT ON carrito_detalles
FOR EACH ROW
BEGIN
    CALL sp_recalcular_carrito(NEW.id_carrito);
END$$
DELIMITER ;

DROP TRIGGER IF EXISTS trg_carrito_detalles_after_update;
DELIMITER $$
CREATE TRIGGER trg_carrito_detalles_after_update
AFTER UPDATE ON carrito_detalles
FOR EACH ROW
BEGIN
    IF OLD.id_carrito IS NOT NULL AND OLD.id_carrito <> NEW.id_carrito THEN
        CALL sp_recalcular_carrito(OLD.id_carrito);
    END IF;
    CALL sp_recalcular_carrito(NEW.id_carrito);
END$$
DELIMITER ;

DROP TRIGGER IF EXISTS trg_carrito_detalles_after_delete;
DELIMITER $$
CREATE TRIGGER trg_carrito_detalles_after_delete
AFTER DELETE ON carrito_detalles
FOR EACH ROW
BEGIN
    CALL sp_recalcular_carrito(OLD.id_carrito);
END$$
DELIMITER ;

-- VISTA: carrito consolidado (útil para la UI)
DROP VIEW IF EXISTS vista_carrito_consolidado;
CREATE VIEW vista_carrito_consolidado AS
SELECT
    c.id_carrito,
    cd.id_detalle,
    cd.id_producto,
    p.nombre AS nombre_producto,
    p.sku,
    cd.cantidad,
    cd.precio_unitario,
    cd.subtotal AS total_producto,
    (SELECT url_imagen FROM producto_imagenes WHERE id_producto = cd.id_producto AND es_principal = 1 LIMIT 1) AS imagen_principal,
    c.subtotal AS carrito_subtotal,
    c.descuento AS carrito_descuento,
    c.total AS carrito_total
FROM carrito_detalles cd
JOIN carrito c ON c.id_carrito = cd.id_carrito
JOIN productos p ON p.id_producto = cd.id_producto;

-- EJEMPLOS: datos iniciales para probar el módulo carrito
-- Crear un carrito para el cliente id_cliente = 1 (si existe)
INSERT INTO carrito (id_cliente, subtotal, descuento, total)
VALUES (1, 0.00, 0.00, 0.00);

-- Supongamos que el id_carrito recién creado es 1 (ajusta según tu importación)
-- Agregar 2 unidades del producto id_producto = 1
CALL sp_add_to_cart(1, 1, 2);

-- Agregar 1 unidad del producto id_producto = 4
CALL sp_add_to_cart(1, 4, 1);
