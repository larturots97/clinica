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
            'paciente_id'         => 'required|exists:pacientes,id',
            'fecha'               => 'required|date',
            'diagnostico'         => 'nullable|string',
            'indicaciones'        => 'nullable|string',
            'medicamentos'        => 'required|array|min:1',
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

    // DEBUG TEMPORAL — quitar después
    $disk = Storage::disk(config('filesystems.default'));
    dd([
        'filesystem_default' => config('filesystems.default'),
        'logo_path'          => $config?->logo,
        'fondo_path'         => $config?->receta_logo_fondo,
        'logo_exists'        => $config?->logo ? $disk->exists($config->logo) : 'no hay path',
        'fondo_exists'       => $config?->receta_logo_fondo ? $disk->exists($config->receta_logo_fondo) : 'no hay path',
        'logo_base64_len'    => strlen($this->imagenBase64($config?->logo) ?? ''),
    ]);
}

    private function imagenBase64(?string $path): ?string
{
    if (!$path) return null;
    try {
        // Leer directo via URL pública de R2
        $url = Storage::disk('s3')->url($path);
        $contenido = file_get_contents($url);
        if (!$contenido) return null;
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime  = $finfo->buffer($contenido);
        return 'data:' . $mime . ';base64,' . base64_encode($contenido);
    } catch (\Exception $e) {
        return null;
    }
}
}