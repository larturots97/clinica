@extends('layouts.panel')

@section('titulo', 'Comprobantes de Pago')

@section('contenido')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-800">Comprobantes de Pago</h2>
        <p class="text-sm text-slate-500">Total: {{ $facturas->total() }} facturas</p>
    </div>
    <a href="{{ route('facturas.create') }}"
        class="flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
        <x-heroicon-o-plus class="w-4 h-4"/>
        Nuevo Comprobante
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Folio</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Fecha</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Paciente</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Total</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Estado</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Método Pago</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($facturas as $factura)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-6 py-4">
                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-mono font-bold">
                        {{ $factura->folio }}
                    </span>
                </td>
                <td class="px-6 py-4 text-slate-700">{{ $factura->fecha->format('d/m/Y') }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <div class="bg-teal-100 rounded-full w-7 h-7 flex items-center justify-center text-teal-700 font-bold text-xs">
                            {{ strtoupper(substr($factura->paciente->nombre, 0, 1)) }}
                        </div>
                        <span class="text-slate-700">{{ $factura->paciente->nombre_completo }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 font-semibold text-slate-800">${{ number_format($factura->total, 2) }}</td>
                <td class="px-6 py-4">
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
                </td>
                <td class="px-6 py-4 text-slate-600">{{ ucfirst($factura->metodo_pago ?? '—') }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('facturas.show', $factura) }}" class="text-blue-600 hover:text-blue-800">
                            <x-heroicon-o-eye class="w-4 h-4"/>
                        </a>
                        <a href="{{ route('facturas.pdf', $factura) }}" class="text-green-600 hover:text-green-800" target="_blank">
                            <x-heroicon-o-document-arrow-down class="w-4 h-4"/>
                        </a>
                        <a href="{{ route('facturas.edit', $factura) }}" class="text-amber-600 hover:text-amber-800">
                            <x-heroicon-o-pencil class="w-4 h-4"/>
                        </a>
                        <form method="POST" action="{{ route('facturas.destroy', $factura) }}"
                            onsubmit="return confirm('¿Eliminar esta factura?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <x-heroicon-o-trash class="w-4 h-4"/>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                    <x-heroicon-o-document-text class="w-12 h-12 mx-auto mb-3 text-slate-300"/>
                    <p>No hay facturas registradas</p>
                    <a href="{{ route('facturas.create') }}" class="text-teal-600 hover:underline text-sm mt-1 inline-block">
                        Crear primera factura
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($facturas->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $facturas->links() }}
    </div>
    @endif
</div>

@endsection
