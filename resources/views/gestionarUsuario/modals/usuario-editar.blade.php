{{-- admin/modals/usuario-editar.blade.php --}}
<div class="modal fade" id="modalEditarUsuario" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="fas fa-user-edit"></i> Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formEditarUsuario" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_usuario_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Nombre completo</label>
                                <input type="text" id="edit_nombre" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" id="edit_email" name="email" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Nueva contraseña (opcional)</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Dejar vacío para no cambiar">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Rol</label>
                                <select id="edit_idRol" name="idRol" class="form-control">
                                    <option value="">-- Sin rol --</option>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->idRol }}">{{ $rol->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Empleado</label>
                                <select id="edit_idEmpleado" name="idEmpleado" class="form-control">
                                    <option value="">-- Ninguno --</option>
                                    @foreach ($empleados as $empleado)
                                        <option value="{{ $empleado->idEmpleado }}">{{ $empleado->nombre }}
                                            {{ $empleado->apellido ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Cliente</label>
                                <select id="edit_idCliente" name="idCliente" class="form-control">
                                    <option value="">-- Ninguno --</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->idCliente }}">{{ $cliente->nombre }}
                                            {{ $cliente->apellido ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>
