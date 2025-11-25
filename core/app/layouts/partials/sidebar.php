<nav class="sidebar sidebar-offcanvas" id="sidebar">
  
  <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top width-full">
    <a class="sidebar-brand brand-logo" href="<?= BASE_URL ?>"><img src="<?= ASSETS ?>images/holding-Logotipo.png" alt="logo"  style="width:200px; height:auto;"/></a>
    <a class="sidebar-brand brand-logo-mini" href="<?= BASE_URL ?>"><img src="<?= ASSETS ?>images/holding-Isotipo.png"  alt="logo"  style="width:40px; height:auto; pading-right:20px;"/></a>
  </div>
  <ul class="nav">
    <!-- Perfil de Usuario DINÁMICO -->
    <li class="nav-item profile">
      <div class="profile-desc">
        <div class="profile-pic">
          <div class="count-indicator">
            <img class="img-xs rounded-circle" 
                src="<?= $userPhoto ?? ASSETS . 'images/faces/default-user.png' ?>" 
                alt="<?= $userNombreCompleto ?? 'Usuario' ?>"
                onerror="this.src='<?= ASSETS ?>images/faces/default-user.png'">
            <span class="count bg-success"></span>
          </div>
          <div class="profile-name">
            <h5 class="mb-0 font-weight-normal">
              <?= $userNombreCompleto ?? $userName ?? 'Usuario' ?>
            </h5>
            <span><?= $userRole ?? 'Usuario' ?></span>
          </div>
        </div>
        <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
        <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
          <a href="<?= BASE_URL ?>perfil" class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-account text-primary"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject ellipsis mb-1 text-small">Mi Perfil</p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= BASE_URL ?>cambiar-password" class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-onepassword text-info"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject ellipsis mb-1 text-small">Cambiar Contraseña</p>
            </div>
          </a>
        </div>
    </li>

    <!-- Navegación Principal -->
    <li class="nav-item nav-category">
      <span class="nav-link">MENÚ PRINCIPAL</span>
    </li>

    <!-- Dashboard -->
    <li class="nav-item menu-items">
      <a class="nav-link" href="<?= BASE_URL ?>">
        <span class="menu-icon">
          <i class="mdi mdi-speedometer"></i>
        </span>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <!-- PRODUCTOS -->
    <li class="nav-item menu-items">
      <a class="nav-link" data-toggle="collapse" href="#productos" aria-expanded="false" aria-controls="productos">
        <span class="menu-icon">
          <i class="mdi mdi-package-variant"></i>
        </span>
        <span class="menu-title">Productos</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="productos">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> 
            <a class="nav-link" href="<?= BASE_URL ?>productos">
              <i class="mdi mdi-view-list"></i> Lista de Productos
            </a>
          </li>
          <li class="nav-item"> 
            <a class="nav-link" href="<?= BASE_URL ?>categorias">
              <i class="mdi mdi-tag-multiple"></i> Categorías
            </a>
          </li>
          <li class="nav-item"> 
            <a class="nav-link" href="<?= BASE_URL ?>marcas">
              <i class="mdi mdi-certificate"></i> Marcas
            </a>
          </li>
        </ul>
      </div>
    </li>

    <!-- VENTAS -->
    <li class="nav-item menu-items">
      <a class="nav-link" data-toggle="collapse" href="#ventas" aria-expanded="false" aria-controls="ventas">
        <span class="menu-icon">
          <i class="mdi mdi-cart"></i>
        </span>
        <span class="menu-title">Ventas</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ventas">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>nuevaventa">Nueva Venta</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>listaventa">Lista de Ventas</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>pedidos">Pedidos</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>metodos-pago">Métodos de Pago</a></li>
        </ul>
      </div>
    </li>

    <!-- COMPRAS -->
    <li class="nav-item menu-items">
      <a class="nav-link" data-toggle="collapse" href="#compras" aria-expanded="false" aria-controls="compras">
        <span class="menu-icon">
          <i class="mdi mdi-truck"></i>
        </span>
        <span class="menu-title">Compras</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="compras">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>compras/nueva">Nueva Compra</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>compras/lista">Lista de Compras</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>proveedores">Proveedores</a></li>
        </ul>
      </div>
    </li>

    <!-- INVENTARIO -->
    <li class="nav-item menu-items">
      <a class="nav-link" data-toggle="collapse" href="#inventario" aria-expanded="false" aria-controls="inventario">
        <span class="menu-icon">
          <i class="mdi mdi-warehouse"></i>
        </span>
        <span class="menu-title">Inventario</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="inventario">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>almacen">Almacén</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>inventario/reporte">Reporte de Stock</a></li>
        </ul>
      </div>
    </li>

    <!-- CLIENTES -->
    <li class="nav-item menu-items">
      <a class="nav-link" href="<?= BASE_URL ?>clientes">
        <span class="menu-icon">
          <i class="mdi mdi-account-multiple"></i>
        </span>
        <span class="menu-title">Clientes</span>
      </a>
    </li>

    <!-- CAJA -->
    <li class="nav-item menu-items">
      <a class="nav-link" data-toggle="collapse" href="#caja" aria-expanded="false" aria-controls="caja">
        <span class="menu-icon">
          <i class="mdi mdi-cash-multiple"></i>
        </span>
        <span class="menu-title">Caja</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="caja">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>caja/apertura">Apertura de Caja</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>caja/central">Caja Central</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>caja/movimientos">Movimientos</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>capital">Capital</a></li>
        </ul>
      </div>
    </li>

    <!-- Separador -->
    <li class="nav-item nav-category">
      <span class="nav-link">GESTIÓN WEB</span>
    </li>

    <!-- SITIO WEB -->
    <li class="nav-item menu-items">
      <a class="nav-link" data-toggle="collapse" href="#web" aria-expanded="false" aria-controls="web">
        <span class="menu-icon">
          <i class="mdi mdi-web"></i>
        </span>
        <span class="menu-title">Sitio Web</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="web">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>carousel">Carrusel/Banners</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>anuncios">Anuncios</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>nosotros">Nosotros</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>contacto">Contacto</a></li>
        </ul>
      </div>
    </li>

    <!-- Separador -->
    <li class="nav-item nav-category">
      <span class="nav-link">CONFIGURACIÓN</span>
    </li>

    <!-- CONFIGURACIÓN DEL NEGOCIO -->
    <li class="nav-item menu-items">
      <a class="nav-link" href="<?= BASE_URL ?>negocio/configuracion">
        <span class="menu-icon">
          <i class="mdi mdi-store"></i>
        </span>
        <span class="menu-title">Mi Negocio</span>
      </a>
    </li>

    <!-- USUARIOS Y PERMISOS -->
    <li class="nav-item menu-items">
      <a class="nav-link" data-toggle="collapse" href="#usuarios" aria-expanded="false" aria-controls="usuarios">
        <span class="menu-icon">
          <i class="mdi mdi-account-key"></i>
        </span>
        <span class="menu-title">Usuarios</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="usuarios">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>usuarios">Lista de Usuarios</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>cargos">Cargos</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>permisos">Permisos</a></li>
        </ul>
      </div>
    </li>

    <!-- REPORTES -->
    <li class="nav-item menu-items">
      <a class="nav-link" data-toggle="collapse" href="#reportes" aria-expanded="false" aria-controls="reportes">
        <span class="menu-icon">
          <i class="mdi mdi-chart-bar"></i>
        </span>
        <span class="menu-title">Reportes</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="reportes">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>reportes/ventas">Ventas</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>reportes/compras">Compras</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>reportes/producto">Productos</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>reportes/cliente">Clientes</a></li>
        </ul>
      </div>
    </li>

  </ul>
</nav>