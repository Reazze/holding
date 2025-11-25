<?php

class Model {
    
    protected $db;
    protected $table;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Obtener todos los registros
     */
    public function all() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->db->select($sql);
    }
    
    /**
     * Obtener un registro por ID
     */
    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->selectOne($sql, [$id]);
    }
    
    /**
     * Buscar registros con condiciones
     */
    public function where($conditions = [], $params = []) {
        $sql = "SELECT * FROM {$this->table}";
        
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        
        return $this->db->select($sql, $params);
    }
    
    /**
     * Insertar un nuevo registro
     */
    public function insert($data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        
        $this->db->execute($sql, array_values($data));
        return $this->db->lastInsertId();
    }
    
    /**
     * Actualizar un registro
     */
    public function update($id, $data) {
        $fields = [];
        foreach (array_keys($data) as $key) {
            $fields[] = "{$key} = ?";
        }
        $fields = implode(', ', $fields);
        
        $sql = "UPDATE {$this->table} SET {$fields} WHERE id = ?";
        
        $params = array_values($data);
        $params[] = $id;
        
        return $this->db->execute($sql, $params);
    }
    
    /**
     * Eliminar un registro
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }
    
    /**
     * Contar registros
     */
    public function count($conditions = [], $params = []) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        
        $result = $this->db->selectOne($sql, $params);
        return $result['total'] ?? 0;
    }
}