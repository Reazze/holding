<!-- <?php
/**
 * Configuración de Seguridad 
 * Archivo centralizado para configuraciones de seguridad
 */

return [
    // Configuración de sesiones
    'session' => [
        'timeout' => 1800, // 30 minutos
        'regeneration_interval' => 300, // 5 minutos
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'
    ],
    
    // Configuración de contraseñas
    'password' => [
        'min_length' => 8,
        'require_uppercase' => true,
        'require_lowercase' => true,
        'require_numbers' => true,
        'require_special' => true,
        'max_age_days' => 90 // Cambiar contraseña cada 90 días
    ],
    
    // Protección contra fuerza bruta
    'brute_force' => [
        'max_attempts' => 5,
        'lockout_duration' => 900, // 15 minutos
        'track_by_ip' => true,
        'track_by_username' => true
    ],
    
    // Configuración de archivos
    'uploads' => [
        'max_size' => 5242880, // 5MB
        'allowed_types' => [
            'images' => ['jpg', 'jpeg', 'png', 'gif'],
            'documents' => ['pdf', 'doc', 'docx', 'txt'],
            'archives' => ['zip', 'rar']
        ],
        'scan_viruses' => false, // Requiere antivirus
        'validate_mime' => true
    ],
    
    // Configuración de logs
    'logging' => [
        'security_events' => true,
        'user_activity' => true,
        'error_logs' => true,
        'retention_days' => 30,
        'log_level' => 'INFO' // DEBUG, INFO, WARNING, ERROR
    ],
    
    // Configuración de IPs
    'ip_security' => [
        'whitelist' => [], // IPs permitidas
        'blacklist' => [], // IPs bloqueadas
        'geo_blocking' => false,
        'proxy_detection' => true
    ],
    
    // Configuración de CSRF
    'csrf' => [
        'enabled' => true,
        'token_expiry' => 3600, // 1 hora
        'regenerate_on_login' => true
    ],
    
    // Configuración de headers de seguridad
    'security_headers' => [
        'x_frame_options' => 'DENY',
        'x_content_type_options' => 'nosniff',
        'x_xss_protection' => '1; mode=block',
        'referrer_policy' => 'strict-origin-when-cross-origin',
        'permissions_policy' => 'geolocation=(), microphone=(), camera=()',
        'content_security_policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; img-src 'self' data: https:; font-src 'self' https://cdnjs.cloudflare.com; connect-src 'self';"
    ],
    
    // Configuración de base de datos
    'database' => [
        'connection_timeout' => 30,
        'max_connections' => 100,
        'query_timeout' => 60,
        'log_queries' => false, // Solo en desarrollo
        'log_slow_queries' => true,
        'slow_query_threshold' => 1.0 // segundos
    ],
    
    // Configuración de rate limiting
    'rate_limiting' => [
        'enabled' => true,
        'requests_per_minute' => 60,
        'requests_per_hour' => 1000,
        'burst_limit' => 10
    ],
    
    // Configuración de backup
    'backup' => [
        'auto_backup' => false,
        'backup_interval' => 'daily',
        'retention_days' => 7,
        'encrypt_backups' => true
    ],
    
    // Configuración de monitoreo
    'monitoring' => [
        'uptime_monitoring' => false,
        'error_alerting' => false,
        'performance_monitoring' => false,
        'security_alerting' => true
    ]
];
?> -->
