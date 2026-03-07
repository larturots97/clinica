<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\Clinica;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        $citas = Cita::with(['paciente', 'medico'])
            ->orderBy('fecha_hora', 'desc')
            ->paginate(15);
        return view('citas.index', compact('citas'));
    }

    public function create()
    {
        $pacientes = Paciente::orderBy('nombre')->get();
        $medicos   = Medico::where('activo', true)->orderBy('nombre')->get();
        return view('citas.create', compact('pacientes', 'medicos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id'     => 'required|exists:pacientes,id',
            'medico_id'       => 'required|exists:medicos,id',
            'fecha_hora'      => 'required|date',
            'duracion_minutos'=> 'required|integer|min:15|max:180',
            'motivo'          => 'nullable|string|max:255',
            'notas'           => 'nullable|string',
        ]);

        $clinica = Clinica::first();

        Cita::create([
            'clinica_id'       => $clinica->id,
            'paciente_id'      => $request->paciente_id,
            'medico_id'        => $request->medico_id,
            'fecha_hora'       => $request->fecha_hora,
            'duracion_minutos' => $request->duracion_minutos,
            'motivo'           => $request->motivo,
            'notas'            => $request->notas,
            'estado'           => 'pendiente',
        ]);

        return redirect()->route('citas.index')
            ->with('success', 'Cita agendada exitosamente.');
    }

    public function show(Cita $cita)
    {
        $cita->load(['paciente', 'medico.especialidad']);
        return view('citas.show', compact('cita'));
    }

    public function edit(Cita $cita)
    {
        $pacientes = Paciente::orderBy('nombre')->get();
        $medicos   = Medico::where('activo', true)->orderBy('nombre')->get();
        return view('citas.edit', compact('cita', 'pacientes', 'medicos'));
    }

    public function update(Request $request, Cita $cita)
    {
        $request->validate([
            'paciente_id'     => 'required|exists:pacientes,id',
            'medico_id'       => 'required|exists:medicos,id',
            'fecha_hora'      => 'required|date',
            'duracion_minutos'=> 'required|integer|min:15|max:180',
            'estado'          => 'required|in:pendiente,confirmada,en_curso,completada,cancelada',
            'motivo'          => 'nullable|string|max:255',
            'notas'           => 'nullable|string',
        ]);

        $cita->update($request->all());

        return redirect()->route('citas.show', $cita)
            ->with('success', 'Cita actualizada exitosamente.');
    }

    public function destroy(Cita $cita)
    {
        $cita->delete();
        return redirect()->route('citas.index')
            ->with('success', 'Cita eliminada exitosamente.');
    }
}