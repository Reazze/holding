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
    id INT AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cargos INT, 
    FOREIGN KEY (cargos) REFERENCES cargos(id)
);

CREATE TABLE categoria (
    id INT AUTO_INCREMENT PRIMARY KEY
);   

CREATE TABLE tipomaterial (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria INT,
    FOREIGN KEY (categoria) REFERENCES categoria(id)
);
CREATE TABLE producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipomaterial INT,
    FOREIGN KEY (tipomaterial) REFERENCES tipomaterial(id)
);
  
CREATE TABLE marca (
    id INT AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE unidad (
    id INT AUTO_INCREMENT PRIMARY KEY
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
    id INT AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE almacen (
    id INT AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE metodopago (
    id INT AUTO_INCREMENT PRIMARY KEY
);
   
CREATE TABLE compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    proveedores INT,
    metodopago INT,
    usuario INT,
    FOREIGN KEY (proveedores) REFERENCES proveedores(id),
    FOREIGN KEY (metodopago) REFERENCES metodopago(id),
    FOREIGN KEY (usuario) REFERENCES usuario(id)
);

CREATE TABLE detallecompra (
    id INT AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE venta (
    id INT AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE detalleventa (
    id INT AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE pedido (
    id INT AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE detallepedido (
    id INT AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE capital (
    id INT AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE apertura_cierre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario INT,
    FOREIGN KEY (usuario) REFERENCES usuario(id)
);

CREATE TABLE cajacentral (
    id INT AUTO_INCREMENT PRIMARY KEY,
    apertura_cierre INT,
    FOREIGN KEY (apertura_cierre) REFERENCES apertura_cierre(id)
);


CREATE TABLE permiso (
    id INT AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE permisousuario (
    id INT AUTO_INCREMENT PRIMARY KEY
);


CREATE TABLE tipoanuncio (
    id INT AUTO_INCREMENT PRIMARY KEY
    
);
    
CREATE TABLE anuncio (
    id INT AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE carrucel (
    id INT AUTO_INCREMENT PRIMARY KEY
    
);

CREATE TABLE nosotros ( 
    id INT AUTO_INCREMENT PRIMARY KEY
    
);

CREATE TABLE contacto (
    id INT AUTO_INCREMENT PRIMARY KEY
);
  