<?php

use App\Http\Controllers\Medico\ConfiguracionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Medico\LandingConfigController;

// ── Landing pública ───────────────────────────────────────────────────────────
Route::get('/', [\App\Http\Controllers\LandingController::class, 'index'])->name('landing');
Route::post('/agendar', [\App\Http\Controllers\LandingController::class, 'agendar'])->name('landing.agendar');
Route::get('/horas-disponibles', [\App\Http\Controllers\LandingController::class, 'horasDisponibles'])->name('landing.horas');

// ── Servir archivos de storage sin symlink ────────────────────────────────────
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) abort(404);
    return response()->file($fullPath);
})->where('path', '.*');

// ── Panel Admin (solo rol admin) ──────────────────────────────────────────────
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:admin'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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
    Route::resource('estetica', \App\Http\Controllers\Medico\TratamientoEsteticoController::class);
});

// ── Panel del Médico (solo rol medico) ────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::prefix('medico')->name('medico.')->middleware('medico')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Medico\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/recetas', [\App\Http\Controllers\Medico\RecetaController::class, 'index'])->name('recetas.index');
        Route::get('/recetas/create', [\App\Http\Controllers\Medico\RecetaController::class, 'create'])->name('recetas.create');
        Route::post('/recetas', [\App\Http\Controllers\Medico\RecetaController::class, 'store'])->name('recetas.store');
        Route::get('/recetas/{receta}', [\App\Http\Controllers\Medico\RecetaController::class, 'show'])->name('recetas.show');
        Route::get('/recetas/{receta}/pdf', [\App\Http\Controllers\RecetaController::class, 'pdf'])->name('medico.recetas.pdf');

        Route::get('/agenda', [\App\Http\Controllers\Medico\AgendaController::class, 'index'])->name('agenda.index');
        Route::put('/agenda/{cita}', [\App\Http\Controllers\Medico\AgendaController::class, 'update'])->name('agenda.update');

        Route::get('/pacientes', [\App\Http\Controllers\Medico\PacienteController::class, 'index'])->name('pacientes.index');
        Route::get('/pacientes/create', [\App\Http\Controllers\Medico\PacienteController::class, 'create'])->name('pacientes.create');
        Route::post('/pacientes', [\App\Http\Controllers\Medico\PacienteController::class, 'store'])->name('pacientes.store');
        Route::get('/pacientes/{paciente}/edit', [\App\Http\Controllers\Medico\PacienteController::class, 'edit'])->name('pacientes.edit');
        Route::put('/pacientes/{paciente}', [\App\Http\Controllers\Medico\PacienteController::class, 'update'])->name('pacientes.update');
        Route::get('/pacientes/{paciente}', [\App\Http\Controllers\Medico\PacienteController::class, 'show'])->name('pacientes.show');

        Route::get('/historial', [\App\Http\Controllers\Medico\HistorialController::class, 'index'])->name('historial.index');
        Route::get('/historial/create', [\App\Http\Controllers\Medico\HistorialController::class, 'create'])->name('historial.create');
        Route::post('/historial', [\App\Http\Controllers\Medico\HistorialController::class, 'store'])->name('historial.store');
        Route::get('/historial/{historial}', [\App\Http\Controllers\Medico\HistorialController::class, 'show'])->name('historial.show');

        Route::get('/estetica/create', [\App\Http\Controllers\Medico\EsteticaController::class, 'create'])->name('estetica.create');
        Route::post('/estetica', [\App\Http\Controllers\Medico\EsteticaController::class, 'store'])->name('estetica.store');
        Route::get('/estetica/{tratamientoEstetico}', [\App\Http\Controllers\Medico\EsteticaController::class, 'show'])->name('estetica.show');

        Route::get('/inventario', [\App\Http\Controllers\Medico\InventarioController::class, 'index'])->name('inventario.index');
        Route::get('/inventario/create', [\App\Http\Controllers\Medico\InventarioController::class, 'create'])->name('inventario.create');
        Route::post('/inventario', [\App\Http\Controllers\Medico\InventarioController::class, 'store'])->name('inventario.store');
        Route::get('/inventario/{inventario}', [\App\Http\Controllers\Medico\InventarioController::class, 'show'])->name('inventario.show');
        Route::post('/inventario/{inventario}/movimiento', [\App\Http\Controllers\Medico\InventarioController::class, 'movimiento'])->name('inventario.movimiento');

        Route::get('/pagos', [\App\Http\Controllers\Medico\PagoController::class, 'index'])->name('pagos.index');
        Route::get('/pagos/create', [\App\Http\Controllers\Medico\PagoController::class, 'create'])->name('pagos.create');
        Route::post('/pagos', [\App\Http\Controllers\Medico\PagoController::class, 'store'])->name('pagos.store');
        Route::get('/pagos/{pago}', [\App\Http\Controllers\Medico\PagoController::class, 'show'])->name('pagos.show');
        Route::put('/pagos/{pago}', [\App\Http\Controllers\Medico\PagoController::class, 'update'])->name('pagos.update');
        Route::get('/pagos/{pago}/pdf', [\App\Http\Controllers\Medico\PagoController::class, 'pdf'])->name('pagos.pdf');
        Route::post('/pagos/{pago}/correo', [\App\Http\Controllers\Medico\PagoController::class, 'enviarCorreo'])->name('pagos.correo');
        Route::post('/perfil/logo', [\App\Http\Controllers\Medico\PagoController::class, 'subirLogo'])->name('perfil.logo');
        Route::post('/perfil/firma', [\App\Http\Controllers\Medico\PagoController::class, 'subirFirma'])->name('perfil.firma');

        Route::get('/tipo-tratamientos', [\App\Http\Controllers\Medico\TipoTratamientoController::class, 'index'])->name('tipo-tratamientos.index');
        Route::get('/tipo-tratamientos/create', [\App\Http\Controllers\Medico\TipoTratamientoController::class, 'create'])->name('tipo-tratamientos.create');
        Route::post('/tipo-tratamientos', [\App\Http\Controllers\Medico\TipoTratamientoController::class, 'store'])->name('tipo-tratamientos.store');
        Route::get('/tipo-tratamientos/{tipoTratamiento}/edit', [\App\Http\Controllers\Medico\TipoTratamientoController::class, 'edit'])->name('tipo-tratamientos.edit');
        Route::put('/tipo-tratamientos/{tipoTratamiento}', [\App\Http\Controllers\Medico\TipoTratamientoController::class, 'update'])->name('tipo-tratamientos.update');
        Route::delete('/tipo-tratamientos/{tipoTratamiento}', [\App\Http\Controllers\Medico\TipoTratamientoController::class, 'destroy'])->name('tipo-tratamientos.destroy');
        Route::post('/tipo-tratamientos/{tipoTratamiento}/toggle', [\App\Http\Controllers\Medico\TipoTratamientoController::class, 'toggleActivo'])->name('tipo-tratamientos.toggle');

        Route::get('/tratamientos-esteticos', [\App\Http\Controllers\Medico\TratamientoEsteticoController::class, 'index'])->name('tratamientos-esteticos.index');
        Route::get('/tratamientos-esteticos/create', [\App\Http\Controllers\Medico\TratamientoEsteticoController::class, 'create'])->name('tratamientos-esteticos.create');
        Route::post('/tratamientos-esteticos', [\App\Http\Controllers\Medico\TratamientoEsteticoController::class, 'store'])->name('tratamientos-esteticos.store');
        Route::get('/tratamientos-esteticos/paciente/{paciente}/datos', [\App\Http\Controllers\Medico\TratamientoEsteticoController::class, 'datosPaciente'])->name('tratamientos-esteticos.datos-paciente');
        Route::get('/tratamientos-esteticos/{tratamientosEstetico}', [\App\Http\Controllers\Medico\TratamientoEsteticoController::class, 'show'])->name('tratamientos-esteticos.show');
        Route::get('/tratamientos-esteticos/{tratamientosEstetico}/edit', [\App\Http\Controllers\Medico\TratamientoEsteticoController::class, 'edit'])->name('tratamientos-esteticos.edit');
        Route::get('/tratamientos-esteticos/{tratamientosEstetico}/pdf', [\App\Http\Controllers\Medico\TratamientoEsteticoController::class, 'pdf'])->name('tratamientos-esteticos.pdf');
        Route::get('/tratamientos-esteticos/{tratamientosEstetico}/consentimiento', [\App\Http\Controllers\Medico\TratamientoEsteticoController::class, 'consentimiento'])->name('tratamientos-esteticos.consentimiento');
        Route::post('/tratamientos-esteticos/{tratamientosEstetico}/firma-paciente', [\App\Http\Controllers\Medico\TratamientoEsteticoController::class, 'guardarFirmaPaciente'])->name('tratamientos-esteticos.firma-paciente');

        Route::get('/citas',           [\App\Http\Controllers\Medico\CitaMedicoController::class, 'index'])->name('citas.index');
        Route::get('/citas/create',    [\App\Http\Controllers\Medico\CitaMedicoController::class, 'create'])->name('citas.create');
        Route::post('/citas',          [\App\Http\Controllers\Medico\CitaMedicoController::class, 'store'])->name('citas.store');
        Route::get('/citas/{cita}',    [\App\Http\Controllers\Medico\CitaMedicoController::class, 'show'])->name('citas.show');
        Route::patch('/citas/{cita}',  [\App\Http\Controllers\Medico\CitaMedicoController::class, 'update'])->name('citas.update');
        Route::delete('/citas/{cita}', [\App\Http\Controllers\Medico\CitaMedicoController::class, 'destroy'])->name('citas.destroy');
        Route::post('/citas/{cita}/estado',  [\App\Http\Controllers\Medico\CitaMedicoController::class, 'cambiarEstado'])->name('citas.estado');
        Route::get('/citas/{cita}/whatsapp', [\App\Http\Controllers\Medico\CitaMedicoController::class, 'whatsapp'])->name('citas.whatsapp');

        Route::get('/configuraciones',          [ConfiguracionController::class, 'index'])          ->name('configuraciones.index');
        Route::post('/configuraciones',         [ConfiguracionController::class, 'update'])         ->name('configuraciones.update');
        Route::put('/configuraciones/datos',    [ConfiguracionController::class, 'updateDatos'])    ->name('configuraciones.datos');
        Route::put('/configuraciones/horarios', [ConfiguracionController::class, 'updateHorarios']) ->name('configuraciones.horarios');
        Route::put('/configuraciones/password', [ConfiguracionController::class, 'updatePassword']) ->name('configuraciones.password');
        Route::get('/configuraciones/slots',    [ConfiguracionController::class, 'slots'])          ->name('configuraciones.slots');
        Route::put('/configuraciones/receta',   [ConfiguracionController::class, 'updateReceta'])   ->name('configuraciones.receta');

        // Landing config
        Route::put('/configuraciones/landing/hero',                    [LandingConfigController::class, 'updateHero'])      ->name('configuraciones.landing.hero');
        Route::put('/configuraciones/landing/sobre',                   [LandingConfigController::class, 'updateSobre'])     ->name('configuraciones.landing.sobre');
        Route::put('/configuraciones/landing/contacto',                [LandingConfigController::class, 'updateContacto'])  ->name('configuraciones.landing.contacto');
        Route::post('/configuraciones/landing/servicios',              [LandingConfigController::class, 'storeServicio'])   ->name('configuraciones.landing.servicio.store');
        Route::post('/configuraciones/landing/servicios/iconos',         [LandingConfigController::class, 'updateIconos'])    ->name('configuraciones.landing.servicio.iconos');
        Route::post('/configuraciones/landing/servicios/iconos',         [LandingConfigController::class, 'updateIconos'])    ->name('configuraciones.landing.servicio.iconos');
        Route::delete('/configuraciones/landing/servicios/{servicio}', [LandingConfigController::class, 'destroyServicio']) ->name('configuraciones.landing.servicio.destroy');
        Route::post('/configuraciones/landing/galeria',                [LandingConfigController::class, 'storeGaleria'])    ->name('configuraciones.landing.galeria.store');
        Route::delete('/configuraciones/landing/galeria/{galeria}',    [LandingConfigController::class, 'destroyGaleria'])  ->name('configuraciones.landing.galeria.destroy');
    });
});

require __DIR__.'/auth.php';