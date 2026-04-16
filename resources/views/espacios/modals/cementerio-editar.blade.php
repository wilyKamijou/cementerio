{{-- resources/views/espacios/modals/cementerio-editar.blade.php --}}
<div class="modal fade" id="modalEditarCementerio" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i> Editar Cementerio
                </h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> --}}
            </div>

            <form id="formEditarCementerio" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_cementerio_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna izquierda -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input type="text" id="edit_nombre_cementerio" name="nombre" class="form-control"
                                    placeholder="Ej: Cementerio Jardines del Recuerdo" required>
                            </div>

                            <div class="mb-3">
                                <label>Estado <span class="text-danger">*</span></label>
                                <input type="text" id="edit_estado_cementerio" name="estado" class="form-control"
                                    placeholder="Ej: Tlaxscala" required>
                            </div>
                        </div>

                        <!-- Columna derecha -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Espacios Disponibles</label>
                                <input type="number" id="edit_espacioDisp" name="espacioDisp" class="form-control"
                                    placeholder="0" min="0">
                                <small class="form-text">Número de espacios disponibles</small>
                            </div>

                            <div class="mb-3">
                                <label>Localización</label>
                                <textarea id="edit_localizacion" name="localizacion" class="form-control" rows="3"
                                    placeholder="Dirección completa del cementerio..."></textarea>
                                <small class="form-text">Ubicación geográfica o dirección</small>
                            </div>
                        </div>
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
