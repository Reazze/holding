<?php

class Marca extends Model {

    protected $table = 'marca';

    /**
     * Obtener todas la ventas 
     */
    public function listar(){
      $sql =  "select * from marca";
    }
    
  
}
