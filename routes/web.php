<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\SepultureroController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/sepulturero/web');
});
Route::get('/sepulturero/web', function () {return view('sepulturero.sepulturero-index');});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ========== RUTAS DEL CEMENTERIO ========== BETA
    // Dashboard
    Route::get('/cementerio/dashboard', [BaseController::class, 'dashboard'])->name('cementerio.dashboard');
    
    // Registro
    Route::get('/cementerio/registro', [BaseController::class, 'registro'])->name('cementerio.registro');
    Route::post('/cementerio/store', [BaseController::class, 'store'])->name('cementerio.store');
    Route::get('/cementerio/ver/{id}', [BaseController::class, 'ver'])->name('cementerio.ver');
    Route::delete('/cementerio/eliminar/{id}', [BaseController::class, 'eliminar'])->name('cementerio.eliminar');
    
    // Mapa
    Route::get('/cementerio/mapa', [BaseController::class, 'mapa'])->name('cementerio.mapa');
    
    // Consultas
    Route::get('/cementerio/consultas', [BaseController::class, 'consultas'])->name('cementerio.consultas');
    Route::get('/cementerio/buscar', [BaseController::class, 'buscar'])->name('cementerio.buscar');
    
    // Mantenimiento
    Route::get('/cementerio/mantenimiento', [BaseController::class, 'mantenimiento'])->name('cementerio.mantenimiento');
    Route::post('/cementerio/mantenimiento/store', [BaseController::class, 'storeMantenimiento'])->name('cementerio.mantenimiento.store');
    
    // Reportes
    Route::get('/cementerio/reportes', [BaseController::class, 'reportes'])->name('cementerio.reportes');

    //RUTAS BETA 2
    //pagina web

   
    
    // Dashboard
    Route::get('/sepulturero/dashboard', [SepultureroController::class, 'dashboard'])->name('sepulturero.dashboard');
    
    // Módulos
    Route::get('/sepulturero/contratos', [SepultureroController::class, 'contratos'])->name('sepulturero.contratos');
    Route::get('/sepulturero/inhumaciones', [SepultureroController::class, 'inhumaciones'])->name('sepulturero.inhumaciones');
    Route::get('/sepulturero/mantenimiento', [SepultureroController::class, 'mantenimiento'])->name('sepulturero.mantenimiento');
    Route::get('/sepulturero/ventas', [SepultureroController::class, 'ventas'])->name('sepulturero.ventas');
    Route::get('/sepulturero/clientes', [SepultureroController::class, 'clientes'])->name('sepulturero.clientes');
});

require __DIR__.'/auth.php';