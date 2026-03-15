<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\ConfiguracionMedico;
use App\Models\HorarioMedico;
use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ConfiguracionController extends Controller
{
    // ══ Vista principal ══
    public function index()
    {
        $medico = auth()->user()->medico;

        $config = ConfiguracionMedico::firstOrCreate(
            ['medico_id' => $medico->id],
            [
                'clinica_id'        => $medico->clinica_id ?? null,
                'clinica_nombre'    => $medico->clinica->nombre     ?? '',
                'clinica_direccion' => $medico->clinica->direccion  ?? '',
                'clinica_ciudad'    => $medico->clinica->ciudad     ?? '',
            ]
        );

        $horarios = HorarioMedico::where('medico_id', $medico->id)
                        ->orderBy('dia_semana')
                        ->get()
                        ->keyBy('dia_semana');

        return view('medico.configuraciones.index', compact('config', 'medico', 'horarios'));
    }

    // ══ Guardar datos clínica + logo + firma + consentimiento (tu lógica original) ══
    public function update(Request $request)
    {
        $medico = auth()->user()->medico;

        $request->validate([
            'clinica_nombre'    => 'nullable|string|max:255',
            'clinica_direccion' => 'nullable|string|max:255',
            'clinica_ciudad'    => 'nullable|string|max:255',
            'clinica_telefono'  => 'nullable|string|max:50',
            'clinica_email'     => 'nullable|email|max:255',
            'logo'              => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'firma'             => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        $config = ConfiguracionMedico::firstOrCreate(['medico_id' => $medico->id]);

        $data = $request->only([
            'clinica_nombre', 'clinica_direccion', 'clinica_ciudad',
            'clinica_telefono', 'clinica_email',
            'consentimiento_punto_1',  'consentimiento_punto_2',
            'consentimiento_punto_3',  'consentimiento_punto_4',
            'consentimiento_punto_5',  'consentimiento_punto_6',
            'consentimiento_punto_7',  'consentimiento_punto_8',
            'consentimiento_punto_9',  'consentimiento_punto_10',
            'consentimiento_punto_11', 'consentimiento_punto_12',
        ]);

        if ($request->hasFile('logo')) {
            if ($config->logo) Storage::disk('public')->delete($config->logo);
            $data['logo'] = $request->file('logo')->store('configuraciones', 'public');
        }

        if ($request->hasFile('firma')) {
            if ($config->firma) Storage::disk('public')->delete($config->firma);
            $data['firma'] = $request->file('firma')->store('configuraciones', 'public');
        }

        $config->update($data);

        return redirect()->route('medico.configuraciones.index')
            ->with('success', 'Configuración guardada correctamente.');
    }

    // ══ Guardar datos personales del médico ══
   public function updateDatos(Request $request)
{
    $medico = Auth::user()->medico;

    $request->validate([
        'nombre'          => 'required|string|max:100',
        'apellido_paterno'=> 'nullable|string|max:100',
        'apellido_materno'=> 'nullable|string|max:100',
        'telefono'        => 'nullable|string|max:20',
        'email'           => 'nullable|email|max:150',
        'cedula'          => 'nullable|string|max:50',
        'especialidad_id' => 'nullable|exists:especialidades,id',
        'duracion_cita'   => 'required|integer|min:15|max:180',
    ]);

    $medico->update([
        'nombre'           => $request->nombre,
        'apellido_paterno' => $request->apellido_paterno,
        'apellido_materno' => $request->apellido_materno,
        'telefono'         => $request->telefono,
        'cedula'           => $request->cedula,
        'especialidad_id'  => $request->especialidad_id,
        'duracion_cita'    => $request->duracion_cita,
    ]);

    if ($request->email) {
        Auth::user()->update(['email' => $request->email]);
    }

    return redirect()->route('medico.configuraciones.index', ['tab' => 'medico'])
        ->with('success', 'Datos actualizados correctamente.');
}

    // ══ Guardar horarios de trabajo ══
  public function updateHorarios(Request $request)
{
    $medico = Auth::user()->medico;

    HorarioMedico::where('medico_id', $medico->id)->delete();

    $diasActivos = array_map('strval', $request->input('dias', []));
    $horasInicio = $request->input('hora_inicio', []);
    $horasFin    = $request->input('hora_fin', []);

    foreach (range(0, 6) as $dia) {
        if (!in_array((string)$dia, $diasActivos)) continue;

        // Si no llegó hora (input disabled), usar valor por defecto
        $horaInicio = $horasInicio[$dia] ?? '09:00';
        $horaFin    = $horasFin[$dia]    ?? '18:00';

        HorarioMedico::create([
            'medico_id'   => $medico->id,
            'dia_semana'  => $dia,
            'hora_inicio' => $horaInicio,
            'hora_fin'    => $horaFin,
            'activo'      => true,
        ]);
    }

    return redirect()->route('medico.configuraciones.index', ['tab' => 'horario'])
        ->with('success', 'Horario actualizado correctamente.');
}

    // ══ API: slots disponibles para una fecha (llamado por AJAX) ══
    public function slots(Request $request)
    {
        $medico   = Auth::user()->medico;
        $fecha    = $request->input('fecha');
        $duracion = (int) $request->input('duracion', $medico->duracion_cita ?? 30);
        $citaId   = $request->input('cita_id');

        if (!$fecha || !strtotime($fecha)) {
            return response()->json(['slots' => [], 'error' => 'Fecha inválida']);
        }

        $carbon    = Carbon::parse($fecha);
        $diaSemana = (int) $carbon->dayOfWeek;

        $horario = HorarioMedico::where('medico_id', $medico->id)
                        ->where('dia_semana', $diaSemana)
                        ->where('activo', true)
                        ->first();

        if (!$horario) {
            return response()->json(['slots' => [], 'mensaje' => 'El médico no trabaja ese día']);
        }

        $inicio = Carbon::parse($fecha . ' ' . $horario->hora_inicio);
        $fin    = Carbon::parse($fecha . ' ' . $horario->hora_fin);
        $slots  = [];
        $cursor = $inicio->copy();

        while ($cursor->copy()->addMinutes($duracion)->lte($fin)) {
            $slots[] = $cursor->format('H:i');
            $cursor->addMinutes($duracion);
        }

        $citasOcupadas = Cita::where('medico_id', $medico->id)
            ->whereDate('fecha_hora', $fecha)
            ->whereNotIn('estado', ['cancelada'])
            ->when($citaId, fn($q) => $q->where('id', '!=', $citaId))
            ->get(['fecha_hora', 'duracion_minutos']);

        $slotsConEstado = array_map(function ($slot) use ($fecha, $citasOcupadas, $duracion) {
            $slotInicio = Carbon::parse($fecha . ' ' . $slot);
            $slotFin    = $slotInicio->copy()->addMinutes($duracion);
            $ocupado    = false;
            foreach ($citasOcupadas as $cita) {
                $citaInicio = Carbon::parse($cita->fecha_hora);
                $citaDur    = $cita->duracion_minutos ?? $duracion;
                $citaFin    = $citaInicio->copy()->addMinutes($citaDur);
                if ($slotInicio->lt($citaFin) && $slotFin->gt($citaInicio)) {
                    $ocupado = true;
                    break;
                }
            }
            return ['hora' => $slot, 'libre' => !$ocupado];
        }, $slots);

        return response()->json([
            'slots'   => $slotsConEstado,
            'dia'     => HorarioMedico::nombreDia($diaSemana),
            'horario' => $horario->hora_inicio . ' — ' . $horario->hora_fin,
        ]);
    }

    // ══ Cambiar contraseña ══
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_actual' => 'required',
            'password'        => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password_actual, $user->password)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual no es correcta.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
    // ══ Guardar configuración de receta ══
    public function updateReceta(Request $request)
    {
        $medico = Auth::user()->medico;

        $request->validate([
            'receta_direccion'  => 'nullable|string|max:255',
            'receta_instagram'  => 'nullable|string|max:100',
            'receta_facebook'   => 'nullable|string|max:100',
            'receta_whatsapp'   => 'nullable|string|max:30',
            'logo'              => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'receta_logo_fondo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        $config = \App\Models\ConfiguracionMedico::firstOrCreate(['medico_id' => $medico->id]);

        $data = $request->only(['receta_direccion', 'receta_instagram', 'receta_facebook', 'receta_whatsapp']);

        if ($request->hasFile('logo')) {
            if ($config->logo) \Illuminate\Support\Facades\Storage::disk('public')->delete($config->logo);
            $data['logo'] = $request->file('logo')->store('configuraciones', 'public');
        }

        if ($request->hasFile('receta_logo_fondo')) {
            if ($config->receta_logo_fondo) \Illuminate\Support\Facades\Storage::disk('public')->delete($config->receta_logo_fondo);
            $data['receta_logo_fondo'] = $request->file('receta_logo_fondo')->store('configuraciones', 'public');
        }

        $config->update($data);

        return redirect()->route('medico.configuraciones.index', ['tab' => 'receta'])
            ->with('success', 'Configuración de receta guardada correctamente.');
    }
}
