<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Historial;
use App\Models\Receta;
use App\Models\TratamientoEstetico;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $medico = $user->medico;

        if (!$medico) {
            abort(403, 'No tienes un perfil de médico asignado.');
        }

        $citasHoy = Cita::where('medico_id', $medico->id)
            ->whereDate('fecha_hora', today())
            ->orderBy('fecha_hora')
            ->with('paciente')
            ->get();

        $citasProximas = Cita::where('medico_id', $medico->id)
            ->whereDate('fecha_hora', '>', today())
            ->orderBy('fecha_hora')
            ->with('paciente')
            ->take(5)
            ->get();

        $totalCitasMes = Cita::where('medico_id', $medico->id)
            ->whereMonth('fecha_hora', now()->month)
            ->count();

        $totalPacientesMes = Cita::where('medico_id', $medico->id)
            ->whereMonth('fecha_hora', now()->month)
            ->distinct('paciente_id')
            ->count('paciente_id');

        $totalRecetasMes = Receta::where('medico_id', $medico->id)
            ->whereMonth('fecha', now()->month)
            ->count();

        $totalTratamientosMes = 0;
        $esMedicoEstetico = $medico->especialidad?->nombre === 'Medicina Estética';

        if ($esMedicoEstetico) {
            $totalTratamientosMes = TratamientoEstetico::where('medico_id', $medico->id)
                ->whereMonth('fecha', now()->month)
                ->count();
        }

        return view('medico.dashboard', compact(
            'medico',
            'citasHoy',
            'citasProximas',
            'totalCitasMes',
            'totalPacientesMes',
            'totalRecetasMes',
            'totalTratamientosMes',
            'esMedicoEstetico'
        ));
    }
}