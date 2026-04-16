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

                            @if (auth()->user()->tienePermiso('crear_espacio'))
                                <button type="button" class="btn btn-light" id="btnCrearEspacio">
                                    <i class="fas fa-tombstone"></i> Nuevo Espacio
                                </button>
                            @endif
                            @if (auth()->user()->tienePermiso('crear_cementerio'))
                                <button type="button" class="btn btn-light" id="btnCrearCementerio">
                                    <i class="fas fa-building"></i> Nuevo Cementerio
                                </button>
                            @endif

                            @if (auth()->user()->tienePermiso('crear_dimension'))
                                <button type="button" class="btn btn-light" id="btnCrearTipoInhumacion">
                                    <i class="fas fa-tag"></i> Nuevo Dimension
                                </button>
                            @endif
                            @if (auth()->user()->tienePermiso('crear_direccion'))
                                <button type="button" class="btn btn-light" id="btnCrearInhumacion">
                                    <i class="fas fa-plus"></i> Nueva Direccion
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
                                @if (auth()->user()->tienePermiso('ver_cementerios'))
                                    <button type="button" class="btn btn-outline-primary" data-tab="cementerios">
                                        <i class="fas fa-building"></i> Cementerios
                                    </button>
                                @endif
                                @if (auth()->user()->tienePermiso('ver_espacios'))
                                    <button type="button" class="btn btn-outline-primary" data-tab="espacios">
                                        <i class="fas fa-tombstone"></i> Espacios
                                    </button>
                                @endif
                                @if (auth()->user()->tienePermiso('ver_tipos_inhumacion'))
                                    <button type="button" class="btn btn-outline-primary" data-tab="tipos">
                                        <i class="fas fa-tag"></i> Tipos de Inhumación
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
                                                    <th>Nombre Completo</th>
                                                    <th>Fecha Defunción</th>
                                                    <th>Fecha Inhumación</th>
                                                    <th>Espacio</th>
                                                    <th>Tipo</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($inhumaciones as $inhumacion)
                                                    <tr class="fila-inhumacion">
                                                        <td>{{ $inhumacion->idInhum }}</td>
                                                        <td>{{ $inhumacion->nombre }} {{ $inhumacion->paterno }}
                                                            {{ $inhumacion->materno }}</td>
                                                        <td>{{ $inhumacion->fechaDefun }}</td>
                                                        <td>{{ $inhumacion->fechaInhuma }}</td>
                                                        <td>{{ $inhumacion->espacio->idEspacio ?? 'N/A' }}</td>
                                                        <td>{{ $inhumacion->tipo->nombre ?? 'N/A' }}</td>
                                                        <td>
                                                            @if (auth()->user()->tienePermiso('editar_inhumacion'))
                                                                <button class="btn-accion btn-edit editar-inhumacion"
                                                                    data-id="{{ $inhumacion->idInhum }}" title="Editar">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                            @endif
                                                            @if (auth()->user()->tienePermiso('eliminar_inhumacion'))
                                                                <button class="btn-accion btn-delete eliminar-inhumacion"
                                                                    data-id="{{ $inhumacion->idInhum }}" title="Eliminar">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">No hay inhumaciones
                                                            registradas</td>
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

                            <!-- TABLA DE ESPACIOS -->
                            @if (auth()->user()->tienePermiso('ver_espacios'))
                                <div id="tab-espacios" class="tab-pane" style="display: none;">
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
                                                        <td>{{ $espacio->estado }}</td>
                                                        <td>{{ $espacio->direccion->seccion ?? 'N/A' }} -
                                                            {{ $espacio->direccion->numero ?? 'N/A' }}</td>
                                                        <td>{{ $espacio->dimension->ancho ?? 'N/A' }} x
                                                            {{ $espacio->dimension->largo ?? 'N/A' }} m²</td>
                                                        <td>{{ $espacio->cementerio->nombre ?? 'N/A' }}</td>
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

                            <!-- TABLA DE TIPOS DE INHUMACIÓN -->
                            @if (auth()->user()->tienePermiso('ver_tipos_inhumacion'))
                                <div id="tab-tipos" class="tab-pane" style="display: none;">
                                    <div class="mb-3">
                                        <input type="text" id="buscarTipo" class="form-control"
                                            placeholder="🔍 Buscar tipo...">
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
                                                    <tr class="fila-tipo">
                                                        <td>{{ $tipo->idTipo }}</td>
                                                        <td>{{ $tipo->nombre }}</td>
                                                        <td>${{ number_format($tipo->precio, 2) }}</td>
                                                        <td>{{ $tipo->capacidadMax ?? 'N/A' }}</td>
                                                        <td>{{ $tipo->areaBase }} m²</td>
                                                        <td>{{ $tipo->estado ?? 'Activo' }}</td>
                                                        <td>
                                                            <button class="btn-accion btn-edit editar-tipo"
                                                                data-id="{{ $tipo->idTipo }}" title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn-accion btn-delete eliminar-tipo"
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
    @if (auth()->user()->tienePermiso('crear_cementerio'))
        @include('espacios.modals.cementerio-crear')
    @endif
    @if (auth()->user()->tienePermiso('crear_espacio'))
        @include('espacios.modals.espacio-crear')
    @endif
    @if (auth()->user()->tienePermiso('crear_dimension'))
        @include('espacios.modals.dimension-crear')
    @endif
    @if (auth()->user()->tienePermiso('crear_direccion'))
        @include('espacios.modals.direccion-crear')
    @endif
    @if (auth()->user()->tienePermiso('editar_cementerio'))
        @include('espacios.modals.cementerio-editar')
    @endif
    @if (auth()->user()->tienePermiso('editar_espacio'))
        @include('espacios.modals.espacio-editar')
    @endif
    @if (auth()->user()->tienePermiso('editar_direccion'))
        @include('espacios.modals.direccion-editar')
    @endif
    @if (auth()->user()->tienePermiso('editar_dimension'))
        @include('espacios.modals.dimension-editar')
    @endif
    <script>
        // Pestañas manuales
        document.querySelectorAll('[data-tab]').forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                document.querySelectorAll('[data-tab]').forEach(btn => {
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-outline-primary');
                });
                this.classList.remove('btn-outline-primary');
                this.classList.add('btn-primary');
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.style.display = 'none';
                });
                document.getElementById(`tab-${tabId}`).style.display = 'block';
            });
        });
    </script>
@endsection
