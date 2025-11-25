<?php

class Clientes extends Core {
    
    private $clienteModel;
    
    public function __construct() {
        parent::__construct();
        
        // Verificar autenticación
        if (!Security::isAuthenticated()) {
            $this->redirect('auth/login');
        }
        
        // Cargar el modelo
        $this->clienteModel = $this->model('Cliente');
    }
    
    /**
     * Obtener datos del usuario para las vistas
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
     * Lista de clientes
     */
    public function index() {
        // Obtener todos los clientes
        $clientes = $this->clienteModel->getAllWithRelations();
        
        $data = array_merge($this->getUserDataForView(), [
            'title' => 'Clientes - WankaShop',
            'clientes' => $clientes,
            'mensaje' => Lb::getMessage()
        ]);
        
        $this->view('clientes/index', $data);
    }
    
    /**
     * Obtener cliente por ID (AJAX)
     */
    public function obtener($id) {
        try {
            $cliente = $this->clienteModel->getByIdWithRelations($id);
            
            if (!$cliente) {
                $this->json(['success' => false, 'message' => 'Cliente no encontrado'], 404);
            }
            
            $this->json(['success' => true, 'cliente' => $cliente]);
            
        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Guardar nuevo cliente
     */
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Método no permitido'], 405);
        }
        
        try {
            // Validar datos requeridos
            $required = ['nombres', 'dni', 'negocio'];
            $validation = (new Executor())->validateRequired($_POST, $required);
            
            if (!$validation['valid']) {
                $this->json([
                    'success' => false, 
                    'message' => 'Campos requeridos: ' . implode(', ', $validation['missing'])
                ], 400);
            }
            
            // Validar DNI único
            if ($this->clienteModel->existeDNI($_POST['dni'])) {
                $this->json([
                    'success' => false, 
                    'message' => 'El DNI ya está registrado'
                ], 400);
            }
            
            // Validar email único si se proporciona
            if (!empty($_POST['email']) && $this->clienteModel->existeEmail($_POST['email'])) {
                $this->json([
                    'success' => false, 
                    'message' => 'El email ya está registrado'
                ], 400);
            }
            
            // Validar formato DNI (8 dígitos)
            if (!preg_match('/^[0-9]{8}$/', $_POST['dni'])) {
                $this->json([
                    'success' => false, 
                    'message' => 'El DNI debe tener 8 dígitos'
                ], 400);
            }
            
            // Preparar datos
            $data = [
                'negocio' => (int)$_POST['negocio'],
                'nombres' => Security::clean($_POST['nombres']),
                'apellido_paterno' => Security::clean($_POST['apellido_paterno'] ?? ''),
                'apellido_materno' => Security::clean($_POST['apellido_materno'] ?? ''),
                'dni' => Security::clean($_POST['dni']),
                'telefono' => Security::clean($_POST['telefono'] ?? ''),
                'email' => Security::clean($_POST['email'] ?? ''),
                'fecha_nacimiento' => !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null,
                'direccion' => Security::clean($_POST['direccion'] ?? ''),
                'genero' => Security::clean($_POST['genero'] ?? 'NO_ESPECIFICA')
            ];
            
            // Crear cliente
            $id = $this->clienteModel->crear($data);
            
            $this->json([
                'success' => true, 
                'message' => 'Cliente registrado exitosamente',
                'id' => $id
            ]);
            
        } catch (Exception $e) {
            $this->json([
                'success' => false, 
                'message' => 'Error al registrar cliente: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Actualizar cliente
     */
    public function actualizar($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Método no permitido'], 405);
        }
        
        try {
            // Validar que el cliente existe
            $cliente = $this->clienteModel->find($id);
            if (!$cliente) {
                $this->json(['success' => false, 'message' => 'Cliente no encontrado'], 404);
            }
            
            // Validar datos requeridos
            $required = ['nombres', 'dni', 'negocio'];
            $validation = (new Executor())->validateRequired($_POST, $required);
            
            if (!$validation['valid']) {
                $this->json([
                    'success' => false, 
                    'message' => 'Campos requeridos: ' . implode(', ', $validation['missing'])
                ], 400);
            }
            
            // Validar DNI único (excepto el actual)
            if ($this->clienteModel->existeDNI($_POST['dni'], $id)) {
                $this->json([
                    'success' => false, 
                    'message' => 'El DNI ya está registrado por otro cliente'
                ], 400);
            }
            
            // Validar email único si se proporciona (excepto el actual)
            if (!empty($_POST['email']) && $this->clienteModel->existeEmail($_POST['email'], $id)) {
                $this->json([
                    'success' => false, 
                    'message' => 'El email ya está registrado por otro cliente'
                ], 400);
            }
            
            // Validar formato DNI
            if (!preg_match('/^[0-9]{8}$/', $_POST['dni'])) {
                $this->json([
                    'success' => false, 
                    'message' => 'El DNI debe tener 8 dígitos'
                ], 400);
            }
            
            // Preparar datos
            $data = [
                'negocio' => (int)$_POST['negocio'],
                'nombres' => Security::clean($_POST['nombres']),
                'apellido_paterno' => Security::clean($_POST['apellido_paterno'] ?? ''),
                'apellido_materno' => Security::clean($_POST['apellido_materno'] ?? ''),
                'dni' => Security::clean($_POST['dni']),
                'telefono' => Security::clean($_POST['telefono'] ?? ''),
                'email' => Security::clean($_POST['email'] ?? ''),
                'fecha_nacimiento' => !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null,
                'direccion' => Security::clean($_POST['direccion'] ?? ''),
                'genero' => Security::clean($_POST['genero'] ?? 'NO_ESPECIFICA')
            ];
            
            // Actualizar cliente
            $this->clienteModel->actualizar($id, $data);
            
            $this->json([
                'success' => true, 
                'message' => 'Cliente actualizado exitosamente'
            ]);
            
        } catch (Exception $e) {
            $this->json([
                'success' => false, 
                'message' => 'Error al actualizar cliente: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Eliminar cliente
     */
    public function eliminar($id) {
        try {
            $cliente = $this->clienteModel->find($id);
            
            if (!$cliente) {
                $this->json(['success' => false, 'message' => 'Cliente no encontrado'], 404);
            }
            
            // Eliminar cliente
            $this->clienteModel->eliminar($id);
            
            $this->json([
                'success' => true, 
                'message' => 'Cliente eliminado exitosamente'
            ]);
            
        } catch (Exception $e) {
            $this->json([
                'success' => false, 
                'message' => 'Error al eliminar cliente: ' . $e->getMessage()
            ], 500);
        }
    }
}