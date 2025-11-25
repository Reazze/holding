<?php

class Core {
    
    protected $view;
    protected $model;
    protected $layout;
    
    public function __construct() {
        $this->view = new View();
        $this->layout = new Layout();
    }
    
    /**
     * Cargar una vista con layout
     */
    protected function view($viewName, $data = []) {
        $this->view->render($viewName, $data);
    }
    
    /**
     * Cargar una vista sin layout (para AJAX o páginas independientes)
     */
    protected function viewOnly($viewName, $data = []) {
        $this->view->renderOnly($viewName, $data);
    }
    
    /**
     * Cargar un modelo
     */
    protected function model($modelName) {
        $modelFile = __DIR__ . '/../app/model/' . $modelName . '.php';
        
        if(file_exists($modelFile)) {
            require_once $modelFile;
            return new $modelName();
        } else {
            die("El modelo {$modelName} no existe");
        }
    }
    
    /**
     * Redireccionar
     */
    protected function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit();
    }
    
    /**
     * Retornar JSON
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}