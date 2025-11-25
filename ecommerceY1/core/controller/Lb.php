<?php 
class Lb {
    const BASE_PATH = "core/app/";

    public function __construct() {
        // Constructor vacío, se puede eliminar si no hay lógica futura
    }

    // Inicia el sistema cargando archivos esenciales
    public function start() {
        $this->loadFile('autoload.php');
        $this->loadFile('init.php');
    }

    // Carga un archivo y maneja errores
    private function loadFile($filename) {
        $filePath = self::BASE_PATH . $filename;

        if (file_exists($filePath)) {
            include $filePath;
        } else {
            throw new Exception("Error: El archivo {$filename} no se pudo cargar.");
        }
    }
}
?>
