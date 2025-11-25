<?php
class Executor {
    public static function doit($sql, $params = []) {
        $con = Database::getInstance()->getConnection();
        try {
            if (defined('Core::$debug_sql') && Core::$debug_sql) {
                // Mostrar la consulta y parámetros si está activado el modo debug
                echo "<pre>$sql</pre><pre>Params: " . print_r($params, true) . "</pre>";
            }
            // Preparar y ejecutar la consulta
            $stmt = $con->prepare($sql);
            $stmt->execute($params);
            // Retornar el statement y el último insert_id si es exitoso
            return [$stmt, $con->lastInsertId()];
        } catch (PDOException $e) {
            // Manejar la excepción lanzando un error controlado
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
}
?>