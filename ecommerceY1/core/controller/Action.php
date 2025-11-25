<?php
class Action {
    const ACTION_PATH = "core/app/action/";

    // Carga la acción solicitada
    public static function load($defaultAction) {
        $action = $_GET['action'] ?? $defaultAction;  // Usar el valor por defecto si no se proporciona 'action'
        if (self::isValid($action)) {
            include self::ACTION_PATH . $action . "-action.php";
        } else {
            self::Error("404 NOT FOUND: Action <b>{$action}</b> not found. <a href='http://evilnapsis.com/legobox/help/' target='_blank'>Help</a>");
        }
    }

    // Verifica si el archivo de la acción es válido
    public static function isValid($action) {
        $file = self::ACTION_PATH . basename($action) . "-action.php"; // Sanitizar 'action' para evitar rutas maliciosas
        return file_exists($file);
    }

    // Manejo de errores
    public static function Error($message) {
        echo $message;
    }

    // Ejecuta una acción específica con parámetros
    public function execute($action, $params = []) {
        $fullpath = self::ACTION_PATH . basename($action) . "-action.php";
        if (file_exists($fullpath)) {
            include $fullpath;
        } else {
            throw new Exception("Error: Action file <b>{$action}-action.php</b> not found.");
        }
    }
}
?>