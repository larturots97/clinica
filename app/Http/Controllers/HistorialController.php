<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\Clinica;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function index()
    {
        $historiales = Historial::with(['paciente', 'medico'])
            ->orderBy('fecha', 'desc')
            ->paginate(15);
        return view('historial.index', compact('historiales'));
    }

    public function create()
    {
        $pacientes = Paciente::orderBy('nombre')->get();
        $medicos   = Medico::where('activo', true)->orderBy('nombre')->get();
        return view('historial.create', compact('pacientes', 'medicos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id'      => 'required|exists:pacientes,id',
            'medico_id'        => 'required|exists:medicos,id',
            'fecha'            => 'required|date',
            'motivo_consulta'  => 'required|string|max:255',
            'diagnostico'      => 'required|string',
            'sintomas'         => 'nullable|string',
            'exploracion_fisica' => 'nullable|string',
            'tratamiento'      => 'nullable|string',
            'observaciones'    => 'nullable|string',
            'peso'             => 'nullable|numeric',
            'talla'            => 'nullable|numeric',
            'presion_sistolica'  => 'nullable|integer',
            'presion_diastolica' => 'nullable|integer',
            'frecuencia_cardiaca' => 'nullable|integer',
            'temperatura'      => 'nullable|numeric',
        ]);

        $clinica = Clinica::first();

        Historial::create([
            'clinica_id'         => $clinica->id,
            'paciente_id'        => $request->paciente_id,
            'medico_id'          => $request->medico_id,
            'cita_id'            => $request->cita_id,
            'fecha'              => $request->fecha,
            'motivo_consulta'    => $request->motivo_consulta,
            'sintomas'           => $request->sintomas,
            'exploracion_fisica' => $request->exploracion_fisica,
            'diagnostico'        => $request->diagnostico,
            'tratamiento'        => $request->tratamiento,
            'observaciones'      => $request->observaciones,
            'peso'               => $request->peso,
            'talla'              => $request->talla,
            'presion_sistolica'  => $request->presion_sistolica,
            'presion_diastolica' => $request->presion_diastolica,
            'frecuencia_cardiaca'=> $request->frecuencia_cardiaca,
            'temperatura'        => $request->temperatura,
        ]);

        return redirect()->route('historial.index')
            ->with('success', 'Consulta registrada exitosamente.');
    }

    public function show(Historial $historial)
    {
        $historial->load(['paciente', 'medico', 'cita']);
        return view('historial.show', compact('historial'));
    }

    public function edit(Historial $historial)
    {
        $pacientes = Paciente::orderBy('nombre')->get();
        $medicos   = Medico::where('activo', true)->orderBy('nombre')->get();
        return view('historial.edit', compact('historial', 'pacientes', 'medicos'));
    }

    public function update(Request $request, Historial $historial)
    {
        $request->validate([
            'paciente_id'      => 'required|exists:pacientes,id',
            'medico_id'        => 'required|exists:medicos,id',
            'fecha'            => 'required|date',
            'motivo_consulta'  => 'required|string|max:255',
            'diagnostico'      => 'required|string',
        ]);

        $historial->update($request->all());

        return redirect()->route('historial.show', $historial)
            ->with('success', 'Consulta actualizada exitosamente.');
    }

    public function destroy(Historial $historial)
    {
        $historial->delete();
        return redirect()->route('historial.index')
            ->with('success', 'Consulta eliminada exitosamente.');
    }
}