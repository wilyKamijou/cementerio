{{-- admin/modals/rol-editar-permisos.blade.php --}}
<div class="modal fade" id="modalEditarPermisosRol" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Editar Permisos del Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formEditarPermisosRol" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_rol_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Nombre del Rol</label>
                                <input type="text" id="edit_rol_nombre" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Descripción</label>
                                <textarea id="edit_rol_descripcion" class="form-control" rows="2" disabled></textarea>
                            </div>
                        </div>
                    </div>

                    <h6 class="border-bottom pb-2">Permisos asignados</h6>
                    <div class="permisos-grid">
                        @foreach ($permisos as $permiso)
                            <div class="permiso-item">
                                <input type="checkbox" name="permisos[]" value="{{ $permiso->idPer }}"
                                    class="permiso-checkbox" id="permiso_{{ $permiso->idPer }}">
                                <label for="permiso_{{ $permiso->idPer }}">
                                    <span class="permiso-nombre">{{ $permiso->nombre }}</span>
                                    <span class="permiso-descripcion">{{ $permiso->descripcion }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-2">
                        <button type="button" class="btn btn-sm btn-secondary" id="selectAllPermisosEdit">
                            <i class="fas fa-check-double"></i> Seleccionar todos
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary" id="deselectAllPermisosEdit">
                            <i class="fas fa-times"></i> Deseleccionar todos
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#selectAllPermisosEdit').click(function() {
        $('.permiso-checkbox').prop('checked', true);
    });
    $('#deselectAllPermisosEdit').click(function() {
        $('.permiso-checkbox').prop('checked', false);
    });
</script>
