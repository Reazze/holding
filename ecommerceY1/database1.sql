CREATE DATABASE wankashop;
USE wankashop;
SET sql_mode = '';

CREATE TABLE cargos (
    id INT AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE negocio (
    id INT AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE configuracion_negocio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);

CREATE TABLE cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    cargos INT, 
    FOREIGN KEY (negocio) REFERENCES negocio(id),
    FOREIGN KEY (cargos) REFERENCES cargos(id)
);

CREATE TABLE categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);   

CREATE TABLE tipomaterial (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria INT,
    negocio INT,
    FOREIGN KEY (categoria) REFERENCES categoria(id),
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);
CREATE TABLE producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    tipomaterial INT,
    FOREIGN KEY (tipomaterial) REFERENCES tipomaterial(id),
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);
  
CREATE TABLE marca (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);
CREATE TABLE unidad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);
CREATE TABLE precio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto INT,
    marca INT,
    unidad INT,
    FOREIGN KEY (producto) REFERENCES producto(id),
    FOREIGN KEY (marca) REFERENCES marca(id),
    FOREIGN KEY (unidad) REFERENCES unidad(id)
);

CREATE TABLE proveedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);

CREATE TABLE almacen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);

CREATE TABLE metodopago (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);
   
CREATE TABLE compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    proveedores INT,
    negocio INT,
    metodopago INT,
    usuario INT,
    FOREIGN KEY (proveedores) REFERENCES proveedores(id),
    FOREIGN KEY (negocio) REFERENCES negocio(id),
    FOREIGN KEY (metodopago) REFERENCES metodopago(id),
    FOREIGN KEY (usuario) REFERENCES usuario(id)
);

CREATE TABLE detallecompra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    compras INT,
    producto INT,
    almacen INT,
    precio INT,
    FOREIGN KEY (compras) REFERENCES compras(id),
    FOREIGN KEY (producto) REFERENCES producto(id),
    FOREIGN KEY (almacen) REFERENCES almacen(id),
    FOREIGN KEY (precio) REFERENCES precio(id)
);


CREATE TABLE venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
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
    FOREIGN KEY (producto) REFERENCES producto(id),
    FOREIGN KEY (pedido) REFERENCES pedido(id),
    FOREIGN KEY (almacen) REFERENCES almacen(id),
    FOREIGN KEY (precio) REFERENCES precio(id)
);

CREATE TABLE capital (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);
CREATE TABLE apertura_cierre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    usuario INT,
    FOREIGN KEY (negocio) REFERENCES negocio(id),
    FOREIGN KEY (usuario) REFERENCES usuario(id)
);

CREATE TABLE cajacentral (
    id INT AUTO_INCREMENT PRIMARY KEY,
    apertura_cierre INT,
    negocio INT,
    FOREIGN KEY (apertura_cierre) REFERENCES apertura_cierre(id),
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);


CREATE TABLE permiso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);
CREATE TABLE permisousuario (
    usuario INT,
    permiso INT,
    FOREIGN KEY (usuario) REFERENCES usuario(id),
    FOREIGN KEY (permiso) REFERENCES permiso(id)
);


CREATE TABLE tipoanuncio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);
    
CREATE TABLE anuncio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipoanuncio INT,
    FOREIGN KEY (tipoanuncio) REFERENCES tipoanuncio(id)
);

CREATE TABLE carrucel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);

CREATE TABLE nosotros ( 
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);

CREATE TABLE contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negocio INT,
    FOREIGN KEY (negocio) REFERENCES negocio(id)
);
