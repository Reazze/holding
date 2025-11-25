CREATE DATABASE wankashop;
USE wankashop;
SET sql_mode = '';

CREATE TABLE cargos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    estado INT DEFAULT 1
);

CREATE TABLE negocio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    dirección VARCHAR(255),
    representante VARCHAR(255),
    logo text,
    ruc VARCHAR(20),
    correo VARCHAR(255),
    teléfono VARCHAR(20),
    estado  INT DEFAULT 1
);

CREATE TABLE configuracion_negocio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dominio VARCHAR(100),
    usuariodb VARCHAR(255),
    estado boolean DEFAULT 1 ,
    negocio INT,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);

CREATE TABLE cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100),
    dni VARCHAR(20),
    telefono VARCHAR(20),
    email VARCHAR(100),
    direccion VARCHAR(200),
    fecha_registro DATETIME DEFAULT NOW(),
    FOREIGN KEY (negocio) REFERENCES negocio(id)

);

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    cargos INT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100),
    usuario VARCHAR(100),
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    telefono VARCHAR(20),
    estado boolean DEFAULT '1',
    FOREIGN KEY (negocio) REFERENCES negocio(id),
    FOREIGN KEY (cargos) REFERENCES cargos(id)
);

CREATE TABLE categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
    );   

CREATE TABLE tipomaterial (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria INT,
    negocio INT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    FOREIGN KEY (categoria) REFERENCES categoria(id),
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);
CREATE TABLE marca (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    nombre VARCHAR(100) NOT NULL, 
    descripcion TEXT
);
CREATE TABLE unidad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    nombre VARCHAR(100) NOT NULL, 
    simbolo VARCHAR(10) NOT NULL, 
    FOREIGN KEY (negocio) REFERENCES negocio(id) 
);

CREATE TABLE producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipomaterial INT,
    negocio INT,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(200),
    precio_base DECIMAL(10,2) NOT NULL,
    precio_oferta DECIMAL(10,2),
    stock INT DEFAULT 0,
    imagen VARCHAR(200),
    modelo VARCHAR(100),
    color VARCHAR(50),
    garantia VARCHAR(100),
    dimensiones VARCHAR(100),
    estado boolean DEFAULT 1,
    codigo VARCHAR(50),
    serie VARCHAR(100),
    talla VARCHAR(50),
    par VARCHAR(50),
    peso VARCHAR(50),
    materiales VARCHAR(100),
    fecha_registro DATETIME,
    
    FOREIGN KEY (tipomaterial) REFERENCES tipomaterial(id),
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);

CREATE TABLE precio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto INT,
    marca INT,
    unidad INT,
    precio_compra DECIMAL(10.2) NOT NULL,
    precio_venta DECIMAL(10,2) NOT NULL,
    fecha_inicio DATE NOT NULL DEFAULT (CURRENT_DATE),
    fecha_fin DATE,
    estado boolean DEFAULT 1,
    FOREIGN KEY (producto) REFERENCES producto(id),
    FOREIGN KEY (marca) REFERENCES marca(id),
    FOREIGN KEY (unidad) REFERENCES unidad(id)
);

CREATE TABLE proveedores (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    nombre           VARCHAR(150) NOT NULL,
    telefono         VARCHAR(30),
    email            VARCHAR(100),
    direccion        VARCHAR(200),
    ciudad           VARCHAR(100),
    pais             VARCHAR(100),
    ruc              VARCHAR(20),
    sitio_web        VARCHAR(150),
    estado boolean DEFAULT 1,
    categoria        VARCHAR(50),
    condiciones_pago VARCHAR(100),
    moneda_preferida VARCHAR(10),
    calificacion     INT,
    fecha_registro   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE almacen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    ubicacion VARCHAR(200),
    telefono VARCHAR(20),
    email VARCHAR(100),
    eestado  ENUM('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
    capacidad      DECIMAL(10,2),
    tipo_almacen  VARCHAR(50),
    observaciones TEXT,
    fecha datetime
);

CREATE TABLE metodopago (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    proveedores int,
    metodopago int,
    usuario int,
    codigo varchar(100),
    descuento float,
    igv float,
    subtotal float,
    total float,
    fecha datetime,
    estado boolean DEFAULT 0,
    FOREIGN KEY (proveedores) REFERENCES proveedores(id),
    FOREIGN KEY (metodopago) REFERENCES metodopago(id),
    FOREIGN KEY (usuario) REFERENCES usuario(id)
);
CREATE TABLE detallecompra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    compras INT,
    producto INT,
    almacen INT,
    precio INT,
    cantidad float,
    igv float,
    subtotal float,
    FOREIGN KEY (compras) REFERENCES compras(id),
    FOREIGN KEY (producto) REFERENCES producto(id),
    FOREIGN KEY (almacen) REFERENCES almacen(id),
    FOREIGN KEY (precio) REFERENCES precio(id)
);

