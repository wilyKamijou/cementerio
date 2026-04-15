{{-- resources/views/admin/modals/empleado-editar.blade.php --}}
<div class="modal fade" id="modalEditarEmpleado" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="fas fa-user-edit"></i> Editar Empleado</h5>

            </div>

            <form id="formEditarEmpleado" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_empleado_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input type="text" id="edit_nombre_empleado" name="nombre" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Apellido Paterno <span class="text-danger">*</span></label>
                                <input type="text" id="edit_paterno_empleado" name="paterno" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Apellido Materno</label>
                                <input type="text" id="edit_materno_empleado" name="materno" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Teléfono <span class="text-danger">*</span></label>
                                <input type="tel" id="edit_telefono_empleado" name="telefono" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Dirección</label>
                        <textarea id="edit_direccion_empleado" name="direccion" class="form-control" rows="3"
                            placeholder="Dirección completa"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Actualizar Empleado</button>
                </div>
            </form>
        </div>
    </div>
</div>
