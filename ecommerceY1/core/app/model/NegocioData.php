<?php 
class NegocioData {
    public static $tablename = "negocio";
    public $id;
    public $nombre;
    public $dirección;
    public $representante;
    public $logo_url;
    public $ruc;
    public $correo;
    public $teléfono;
    public $estado;
    public $total;
    public $fecha_constitucion;
    public $fecha_registro;
    public $fecha_actualizacion;

    public static function verid($id){
        $sql = "select * from ".self::$tablename." where id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0],new NegocioData());
    }
    public static function vertodos(){
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0],new NegocioData());
    }

    public static function vercontenido(){
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0],new NegocioData());
    }

    public static function vercontenidopaginado($start, $length, $search=''){
        $sql = "select * from ".self::$tablename;
        if($search){
            $sql .= " where nombre like '%$search%' or ruc like '%$search%' or representante like '%$search%'";
        }
        $sql .= " limit $start, $length";
        $query = Executor::doit($sql);
        return Model::many($query[0],new NegocioData());
    }

    public static function totalregistros(){
        $sql = "select count(*) as total from ".self::$tablename;
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new NegocioData());
        return $result->total;
    }

    public static function totalregistrosbuscados($search=''){
        $sql = "select count(*) as total from ".self::$tablename;
        if($search){
            $sql .= " where nombre like '%$search%' or ruc like '%$search%' or representante like '%$search%'";
        }
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new NegocioData());
        return $result->total;
    }
}

?>