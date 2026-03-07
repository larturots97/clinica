<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\TratamientoEstetico;
use App\Models\TratamientoZona;
use App\Models\Paciente;
use App\Models\Producto;
use App\Models\Clinica;
use App\Models\MovimientoInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EsteticaController extends Controller
{
    public function show(TratamientoEstetico $tratamientoEstetico)
    {
        $medico = Auth::user()->medico;
        if ($tratamientoEstetico->medico_id !== $medico->id) abort(403);
        $tratamientoEstetico->load('paciente', 'zonas.producto');
        return view('medico.estetica.show', compact('tratamientoEstetico'));
    }

    public function create(Request $request)
    {
        $medico = Auth::user()->medico;
        $pacientes = Paciente::whereHas('citas', fn($q) => $q->where('medico_id', $medico->id))
            ->orderBy('nombre')->get();
        $productos = Producto::where('activo', true)->orderBy('nombre')->get();
        $pacienteSeleccionado = $request->paciente_id
            ? Paciente::find($request->paciente_id)
            : null;
        return view('medico.estetica.create', compact('pacientes', 'productos', 'pacienteSeleccionado', 'medico'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha'       => 'required|date',
            'zonas'       => 'required|array|min:1',
        ]);

        $medico  = Auth::user()->medico;
        $clinica = Clinica::first();

        DB::transaction(function() use ($request, $medico, $clinica) {
            $tratamiento = TratamientoEstetico::create([
                'clinica_id'              => $clinica->id,
                'paciente_id'             => $request->paciente_id,
                'medico_id'               => $medico->id,
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

        return redirect()->route('medico.pacientes.show', $request->paciente_id)
            ->with('success', 'Tratamiento estético registrado correctamente.');
    }
}