<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\Historial;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistorialController extends Controller
{
    public function index(Request $request)
    {
        $medico = Auth::user()->medico;

        $query = Historial::where('medico_id', $medico->id)
            ->with('paciente')
            ->orderBy('fecha', 'desc');

        if ($request->buscar) {
            $query->where(function($q) use ($request) {
                $q->where('motivo_consulta', 'like', '%'.$request->buscar.'%')
                  ->orWhere('diagnostico', 'like', '%'.$request->buscar.'%')
                  ->orWhereHas('paciente', function($q2) use ($request) {
                      $q2->where('nombre', 'like', '%'.$request->buscar.'%')
                         ->orWhere('apellidos', 'like', '%'.$request->buscar.'%');
                  });
            });
        }

        $historiales = $query->paginate(15);

        return view('medico.historial.index', compact('medico', 'historiales'));
    }

    public function create(Request $request)
    {
        $medico    = Auth::user()->medico;
        $pacientes = Paciente::whereHas('citas', function($q) use ($medico) {
            $q->where('medico_id', $medico->id);
        })->orderBy('nombre')->get();

        $pacienteSeleccionado = $request->paciente_id
            ? Paciente::find($request->paciente_id)
            : null;

        return view('medico.historial.create', compact(
            'medico', 'pacientes', 'pacienteSeleccionado'
        ));
    }

    public function store(Request $request)
    {
        $medico = Auth::user()->medico;

        $request->validate([
            'paciente_id'      => 'required|exists:pacientes,id',
            'fecha'            => 'required|date',
            'motivo_consulta'  => 'required|string|max:500',
            'diagnostico'      => 'required|string|max:1000',
            'tratamiento'      => 'nullable|string|max:1000',
            'notas'            => 'nullable|string',
        ]);

        Historial::create([
            'clinica_id'      => $medico->clinica_id,
            'paciente_id'     => $request->paciente_id,
            'medico_id'       => $medico->id,
            'fecha'           => $request->fecha,
            'motivo_consulta' => $request->motivo_consulta,
            'diagnostico'     => $request->diagnostico,
            'tratamiento'     => $request->tratamiento,
            'notas'           => $request->notas,
        ]);

        return redirect()->route('medico.historial.index')
            ->with('success', 'Consulta registrada correctamente.');
    }

    public function show(Historial $historial)
    {
        $medico = Auth::user()->medico;

        if ($historial->medico_id !== $medico->id) {
            abort(403);
        }

        $historial->load('paciente');

        return view('medico.historial.show', compact('medico', 'historial'));
    }
}