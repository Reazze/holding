<!-- Page Header -->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="font-weight-bold mb-0">Gestión de Productos</h3>
                <p class="text-muted mb-0">Lista completa de productos del sistema</p>
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

<!-- Tabla de Productos -->
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">
                        <i class="mdi mdi-package-variant text-primary"></i>
                        Lista de Productos
                    </h4>
                    <div>
                        <span class="badge badge-info">
                            Total: <strong id="totalProductos"><?= count($productos) ?></strong> productos
                        </span>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover" id="productosTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Código</th>
                                <th>Estado</th>
                                <th>Material</th>
                                <th>Precio Base</th>
                                <th>Precio Oferta</th>
                                <th>Stock</th>  
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($productos)): ?>
                                <?php foreach($productos as $index => $producto): ?>
                                <tr data-id="<?= $producto['id'] ?>">
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <?php if(!empty($producto['imagen'])): ?>
                                            <img src="<?= BASE_URL ?>storage/archivo/productos/<?= $producto['imagen'] ?>" 
                                                 alt="<?= $producto['nombre'] ?>" 
                                                 class="img-thumbnail" 
                                                 style="width: 50px; height: 50px; object-fit: cover;"
                                                 onerror="this.src='<?= ASSETS ?>images/no-image.png'">
                                        <?php else: ?>
                                            <img src="<?= ASSETS ?>images/no-image.png" 
                                                 alt="Sin imagen" 
                                                 class="img-thumbnail" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($producto['nombre']) ?></strong>
                                        <?php if(!empty($producto['modelo'])): ?>
                                            <br><small class="text-muted">Modelo: <?= htmlspecialchars($producto['modelo']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= !empty($producto['codigo']) ? htmlspecialchars($producto['codigo']) : '<span class="text-muted">-</span>' ?>
                                    </td>
                                    <td>
                                        <?php if($producto['estado'] == 1): ?>
                                            <span class="badge badge-success">
                                                <i class="mdi mdi-check"></i> Activo
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">
                                                <i class="mdi mdi-close"></i> Inactivo
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            <?= htmlspecialchars($producto['tipomaterial_nombre'] ?? 'Sin tipo') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong class="text-success">S/ <?= number_format($producto['precio_base'], 2) ?></strong>
                                    </td>
                                    <td>
                                        <?php if(!empty($producto['precio_oferta']) && $producto['precio_oferta'] > 0): ?>
                                            <strong class="text-danger">S/ <?= number_format($producto['precio_oferta'], 2) ?></strong>
                                            <br>
                                            <small class="badge badge-warning">
                                                <?php 
                                                    $descuento = (($producto['precio_base'] - $producto['precio_oferta']) / $producto['precio_base']) * 100;
                                                    echo round($descuento) . '% OFF';
                                                ?>
                                            </small>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $stock = (int)$producto['stock'];
                                            $stockClass = 'primary';
                                            if($stock <= 0) {
                                                $stockClass = 'danger';
                                            } elseif($stock <= 10) {
                                                $stockClass = 'warning';
                                            }
                                        ?>
                                        <span class="badge badge-<?= $stockClass ?>">
                                            <?= $stock ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <!-- Ver -->
                                            <button type="button" 
                                                    class="btn btn-sm btn" 
                                                    onclick="verProducto(<?= $producto['id'] ?>)"
                                                    title="Ver detalle">
                                                <i class="mdi mdi-eye text-info"></i>
                                            </button>
                                            
                                            <!-- Editar -->
                                            <button type="button" 
                                                    class="btn btn-sm btn" 
                                                    onclick="editarProducto(<?= $producto['id'] ?>)"
                                                    title="Editar">
                                                <i class="mdi mdi-pencil text-warning"></i>
                                            </button> 
                                            
                                            <!-- Eliminar -->
                                            <button type="button" 
                                                    class="btn btn-sm btn" 
                                                    onclick="eliminarProducto(<?= $producto['id'] ?>, '<?= htmlspecialchars($producto['nombre']) ?>')"
                                                    title="Eliminar">
                                                <i class="mdi mdi-delete text-danger"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center">
                                        <div class="py-5">
                                            <i class="mdi mdi-package-variant mdi-48px text-muted"></i>
                                            <p class="text-muted mt-3">No hay productos registrados</p>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCrearProducto">
                                                <i class="mdi mdi-plus"></i> Agregar primer producto
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CREAR PRODUCTO -->
<div class="modal fade" id="modalCrearProducto" tabindex="-1" role="dialog" aria-labelledby="modalCrearProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formCrearProducto" enctype="multipart/form-data">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalCrearProductoLabel">
                        <i class="mdi mdi-plus-circle"></i> Nuevo Producto
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna Izquierda -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre del Producto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombre" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Tipo de Material <span class="text-danger">*</span></label>
                                <select class="form-control" name="tipomaterial" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $db = new Database();
                                    $tipos = $db->select("SELECT * FROM tipomaterial ORDER BY nombre");
                                    foreach($tipos as $tipo):
                                    ?>
                                        <option value="<?= $tipo['id'] ?>"><?= $tipo['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Negocio <span class="text-danger">*</span></label>
                                <select class="form-control" name="negocio" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $negocios = $db->select("SELECT * FROM negocio WHERE estado = 1 ORDER BY nombre");
                                    foreach($negocios as $negocio):
                                    ?>
                                        <option value="<?= $negocio['id'] ?>"><?= $negocio['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Precio Base <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="precio_base" step="0.01" min="0" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Precio Oferta</label>
                                <input type="number" class="form-control" name="precio_oferta" step="0.01" min="0">
                            </div>
                            
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" class="form-control" name="stock" value="0" min="0">
                            </div>
                        </div>
                        
                        <!-- Columna Derecha -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Código</label>
                                <input type="text" class="form-control" name="codigo">
                            </div>
                            
                            <div class="form-group">
                                <label>Modelo</label>
                                <input type="text" class="form-control" name="modelo">
                            </div>
                            
                            <div class="form-group">
                                <label>Color</label>
                                <input type="text" class="form-control" name="color">
                            </div>
                            
                            <div class="form-group">
                                <label>Serie</label>
                                <input type="text" class="form-control" name="serie">
                            </div>
                            
                            <div class="form-group">
                                <label>Talla</label>
                                <input type="text" class="form-control" name="talla">
                            </div>
                            
                            <div class="form-group">
                                <label>Imagen</label>
                                <input type="file" class="form-control" name="imagen" accept="image/*">
                            </div>
                        </div>
                        
                        <!-- Descripción completa -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="mdi mdi-close"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-content-save"></i> Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDITAR PRODUCTO -->
<div class="modal fade" id="modalEditarProducto" tabindex="-1" role="dialog" aria-labelledby="modalEditarProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formEditarProducto" enctype="multipart/form-data">
                <input type="hidden" name="producto_id" id="edit_producto_id">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="modalEditarProductoLabel">
                        <i class="mdi mdi-pencil"></i> Editar Producto
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna Izquierda -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre del Producto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombre" id="edit_nombre" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Tipo de Material <span class="text-danger">*</span></label>
                                <select class="form-control" name="tipomaterial" id="edit_tipomaterial" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($tipos as $tipo): ?>
                                        <option value="<?= $tipo['id'] ?>"><?= $tipo['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Negocio <span class="text-danger">*</span></label>
                                <select class="form-control" name="negocio" id="edit_negocio" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($negocios as $negocio): ?>
                                        <option value="<?= $negocio['id'] ?>"><?= $negocio['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Precio Base <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="precio_base" id="edit_precio_base" step="0.01" min="0" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Precio Oferta</label>
                                <input type="number" class="form-control" name="precio_oferta" id="edit_precio_oferta" step="0.01" min="0">
                            </div>
                            
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" class="form-control" name="stock" id="edit_stock" min="0">
                            </div>
                            
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" name="estado" id="edit_estado">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Columna Derecha -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Código</label>
                                <input type="text" class="form-control" name="codigo" id="edit_codigo">
                            </div>
                            
                            <div class="form-group">
                                <label>Modelo</label>
                                <input type="text" class="form-control" name="modelo" id="edit_modelo">
                            </div>
                            
                            <div class="form-group">
                                <label>Color</label>
                                <input type="text" class="form-control" name="color" id="edit_color">
                            </div>
                            
                            <div class="form-group">
                                <label>Serie</label>
                                <input type="text" class="form-control" name="serie" id="edit_serie">
                            </div>
                            
                            <div class="form-group">
                                <label>Talla</label>
                                <input type="text" class="form-control" name="talla" id="edit_talla">
                            </div>
                            
                            <div class="form-group">
                                <label>Imagen Nueva</label>
                                <input type="file" class="form-control" name="imagen" accept="image/*">
                                <small class="text-muted">Deja vacío si no quieres cambiar la imagen</small>
                            </div>
                            
                            <div id="imagenActual"></div>
                        </div>
                        
                        <!-- Descripción completa -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea class="form-control" name="descripcion" id="edit_descripcion" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="mdi mdi-close"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="mdi mdi-content-save"></i> Actualizar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL ELIMINAR PRODUCTO -->
<div class="modal fade" id="modalEliminarProducto" tabindex="-1" role="dialog" aria-labelledby="modalEliminarProductoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalEliminarProductoLabel">
                    <i class="mdi mdi-alert"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este producto?</p>
                <div class="alert alert-warning">
                    <strong>Producto:</strong> <span id="delete_producto_nombre"></span>
                </div>
                <p class="text-muted">Esta acción cambiará el estado del producto a inactivo.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="mdi mdi-close"></i> Cancelar
                </button>
                <button type="button" class="btn btn-danger" onclick="confirmarEliminar()">
                    <i class="mdi mdi-delete"></i> Sí, Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL VER PRODUCTO -->
<div class="modal fade" id="modalVerProducto" tabindex="-1" role="dialog" aria-labelledby="modalVerProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalVerProductoLabel">
                    <i class="mdi mdi-eye"></i> Detalle del Producto
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detalleProductoContent">
                <!-- Se llenará dinámicamente con JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="mdi mdi-close"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para Modales -->
<script>
const BASE_URL = '<?= BASE_URL ?>';
let productoIdEliminar = null;

// CREAR PRODUCTO
document.getElementById('formCrearProducto').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Guardando...';
    
    fetch(BASE_URL + 'productos/guardar', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            $('#modalCrearProducto').modal('hide');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar el producto');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="mdi mdi-content-save"></i> Guardar Producto';
    });
});

// VER PRODUCTO
function verProducto(id) {
    fetch(BASE_URL + 'productos/obtener/' + id)
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            const producto = data.producto;
            let html = `
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="${producto.imagen ? BASE_URL + 'storage/archivo/productos/' + producto.imagen : BASE_URL + 'assets/images/no-image.png'}" 
                             class="img-fluid rounded" 
                             alt="${producto.nombre}">
                    </div>
                    <div class="col-md-8">
                        <h4>${producto.nombre}</h4>
                        <hr>
                        <table class="table table-sm">
                            <tr>
                                <th>Código:</th>
                                <td>${producto.codigo || '-'}</td>
                            </tr>
                            <tr>
                                <th>Modelo:</th>
                                <td>${producto.modelo || '-'}</td>
                            </tr>
                            <tr>
                                <th>Material:</th>
                                <td>${producto.tipomaterial_nombre || '-'}</td>
                            </tr>
                            <tr>
                                <th>Precio Base:</th>
                                <td class="text-success"><strong>S/ ${parseFloat(producto.precio_base).toFixed(2)}</strong></td>
                            </tr>
                            <tr>
                                <th>Precio Oferta:</th>
                                <td class="text-danger">${producto.precio_oferta ? 'S/ ' + parseFloat(producto.precio_oferta).toFixed(2) : '-'}</td>
                            </tr>
                            <tr>
                                <th>Stock:</th>
                                <td><span class="badge badge-info">${producto.stock}</span></td>
                            </tr>
                            <tr>
                                <th>Estado:</th>
                                <td>${producto.estado == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>'}</td>
                            </tr>
                        </table>
                        ${producto.descripcion ? '<p><strong>Descripción:</strong><br>' + producto.descripcion + '</p>' : ''}
                    </div>
                </div>
            `;
            document.getElementById('detalleProductoContent').innerHTML = html;
            $('#modalVerProducto').modal('show');
        }
    });
}

