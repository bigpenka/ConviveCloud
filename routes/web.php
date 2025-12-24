<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProtocoloController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocenteController;
/*
|--------------------------------------------------------------------------
| Rutas de Acceso Público
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login'); 
});

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Requieren Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Principal
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Gestión de Estudiantes
    Route::resource('estudiantes', EstudianteController::class);

    // --- SECCIÓN DE PROTOCOLOS ---
    
    // Ruta explícita para el formulario de creación (Para evitar el error "undefined method")
    Route::get('protocolos/create', [ProtocoloController::class, 'create'])->name('protocolos.create');
    
    // Ruta explícita para guardar
    Route::post('protocolos', [ProtocoloController::class, 'store'])->name('protocolos.store');

    // El resto de funciones automáticas (index, show, edit, update, destroy)
    Route::resource('protocolos', ProtocoloController::class)->except(['create', 'store']);

    // Vistas de Bitácora / Gestión de Hechos
    Route::get('/protocolos/vulneracion/{id}', [ProtocoloController::class, 'vulneracion'])->name('protocolos.vulneracion');
    Route::get('/protocolos/agresion-sexual/{id}', [ProtocoloController::class, 'agresionSexual'])->name('protocolos.agresion');

    // Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('docentes', DocenteController::class);
    Route::post('/protocolos/{id}/asignar-agresor', [App\Http\Controllers\ProtocoloController::class, 'asignarAgresor'])
     ->name('protocolos.asignar-agresor');
     Route::get('/api/buscar-personas', function (Illuminate\Http\Request $request) {
    $tipo = $request->query('tipo');
    if ($tipo === 'estudiante') {
        return DB::table('estudiantes')->select('id', 'nombre', 'apellido', 'rut')->get();
    }
    return DB::table('docentes')->select('id', 'nombre', 'apellido', 'rut')->get();
});
});

require __DIR__.'/auth.php';