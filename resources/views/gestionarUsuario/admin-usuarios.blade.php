{{-- resources/views/admin/usuarios/index.blade.php --}}
@extends('layouts.sepulturero')

@section('title', 'Gestión del Sistema - El Sepulturero Juan')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><i class="fas fa-cog"></i> Gestión del Sistema</h3>
                        <div>
                            <button type="button" class="btn btn-light" id="btnCrearUsuario">
                                <i class="fas fa-plus"></i> Nuevo Usuario
                            </button>
                            <button type="button" class="btn btn-light" id="btnCrearEmpleado">
                                <i class="fas fa-user-tie"></i> Nuevo Empleado
                            </button>
                            <button type="button" class="btn btn-light" id="btnCrearRol">
                                <i class="fas fa-tag"></i> Nuevo Rol
                            </button>
                            <button type="button" class="btn btn-light" id="btnCrearPermiso">
                                <i class="fas fa-lock"></i> Nuevo Permiso
                            </button>
                        </div>
                    </div>

                    <div class="card-body">

                        <!-- Pestañas manuales -->
                        <div class="mb-4">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary" data-tab="usuarios">
                                    <i class="fas fa-users"></i> Usuarios
                                </button>
                                <button type="button" class="btn btn-outline-primary" data-tab="empleados">
                                    <i class="fas fa-user-tie"></i> Empleados
                                </button>
                                <button type="button" class="btn btn-outline-primary" data-tab="roles">
                                    <i class="fas fa-tag"></i> Roles
                                </button>
                                <button type="button" class="btn btn-outline-primary" data-tab="permisos">
                                    <i class="fas fa-lock"></i> Permisos
                                </button>
                            </div>
                        </div>

                        <!-- Contenido de las pestañas -->
                        <div id="tabContent">
                            <!-- TABLA DE USUARIOS -->
                            <div id="tab-usuarios" class="tab-pane" style="display: block;">
                                <div class="mb-3">
                                    <input type="text" id="buscarUsuario" class="form-control"
                                        placeholder="🔍 Buscar usuario...">
                                </div>
                                <div class="table-responsive">
                                    <table class="usuarios-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Rol</th>
                                                <th>Empleado/Cliente</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($usuarios as $usuario)
                                                <tr class="fila-usuario">
                                                    <td>{{ $usuario->id }}</td>
                                                    <td>{{ $usuario->name }}</td>
                                                    <td>{{ $usuario->email }}</td>
                                                    <td>
                                                        @if ($usuario->roles)
                                                            <span
                                                                class="badge-rol badge-{{ strtolower($usuario->roles->nombre) }}">
                                                                {{ $usuario->roles->nombre }}
                                                            </span>
                                                        @else
                                                            <span class="badge-rol badge-default">Sin rol</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($usuario->idEmpleado)
                                                            <i class="fas fa-user-tie"></i> Empleado:
                                                            {{ $usuario->empleados->nombre ?? 'N/A' }}
                                                        @elseif($usuario->idCliente)
                                                            <i class="fas fa-user"></i> Cliente:
                                                            {{ $usuario->clientes->nombre ?? 'N/A' }}
                                                        @else
                                                            <span class="text-muted">Sin asignar</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn-accion btn-edit editar-usuario"
                                                            data-id="{{ $usuario->id }}" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn-accion btn-delete eliminar-usuario"
                                                            data-id="{{ $usuario->id }}" title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No hay usuarios registrados
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- TABLA DE EMPLEADOS -->
                            <div id="tab-empleados" class="tab-pane" style="display: none;">
                                <div class="mb-3">
                                    <input type="text" id="buscarEmpleado" class="form-control"
                                        placeholder="🔍 Buscar empleado...">
                                </div>
                                <div class="table-responsive">
                                    <table class="usuarios-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre Completo</th>
                                                <th>Teléfono</th>
                                                <th>Dirección</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($empleados as $empleado)
                                                <tr class="fila-empleado">
                                                    <td>{{ $empleado->idEmpleado }}</td>
                                                    <td>{{ $empleado->nombre }} {{ $empleado->paterno }}
                                                        {{ $empleado->materno }}</td>
                                                    <td>{{ $empleado->telefono }}</td>
                                                    <td>{{ $empleado->direccion ?? 'N/A' }}</td>
                                                    <td>
                                                        <button class="btn-accion btn-edit editar-empleado"
                                                            data-id="{{ $empleado->idEmpleado }}" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn-accion btn-delete eliminar-empleado"
                                                            data-id="{{ $empleado->idEmpleado }}" title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No hay empleados registrados
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- TABLA DE ROLES -->
                            <div id="tab-roles" class="tab-pane" style="display: none;">
                                <div class="mb-3">
                                    <input type="text" id="buscarRol" class="form-control"
                                        placeholder="🔍 Buscar rol...">
                                </div>
                                <div class="table-responsive">
                                    <table class="usuarios-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Descripción</th>
                                                <th>Permisos</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($roles as $rol)
                                                <tr class="fila-rol">
                                                    <td>{{ $rol->idRol }}</td>
                                                    <td>{{ $rol->nombre }}</td>
                                                    <td>{{ $rol->descripcion ?? 'N/A' }}</td>
                                                    <td><span class="badge-rol badge-info">{{ $rol->permisos->count() }}
                                                            permisos</span></td>
                                                    <td>
                                                        <button class="btn-accion btn-edit editar-permisos-rol"
                                                            data-id="{{ $rol->idRol }}" title="Editar Permisos">
                                                            <i class="fas fa-key"></i>
                                                        </button>
                                                        <button class="btn-accion btn-delete eliminar-rol"
                                                            data-id="{{ $rol->idRol }}" title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No hay roles registrados</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- TABLA DE PERMISOS -->
                            <div id="tab-permisos" class="tab-pane" style="display: none;">
                                <div class="mb-3">
                                    <input type="text" id="buscarPermiso" class="form-control"
                                        placeholder="🔍 Buscar permiso...">
                                </div>
                                <div class="table-responsive">
                                    <table class="usuarios-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Ruta</th>
                                                <th>Descripción</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($permisos as $permiso)
                                                <tr class="fila-permiso">
                                                    <td>{{ $permiso->idPer }}</td>
                                                    <td>{{ $permiso->nombre }}</td>
                                                    <td>{{ $permiso->ruta ?? 'N/A' }}</td>
                                                    <td>{{ $permiso->descripcion ?? 'N/A' }}</td>
                                                    <td>
                                                        <button class="btn-accion btn-edit editar-permiso"
                                                            data-id="{{ $permiso->idPer }}" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn-accion btn-delete eliminar-permiso"
                                                            data-id="{{ $permiso->idPer }}" title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No hay permisos registrados
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <script>
                            // Pestañas manuales
                            document.querySelectorAll('[data-tab]').forEach(button => {
                                button.addEventListener('click', function() {
                                    const tabId = this.getAttribute('data-tab');

                                    // Cambiar estilo de botones
                                    document.querySelectorAll('[data-tab]').forEach(btn => {
                                        btn.classList.remove('btn-primary');
                                        btn.classList.add('btn-outline-primary');
                                    });
                                    this.classList.remove('btn-outline-primary');
                                    this.classList.add('btn-primary');

                                    // Mostrar contenido correspondiente
                                    document.querySelectorAll('.tab-pane').forEach(pane => {
                                        pane.style.display = 'none';
                                    });
                                    document.getElementById(`tab-${tabId}`).style.display = 'block';
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODALS -->
    @include('gestionarUsuario.modals.usuario-crear')
    @include('gestionarUsuario.modals.usuario-editar')
    @include('gestionarUsuario.modals.rol-crear')
    @include('gestionarUsuario.modals.rol-editar-permisos')
    @include('gestionarUsuario.modals.permiso-crear')
    @include('gestionarUsuario.modals.empleado-crear')

@endsection
