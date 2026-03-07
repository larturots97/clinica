<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\RecetaItem;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\Clinica;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RecetaController extends Controller
{
    public function index()
    {
        $recetas = Receta::with(['paciente', 'medico'])
            ->orderBy('fecha', 'desc')
            ->paginate(15);
        return view('recetas.index', compact('recetas'));
    }

    public function create()
    {
        $pacientes = Paciente::orderBy('nombre')->get();
        $medicos   = Medico::where('activo', true)->orderBy('nombre')->get();
        return view('recetas.create', compact('pacientes', 'medicos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id'  => 'required|exists:pacientes,id',
            'medico_id'    => 'required|exists:medicos,id',
            'fecha'        => 'required|date',
            'diagnostico'  => 'nullable|string',
            'indicaciones' => 'nullable|string',
            'medicamentos' => 'required|array|min:1',
            'medicamentos.*.medicamento' => 'required|string',
        ]);

        $clinica = Clinica::first();

        $receta = Receta::create([
            'clinica_id'   => $clinica->id,
            'paciente_id'  => $request->paciente_id,
            'medico_id'    => $request->medico_id,
            'folio'        => 'RX-' . str_pad(Receta::count() + 1, 5, '0', STR_PAD_LEFT),
            'fecha'        => $request->fecha,
            'diagnostico'  => $request->diagnostico,
            'indicaciones' => $request->indicaciones,
        ]);

        foreach ($request->medicamentos as $i => $item) {
            if (!empty($item['medicamento'])) {
                RecetaItem::create([
                    'receta_id'    => $receta->id,
                    'medicamento'  => $item['medicamento'],
                    'dosis'        => $item['dosis'] ?? null,
                    'frecuencia'   => $item['frecuencia'] ?? null,
                    'duracion'     => $item['duracion'] ?? null,
                    'indicaciones' => $item['indicaciones'] ?? null,
                    'orden'        => $i,
                ]);
            }
        }

        return redirect()->route('recetas.show', $receta)
            ->with('success', 'Receta creada exitosamente.');
    }

    public function show(Receta $receta)
    {
        $receta->load(['paciente', 'medico.especialidad', 'items', 'clinica']);
        return view('recetas.show', compact('receta'));
    }

    public function edit(Receta $receta)
    {
        $pacientes = Paciente::orderBy('nombre')->get();
        $medicos   = Medico::where('activo', true)->orderBy('nombre')->get();
        $receta->load('items');
        return view('recetas.edit', compact('receta', 'pacientes', 'medicos'));
    }

    public function update(Request $request, Receta $receta)
    {
        $request->validate([
            'paciente_id'  => 'required|exists:pacientes,id',
            'medico_id'    => 'required|exists:medicos,id',
            'fecha'        => 'required|date',
            'medicamentos' => 'required|array|min:1',
            'medicamentos.*.medicamento' => 'required|string',
        ]);

        $receta->update([
            'paciente_id'  => $request->paciente_id,
            'medico_id'    => $request->medico_id,
            'fecha'        => $request->fecha,
            'diagnostico'  => $request->diagnostico,
            'indicaciones' => $request->indicaciones,
        ]);

        $receta->items()->delete();

        foreach ($request->medicamentos as $i => $item) {
            if (!empty($item['medicamento'])) {
                RecetaItem::create([
                    'receta_id'    => $receta->id,
                    'medicamento'  => $item['medicamento'],
                    'dosis'        => $item['dosis'] ?? null,
                    'frecuencia'   => $item['frecuencia'] ?? null,
                    'duracion'     => $item['duracion'] ?? null,
                    'indicaciones' => $item['indicaciones'] ?? null,
                    'orden'        => $i,
                ]);
            }
        }

        return redirect()->route('recetas.show', $receta)
            ->with('success', 'Receta actualizada exitosamente.');
    }

    public function destroy(Receta $receta)
    {
        $receta->delete();
        return redirect()->route('recetas.index')
            ->with('success', 'Receta eliminada exitosamente.');
    }

    public function pdf(Receta $receta)
    {
        $receta->load(['paciente', 'medico.especialidad', 'items', 'clinica']);
        $pdf = Pdf::loadView('recetas.pdf', compact('receta'));
        return $pdf->stream('receta-' . $receta->folio . '.pdf');
    }
}