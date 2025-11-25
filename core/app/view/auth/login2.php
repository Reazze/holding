<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - WankaShop</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= ASSETS ?>vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= ASSETS ?>vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?= ASSETS ?>css/style.css">
    <link rel="shortcut icon" href="<?= ASSETS ?>images/favicon.png" />
    
    <style>
        .auth .login-half-bg {
            background: url('<?= ASSETS ?>images/auth/login-bg.jpg');
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo text-center">
                                <img src="<?= ASSETS ?>images/logo.svg" alt="logo">
                            </div>
                            <h4 class="text-center">¡Hola! Bienvenido</h4>
                            <h6 class="font-weight-light text-center">Inicia sesión para continuar</h6>
                            
                            <!-- Mostrar mensaje de error -->
                            <?php if($error): ?>
                                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                    <strong>Error:</strong> <?= $error['message'] ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Formulario de Login -->
                            <form class="pt-3" method="POST" action="<?= BASE_URL ?>auth/processLogin">
                                
                                <!-- Email -->
                                <div class="form-group">
                                    <input type="email" 
                                           class="form-control form-control-lg" 
                                           id="email" 
                                           name="email" 
                                           placeholder="Email" 
                                           required
                                           autofocus>
                                </div>
                                
                                <!-- Password -->
                                <div class="form-group">
                                    <input type="password" 
                                           class="form-control form-control-lg" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Contraseña" 
                                           required>
                                </div>
                                
                                <!-- Botón Login -->
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                                        INICIAR SESIÓN
                                    </button>
                                </div>
                                
                                <!-- Recordar contraseña -->
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input" name="remember">
                                            Recordarme
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                    <a href="#" class="auth-link text-black">¿Olvidaste tu contraseña?</a>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="<?= ASSETS ?>vendors/js/vendor.bundle.base.js"></script>
    <script src="<?= ASSETS ?>js/off-canvas.js"></script>
    <script src="<?= ASSETS ?>js/hoverable-collapse.js"></script>
    <script src="<?= ASSETS ?>js/misc.js"></script>
</body>
</html>