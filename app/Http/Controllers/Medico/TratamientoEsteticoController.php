<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\TratamientoEstetico;
use App\Models\TratamientoZona;
use App\Models\TipoTratamiento;
use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Producto;
use App\Models\MovimientoInventario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

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
        $medico    = $this->getMedico();
        $tipos     = TipoTratamiento::where('medico_id', $medico->id)->activos()->get()->groupBy('grupo');
        $pacientes = Paciente::where('clinica_id', $medico->clinica_id)->orderBy('nombre')->get();
        $productos = Producto::where('clinica_id', $medico->clinica_id)
            ->where('activo', true)
            ->where('stock_actual', '>', 0)
            ->orderBy('nombre')
            ->get();

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
            compact('tipos', 'pacientes', 'paciente', 'cita', 'medico', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id'         => 'required|exists:pacientes,id',
            'tipo_tratamiento_id' => 'required|exists:tipo_tratamientos,id',
            'fecha'               => 'required|date',
            'tipo_clave'          => 'required|string',
            'grupo'               => 'required|in:A,B,C,D,E',
            'producto_id'         => 'nullable|exists:productos,id',
            'producto_cantidad'   => 'nullable|numeric|min:0.01',
        ]);

        $medico = $this->getMedico();
        $tipo   = TipoTratamiento::findOrFail($request->tipo_tratamiento_id);

        // Verificar stock antes de iniciar la transacción
        if ($request->producto_id && $request->producto_cantidad) {
            $producto = Producto::findOrFail($request->producto_id);
            if ($producto->stock_actual < $request->producto_cantidad) {
                return back()->withInput()->withErrors([
                    'producto_cantidad' => "Stock insuficiente. Disponible: {$producto->stock_actual} {$producto->unidad}.",
                ]);
            }
        }

        $tratamiento = null;

        DB::transaction(function () use ($request, $medico, $tipo, &$tratamiento) {

            $tratamiento = TratamientoEstetico::create([
                'clinica_id'              => $medico->clinica_id,
                'medico_id'               => $medico->id,
                'paciente_id'             => $request->paciente_id,
                'tipo_tratamiento_id'     => $request->tipo_tratamiento_id,
                'fecha'                   => $request->fecha,
                'titulo'                  => $tipo->nombre,
                'grupo'                   => $request->grupo,
                'tipo_clave'              => $request->tipo_clave,
                'motivo_consulta'         => $request->motivo_consulta,
                'fitzpatrick'             => $request->fitzpatrick,
                'tipo_piel'               => $request->tipo_piel ?? [],
                'condiciones_piel'        => $request->condiciones_piel ?? [],
                'antecedentes'            => $request->antecedentes ?? [],
                'simetria'                => $request->simetria,
                'tonicidad'               => $request->tonicidad,
                'tecnica'                 => $request->tecnica,
                'profundidad'             => $request->profundidad,
                'producto_id'             => $request->producto_id ?: null,
                'producto_cantidad'       => $request->producto_cantidad ?: null,
                'producto_marca'          => $request->producto_marca,
                'producto_lote'           => $request->producto_lote,
                'producto_caducidad'      => $request->producto_caducidad ?: null,
                'sesion_numero'           => $request->sesion_numero ?? 1,
                'intervalo'               => $request->intervalo,
                'volumen_total'           => $request->volumen_total,
                'unidad_volumen'          => $request->unidad_volumen,
                'objetivo'                => $request->objetivo,
                'exploracion_fisica'      => $request->exploracion_fisica,
                'peso'                    => $request->peso,
                'talla'                   => $request->talla,
                'temperatura'             => $request->temperatura,
                'tension_arterial'        => $request->tension_arterial,
                'frecuencia_cardiaca'     => $request->frecuencia_cardiaca,
                'saturacion_o2'           => $request->saturacion_o2,
                'observaciones_generales' => $request->observaciones_generales,
                'observaciones_post'      => $request->observaciones_post,
                'consentimiento_idioma'   => $request->consentimiento_idioma ?? 'es',
                'consentimiento_entrega'  => $request->consentimiento_entrega,
                'campos_extra'            => $request->campos_extra
                    ? (is_array($request->campos_extra) ? $request->campos_extra : json_decode($request->campos_extra, true))
                    : null,
                'mapa_activo'             => $request->input('mapa_activo', '1') === '1' ? 1 : 0,
                'zonas_texto'             => $request->zonas_texto,
            ]);

            // ── Descontar inventario ──────────────────────────────────────
            if ($request->producto_id && $request->producto_cantidad) {
                $producto      = Producto::lockForUpdate()->find($request->producto_id);
                $stockAnterior = $producto->stock_actual;
                $stockNuevo    = $stockAnterior - (float) $request->producto_cantidad;

                $producto->update(['stock_actual' => $stockNuevo]);

                MovimientoInventario::create([
                    'clinica_id'     => $medico->clinica_id,
                    'producto_id'    => $producto->id,
                    'user_id'        => auth()->id(),
                    'tipo'           => 'salida',
                    'cantidad'       => $request->producto_cantidad,
                    'stock_anterior' => $stockAnterior,
                    'stock_nuevo'    => $stockNuevo,
                    'motivo'         => "Tratamiento estético #{$tratamiento->id} — {$tratamiento->titulo}",
                ]);
            }

            // ── Zonas predefinidas ────────────────────────────────────────
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

            // ── Puntos libres del mapa ────────────────────────────────────
            if ($request->puntos_libres) {
                $raw    = $request->puntos_libres;
                $puntos = is_array($raw) ? $raw : json_decode($raw, true);
                foreach ($puntos as $punto) {
                    TratamientoZona::create([
                        'tratamiento_id' => $tratamiento->id,
                        'zona'           => 'libre',
                        'zona_label'     => $punto['nombre'] ?? $punto['label'] ?? '',
                        'tipo'           => 'libre',
                        'coord_x'        => $punto['x'],
                        'coord_y'        => $punto['y'],
                        'color'          => $punto['color'] ?? '#dc2626',
                        'cantidad'       => $punto['cantidad'] ?? null,
                        'unidad'         => isset($punto['cantidad']) ? 'U' : null,
                        'notas'          => $punto['label'] ?? null,
                        'activa'         => true,
                    ]);
                }
            }
        });

        return redirect()->route('medico.tratamientos-esteticos.show', $tratamiento)
            ->with('success', 'Historia clínica estética guardada correctamente.');
    }

    public function show(TratamientoEstetico $tratamientosEstetico)
    {
        $tratamiento = $tratamientosEstetico;
        $tratamiento->load(['paciente', 'tipoTratamiento', 'zonas', 'medico', 'producto']);
        return view('medico.tratamientos-esteticos.show', compact('tratamiento'));
    }

    public function edit(TratamientoEstetico $tratamientosEstetico)
    {
        $tratamiento = $tratamientosEstetico;
        $medico      = $this->getMedico();
        $tipos       = TipoTratamiento::where('medico_id', $medico->id)->activos()->get()->groupBy('grupo');
        $tratamiento->load(['zonas', 'tipoTratamiento']);
        return view('medico.tratamientos-esteticos.edit', compact('tratamiento', 'tipos', 'medico'));
    }

   public function pdf(TratamientoEstetico $tratamientosEstetico)
{
    $tratamiento = $tratamientosEstetico;
    $tratamiento->load(['paciente', 'tipoTratamiento', 'zonas', 'medico', 'producto']);

    $mapaBase64  = $this->generarMapaBase64($tratamiento);
    $config      = \App\Models\ConfiguracionMedico::where('medico_id', $tratamiento->medico_id)->first();
    $logoBase64  = $this->imagenBase64($config?->logo);

    $pdf = Pdf::loadView('medico.tratamientos-esteticos.pdf', compact('tratamiento', 'mapaBase64', 'config', 'logoBase64'))
        ->setOptions(['isRemoteEnabled' => true, 'defaultFont' => 'Arial','isGdEnabled'     => false,])
        ->setPaper('letter', 'portrait');
        

    return $pdf->stream('historial-estetico-' . $tratamiento->id . '.pdf');
}

