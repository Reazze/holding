<nav class="navbar p-0 fixed-top d-flex ">
  <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
    <a class="sidebar-brand brand-logo" href="<?= BASE_URL ?>"><img src="<?= ASSETS ?>images/holding-Logotipo.png" alt="logo"  style="width:150px; height:auto; margin-left:100px;"/></a>
  </div>
  <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>
    <ul class="navbar-nav w-100">
      <li class="nav-item w-100">
        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
          <input type="text" class="form-control" placeholder="Buscar...">
        </form>
      </li>
    </ul>
    <ul class="navbar-nav navbar-nav-right">
      
      <!-- Theme Switcher -->
      <li class="nav-item nav-theme-toggle d-flex align-items-center mr-3">
        <button type="button" class="theme-toggle" id="themeToggle" title="Cambiar tema">
            <div class="theme-toggle-slider">
                <i class="mdi mdi-moon-waning-crescent theme-toggle-icon"></i>
                <i class="mdi mdi-white-balance-sunny theme-toggle-icon"></i>
            </div>
        </button>
      </li>

      <li class="nav-item nav-settings d-none d-lg-block">
        <a class="nav-link" href="#">
          <i class="mdi mdi-view-grid"></i>
        </a>
      </li>
      
      <!-- Mensajes -->
      <li class="nav-item dropdown border-left">
        <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <i class="mdi mdi-email"></i>
          <span class="count bg-success"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
          <h6 class="p-3 mb-0">Mensajes</h6>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img src="<?= ASSETS ?>images/faces/face4.jpg" alt="image" class="rounded-circle profile-pic">
            </div>
            <div class="preview-item-content">
              <p class="preview-subject ellipsis mb-1">Nuevo mensaje</p>
              <p class="text-muted mb-0"> 1 Minuto atrás </p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <p class="p-3 mb-0 text-center">Ver todos los mensajes</p>
        </div>
      </li>
      
      <!-- Notificaciones -->
      <li class="nav-item dropdown border-left">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
          <i class="mdi mdi-bell"></i>
          <span class="count bg-danger"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
          <h6 class="p-3 mb-0">Notificaciones</h6>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-calendar text-success"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject mb-1">Nueva notificación</p>
              <p class="text-muted ellipsis mb-0">Hace 5 minutos</p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <p class="p-3 mb-0 text-center">Ver todas las notificaciones</p>
        </div>
      </li>
      
      <!-- Perfil de Usuario DINÁMICO -->
      <li class="nav-item dropdown">
        <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
          <div class="navbar-profile">
            <img class="img-xs rounded-circle" 
                src="<?= $userPhoto ?? ASSETS . 'images/faces/default-user.png' ?>" 
                alt="<?= $userNombreCompleto ?? 'Usuario' ?>"
                onerror="this.src='<?= ASSETS ?>images/faces/default-user.png'">
            <p class="mb-0 d-none d-sm-block navbar-profile-name">
              <?= $userName ?? 'Usuario' ?>
            </p>
            <i class="mdi mdi-menu-down d-none d-sm-block"></i>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
          <h6 class="p-3 mb-0">
            <?= $userNombreCompleto ?? 'Usuario' ?>
            <br>
            <small class="text-muted"><?= $userEmail ?? '' ?></small>
          </h6>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item" href="<?= BASE_URL ?>perfil">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-account text-primary"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject mb-1">Mi Perfil</p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item" href="<?= BASE_URL ?>configuracion">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-settings text-success"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject mb-1">Configuración</p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item" href="<?= BASE_URL ?>auth/logout">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-logout text-danger"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject mb-1">Cerrar Sesión</p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <p class="p-3 mb-0 text-center">
            <small class="text-muted"><?= $userRole ?? 'Usuario' ?></small>
          </p>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-format-line-spacing"></span>
    </button>
  </div>
</nav>