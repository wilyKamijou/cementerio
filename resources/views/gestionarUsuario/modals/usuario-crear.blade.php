{{-- resources/views/admin/modals/usuario-crear.blade.php --}}
<div class="modal fade" id="modalCrearUsuario" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus"></i> Registrar Nuevo Usuario
                </h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> --}}
            </div>

            <form id="formCrearUsuario" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna izquierda: Datos personales -->
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2">Datos Personales</h6>
                            <div class="mb-3">
                                <label>Nombre de usuario <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <!-- Campo Contraseña con ojo -->
                            <div class="mb-3">
                                <label>Contraseña <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input placeholder="Mín. 8 caracteres, 1 mayús. , 1 núm. y 1 símbolo"
                                        type="password" name="password" id="password" class="form-control" required>
                                    <button type="button" class="btn btn-outline-secondary toggle-password"
                                        data-target="password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            {{-- <small class="text-muted">Mínimo 8 caracteres, una mayúscula, un número y un
                                    símbolo</small> --}}
                            <!-- Campo Confirmar contraseña con ojo -->
                            <div class="mb-3">
                                <label>Confirmar contraseña <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input placeholder="Mín. 8 caracteres, 1 mayús. , 1 núm. y 1 símbolo"
                                        type="password" name="password_confirmation"
                                        id="password_confirmation"class="form-control">
                                    <button type="button" class="btn btn-outline-secondary toggle-password"
                                        data-target="password_confirmation">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                            </div>
                        </div>

                        <!-- Columna derecha: Rol + Empleado/Cliente -->
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2">Asignar Rol</h6>
                            <div class="mb-3">
                                <label>Seleccionar rol existente</label>
                                <select name="idRol" class="form-control" id="selectRolExistente">
                                    <option value="">-- Ninguno --</option>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->idRol }}">{{ $rol->nombre }} -
                                            {{ $rol->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <h6 class="border-bottom pb-2 mt-3">Asignar Empleado/Cliente</h6>
                            <div class="mb-3">
                                <label>Empleado</label>
                                <select name="idEmpleado" id="selectEmpleado" class="form-control">
                                    <option value="">-- Seleccionar empleado --</option>
                                    @foreach ($empleados as $empleado)
                                        <option value="{{ $empleado->idEmpleado }}">{{ $empleado->nombre }}
                                            {{ $empleado->apellido ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Cliente</label>
                                <select name="idCliente" id="selectCliente" class="form-control">
                                    <option value="">-- Seleccionar cliente --</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->idCliente }}">{{ $cliente->nombre }}
                                            {{ $cliente->apellido ?? '' }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Solo uno de los dos puede ser asignado</small>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar
                            Usuario</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
