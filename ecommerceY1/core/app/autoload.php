<?php

// Función de autoload para cargar modelos
function modelAutoload($modelName) {
    if (Model::exists($modelName)) {
        include Model::getFullpath($modelName);
    } else {
        // Manejar el error si el modelo no existe
        error_log("Modelo no encontrado: {$modelName}");
        throw new Exception("Error: El modelo {$modelName} no se pudo cargar.");
    }
}

// Registrar la función de autoload
spl_autoload_register("modelAutoload");

?>
