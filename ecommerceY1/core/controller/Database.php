<?php
class Database {
    private static $instance = null;
    private $con;

    private function __construct() {
        $dsn = "mysql:host=" . (getenv('DB_HOST') ?: 'localhost') . ";dbname=" . (getenv('DB_NAME') ?: 'wankashopx') . ";charset=utf8mb4";
        try {
            $this->con = new PDO($dsn, getenv('DB_USER') ?: 'root', getenv('DB_PASS') ?: '');
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            error_log("Connection failed: " . $e->getMessage());
            throw new Exception("Error de conexión a la base de datos. Por favor intente más tarde.");
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->con;
    }

    public static function sanitizeInput($data) {
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }

    public function executeQuery($sql, $params = []) {
        try {
            $stmt = $this->con->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Query error: " . $e->getMessage());
            throw new Exception("Error al procesar la solicitud.");
        }
    }
}
?>