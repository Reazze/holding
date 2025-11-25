<?php

/**
 * Punto de entrada del sistema
 * Todas las peticiones pasan por aquí
 */

// Iniciar sesión
session_start();

// Configuración de errores (cambiar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cargar el autoloader y configuraciones



require_once __DIR__ . '/core/autoload.php';

// Ejecutar el sistema de rutas
Action::run();