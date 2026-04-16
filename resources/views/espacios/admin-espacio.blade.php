{{-- resources/views/admin/inhumaciones/index.blade.php --}}
@extends('layouts.sepulturero')

@section('title', 'Gestión de Inhumaciones - El Sepulturero Juan')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><i class="fas fa-dove"></i> Módulo de Espacios</h3>
                        <div>

                            @if (auth()->user()->tienePermiso('ver_espacios'))
                                <button type="button" class="btn btn-light" id="btnCrearEspacio">
                                    <i class="fas fa-monument"></i> Nuevo Espacio
                                </button>
                            @endif
                            @if (auth()->user()->tienePermiso('ver_cementerios'))
                                <button type="button" class="btn btn-light" id="btnCrearCementerio">
                                    <i class="fas fa-building"></i> Nuevo Cementerio
                                </button>
                            @endif

                            @if (auth()->user()->tienePermiso('ver_dimensiones'))
                                <button type="button" class="btn btn-light" id="btnCrearDimension">
                                    <i class="fas fa-tag"></i> Nuevo Dimension
                                </button>
                            @endif
                            @if (auth()->user()->tienePermiso('ver_direcciones'))
                                <button type="button" class="btn btn-light" id="btnCrearDireccion">
                                    <i class="fas fa-plus"></i> Nueva Direccion
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Pestañas -->
                        <div class="mb-4">
                            <div class="btn-group" role="group">
                                @if (auth()->user()->tienePermiso('ver_espacios'))
                                    <button type="button" class="btn btn-primary" data-tab="espacios">
                                        <i class="fas fa-tombstone"></i> Espacios
                                    </button>
                                @endif
                                @if (auth()->user()->tienePermiso('ver_cementerios'))
                                    <button type="button" class="btn btn-outline-primary" data-tab="cementerios">
                                        <i class="fas fa-building"></i> Cementerios
                                    </button>
                                @endif
                                @if (auth()->user()->tienePermiso('ver_dimensiones'))
                                    <button type="button" class="btn btn-outline-primary" data-tab="dimensiones">
                                        <i class="fas fa-arrows-alt"></i> Dimensiones
                                    </button>
                                @endif
                                @if (auth()->user()->tienePermiso('ver_direcciones'))
                                    <button type="button" class="btn btn-outline-primary" data-tab="direcciones">
                                        <i class="fas fa-map-marker-alt"></i> Direcciones
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div id="tabContent">
                            {{-- tabla de espacio --}}
                            @if (auth()->user()->tienePermiso('ver_espacios'))
                                <div id="tab-espacios" class="tab-pane" style="display: block;">
                                    <div class="mb-3">
                                        <input type="text" id="buscarEspacio" class="form-control"
                                            placeholder="🔍 Buscar espacio...">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="usuarios-table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Precio</th>
                                                    <th>Estado</th>
                                                    <th>Dirección</th>
                                                    <th>Dimensiones</th>
                                                    <th>Cementerio</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($espacios as $espacio)
                                                    <tr class="fila-espacio">
                                                        <td>{{ $espacio->idEspacio }}</td>
                                                        <td>${{ number_format($espacio->precio, 2) }}</td>
                                                        <td>
                                                            @php
                                                                $estadoClass = '';
                                                                switch ($espacio->estado) {
                                                                    case 'disponible':
                                                                        $estadoClass = 'badge-available';
                                                                        break;
                                                                    case 'ocupado':
                                                                        $estadoClass = 'badge-occupied';
                                                                        break;
                                                                    case 'reservado':
                                                                        $estadoClass = 'badge-reserved';
                                                                        break;
                                                                }
                                                            @endphp
                                                            <span class="estado-badge {{ $estadoClass }}">
                                                                {{ ucfirst($espacio->estado) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @if ($espacio->direccion)
                                                                <div class="direccion-completa">
                                                                    <small>
                                                                        <strong>Secc:</strong>
                                                                        {{ $espacio->direccion->seccion }} |
                                                                        <strong>Núm:</strong>
                                                                        {{ $espacio->direccion->numero }} |
                                                                        <strong>Calle:</strong>
                                                                        {{ $espacio->direccion->calle }} |
                                                                        <strong>Fila:</strong>
                                                                        {{ $espacio->direccion->fila }}
                                                                    </small>
                                                                </div>
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($espacio->dimension)
                                                                {{ $espacio->dimension->ancho }} x
                                                                {{ $espacio->dimension->largo }} m²
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($espacio->cementerio)
                                                                {{ $espacio->cementerio->nombre }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button class="btn-accion btn-edit editar-espacio"
                                                                data-id="{{ $espacio->idEspacio }}" title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn-accion btn-delete eliminar-espacio"
                                                                data-id="{{ $espacio->idEspacio }}" title="Eliminar">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">No hay espacios registrados
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif


                            <!-- TABLA DE CEMENTERIOS -->
                            @if (auth()->user()->tienePermiso('ver_cementerios'))
                                <div id="tab-cementerios" class="tab-pane" style="display: none;">
                                    <div class="mb-3">
                                        <input type="text" id="buscarCementerio" class="form-control"
                                            placeholder="🔍 Buscar cementerio...">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="usuarios-table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nombre</th>
                                                    <th>Estado</th>
                                                    <th>Localización</th>
                                                    <th>Espacios Disponibles</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($cementerios as $cementerio)
                                                    <tr class="fila-cementerio">
                                                        <td>{{ $cementerio->idCem }}</td>
                                                        <td>{{ $cementerio->nombre }}</td>
                                                        <td>{{ $cementerio->estado }}</td>
                                                        <td>{{ $cementerio->localizacion ?? 'N/A' }}</td>
                                                        <td>{{ $cementerio->espacioDisp ?? 'N/A' }}</td>
                                                        <td>
                                                            <button class="btn-accion btn-edit editar-cementerio"
                                                                data-id="{{ $cementerio->idCem }}" title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn-accion btn-delete eliminar-cementerio"
                                                                data-id="{{ $cementerio->idCem }}" title="Eliminar">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">No hay cementerios
                                                            registrados</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif


                            <!-- TABLA DE DIMENSIONES -->
                            @if (auth()->user()->tienePermiso('ver_dimensiones'))
                                <div id="tab-dimensiones" class="tab-pane" style="display: none;">
                                    <div class="mb-3">
                                        <input type="text" id="buscarDimension" class="form-control"
                                            placeholder="🔍 Buscar dimensión...">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="usuarios-table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Ancho (m)</th>
                                                    <th>Largo (m)</th>
                                                    <th>Área (m²)</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($dimensiones as $dimension)
                                                    <tr class="fila-dimension">
                                                        <td>{{ $dimension->idDim }}</td>
                                                        <td>{{ $dimension->ancho }} m</td>
                                                        <td>{{ $dimension->largo }} m</td>
                                                        <td>{{ $dimension->area }} m²</td>
                                                        <td>
                                                            <button class="btn-accion btn-edit editar-dimension"
                                                                data-id="{{ $dimension->idDim }}" title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn-accion btn-delete eliminar-dimension"
                                                                data-id="{{ $dimension->idDim }}" title="Eliminar">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">No hay dimensiones
                                                            registradas</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            <!-- TABLA DE DIRECCIONES -->
                            @if (auth()->user()->tienePermiso('ver_direcciones'))
                                <div id="tab-direcciones" class="tab-pane" style="display: none;">
                                    <div class="mb-3">
                                        <input type="text" id="buscarDireccion" class="form-control"
                                            placeholder="🔍 Buscar dirección...">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="usuarios-table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Sección</th>
                                                    <th>Número</th>
                                                    <th>Calle</th>
                                                    <th>Fila</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($direcciones as $direccion)
                                                    <tr class="fila-direccion">
                                                        <td>{{ $direccion->idDir }}</td>
                                                        <td>{{ $direccion->seccion }}</td>
                                                        <td>{{ $direccion->numero }}</td>
                                                        <td>{{ $direccion->calle }}</td>
                                                        <td>{{ $direccion->fila }}</td>
                                                        <td>
                                                            <button class="btn-accion btn-edit editar-direccion"
                                                                data-id="{{ $direccion->idDir }}" title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn-accion btn-delete eliminar-direccion"
                                                                data-id="{{ $direccion->idDir }}" title="Eliminar">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">No hay direcciones
                                                            registradas</td>
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
    @if (auth()->user()->tienePermiso('ver_cementerios'))
        @include('espacios.modals.cementerio-crear')
    @endif
    @if (auth()->user()->tienePermiso('ver_espacios'))
        @include('espacios.modals.espacio-crear')
    @endif
    @if (auth()->user()->tienePermiso('ver_dimensiones'))
        @include('espacios.modals.dimension-crear')
    @endif
    @if (auth()->user()->tienePermiso('ver_direcciones'))
        @include('espacios.modals.direccion-crear')
    @endif

    @if (auth()->user()->tienePermiso('ver_cementerios'))
        @include('espacios.modals.cementerio-editar')
    @endif
    @if (auth()->user()->tienePermiso('ver_espacios'))
        @include('espacios.modals.espacio-editar')
    @endif
    @if (auth()->user()->tienePermiso('ver_dimensiones'))
        @include('espacios.modals.dimension-editar')
    @endif
    @if (auth()->user()->tienePermiso('ver_direcciones'))
        @include('espacios.modals.direccion-editar')
    @endif
@endsection
