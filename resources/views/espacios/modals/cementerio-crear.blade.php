{{-- resources/views/admin/modals/cementerio-crear.blade.php --}}
<div class="modal fade" id="modalCrearCementerio" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-church"></i> Nuevo Cementerio
                </h5>

            </div>

            <form id="formCrearCementerio" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna izquierda -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" class="form-control"
                                    placeholder="Ej: Cementerio Jardines del Recuerdo" required>
                            </div>

                            <div class="mb-3">
                                <label>Estado <span class="text-danger">*</span></label>
                                <input type="text" name="estado" class="form-control" placeholder="Ej: Durando"
                                    required>
                            </div>
                        </div>

                        <!-- Columna derecha -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Espacios Disponibles</label>
                                <input type="number" name="espacioDisp" class="form-control" placeholder="0"
                                    value="0">
                            </div>

                            <div class="mb-3">
                                <label>Localización</label>
                                <textarea name="localizacion" class="form-control" placeholder="Dirección completa del cementerio..." rows="3"></textarea>
                            </div>
                        </div>
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
