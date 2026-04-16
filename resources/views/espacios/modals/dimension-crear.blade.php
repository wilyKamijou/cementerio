{{-- resources/views/admin/modals/dimension-crear.blade.php --}}
<div class="modal fade" id="modalCrearDimension" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-arrows-alt"></i> Nueva Dimensión
                </h5>

            </div>

            <form id="formCrearDimension" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna izquierda - Ancho -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Ancho <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="ancho" class="form-control"
                                        placeholder="Ej: 2.50" required>
                                    <span class="input-group-text">m</span>
                                </div>
                                <small class="form-text">Ingrese el ancho en metros</small>
                            </div>
                        </div>

                        <!-- Columna derecha - Largo -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Largo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="largo" class="form-control"
                                        placeholder="Ej: 1.80" required>
                                    <span class="input-group-text">m</span>
                                </div>
                                <small class="form-text">Ingrese el largo en metros</small>
                            </div>
                        </div>
                    </div>

                    <!-- Vista previa del área (opcional) -->
                    <div class="dimension-preview" id="previewDimension" style="display: none;">
                        <i class="fas fa-calculator"></i>
                        <span>Área total: <strong id="previewArea" class="preview-value">0.00</strong> m²</span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