// EDITAR PRODUCTO
function editarProducto(id) {
    fetch(BASE_URL + 'productos/obtener/' + id)
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            const p = data.producto;
            document.getElementById('edit_producto_id').value = p.id;
            document.getElementById('edit_nombre').value = p.nombre;
            document.getElementById('edit_tipomaterial').value = p.tipomaterial;
            document.getElementById('edit_negocio').value = p.negocio;
            document.getElementById('edit_precio_base').value = p.precio_base;
            document.getElementById('edit_precio_oferta').value = p.precio_oferta || '';
            document.getElementById('edit_stock').value = p.stock;
            document.getElementById('edit_codigo').value = p.codigo || '';
            document.getElementById('edit_modelo').value = p.modelo || '';
            document.getElementById('edit_color').value = p.color || '';
            document.getElementById('edit_serie').value = p.serie || '';
            document.getElementById('edit_talla').value = p.talla || '';
            document.getElementById('edit_descripcion').value = p.descripcion || '';
            document.getElementById('edit_estado').value = p.estado;
            
            if(p.imagen) {
                document.getElementById('imagenActual').innerHTML = `
                    <label>Imagen Actual:</label><br>
                    <img src="${BASE_URL}storage/archivo/productos/${p.imagen}" 
                         class="img-thumbnail" 
                         style="max-width: 150px;">
                `;
            } else {
                document.getElementById('imagenActual').innerHTML = '';
            }
            
            $('#modalEditarProducto').modal('show');
        }
    });
}

