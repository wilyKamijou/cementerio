{{-- resources/views/admin/inhumaciones/modals/tipo-inhumacion-editar.blade.php --}}
<div class="modal fade" id="modalEditarTipoInhumacion" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i> Editar Tipo de Inhumación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formEditarTipoInhumacion" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_tipo_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input type="text" id="edit_nombre_tipo" name="nombre" class="form-control"
                                    placeholder="Ej: Inhumación Tradicional" required>
                                <small class="form-text">Nombre del tipo de inhumación</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Precio Base <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" id="edit_precio_tipo" name="precio"
                                        class="form-control" placeholder="0.00" required>
                                </div>
                                <small class="form-text">Precio base del servicio</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Capacidad Máxima</label>
                                <input type="number" id="edit_capacidad_tipo" name="capacidadMax" class="form-control"
                                    placeholder="Ej: 1, 2, 4" min="1">
                                <small class="form-text">Personas que puede albergar</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Área Base (m²)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" id="edit_area_tipo" name="areaBase"
                                        class="form-control" placeholder="0.00">
                                    <span class="input-group-text">m²</span>
                                </div>
                                <small class="form-text">Área requerida para este tipo</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Estado</label>
                                <select id="edit_estado_tipo" name="estado" class="form-control">
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                                <small class="form-text">Estado del tipo de inhumación</small>
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
