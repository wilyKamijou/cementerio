{{-- resources/views/admin/usuarios/index.blade.php --}}
@extends('layouts.sepulturero')

@section('title', 'Gestión del Sistema - El Sepulturero Juan')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><i class="fas fa-cog"></i> Módulo de Usuarios</h3>
                        <div>
                            {{-- Botón Nuevo Usuario (solo si tiene permiso) --}}
                            @if (auth()->user()->tienePermiso('ver_usuarios'))
                                <button type="button" class="btn btn-light" id="btnCrearUsuario">
                                    <i class="fas fa-plus"></i> Nuevo Usuario
                                </button>
                            @endif

                            {{-- Botón Nuevo Empleado (solo si tiene permiso) --}}
                            @if (auth()->user()->tienePermiso('ver_empleados'))
                                <button type="button" class="btn btn-light" id="btnCrearEmpleado">
                                    <i class="fas fa-user-tie"></i> Nuevo Empleado
                                </button>
                            @endif

                            {{-- Botón Nuevo Rol (solo si tiene permiso) --}}
                            @if (auth()->user()->tienePermiso('ver_roles'))
                                <button type="button" class="btn btn-light" id="btnCrearRol">
                                    <i class="fas fa-tag"></i> Nuevo Rol
                                </button>
                            @endif
                            {{-- Botón Nuevo Rol (solo si tiene permiso)
                            @if (auth()->user()->tienePermiso('crear_rol'))
                                <button type="button" class="btn btn-light" id="btnCrearRol">
                                    <i class="fas fa-tag"></i> Nuevo permiso
                                </button>
                            @endif --}}

                        </div>
                    </div>

                    <div class="card-body">

                        <!-- Pestañas manuales -->
                        <div class="mb-4">
                            <div class="btn-group" role="group">
                                {{-- Pestaña Usuarios (solo si tiene permiso) --}}
                                @if (auth()->user()->tienePermiso('ver_usuarios'))
                                    <button type="button" class="btn btn-primary" data-tab="usuarios">
                                        <i class="fas fa-users"></i> Usuarios
                                    </button>
                                @endif

                                {{-- Pestaña Empleados (solo si tiene permiso) --}}
                                @if (auth()->user()->tienePermiso('ver_empleados'))
                                    <button type="button" class="btn btn-outline-primary" data-tab="empleados">
                                        <i class="fas fa-user-tie"></i> Empleados
                                    </button>
                                @endif

                                {{-- Pestaña Roles (solo si tiene permiso) --}}
                                @if (auth()->user()->tienePermiso('ver_roles'))
                                    <button type="button" class="btn btn-outline-primary" data-tab="roles">
                                        <i class="fas fa-tag"></i> Roles
                                    </button>
                                @endif

                                {{-- Pestaña Permisos (solo si tiene permiso) --}}
                                @if (auth()->user()->tienePermiso('ver_roles'))
                                    <button type="button" class="btn btn-outline-primary" data-tab="permisos">
                                        <i class="fas fa-lock"></i> Permisos
                                    </button>
                                @endif

                                {{-- Pestaña Rol-Permisos (solo si tiene permiso) --}}
                                @if (auth()->user()->tienePermiso('ver_roles'))
                                    <button type="button" class="btn btn-outline-primary" data-tab="rol-permisos">
                                        <i class="fas fa-link"></i> Rol-Permisos
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Contenido de las pestañas -->
                        <div id="tabContent">
                            <!-- TABLA DE USUARIOS -->
                            @if (auth()->user()->tienePermiso('ver_usuarios'))
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
                                                    <th>Usuario</th>
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
                                                            {{-- Botones de acción según permisos --}}
                                                            {{-- @if (auth()->user()->tienePermiso('editar_usuario')) --}}
                                                            <button class="btn-accion btn-edit editar-usuario"
                                                                data-id="{{ $usuario->id }}" title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            {{-- @endif --}}
                                                            {{-- @if (auth()->user()->tienePermiso('eliminar_usuario')) --}}
                                                            <button class="btn-accion btn-delete eliminar-usuario"
                                                                data-id="{{ $usuario->id }}" title="Eliminar">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                            {{-- @endif --}}
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
                            @endif

                            <!-- TABLA DE EMPLEADOS -->
                            @if (auth()->user()->tienePermiso('ver_empleados'))
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
                                                            {{-- @if (auth()->user()->tienePermiso('editar_empleado')) --}}
                                                            <button class="btn-accion btn-edit editar-empleado"
                                                                data-id="{{ $empleado->idEmpleado }}" title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            {{-- @endif --}}
                                                            {{-- @if (auth()->user()->tienePermiso('eliminar_empleado')) --}}
                                                            <button class="btn-accion btn-delete eliminar-empleado"
                                                                data-id="{{ $empleado->idEmpleado }}" title="Eliminar">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                            {{-- @endif --}}
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
                            @endif

                            <!-- TABLA DE ROLES -->
                            @if (auth()->user()->tienePermiso('ver_roles'))
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
                                                        <td><span
                                                                class="badge-rol badge-info">{{ $rol->permisos->count() }}
                                                                permisos</span></td>
                                                        <td>
                                                            {{-- @if (auth()->user()->tienePermiso('editar_rol')) --}}
                                                            <button class="btn-accion btn-edit editar-permisos-rol"
                                                                data-id="{{ $rol->idRol }}" title="Editar Permisos">
                                                                <i class="fas fa-key"></i>
                                                            </button>
                                                            {{-- @endif --}}
                                                            {{-- @if (auth()->user()->tienePermiso('eliminar_rol')) --}}
                                                            <button class="btn-accion btn-delete eliminar-rol"
                                                                data-id="{{ $rol->idRol }}" title="Eliminar">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                            {{-- @endif --}}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">No hay roles registrados
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            <!-- TABLA DE PERMISOS -->
                            @if (auth()->user()->tienePermiso('ver_roles'))
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
                                                        {{-- <td>
                                                            @if (auth()->user()->tienePermiso('editar_permiso'))
                                                                <button class="btn-accion btn-edit editar-permiso"
                                                                    data-id="{{ $permiso->idPer }}" title="Editar">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                            @endif
                                                            @if (auth()->user()->tienePermiso('eliminar_permiso'))
                                                                <button class="btn-accion btn-delete eliminar-permiso"
                                                                    data-id="{{ $permiso->idPer }}" title="Eliminar">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            @endif
                                                        </td> --}}
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
                            @endif

                            <!-- TABLA DE ROL-PERMISOS (ASIGNACIONES) -->
                            @if (auth()->user()->tienePermiso('ver_roles'))
                                <div id="tab-rol-permisos" class="tab-pane" style="display: none;">
                                    <div class="mb-3">
                                        <input type="text" id="buscarRolPermiso" class="form-control"
                                            placeholder="🔍 Buscar por rol o permiso...">
                                    </div>

                                    <div class="table-responsive">
                                        <table class="usuarios-table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Rol</th>
                                                    <th>Permiso</th>
                                                    <th>Fecha Asignación</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($rolPermisos as $rp)
                                                    <tr class="fila-rol-permiso">
                                                        <td>{{ $rp->id }}</td>
                                                        <td>{{ $rp->rol->nombre ?? 'N/A' }}</td>
                                                        <td>{{ $rp->permiso->nombre ?? 'N/A' }}</td>
                                                        <td>{{ $rp->created_at ? $rp->created_at->format('d/m/Y H:i') : 'N/A' }}
                                                        </td>
                                                        <td>
                                                            {{-- @if (auth()->user()->tienePermiso('eliminar_rol'))
                                                                <button class="btn-accion btn-delete eliminar-rol-permiso"
                                                                    data-id="{{ $rp->id }}"
                                                                    title="Eliminar asignación">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            @endif --}}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">No hay asignaciones de
                                                            permisos a roles registradas</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODALS -->
    @if (auth()->user()->tienePermiso('ver_usuarios'))
        @include('gestionarUsuario.modals.usuario-crear')
        @include('gestionarUsuario.modals.usuario-editar')
    @endif

    @if (auth()->user()->tienePermiso('ver_roles'))
        @include('gestionarUsuario.modals.rol-crear')
        @include('gestionarUsuario.modals.rol-editar-permisos')
    @endif

    {{-- @if (auth()->user()->tienePermiso('crear_permiso'))
        @include('gestionarUsuario.modals.permiso-crear')
    @endif --}}

    @if (auth()->user()->tienePermiso('ver_empleados'))
        @include('gestionarUsuario.modals.empleado-crear')
        @include('gestionarUsuario.modals.empleado-editar')
    @endif
    {{-- @if (auth()->user()->tienePermiso('crear_rol'))
        @include('gestionarUsuario.modals.permiso-crear')
    @endif --}}
@endsection