// ACTUALIZAR PRODUCTO
document.getElementById('formEditarProducto').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const id = document.getElementById('edit_producto_id').value;
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Actualizando...';
    
    fetch(BASE_URL + 'productos/actualizar/' + id, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            $('#modalEditarProducto').modal('hide');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar el producto');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="mdi mdi-content-save"></i> Actualizar Producto';
    });
});

// ELIMINAR PRODUCTO
function eliminarProducto(id, nombre) {
    productoIdEliminar = id;
    document.getElementById('delete_producto_nombre').textContent = nombre;
    $('#modalEliminarProducto').modal('show');
}

function confirmarEliminar() {
    if(!productoIdEliminar) return;
    
    fetch(BASE_URL + 'productos/eliminar/' + productoIdEliminar, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            $('#modalEliminarProducto').modal('hide');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar el producto');
    });
}

// BÚSQUEDA Y FILTROS
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterEstado = document.getElementById('filterEstado');
    const table = document.getElementById('productosTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const estadoFilter = filterEstado.value;
        let visibleCount = 0;
        
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            if(row.cells.length < 2) continue; // Skip empty state row
            
            const nombre = row.cells[2]?.textContent.toLowerCase() || '';
            const codigo = row.cells[3]?.textContent.toLowerCase() || '';
            const estado = row.cells[8]?.querySelector('.badge')?.textContent.includes('Activo') ? '1' : '0';
            
            let showRow = true;
            
            // Filtro de búsqueda
            if (searchTerm && !nombre.includes(searchTerm) && !codigo.includes(searchTerm)) {
                showRow = false;
            }
            
            // Filtro de estado
            if (estadoFilter && estado !== estadoFilter) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
            if(showRow) visibleCount++;
        }
        
        document.getElementById('totalProductos').textContent = visibleCount;
    }
    
    searchInput.addEventListener('keyup', filterTable);
    filterEstado.addEventListener('change', filterTable);
});

// Limpiar formularios al cerrar modales
$('#modalCrearProducto').on('hidden.bs.modal', function () {
    document.getElementById('formCrearProducto').reset();
});

$('#modalEditarProducto').on('hidden.bs.modal', function () {
    document.getElementById('formEditarProducto').reset();
});
</script>

<!-- Estilos adicionales -->
<style>
.modal-body {
    max-height: 70vh;
    overflow-y: auto;
}

.table td {
    vertical-align: middle;
}

.btn-group .btn {
    margin: 0;
}

.img-thumbnail {
    border-radius: 8px;
}

/* Animación hover en las filas */
#productosTable tbody tr {
    transition: all 0.3s ease;
}

#productosTable tbody tr:hover {
    transform: scale(1.01);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Mejorar el aspecto de los badges */
.badge {
    padding: 5px 10px;
    font-size: 11px;
}

/* Botones de acción con mejor espaciado */
.btn-group .btn {
    padding: 5px 10px;
}

/* Scrollbar personalizado para modal */
.modal-body::-webkit-scrollbar {
    width: 8px;
}

.modal-body::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.modal-body::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Loading spinner animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.mdi-spin {
    animation: spin 1s linear infinite;
}
</style>