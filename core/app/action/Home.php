<?php

class Home extends Core {
    
    public function __construct() {
        parent::__construct();
        
        // Verificar que esté autenticado
        if (!Security::isAuthenticated()) {
            $this->redirect('auth/login');
        }
    }
    
    /**
 * Vista principal del dashboard
 */
public function index() {
    
    // Obtener datos del usuario actual desde la sesión
    $userData = Security::getUserData();
    
    // Datos para el dashboard y layout
    $data = [
        'title' => 'Dashboard - WankaShop',
        'userName' => $userData['nombre'] ?? 'Usuario',
        'userApellido' => $userData['apellido'] ?? '',
        'userNombreCompleto' => $userData['nombre_completo'] ?? 'Usuario',
        'userEmail' => $userData['email'] ?? '',
        'userRole' => $userData['cargo_nombre'] ?? 'Usuario',
        'userPhoto' => $userData['url_foto'] ?? ASSETS . 'images/faces/default-user.png',
        'appName' => 'WankaShop',
        'appVersion' => '1.0.0',
        
        // Estadísticas del dashboard
        'stats' => $this->getStats()
    ];
    
    // Renderizar vista
    $this->view('dashboard/home', $data);
}
    
    /**
     * Obtener estadísticas básicas
     */
    private function getStats() {
        try {
            $db = new Database();
            
            // Total de productos
            $productos = $db->selectOne("SELECT COUNT(*) as total FROM producto");
            
            // Total de clientes
            $clientes = $db->selectOne("SELECT COUNT(*) as total FROM cliente");
            
            // Total de ventas
            $ventas = $db->selectOne("SELECT COUNT(*) as total FROM venta");
            
            // Total en ventas
            $totalVentas = $db->selectOne("SELECT COALESCE(SUM(total), 0) as total FROM venta");
            
            return [
                'productos' => $productos['total'] ?? 0,
                'clientes' => $clientes['total'] ?? 0,
                'numVentas' => $ventas['total'] ?? 0,
                'totalVentas' => $totalVentas['total'] ?? 0
            ];
            
        } catch (Exception $e) {
            return [
                'productos' => 0,
                'clientes' => 0,
                'numVentas' => 0,
                'totalVentas' => 0
            ];
        }
    }
}