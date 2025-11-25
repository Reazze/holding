<?php
class Model {
    // Verifica si existe el archivo de un modelo
    public static function exists($modelname) {
        return file_exists(self::getFullpath($modelname));
    }

    // Retorna la ruta completa de un modelo
    public static function getFullpath($modelname) {
        return "core/app/model/" . $modelname . ".php";
    }

    // Devuelve múltiples registros
    public static function many($query, $aclass) {
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $results = $query->fetchAll();
        $array = [];

        foreach ($results as $r) {
            $obj = new $aclass;
            foreach ($r as $key => $v) {
                $obj->$key = $v;
            }
            $array[] = $obj;
        }
        return $array;
    }

    // Devuelve un solo registro
    public static function one($query, $aclass) {
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $r = $query->fetch();
        if (!$r) return null;

        $data = new $aclass;
        foreach ($r as $key => $v) {
            $data->$key = $v;
        }
        return $data;
    }
}
?>