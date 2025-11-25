<?php

class Database {
    
    private $host;
    private $user;
    private $pass;
    private $database;
    private $charset;
    private $connection;
    
    public function __construct() {
        // Cargar configuración desde config/database.php
        $config = require __DIR__ . '/../../config/database.php';
        
        $this->host = $config['host'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
        $this->database = $config['database'];
        $this->charset = $config['charset'] ?? 'utf8mb4';
        
        $this->connect();
    }
    
    /**
     * Conectar a la base de datos
     */
    private function connect() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            
            $this->connection = new PDO($dsn, $this->user, $this->pass, $options);
            
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    /**
     * Obtener la conexión
     */
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * Ejecutar una consulta SELECT
     */
    public function select($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Error en SELECT: " . $e->getMessage());
        }
    }
    
    /**
     * Ejecutar una consulta SELECT y retornar un solo registro
     */
    public function selectOne($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            die("Error en SELECT ONE: " . $e->getMessage());
        }
    }
    
    /**
     * Ejecutar INSERT, UPDATE, DELETE
     */
    public function execute($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            die("Error en EXECUTE: " . $e->getMessage());
        }
    }
    
    /**
     * Obtener el último ID insertado
     */
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
    
    /**
     * Iniciar transacción
     */
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }
    
    /**
     * Confirmar transacción
     */
    public function commit() {
        return $this->connection->commit();
    }
    
    /**
     * Revertir transacción
     */
    public function rollback() {
        return $this->connection->rollBack();
    }
}