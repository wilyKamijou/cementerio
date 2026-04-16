{{-- resources/views/espacios/modals/dimension-editar.blade.php --}}
<div class="modal fade" id="modalEditarDimension" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i> Editar Dimensión
                </h5>

            </div>

            <form id="formEditarDimension" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_dimension_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Ancho <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" id="edit_ancho_dim" name="ancho"
                                        class="form-control" placeholder="Ej: 2.50" required>
                                    <span class="input-group-text">m</span>
                                </div>
                                <small class="form-text">Ingrese el ancho en metros</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Largo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" id="edit_largo_dim" name="largo"
                                        class="form-control" placeholder="Ej: 1.80" required>
                                    <span class="input-group-text">m</span>
                                </div>
                                <small class="form-text">Ingrese el largo en metros</small>
                            </div>
                        </div>
                    </div>

                    <!-- Vista previa del área con IDs ÚNICOS para editar -->
                    <div class="dimension-preview" id="previewDimensionEditar" style="display: none;">
                        <i class="fas fa-calculator"></i>
                        <span>Área total: <strong id="previewAreaEditar" class="preview-value">0.00</strong> m²</span>
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
