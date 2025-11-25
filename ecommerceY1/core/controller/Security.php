<?php
/**
 * Clase de Seguridad Integral para SYMETRI PROJECT
 * Implementa múltiples capas de protección contra ataques comunes
 */
class Security {
    
    // Configuración de seguridad
    private static $config = [
        'csrf_token_expiry' => 3600, // 1 hora
        'max_login_attempts' => 5,
        'lockout_duration' => 900, // 15 minutos
        'session_timeout' => 1800, // 30 minutos
        'password_min_length' => 8,
        'allowed_file_types' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'],
        'max_file_size' => 5242880, // 5MB
    ];
    
    /**
     * Inicializa las configuraciones de seguridad
     */
    public static function init() {
        // Configurar headers de seguridad (debe ser antes de cualquier salida)
        self::setSecurityHeaders();
        
        // Configurar cookies seguras (debe ser antes de session_start)
        self::setSecureCookies();
        
        // Protección CSRF (se inicializa después de session_start)
        // self::initCSRF(); // Se moverá a validateSession
        
        // Log de actividad (se hace después de session_start)
        // self::logActivity(); // Se moverá a validateSession
    }
    
    /**
     * Headers de seguridad HTTP
     */
    private static function setSecurityHeaders() {
        // Solo enviar headers si no se han enviado ya
        if (headers_sent()) {
            return;
        }
        
        // Prevenir clickjacking
        header('X-Frame-Options: DENY');
        
        // Prevenir MIME type sniffing
        header('X-Content-Type-Options: nosniff');
        
        // Política de referrer
        header('Referrer-Policy: strict-origin-when-cross-origin');
        
        // Content Security Policy
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; img-src 'self' data: https:; font-src 'self' https://cdnjs.cloudflare.com; connect-src 'self';");
        
        // Prevenir XSS
        header('X-XSS-Protection: 1; mode=block');
        
        // HSTS (HTTPS Strict Transport Security)
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
        }
    }
    
    /**
     * Configuración de cookies seguras
     */
    private static function setSecureCookies() {
        // Solo configurar si la sesión no ha empezado
        if (session_status() !== PHP_SESSION_ACTIVE) {
            // Configurar parámetros de cookies de forma compatible con PHP 8.2
            $cookieParams = session_get_cookie_params();
            
            // En PHP 8.2, session_set_cookie_params acepta máximo 5 argumentos
            // Los parámetros son: lifetime, path, domain, secure, httponly
            session_set_cookie_params(
                $cookieParams['lifetime'],
                $cookieParams['path'],
                $cookieParams['domain'],
                isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on', // secure
                true  // httponly
            );
            
            // Configurar SameSite a través de ini_set (alternativa para .htaccess)
            ini_set('session.cookie_samesite', 'Strict');
        }
    }
    
    /**
     * Validación de sesión
     */
    public static function validateSession() {
        // Solo validar si la sesión está activa
        if (session_status() === PHP_SESSION_ACTIVE) {
            // Regenerar ID de sesión periódicamente
            if (!isset($_SESSION['last_regeneration']) || 
                (time() - $_SESSION['last_regeneration']) > 300) { // 5 minutos
                session_regenerate_id(true);
                $_SESSION['last_regeneration'] = time();
            }
            
            // Verificar timeout de sesión
            if (isset($_SESSION['last_activity']) && 
                (time() - $_SESSION['last_activity']) > self::$config['session_timeout']) {
                session_destroy();
                header('Location: salir.php');
                exit();
            }
            
            $_SESSION['last_activity'] = time();
            
            // Inicializar CSRF después de que la sesión esté activa
            self::initCSRF();
            
            // Log de actividad
            self::logActivity();
        }
    }
    
    /**
     * Inicialización de protección CSRF
     */
    private static function initCSRF() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['csrf_token_time'] = time();
        }
        
        // Verificar expiración del token
        if ((time() - $_SESSION['csrf_token_time']) > self::$config['csrf_token_expiry']) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['csrf_token_time'] = time();
        }
    }
    
    /**
     * Genera token CSRF para formularios
     */
    public static function getCSRFToken() {
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Valida token CSRF
     */
    public static function validateCSRFToken($token) {
        if (!isset($_SESSION['csrf_token']) || 
            !hash_equals($_SESSION['csrf_token'], $token)) {
            self::logSecurityEvent('CSRF_TOKEN_INVALID', $_SERVER['REMOTE_ADDR']);
            return false;
        }
        return true;
    }
    
    /**
     * Sanitización avanzada de inputs
     */
    public static function sanitizeInput($data, $type = 'string') {
        if (is_array($data)) {
            return array_map([self::class, 'sanitizeInput'], $data);
        }
        
        $data = trim($data);
        
        switch ($type) {
            case 'email':
                return filter_var($data, FILTER_SANITIZE_EMAIL);
            case 'url':
                return filter_var($data, FILTER_SANITIZE_URL);
            case 'int':
                return filter_var($data, FILTER_SANITIZE_NUMBER_INT);
            case 'float':
                return filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT);
            case 'string':
            default:
                return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }
    }
    
    /**
     * Validación de archivos subidos
     */
    public static function validateUploadedFile($file) {
        $errors = [];
        
        // Verificar si se subió un archivo
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            $errors[] = 'Archivo no válido';
            return $errors;
        }
        
        // Verificar tamaño
        if ($file['size'] > self::$config['max_file_size']) {
            $errors[] = 'Archivo demasiado grande';
        }
        
        // Verificar tipo de archivo
        $fileInfo = pathinfo($file['name']);
        $extension = strtolower($fileInfo['extension']);
        
        if (!in_array($extension, self::$config['allowed_file_types'])) {
            $errors[] = 'Tipo de archivo no permitido';
        }
        
        // Verificar contenido del archivo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        $allowedMimes = [
            'image/jpeg', 'image/png', 'image/gif', 
            'application/pdf', 'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];
        
        if (!in_array($mimeType, $allowedMimes)) {
            $errors[] = 'Tipo MIME no permitido';
        }
        
        return $errors;
    }
    
    /**
     * Protección contra SQL Injection
     */
    public static function escapeSQL($string) {
        return addslashes($string);
    }
    
    /**
     * Protección contra XSS
     */
    public static function preventXSS($data) {
        if (is_array($data)) {
            return array_map([self::class, 'preventXSS'], $data);
        }
        
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Validación de contraseña
     */
    public static function validatePassword($password) {
        $errors = [];
        
        if (strlen($password) < self::$config['password_min_length']) {
            $errors[] = 'La contraseña debe tener al menos ' . self::$config['password_min_length'] . ' caracteres';
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'La contraseña debe contener al menos una mayúscula';
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'La contraseña debe contener al menos una minúscula';
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'La contraseña debe contener al menos un número';
        }
        
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = 'La contraseña debe contener al menos un carácter especial';
        }
        
        return $errors;
    }
    
    /**
     * Hash seguro de contraseña
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_ARGON2ID, [
            'memory_cost' => 65536,
            'time_cost' => 4,
            'threads' => 3
        ]);
    }
    
    /**
     * Verificación de contraseña
     */
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    /**
     * Protección contra ataques de fuerza bruta
     */
    public static function checkBruteForce($identifier, $type = 'login') {
        $key = "brute_force_{$type}_{$identifier}";
        
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = ['attempts' => 0, 'last_attempt' => 0];
        }
        
        $now = time();
        
        // Resetear si ha pasado el tiempo de bloqueo
        if (($now - $_SESSION[$key]['last_attempt']) > self::$config['lockout_duration']) {
            $_SESSION[$key]['attempts'] = 0;
        }
        
        // Verificar si está bloqueado
        if ($_SESSION[$key]['attempts'] >= self::$config['max_login_attempts']) {
            return false; // Bloqueado
        }
        
        $_SESSION[$key]['attempts']++;
        $_SESSION[$key]['last_attempt'] = $now;
        
        return true; // No bloqueado
    }
    
    /**
     * Log de eventos de seguridad
     */
    public static function logSecurityEvent($event, $ip = null, $details = '') {
        $ip = $ip ?: $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
        $timestamp = date('Y-m-d H:i:s');
        
        $logEntry = "[{$timestamp}] {$event} - IP: {$ip} - UA: {$userAgent} - {$details}\n";
        
        $logFile = 'storage/logs/security.log';
        $logDir = dirname($logFile);
        
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }
    
    /**
     * Log de actividad general
     */
    private static function logActivity() {
        if (isset($_SESSION['conticomtc'])) {
            $user = $_SESSION['conticomtc'];
            $page = $_SERVER['REQUEST_URI'];
            $timestamp = date('Y-m-d H:i:s');
            
            $logEntry = "[{$timestamp}] User: {$user} - Page: {$page} - IP: {$_SERVER['REMOTE_ADDR']}\n";
            
            $logFile = 'storage/logs/activity.log';
            $logDir = dirname($logFile);
            
            if (!is_dir($logDir)) {
                mkdir($logDir, 0755, true);
            }
            
            file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
        }
    }
    
    /**
     * Limpieza de logs antiguos
     */
    public static function cleanOldLogs($days = 30) {
        $logDir = 'storage/logs/';
        $cutoff = time() - ($days * 24 * 60 * 60);
        
        if (is_dir($logDir)) {
            $files = glob($logDir . '*.log');
            foreach ($files as $file) {
                if (filemtime($file) < $cutoff) {
                    unlink($file);
                }
            }
        }
    }
    
    /**
     * Verificación de IP en lista blanca/negra
     */
    public static function checkIPAccess($ip = null) {
        $ip = $ip ?: $_SERVER['REMOTE_ADDR'];
        
        // Lista negra (IPs bloqueadas)
        $blacklist = ['127.0.0.1']; // Ejemplo
        
        if (in_array($ip, $blacklist)) {
            self::logSecurityEvent('IP_BLOCKED', $ip);
            return false;
        }
        
        return true;
    }
    
    /**
     * Generación de token de autenticación
     */
    public static function generateAuthToken($userId) {
        $token = bin2hex(random_bytes(32));
        $expiry = time() + (24 * 60 * 60); // 24 horas
        
        $_SESSION['auth_token'] = [
            'token' => $token,
            'user_id' => $userId,
            'expiry' => $expiry
        ];
        
        return $token;
    }
    
    /**
     * Validación de token de autenticación
     */
    public static function validateAuthToken($token) {
        if (!isset($_SESSION['auth_token']) || 
            $_SESSION['auth_token']['token'] !== $token ||
            time() > $_SESSION['auth_token']['expiry']) {
            return false;
        }
        
        return $_SESSION['auth_token']['user_id'];
    }
}
?>
