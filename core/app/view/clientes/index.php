<!-- Page Header -->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="font-weight-bold mb-0">Gestión de Clientes</h3>
                <p class="text-muted mb-0">Lista completa de clientes registrados</p>
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-icon-text" data-toggle="modal" data-target="#modalCrearCliente">
                    <i class="mdi mdi-account-plus btn-icon-prepend"></i>
                    Nuevo Cliente
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
                                       placeholder="Buscar por nombre, DNI, email...">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="button">
                                        <i class="mdi mdi-magnify"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="filterGenero">
                            <option value="">Todos los géneros</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                            <option value="OTRO">Otro</option>
                            <option value="NO_ESPECIFICA">No especifica</option>
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

<!-- Tabla de Clientes -->
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">
                        <i class="mdi mdi-account-multiple text-primary"></i>
                        Lista de Clientes
                    </h4>
                    <div>
                        <span class="badge badge-info">
                            Total: <strong id="totalClientes"><?= count($clientes) ?></strong> clientes
                        </span>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover" id="clientesTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombres Completos</th>
                                <th>DNI</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Género</th>
                                <th>Negocio</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($clientes)): ?>
                                <?php foreach($clientes as $index => $cliente): ?>
                                <tr data-id="<?= $cliente['id'] ?>">
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($cliente['nombres']) ?> 
                                        <?= htmlspecialchars($cliente['apellido_paterno'] ?? '') ?> 
                                        <?= htmlspecialchars($cliente['apellido_materno'] ?? '') ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge cyan">
                                            <?= htmlspecialchars($cliente['dni']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?= !empty($cliente['telefono']) ? htmlspecialchars($cliente['telefono']) : '<span class="text-muted">-</span>' ?>
                                    </td>
                                    <td>
                                        <?= !empty($cliente['email']) ? htmlspecialchars($cliente['email']) : '<span class="text-muted">-</span>' ?>
                                    </td>
                                    <td>
                                        <?php
                                            $generoIcono = 'mdi-help-circle';
                                            $generoTexto = 'No especifica';
                                            $generoBadge = 'secondary';
                                            
                                            switch($cliente['genero']) {
                                                case 'M':
                                                    $generoIcono = 'mdi-gender-male';
                                                    $generoTexto = 'Masculino';
                                                    $generoBadge = 'primary';
                                                    break;
                                                case 'F':
                                                    $generoIcono = 'mdi-gender-female';
                                                    $generoTexto = 'Femenino';
                                                    $generoBadge = 'danger';
                                                    break;
                                                case 'OTRO':
                                                    $generoIcono = 'mdi-gender-transgender';
                                                    $generoTexto = 'Otro';
                                                    $generoBadge = 'warning';
                                                    break;
                                            }
                                        ?>
                                        <span class="badge badge-<?= $generoBadge ?>">
                                            <i class="mdi <?= $generoIcono ?>"></i> <?= $generoTexto ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            <?= htmlspecialchars($cliente['negocio_nombre'] ?? 'Sin negocio') ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <!-- Ver -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-info" 
                                                    onclick="verCliente(<?= $cliente['id'] ?>)"
                                                    title="Ver detalle">
                                                <i class="mdi mdi-eye"></i>
                                            </button>
                                            
                                            <!-- Editar -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-warning" 
                                                    onclick="editarCliente(<?= $cliente['id'] ?>)"
                                                    title="Editar">
                                                <i class="mdi mdi-pencil"></i>
                                            </button>
                                            
                                            <!-- Eliminar -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="eliminarCliente(<?= $cliente['id'] ?>, '<?= htmlspecialchars($cliente['nombres'] . ' ' . ($cliente['apellido_paterno'] ?? '')) ?>')"
                                                    title="Eliminar">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div class="py-5">
                                            <i class="mdi mdi-account-multiple mdi-48px text-muted"></i>
                                            <p class="text-muted mt-3">No hay clientes registrados</p>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCrearCliente">
                                                <i class="mdi mdi-plus"></i> Registrar primer cliente
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

<!-- MODAL CREAR CLIENTE -->
<div class="modal fade" id="modalCrearCliente" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formCrearCliente">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="mdi mdi-account-plus"></i> Registrar Nuevo Cliente
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna Izquierda -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombres <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombres" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Apellido Paterno <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="apellido_paterno">
                            </div>
                            
                            <div class="form-group">
                                <label>Apellido Materno <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="apellido_materno">
                            </div>
                            
                            <div class="form-group">
                                <label>DNI <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="dni" maxlength="8" pattern="[0-9]{8}" required>
                                <small class="text-muted">8 dígitos</small>
                            </div>
                            
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" class="form-control" name="telefono" maxlength="15">
                            </div>
                        </div>
                        
                        <!-- Columna Derecha -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            
                            <div class="form-group">
                                <label>Fecha de Nacimiento</label>
                                <input type="date" class="form-control" name="fecha_nacimiento">
                            </div>
                            
                            <div class="form-group">
                                <label>Género</label>
                                <select class="form-control" name="genero">
                                    <option value="NO_ESPECIFICA">No especifica</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                    <option value="OTRO">Otro</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Negocio <span class="text-danger">*</span></label>
                                <select class="form-control" name="negocio" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $db = new Database();
                                    $negocios = $db->select("SELECT * FROM negocio WHERE estado = 1 ORDER BY nombre");
                                    foreach($negocios as $negocio):
                                    ?>
                                        <option value="<?= $negocio['id'] ?>"><?= $negocio['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Dirección completa -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Dirección</label>
                                <textarea class="form-control" name="direccion" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="mdi mdi-close"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-content-save"></i> Registrar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDITAR CLIENTE -->
<div class="modal fade" id="modalEditarCliente" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formEditarCliente">
                <input type="hidden" name="cliente_id" id="edit_cliente_id">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">
                        <i class="mdi mdi-pencil"></i> Editar Cliente
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna Izquierda -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombres <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombres" id="edit_nombres" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Apellido Paterno</label>
                                <input type="text" class="form-control" name="apellido_paterno" id="edit_apellido_paterno">
                            </div>
                            
                            <div class="form-group">
                                <label>Apellido Materno</label>
                                <input type="text" class="form-control" name="apellido_materno" id="edit_apellido_materno">
                            </div>
                            
                            <div class="form-group">
                                <label>DNI <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="dni" id="edit_dni" maxlength="8" pattern="[0-9]{8}" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" class="form-control" name="telefono" id="edit_telefono" maxlength="15">
                            </div>
                        </div>
                        
                        <!-- Columna Derecha -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" id="edit_email">
                            </div>
                            
                            <div class="form-group">
                                <label>Fecha de Nacimiento</label>
                                <input type="date" class="form-control" name="fecha_nacimiento" id="edit_fecha_nacimiento">
                            </div>
                            
                            <div class="form-group">
                                <label>Género</label>
                                <select class="form-control" name="genero" id="edit_genero">
                                    <option value="NO_ESPECIFICA">No especifica</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                    <option value="OTRO">Otro</option>
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
                        </div>
                        
                        <!-- Dirección completa -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Dirección</label>
                                <textarea class="form-control" name="direccion" id="edit_direccion" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="mdi mdi-close"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="mdi mdi-content-save"></i> Actualizar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL VER CLIENTE -->
<div class="modal fade" id="modalVerCliente" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="mdi mdi-account-card-details"></i> Detalle del Cliente
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detalleClienteContent">
                <!-- Se llenará dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="mdi mdi-close"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ELIMINAR CLIENTE -->
<div class="modal fade" id="modalEliminarCliente" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="mdi mdi-alert"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este cliente?</p>
                <div class="alert alert-warning">
                    <strong>Cliente:</strong> <span id="delete_cliente_nombre"></span>
                </div>
                <p class="text-danger"><strong>Advertencia:</strong> Esta acción eliminará permanentemente al cliente.</p>
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

<!-- JavaScript -->
<script>
const BASE_URL = '<?= BASE_URL ?>';
let clienteIdEliminar = null;

// CREAR CLIENTE
document.getElementById('formCrearCliente').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Guardando...';
    
    fetch(BASE_URL + 'clientes/guardar', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            $('#modalCrearCliente').modal('hide');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar el cliente');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="mdi mdi-content-save"></i> Registrar Cliente';
    });
});

