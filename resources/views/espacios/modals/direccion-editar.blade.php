{{-- resources/views/espacios/modals/direccion-editar.blade.php --}}
<div class="modal fade" id="modalEditarDireccion" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i> Editar Dirección
                </h5>

            </div>

            <form id="formEditarDireccion" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_direccion_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Sección <span class="text-danger">*</span></label>
                                <input type="text" id="edit_seccion" name="seccion" class="form-control"
                                    placeholder="Ej: A, B, C" required>
                                <small class="form-text">Letra o número de sección</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Número <span class="text-danger">*</span></label>
                                <input type="text" id="edit_numero" name="numero" class="form-control"
                                    placeholder="Ej: 001, 002" required>
                                <small class="form-text">Número del espacio</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Calle <span class="text-danger">*</span></label>
                                <input type="text" id="edit_calle" name="calle" class="form-control"
                                    placeholder="Ej: Los Pinos, Principal" required>
                                <small class="form-text">Nombre de la calle o avenida</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Fila <span class="text-danger">*</span></label>
                                <input type="text" id="edit_fila" name="fila" class="form-control"
                                    placeholder="Ej: 1, 2, 3" required>
                                <small class="form-text">Número de fila</small>
                            </div>
                        </div>
                    </div>

                    <!-- Vista previa de la dirección completa -->
                    <div class="direccion-preview" id="previewDireccionEditar" style="display: none;">
                        <i class="fas fa-location-dot"></i>
                        <span>Dirección completa:</span>
                        <div class="preview-text" id="previewTextoEditar"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
