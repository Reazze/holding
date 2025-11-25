<!-- Page Header -->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="font-weight-bold">Bienvenido al Dashboard</h3>
                <h6 class="font-weight-normal mb-0">Sistema de Gestión E-commerce - WankaShop</h6>
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-primary btn-icon-text">
                    <i class="mdi mdi-calendar-today btn-icon-prepend"></i> 
                    <?= date('d/m/Y') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row">
    
    <!-- Total Ventas -->
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="<?= ASSETS ?>images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">
                    Total Ventas
                    <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                </h4>
                <h2 class="mb-5">S/ <?= number_format($stats['totalVentas'], 2) ?></h2>
                <h6 class="card-text"><?= $stats['numVentas'] ?> ventas realizadas</h6>
            </div>
        </div>
    </div>
    
    <!-- Total Productos -->
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="<?= ASSETS ?>images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">
                    Total Productos
                    <i class="mdi mdi-package-variant mdi-24px float-right"></i>
                </h4>
                <h2 class="mb-5"><?= number_format($stats['productos']) ?></h2>
                <h6 class="card-text">En catálogo</h6>
            </div>
        </div>
    </div>
    
    <!-- Total Clientes -->
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="<?= ASSETS ?>images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">
                    Total Clientes
                    <i class="mdi mdi-account-multiple mdi-24px float-right"></i>
                </h4>
                <h2 class="mb-5"><?= number_format($stats['clientes']) ?></h2>
                <h6 class="card-text">Clientes registrados</h6>
            </div>
        </div>
    </div>
    
    <!-- Pedidos -->
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-gradient-warning card-img-holder text-white">
            <div class="card-body">
                <img src="<?= ASSETS ?>images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">
                    Sistema
                    <i class="mdi mdi-cogs mdi-24px float-right"></i>
                </h4>
                <h2 class="mb-5">Activo</h2>
                <h6 class="card-text">Todo funcionando</h6>
            </div>
        </div>
    </div>
    
</div>

<!-- Welcome Card -->
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title mb-0">Dashboard WankaShop E-commerce</h4>
                        <p class="card-description mt-2">
                            Sistema de gestión completo para tu negocio online
                        </p>
                    </div>
                    <div>
                        <span class="badge badge-success badge-pill">v<?= $appVersion ?></span>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-bg bg-primary-gradient rounded-circle p-3 mr-3">
                                <i class="mdi mdi-cart text-white mdi-24px"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Gestión de Ventas</h6>
                                <small class="text-muted">Control completo de ventas</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-bg bg-success-gradient rounded-circle p-3 mr-3">
                                <i class="mdi mdi-package-variant text-white mdi-24px"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Inventario</h6>
                                <small class="text-muted">Control de stock y productos</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-bg bg-info-gradient rounded-circle p-3 mr-3">
                                <i class="mdi mdi-chart-bar text-white mdi-24px"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Reportes</h6>
                                <small class="text-muted">Análisis y estadísticas</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <p class="text-muted mb-2">
                        <i class="mdi mdi-database-check text-success"></i> 
                        Conectado a la base de datos: <strong>wankashopx</strong>
                    </p>
                    <p class="text-muted">
                        <i class="mdi mdi-clock-outline"></i> 
                        Fecha y hora: <strong><?= date('d/m/Y H:i:s') ?></strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>