<?php

class Executor {
    
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Ejecutar una consulta SQL personalizada
     */
    public function query($sql, $params = []) {
        return $this->db->select($sql, $params);
    }
    
    /**
     * Ejecutar una consulta y obtener un solo resultado
     */
    public function queryOne($sql, $params = []) {
        return $this->db->selectOne($sql, $params);
    }
    
    /**
     * Ejecutar INSERT, UPDATE, DELETE
     */
    public function execute($sql, $params = []) {
        return $this->db->execute($sql, $params);
    }
    
    /**
     * Obtener el último ID insertado
     */
    public function lastId() {
        return $this->db->lastInsertId();
    }
    
    /**
     * Operación en transacción
     */
    public function transaction($callback) {
        try {
            $this->db->beginTransaction();
            
            $result = $callback($this);
            
            $this->db->commit();
            return $result;
            
        } catch (Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }
    
    /**
     * Validar datos requeridos
     */
    public function validateRequired($data, $required = []) {
        $missing = [];
        
        foreach ($required as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $missing[] = $field;
            }
        }
        
        return [
            'valid' => empty($missing),
            'missing' => $missing
        ];
    }
    
    /**
     * Respuesta JSON
     */
    public function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
    
    /**
     * Respuesta de éxito
     */
    public function success($message, $data = []) {
        return $this->jsonResponse([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }
    
    /**
     * Respuesta de error
     */
    public function error($message, $statusCode = 400) {
        return $this->jsonResponse([
            'success' => false,
            'message' => $message
        ], $statusCode);
    }
}