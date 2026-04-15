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
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_usuarios'])->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create')->middleware('permiso:crear_usuario');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store')->middleware('permiso:crear_usuario');
        Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');
        //Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit')->middleware('permiso:editar_usuario');
        Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update')->middleware('permiso:editar_usuario');
        Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy')->middleware('permiso:eliminar_usuario');
        //Route::post('/usuarios/{id}/asignar-rol', [UsuarioController::class, 'asignarRol'])->name('usuarios.asignar-rol')->middleware('permiso:asignar_rol');
    });

    // ========== MÓDULO ROLES (SOLO ADMINISTRADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_roles'])->group(function () {
        Route::get('/roles', [RolController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [RolController::class, 'create'])->name('roles.create')->middleware('permiso:crear_rol');
        Route::post('/roles', [RolController::class, 'store'])->name('roles.store')->middleware('permiso:crear_rol');
        Route::get('/roles/{id}/edit', [RolController::class, 'edit'])->name('roles.edit')->middleware('permiso:editar_rol');
        Route::put('/roles/{id}', [RolController::class, 'update'])->name('roles.update')->middleware('permiso:editar_rol');
        Route::delete('/roles/{id}', [RolController::class, 'destroy'])->name('roles.destroy')->middleware('permiso:eliminar_rol');
        Route::get('/roles/{id}/permisos', [RolController::class, 'permisos'])->name('roles.permisos')->middleware('permiso:asignar_permisos');
        Route::put('/roles/{id}/permisos', [RolController::class, 'asignarPermisos'])->name('roles.asignar-permisos')->middleware('permiso:asignar_permisos');
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
        Route::get('/empleados/create', [EmpleadoController::class, 'create'])->name('empleados.create')->middleware('permiso:crear_empleado');
        Route::post('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store')->middleware('permiso:crear_empleado');
        Route::get('/empleados/{id}', [EmpleadoController::class, 'show'])->name('empleados.show')->middleware('permiso:editar_empleado');
        Route::put('/empleados/{id}', [EmpleadoController::class, 'update'])->name('empleados.update')->middleware('permiso:editar_empleado');
        Route::delete('/empleados/{id}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy')->middleware('permiso:eliminar_empleado');
    });

    // ========== MÓDULO ESPACIOS (SOLO ADMINISTRADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_espacios'])->group(function () {
        Route::get('/espacios', [EspacioController::class, 'index'])->name('espacios.index');
        Route::get('/espacios/create', [EspacioController::class, 'create'])->name('espacios.create')->middleware('permiso:crear_espacio');
        Route::post('/espacios', [EspacioController::class, 'store'])->name('espacios.store')->middleware('permiso:crear_espacio');
        Route::get('/espacios/{id}/edit', [EspacioController::class, 'edit'])->name('espacios.edit')->middleware('permiso:editar_espacio');
        Route::put('/espacios/{id}', [EspacioController::class, 'update'])->name('espacios.update')->middleware('permiso:editar_espacio');
        Route::delete('/espacios/{id}', [EspacioController::class, 'destroy'])->name('espacios.destroy')->middleware('permiso:eliminar_espacio');
    });

    // ========== MÓDULO CLIENTES (ADMINISTRADOR Y CAJERO) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_clientes'])->group(function () {
        Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
        Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create')->middleware('permiso:crear_cliente');
        Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store')->middleware('permiso:crear_cliente');
        Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit')->middleware('permiso:editar_cliente');
        Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update')->middleware('permiso:editar_cliente');
        Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy')->middleware('permiso:eliminar_cliente');
    });

    // ========== MÓDULO CONTRATOS (ADMINISTRADOR Y CAJERO) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_contratos'])->group(function () {
        Route::get('/contratos', [ContratoController::class, 'index'])->name('contratos.index');
        Route::get('/contratos/create', [ContratoController::class, 'create'])->name('contratos.create')->middleware('permiso:crear_contrato');
        Route::post('/contratos', [ContratoController::class, 'store'])->name('contratos.store')->middleware('permiso:crear_contrato');
        Route::get('/contratos/{id}/edit', [ContratoController::class, 'edit'])->name('contratos.edit')->middleware('permiso:editar_contrato');
        Route::put('/contratos/{id}', [ContratoController::class, 'update'])->name('contratos.update')->middleware('permiso:editar_contrato');
        Route::delete('/contratos/{id}', [ContratoController::class, 'destroy'])->name('contratos.destroy')->middleware('permiso:eliminar_contrato');
    });

    // ========== MÓDULO PAGOS (ADMINISTRADOR Y CAJERO) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_pagos'])->group(function () {
        Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
        Route::get('/pagos/create', [PagoController::class, 'create'])->name('pagos.create')->middleware('permiso:crear_pago');
        Route::post('/pagos', [PagoController::class, 'store'])->name('pagos.store')->middleware('permiso:crear_pago');
        Route::get('/pagos/{id}/edit', [PagoController::class, 'edit'])->name('pagos.edit')->middleware('permiso:editar_pago');
        Route::put('/pagos/{id}', [PagoController::class, 'update'])->name('pagos.update')->middleware('permiso:editar_pago');
        Route::delete('/pagos/{id}', [PagoController::class, 'destroy'])->name('pagos.destroy')->middleware('permiso:eliminar_pago');
    });

    // ========== MÓDULO INHUMACIONES (ADMINISTRADOR Y OPERADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_inhumaciones'])->group(function () {
        Route::get('/inhumaciones', [InhumacionController::class, 'index'])->name('inhumaciones.index');
        Route::get('/inhumaciones/create', [InhumacionController::class, 'create'])->name('inhumaciones.create')->middleware('permiso:crear_inhumacion');
        Route::post('/inhumaciones', [InhumacionController::class, 'store'])->name('inhumaciones.store')->middleware('permiso:crear_inhumacion');
        Route::get('/inhumaciones/{id}/edit', [InhumacionController::class, 'edit'])->name('inhumaciones.edit')->middleware('permiso:editar_inhumacion');
        Route::put('/inhumaciones/{id}', [InhumacionController::class, 'update'])->name('inhumaciones.update')->middleware('permiso:editar_inhumacion');
        Route::delete('/inhumaciones/{id}', [InhumacionController::class, 'destroy'])->name('inhumaciones.destroy')->middleware('permiso:eliminar_inhumacion');
    });

    // ========== MÓDULO MANTENIMIENTO (ADMINISTRADOR Y OPERADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_mantenimientos'])->group(function () {
        Route::get('/mantenimientos', [MantenimientoController::class, 'index'])->name('mantenimientos.index');
        Route::get('/mantenimientos/create', [MantenimientoController::class, 'create'])->name('mantenimientos.create')->middleware('permiso:crear_mantenimiento');
        Route::post('/mantenimientos', [MantenimientoController::class, 'store'])->name('mantenimientos.store')->middleware('permiso:crear_mantenimiento');
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
        Route::get('/cementerios/create', [CementeriosController::class, 'create'])->name('cementerios.create')->middleware('permiso:crear_cementerio');
        Route::post('/cementerios', [CementeriosController::class, 'store'])->name('cementerios.store')->middleware('permiso:crear_cementerio');
        Route::get('/cementerios/{id}/edit', [CementeriosController::class, 'edit'])->name('cementerios.edit')->middleware('permiso:editar_cementerio');
        Route::put('/cementerios/{id}', [CementeriosController::class, 'update'])->name('cementerios.update')->middleware('permiso:editar_cementerio');
        Route::delete('/cementerios/{id}', [CementeriosController::class, 'destroy'])->name('cementerios.destroy')->middleware('permiso:eliminar_cementerio');
    });

    // ========== MÓDULO DIMENSIONES (SOLO ADMINISTRADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_dimensiones'])->group(function () {
        Route::get('/dimensiones', [DimensionController::class, 'index'])->name('dimensiones.index');
        Route::get('/dimensiones/create', [DimensionController::class, 'create'])->name('dimensiones.create')->middleware('permiso:crear_dimension');
        Route::post('/dimensiones', [DimensionController::class, 'store'])->name('dimensiones.store')->middleware('permiso:crear_dimension');
        Route::get('/dimensiones/{id}/edit', [DimensionController::class, 'edit'])->name('dimensiones.edit')->middleware('permiso:editar_dimension');
        Route::put('/dimensiones/{id}', [DimensionController::class, 'update'])->name('dimensiones.update')->middleware('permiso:editar_dimension');
        Route::delete('/dimensiones/{id}', [DimensionController::class, 'destroy'])->name('dimensiones.destroy')->middleware('permiso:eliminar_dimension');
    });

    // ========== MÓDULO DIRECCIONES (SOLO ADMINISTRADOR) ==========
    Route::prefix('admin')->name('admin.')->middleware(['permiso:ver_direcciones'])->group(function () {
        Route::get('/direcciones', [DireccionController::class, 'index'])->name('direcciones.index');
        Route::get('/direcciones/create', [DireccionController::class, 'create'])->name('direcciones.create')->middleware('permiso:crear_direccion');
        Route::post('/direcciones', [DireccionController::class, 'store'])->name('direcciones.store')->middleware('permiso:crear_direccion');
        Route::get('/direcciones/{id}/edit', [DireccionController::class, 'edit'])->name('direcciones.edit')->middleware('permiso:editar_direccion');
        Route::put('/direcciones/{id}', [DireccionController::class, 'update'])->name('direcciones.update')->middleware('permiso:editar_direccion');
        Route::delete('/direcciones/{id}', [DireccionController::class, 'destroy'])->name('direcciones.destroy')->middleware('permiso:eliminar_direccion');
    });
});
require __DIR__ . '/auth.php';
