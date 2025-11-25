<?php
class View {
    // Carga una vista específica
    public static function load($view) {
        $viewFile = isset($_GET['view']) ? $_GET['view'] : $view;
        $fullpath = self::getViewPath($viewFile);

        if (self::isValid($fullpath)) {
            include $fullpath;
        } else {
            // Redirigir a ayuda-view.php si la vista no existe
            $helpPath = self::getViewPath('ayuda');
            if (self::isValid($helpPath)) {
                header("Location: ayuda");
                exit();
            } else {
                self::error("<br><br><br><br>404 NOT FOUND: View <b>{$viewFile}</b> does not exist! <a href='https://www.tareacompleto.com/' target='_blank'>Ayuda</a>");
            }
        }
    }

    // Verifica si la vista es válida (existe)
    private static function isValid($fullpath) {
        return file_exists($fullpath);
    }

    // Retorna la ruta completa de la vista
    private static function getViewPath($view) {
        return "core/app/view/{$view}-view.php";
    }

    // Muestra un mensaje de error
    private static function error($message) {
        // Es posible que aquí quieras lanzar una excepción en lugar de imprimir el error
        echo "<div style='color: red;'>{$message}</div>";
    }
}
?>