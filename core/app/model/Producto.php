<?php

class Producto extends Model {
    
    protected $table = 'producto';
    
    /**
     * Obtener todos los productos con sus relaciones
     */
    public function getAllWithRelations() {
        $sql = "SELECT 
                    p.*,
                    tm.nombre as tipomaterial_nombre,
                    c.nombre as categoria_nombre,
                    n.nombre as negocio_nombre
                FROM producto p
                LEFT JOIN tipomaterial tm ON p.tipomaterial = tm.id
                LEFT JOIN categoria c ON tm.categoria = c.id
                LEFT JOIN negocio n ON p.negocio = n.id
                ORDER BY p.id DESC";
        
        return $this->db->select($sql);
    }
    
    /**
     * Obtener un producto por ID con sus relaciones
     */
    public function getByIdWithRelations($id) {
        $sql = "SELECT 
                    p.*,
                    tm.nombre as tipomaterial_nombre,
                    c.nombre as categoria_nombre,
                    n.nombre as negocio_nombre
                FROM producto p
                LEFT JOIN tipomaterial tm ON p.tipomaterial = tm.id
                LEFT JOIN categoria c ON tm.categoria = c.id
                LEFT JOIN negocio n ON p.negocio = n.id
                WHERE p.id = ?";
        
        return $this->db->selectOne($sql, [$id]);
    }
    
    /**
     * Crear un nuevo producto
     */
    public function crear($data) {
        $sql = "INSERT INTO producto (
                    tipomaterial,
                    negocio,
                    nombre,
                    descripcion,
                    precio_base,
                    precio_oferta,
                    stock,
                    imagen,
                    modelo,
                    color,
                    garantia,
                    dimensiones,
                    estado,
                    codigo,
                    serie,
                    talla,
                    par,
                    peso,
                    materiales,
                    fecha_registro
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $params = [
            $data['tipomaterial'],
            $data['negocio'],
            $data['nombre'],
            $data['descripcion'] ?? null,
            $data['precio_base'],
            $data['precio_oferta'] ?? null,
            $data['stock'] ?? 0,
            $data['imagen'] ?? null,
            $data['modelo'] ?? null,
            $data['color'] ?? null,
            $data['garantia'] ?? null,
            $data['dimensiones'] ?? null,
            $data['estado'] ?? 1,
            $data['codigo'] ?? null,
            $data['serie'] ?? null,
            $data['talla'] ?? null,
            $data['par'] ?? null,
            $data['peso'] ?? null,
            $data['materiales'] ?? null
        ];
        
        $this->db->execute($sql, $params);
        return $this->db->lastInsertId();
    }
    
    /**
     * Actualizar un producto
     */
    public function actualizar($id, $data) {
        $sql = "UPDATE producto SET 
                    tipomaterial = ?,
                    negocio = ?,
                    nombre = ?,
                    descripcion = ?,
                    precio_base = ?,
                    precio_oferta = ?,
                    stock = ?,
                    imagen = ?,
                    modelo = ?,
                    color = ?,
                    garantia = ?,
                    dimensiones = ?,
                    estado = ?,
                    codigo = ?,
                    serie = ?,
                    talla = ?,
                    par = ?,
                    peso = ?,
                    materiales = ?
                WHERE id = ?";
        
        $params = [
            $data['tipomaterial'],
            $data['negocio'],
            $data['nombre'],
            $data['descripcion'] ?? null,
            $data['precio_base'],
            $data['precio_oferta'] ?? null,
            $data['stock'] ?? 0,
            $data['imagen'] ?? null,
            $data['modelo'] ?? null,
            $data['color'] ?? null,
            $data['garantia'] ?? null,
            $data['dimensiones'] ?? null,
            $data['estado'] ?? 1,
            $data['codigo'] ?? null,
            $data['serie'] ?? null,
            $data['talla'] ?? null,
            $data['par'] ?? null,
            $data['peso'] ?? null,
            $data['materiales'] ?? null,
            $id
        ];
        
        return $this->db->execute($sql, $params);
    }
    
    /**
     * Eliminar (cambiar estado) un producto
     */
    public function eliminar($id) {
        $sql = "UPDATE producto SET estado = 0 WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }
    
    /**
     * Activar producto
     */
    public function activar($id) {
        $sql = "UPDATE producto SET estado = 1 WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }
    
    /**
     * Eliminar permanentemente un producto
     */
    public function eliminarPermanente($id) {
        $sql = "DELETE FROM producto WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }
    
    /**
     * Buscar productos
     */
    public function buscar($termino) {
        $sql = "SELECT 
                    p.*,
                    tm.nombre as tipomaterial_nombre,
                    n.nombre as negocio_nombre
                FROM producto p
                LEFT JOIN tipomaterial tm ON p.tipomaterial = tm.id
                LEFT JOIN negocio n ON p.negocio = n.id
                WHERE p.nombre LIKE ? 
                   OR p.codigo LIKE ?
                   OR p.modelo LIKE ?
                   OR p.descripcion LIKE ?
                ORDER BY p.nombre";
        
        $busqueda = "%{$termino}%";
        return $this->db->select($sql, [$busqueda, $busqueda, $busqueda, $busqueda]);
    }
    
    /**
     * Obtener productos con stock bajo
     */
    public function getStockBajo($limite = 10) {
        $sql = "SELECT 
                    p.*,
                    tm.nombre as tipomaterial_nombre,
                    n.nombre as negocio_nombre
                FROM producto p
                LEFT JOIN tipomaterial tm ON p.tipomaterial = tm.id
                LEFT JOIN negocio n ON p.negocio = n.id
                WHERE p.stock <= ?
                ORDER BY p.stock ASC";
        
        return $this->db->select($sql, [$limite]);
    }
    
    /**
     * Actualizar stock
     */
    public function actualizarStock($id, $cantidad) {
        $sql = "UPDATE producto SET stock = stock + ? WHERE id = ?";
        return $this->db->execute($sql, [$cantidad, $id]);
    }
    
    /**
     * Obtener productos por negocio
     */
    public function getByNegocio($negocioId) {
        $sql = "SELECT 
                    p.*,
                    tm.nombre as tipomaterial_nombre
                FROM producto p
                LEFT JOIN tipomaterial tm ON p.tipomaterial = tm.id
                WHERE p.negocio = ?
                ORDER BY p.nombre";
        
        return $this->db->select($sql, [$negocioId]);
    }
    
    /**
     * Obtener productos por tipo de material
     */
    public function getByTipoMaterial($tipoId) {
        $sql = "SELECT 
                    p.*,
                    n.nombre as negocio_nombre
                FROM producto p
                LEFT JOIN negocio n ON p.negocio = n.id
                WHERE p.tipomaterial = ?
                ORDER BY p.nombre";
        
        return $this->db->select($sql, [$tipoId]);
    }
    
    /**
     * Contar productos por estado
     */
    public function contarPorEstado($estado = 1) {
        $sql = "SELECT COUNT(*) as total FROM producto WHERE estado = ?";
        $result = $this->db->selectOne($sql, [$estado]);
        return $result['total'] ?? 0;
    }
}