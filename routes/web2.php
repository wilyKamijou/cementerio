<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\Admin\EmpleadoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\InhumacionController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\CementeriosController;
use App\Http\Controllers\DimensionController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\CompromisoController;
use Illuminate\Support\Facades\Route;

// ========== RUTAS CON PERMISOS SEGÚN ROL ==========
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // ========== ADMINISTRADOR (Prioridad Primaria) ==========

    // Gestión de Usuarios - solo Administrador
    Route::resource('usuarios', UsuarioController::class)->middleware('permiso:ver_usuarios');

    // Gestión de Roles - solo Administrador
    Route::resource('roles', RolController::class)->middleware('permiso:ver_roles');
    Route::get('roles/{id}/permisos', [RolController::class, 'permisos'])->name('roles.permisos')->middleware('permiso:ver_roles');

    // Gestión de Empleados - solo Administrador
    Route::resource('empleados', EmpleadoController::class)->middleware('permiso:ver_empleados');

    // Gestión de Espacios Funerarios - solo Administrador
    Route::resource('espacios', EspacioController::class)->middleware('permiso:ver_espacios');

    // Gestión de Cementerio - solo Administrador
    Route::resource('cementerio', CementeriosController::class)->middleware('permiso:ver_cementerio');

    // Gestión de Dimensiones - solo Administrador
    Route::resource('dimensiones', DimensionController::class)->middleware('permiso:ver_dimensiones');

    // Gestión de Direcciones - solo Administrador
    Route::resource('direcciones', DireccionController::class)->middleware('permiso:ver_direcciones');

    // Reportes - solo Administrador
    Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index')->middleware('permiso:ver_reportes');
    Route::post('reportes/exportar', [ReporteController::class, 'exportar'])->name('reportes.exportar')->middleware('permiso:exportar_reportes');
    Route::post('reportes/enviar', [ReporteController::class, 'enviar'])->name('reportes.enviar')->middleware('permiso:enviar_reportes');

    // ========== CAJERO (Prioridad Primaria) ==========

    // Gestión de Clientes - solo Cajero y Administrador
    Route::resource('clientes', ClienteController::class)->middleware('permiso:ver_clientes');

    // Generar Contrato - solo Cajero y Administrador
    Route::resource('contratos', ContratoController::class)->middleware('permiso:crear_contrato');

    // Registrar Pago - solo Cajero y Administrador
    Route::resource('pagos', PagoController::class)->middleware('permiso:registrar_pago');

    // Generar Compromiso - solo Cajero y Administrador
    Route::resource('compromisos', CompromisoController::class)->middleware('permiso:crear_compromiso');

    // ========== OPERADOR (Prioridad Primaria/Secundaria) ==========

    // Registrar Inhumación - solo Operador y Administrador
    Route::resource('inhumaciones', InhumacionController::class)->middleware('permiso:crear_inhumacion');

    // Registrar Mantenimiento - solo Operador y Administrador
    Route::resource('mantenimientos', MantenimientoController::class)->middleware('permiso:crear_mantenimiento');
});

// ========== RUTAS PÚBLICAS / CLIENTE (Secundario) ==========

// Procesar pago en línea - Cliente (sin autenticación o con autenticación especial)
Route::post('pagos/procesar-en-linea', [PagoController::class, 'procesarEnLinea'])->name('pagos.procesar-en-linea');

// Consulta de estado del contrato - Cliente
Route::get('contratos/estado/{token}', [ContratoController::class, 'estado'])->name('contratos.estado');