public function consentimiento(TratamientoEstetico $tratamientosEstetico)
{
    $tratamiento = $tratamientosEstetico;
    $tratamiento->load(['paciente', 'tipoTratamiento', 'medico.clinica', 'producto', 'zonas']);

    $config     = \App\Models\ConfiguracionMedico::where('medico_id', $tratamiento->medico_id)->first();
    $logoBase64 = $this->imagenBase64($config?->logo);
    $firmaBase64 = $this->imagenBase64($config?->firma);

    $pdf = Pdf::loadView('medico.tratamientos-esteticos.consentimiento-pdf', compact('tratamiento', 'config', 'logoBase64', 'firmaBase64'))
        ->setOptions(['isRemoteEnabled' => true, 'defaultFont' => 'Arial'])
        ->setPaper('letter', 'portrait');

    return $pdf->stream('consentimiento-' . $tratamiento->id . '.pdf');
}

private function imagenBase64(?string $path): ?string
{
    if (!$path) return null;
    try {
        $client = new \Aws\S3\S3Client([
            'version'     => 'latest',
            'region'      => 'auto',
            'endpoint'    => config('filesystems.disks.s3.endpoint'),
            'credentials' => [
                'key'    => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret'),
            ],
            'use_path_style_endpoint' => false,
        ]);

        $result    = $client->getObject([
            'Bucket' => config('filesystems.disks.s3.bucket'),
            'Key'    => $path,
        ]);

        $contenido = (string) $result['Body'];
        $mime      = $result['ContentType'] ?? 'image/png';
        return 'data:' . $mime . ';base64,' . base64_encode($contenido);
    } catch (\Exception $e) {
        return null;
    }
}
   public function guardarFirmaPaciente(Request $request, TratamientoEstetico $tratamientosEstetico)
    {
        // Si ya está bloqueado, no permitir cambios
        if ($tratamientosEstetico->consentimiento_bloqueado) {
            return response()->json(['error' => 'Este consentimiento ya fue firmado y está bloqueado.'], 403);
        }

        $request->validate([
            'firma_paciente' => 'required|string',
        ]);

        if (!preg_match('/^data:image\/(png|jpeg|jpg);base64,/', $request->firma_paciente)) {
            return response()->json(['error' => 'Firma inválida'], 422);
        }

        $tratamientosEstetico->update([
            'firma_paciente'           => $request->firma_paciente,
            'firma_paciente_at'        => now(),
            'consentimiento_bloqueado' => true,
        ]);

        return response()->json(['success' => true]);
    }

    private function generarMapaBase64($tratamiento): string
    {
        $coordsZonas = [
            'F'   => [100, 74],  'GL'  => [100, 100],
            'PGI' => [52,  122], 'PGD' => [148, 122],
            'BL'  => [100, 140], 'L'   => [100, 172],
            'MI'  => [44,  158], 'MD'  => [156, 158],
            'C'   => [100, 228],
        ];

        $predefinidas     = $tratamiento->zonas->where('tipo', 'predefinida')->where('activa', true)->filter(fn($z) => $z->cantidad > 0);
        $libres           = $tratamiento->zonas->where('tipo', 'libre');
        $zonasActivasKeys = $predefinidas->pluck('zona')->toArray();
        $zonasMap         = $predefinidas->keyBy('zona');

        $puntosActivos = '';
        foreach ($coordsZonas as $key => $coords) {
            if (in_array($key, $zonasActivasKeys)) {
                $zona = $zonasMap->get($key);
                $cant = $zona?->cantidad;
                $cx   = $coords[0];
                $cy   = $coords[1];
                $puntosActivos .= "<circle cx=\"{$cx}\" cy=\"{$cy}\" r=\"11\" fill=\"#9333ea\"/>";
                $puntosActivos .= "<text x=\"{$cx}\" y=\"" . ($cy + 4) . "\" text-anchor=\"middle\" font-size=\"8\" fill=\"white\" font-family=\"Arial\" font-weight=\"bold\">{$key}</text>";
                if ($cant) {
                    $puntosActivos .= "<text x=\"{$cx}\" y=\"" . ($cy - 14) . "\" text-anchor=\"middle\" font-size=\"8\" fill=\"#4c1d95\" font-family=\"Arial\" font-weight=\"bold\">{$cant}U</text>";
                }
            }
        }

        $puntosLibres = '';
        foreach ($libres as $pl) {
            if ($pl->coord_x && $pl->coord_y) {
                $color = $pl->color ?? '#dc2626';
                $cx    = $pl->coord_x;
                $cy    = $pl->coord_y;
                $puntosLibres .= "<circle cx=\"{$cx}\" cy=\"{$cy}\" r=\"9\" fill=\"{$color}\"/>";
                if ($pl->zona_label) {
                    $lbl = htmlspecialchars(substr($pl->zona_label, 0, 6));
                    $puntosLibres .= "<text x=\"" . ($cx + 11) . "\" y=\"" . ($cy + 3) . "\" font-size=\"7\" fill=\"{$color}\" font-family=\"Arial\" font-weight=\"bold\">{$lbl}</text>";
                }
                if ($pl->cantidad) {
                    $puntosLibres .= "<text x=\"{$cx}\" y=\"" . ($cy - 13) . "\" text-anchor=\"middle\" font-size=\"8\" fill=\"{$color}\" font-family=\"Arial\" font-weight=\"bold\">{$pl->cantidad}U</text>";
                }
            }
        }

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="200" height="270" viewBox="0 0 200 270">
  <ellipse cx="100" cy="130" rx="64" ry="84" fill="#fdf8ee" stroke="#3d2010" stroke-width="1.5"/>
  <path d="M82 206 L80 238 Q100 246 120 238 L118 206" fill="#fdf8ee" stroke="#3d2010" stroke-width="1.2"/>
  <path d="M36 93 Q38 63 60 46 Q80 32 100 30 Q120 32 140 46 Q162 63 164 93 Q152 66 100 64 Q48 66 36 93 Z" fill="#2c1408"/>
  <ellipse cx="36" cy="130" rx="9" ry="15" fill="#fdf0d8" stroke="#3d2010" stroke-width="1.2"/>
  <ellipse cx="164" cy="130" rx="9" ry="15" fill="#fdf0d8" stroke="#3d2010" stroke-width="1.2"/>
  <path d="M62 100 Q75 94 90 98" stroke="#2c1408" stroke-width="2" stroke-linecap="round"/>
  <path d="M110 98 Q125 94 138 100" stroke="#2c1408" stroke-width="2" stroke-linecap="round"/>
  <path d="M62 110 Q76 104 90 110" stroke="#2c1408" stroke-width="2" stroke-linecap="round"/>
  <path d="M110 110 Q124 104 138 110" stroke="#2c1408" stroke-width="2" stroke-linecap="round"/>
  <ellipse cx="76" cy="116" rx="14" ry="9" fill="#fdf8ee" stroke="#2c1408" stroke-width="1.2"/>
  <ellipse cx="124" cy="116" rx="14" ry="9" fill="#fdf8ee" stroke="#2c1408" stroke-width="1.2"/>
  <circle cx="76" cy="116" r="6" fill="#1a0a04"/>
  <circle cx="124" cy="116" r="6" fill="#1a0a04"/>
  <circle cx="74" cy="114" r="2" fill="#fdf8ee"/>
  <circle cx="122" cy="114" r="2" fill="#fdf8ee"/>
  <path d="M97 128 Q94 146 88 152 Q100 156 112 152 Q106 146 103 128" fill="none" stroke="#c0906a" stroke-width="1.2"/>
  <path d="M80 168 Q100 180 120 168" fill="#c08878" stroke="#3d2010" stroke-width="0.8"/>
  <path d="M80 168 Q100 162 120 168" fill="#a06858" stroke="#3d2010" stroke-width="0.8"/>
  {$puntosActivos}
  {$puntosLibres}
</svg>
SVG;

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
   public function datosPaciente(Paciente $paciente)
    {
        return response()->json([
            'fitzpatrick'      => $paciente->fitzpatrick,
            'tipo_piel'        => $paciente->tipo_piel ?? [],
            'condiciones_piel' => $paciente->condiciones_piel ?? [],
            'tipo_sangre'     => $paciente->tipo_sangre,
        ]);
    }
}