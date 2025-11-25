<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="<?= ASSETS ?>vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= ASSETS ?>vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?= ASSETS ?>css/login.css">
    <link rel="shortcut icon" href="<?= ASSETS ?>images/favicon.png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
    <link rel="stylesheet" href="style.css" />
    <title>WankaShop</title>
  </head>

  <body>
    <div class="container" id="container">
      <div class="form-container sign-up">
        <form>
          <h1>Crear Usuario</h1>
          <div class="social-icons">
            <a href="#" class="icon"
              ><i class="fa-brands fa-google-plus-g"></i
            ></a>
            <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
            <a href="#" class="icon"
              ><i class="fa-brands fa-linkedin-in"></i
            ></a>
          </div>
          <span>or use your email for registeration</span>
          <input type="text" placeholder="Name" />
          <input type="email" placeholder="Email" />
          <input type="password" placeholder="Password" />
          <button>Registrar</button>
        </form>
      </div>
      <div class="form-container sign-in">
        <form method="POST" action="<?= BASE_URL ?>auth/processLogin">
          <h1>WankaShop</h1>
          <?php if($error): ?>
            <div class="alert alert-danger">
                <?= $error['message'] ?>
            </div>
            <?php endif; ?>

          <div class="social-icons">
            <a href="#" class="icon"
              ><i class="fa-brands fa-google-plus-g"></i
            ></a>
            <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
            <a href="#" class="icon"
              ><i class="fa-brands fa-linkedin-in"></i
            ></a>
          </div>
          <span>Utilice su contraseña y correo electrónico.</span>
          <input type="email" name="email" required />
          <input type="password" name="password" required />
          <a href="#">Forget Your Password?</a>
          <button>Iniciar Sesión</button>
        </form>
      </div>
      <div class="toggle-container">
        <div class="toggle">
          <div class="toggle-panel toggle-left">
            <h1>¡Bienvenido de nuevo!</h1>
            <p>Introduce tus datos personales para usar todas las funciones del sitio.</p>
            <button class="hidden" id="login"><--- Iniciar Sesión</button>
          </div>
          <div class="toggle-panel toggle-right">
            <h1>¡Hola, amigo/a!</h1>
            <p>
                Regístrate con tus datos personales para usar todas las funciones del sitio.
            </p>
            <button class="hidden" id="register">Registrar</button>
          </div>
        </div>
      </div>
    </div>
    <script src="<?= ASSETS ?>js/script.js"></script>
  </body>
</html>