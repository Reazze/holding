<?php

class View {
    
    /**
     * Renderizar vista con layout
     */
    public function render($viewName, $data = []) {
        // Extraer variables para usar en las vistas
        extract($data);
        
        // Ruta de la vista
        $viewFile = __DIR__ . '/../app/view/' . $viewName . '.php';
        
        // Verificar si existe la vista
        if(file_exists($viewFile)) {
            // Pasar la ruta de la vista al layout
            $view = $viewFile;
            
            // Cargar el layout principal
            include __DIR__ . '/../app/layouts/layout.php';
        } else {
            die("La vista {$viewName} no existe en: {$viewFile}");
        }
    }
    
    /**
     * Renderizar solo la vista sin layout (para AJAX o páginas independientes)
     */
    public function renderOnly($viewName, $data = []) {
        // Extraer variables
        extract($data);
        
        // Ruta de la vista
        $viewFile = __DIR__ . '/../app/view/' . $viewName . '.php';
        
        // Verificar si existe
        if(file_exists($viewFile)) {
            include $viewFile;
        } else {
            die("La vista {$viewName} no existe en: {$viewFile}");
        }
    }
}