@extends('layouts.panel')

@section('titulo', 'Nuevo Comprobante')

@section('contenido')

<div class="max-w-4xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('facturas.index') }}" class="text-slate-400 hover:text-slate-600">
            <x-heroicon-o-arrow-left class="w-5 h-5"/>
        </a>
        <h2 class="text-lg font-semibold text-slate-800">Nuevo Comprobante</h2>
    </div>

    <form method="POST" action="{{ route('facturas.store') }}">
        @csrf

        <div class="space-y-6">

            <!-- Datos generales -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                    Datos Generales
                </h3>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Paciente *</label>
                        <select name="paciente_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option value="">Seleccionar...</option>
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                        @error('paciente_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Médico</label>
                        <select name="medico_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option value="">Seleccionar...</option>
                            @foreach($medicos as $medico)
                                <option value="{{ $medico->id }}" {{ old('medico_id') == $medico->id ? 'selected' : '' }}>
                                    Dr. {{ $medico->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Fecha *</label>
                        <input type="date" name="fecha" value="{{ old('fecha', now()->format('Y-m-d')) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>
            </div>

            <!-- Conceptos -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4 pb-2 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider">Conceptos</h3>
                    <button type="button" id="agregar-concepto"
                        class="flex items-center gap-1 text-teal-600 hover:text-teal-800 text-sm font-medium">
                        <x-heroicon-o-plus class="w-4 h-4"/>
                        Agregar concepto
                    </button>
                </div>

                <div id="conceptos-container" class="space-y-3">
                    <div class="concepto-item border border-gray-200 rounded-lg p-4 bg-slate-50">
                        <div class="grid grid-cols-12 gap-3 items-end">
                            <div class="col-span-5">
                                <label class="block text-xs text-slate-600 mb-1">Concepto *</label>
                                <input type="text" name="conceptos[0][concepto]"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    placeholder="Ej: Consulta médica, Botox...">
                            </div>
                            <div class="col-span-3">
                                <label class="block text-xs text-slate-600 mb-1">Descripción</label>
                                <input type="text" name="conceptos[0][descripcion]"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    placeholder="Opcional">
                            </div>
                            <div class="col-span-1">
                                <label class="block text-xs text-slate-600 mb-1">Cantidad</label>
                                <input type="number" name="conceptos[0][cantidad]" value="1" min="1"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 text-center concepto-cantidad">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs text-slate-600 mb-1">Precio Unit.</label>
                                <input type="number" name="conceptos[0][precio_unitario]" value="0" min="0" step="0.01"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 concepto-precio">
                            </div>
                            <div class="col-span-1">
                                <label class="block text-xs text-slate-600 mb-1">Subtotal</label>
                                <p class="text-sm font-semibold text-slate-700 concepto-subtotal py-2">$0.00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Totales y descuento -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div style="display:grid; grid-template-columns: 1fr 300px; gap:24px;">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Notas</label>
                        <textarea name="notas" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="Notas adicionales...">{{ old('notas') }}</textarea>
                        <div class="mt-3 flex items-center gap-2">
                            <input type="checkbox" name="sin_impuesto" id="sin_impuesto" value="1" class="rounded">
                            <label for="sin_impuesto" class="text-sm text-slate-600">Sin IVA (16%)</label>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Subtotal:</span>
                            <span class="font-medium" id="resumen-subtotal">$0.00</span>
                        </div>
                        <div class="flex justify-between text-sm items-center">
                            <span class="text-slate-600">Descuento:</span>
                            <input type="number" name="descuento" id="descuento" value="0" min="0" step="0.01"
                                class="w-24 border border-gray-300 rounded px-2 py-1 text-sm text-right focus:outline-none focus:ring-1 focus:ring-teal-500">
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">IVA (16%):</span>
                            <span class="font-medium" id="resumen-impuesto">$0.00</span>
                        </div>
                        <div class="flex justify-between text-base font-bold border-t border-gray-200 pt-2 mt-2">
                            <span>Total:</span>
                            <span class="text-teal-600" id="resumen-total">$0.00</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="flex items-center gap-3 mt-6">
            <button type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                Crear factura
            </button>
            <a href="{{ route('facturas.index') }}"
                class="text-slate-600 hover:text-slate-800 px-4 py-2 rounded-lg text-sm font-medium border border-gray-300 transition">
                Cancelar
            </a>
        </div>

    </form>
</div>

<script>
let contador = 1;

function calcularTotales() {
    let subtotal = 0;
    document.querySelectorAll('.concepto-item').forEach(item => {
        const cantidad = parseFloat(item.querySelector('.concepto-cantidad').value) || 0;
        const precio   = parseFloat(item.querySelector('.concepto-precio').value) || 0;
        const sub      = cantidad * precio;
        item.querySelector('.concepto-subtotal').textContent = '$' + sub.toFixed(2);
        subtotal += sub;
    });

    const descuento   = parseFloat(document.getElementById('descuento').value) || 0;
    const sinImpuesto = document.getElementById('sin_impuesto').checked;
    const impuesto    = sinImpuesto ? 0 : (subtotal - descuento) * 0.16;
    const total       = subtotal - descuento + impuesto;

    document.getElementById('resumen-subtotal').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('resumen-impuesto').textContent = '$' + impuesto.toFixed(2);
    document.getElementById('resumen-total').textContent    = '$' + total.toFixed(2);
}

document.addEventListener('input', calcularTotales);
document.getElementById('sin_impuesto').addEventListener('change', calcularTotales);

document.getElementById('agregar-concepto').addEventListener('click', function() {
    const container = document.getElementById('conceptos-container');
    const div = document.createElement('div');
    div.className = 'concepto-item border border-gray-200 rounded-lg p-4 bg-slate-50';
    div.innerHTML = `
        <div class="grid grid-cols-12 gap-3 items-end">
            <div class="col-span-5">
                <label class="block text-xs text-slate-600 mb-1">Concepto *</label>
                <input type="text" name="conceptos[${contador}][concepto]"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                    placeholder="Ej: Consulta médica, Botox...">
            </div>
            <div class="col-span-3">
                <label class="block text-xs text-slate-600 mb-1">Descripción</label>
                <input type="text" name="conceptos[${contador}][descripcion]"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                    placeholder="Opcional">
            </div>
            <div class="col-span-1">
                <label class="block text-xs text-slate-600 mb-1">Cantidad</label>
                <input type="number" name="conceptos[${contador}][cantidad]" value="1" min="1"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 text-center concepto-cantidad">
            </div>
            <div class="col-span-2">
                <label class="block text-xs text-slate-600 mb-1">Precio Unit.</label>
                <input type="number" name="conceptos[${contador}][precio_unitario]" value="0" min="0" step="0.01"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 concepto-precio">
            </div>
            <div class="col-span-1">
                <label class="block text-xs text-slate-600 mb-1">Subtotal</label>
                <p class="text-sm font-semibold text-slate-700 concepto-subtotal py-2">$0.00</p>
            </div>
            <div class="col-span-12 text-right">
                <button type="button" class="text-red-500 hover:text-red-700 text-xs" onclick="this.closest('.concepto-item').remove(); calcularTotales();">
                    Eliminar
                </button>
            </div>
        </div>
    `;
    container.appendChild(div);
    contador++;
});
</script>

@endsection
