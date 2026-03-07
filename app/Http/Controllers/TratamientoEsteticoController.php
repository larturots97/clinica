<?php

namespace App\Http\Controllers;

use App\Models\TratamientoEstetico;
use App\Models\TratamientoZona;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\Producto;
use App\Models\Clinica;
use App\Models\MovimientoInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TratamientoEsteticoController extends Controller
{
    private function esMedicoEstetico()
    {
        $user = auth()->user();
        if ($user->hasRole('admin')) return false;
        if (!$user->hasRole('medico')) return false;
        $medico = \App\Models\Medico::where('user_id', $user->id)->first();
        return $medico && $medico->especialidad?->nombre === 'Medicina Estética';
    }

    public function index()
    {
        $tratamientos = TratamientoEstetico::with(['paciente', 'medico'])
            ->orderBy('fecha', 'desc')
            ->paginate(15);
        return view('estetica.index', compact('tratamientos'));
    }

    public function create()
    {
        if (!$this->esMedicoEstetico()) {
            abort(403, 'Solo médicos de Medicina Estética pueden crear tratamientos.');
        }
        $pacientes = Paciente::orderBy('nombre')->get();
        $medicos   = Medico::where('activo', true)->orderBy('nombre')->get();
        $productos = Producto::where('activo', true)->orderBy('nombre')->get();
        return view('estetica.create', compact('pacientes', 'medicos', 'productos'));
    }

    public function store(Request $request)
    {
        if (!$this->esMedicoEstetico()) {
            abort(403, 'Solo médicos de Medicina Estética pueden crear tratamientos.');
        }

        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id'   => 'required|exists:medicos,id',
            'fecha'       => 'required|date',
            'zonas'       => 'required|array|min:1',
        ]);

        $clinica = Clinica::first();

        DB::transaction(function() use ($request, $clinica) {
            $tratamiento = TratamientoEstetico::create([
                'clinica_id'              => $clinica->id,
                'paciente_id'             => $request->paciente_id,
                'medico_id'               => $request->medico_id,
                'fecha'                   => $request->fecha,
                'titulo'                  => $request->titulo,
                'observaciones_generales' => $request->observaciones_generales,
            ]);

            foreach ($request->zonas as $zonaData) {
                if (empty($zonaData['zona'])) continue;

                TratamientoZona::create([
                    'tratamiento_id' => $tratamiento->id,
                    'producto_id'    => $zonaData['producto_id'] ?? null,
                    'zona'           => $zonaData['zona'],
                    'zona_label'     => $zonaData['zona_label'] ?? $zonaData['zona'],
                    'cantidad'       => $zonaData['cantidad'] ?? 0,
                    'unidad'         => $zonaData['unidad'] ?? null,
                    'notas'          => $zonaData['notas'] ?? null,
                ]);

                if (!empty($zonaData['producto_id']) && !empty($zonaData['cantidad'])) {
                    $producto = Producto::find($zonaData['producto_id']);
                    if ($producto) {
                        $stockAnterior = $producto->stock_actual;
                        $stockNuevo    = max(0, $stockAnterior - $zonaData['cantidad']);
                        $producto->update(['stock_actual' => $stockNuevo]);

                        MovimientoInventario::create([
                            'clinica_id'     => $clinica->id,
                            'producto_id'    => $producto->id,
                            'user_id'        => Auth::id(),
                            'tipo'           => 'salida',
                            'cantidad'       => $zonaData['cantidad'],
                            'stock_anterior' => $stockAnterior,
                            'stock_nuevo'    => $stockNuevo,
                            'motivo'         => 'Tratamiento estético — ' . ($zonaData['zona_label'] ?? $zonaData['zona']),
                        ]);
                    }
                }
            }
        });

        return redirect()->route('estetica.index')
            ->with('success', 'Tratamiento estético registrado exitosamente.');
    }

    public function show(TratamientoEstetico $estetica)
    {
        $estetica->load(['paciente', 'medico', 'zonas.producto']);
        return view('estetica.show', compact('estetica'));
    }

    public function edit(TratamientoEstetico $estetica)
    {
        if (!$this->esMedicoEstetico()) {
            abort(403, 'Solo médicos de Medicina Estética pueden editar tratamientos.');
        }
        $pacientes = Paciente::orderBy('nombre')->get();
        $medicos   = Medico::where('activo', true)->orderBy('nombre')->get();
        $productos = Producto::where('activo', true)->orderBy('nombre')->get();
        $estetica->load('zonas');
        return view('estetica.edit', compact('estetica', 'pacientes', 'medicos', 'productos'));
    }

    public function update(Request $request, TratamientoEstetico $estetica)
    {
        if (!$this->esMedicoEstetico()) {
            abort(403, 'Solo médicos de Medicina Estética pueden editar tratamientos.');
        }

        $estetica->update([
            'titulo'                  => $request->titulo,
            'observaciones_generales' => $request->observaciones_generales,
        ]);

        return redirect()->route('estetica.show', $estetica)
            ->with('success', 'Tratamiento actualizado exitosamente.');
    }

    public function destroy(TratamientoEstetico $estetica)
    {
        $estetica->delete();
        return redirect()->route('estetica.index')
            ->with('success', 'Tratamiento eliminado exitosamente.');
    }
}