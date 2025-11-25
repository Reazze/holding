<?php

class Lb {
    
    /**
     * Formatear fecha a español
     */
    public static function formatDate($date, $format = 'd/m/Y') {
        if (empty($date)) return '';
        
        $timestamp = strtotime($date);
        return date($format, $timestamp);
    }
    
    /**
     * Formatear moneda (Soles peruanos)
     */
    public static function formatMoney($amount, $symbol = 'S/ ') {
        return $symbol . number_format($amount, 2, '.', ',');
    }
    
    /**
     * Generar slug para URLs
     */
    public static function slug($text) {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim($text, '-');
        return $text;
    }
    
    /**
     * Truncar texto
     */
    public static function truncate($text, $length = 100, $suffix = '...') {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . $suffix;
    }
    
    /**
     * Obtener extensión de archivo
     */
    public static function getExtension($filename) {
        return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    }
    
    /**
     * Validar extensión de archivo
     */
    public static function validateExtension($filename, $allowed = []) {
        $ext = self::getExtension($filename);
        return in_array($ext, $allowed);
    }
    
    /**
     * Subir archivo
     */
    public static function uploadFile($file, $destination, $allowedExt = ['jpg', 'jpeg', 'png', 'gif']) {
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return ['success' => false, 'message' => 'No se recibió ningún archivo'];
        }
        
        // Validar extensión
        if (!self::validateExtension($file['name'], $allowedExt)) {
            return ['success' => false, 'message' => 'Extensión no permitida'];
        }
        
        // Generar nombre único
        $ext = self::getExtension($file['name']);
        $newName = uniqid() . '.' . $ext;
        $fullPath = $destination . '/' . $newName;
        
        // Mover archivo
        if (move_uploaded_file($file['tmp_name'], $fullPath)) {
            return ['success' => true, 'filename' => $newName, 'path' => $fullPath];
        }
        
        return ['success' => false, 'message' => 'Error al subir el archivo'];
    }
    
    /**
     * Eliminar archivo
     */
    public static function deleteFile($path) {
        if (file_exists($path)) {
            return unlink($path);
        }
        return false;
    }
    
    /**
     * Debug: Imprimir variable con formato
     */
    public static function debug($data, $exit = false) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        
        if ($exit) exit();
    }
    
    /**
     * Redireccionar con mensaje
    */
    public static function redirect($url, $message = null) {
        if ($message) {
            $_SESSION['flash_message'] = $message;
        }
        header('Location: ' . BASE_URL . $url);
        exit();
    }

    /**
    * Obtener mensaje flash de sesión
    */
    public static function getMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}
    
    /**
     * Generar código aleatorio
     */
    public static function generateCode($length = 6) {
        return strtoupper(substr(md5(uniqid(rand(), true)), 0, $length));
    }
    
    /**
     * Validar RUC (Perú)
     */
    public static function validateRUC($ruc) {
        return preg_match('/^[0-9]{11}$/', $ruc);
    }
    
    /**
     * Validar DNI (Perú)
     */
    public static function validateDNI($dni) {
        return preg_match('/^[0-9]{8}$/', $dni);
    }
}