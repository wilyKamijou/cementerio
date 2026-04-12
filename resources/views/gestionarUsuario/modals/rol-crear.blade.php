{{-- admin/modals/rol-crear.blade.php --}}
<div class="modal fade" id="modalCrearRol" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-tag"></i> Crear Nuevo Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formCrearRol" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Nombre del Rol <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <h6 class="border-bottom pb-2">Permisos para este rol</h6>
                    <div class="permisos-grid">
                        @foreach ($permisos as $permiso)
                            <div class="permiso-item">
                                <input type="checkbox" name="permisos[]" value="{{ $permiso->idPer }}"
                                    class="permiso-checkbox">
                                <label>
                                    <span class="permiso-nombre">{{ $permiso->nombre }}</span>
                                    <span class="permiso-descripcion">{{ $permiso->descripcion }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-2">
                        <button type="button" class="btn btn-sm btn-secondary" id="selectAllPermisosRol">
                            <i class="fas fa-check-double"></i> Seleccionar todos
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Crear Rol</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#selectAllPermisosRol').click(function() {
        $('.permiso-checkbox').prop('checked', true);
    });
</script>
