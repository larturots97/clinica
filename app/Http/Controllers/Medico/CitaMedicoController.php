<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\TipoTratamiento;
use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CitaMedicoController extends Controller
{
    protected function getMedico()
    {
        return Medico::where('user_id', Auth::id())->first();
    }

    public function index(Request $request)
    {
        $medico = $this->getMedico();
        $vista  = $request->get('vista', 'calendario');
        $mes    = $request->get('mes', now()->month);
        $anio   = $request->get('anio', now()->year);

        // Para FullCalendar (JSON) — usa rango start/end que envía FullCalendar
        if ($request->ajax() || $request->wantsJson() || $request->header('Accept') === 'application/json') {
            $start = $request->get('start', now()->startOfMonth());
            $end   = $request->get('end', now()->endOfMonth());

            $citas = Cita::with(['paciente', 'tipoTratamiento'])
                ->where('medico_id', $medico->id)
                ->whereBetween('fecha_hora', [$start, $end])
                ->orderBy('fecha_hora')
                ->get();

            $eventos = $citas->map(fn($c) => [
                'id'    => $c->id,
                'title' => $c->paciente?->nombre_completo ?? $c->nombre_visitante ?? 'Visitante',
                'start' => $c->fecha_hora->format('Y-m-d\TH:i:s'),
                'end'   => $c->fecha_hora->copy()->addMinutes($c->duracion_minutos ?? 30)->format('Y-m-d\TH:i:s'),
                'color' => $this->colorEstado($c->estado),
                'url'   => route('medico.citas.show', $c),
                'extendedProps' => [
                    'estado' => $c->estado,
                    'motivo' => $c->motivo,
                ],
            ]);

            return response()->json($eventos);
        }

        // Para la vista lista (Blade)
        $citas = Cita::with(['paciente', 'tipoTratamiento'])
            ->where('medico_id', $medico->id)
            ->whereYear('fecha_hora', $anio)
            ->whereMonth('fecha_hora', $mes)
            ->orderBy('fecha_hora')
            ->get();

        $estadisticas = [
            'hoy'        => Cita::where('medico_id', $medico->id)->whereDate('fecha_hora', today())->whereNotIn('estado', ['cancelada'])->count(),
            'semana'     => Cita::where('medico_id', $medico->id)->whereBetween('fecha_hora', [now()->startOfWeek(), now()->endOfWeek()])->whereNotIn('estado', ['cancelada'])->count(),
            'pendientes' => Cita::where('medico_id', $medico->id)->where('estado', 'pendiente')->count(),
        ];

        $pacientes        = Paciente::orderBy('nombre')->get();
        $tiposTratamiento = TipoTratamiento::orderBy('nombre')->get();

        return view('medico.citas.index', compact('citas', 'vista', 'mes', 'anio', 'pacientes', 'tiposTratamiento', 'estadisticas', 'medico'));
    }

    public function store(Request $request)
    {
        $medico = $this->getMedico();

        $request->validate([
            'paciente_id'         => 'required|exists:pacientes,id',
            'fecha_hora'          => 'required|date|after:now',
            'duracion_minutos'    => 'required|integer|min:15|max:240',
            'motivo'              => 'nullable|string|max:255',
            'notas'               => 'nullable|string',
            'tipo_tratamiento_id' => 'nullable|exists:tipo_tratamientos,id',
        ]);

        $paciente = Paciente::findOrFail($request->paciente_id);

        $cita = Cita::create([
            'clinica_id'          => $medico->clinica_id,
            'paciente_id'         => $request->paciente_id,
            'medico_id'           => $medico->id,
            'tipo_tratamiento_id' => $request->tipo_tratamiento_id,
            'fecha_hora'          => $request->fecha_hora,
            'duracion_minutos'    => $request->duracion_minutos,
            'motivo'              => $request->motivo,
            'notas'               => $request->notas,
            'estado'              => 'pendiente',
            'telefono_paciente'   => $paciente->telefono ?? null,
            'email_paciente'      => $paciente->email ?? null,
        ]);

        if ($cita->email_paciente) {
            $this->enviarCorreoConfirmacion($cita);
        }

        return response()->json(['success' => true, 'cita_id' => $cita->id]);
    }

    public function show(Cita $cita)
    {
        $cita->load(['paciente', 'medico', 'tipoTratamiento']);
        $medico = $this->getMedico();
        return view('medico.citas.show', compact('cita', 'medico'));
    }

    public function update(Request $request, Cita $cita)
    {
        $request->validate([
            'fecha_hora'          => 'sometimes|date',
            'duracion_minutos'    => 'sometimes|integer|min:15|max:240',
            'estado'              => 'sometimes|in:pendiente,confirmada,en_curso,completada,cancelada',
            'motivo'              => 'nullable|string|max:255',
            'notas'               => 'nullable|string',
            'tipo_tratamiento_id' => 'nullable|exists:tipo_tratamientos,id',
        ]);

        $cita->update($request->only(['fecha_hora', 'duracion_minutos', 'estado', 'motivo', 'notas', 'tipo_tratamiento_id']));

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Cita actualizada.');
    }

    public function destroy(Cita $cita)
    {
        $cita->delete();
        return response()->json(['success' => true]);
    }

    public function cambiarEstado(Request $request, Cita $cita)
    {
        $request->validate(['estado' => 'required|in:pendiente,confirmada,en_curso,completada,cancelada']);
        $cita->update(['estado' => $request->estado]);
        return response()->json(['success' => true, 'estado' => $cita->estado]);
    }

    public function whatsapp(Cita $cita)
    {
        $cita->load(['paciente', 'medico']);
        $fecha         = Carbon::parse($cita->fecha_hora)->locale('es')->isoFormat('dddd D [de] MMMM [a las] h:mm A');
        $clinicaNombre = $cita->medico->clinica->nombre ?? 'nuestra clínica';
        $mensaje       = "Hola {$cita->paciente->nombre}, le confirmamos su cita en *{$clinicaNombre}* para el *{$fecha}*. Motivo: {$cita->motivo}. Si necesita cancelar o reprogramar contáctenos. ¡Le esperamos!";
        $tel           = preg_replace('/[^0-9]/', '', $cita->telefono_paciente ?? $cita->paciente->telefono ?? '');
        $url           = 'https://wa.me/' . $tel . '?text=' . urlencode($mensaje);
        return response()->json(['url' => $url]);
    }

    protected function enviarCorreoConfirmacion(Cita $cita)
    {
        try {
            $cita->load(['paciente', 'medico']);
            Mail::send('emails.cita-confirmacion', ['cita' => $cita], function ($m) use ($cita) {
                $m->to($cita->email_paciente, $cita->paciente->nombre)
                  ->subject('Confirmación de cita — ' . Carbon::parse($cita->fecha_hora)->locale('es')->isoFormat('dddd D [de] MMMM'));
            });
        } catch (\Exception $e) {
            // No interrumpir el flujo si falla el correo
        }
    }

    protected function colorEstado(string $estado): string
    {
        return match($estado) {
            'pendiente'  => '#f59e0b',
            'confirmada' => '#10b981',
            'en_curso'   => '#6366f1',
            'completada' => '#64748b',
            'cancelada'  => '#ef4444',
            default      => '#94a3b8',
        };
    }
}