// VER CLIENTE
function verCliente(id) {
    fetch(BASE_URL + 'clientes/obtener/' + id)
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            const c = data.cliente;
            const generoTexto = {
                'M': 'Masculino',
                'F': 'Femenino',
                'OTRO': 'Otro',
                'NO_ESPECIFICA': 'No especifica'
            };
            
            let html = `
                <div class="row">
                    <div class="col-md-12">
                        <h4>${c.nombres} ${c.apellido_paterno || ''} ${c.apellido_materno || ''}</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tr>
                                        <th width="40%">DNI:</th>
                                        <td><strong>${c.dni}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Teléfono:</th>
                                        <td>${c.telefono || '-'}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>${c.email || '-'}</td>
                                    </tr>
                                    <tr>
                                        <th>Género:</th>
                                        <td>${generoTexto[c.genero] || 'No especifica'}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tr>
                                        <th width="50%">Fecha Nacimiento:</th>
                                        <td>${c.fecha_nacimiento ? new Date(c.fecha_nacimiento).toLocaleDateString('es-PE') : '-'}</td>
                                    </tr>
                                    <tr>
                                        <th>Negocio:</th>
                                        <td><span class="badge badge-success">${c.negocio_nombre || '-'}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Fecha Registro:</th>
                                        <td>${new Date(c.fecha_registro).toLocaleDateString('es-PE')}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        ${c.direccion ? '<p><strong>Dirección:</strong><br>' + c.direccion + '</p>' : ''}
                    </div>
                </div>
            `;
            document.getElementById('detalleClienteContent').innerHTML = html;
            $('#modalVerCliente').modal('show');
        }
    });
}

