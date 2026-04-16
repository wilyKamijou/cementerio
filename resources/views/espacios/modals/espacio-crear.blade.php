{{-- resources/views/admin/modals/espacio-crear.blade.php --}}
<div class="modal fade" id="modalCrearEspacio" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-landmark"></i> Nuevo Espacio
                </h5>

            </div>

            <form id="formCrearEspacio" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna izquierda -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Precio <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="precio" class="form-control"
                                    placeholder="0.00" required>
                            </div>

                            <div class="mb-3">
                                <label>Estado <span class="text-danger">*</span></label>
                                <select name="estado" class="form-control" required>
                                    <option value="disponible">Disponible</option>
                                    <option value="ocupado">Ocupado</option>
                                    <option value="reservado">Reservado</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Dirección <span class="text-danger">*</span></label>
                                <select name="idDir" class="form-control" required>
                                    <option value="">-- Seleccionar dirección --</option>
                                    @foreach ($direcciones as $direccion)
                                        <option value="{{ $direccion->idDir }}">
                                            Secc: {{ $direccion->seccion }} | Núm: {{ $direccion->numero }} | Calle:
                                            {{ $direccion->calle }} | Fila: {{ $direccion->fila }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text">
                                    <i class="fas fa-info-circle"></i> Formato: Sección - Número | Calle | Fila
                                </small>
                            </div>
                        </div>

                        <!-- Columna derecha -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Dimensión <span class="text-danger">*</span></label>
                                <select name="idDim" class="form-control" required>
                                    <option value="">-- Seleccionar dimensión --</option>
                                    @foreach ($dimensiones as $dimension)
                                        <option value="{{ $dimension->idDim }}">
                                            {{ $dimension->ancho }} x {{ $dimension->largo }} m²
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Cementerio <span class="text-danger">*</span></label>
                                <select name="idCem" class="form-control" required>
                                    <option value="">-- Seleccionar cementerio --</option>
                                    @foreach ($cementerios as $cementerio)
                                        <option value="{{ $cementerio->idCem }}">
                                            {{ $cementerio->nombre }}
                                        </option>
                                    @endforeach
                                </select>
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
