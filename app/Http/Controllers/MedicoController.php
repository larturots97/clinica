<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Especialidad;
use App\Models\Clinica;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MedicoController extends Controller
{
    public function index()
    {
        $medicos = Medico::with(['especialidad', 'user'])->orderBy('nombre')->paginate(15);
        return view('medicos.index', compact('medicos'));
    }

    public function create()
    {
        $especialidades = Especialidad::where('activo', true)->orderBy('nombre')->get();
        return view('medicos.create', compact('especialidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'            => 'required|string|max:255',
            'apellidos'         => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'cedula_profesional'=> 'nullable|string|max:20',
            'especialidad_id'   => 'required|exists:especialidades,id',
            'telefono'          => 'nullable|string|max:20',
            'biografia'         => 'nullable|string',
        ]);

        // Crear usuario para el médico
        $user = User::create([
            'name'     => $request->nombre . ' ' . $request->apellidos,
            'email'    => $request->email,
            'password' => Hash::make('password123'),
        ]);
        $user->assignRole('medico');

        $clinica = Clinica::first();

        Medico::create([
            'clinica_id'         => $clinica->id,
            'user_id'            => $user->id,
            'especialidad_id'    => $request->especialidad_id,
            'cedula_profesional' => $request->cedula_profesional,
            'nombre'             => $request->nombre,
            'apellidos'          => $request->apellidos,
            'telefono'           => $request->telefono,
            'biografia'          => $request->biografia,
        ]);

        return redirect()->route('medicos.index')
            ->with('success', 'Médico registrado. Contraseña inicial: password123');
    }

    public function show(Medico $medico)
    {
        $medico->load(['especialidad', 'user', 'citas' => function($q) {
            $q->orderBy('fecha_hora', 'desc')->limit(5);
        }]);
        return view('medicos.show', compact('medico'));
    }

    public function edit(Medico $medico)
    {
        $especialidades = Especialidad::where('activo', true)->orderBy('nombre')->get();
        return view('medicos.edit', compact('medico', 'especialidades'));
    }

    public function update(Request $request, Medico $medico)
    {
        $request->validate([
            'nombre'            => 'required|string|max:255',
            'apellidos'         => 'required|string|max:255',
            'cedula_profesional'=> 'nullable|string|max:20',
            'especialidad_id'   => 'required|exists:especialidades,id',
            'telefono'          => 'nullable|string|max:20',
            'biografia'         => 'nullable|string',
        ]);

        $medico->update($request->only([
            'nombre', 'apellidos', 'cedula_profesional',
            'especialidad_id', 'telefono', 'biografia', 'activo'
        ]));

        return redirect()->route('medicos.show', $medico)
            ->with('success', 'Médico actualizado exitosamente.');
    }

    public function destroy(Medico $medico)
    {
        $medico->delete();
        return redirect()->route('medicos.index')
            ->with('success', 'Médico eliminado exitosamente.');
    }
}