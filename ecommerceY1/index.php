<?php
// Configuración de debug
$debug = true;

if($debug){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

// Incluir sistema de seguridad ANTES de cualquier salida
include "core/autoload.php";

// Inicializar sistema de seguridad ANTES de session_start
Security::init();

// Iniciar sesión después de configurar seguridad
session_start();

// Completar la inicialización de seguridad después de session_start
Security::validateSession();

// Buffer de salida
ob_start();

// si quieres que se muestre las consultas SQL debes decomentar la siguiente linea
// Core::$debug_sql = true;

$lb = new Lb();
$lb->start();

?>