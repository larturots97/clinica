<?php

namespace App\Http\Controllers;

use App\Models\LandingMedico;
use App\Models\LandingServicio;
use App\Models\LandingGaleria;
use App\Models\Medico;
use App\Models\Cita;
use App\Models\HorarioMedico;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $medico    = Medico::with(['especialidad'])->first();
        if (!$medico) abort(404, 'No hay médico configurado.');

        $landing   = LandingMedico::where('medico_id', $medico->id)->first();
        $servicios = LandingServicio::where('medico_id', $medico->id)->where('activo', true)->orderBy('orden')->get();
        $galeria   = LandingGaleria::where('medico_id', $medico->id)->orderBy('orden')->get();

        return view('landing.index', compact('medico', 'landing', 'servicios', 'galeria'));
    }

    /**
     * AJAX — devuelve las horas disponibles para una fecha dada
     * GET /horas-disponibles?fecha=2026-03-20
     */
    public function horasDisponibles(Request $request)
    {
        $fecha  = $request->fecha;
        $medico = Medico::first();

        if (!$fecha || !$medico) {
            return response()->json(['horas' => []]);
        }

        $diaSemana = \Carbon\Carbon::parse($fecha)->dayOfWeek; // 0=Dom, 1=Lun...

        // Obtener horario del médico para ese día
        $horario = HorarioMedico::where('medico_id', $medico->id)
            ->where('dia_semana', $diaSemana)
            ->where('activo', true)
            ->first();

        if (!$horario) {
            return response()->json(['horas' => [], 'mensaje' => 'El médico no atiende ese día.']);
        }

        // Generar slots cada 30 minutos entre hora_inicio y hora_fin
        $slots  = [];
        $inicio = \Carbon\Carbon::parse($fecha . ' ' . $horario->hora_inicio);
        $fin    = \Carbon\Carbon::parse($fecha . ' ' . $horario->hora_fin);
        $duracion = $medico->duracion_cita ?? 30;

        // Obtener citas ya agendadas ese día
        $citasOcupadas = Cita::where('medico_id', $medico->id)
            ->whereDate('fecha_hora', $fecha)
            ->whereNotIn('estado', ['cancelada'])
            ->pluck('fecha_hora')
            ->map(fn($fh) => \Carbon\Carbon::parse($fh)->format('H:i'))
            ->toArray();

        $current = $inicio->copy();
        while ($current->lt($fin)) {
            $hora = $current->format('H:i');
            $slots[] = [
                'hora'       => $hora,
                'label'      => $current->format('h:i A'),
                'disponible' => !in_array($hora, $citasOcupadas),
            ];
            $current->addMinutes($duracion);
        }

        return response()->json(['horas' => $slots]);
    }

    /**
     * Guardar cita desde landing
     * POST /agendar
     */
    public function agendar(Request $request)
    {
        
        $request->validate([
            'nombre'   => 'required|string|max:150',
            'telefono' => 'required|string|max:20',
            'email'    => 'nullable|email|max:150',
            'fecha'    => 'required|date|after_or_equal:today',
            'hora'     => 'required',
            'motivo'   => 'nullable|string|max:500',
        ], [
            'nombre.required'      => 'El nombre es requerido.',
            'telefono.required'    => 'El teléfono es requerido.',
            'fecha.required'       => 'La fecha es requerida.',
            'fecha.after_or_equal' => 'La fecha debe ser hoy o en el futuro.',
            'hora.required'        => 'La hora es requerida.',
        ]);

        $medico = Medico::first();

        // Verificar que la hora sigue disponible
        $fechaHora = $request->fecha . ' ' . $request->hora . ':00';
        $existe = Cita::where('medico_id', $medico->id)
            ->where('fecha_hora', $fechaHora)
            ->whereNotIn('estado', ['cancelada'])
            ->exists();

        if ($existe) {
            return back()->withInput()->with('cita_error', 'Ese horario ya fue reservado. Por favor elige otro.');
        }

        Cita::create([
            'medico_id'          => $medico->id,
            'clinica_id'         => $medico->clinica_id ?? 1,
            'paciente_id'        => null,
            'fecha_hora'         => $fechaHora,
            'duracion_minutos'   => $medico->duracion_cita ?? 30,
            'motivo'             => $request->motivo ?? 'Cita de valoración desde la landing.',
            'estado'             => 'pendiente',
            'origen'             => 'landing',
            'nombre_visitante'   => $request->nombre,
            'telefono_visitante' => $request->telefono,
            'email_visitante'    => $request->email,
            'motivo_visitante'   => $request->motivo,
            'fecha_cita'         => $request->fecha,
            'hora_cita'          => $request->hora,
        ]);

        return back()->with('cita_success', '¡Tu cita fue solicitada! Te contactaremos pronto por WhatsApp para confirmar.');
    }
}