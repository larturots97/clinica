@extends('layouts.panel')

@section('titulo', 'Editar Factura')

@section('contenido')

<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('facturas.show', $factura) }}" class="text-slate-400 hover:text-slate-600">
            <x-heroicon-o-arrow-left class="w-5 h-5"/>
        </a>
        <h2 class="text-lg font-semibold text-slate-800">Editar Factura — {{ $factura->folio }}</h2>
    </div>

    <form method="POST" action="{{ route('facturas.update', $factura) }}">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
            <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                Estado y Pago
            </h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Estado *</label>
                    <select name="estado"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        @foreach(['pendiente','pagada','cancelada'] as $estado)
                            <option value="{{ $estado }}" {{ old('estado', $factura->estado) == $estado ? 'selected' : '' }}>
                                {{ ucfirst($estado) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Método de Pago</label>
                    <select name="metodo_pago"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="">Sin especificar</option>
                        @foreach(['efectivo','tarjeta','transferencia','otro'] as $metodo)
                            <option value="{{ $metodo }}" {{ old('metodo_pago', $factura->metodo_pago) == $metodo ? 'selected' : '' }}>
                                {{ ucfirst($metodo) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Notas</label>
                <textarea name="notas" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('notas', $factura->notas) }}</textarea>
            </div>

            <!-- Resumen -->
            <div class="bg-slate-50 rounded-lg p-4 space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Subtotal:</span>
                    <span>${{ number_format($factura->subtotal, 2) }}</span>
                </div>
                @if($factura->descuento > 0)
                <div class="flex justify-between text-red-600">
                    <span>Descuento:</span>
                    <span>-${{ number_format($factura->descuento, 2) }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-slate-500">IVA:</span>
                    <span>${{ number_format($factura->impuesto, 2) }}</span>
                </div>
                <div class="flex justify-between font-bold text-base border-t border-gray-200 pt-2">
                    <span>Total:</span>
                    <span class="text-teal-600">${{ number_format($factura->total, 2) }}</span>
                </div>
            </div>

        </div>

        <div class="flex items-center gap-3 mt-6">
            <button type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                Guardar cambios
            </button>
            <a href="{{ route('facturas.show', $factura) }}"
                class="text-slate-600 hover:text-slate-800 px-4 py-2 rounded-lg text-sm font-medium border border-gray-300 transition">
                Cancelar
            </a>
        </div>

    </form>
</div>

@endsection
