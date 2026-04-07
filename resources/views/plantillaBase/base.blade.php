{{-- resources/views/cementerio/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard - Cementerio')

@section('page', 'Dashboard')

@section('content')
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon">📊</div>
        <div class="stat-title">Total Inhumaciones</div>
        <div class="stat-value">{{ $totalDifuntos }}</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">📅</div>
        <div class="stat-title">Registros este mes</div>
        <div class="stat-value">{{ $registrosMes }}</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">📍</div>
        <div class="stat-title">Espacios ocupados</div>
        <div class="stat-value">{{ $totalSectores }}</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">🧹</div>
        <div class="stat-title">Mantenimientos hoy</div>
        <div class="stat-value">{{ $mantenimientosHoy }}</div>
    </div>
</div>

<div class="card">
    <h3>Últimas inhumaciones</h3>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nombre completo</th>
                    <th>Fecha defunción</th>
                    <th>Fecha inhumación</th>
                    <th>Espacio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ultimosDifuntos as $difunto)
                <tr>
                    <td>{{ $difunto->nombre }} {{ $difunto->paterno }} {{ $difunto->materno }}</td>
                    <td>{{ $difunto->fechaDefun }}</td>
                    <td>{{ $difunto->fechaInhuma }}</td>
                    <td>Espacio #{{ $difunto->idEspacio }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="verDetalle({{ $difunto->id }})">Ver</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmarEliminar({{ $difunto->id }})">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function verDetalle(id) {
    window.location.href = '/cementerio/ver/' + id;
}

function confirmarEliminar(id) {
    if(confirm('¿Estás seguro de eliminar este registro?')) {
        window.location.href = '/cementerio/eliminar/' + id;
    }
}
</script>
@endsection