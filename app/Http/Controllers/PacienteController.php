<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Clinica;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::orderBy('nombre')->paginate(15);
        return view('pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono'  => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'genero'    => 'nullable|in:masculino,femenino,otro',
            'tipo_sangre' => 'nullable|string|max:5',
            'alergias'  => 'nullable|string',
            'antecedentes' => 'nullable|string',
        ]);

        $clinica = Clinica::first();

        $paciente = Paciente::create([
            'clinica_id'        => $clinica->id,
            'numero_expediente' => 'EXP-' . str_pad(Paciente::count() + 1, 5, '0', STR_PAD_LEFT),
            'nombre'            => $request->nombre,
            'apellidos'         => $request->apellidos,
            'telefono'          => $request->telefono,
            'email'             => $request->email,
            'fecha_nacimiento'  => $request->fecha_nacimiento,
            'genero'            => $request->genero,
            'tipo_sangre'       => $request->tipo_sangre,
            'alergias'          => $request->alergias,
            'antecedentes'      => $request->antecedentes,
        ]);

        return redirect()->route('pacientes.show', $paciente)
            ->with('success', 'Paciente registrado exitosamente.');
    }

    public function show(Paciente $paciente)
    {
        return view('pacientes.show', compact('paciente'));
    }

    public function edit(Paciente $paciente)
    {
        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono'  => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'genero'    => 'nullable|in:masculino,femenino,otro',
            'tipo_sangre' => 'nullable|string|max:5',
            'alergias'  => 'nullable|string',
            'antecedentes' => 'nullable|string',
        ]);

        $paciente->update($request->all());

        return redirect()->route('pacientes.show', $paciente)
            ->with('success', 'Paciente actualizado exitosamente.');
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente eliminado exitosamente.');
    }
}