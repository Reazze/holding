<?php

class Inventario extends Model {

    protected $table = 'inventario';

    /**
     * Obtener todo el inventario con su categoría
     */
    public function listar(){
      $sql =  "select * from almacen";
    }
    
  
}
