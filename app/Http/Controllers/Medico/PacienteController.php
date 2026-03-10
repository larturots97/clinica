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
  public function create()
{
    $medico = Auth::user()->medico ?? null;
    return view('medico.pacientes.create', compact('medico'));
}

public function store(Request $request)
{
    $request->validate([
        'nombre'           => 'required|string|max:100',
        'apellido_paterno' => 'required|string|max:100',
        'apellido_materno' => 'nullable|string|max:100',
        'fecha_nacimiento' => 'required|date',
        'sexo'             => 'required|in:M,F,O',
        'telefono'         => 'nullable|string|max:20',
        'email'            => 'nullable|email|max:100',
        'alergias'         => 'nullable|string',
        'antecedentes'     => 'nullable|string',
    ]);

    $paciente = Paciente::create([
        'clinica_id'       => Auth::user()->medico->clinica_id,
        'nombre'           => $request->nombre,
        'apellido_paterno' => $request->apellido_paterno,
        'apellido_materno' => $request->apellido_materno,
        'fecha_nacimiento' => $request->fecha_nacimiento,
        'sexo'             => $request->sexo,
        'telefono'         => $request->telefono,
        'email'            => $request->email,
        'alergias'         => $request->alergias,
        'antecedentes'     => $request->antecedentes,
        'expediente'       => 'EXP-' . strtoupper(uniqid()),
    ]);

    return redirect()->route('medico.pacientes.show', $paciente)
        ->with('success', 'Paciente registrado correctamente.');
}
public function edit(Paciente $paciente)
{
    $medico = Auth::user()->medico;
    return view('medico.pacientes.edit', compact('medico', 'paciente'));
}

public function update(Request $request, Paciente $paciente)
{
    $request->validate([
        'nombre'           => 'required|string|max:100',
        'apellido_paterno' => 'required|string|max:100',
        'apellido_materno' => 'nullable|string|max:100',
        'fecha_nacimiento' => 'required|date',
        'sexo'             => 'required|in:M,F,O',
        'telefono'         => 'nullable|string|max:20',
        'email'            => 'nullable|email|max:100',
        'alergias'         => 'nullable|string',
        'antecedentes'     => 'nullable|string',
    ]);

    $paciente->update($request->only([
        'nombre', 'apellido_paterno', 'apellido_materno',
        'fecha_nacimiento', 'sexo', 'telefono', 'email',
        'alergias', 'antecedentes',
    ]));

    return redirect()->route('medico.pacientes.show', $paciente)
        ->with('success', 'Paciente actualizado correctamente.');
}
}