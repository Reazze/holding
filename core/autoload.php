<?php

/**
 * Autoloader del sistema
 * Carga automáticamente las clases necesarias
 */

// Cargar clases del directorio core/controller/
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/controller/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Cargar clases del directorio core/app/model/
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/app/model/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Cargar clases del directorio core/app/action/
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/app/action/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Cargar configuración de rutas
if (file_exists(__DIR__ . '/../config/paths.php')) {
    require_once __DIR__ . '/../config/paths.php';
}

// Cargar inicialización de la aplicación
if (file_exists(__DIR__ . '/app/init.php')) {
    require_once __DIR__ . '/app/init.php';
}