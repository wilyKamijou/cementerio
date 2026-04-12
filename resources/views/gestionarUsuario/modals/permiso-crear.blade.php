{{-- admin/modals/permiso-crear.blade.php --}}
<div class="modal fade" id="modalCrearPermiso" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-lock"></i> Crear Nuevo Permiso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formCrearPermiso" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nombre del Permiso <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control" required>
                        <small class="text-muted">Ejemplo: ver_contratos, crear_usuario, eliminar_rol</small>
                    </div>
                    <div class="mb-3">
                        <label>Ruta (opcional)</label>
                        <input type="text" name="ruta" class="form-control" placeholder="/admin/usuarios">
                        <small class="text-muted">URL o ruta asociada al permiso</small>
                    </div>
                    <div class="mb-3">
                        <label>Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3" placeholder="¿Qué hace este permiso?"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info">Crear Permiso</button>
                </div>
            </form>
        </div>
    </div>
</div>
