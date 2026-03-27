<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use App\Models\FacturaItem;
use App\Models\Paciente;
use App\Models\Clinica;
use App\Models\Medico;
use App\Models\ConfiguracionMedico;
use App\Mail\ReciboPacienteMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        $medico = Auth::user()->medico;

        $query = Factura::where('medico_id', $medico->id)
            ->with('paciente')
            ->orderBy('fecha', 'desc');

        if ($request->buscar) {
            $query->whereHas('paciente', fn($q) =>
                $q->where('nombre', 'like', '%' . $request->buscar . '%')
                  ->orWhere('apellidos', 'like', '%' . $request->buscar . '%')
            );
        }

        $facturas = $query->paginate(15);

        $totalMes = Factura::where('medico_id', $medico->id)
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->sum('total');

        $pendientes = Factura::where('medico_id', $medico->id)
            ->where('estado', 'pendiente')->count();

        return view('medico.pagos.index', compact('facturas', 'totalMes', 'pendientes'));
    }

    public function create(Request $request)
    {
        $medico    = Auth::user()->medico;
        $pacientes = Paciente::whereHas('citas', fn($q) => $q->where('medico_id', $medico->id))
            ->orderBy('nombre')->get();
        $pacienteSeleccionado = $request->paciente_id
            ? Paciente::find($request->paciente_id)
            : null;

        return view('medico.pagos.create', compact('pacientes', 'pacienteSeleccionado'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id'                 => 'required|exists:pacientes,id',
            'fecha'                       => 'required|date',
            'conceptos'                   => 'required|array|min:1',
            'conceptos.*.concepto'        => 'required|string',
            'conceptos.*.cantidad'        => 'required|integer|min:1',
            'conceptos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        $medico  = Auth::user()->medico;
        $clinica = Clinica::first();

        $subtotal = 0;
        foreach ($request->conceptos as $item) {
            $subtotal += $item['cantidad'] * $item['precio_unitario'];
        }

        $descuento = $request->descuento ?? 0;
        $impuesto  = $request->sin_impuesto ? 0 : round(($subtotal - $descuento) * 0.16, 2);
        $total     = $subtotal - $descuento + $impuesto;

        $factura = Factura::create([
            'clinica_id'  => $clinica->id,
            'paciente_id' => $request->paciente_id,
            'medico_id'   => $medico->id,
            'folio'       => 'FAC-' . str_pad(Factura::count() + 1, 5, '0', STR_PAD_LEFT),
            'fecha'       => $request->fecha,
            'subtotal'    => $subtotal,
            'descuento'   => $descuento,
            'impuesto'    => $impuesto,
            'total'       => $total,
            'estado'      => 'pendiente',
            'notas'       => $request->notas,
        ]);

        foreach ($request->conceptos as $i => $item) {
            FacturaItem::create([
                'factura_id'      => $factura->id,
                'concepto'        => $item['concepto'],
                'descripcion'     => $item['descripcion'] ?? null,
                'cantidad'        => $item['cantidad'],
                'precio_unitario' => $item['precio_unitario'],
                'subtotal'        => $item['cantidad'] * $item['precio_unitario'],
                'orden'           => $i,
            ]);
        }

        return redirect()->route('medico.pagos.show', $factura)
            ->with('success', 'Recibo creado correctamente.');
    }

    public function show(Factura $pago)
    {
        $medico = Auth::user()->medico;
        if ($pago->medico_id !== $medico->id) abort(403);
        $pago->load(['paciente', 'items', 'medico.especialidad', 'clinica']);
        return view('medico.pagos.show', compact('pago'));
    }

    public function update(Request $request, Factura $pago)
    {
        $medico = Auth::user()->medico;
        if ($pago->medico_id !== $medico->id) abort(403);

        $request->validate([
            'estado'      => 'required|in:pendiente,pagada,cancelada',
            'metodo_pago' => 'nullable|in:efectivo,tarjeta,transferencia,otro',
        ]);

        $pago->update([
            'estado'      => $request->estado,
            'metodo_pago' => $request->metodo_pago,
            'notas'       => $request->notas,
        ]);

        return redirect()->route('medico.pagos.show', $pago)
            ->with('success', 'Recibo actualizado correctamente.');
    }

    public function pdf(Factura $pago)
    {
        $medico = Auth::user()->medico;
        if ($pago->medico_id !== $medico->id) abort(403);
        $pago->load(['paciente', 'items', 'medico.especialidad', 'clinica']);

        $config = ConfiguracionMedico::where('medico_id', $pago->medico_id)->first();

        $logoBase64      = $this->imagenBase64($config->logo ?? null);
        $logoFondoBase64 = $logoBase64;
        $firmaBase64     = $this->imagenBase64($config->firma ?? null);

        $factura = $pago;

       $pdf = Pdf::loadView('medico.pagos.pdf', compact('factura', 'logoBase64', 'logoFondoBase64', 'firmaBase64'))
           ->setOptions([
               'isRemoteEnabled' => true,
               'defaultFont'     => 'Arial',
               'margin_top'      => 0,
               'margin_bottom'   => 0,
               'margin_left'     => 0,
               'margin_right'    => 0,
               'isGdEnabled'     => false,
           ])
           ->setPaper('letter', 'portrait');

        return $pdf->stream('recibo-' . $pago->folio . '.pdf');
    }

    public function enviarCorreo(Request $request, Factura $pago)
    {
        $medico = Auth::user()->medico;
        if ($pago->medico_id !== $medico->id) abort(403);

        $request->validate([
            'email_destino' => 'required|email',
        ]);

        $pago->load(['paciente', 'items', 'medico.especialidad', 'clinica']);

        if ($request->guardar_email) {
            $pago->paciente->update(['email' => $request->email_destino]);
        }

        Mail::to($request->email_destino)->send(new ReciboPacienteMail($pago));

        return back()->with('success', '✓ Recibo enviado a ' . $request->email_destino);
    }

    public function subirLogo(Request $request)
    {
        $request->validate(['logo' => 'required|image|max:2048']);
        $medico = Auth::user()->medico;
        $path = $request->file('logo')->store('medicos/logos', 'public');
        $medico->update(['logo' => $path]);
        return back()->with('success', 'Logo actualizado correctamente.');
    }

    public function subirFirma(Request $request)
    {
        $request->validate(['firma' => 'required|image|max:2048']);
        $medico = Auth::user()->medico;
        $path = $request->file('firma')->store('medicos/firmas', 'public');
        $medico->update(['firma' => $path]);
        return back()->with('success', 'Firma actualizada correctamente.');
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
}