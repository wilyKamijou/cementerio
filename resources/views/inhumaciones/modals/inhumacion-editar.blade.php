{{-- resources/views/admin/inhumaciones/modals/inhumacion-editar.blade.php --}}
<div class="modal fade" id="modalEditarInhumacion" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i> Editar Inhumación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formEditarInhumacion" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_idInhum" name="idInhum">

                <div class="modal-body">
                    <!-- DATOS DEL FALLECIDO -->
                    <h6 class="mb-3"><i class="fas fa-user"></i> Datos del Fallecido</h6>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input type="text" id="edit_nombre" name="nombre" class="form-control" required>
                                <small class="form-text">Nombre(s) del fallecido</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label>Apellido Paterno <span class="text-danger">*</span></label>
                                <input type="text" id="edit_paterno" name="paterno" class="form-control" required>
                                <small class="form-text">Primer apellido</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label>Apellido Materno</label>
                                <input type="text" id="edit_materno" name="materno" class="form-control">
                                <small class="form-text">Segundo apellido (opcional)</small>
                            </div>
                        </div>
                    </div>

                    <!-- FECHAS IMPORTANTES -->
                    <h6 class="mb-3 mt-3"><i class="fas fa-calendar-alt"></i> Fechas Importantes</h6>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label>Fecha de Nacimiento</label>
                                <input type="date" id="edit_fechaNaci" name="fechaNaci" class="form-control">
                                <small class="form-text">Fecha de nacimiento (opcional)</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label>Fecha de Defunción <span class="text-danger">*</span></label>
                                <input type="date" id="edit_fechaDefun" name="fechaDefun" class="form-control"
                                    required>
                                <small class="form-text">Fecha de fallecimiento</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label>Fecha de Inhumación <span class="text-danger">*</span></label>
                                <input type="date" id="edit_fechaInhuma" name="fechaInhuma" class="form-control"
                                    required>
                                <small class="form-text">Fecha del entierro</small>
                            </div>
                        </div>
                    </div>

                    <!-- CAUSA DE MUERTE -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label>Causa de Muerte</label>
                                <textarea id="edit_causaMuer" name="causaMuer" class="form-control" rows="2"></textarea>
                                <small class="form-text">Información opcional</small>
                            </div>
                        </div>
                    </div>

                    <!-- DATOS DE LA INHUMACIÓN -->
                    <h6 class="mb-3 mt-3"><i class="fas fa-dove"></i> Datos de la Inhumación</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Espacio <span class="text-danger">*</span></label>
                                <select id="edit_idEspacio" name="idEspacio" class="form-control" required>
                                    <option value="">-- Seleccionar espacio --</option>
                                    @foreach ($espacios as $espacio)
                                        <option value="{{ $espacio->idEspacio }}">
                                            Espacio #{{ $espacio->idEspacio }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text">Ubicación del espacio funerario</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Tipo de Inhumación <span class="text-danger">*</span></label>
                                <select id="edit_idTipo" name="idTipo" class="form-control" required>
                                    <option value="">-- Seleccionar tipo --</option>
                                    @foreach ($tiposInhumacion as $tipo)
                                        <option value="{{ $tipo->idTipo }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text">Tipo de servicio funerario</small>
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
