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

    \Illuminate\Support\Facades\Log::info('PDF logos', [
        'logo_path'       => $config?->logo,
        'logo_len'        => strlen($logoBase64 ?? ''),
        'fondo_len'       => strlen($logoFondoBase64 ?? ''),
        'disk'            => config('filesystems.default'),
        'bucket'          => config('filesystems.disks.s3.bucket'),
    ]);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'recetas.pdf',
        compact('receta', 'config', 'logoBase64', 'logoFondoBase64')
    )
    ->setOptions([
        'isRemoteEnabled' => true,
        'defaultFont'     => 'Arial',
    ])
    ->setPaper('letter', 'portrait');

    return $pdf->stream('receta-' . $receta->folio . '.pdf');
}
    private function imagenBase64(?string $path): ?string
    {
        if (!$path) return null;
        try {
            $contenido = Storage::disk('s3')->get($path);
            if (!$contenido) return null;
            $mime = Storage::disk('s3')->mimeType($path);
            return 'data:' . $mime . ';base64,' . base64_encode($contenido);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('imagenBase64 error: ' . $e->getMessage() . ' path: ' . $path);
            return null;
        }
    }
}