<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $medico = Auth::user()->medico;

        if (!$medico) {
            abort(403);
        }

        $semana = $request->get('semana', now()->startOfWeek()->format('Y-m-d'));
        $inicio = \Carbon\Carbon::parse($semana)->startOfWeek();
        $fin    = $inicio->copy()->endOfWeek();

        $citas = Cita::where('medico_id', $medico->id)
            ->whereBetween('fecha_hora', [$inicio, $fin->endOfDay()])
            ->orderBy('fecha_hora')
            ->with('paciente')
            ->get();

        $semanaAnterior = $inicio->copy()->subWeek()->format('Y-m-d');
        $semanaSiguiente = $inicio->copy()->addWeek()->format('Y-m-d');

        return view('medico.agenda', compact(
            'medico',
            'citas',
            'inicio',
            'fin',
            'semanaAnterior',
            'semanaSiguiente'
        ));
    }

    public function update(Request $request, Cita $cita)
    {
        $medico = Auth::user()->medico;

        if ($cita->medico_id !== $medico->id) {
            abort(403);
        }

        $request->validate([
            'estado' => 'required|in:pendiente,confirmada,en_curso,completada,cancelada',
        ]);

        $cita->update(['estado' => $request->estado]);

        return redirect()->route('medico.agenda.index')
            ->with('success', 'Estado de cita actualizado.');
    }
}