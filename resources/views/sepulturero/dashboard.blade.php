{{-- resources/views/sepulturero/dashboard.blade.php --}}
@extends('layouts.sepulturero')

@section('title', 'Dashboard - El Sepulturero Juan')

@section('active_dashboard', 'active')

@section('content')
    <!-- Tarjetas de estadísticas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>Espacios Totales</h3>
                <span class="stat-number">{{ $espaciosTotales ?? '1,247' }}</span>
            </div>
            <div class="stat-icon">
                <i class="fas fa-tombstone"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3>Espacios Disponibles</h3>
                <span class="stat-number">{{ $espaciosDisponibles ?? '342' }}</span>
            </div>
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3>Contratos Activos</h3>
                <span class="stat-number">{{ $contratosActivos ?? '856' }}</span>
            </div>
            <div class="stat-icon">
                <i class="fas fa-file-contract"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3>Ventas del Mes</h3>
                <span class="stat-number">{{ $ventasMes ?? '$245K' }}</span>
            </div>
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>

    <!-- Acciones rápidas -->
    <div class="quick-actions">
        <h2><i class="fas fa-bolt"></i> Acciones Rápidas</h2>
        <div class="actions-grid">
            <button class="action-btn">
                <i class="fas fa-plus-circle"></i>
                <span>Nuevo Contrato</span>
            </button>
            <button class="action-btn">
                <i class="fas fa-truck"></i>
                <span>Registrar Inhumación</span>
            </button>
            <button class="action-btn">
                <i class="fas fa-wrench"></i>
                <span>Solicitar Mantenimiento</span>
            </button>
            <button class="action-btn">
                <i class="fas fa-hand-holding-usd"></i>
                <span>Venta a Crédito</span>
            </button>
            <button class="action-btn">
                <i class="fas fa-file-invoice"></i>
                <span>Generar Reporte</span>
            </button>
            <button class="action-btn">
                <i class="fas fa-search"></i>
                <span>Buscar Difunto</span>
            </button>
        </div>
    </div>

    <!-- Módulos principales -->
    <div class="modules-grid">
        <!-- Módulo de Contratos -->
        <div class="module-card">
            <div class="module-header">
                <i class="fas fa-file-contract"></i>
                <h3>Contratos Recientes</h3>
            </div>
            <div class="module-content">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Contrato</th>
                                <th>Cliente</th>
                                <th>Espacio</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contratosRecientes ?? [] as $contrato)
                            <tr>
                                <td>{{ $contrato->codigo }}</td>
                                <td>{{ $contrato->cliente }}</td>
                                <td>{{ $contrato->espacio }}</td>
                                <td><span class="badge badge-success">{{ $contrato->estado }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">No hay contratos recientes</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Módulo de Inhumaciones -->
        <div class="module-card">
            <div class="module-header">
                <i class="fas fa-tombstone"></i>
                <h3>Próximas Inhumaciones</h3>
            </div>
            <div class="module-content">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Difunto</th>
                                <th>Ubicación</th>
                                <th>Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proximasInhumaciones ?? [] as $inhumacion)
                            <tr>
                                <td>{{ $inhumacion->fecha }}</td>
                                <td>{{ $inhumacion->difunto }}</td>
                                <td>{{ $inhumacion->ubicacion }}</td>
                                <td>{{ $inhumacion->hora }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">No hay inhumaciones programadas</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Módulo de Mantenimiento -->
        <div class="module-card">
            <div class="module-header">
                <i class="fas fa-tools"></i>
                <h3>Mantenimientos Pendientes</h3>
            </div>
            <div class="module-content">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ubicación</th>
                                <th>Tipo</th>
                                <th>Prioridad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mantenimientosPendientes ?? [] as $mantenimiento)
                            <tr>
                                <td>{{ $mantenimiento->id }}</td>
                                <td>{{ $mantenimiento->ubicacion }}</td>
                                <td>{{ $mantenimiento->tipo }}</td>
                                <td><span class="badge badge-warning">{{ $mantenimiento->prioridad }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">No hay mantenimientos pendientes</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Módulo de Ventas a Crédito -->
        <div class="module-card">
            <div class="module-header">
                <i class="fas fa-credit-card"></i>
                <h3>Ventas a Crédito</h3>
            </div>
            <div class="module-content">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Espacio</th>
                                <th>Monto</th>
                                <th>Cuotas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ventasCredito ?? [] as $venta)
                            <tr>
                                <td>{{ $venta->cliente }}</td>
                                <td>{{ $venta->espacio }}</td>
                                <td>{{ $venta->monto }}</td>
                                <td>{{ $venta->cuotas }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">No hay ventas a crédito registradas</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel de ventas al contado y crédito -->
    <div class="quick-actions">
        <h2><i class="fas fa-chart-pie"></i> Panel de Ventas</h2>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <h3>Ventas al Contado - Hoy</h3>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr><th>Espacio</th><th>Monto</th><th>Estado</th></tr>
                        </thead>
                        <tbody>
                            @forelse($ventasContadoHoy ?? [] as $venta)
                            <tr><td>{{ $venta->espacio }}</td><td>{{ $venta->monto }}</td><td><span class="badge badge-success">Pagado</span></td></tr>
                            @empty
                            <tr><td colspan="3">No hay ventas al contado hoy</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <h3>Cuotas por Vencer</h3>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr><th>Cliente</th><th>Cuota</th><th>Monto</th><th>Estado</th></tr>
                        </thead>
                        <tbody>
                            @forelse($cuotasPorVencer ?? [] as $cuota)
                            <tr><td>{{ $cuota->cliente }}</td><td>{{ $cuota->cuota }}</td><td>{{ $cuota->monto }}</td><td><span class="badge badge-warning">Próximo</span></td></tr>
                            @empty
                            <tr><td colspan="4">No hay cuotas por vencer</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de búsqueda y registro rápido -->
    <div class="grid-2">
        <!-- Formulario de búsqueda -->
        <div class="quick-actions">
            <h2><i class="fas fa-search"></i> Buscar Registros</h2>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <select id="searchType" class="form-control" style="width: 200px;">
                    <option>Contratos</option>
                    <option>Inhumaciones</option>
                    <option>Difuntos</option>
                    <option>Clientes</option>
                </select>
                <input type="text" id="searchTerm" class="form-control" placeholder="Ingrese término de búsqueda..." style="flex: 1;">
                <button class="btn btn-primary search-btn"><i class="fas fa-search"></i> Buscar</button>
            </div>
        </div>

        <!-- Registro rápido -->
        <div class="quick-actions">
            <h2><i class="fas fa-clock"></i> Registro Rápido</h2>
            <select id="quickRegisterType" class="form-control" style="margin-bottom: 0.5rem;">
                <option>Seleccionar tipo de registro</option>
                <option>Nuevo contrato</option>
                <option>Nueva inhumación</option>
                <option>Solicitud de mantenimiento</option>
                <option>Venta al contado</option>
                <option>Venta a crédito</option>
            </select>
            <button id="quickRegisterBtn" class="btn btn-primary" style="width: 100%;">Continuar</button>
        </div>
    </div>
@endsection