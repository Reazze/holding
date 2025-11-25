<?php 
class UserData {
    public static $tablename = "usuario";
    public $id;
    public $negocio ;
    public $cargos ;
    public $nombre;
    public $apellido;
    public $usuario;
    public $password;
    public $email;
    public $telefono;
    public $estado;
    public $dni;
    public $total;
    
    public function registro() {
        $sql = "INSERT INTO " . self::$tablename . " 
                (negocio, cargos, nombre, apellido, usuario, password, email, telefono, estado, dni)
                VALUES (:negocio, :cargos, :nombre, :apellido, :usuario, :password, :email, :telefono, :estado, :dni)";
        return Executor::doit($sql, [
            ':negocio'  => $this->negocio ?: null,
            ':cargos'   => $this->cargos ?: null,
            ':nombre'   => $this->nombre,
            ':apellido' => $this->apellido,
            ':usuario'  => $this->usuario,
            ':password' => $this->password,
            ':email'    => $this->email,
            ':telefono' => $this->telefono,
            ':estado'   => $this->estado,
            ':dni'      => $this->dni
        ]);
    }
    
    public function actualizar(){
        $campos = [
            "negocio" => $this->negocio,
            "cargos" => $this->cargos,
            "nombre" => $this->nombre,
            "apellido" => $this->apellido,
            "email" => $this->email,
            "telefono" => $this->telefono,
            "estado" => $this->estado,
            "dni" => $this->dni
        ];
        $fields = [];
        $params = [":id" => $this->id];
        foreach ($campos as $columna => $valor) {
            $fields[] = "$columna=:$columna";
            $params[":$columna"] = $valor;
        }
        if(empty($fields)){
            return false; // No hay campos para actualizar
        }
        $sql = "UPDATE " . self::$tablename . " SET " . implode(", ", $fields) . " WHERE id=:id";
        return Executor::doit($sql, $params);
    }
    
    public function actualizarusuario(){
        $sql = "UPDATE ".self::$tablename." SET usuario=:usuario WHERE id=:id";
        return Executor::doit($sql, [
            ':usuario' => $this->usuario,
            ':id' => $this->id
        ]);
    }
    
    public function actualizarpassword(){
        $sql = "UPDATE ".self::$tablename." SET password=:password WHERE id=:id";
        return Executor::doit($sql, [
            ':password' => $this->password,
            ':id' => $this->id
        ]);
    }

    public static function verid($id){
        $sql = "select * from ".self::$tablename." where id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0],new UserData());
    }
    
    public function eliminar(){
        $sql = "delete from ".self::$tablename." where id=$this->id";
        Executor::doit($sql);
    }

    public static function duplicidad($dni){
        $sql = "select * from ".self::$tablename." where dni=$dni";
        $query = Executor::doit($sql);
        return Model::many($query[0],new UserData());
    }
    
    public static function evitarduplicidad($dni, $id){
        $sql = "select * from ".self::$tablename." where dni=$dni AND id != $id";
        $query = Executor::doit($sql);
        return Model::many($query[0],new UserData());
    }

    public static function vercontenido(){
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0],new UserData());
    }

    public static function vercontenidopaginado($start, $length, $search=''){
        $sql = "select * from ".self::$tablename;
        if($search){
            $sql .= " where nombre like '%$search%' or apellido like '%$search%' or dni like '%$search%'";
        }
        $sql .= " limit $start, $length";
        $query = Executor::doit($sql);
        return Model::many($query[0],new UserData());
    }

    public static function totalregistros(){
        $sql = "select count(*) as total from ".self::$tablename;
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new UserData());
        return $result->total;
    }

    public static function totalregistrosbuscados($search=''){
        $sql = "select count(*) as total from ".self::$tablename;
        if($search){
            $sql .= " where nombre like '%$search%' or apellido like '%$search%' or dni like '%$search%'";
        }
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new UserData());
        return $result->total;
    }
}
?>