<?php

class Productos extends Core {
    
    private $productoModel;
    
    public function __construct() {
        parent::__construct();
        
        // Verificar autenticación
        if (!Security::isAuthenticated()) {
            $this->redirect('auth/login');
        }
        
        // Cargar el modelo
        $this->productoModel = $this->model('Producto');
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
     * Lista de productos
     */
    public function index() {
        // Obtener todos los productos
        $productos = $this->productoModel->getAllWithRelations();
        
        $data = array_merge($this->getUserDataForView(), [
            'title' => 'Productos - WankaShop',
            'productos' => $productos,
            'mensaje' => Lb::getMessage()
        ]);
        
        $this->view('productos/index', $data);
    }
    
    /**
     * Obtener producto por ID (AJAX) - NUEVO
     */
    public function obtener($id) {
        try {
            $producto = $this->productoModel->getByIdWithRelations($id);
            
            if (!$producto) {
                $this->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
            }
            
            $this->json(['success' => true, 'producto' => $producto]);
            
        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Guardar nuevo producto (ACTUALIZADO para soportar AJAX)
     */
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Método no permitido'], 405);
        }
        
        try {
            // Validar datos requeridos
            $required = ['nombre', 'tipomaterial', 'negocio', 'precio_base'];
            $validation = (new Executor())->validateRequired($_POST, $required);
            
            if (!$validation['valid']) {
                $this->json([
                    'success' => false, 
                    'message' => 'Campos requeridos: ' . implode(', ', $validation['missing'])
                ], 400);
            }
            
            // Preparar datos
            $data = [
                'tipomaterial' => (int)$_POST['tipomaterial'],
                'negocio' => (int)$_POST['negocio'],
                'nombre' => Security::clean($_POST['nombre']),
                'descripcion' => Security::clean($_POST['descripcion'] ?? ''),
                'precio_base' => (float)$_POST['precio_base'],
                'precio_oferta' => !empty($_POST['precio_oferta']) ? (float)$_POST['precio_oferta'] : null,
                'stock' => (int)($_POST['stock'] ?? 0),
                'modelo' => Security::clean($_POST['modelo'] ?? ''),
                'color' => Security::clean($_POST['color'] ?? ''),
                'garantia' => Security::clean($_POST['garantia'] ?? ''),
                'dimensiones' => Security::clean($_POST['dimensiones'] ?? ''),
                'codigo' => Security::clean($_POST['codigo'] ?? ''),
                'serie' => Security::clean($_POST['serie'] ?? ''),
                'talla' => Security::clean($_POST['talla'] ?? ''),
                'par' => Security::clean($_POST['par'] ?? ''),
                'peso' => Security::clean($_POST['peso'] ?? ''),
                'materiales' => Security::clean($_POST['materiales'] ?? ''),
                'estado' => 1
            ];
            
            // Manejar imagen si existe
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
                $uploadDir = 'storage/archivo/productos';
                
                // Crear directorio si no existe
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $upload = Lb::uploadFile(
                    $_FILES['imagen'], 
                    $uploadDir,
                    ['jpg', 'jpeg', 'png', 'webp', 'gif']
                );
                
                if ($upload['success']) {
                    $data['imagen'] = $upload['filename'];
                }
            }
            
            // Crear producto
            $id = $this->productoModel->crear($data);
            
            $this->json([
                'success' => true, 
                'message' => 'Producto creado exitosamente',
                'id' => $id
            ]);
            
        } catch (Exception $e) {
            $this->json([
                'success' => false, 
                'message' => 'Error al crear producto: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Actualizar producto (ACTUALIZADO para soportar AJAX)
     */
    public function actualizar($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Método no permitido'], 405);
        }
        
        try {
            // Validar que el producto existe
            $producto = $this->productoModel->find($id);
            if (!$producto) {
                $this->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
            }
            
            // Validar datos requeridos
            $required = ['nombre', 'tipomaterial', 'negocio', 'precio_base'];
            $validation = (new Executor())->validateRequired($_POST, $required);
            
            if (!$validation['valid']) {
                $this->json([
                    'success' => false, 
                    'message' => 'Campos requeridos: ' . implode(', ', $validation['missing'])
                ], 400);
            }
            
            // Preparar datos
            $data = [
                'tipomaterial' => (int)$_POST['tipomaterial'],
                'negocio' => (int)$_POST['negocio'],
                'nombre' => Security::clean($_POST['nombre']),
                'descripcion' => Security::clean($_POST['descripcion'] ?? ''),
                'precio_base' => (float)$_POST['precio_base'],
                'precio_oferta' => !empty($_POST['precio_oferta']) ? (float)$_POST['precio_oferta'] : null,
                'stock' => (int)($_POST['stock'] ?? 0),
                'modelo' => Security::clean($_POST['modelo'] ?? ''),
                'color' => Security::clean($_POST['color'] ?? ''),
                'garantia' => Security::clean($_POST['garantia'] ?? ''),
                'dimensiones' => Security::clean($_POST['dimensiones'] ?? ''),
                'codigo' => Security::clean($_POST['codigo'] ?? ''),
                'serie' => Security::clean($_POST['serie'] ?? ''),
                'talla' => Security::clean($_POST['talla'] ?? ''),
                'par' => Security::clean($_POST['par'] ?? ''),
                'peso' => Security::clean($_POST['peso'] ?? ''),
                'materiales' => Security::clean($_POST['materiales'] ?? ''),
                'imagen' => $producto['imagen'], // Mantener imagen actual
                'estado' => (int)($_POST['estado'] ?? 1)
            ];
            
            // Manejar nueva imagen si existe
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
                $uploadDir = 'storage/archivo/productos';
                
                $upload = Lb::uploadFile(
                    $_FILES['imagen'], 
                    $uploadDir,
                    ['jpg', 'jpeg', 'png', 'webp', 'gif']
                );
                
                if ($upload['success']) {
                    // Eliminar imagen anterior si existe
                    if (!empty($producto['imagen']) && file_exists($uploadDir . '/' . $producto['imagen'])) {
                        unlink($uploadDir . '/' . $producto['imagen']);
                    }
                    $data['imagen'] = $upload['filename'];
                }
            }
            
            // Actualizar producto
            $this->productoModel->actualizar($id, $data);
            
            $this->json([
                'success' => true, 
                'message' => 'Producto actualizado exitosamente'
            ]);
            
        } catch (Exception $e) {
            $this->json([
                'success' => false, 
                'message' => 'Error al actualizar producto: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Eliminar producto (ACTUALIZADO para soportar AJAX)
     */
    public function eliminar($id) {
        try {
            $producto = $this->productoModel->find($id);
            
            if (!$producto) {
                $this->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
            }
            
            // Cambiar estado a 0
            $this->productoModel->eliminar($id);
            
            $this->json([
                'success' => true, 
                'message' => 'Producto eliminado exitosamente'
            ]);
            
        } catch (Exception $e) {
            $this->json([
                'success' => false, 
                'message' => 'Error al eliminar producto: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Activar producto
     */
    public function activar($id) {
        try {
            $this->productoModel->activar($id);
            
            $this->json([
                'success' => true, 
                'message' => 'Producto activado exitosamente'
            ]);
            
        } catch (Exception $e) {
            $this->json([
                'success' => false, 
                'message' => 'Error al activar producto: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Ver detalle de producto (mantenido para compatibilidad)
     */
    public function ver($id) {
        $producto = $this->productoModel->getByIdWithRelations($id);
        
        if (!$producto) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Producto no encontrado'
            ];
            $this->redirect('productos');
        }
        
        $data = array_merge($this->getUserDataForView(), [
            'title' => 'Detalle Producto - WankaShop',
            'producto' => $producto
        ]);
        
        $this->view('productos/ver', $data);
    }
}
