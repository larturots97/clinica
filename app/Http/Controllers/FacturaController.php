<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\FacturaItem;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\Clinica;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = Factura::with(['paciente', 'medico'])
            ->orderBy('fecha', 'desc')
            ->paginate(15);
        return view('facturas.index', compact('facturas'));
    }

    public function create()
    {
        $pacientes = Paciente::orderBy('nombre')->get();
        $medicos   = Medico::where('activo', true)->orderBy('nombre')->get();
        return view('facturas.create', compact('pacientes', 'medicos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha'       => 'required|date',
            'conceptos'   => 'required|array|min:1',
            'conceptos.*.concepto'        => 'required|string',
            'conceptos.*.cantidad'        => 'required|integer|min:1',
            'conceptos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        $clinica = Clinica::first();

        $subtotal = 0;
        foreach ($request->conceptos as $item) {
            $subtotal += $item['cantidad'] * $item['precio_unitario'];
        }

        $descuento = $request->descuento ?? 0;
        $impuesto  = round(($subtotal - $descuento) * 0.16, 2);
        $total     = $subtotal - $descuento + $impuesto;

        if ($request->sin_impuesto) {
            $impuesto = 0;
            $total    = $subtotal - $descuento;
        }

        $factura = Factura::create([
            'clinica_id'  => $clinica->id,
            'paciente_id' => $request->paciente_id,
            'medico_id'   => $request->medico_id ?? null,
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

        return redirect()->route('facturas.show', $factura)
            ->with('success', 'Factura creada exitosamente.');
    }

    public function show(Factura $factura)
    {
        $factura->load(['paciente', 'medico', 'items', 'clinica']);
        return view('facturas.show', compact('factura'));
    }

    public function edit(Factura $factura)
    {
        $pacientes = Paciente::orderBy('nombre')->get();
        $medicos   = Medico::where('activo', true)->orderBy('nombre')->get();
        $factura->load('items');
        return view('facturas.edit', compact('factura', 'pacientes', 'medicos'));
    }

    public function update(Request $request, Factura $factura)
    {
        $request->validate([
            'estado'      => 'required|in:pendiente,pagada,cancelada',
            'metodo_pago' => 'nullable|in:efectivo,tarjeta,transferencia,otro',
        ]);

        $factura->update([
            'estado'      => $request->estado,
            'metodo_pago' => $request->metodo_pago,
            'notas'       => $request->notas,
        ]);

        return redirect()->route('facturas.show', $factura)
            ->with('success', 'Factura actualizada exitosamente.');
    }

    public function destroy(Factura $factura)
    {
        $factura->delete();
        return redirect()->route('facturas.index')
            ->with('success', 'Factura eliminada exitosamente.');
    }

    public function pdf(Factura $factura)
    {
        $factura->load(['paciente', 'medico', 'items', 'clinica']);
        $pdf = Pdf::loadView('facturas.pdf', compact('factura'));
        return $pdf->stream('factura-' . $factura->folio . '.pdf');
    }
}