// EDITAR CLIENTE
function editarCliente(id) {
    fetch(BASE_URL + 'clientes/obtener/' + id)
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            const c = data.cliente;
            document.getElementById('edit_cliente_id').value = c.id;
            document.getElementById('edit_nombres').value = c.nombres;
            document.getElementById('edit_apellido_paterno').value = c.apellido_paterno || '';
            document.getElementById('edit_apellido_materno').value = c.apellido_materno || '';
            document.getElementById('edit_dni').value = c.dni;
            document.getElementById('edit_telefono').value = c.telefono || '';
            document.getElementById('edit_email').value = c.email || '';
            document.getElementById('edit_fecha_nacimiento').value = c.fecha_nacimiento || '';
            document.getElementById('edit_genero').value = c.genero;
            document.getElementById('edit_negocio').value = c.negocio;
            document.getElementById('edit_direccion').value = c.direccion || '';
            
            $('#modalEditarCliente').modal('show');
        }
    });
}

// ACTUALIZAR CLIENTE
document.getElementById('formEditarCliente').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const id = document.getElementById('edit_cliente_id').value;
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Actualizando...';
    
    fetch(BASE_URL + 'clientes/actualizar/' + id, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            $('#modalEditarCliente').modal('hide');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar el cliente');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="mdi mdi-content-save"></i> Actualizar Cliente';
    });
});

// ELIMINAR CLIENTE
function eliminarCliente(id, nombre) {
    clienteIdEliminar = id;
    document.getElementById('delete_cliente_nombre').textContent = nombre;
    $('#modalEliminarCliente').modal('show');
}

function confirmarEliminar() {
    if(!clienteIdEliminar) return;
    
    fetch(BASE_URL + 'clientes/eliminar/' + clienteIdEliminar, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            $('#modalEliminarCliente').modal('hide');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar el cliente');
    });
}

// BÚSQUEDA Y FILTROS
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterGenero = document.getElementById('filterGenero');
    const table = document.getElementById('clientesTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const generoFilter = filterGenero.value;
        let visibleCount = 0;
        
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            if(row.cells.length < 2) continue;
            
            const nombre = row.cells[1]?.textContent.toLowerCase() || '';
            const dni = row.cells[2]?.textContent.toLowerCase() || '';
            const email = row.cells[4]?.textContent.toLowerCase() || '';
            const generoBadge = row.cells[5]?.querySelector('.badge')?.textContent.toLowerCase() || '';
            
            let showRow = true;
            
            if (searchTerm && !nombre.includes(searchTerm) && !dni.includes(searchTerm) && !email.includes(searchTerm)) {
                showRow = false;
            }
            
            if (generoFilter) {
                const generoTextos = {
                    'M': 'masculino',
                    'F': 'femenino',
                    'OTRO': 'otro',
                    'NO_ESPECIFICA': 'no especifica'
                };
                if (!generoBadge.includes(generoTextos[generoFilter])) {
                    showRow = false;
                }
            }
            
            row.style.display = showRow ? '' : 'none';
            if(showRow) visibleCount++;
        }
        
        document.getElementById('totalClientes').textContent = visibleCount;
    }
    
    searchInput.addEventListener('keyup', filterTable);
    filterGenero.addEventListener('change', filterTable);
});

// Limpiar formularios al cerrar modales
$('#modalCrearCliente').on('hidden.bs.modal', function () {
    document.getElementById('formCrearCliente').reset();
});

$('#modalEditarCliente').on('hidden.bs.modal', function () {
    document.getElementById('formEditarCliente').reset();
});
</script>

<!-- Estilos adicionales -->
<style>
.table td {
    vertical-align: middle;
}

.btn-group .btn {
    margin: 0;
}

/* Animación hover en las filas */
#clientesTable tbody tr {
    transition: all 0.3s ease;
}

#clientesTable tbody tr:hover {
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

/* Loading spinner animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.mdi-spin {
    animation: spin 1s linear infinite;
}

/* Iconos de género con mejor tamaño */
.badge .mdi {
    font-size: 14px;
    vertical-align: middle;
}
</style>