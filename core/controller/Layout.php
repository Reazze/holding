<?php

class Layout {
    
    private $layoutPath;
    
    public function __construct() {
        $this->layoutPath = __DIR__ . '/../app/layouts/';
    }
    
    /**
     * Renderizar un layout con una vista
     */
    public function render($layoutName, $viewFile, $data = []) {
        // Extraer datos
        extract($data);
        
        // Ruta del layout
        $layoutFile = $this->layoutPath . $layoutName . '.php';
        
        // Verificar que exista
        if (file_exists($layoutFile)) {
            // La variable $view se usará dentro del layout
            $view = $viewFile;
            include $layoutFile;
        } else {
            die("Layout no encontrado: {$layoutName}");
        }
    }
    
    /**
     * Cargar un partial (navbar, sidebar, footer, etc.)
     */
    public function partial($partialName, $data = []) {
        extract($data);
        
        $partialFile = $this->layoutPath . 'partials/' . $partialName . '.php';
        
        if (file_exists($partialFile)) {
            include $partialFile;
        } else {
            echo "<!-- Partial no encontrado: {$partialName} -->";
        }
    }
    
    /**
     * Verificar si un layout existe
     */
    public function exists($layoutName) {
        $layoutFile = $this->layoutPath . $layoutName . '.php';
        return file_exists($layoutFile);
    }
}