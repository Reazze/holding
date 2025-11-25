<?php

class Venta extends Model {

    protected $table = 'venta';

    /**
     * Obtener todas la ventas 
     */
    public function listar(){
      $sql =  "select * from venta";
    }
    
  
}
