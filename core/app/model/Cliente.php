<?php

class Cliente extends Model {
    
    protected $table = 'cliente';
    
    /**
     * Obtener todos los clientes con su negocio
     */
    public function getAllWithRelations() {
        $sql = "SELECT 
                    c.*,
                    n.nombre as negocio_nombre
                FROM cliente c
                LEFT JOIN negocio n ON c.negocio = n.id
                ORDER BY c.id DESC";
        
        return $this->db->select($sql);
    }
    
    /**
     * Obtener un cliente por ID con relaciones
     */
    public function getByIdWithRelations($id) {
        $sql = "SELECT 
                    c.*,
                    n.nombre as negocio_nombre
                FROM cliente c
                LEFT JOIN negocio n ON c.negocio = n.id
                WHERE c.id = ?";
        
        return $this->db->selectOne($sql, [$id]);
    }
    
    /**
     * Crear un nuevo cliente
     */
    public function crear($data) {
        $sql = "INSERT INTO cliente (
                    negocio,
                    nombres,
                    apellido_paterno,
                    apellido_materno,
                    dni,
                    telefono,
                    email,
                    fecha_nacimiento,
                    direccion,
                    genero,
                    fecha_registro
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $params = [
            $data['negocio'],
            $data['nombres'],
            $data['apellido_paterno'] ?? null,
            $data['apellido_materno'] ?? null,
            $data['dni'],
            $data['telefono'] ?? null,
            $data['email'] ?? null,
            $data['fecha_nacimiento'] ?? null,
            $data['direccion'] ?? null,
            $data['genero'] ?? 'NO_ESPECIFICA'
        ];
        
        $this->db->execute($sql, $params);
        return $this->db->lastInsertId();
    }
    
    /**
     * Actualizar un cliente
     */
    public function actualizar($id, $data) {
        $sql = "UPDATE cliente SET 
                    negocio = ?,
                    nombres = ?,
                    apellido_paterno = ?,
                    apellido_materno = ?,
                    dni = ?,
                    telefono = ?,
                    email = ?,
                    fecha_nacimiento = ?,
                    direccion = ?,
                    genero = ?
                WHERE id = ?";
        
        $params = [
            $data['negocio'],
            $data['nombres'],
            $data['apellido_paterno'] ?? null,
            $data['apellido_materno'] ?? null,
            $data['dni'],
            $data['telefono'] ?? null,
            $data['email'] ?? null,
            $data['fecha_nacimiento'] ?? null,
            $data['direccion'] ?? null,
            $data['genero'] ?? 'NO_ESPECIFICA',
            $id
        ];
        
        return $this->db->execute($sql, $params);
    }
    
    /**
     * Eliminar un cliente
     */
    public function eliminar($id) {
        $sql = "DELETE FROM cliente WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }
    
    /**
     * Buscar clientes
     */
    public function buscar($termino) {
        $sql = "SELECT 
                    c.*,
                    n.nombre as negocio_nombre
                FROM cliente c
                LEFT JOIN negocio n ON c.negocio = n.id
                WHERE c.nombres LIKE ? 
                   OR c.apellido_paterno LIKE ?
                   OR c.apellido_materno LIKE ?
                   OR c.dni LIKE ?
                   OR c.email LIKE ?
                ORDER BY c.nombres";
        
        $busqueda = "%{$termino}%";
        return $this->db->select($sql, [$busqueda, $busqueda, $busqueda, $busqueda, $busqueda]);
    }
    
    /**
     * Verificar si existe un DNI
     */
    public function existeDNI($dni, $exceptoId = null) {
        if ($exceptoId) {
            $sql = "SELECT COUNT(*) as total FROM cliente WHERE dni = ? AND id != ?";
            $result = $this->db->selectOne($sql, [$dni, $exceptoId]);
        } else {
            $sql = "SELECT COUNT(*) as total FROM cliente WHERE dni = ?";
            $result = $this->db->selectOne($sql, [$dni]);
        }
        
        return $result['total'] > 0;
    }
    
    /**
     * Verificar si existe un email
     */
    public function existeEmail($email, $exceptoId = null) {
        if ($exceptoId) {
            $sql = "SELECT COUNT(*) as total FROM cliente WHERE email = ? AND id != ?";
            $result = $this->db->selectOne($sql, [$email, $exceptoId]);
        } else {
            $sql = "SELECT COUNT(*) as total FROM cliente WHERE email = ?";
            $result = $this->db->selectOne($sql, [$email]);
        }
        
        return $result['total'] > 0;
    }
    
    /**
     * Obtener clientes por negocio
     */
    public function getByNegocio($negocioId) {
        $sql = "SELECT * FROM cliente WHERE negocio = ? ORDER BY nombres";
        return $this->db->select($sql, [$negocioId]);
    }
    
    /**
     * Obtener clientes por género
     */
    public function getByGenero($genero) {
        $sql = "SELECT 
                    c.*,
                    n.nombre as negocio_nombre
                FROM cliente c
                LEFT JOIN negocio n ON c.negocio = n.id
                WHERE c.genero = ?
                ORDER BY c.nombres";
        
        return $this->db->select($sql, [$genero]);
    }
    
    /**
     * Contar clientes
     */
    public function contar() {
        $sql = "SELECT COUNT(*) as total FROM cliente";
        $result = $this->db->selectOne($sql);
        return $result['total'] ?? 0;
    }
    
    /**
     * Obtener clientes recientes
     */
    public function getRecientes($limite = 10) {
        $sql = "SELECT 
                    c.*,
                    n.nombre as negocio_nombre
                FROM cliente c
                LEFT JOIN negocio n ON c.negocio = n.id
                ORDER BY c.fecha_registro DESC
                LIMIT ?";
        
        return $this->db->select($sql, [$limite]);
    }
}