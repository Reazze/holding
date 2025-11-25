<?php

class Auth extends Core {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Mostrar formulario de login
     */
    public function login() {
        // Si ya está logueado, redirigir al dashboard
        if (Security::isAuthenticated()) {
            $this->redirect('home');
        }
        
        // Obtener mensaje flash si existe
        $message = null;
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
        }
        
        $data = [
            'title' => 'Iniciar Sesión - WankaShop',
            'error' => $message
        ];
        
        // Cargar vista de login SIN layout
        $this->viewOnly('auth/login', $data);
    }
    
   /**
     * Procesar login
     */
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/login');
        }
        
        // Obtener datos del formulario
        $email = Security::clean($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Validar campos vacíos
        if (empty($email) || empty($password)) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Por favor, complete todos los campos'
            ];
            $this->redirect('auth/login');
        }
        
        // Buscar usuario con datos completos (incluyendo apellido y foto)
        $db = new Database();
        $user = $db->selectOne(
            "SELECT 
                u.id,
                u.nombre,
                u.apellido,
                u.email,
                u.password,
                u.url_foto,
                u.estado,
                u.cargo,
                c.nombre as cargo_nombre
            FROM usuario u
            LEFT JOIN cargo c ON u.cargo = c.id
            WHERE u.email = ? AND u.estado = 1", 
            [$email]
        );
        
        // Verificar si existe el usuario
        if (!$user) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Credenciales incorrectas'
            ];
            $this->redirect('auth/login');
        }
        
        // Verificar contraseña
        if (!Security::verifyPassword($password, $user['password'])) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Credenciales incorrectas'
            ];
            $this->redirect('auth/login');
        }
        
        // Preparar foto del usuario
        $foto = !empty($user['url_foto']) 
            ? BASE_URL . $user['url_foto']
            : ASSETS . 'images/faces/default-user.png';
        
        // Nombre completo
        $nombreCompleto = trim($user['nombre'] . ' ' . ($user['apellido'] ?? ''));
        
        // Login exitoso - Crear sesión con datos completos
        Security::login($user['id'], [
            'nombre' => $user['nombre'],
            'apellido' => $user['apellido'] ?? '',
            'nombre_completo' => $nombreCompleto,
            'email' => $user['email'],
            'cargo_id' => $user['id_cargo'],
            'cargo_nombre' => $user['cargo_nombre'] ?? 'Usuario',
            'url_foto' => $foto
        ]);
        
        // Redirigir al dashboard
        $this->redirect('home');
    }
    
    /**
     * Cerrar sesión
     */
    public function logout() {
        Security::logout();
        $this->redirect('auth/login');
    }
}