CREATE TABLE venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descuentos DECIMAL(5, 2),       
    fecha_venta DATETIME NOT NULL,
    codigo VARCHAR(50) UNIQUE,
    subtotal float,       
    total float,
    igv float,
    descuento float,
    metodopago INT,
    cliente INT,
    negocio INT,
    usuario INT,
    FOREIGN KEY (metodopago) REFERENCES metodopago(id),
    FOREIGN KEY (cliente) REFERENCES cliente(id),
    FOREIGN KEY (negocio) REFERENCES negocio(id),
    FOREIGN KEY (usuario) REFERENCES usuario(id)
);

CREATE TABLE detalleventa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subtotal float ,
    igv  float,
    cantidad float,
    venta INT,
    producto INT,
    precio INT,
    almacen INT,
    FOREIGN KEY (venta) REFERENCES venta(id),
    FOREIGN KEY (producto) REFERENCES producto(id),
    FOREIGN KEY (precio) REFERENCES precio(id),
    FOREIGN KEY (almacen) REFERENCES almacen(id)
);

CREATE TABLE pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
 	codigo VARCHAR(50) UNIQUE,
    subtotal float,       
    total float,
    igv float,
    descuento float,
   	cliente INT,
    negocio INT,
    usuario INT,
    metodopago INT,
    FOREIGN KEY (cliente) REFERENCES cliente(id),
    FOREIGN KEY (negocio) REFERENCES negocio(id),
    FOREIGN KEY (usuario) REFERENCES usuario(id),
    FOREIGN KEY (metodopago) REFERENCES metodopago(id)
    
 
);
CREATE TABLE detallepedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto INT,
    pedido INT,
    almacen INT,
    precio INT,
    subtotal float ,
    igv  float,
    cantidad float,
    FOREIGN KEY (producto) REFERENCES producto(id),
    FOREIGN KEY (pedido) REFERENCES pedido(id),
    FOREIGN KEY (almacen) REFERENCES almacen(id),
    FOREIGN KEY (precio) REFERENCES precio(id)
);
    

    

CREATE TABLE capital (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    monto_inicial float,
    monto_actual float,
    descripcion VARCHAR(200),
    responsable VARCHAR(100),
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);

CREATE TABLE apertura_cierre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    usuario INT,
    total float,
    fecha_apertura DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_cierre DATETIME,
    saldo_inicial float,
    saldo_final float,
    FOREIGN KEY (negocio) REFERENCES negocio(id),
    FOREIGN KEY (usuario) REFERENCES usuario(id)
);

CREATE TABLE cajacentral (
    id INT AUTO_INCREMENT PRIMARY KEY,
    apertura_cierre INT,
    monto  float,
    FOREIGN KEY (apertura_cierre) REFERENCES apertura_cierre(id)
);
CREATE TABLE permiso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR (255),
    descripcion VARCHAR (255)
);

CREATE TABLE permisousuario (
    usuario INT,
    permiso INT,
    FOREIGN KEY (usuario) REFERENCES usuario(id),
    FOREIGN KEY (permiso) REFERENCES permiso(id)
);


CREATE TABLE tipoanuncio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,        
    descripcion VARCHAR(200),           
    estado boolean DEFAULT 1
);  
CREATE TABLE anuncio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255),
    titulo VARCHAR(100),      
    descripcion TEXT,                   
    imagen VARCHAR(200),                 
    inicio DATETIME   ,       
    fin DATETIME,                      
    estado boolean DEFAULT 1, 
    tipoanuncio INT,                 
    FOREIGN KEY (tipoanuncio) REFERENCES tipoanuncio(id)
);
CREATE TABLE carrucel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,           
    descripcion VARCHAR(255),              
    imagen VARCHAR(200) NOT NULL,           
    enlace VARCHAR(200),                    
    orden INT DEFAULT 0,                    
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo', 
    fecha_inicio DATE,                     
    fecha_fin DATE                          
);

CREATE TABLE nosotros ( 
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100),         
    descripcion TEXT,            
    mision TEXT,
    vision TEXT,
    valores TEXT,
    imagen_portada VARCHAR(255)
);

CREATE TABLE contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contacto VARCHAR(100),   
    correo VARCHAR(100),            
    telefono VARCHAR(20),
    direccion TEXT,
    ciudad VARCHAR(100),
    horario_atencion VARCHAR(100), 
    mensaje_bienvenida TEXT,
    facebook TEXT(30),
    instagram TEXT(30),
    twitter TEXT(30),
    linkedin TEXT(30),
    whatsapp TEXT(30),
    youtube TEXT(30),
    tiktok TEXT(30),      
    fecha_actualizacion DATETIME
);
  