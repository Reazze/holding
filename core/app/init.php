<?php

/**
 * Archivo de inicialización de la aplicación
 * Se carga automáticamente al inicio del sistema
 */

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Configuración de zona horaria (Perú)
date_default_timezone_set('America/Lima');

// Configuración de errores según el ambiente
$environment = 'development'; // Cambiar a 'production' en servidor

if ($environment === 'development') {
    // Mostrar todos los errores en desarrollo
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    // Ocultar errores en producción
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../../storage/logs/error.log');
}

// Configuración de caracteres
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

// Prevenir ataques XSS
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');

// Configuración de límites de memoria y tiempo
ini_set('memory_limit', '256M');
ini_set('max_execution_time', '300');

// Variables globales de la aplicación
define('APP_NAME', 'WankaShop');
define('APP_VERSION', '1.0.0');
define('APP_AUTHOR', 'Tu Nombre');

// Rutas del sistema
define('ROOT_PATH', __DIR__ . '/../..');
define('STORAGE_PATH', ROOT_PATH . '/storage');
define('UPLOAD_PATH', STORAGE_PATH . '/archivo');
define('LOG_PATH', STORAGE_PATH . '/logs');

// Configuración de uploads
define('MAX_FILE_SIZE', 5242880); // 5MB en bytes
define('ALLOWED_IMAGES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
define('ALLOWED_DOCUMENTS', ['pdf', 'doc', 'docx', 'xls', 'xlsx']);

// Configuración del negocio (se puede cargar desde BD después)
define('CURRENCY_SYMBOL', 'S/ ');
define('CURRENCY_CODE', 'PEN');
define('TAX_RATE', 0.18); // IGV 18%

// Helper: función para debug rápido
if (!function_exists('dd')) {
    function dd($data) {
        echo '<pre style="background: #1a1a1a; color: #00ff00; padding: 20px; margin: 20px;">';
        print_r($data);
        echo '</pre>';
        die();
    }
}

// Helper: función para imprimir sin detener
if (!function_exists('dump')) {
    function dump($data) {
        echo '<pre style="background: #1a1a1a; color: #00ff00; padding: 20px; margin: 20px;">';
        print_r($data);
        echo '</pre>';
    }
}

// Helper: obtener la URL actual
if (!function_exists('currentUrl')) {
    function currentUrl() {
        return $_SERVER['REQUEST_URI'];
    }
}

// Helper: verificar si la URL actual coincide
if (!function_exists('isActive')) {
    function isActive($url) {
        $current = currentUrl();
        return strpos($current, $url) !== false ? 'active' : '';
    }
}

// Cargar funciones personalizadas adicionales
if (file_exists(__DIR__ . '/helpers.php')) {
    require_once __DIR__ . '/helpers.php';
}