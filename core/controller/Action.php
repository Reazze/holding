<?php

class Action {
    
    /**
     * Procesar la acción solicitada
     */
    public static function run() {
        // Obtener la URL solicitada
        $url = self::getUrl();
        
        // Parsear la URL
        $controller = $url[0] ?? 'home';
        $method = $url[1] ?? 'index';
        $params = array_slice($url, 2);
        
        // Capitalizar el nombre del controlador
        $controllerClass = ucfirst(strtolower($controller));
        
        // Ruta del archivo del controlador
        $actionFile = __DIR__ . '/../app/action/' . $controllerClass . '.php';
        
        // Verificar si existe el archivo
        if (file_exists($actionFile)) {
            require_once $actionFile;
            
            // Verificar si existe la clase
            if (class_exists($controllerClass)) {
                $controllerInstance = new $controllerClass();
                
                // Verificar si existe el método
                if (method_exists($controllerInstance, $method)) {
                    // Ejecutar el método con parámetros
                    call_user_func_array([$controllerInstance, $method], $params);
                } else {
                    self::error404("Método no encontrado: {$controllerClass}::{$method}()");
                }
            } else {
                self::error404("Clase no encontrada: {$controllerClass}");
            }
        } else {
            self::error404("Controlador no encontrado: {$controllerClass}");
        }
    }
    
    /**
     * Obtener y limpiar la URL
     */
    private static function getUrl() {
        // Obtener la URL desde el parámetro GET
        $url = isset($_GET['url']) ? $_GET['url'] : 'home/index';
        
        // Limpiar la URL
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        
        return $url;
    }
    
    /**
     * Página de error 404
     */
    private static function error404($message = "Página no encontrada") {
        http_response_code(404);
        
        // Intentar cargar una vista de error personalizada
        $errorView = __DIR__ . '/../app/view/errors/404.php';
        
        if (file_exists($errorView)) {
            include $errorView;
        } else {
            // Error básico si no existe vista personalizada
            echo '<!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Error 404</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background: #f5f5f5;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                    }
                    .error-container {
                        text-align: center;
                        background: white;
                        padding: 50px;
                        border-radius: 10px;
                        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    }
                    h1 {
                        font-size: 100px;
                        margin: 0;
                        color: #e74c3c;
                    }
                    h2 {
                        color: #555;
                    }
                    p {
                        color: #777;
                        margin: 20px 0;
                    }
                    a {
                        display: inline-block;
                        margin-top: 20px;
                        padding: 10px 30px;
                        background: #3498db;
                        color: white;
                        text-decoration: none;
                        border-radius: 5px;
                    }
                    a:hover {
                        background: #2980b9;
                    }
                </style>
            </head>
            <body>
                <div class="error-container">
                    <h1>404</h1>
                    <h2>Página no encontrada</h2>
                    <p>' . htmlspecialchars($message) . '</p>
                    <a href="' . BASE_URL . '">Volver al inicio</a>
                </div>
            </body>
            </html>';
        }
        exit();
    }
}