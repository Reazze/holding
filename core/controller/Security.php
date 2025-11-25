<?php

class Security {
    
    /**
     * Limpiar datos de entrada
     */
    public static function clean($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::clean($value);
            }
        } else {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }
        return $data;
    }
    
    /**
     * Validar email
     */
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    /**
     * Hash de contraseña
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }
    
    /**
     * Verificar contraseña
     */
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    /**
     * Generar token CSRF
     */
    public static function generateToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validar token CSRF
     */
    public static function validateToken($token) {
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Prevenir XSS
     */
    public static function xssClean($data) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Prevenir SQL Injection (usar con PDO preparado)
     */
    public static function sqlClean($data) {
        return addslashes(trim($data));
    }
    
    /**
     * Verificar si el usuario está autenticado
     */
    public static function isAuthenticated() {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
    
    /**
     * Obtener ID del usuario autenticado
     */
    public static function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }
    
    /**
     * Iniciar sesión de usuario
     */
    public static function login($userId, $userData = []) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_data'] = $userData;
        $_SESSION['login_time'] = time();
    }

    /**
     * Obtener datos del usuario actual
     */
    public static function getUserData() {
        return $_SESSION['user_data'] ?? null;
    }

    /**
     * Obtener un dato específico del usuario
     */
    public static function getUserInfo($key, $default = null) {
        $userData = self::getUserData();
        return $userData[$key] ?? $default;
    }
    
    /**
     * Cerrar sesión
     */
    public static function logout() {
        session_unset();
        session_destroy();
    }
    
    /**
     * Redireccionar si no está autenticado
     */
    public static function requireAuth($redirectTo = 'login') {
        if (!self::isAuthenticated()) {
            header('Location: ' . BASE_URL . $redirectTo);
            exit();
        }
    }
    
    /**
     * Generar contraseña aleatoria
     */
    public static function generatePassword($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        return substr(str_shuffle($chars), 0, $length);
    }
}