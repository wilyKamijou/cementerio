{{-- resources/views/admin/usuarios/index.blade.php --}}
@extends('layouts.sepulturero')

@section('title', 'Gestión de Usuarios - El Sepulturero Juan')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><i class="fas fa-users"></i> Gestión de Usuarios</h3>
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
                        <!-- Buscador -->
                        <div class="mb-3">
                            <input type="text" id="buscarUsuario" class="form-control"
                                placeholder="🔍 Buscar usuario...">
                        </div>

                        <!-- Tabla de usuarios -->
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
                                                    <span class="badge-rol badge-{{ strtolower($usuario->roles->nombre) }}">
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
                                            <td colspan="6" class="text-center">No hay usuarios registrados</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
