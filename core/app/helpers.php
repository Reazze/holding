<?php

/**
 * Funciones auxiliares personalizadas
 */

/**
 * Obtener valor de array de forma segura
 */
function getValue($array, $key, $default = null) {
    return isset($array[$key]) ? $array[$key] : $default;
}

/**
 * Verificar si el request es AJAX
 */
function isAjax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Obtener método HTTP actual
 */
function getMethod() {
    return $_SERVER['REQUEST_METHOD'];
}

/**
 * Verificar si es POST
 */
function isPost() {
    return getMethod() === 'POST';
}

/**
 * Verificar si es GET
 */
function isGet() {
    return getMethod() === 'GET';
}

/**
 * Sanitizar entrada POST
 */
function post($key, $default = null) {
    return Security::clean(getValue($_POST, $key, $default));
}

/**
 * Sanitizar entrada GET
 */
function get($key, $default = null) {
    return Security::clean(getValue($_GET, $key, $default));
}

/**
 * Mostrar alerta (mensaje flash)
 */
function alert($message, $type = 'info') {
    return '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">
                <strong>' . ucfirst($type) . ':</strong> ' . $message . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
}

/**
 * Generar URL completa
 */
function url($path = '') {
    return BASE_URL . ltrim($path, '/');
}

/**
 * Generar URL de asset
 */
function asset($path = '') {
    return ASSETS . ltrim($path, '/');
}

/**
 * Obtener año actual
 */
function currentYear() {
    return date('Y');
}

/**
 * Formatear número con decimales
 */
function formatNumber($number, $decimals = 2) {
    return number_format($number, $decimals, '.', ',');
}

/**
 * Calcular porcentaje
 */
function percentage($value, $total) {
    if ($total == 0) return 0;
    return round(($value / $total) * 100, 2);
}

/**
 * Validar si usuario está logueado
 */
function isLogged() {
    return Security::isAuthenticated();
}

/**
 * Obtener datos del usuario actual
 */
function currentUser() {
    return $_SESSION['user_data'] ?? null;
}

/**
 * Crear directorio si no existe
 */
function createDir($path) {
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
}

/**
 * Log de errores personalizado
 */
function logError($message, $file = 'error.log') {
    $logFile = LOG_PATH . '/' . $file;
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] {$message}\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}