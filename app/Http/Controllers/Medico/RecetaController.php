<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\Receta;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecetaController extends Controller
{
    public function index()
    {
        $medico = Auth::user()->medico;

        $recetas = Receta::where('medico_id', $medico->id)
            ->with('paciente')
            ->orderBy('fecha', 'desc')
            ->paginate(15);

        return view('medico.recetas.index', compact('recetas'));
    }

    public function create(Request $request)
    {
        $medico = Auth::user()->medico;

        $pacientes = Paciente::whereHas('citas', fn($q) => $q->where('medico_id', $medico->id))
            ->orderBy('nombre')->get();

        $pacienteSeleccionado = $request->paciente_id
            ? Paciente::find($request->paciente_id)
            : null;

        return view('medico.recetas.create', compact('pacientes', 'pacienteSeleccionado'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id'                 => 'required|exists:pacientes,id',
            'fecha'                       => 'required|date',
            'diagnostico'                 => 'nullable|string',
            'indicaciones'                => 'nullable|string',
            'medicamentos'                => 'required|array|min:1',
            'medicamentos.*.nombre'       => 'required|string',
            'medicamentos.*.dosis'        => 'required|string',
            'medicamentos.*.frecuencia'   => 'required|string',
            'medicamentos.*.duracion'     => 'nullable|string',
            'medicamentos.*.indicaciones' => 'nullable|string',
        ]);

        $medico = Auth::user()->medico;

        $folio = 'RX-' . str_pad(Receta::count() + 1, 5, '0', STR_PAD_LEFT);

        $receta = Receta::create([
            'clinica_id'   => 1,
            'medico_id'    => $medico->id,
            'paciente_id'  => $request->paciente_id,
            'fecha'        => $request->fecha,
            'folio'        => $folio,
            'diagnostico'  => $request->diagnostico,
            'indicaciones' => $request->indicaciones,
        ]);

        foreach ($request->medicamentos as $med) {
            $receta->items()->create([
                'medicamento'  => $med['nombre'],
                'dosis'        => $med['dosis'],
                'frecuencia'   => $med['frecuencia'],
                'duracion'     => $med['duracion'] ?? null,
                'indicaciones' => $med['indicaciones'] ?? null,
            ]);
        }

        return redirect()->route('medico.recetas.show', $receta)
            ->with('success', 'Receta creada correctamente.');
    }

    public function show(Receta $receta)
    {
        $medico = Auth::user()->medico;

        if ($receta->medico_id !== $medico->id) {
            abort(403);
        }

        $receta->load('paciente', 'items', 'medico.especialidad');

        return view('medico.recetas.show', compact('receta'));
    }

    public function pdf(Receta $receta)
    {
        $medico = Auth::user()->medico;

        if ($receta->medico_id !== $medico->id) {
            abort(403);
        }

        $receta->load('paciente', 'items', 'medico.especialidad');
        $config = \App\Models\ConfiguracionMedico::where('medico_id', $medico->id)->first();

        $logoBase64      = $this->imagenBase64($config?->logo);
        $logoFondoBase64 = $this->imagenBase64($config?->receta_logo_fondo ?: $config?->logo);

        dd([
            'logo_path' => $config?->logo,
            'logo_len'  => strlen($logoBase64 ?? ''),
            'fondo_len' => strlen($logoFondoBase64 ?? ''),
            'disk'      => config('filesystems.default'),
            'bucket'    => config('filesystems.disks.s3.bucket'),
            'key_set'   => !empty(config('filesystems.disks.s3.key')),
        ]);
    }
private function imagenBase64(?string $path): ?string
{
    if (!$path) return null;
    try {
        // Forzar throw para ver errores reales
        $disk = Storage::build([
            'driver'                  => 's3',
            'key'                     => config('filesystems.disks.s3.key'),
            'secret'                  => config('filesystems.disks.s3.secret'),
            'region'                  => config('filesystems.disks.s3.region'),
            'bucket'                  => config('filesystems.disks.s3.bucket'),
            'endpoint'                => config('filesystems.disks.s3.endpoint'),
            'use_path_style_endpoint' => config('filesystems.disks.s3.use_path_style_endpoint', false),
            'throw'                   => true,
        ]);

        $contenido = $disk->get($path);
        $mime      = $disk->mimeType($path);
        return 'data:' . $mime . ';base64,' . base64_encode($contenido);
    } catch (\Exception $e) {
        dd('STORAGE ERROR: ' . $e->getMessage());
    }
}
}