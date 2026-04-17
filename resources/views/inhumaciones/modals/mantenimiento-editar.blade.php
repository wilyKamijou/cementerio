{{-- resources/views/admin/inhumaciones/modals/mantenimiento-editar.blade.php --}}
<div class="modal fade" id="modalEditarMantenimiento" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i> Editar Mantenimiento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formEditarMantenimiento" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_mantenimiento_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label>Espacio <span class="text-danger">*</span></label>
                                <select id="edit_idEspacio" name="idEspacio" class="form-control" required>
                                    <option value="">-- Seleccionar espacio --</option>
                                    @foreach ($espacios as $espacio)
                                        <option value="{{ $espacio->idEspacio }}">
                                            Espacio #{{ $espacio->idEspacio }} -
                                            {{ $espacio->direccion->calle ?? 'Sin dirección' }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text">Espacio a mantener</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Tipo de Mantenimiento <span class="text-danger">*</span></label>
                                <select id="edit_tipo_mantenimiento" name="tipo" class="form-control" required>
                                    <option value="">-- Seleccionar tipo --</option>
                                    <option value="limpieza">Limpieza</option>
                                    <option value="reparacion">Reparación</option>
                                    <option value="pintura">Pintura</option>
                                    <option value="jardineria">Jardinería</option>
                                    <option value="general">General</option>
                                </select>
                                <small class="form-text">Tipo de mantenimiento a realizar</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Fecha de Mantenimiento <span class="text-danger">*</span></label>
                                <input type="date" id="edit_fechaMant" name="fechaMant" class="form-control"
                                    required>
                                <small class="form-text">Fecha programada</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Costo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" id="edit_precio_mantenimiento" name="precio"
                                        class="form-control" placeholder="0.00" required>
                                </div>
                                <small class="form-text">Costo del mantenimiento</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Estado</label>
                                <select id="edit_estado_mantenimiento" name="estado" class="form-control">
                                    <option value="pendiente">Pendiente</option>
                                    <option value="en_proceso">En Proceso</option>
                                    <option value="completado">Completado</option>
                                    <option value="cancelado">Cancelado</option>
                                </select>
                                <small class="form-text">Estado del mantenimiento</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Descripción</label>
                        <textarea id="edit_descripcion_mantenimiento" name="descripcion" class="form-control" rows="3"
                            placeholder="Descripción detallada del mantenimiento..."></textarea>
                        <small class="form-text">Detalles adicionales del trabajo a realizar</small>
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
