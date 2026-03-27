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
        $vista  = $request->get('vista', 'citas');

        $totalCitas = Paciente::whereHas('citas', function($q) use ($medico) {
            $q->where('medico_id', $medico->id);
        })->count();

        $totalTodos = Paciente::where('clinica_id', $medico->clinica_id)->count();

        $totalWeb = Cita::where('medico_id', $medico->id)
            ->where('origen', 'landing')
            ->whereNull('paciente_id')
            ->count();

        $citasWeb  = collect();
        $pacientes = collect();

        if ($vista === 'web') {
            $citasWeb = Cita::where('medico_id', $medico->id)
                ->where('origen', 'landing')
                ->whereNull('paciente_id')
                ->orderByDesc('created_at')
                ->get();
        } else {
            if ($vista === 'todos') {
                $query = Paciente::where('clinica_id', $medico->clinica_id)->orderBy('nombre');
            } else {
                $query = Paciente::whereHas('citas', function($q) use ($medico) {
                    $q->where('medico_id', $medico->id);
                })->orderBy('nombre');
            }

            if ($request->buscar) {
                $query->where(function($q) use ($request) {
                    $q->where('nombre', 'like', '%'.$request->buscar.'%')
                      ->orWhere('apellidos', 'like', '%'.$request->buscar.'%')
                      ->orWhere('numero_expediente', 'like', '%'.$request->buscar.'%');
                });
            }

            $pacientes = $query->paginate(15);
        }

        return view('medico.pacientes', compact(
            'medico', 'pacientes', 'citasWeb',
            'totalCitas', 'totalTodos', 'totalWeb'
        ));
    }

    public function show(Paciente $paciente)
    {
        $medico = Auth::user()->medico;

        $paciente->load([
            'historiales' => fn($q) => $q->where('medico_id', $medico->id)->orderBy('fecha', 'desc'),
            'recetas'     => fn($q) => $q->where('medico_id', $medico->id)->orderBy('fecha', 'desc'),
            'citas'       => fn($q) => $q->where('medico_id', $medico->id)->orderBy('fecha_hora', 'desc'),
        ]);

        $esMedicoEstetico = str_contains(
            strtolower($medico->especialidad?->nombre ?? ''),
            'estetica'
        );
        $tratamientos = [];

        if ($esMedicoEstetico) {
            $tratamientos = $paciente->tratamientosEsteticos()
                ->where('medico_id', $medico->id)
                ->orderBy('fecha', 'desc')
                ->with('zonas')
                ->get();
        }

        return view('medico.paciente-show', compact('medico', 'paciente', 'esMedicoEstetico', 'tratamientos'));
    }

    public function create(Request $request)
    {
        $medico   = Auth::user()->medico ?? null;
        $citaWeb  = null;

        // Si viene desde una cita web, pre-rellenar datos
        if ($request->desde_cita) {
            $citaWeb = Cita::where('id', $request->desde_cita)
                ->where('medico_id', $medico->id)
                ->where('origen', 'landing')
                ->first();
        }

        return view('medico.pacientes.create', compact('medico', 'citaWeb'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'             => 'required|string|max:100',
            'apellido_paterno'   => 'required|string|max:100',
            'apellido_materno'   => 'nullable|string|max:100',
            'fecha_nacimiento'   => 'required|date',
            'sexo'               => 'required|in:M,F,O',
            'telefono'           => 'nullable|string|max:20',
            'email'              => 'nullable|email|max:100',
            'alergias'           => 'nullable|string',
            'antecedentes'       => 'nullable|string',
            'antecedentes_extra' => 'nullable|array',
            'direccion'          => 'nullable|string|max:255',
            'ocupacion'          => 'nullable|string|max:100',
            'fitzpatrick'        => 'nullable|integer|min:1|max:6',
            'tipo_piel'          => 'nullable|array',
            'condiciones_piel'   => 'nullable|array',
            'nota_medica'        => 'nullable|string',
            'tipo_sangre' => 'nullable|string|max:5',

        ]);

        $apellidos = trim($request->apellido_paterno . ' ' . $request->apellido_materno);

        $paciente = Paciente::create([
            'clinica_id'         => Auth::user()->medico->clinica_id,
            'numero_expediente'  => 'EXP-' . strtoupper(uniqid()),
            'nombre'             => $request->nombre,
            'apellidos'          => $apellidos,
            'fecha_nacimiento'   => $request->fecha_nacimiento,
            'genero'             => match($request->sexo) {
                'M' => 'masculino', 'F' => 'femenino', default => 'otro'
            },
            'telefono'           => $request->telefono,
            'email'              => $request->email,
            'alergias'           => $request->alergias,
            'antecedentes'       => $request->antecedentes,
            'direccion'          => $request->direccion,
            'ocupacion'          => $request->ocupacion,
            'fitzpatrick'        => $request->fitzpatrick,
            'tipo_piel'          => $request->tipo_piel ?? [],
            'condiciones_piel'   => $request->condiciones_piel ?? [],
            'antecedentes_extra' => $request->antecedentes_extra ?? [],
            'nota_medica'        => $request->nota_medica,
            'tipo_sangre' => $request->tipo_sangre,
        ]);

        // Si viene de una cita web, vincular la cita al nuevo paciente
        if ($request->cita_web_id) {
            Cita::where('id', $request->cita_web_id)
                ->where('origen', 'landing')
                ->update(['paciente_id' => $paciente->id]);
        }

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
            'fitzpatrick'      => 'nullable|integer|min:1|max:6',
            'tipo_piel'        => 'nullable|array',
            'condiciones_piel' => 'nullable|array',
            'nota_medica'      => 'nullable|string',
            'direccion'        => 'nullable|string|max:255',
            'ocupacion'        => 'nullable|string|max:100',
            'tipo_sangre' => 'nullable|string|max:5',
        ]);

        $apellidos = trim($request->apellido_paterno . ' ' . $request->apellido_materno);

        $paciente->update([
            'nombre'           => $request->nombre,
            'apellidos'        => $apellidos,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero'           => match($request->sexo) {
                'M' => 'masculino', 'F' => 'femenino', default => 'otro'
            },
            'telefono'         => $request->telefono,
            'email'            => $request->email,
            'alergias'         => $request->alergias,
            'antecedentes'     => $request->antecedentes,
            'fitzpatrick'      => $request->fitzpatrick,
            'tipo_piel'        => $request->tipo_piel ?? [],
            'condiciones_piel' => $request->condiciones_piel ?? [],
            'nota_medica'      => $request->nota_medica,
            'direccion'        => $request->direccion,
            'ocupacion'        => $request->ocupacion,
            'tipo_sangre' => $request->tipo_sangre,
        ]);

        return redirect()->route('medico.pacientes.show', $paciente)
            ->with('success', 'Paciente actualizado correctamente.');
    }
}