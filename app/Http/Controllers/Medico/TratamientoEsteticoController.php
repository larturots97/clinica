<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\TratamientoEstetico;
use App\Models\TratamientoZona;
use App\Models\TipoTratamiento;
use App\Models\Paciente;
use App\Models\Cita;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TratamientoEsteticoController extends Controller
{
    private function getMedico()
    {
        return auth()->user()->medico;
    }

    public function index()
    {
        $medico = $this->getMedico();
        $tratamientos = TratamientoEstetico::with(['paciente', 'tipoTratamiento'])
            ->where('medico_id', $medico->id)
            ->orderByDesc('fecha')
            ->paginate(20);

        return view('medico.tratamientos-esteticos.index', compact('tratamientos'));
    }

    public function create(Request $request)
    {
        $medico = $this->getMedico();
        $tipos  = TipoTratamiento::where('medico_id', $medico->id)->activos()->get()->groupBy('grupo');
        $pacientes = Paciente::where('clinica_id', $medico->clinica_id)->orderBy('nombre')->get();

        $paciente = null;
        $cita     = null;

        if ($request->paciente_id) {
            $paciente = Paciente::find($request->paciente_id);
        }
        if ($request->cita_id) {
            $cita = Cita::with('paciente')->find($request->cita_id);
            if ($cita) $paciente = $cita->paciente;
        }

        return view('medico.tratamientos-esteticos.create',
            compact('tipos', 'pacientes', 'paciente', 'cita', 'medico'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id'      => 'required|exists:pacientes,id',
            'tipo_tratamiento_id' => 'required|exists:tipo_tratamientos,id',
            'fecha'            => 'required|date',
            'tipo_clave'       => 'required|string',
            'grupo'            => 'required|in:A,B,C,D,E',
        ]);

        $medico = $this->getMedico();

        $tipo = TipoTratamiento::findOrFail($request->tipo_tratamiento_id);

        $tratamiento = TratamientoEstetico::create([
            'clinica_id'           => $medico->clinica_id,
            'medico_id'            => $medico->id,
            'paciente_id'          => $request->paciente_id,
            'tipo_tratamiento_id'  => $request->tipo_tratamiento_id,
            'fecha'                => $request->fecha,
            'titulo'               => $tipo->nombre,
            'grupo'                => $request->grupo,
            'tipo_clave'           => $request->tipo_clave,
            'motivo_consulta'      => $request->motivo_consulta,
            'fitzpatrick'          => $request->fitzpatrick,
            'tipo_piel'            => $request->tipo_piel ?? [],
            'condiciones_piel'     => $request->condiciones_piel ?? [],
            'antecedentes'         => $request->antecedentes ?? [],
            'simetria'             => $request->simetria,
            'tonicidad'            => $request->tonicidad,
            'tecnica'              => $request->tecnica,
            'profundidad'          => $request->profundidad,
            'producto_marca'       => $request->producto_marca,
            'producto_lote'        => $request->producto_lote,
            'producto_caducidad'   => $request->producto_caducidad ?: null,
            'sesion_numero'        => $request->sesion_numero ?? 1,
            'intervalo'            => $request->intervalo,
            'volumen_total'        => $request->volumen_total,
            'unidad_volumen'       => $request->unidad_volumen,
            'objetivo'             => $request->objetivo,
            'observaciones_generales' => $request->observaciones_generales,
            'observaciones_post'   => $request->observaciones_post,
            'consentimiento_idioma'   => $request->consentimiento_idioma ?? 'es',
            'consentimiento_entrega'  => $request->consentimiento_entrega,
            'campos_extra'         => $request->campos_extra ? json_decode($request->campos_extra, true) : null,
        ]);

        // Guardar zonas predefinidas
        if ($request->zonas_predefinidas) {
            foreach ($request->zonas_predefinidas as $zona => $datos) {
                if (!empty($datos['activa'])) {
                    TratamientoZona::create([
                        'tratamiento_id' => $tratamiento->id,
                        'zona'           => $zona,
                        'zona_label'     => $datos['label'] ?? $zona,
                        'tipo'           => 'predefinida',
                        'cantidad'       => $datos['cantidad'] ?? null,
                        'unidad'         => $datos['unidad'] ?? null,
                        'notas'          => $datos['notas'] ?? null,
                        'activa'         => true,
                    ]);
                }
            }
        }

        // Guardar puntos libres del mapa
        if ($request->puntos_libres) {
            $puntos = json_decode($request->puntos_libres, true);
            foreach ($puntos as $punto) {
                TratamientoZona::create([
                    'tratamiento_id' => $tratamiento->id,
                    'zona'           => 'libre',
                    'zona_label'     => $punto['label'] ?? '',
                    'tipo'           => 'libre',
                    'coord_x'        => $punto['x'],
                    'coord_y'        => $punto['y'],
                    'color'          => $punto['color'] ?? '#dc2626',
                    'activa'         => true,
                ]);
            }
        }

        return redirect()->route('medico.tratamientos-esteticos.show', $tratamiento)
            ->with('success', 'Historia clinica estetica guardada correctamente.');
    }

    public function show(TratamientoEstetico $tratamientosEstetico)
    {
        $tratamiento = $tratamientosEstetico;
        $tratamiento->load(['paciente', 'tipoTratamiento', 'zonas', 'medico']);
        return view('medico.tratamientos-esteticos.show', compact('tratamiento'));
    }

    public function edit(TratamientoEstetico $tratamientosEstetico)
    {
        $tratamiento = $tratamientosEstetico;
        $medico = $this->getMedico();
        $tipos  = TipoTratamiento::where('medico_id', $medico->id)->activos()->get()->groupBy('grupo');
        $tratamiento->load(['zonas', 'tipoTratamiento']);
        return view('medico.tratamientos-esteticos.edit', compact('tratamiento', 'tipos', 'medico'));
    }

    public function pdf(TratamientoEstetico $tratamientosEstetico)
    {
        $tratamiento = $tratamientosEstetico;
        $tratamiento->load(['paciente', 'tipoTratamiento', 'zonas', 'medico']);

        $pdf = Pdf::loadView('medico.tratamientos-esteticos.pdf', compact('tratamiento'))
            ->setPaper('letter', 'portrait');

        return $pdf->stream('historial-estetico-' . $tratamiento->id . '.pdf');
    }
}
