<?php


use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\Admin\EmpleadoController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\InhumacionController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\CementeriosController;
use App\Http\Controllers\DimensionController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\CompromisoController;
use App\Http\Controllers\SepultureroController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TipoInhumacionController;
use Illuminate\Support\Facades\Route;

// ========== RUTAS PÚBLICAS ==========
Route::get('/', function () {
    return redirect('/sepulturero/web');
});

Route::get('/sepulturero/web', function () {
    return view('sepulturero.sepulturero-index');
});

// ========== RUTAS CLIENTE (PÚBLICAS CON PERMISO) ==========
Route::post('/pagos/procesar', [PagoController::class, 'procesarEnLinea'])->name('pagos.procesar')->middleware('permiso:procesar_pago_online');
Route::get('/contratos/estado/{token}', [ContratoController::class, 'estado'])->name('contratos.estado')->middleware('permiso:consultar_contrato');

// ========== RUTAS PROTEGIDAS (REQUIEREN AUTENTICACIÓN) ==========
Route::middleware(['auth'])->group(function () {

    // ========== DASHBOARD ==========
    Route::get('/sepulturero/dashboard', [SepultureroController::class, 'dashboard'])->name('sepulturero.dashboard');

    // ========== MÓDULO USUARIOS (SOLO ADMINISTRADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso.any:ver_usuarios,ver_empleados,ver_roles,ver_permisos,ver_roles_permisos'])->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');
        //Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit')->middleware('permiso:editar_usuario');
        Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
        //Route::post('/usuarios/{id}/asignar-rol', [UsuarioController::class, 'asignarRol'])->name('usuarios.asignar-rol')->middleware('permiso:asignar_rol');
    });

    // ========== MÓDULO ROLES (SOLO ADMINISTRADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_roles'])->group(function () {
        Route::get('/roles', [RolController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [RolController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RolController::class, 'store'])->name('roles.store');
        Route::get('/roles/{id}/edit', [RolController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{id}', [RolController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{id}', [RolController::class, 'destroy'])->name('roles.destroy');
        Route::get('/roles/{id}/permisos', [RolController::class, 'permisos'])->name('roles.permisos');
        Route::put('/roles/{id}/permisos', [RolController::class, 'asignarPermisos'])->name('roles.asignar-permisos');
    });

    // ========== MÓDULO PERMISOS (SOLO ADMINISTRADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_permisos'])->group(function () {
        Route::get('/permisos', [PermisoController::class, 'index'])->name('permisos.index');
        Route::get('/permisos/create', [PermisoController::class, 'create'])->name('permisos.create');
        Route::post('/permisos', [PermisoController::class, 'store'])->name('permisos.store');
        Route::get('/permisos/{id}/edit', [PermisoController::class, 'edit'])->name('permisos.edit');
        Route::put('/permisos/{id}', [PermisoController::class, 'update'])->name('permisos.update');
        Route::delete('/permisos/{id}', [PermisoController::class, 'destroy'])->name('permisos.destroy');
    });

    // ========== MÓDULO EMPLEADOS (SOLO ADMINISTRADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_empleados'])->group(function () {
        Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index');
        Route::get('/empleados/create', [EmpleadoController::class, 'create'])->name('empleados.create');
        Route::post('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store');
        Route::get('/empleados/{id}', [EmpleadoController::class, 'show'])->name('empleados.show');
        Route::put('/empleados/{id}', [EmpleadoController::class, 'update'])->name('empleados.update');
        Route::delete('/empleados/{id}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy');
    });

    // ========== MÓDULO ESPACIOS (SOLO ADMINISTRADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso.any:ver_espacios,ver_cementerios,ver_dimensiones,ver_direcciones'])->group(function () {
        Route::get('/espacios', [EspacioController::class, 'index'])->name('espacios.index');
        Route::get('/espacios/create', [EspacioController::class, 'create'])->name('espacios.create');
        Route::post('/espacios', [EspacioController::class, 'store'])->name('espacios.store');
        Route::get('/espacios/{id}', [EspacioController::class, 'show'])->name('espacios.show');
        Route::put('/espacios/{id}', [EspacioController::class, 'update'])->name('espacios.update');
        Route::delete('/espacios/{id}', [EspacioController::class, 'destroy'])->name('espacios.destroy');
    });

    // ========== MÓDULO CLIENTES (ADMINISTRADOR Y CAJERO) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_clientes'])->group(function () {
        Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
        Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
        Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
        Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
        Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
        Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
    });

    // ========== MÓDULO CONTRATOS (ADMINISTRADOR Y CAJERO) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_contratos'])->group(function () {
        Route::get('/contratos', [ContratoController::class, 'index'])->name('contratos.index');
        Route::get('/contratos/create', [ContratoController::class, 'create'])->name('contratos.create');
        Route::post('/contratos', [ContratoController::class, 'store'])->name('contratos.store');
        Route::get('/contratos/{id}/edit', [ContratoController::class, 'edit'])->name('contratos.edit');
        Route::put('/contratos/{id}', [ContratoController::class, 'update'])->name('contratos.update');
        Route::delete('/contratos/{id}', [ContratoController::class, 'destroy'])->name('contratos.destroy');
    });

    // ========== MÓDULO PAGOS (ADMINISTRADOR Y CAJERO) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_pagos'])->group(function () {
        Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
        Route::get('/pagos/create', [PagoController::class, 'create'])->name('pagos.create');
        Route::post('/pagos', [PagoController::class, 'store'])->name('pagos.store');
        Route::get('/pagos/{id}/edit', [PagoController::class, 'edit'])->name('pagos.edit');
        Route::put('/pagos/{id}', [PagoController::class, 'update'])->name('pagos.update');
        Route::delete('/pagos/{id}', [PagoController::class, 'destroy'])->name('pagos.destroy');
    });

    // ========== MÓDULO INHUMACIONES (ADMINISTRADOR Y OPERADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_inhumaciones'])->group(function () {
        Route::get('/inhumaciones', [InhumacionController::class, 'index'])->name('inhumaciones.index');
        Route::get('/inhumaciones/create', [InhumacionController::class, 'create'])->name('inhumaciones.create');
        Route::post('/inhumaciones', [InhumacionController::class, 'store'])->name('inhumaciones.store');
        Route::get('/inhumaciones/{id}', [InhumacionController::class, 'show'])->name('inhumaciones.show');
        Route::put('/inhumaciones/{id}', [InhumacionController::class, 'update'])->name('inhumaciones.update');
        Route::delete('/inhumaciones/{id}', [InhumacionController::class, 'destroy'])->name('inhumaciones.destroy');
    });

    // ========== MÓDULO MANTENIMIENTO (ADMINISTRADOR Y OPERADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_mantenimientos'])->group(function () {
        Route::get('/mantenimientos', [MantenimientoController::class, 'index'])->name('mantenimientos.index');
        Route::get('/mantenimientos/create', [MantenimientoController::class, 'create'])->name('mantenimientos.create');
        Route::post('/mantenimientos', [MantenimientoController::class, 'store'])->name('mantenimientos.store');
        Route::get('/mantenimientos/{id}', [MantenimientoController::class, 'show'])->name('mantenimientos.show');
        Route::put('/mantenimientos/{id}', [MantenimientoController::class, 'update'])->name('mantenimientos.update');
        Route::delete('/mantenimientos/{id}', [MantenimientoController::class, 'destroy'])->name('mantenimientos.destroy');
    });

    // ========== MÓDULO REPORTES (ADMINISTRADOR Y CAJERO) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_reportes'])->group(function () {
        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::post('/reportes/exportar', [ReporteController::class, 'exportar'])->name('reportes.exportar')->middleware('permiso:exportar_reportes');
        Route::post('/reportes/enviar', [ReporteController::class, 'enviar'])->name('reportes.enviar')->middleware('permiso:enviar_reportes');
    });

    // ========== MÓDULO COMPROMISOS (CAJERO Y ADMINISTRADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_compromisos'])->group(function () {
        Route::get('/compromisos', [CompromisoController::class, 'index'])->name('compromisos.index');
        Route::get('/compromisos/create', [CompromisoController::class, 'create'])->name('compromisos.create')->middleware('permiso:crear_compromiso');
        Route::post('/compromisos', [CompromisoController::class, 'store'])->name('compromisos.store')->middleware('permiso:crear_compromiso');
    });

    // ========== MÓDULO CEMENTERIOS (SOLO ADMINISTRADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_cementerios'])->group(function () {
        Route::get('/cementerios', [CementeriosController::class, 'index'])->name('cementerios.index');
        Route::get('/cementerios/create', [CementeriosController::class, 'create'])->name('cementerios.create');
        Route::post('/cementerios', [CementeriosController::class, 'store'])->name('cementerios.store');
        Route::get('/cementerios/{id}', [CementeriosController::class, 'show'])->name('cementerios.show');
        Route::put('/cementerios/{id}', [CementeriosController::class, 'update'])->name('cementerios.update');
        Route::delete('/cementerios/{id}', [CementeriosController::class, 'destroy'])->name('cementerios.destroy');
    });

    // ========== MÓDULO DIMENSIONES (SOLO ADMINISTRADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_dimensiones'])->group(function () {
        Route::get('/dimensiones', [DimensionController::class, 'index'])->name('dimensiones.index');
        Route::get('/dimensiones/create', [DimensionController::class, 'create'])->name('dimensiones.create');
        Route::post('/dimensiones', [DimensionController::class, 'store'])->name('dimensiones.store');
        Route::get('/dimensiones/{id}', [DimensionController::class, 'show'])->name('dimensiones.show');
        Route::put('/dimensiones/{id}', [DimensionController::class, 'update'])->name('dimensiones.update');
        Route::delete('/dimensiones/{id}', [DimensionController::class, 'destroy'])->name('dimensiones.destroy');
    });

    // ========== MÓDULO DIRECCIONES (SOLO ADMINISTRADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_direcciones'])->group(function () {
        Route::get('/direcciones', [DireccionController::class, 'index'])->name('direcciones.index');
        Route::get('/direcciones/create', [DireccionController::class, 'create'])->name('direcciones.create');
        Route::post('/direcciones', [DireccionController::class, 'store'])->name('direcciones.store');
        Route::get('/direcciones/{id}', [DireccionController::class, 'show'])->name('direcciones.show');
        Route::put('/direcciones/{id}', [DireccionController::class, 'update'])->name('direcciones.update');
        Route::delete('/direcciones/{id}', [DireccionController::class, 'destroy'])->name('direcciones.destroy');
    });

    // ========== MÓDULO DIRECCIONES (SOLO ADMINISTRADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_tipo_inhumaciones'])->group(function () {
        Route::get('/tipo_inhumaciones', [TipoInhumacionController::class, 'index'])->name('tipo_inhumaciones.index');
        Route::get('/tipo_inhumaciones/create', [TipoInhumacionController::class, 'create'])->name('tipo_inhumaciones.create');
        Route::post('/tipo_inhumaciones', [TipoInhumacionController::class, 'store'])->name('tipo_inhumaciones.store');
        Route::get('/tipo_inhumaciones/{id}', [TipoInhumacionController::class, 'show'])->name('tipo_inhumaciones.show');
        Route::put('/tipo_inhumaciones/{id}', [TipoInhumacionController::class, 'update'])->name('tipo_inhumaciones.update');
        Route::delete('/tipo_inhumaciones/{id}', [TipoInhumacionController::class, 'destroy'])->name('tipo_inhumaciones.destroy');
    });
});
require __DIR__ . '/auth.php';
