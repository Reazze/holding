<?php

class Categoria extends Model {

    protected $table = 'categoria';

    /**
     * Obtener todas la ventas 
     */
    public function listar(){
      $sql =  "select * from categoria";
    }
    
  
}
