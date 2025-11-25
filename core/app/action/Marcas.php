<?php

class Marcas extends Core {
    
    private $marcaModel;
    
    public function __construct() {
        parent::__construct();

        // Autenticación obligatoria
        if (!Security::isAuthenticated()) {
            $this->redirect('auth/login');
        }

        // Cargar modelo
        $this->marcaModel = $this->model('Marca');
    }

    /**
     * Datos del usuario para la vista
     */
    private function getUserDataForView() {
        $userData = Security::getUserData();
        
        return [
            'userName' => $userData['nombre'] ?? 'Usuario',
            'userApellido' => $userData['apellido'] ?? '',
            'userNombreCompleto' => $userData['nombre_completo'] ?? 'Usuario',
            'userEmail' => $userData['email'] ?? '',
            'userRole' => $userData['cargo_nombre'] ?? 'Usuario',
            'userPhoto' => $userData['foto'] ?? ASSETS . 'images/faces/default-user.jpg',
            'appName' => 'WankaShop',
            'appVersion' => '1.0.0'
        ];
    }

    /**
     * Vista principal del inventario
     */
    public function index() {
        // Obtener datos del inventario
        $marcas = $this->marcaModel->listar();
        $data = array_merge($this->getUserDataForView(), [
            'title' => 'Marcas - WankaShop',
            'marcas' => $marcas,
            'mensaje' => Lb::getMessage()
        ]);

        $this->view('productos/marcas', $data);
    }

}
