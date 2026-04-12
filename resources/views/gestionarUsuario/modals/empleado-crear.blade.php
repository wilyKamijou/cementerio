{{-- resources/views/admin/modals/empleado-crear.blade.php --}}
<div class="modal fade" id="modalCrearEmpleado" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-tie"></i> Registrar Nuevo Empleado
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formCrearEmpleado" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Apellido Paterno <span class="text-danger">*</span></label>
                                <input type="text" name="paterno" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Apellido Materno</label>
                                <input type="text" name="materno" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Teléfono <span class="text-danger">*</span></label>
                                <input type="tel" name="telefono" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Dirección</label>
                        <textarea name="direccion" class="form-control" rows="3" placeholder="Dirección completa"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Empleado
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
