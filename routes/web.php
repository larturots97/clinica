<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('pacientes', \App\Http\Controllers\PacienteController::class);
    Route::resource('medicos', \App\Http\Controllers\MedicoController::class);
    Route::resource('citas', \App\Http\Controllers\CitaController::class);
    Route::resource('historial', \App\Http\Controllers\HistorialController::class);
    Route::resource('recetas', \App\Http\Controllers\RecetaController::class);
    Route::get('recetas/{receta}/pdf', [\App\Http\Controllers\RecetaController::class, 'pdf'])->name('recetas.pdf');
    Route::resource('facturas', \App\Http\Controllers\FacturaController::class);
    Route::get('facturas/{factura}/pdf', [\App\Http\Controllers\FacturaController::class, 'pdf'])->name('facturas.pdf');
    Route::resource('inventario', \App\Http\Controllers\ProductoController::class);
    Route::post('inventario/{inventario}/movimiento', [\App\Http\Controllers\ProductoController::class, 'movimiento'])->name('inventario.movimiento');
    Route::resource('estetica', \App\Http\Controllers\TratamientoEsteticoController::class);

    // Panel del Médico
    Route::prefix('medico')->name('medico.')->middleware('medico')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Medico\DashboardController::class, 'index'])->name('dashboard');

        // Recetas
        Route::get('/recetas', [\App\Http\Controllers\Medico\RecetaController::class, 'index'])->name('recetas.index');
        Route::get('/recetas/create', [\App\Http\Controllers\Medico\RecetaController::class, 'create'])->name('recetas.create');
        Route::post('/recetas', [\App\Http\Controllers\Medico\RecetaController::class, 'store'])->name('recetas.store');
        Route::get('/recetas/{receta}', [\App\Http\Controllers\Medico\RecetaController::class, 'show'])->name('recetas.show');

        // Agenda
        Route::get('/agenda', [\App\Http\Controllers\Medico\AgendaController::class, 'index'])->name('agenda.index');
        Route::put('/agenda/{cita}', [\App\Http\Controllers\Medico\AgendaController::class, 'update'])->name('agenda.update');

        // Pacientes
        Route::get('/pacientes', [\App\Http\Controllers\Medico\PacienteController::class, 'index'])->name('pacientes.index');
        Route::get('/pacientes/{paciente}', [\App\Http\Controllers\Medico\PacienteController::class, 'show'])->name('pacientes.show');

        // Historial
        Route::get('/historial', [\App\Http\Controllers\Medico\HistorialController::class, 'index'])->name('historial.index');
        Route::get('/historial/create', [\App\Http\Controllers\Medico\HistorialController::class, 'create'])->name('historial.create');
        Route::post('/historial', [\App\Http\Controllers\Medico\HistorialController::class, 'store'])->name('historial.store');
        Route::get('/historial/{historial}', [\App\Http\Controllers\Medico\HistorialController::class, 'show'])->name('historial.show');

        // Estética vieja (solo ver)
        Route::get('/estetica/create', [\App\Http\Controllers\Medico\EsteticaController::class, 'create'])->name('estetica.create');
        Route::post('/estetica', [\App\Http\Controllers\Medico\EsteticaController::class, 'store'])->name('estetica.store');
        Route::get('/estetica/{tratamientoEstetico}', [\App\Http\Controllers\Medico\EsteticaController::class, 'show'])->name('estetica.show');

        // Inventario
        Route::get('/inventario', [\App\Http\Controllers\Medico\InventarioController::class, 'index'])->name('inventario.index');
        Route::get('/inventario/create', [\App\Http\Controllers\Medico\InventarioController::class, 'create'])->name('inventario.create');
        Route::post('/inventario', [\App\Http\Controllers\Medico\InventarioController::class, 'store'])->name('inventario.store');
        Route::get('/inventario/{inventario}', [\App\Http\Controllers\Medico\InventarioController::class, 'show'])->name('inventario.show');
        Route::post('/inventario/{inventario}/movimiento', [\App\Http\Controllers\Medico\InventarioController::class, 'movimiento'])->name('inventario.movimiento');

        // Pagos
        Route::get('/pagos', [\App\Http\Controllers\Medico\PagoController::class, 'index'])->name('pagos.index');
        Route::get('/pagos/create', [\App\Http\Controllers\Medico\PagoController::class, 'create'])->name('pagos.create');
        Route::post('/pagos', [\App\Http\Controllers\Medico\PagoController::class, 'store'])->name('pagos.store');
        Route::get('/pagos/{pago}', [\App\Http\Controllers\Medico\PagoController::class, 'show'])->name('pagos.show');
        Route::put('/pagos/{pago}', [\App\Http\Controllers\Medico\PagoController::class, 'update'])->name('pagos.update');
        Route::get('/pagos/{pago}/pdf', [\App\Http\Controllers\Medico\PagoController::class, 'pdf'])->name('pagos.pdf');
        Route::post('/pagos/{pago}/correo', [\App\Http\Controllers\Medico\PagoController::class, 'enviarCorreo'])->name('pagos.correo');
        Route::post('/perfil/logo', [\App\Http\Controllers\Medico\PagoController::class, 'subirLogo'])->name('perfil.logo');
        Route::post('/perfil/firma', [\App\Http\Controllers\Medico\PagoController::class, 'subirFirma'])->name('perfil.firma');

        // ── Tipos de Tratamiento (catálogo del médico) ──
        Route::get('/tipo-tratamientos', [\App\Http\Controllers\Medico\TipoTratamientoController::class, 'index'])->name('tipo-tratamientos.index');
        Route::get('/tipo-tratamientos/create', [\App\Http\Controllers\Medico\TipoTratamientoController::class, 'create'])->name('tipo-tratamientos.create');
        Route::post('/tipo-tratamientos', [\App\Http\Controllers\Medico\TipoTratamientoController::class, 'store'])->name('tipo-tratamientos.store');
        Route::get('/tipo-tratamientos/{tipoTratamiento}/edit', [\App\Http\Controllers\Medico\TipoTratamientoController::class, 'edit'])->name('tipo-tratamientos.edit');
        Route::put('/tipo-tratamientos/{tipoTratamiento}', [\App\Http\Controllers\Medico\TipoTratamientoController::class, 'update'])->name('tipo-tratamientos.update');
        Route::delete('/tipo-tratamientos/{tipoTratamiento}', [\App\Http\Controllers\Medico\TipoTratamientoController::class, 'destroy'])->name('tipo-tratamientos.destroy');
        Route::post('/tipo-tratamientos/{tipoTratamiento}/toggle', [\App\Http\Controllers\Medico\TipoTratamientoController::class, 'toggleActivo'])->name('tipo-tratamientos.toggle');

        // ── Historia Clínica Estética (nueva) ──
        Route::get('/tratamientos-esteticos', [\App\Http\Controllers\Medico\TratamientoEsteticoController::class, 'index'])->name('tratamientos-esteticos.index');
        Route::get('/tratamientos-esteticos/create', [\App\Http\Controllers\Medico\TratamientoEsteticoController::class, 'create'])->name('tratamientos-esteticos.create');
        Route::post('/tratamientos-esteticos', [\App\Http\Controllers\Medico\TratamientoEsteticoController::class, 'store'])->name('tratamientos-esteticos.store');
        Route::get('/tratamientos-esteticos/{tratamientosEstetico}', [\App\Http\Controllers\Medico\TratamientoEsteticoController::class, 'show'])->name('tratamientos-esteticos.show');
        Route::get('/tratamientos-esteticos/{tratamientosEstetico}/edit', [\App\Http\Controllers\Medico\TratamientoEsteticoController::class, 'edit'])->name('tratamientos-esteticos.edit');
        Route::get('/tratamientos-esteticos/{tratamientosEstetico}/pdf', [\App\Http\Controllers\Medico\TratamientoEsteticoController::class, 'pdf'])->name('tratamientos-esteticos.pdf');
    });
});

require __DIR__.'/auth.php';
