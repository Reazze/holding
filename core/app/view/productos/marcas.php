<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="font-weight-bold mb-0">Gestión de Marcas</h3>
                <p class="text-muted mb-0">Lista completa de Marcas en los productos del sistema</p>
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-icon-text" data-toggle="modal" data-target="#modalCrearProducto">
                    <i class="mdi mdi-plus btn-icon-prepend"></i>
                    Nuevo Producto
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Mensaje Flash -->
<?php if(isset($mensaje) && $mensaje): ?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-<?= $mensaje['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
            <strong><?= $mensaje['type'] === 'success' ? '¡Éxito!' : 'Error:' ?></strong> 
            <?= $mensaje['message'] ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Filtros y Búsqueda -->
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <div class="input-group">
                                <input type="text" 
                                       class="form-control" 
                                       id="searchInput" 
                                       placeholder="Buscar por nombre, código, modelo...">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="button">
                                        <i class="mdi mdi-magnify"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="filterEstado">
                            <option value="">Todos los estados</option>
                            <option value="1">Activos</option>
                            <option value="0">Inactivos</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-sm btn-success" onclick="location.reload()">
                            <i class="mdi mdi-refresh"></i> Recargar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
