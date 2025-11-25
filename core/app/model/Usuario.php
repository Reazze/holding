<?php

class Usuario extends Model {
    
    protected $table = 'usuario';
    
    /**
     * Obtener información completa del usuario con su cargo
     */
    public function getUsuarioConCargo($id) {
        $sql = "SELECT 
                    u.id,
                    u.nombre,
                    u.email,
                    u.url_foto,
                    u.estado,
                    c.nombre as cargo_nombre
                FROM usuario u
                LEFT JOIN cargo c ON u.cargo = c.id
                WHERE u.id = ? AND u.estado = 1";
        
        return $this->db->selectOne($sql, [$id]);
    }
    
    /**
     * Obtener foto del usuario o una por defecto
     */
    public function getFoto($id) {
        $user = $this->find($id);
        
        if ($user && !empty($user['url_foto'])) {
            // Si tiene foto personalizada
            return UPLOAD_PATH . '/usuarios/' . $user['url_foto'];
        }
        
        // Foto por defecto
        return ASSETS . 'images/faces/default-user.png';
    }
    
}