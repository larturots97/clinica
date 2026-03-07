@extends('layouts.panel')

@section('titulo', 'Factura — ' . $factura->folio)

@section('contenido')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('facturas.index') }}" class="text-slate-400 hover:text-slate-600">
        <x-heroicon-o-arrow-left class="w-5 h-5"/>
    </a>
    <h2 class="text-lg font-semibold text-slate-800">Factura {{ $factura->folio }}</h2>
    <div style="margin-left:auto; display:flex; gap:8px;">
        <a href="{{ route('facturas.pdf', $factura) }}" target="_blank"
            style="display:flex; align-items:center; gap:8px; background:#16a34a; color:white; padding:8px 16px; border-radius:8px; font-size:14px; font-weight:500; text-decoration:none;">
            <x-heroicon-o-document-arrow-down class="w-4 h-4"/>
            Descargar PDF
        </a>
        <a href="{{ route('facturas.edit', $factura) }}"
            style="display:flex; align-items:center; gap:8px; background:#f59e0b; color:white; padding:8px 16px; border-radius:8px; font-size:14px; font-weight:500; text-decoration:none;">
            <x-heroicon-o-pencil class="w-4 h-4"/>
            Editar
        </a>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; padding:0 8px;">

    <!-- Paciente -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-semibold text-slate-700 mb-4">Paciente</h4>
        <div class="flex items-center gap-3">
            <div class="bg-teal-500 rounded-full w-10 h-10 flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr($factura->paciente->nombre, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-slate-800">{{ $factura->paciente->nombre_completo }}</p>
                <p class="text-xs text-slate-400">{{ $factura->paciente->numero_expediente }}</p>
            </div>
        </div>
    </div>

    <!-- Datos factura -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-semibold text-slate-700 mb-4">Datos de la Factura</h4>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-slate-500">Folio:</span>
                <span class="font-mono font-bold text-blue-700">{{ $factura->folio }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Fecha:</span>
                <span class="font-medium">{{ $factura->fecha->format('d/m/Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Estado:</span>
                @php
                    $colores = [
                        'pendiente' => 'bg-yellow-50 text-yellow-700',
                        'pagada'    => 'bg-green-50 text-green-700',
                        'cancelada' => 'bg-red-50 text-red-700',
                    ];
                @endphp
                <span class="px-2 py-1 rounded text-xs font-medium {{ $colores[$factura->estado] ?? '' }}">
                    {{ ucfirst($factura->estado) }}
                </span>
            </div>
            @if($factura->metodo_pago)
            <div class="flex justify-between">
                <span class="text-slate-500">Método de pago:</span>
                <span class="font-medium">{{ ucfirst($factura->metodo_pago) }}</span>
            </div>
            @endif
        </div>
    </div>

    <!-- Conceptos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" style="grid-column: span 2;">
        <h4 class="text-sm font-semibold text-slate-700 mb-4">Conceptos</h4>
        <table class="w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="text-left px-4 py-2 text-slate-600">Concepto</th>
                    <th class="text-left px-4 py-2 text-slate-600">Descripción</th>
                    <th class="text-center px-4 py-2 text-slate-600">Cantidad</th>
                    <th class="text-right px-4 py-2 text-slate-600">Precio Unit.</th>
                    <th class="text-right px-4 py-2 text-slate-600">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($factura->items as $item)
                <tr>
                    <td class="px-4 py-3 font-medium text-slate-800">{{ $item->concepto }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $item->descripcion ?? '—' }}</td>
                    <td class="px-4 py-3 text-center text-slate-700">{{ $item->cantidad }}</td>
                    <td class="px-4 py-3 text-right text-slate-700">${{ number_format($item->precio_unitario, 2) }}</td>
                    <td class="px-4 py-3 text-right font-medium text-slate-800">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totales -->
        <div class="flex justify-end mt-4">
            <div class="w-64 space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Subtotal:</span>
                    <span class="font-medium">${{ number_format($factura->subtotal, 2) }}</span>
                </div>
                @if($factura->descuento > 0)
                <div class="flex justify-between text-red-600">
                    <span>Descuento:</span>
                    <span>-${{ number_format($factura->descuento, 2) }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-slate-500">IVA (16%):</span>
                    <span class="font-medium">${{ number_format($factura->impuesto, 2) }}</span>
                </div>
                <div class="flex justify-between text-base font-bold border-t border-gray-200 pt-2">
                    <span>Total:</span>
                    <span class="text-teal-600">${{ number_format($factura->total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    @if($factura->notas)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" style="grid-column: span 2;">
        <h4 class="text-sm font-semibold text-slate-700 mb-3">Notas</h4>
        <p class="text-sm text-slate-600">{{ $factura->notas }}</p>
    </div>
    @endif

</div>

@endsection
