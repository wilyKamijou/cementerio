{{-- resources/views/admin/inhumaciones/index.blade.php --}}
@extends('layouts.sepulturero')

@section('title', 'Gestión de Inhumaciones - El Sepulturero Juan')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><i class="fas fa-dove"></i> Módulo de Inhumaciones</h3>
                        <div>
                            @if (auth()->user()->tienePermiso('ver_inhumaciones'))
                                <button type="button" class="btn btn-light" id="btnCrearInhumacion">
                                    <i class="fas fa-plus-circle"></i> Nueva Inhumación
                                </button>
                            @endif
                            @if (auth()->user()->tienePermiso('ver_tipo_inhumaciones'))
                                <button type="button" class="btn btn-light" id="btnCrearTipoInhumacion">
                                    <i class="fas fa-tag"></i> Nuevo Tipo
                                </button>
                            @endif
                            @if (auth()->user()->tienePermiso('ver_mantenimientos'))
                                <button type="button" class="btn btn-light" id="btnCrearMantenimiento">
                                    <i class="fas fa-tools"></i> Nuevo Mantenimiento
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Pestañas -->
                        <div class="mb-4">
                            <div class="btn-group" role="group">
                                @if (auth()->user()->tienePermiso('ver_inhumaciones'))
                                    <button type="button" class="btn btn-primary" data-tab="inhumaciones">
                                        <i class="fas fa-dove"></i> Inhumaciones
                                    </button>
                                @endif
                                @if (auth()->user()->tienePermiso('ver_tipo_inhumaciones'))
                                    <button type="button" class="btn btn-outline-primary" data-tab="tipos">
                                        <i class="fas fa-tags"></i> Tipos de Inhumación
                                    </button>
                                @endif
                                @if (auth()->user()->tienePermiso('ver_mantenimientos'))
                                    <button type="button" class="btn btn-outline-primary" data-tab="mantenimientos">
                                        <i class="fas fa-tools"></i> Mantenimientos
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div id="tabContent">
                            <!-- TABLA DE INHUMACIONES -->
                            @if (auth()->user()->tienePermiso('ver_inhumaciones'))
                                <div id="tab-inhumaciones" class="tab-pane" style="display: block;">
                                    <div class="mb-3">
                                        <input type="text" id="buscarInhumacion" class="form-control"
                                            placeholder="🔍 Buscar inhumación...">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="usuarios-table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Fallecido</th>
                                                    <th>Fecha Nacimiento</th>
                                                    <th>Fecha Defunción</th>
                                                    <th>Fecha Inhumación</th>
                                                    <th>Tipo</th>
                                                    <th>Espacio</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($inhumaciones as $inhumacion)
                                                    <tr class="fila-inhumacion">
                                                        <td>{{ $inhumacion->idInhum }}</td>
                                                        <td>{{ $inhumacion->nombre }} {{ $inhumacion->paterno }}
                                                            {{ $inhumacion->materno }}</td>
                                                        <td>{{ $inhumacion->fechaNaci ? \Carbon\Carbon::parse($inhumacion->fechaNaci)->format('d/m/Y') : 'N/A' }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($inhumacion->fechaDefun)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($inhumacion->fechaInhuma)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ $inhumacion->tipo->nombre ?? 'N/A' }}</td>
                                                        <td>{{ $inhumacion->espacio->idEspacio ?? 'N/A' }}</td>
                                                        <td>
                                                            <button class="btn-accion btn-edit editar-inhumacion"
                                                                data-id="{{ $inhumacion->idInhum }}" title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn-accion btn-delete eliminar-inhumacion"
                                                                data-id="{{ $inhumacion->idInhum }}" title="Eliminar">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center">No hay inhumaciones
                                                            registradas</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            <!-- TABLA DE TIPOS DE INHUMACIÓN -->
                            @if (auth()->user()->tienePermiso('ver_tipo_inhumaciones'))
                                <div id="tab-tipos" class="tab-pane" style="display: none;">
                                    <div class="mb-3">
                                        <input type="text" id="buscarTipoInhumacion" class="form-control"
                                            placeholder="🔍 Buscar tipo de inhumación...">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="usuarios-table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nombre</th>
                                                    <th>Precio</th>
                                                    <th>Capacidad Máx</th>
                                                    <th>Área Base</th>
                                                    <th>Estado</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($tiposInhumacion as $tipo)
                                                    <tr class="fila-tipo-inhumacion">
                                                        <td>{{ $tipo->idTipo }}</td>
                                                        <td>{{ $tipo->nombre }}</td>
                                                        <td>${{ number_format($tipo->precio, 2) }}</td>
                                                        <td>{{ $tipo->capacidadMax ?? 'N/A' }}</td>
                                                        <td>{{ $tipo->areaBase ? $tipo->areaBase . ' m²' : 'N/A' }}</td>
                                                        <td>
                                                            <span
                                                                class="estado-badge {{ $tipo->estado == 'activo' ? 'badge-available' : 'badge-occupied' }}">
                                                                {{ ucfirst($tipo->estado) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <button class="btn-accion btn-edit editar-tipo-inhumacion"
                                                                data-id="{{ $tipo->idTipo }}" title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn-accion btn-delete eliminar-tipo-inhumacion"
                                                                data-id="{{ $tipo->idTipo }}" title="Eliminar">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">No hay tipos de inhumación
                                                            registrados</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            <!-- TABLA DE MANTENIMIENTOS -->
                            @if (auth()->user()->tienePermiso('ver_mantenimientos'))
                                <div id="tab-mantenimientos" class="tab-pane" style="display: none;">
                                    <div class="mb-3">
                                        <input type="text" id="buscarMantenimiento" class="form-control"
                                            placeholder="🔍 Buscar mantenimiento...">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="usuarios-table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Espacio</th>
                                                    <th>Tipo</th>
                                                    <th>Fecha</th>
                                                    <th>Precio</th>
                                                    <th>Estado</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($mantenimientos as $mantenimiento)
                                                    <tr class="fila-mantenimiento">
                                                        <td>{{ $mantenimiento->idMant }}</td>
                                                        <td>Espacio #{{ $mantenimiento->idEspacio }}</td>
                                                        <td>{{ ucfirst($mantenimiento->tipo) }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($mantenimiento->fechaMant)->format('d/m/Y') }}
                                                        </td>
                                                        <td>${{ number_format($mantenimiento->precio, 2) }}</td>
                                                        <td>
                                                            <span
                                                                class="estado-badge 
                                                                @if ($mantenimiento->estado == 'completado') badge-available
                                                                @elseif($mantenimiento->estado == 'en_proceso') badge-reserved
                                                                @else badge-occupied @endif">
                                                                {{ ucfirst($mantenimiento->estado) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <button class="btn-accion btn-edit editar-mantenimiento"
                                                                data-id="{{ $mantenimiento->idMant }}" title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn-accion btn-delete eliminar-mantenimiento"
                                                                data-id="{{ $mantenimiento->idMant }}" title="Eliminar">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">No hay mantenimientos
                                                            registrados</td>
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
    @if (auth()->user()->tienePermiso('ver_inhumaciones'))
        @include('inhumaciones.modals.inhumacion-crear')
        @include('inhumaciones.modals.inhumacion-editar')
    @endif
    @if (auth()->user()->tienePermiso('ver_tipo_inhumaciones'))
        @include('inhumaciones.modals.tipo-inhumacion-crear')
        @include('inhumaciones.modals.tipo-inhumacion-editar')
    @endif
    @if (auth()->user()->tienePermiso('ver_mantenimientos'))
        @include('inhumaciones.modals.mantenimiento-crear')
        @include('inhumaciones.modals.mantenimiento-editar')
    @endif
@endsection
