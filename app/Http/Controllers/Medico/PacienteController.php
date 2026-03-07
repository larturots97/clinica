<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        $medico = Auth::user()->medico;

        $query = Paciente::whereHas('citas', function($q) use ($medico) {
            $q->where('medico_id', $medico->id);
        })->orderBy('nombre');

        if ($request->buscar) {
            $query->where(function($q) use ($request) {
                $q->where('nombre', 'like', '%'.$request->buscar.'%')
                  ->orWhere('apellido_paterno', 'like', '%'.$request->buscar.'%')
                  ->orWhere('expediente', 'like', '%'.$request->buscar.'%');
            });
        }

        $pacientes = $query->paginate(15);

        return view('medico.pacientes', compact('medico', 'pacientes'));
    }

    public function show(Paciente $paciente)
    {
        $medico = Auth::user()->medico;

        $paciente->load([
            'historiales' => fn($q) => $q->where('medico_id', $medico->id)->orderBy('fecha', 'desc'),
            'recetas'     => fn($q) => $q->where('medico_id', $medico->id)->orderBy('fecha', 'desc'),
            'citas'       => fn($q) => $q->where('medico_id', $medico->id)->orderBy('fecha_hora', 'desc'),
        ]);

        $esMedicoEstetico = $medico->especialidad?->nombre === 'Medicina Estética';

        $tratamientos = [];
        if ($esMedicoEstetico) {
            $tratamientos = $paciente->tratamientosEsteticos()
                ->where('medico_id', $medico->id)
                ->orderBy('fecha', 'desc')
                ->with('zonas')
                ->get();
        }

        return view('medico.paciente-show', compact(
            'medico',
            'paciente',
            'esMedicoEstetico',
            'tratamientos'
        ));
    }
}