@extends('layouts.panel')

@section('titulo', 'Editar Receta')

@section('contenido')

<div class="max-w-4xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('recetas.show', $receta) }}" class="text-slate-400 hover:text-slate-600">
            <x-heroicon-o-arrow-left class="w-5 h-5"/>
        </a>
        <h2 class="text-lg font-semibold text-slate-800">Editar Receta — {{ $receta->folio }}</h2>
    </div>

    <form method="POST" action="{{ route('recetas.update', $receta) }}">
        @csrf
        @method('PUT')

        <div class="space-y-6">

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                    Datos de la Receta
                </h3>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Paciente *</label>
                        <select name="paciente_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ old('paciente_id', $receta->paciente_id) == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Médico *</label>
                        <select name="medico_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            @foreach($medicos as $medico)
                                <option value="{{ $medico->id }}" {{ old('medico_id', $receta->medico_id) == $medico->id ? 'selected' : '' }}>
                                    Dr. {{ $medico->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Fecha *</label>
                        <input type="date" name="fecha" value="{{ old('fecha', $receta->fecha->format('Y-m-d')) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Diagnóstico</label>
                    <input type="text" name="diagnostico" value="{{ old('diagnostico', $receta->diagnostico) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4 pb-2 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider">Medicamentos</h3>
                    <button type="button" id="agregar-medicamento"
                        class="flex items-center gap-1 text-teal-600 hover:text-teal-800 text-sm font-medium">
                        <x-heroicon-o-plus class="w-4 h-4"/>
                        Agregar medicamento
                    </button>
                </div>

                <div id="medicamentos-container" class="space-y-4">
                    @foreach($receta->items as $i => $item)
                    <div class="medicamento-item border border-gray-200 rounded-lg p-4 bg-slate-50">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-medium text-slate-700">Medicamento #{{ $i + 1 }}</span>
                            @if($i > 0)
                            <button type="button" class="text-red-500 hover:text-red-700 text-xs" onclick="this.closest('.medicamento-item').remove()">Eliminar</button>
                            @endif
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="col-span-2">
                                <label class="block text-xs text-slate-600 mb-1">Medicamento *</label>
                                <input type="text" name="medicamentos[{{ $i }}][medicamento]" value="{{ $item->medicamento }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-600 mb-1">Dosis</label>
                                <input type="text" name="medicamentos[{{ $i }}][dosis]" value="{{ $item->dosis }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-600 mb-1">Frecuencia</label>
                                <input type="text" name="medicamentos[{{ $i }}][frecuencia]" value="{{ $item->frecuencia }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-600 mb-1">Duración</label>
                                <input type="text" name="medicamentos[{{ $i }}][duracion]" value="{{ $item->duracion }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-600 mb-1">Indicaciones</label>
                                <input type="text" name="medicamentos[{{ $i }}][indicaciones]" value="{{ $item->indicaciones }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                    Indicaciones Generales
                </h3>
                <textarea name="indicaciones" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('indicaciones', $receta->indicaciones) }}</textarea>
            </div>

        </div>

        <div class="flex items-center gap-3 mt-6">
            <button type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                Guardar cambios
            </button>
            <a href="{{ route('recetas.show', $receta) }}"
                class="text-slate-600 hover:text-slate-800 px-4 py-2 rounded-lg text-sm font-medium border border-gray-300 transition">
                Cancelar
            </a>
        </div>

    </form>
</div>

<script>
let contador = {{ $receta->items->count() }};
document.getElementById('agregar-medicamento').addEventListener('click', function() {
    const container = document.getElementById('medicamentos-container');
    const div = document.createElement('div');
    div.className = 'medicamento-item border border-gray-200 rounded-lg p-4 bg-slate-50';
    div.innerHTML = `
        <div class="flex justify-between items-center mb-3">
            <span class="text-sm font-medium text-slate-700">Medicamento #${contador + 1}</span>
            <button type="button" class="text-red-500 hover:text-red-700 text-xs" onclick="this.closest('.medicamento-item').remove()">Eliminar</button>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div class="col-span-2">
                <label class="block text-xs text-slate-600 mb-1">Medicamento *</label>
                <input type="text" name="medicamentos[${contador}][medicamento]"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-xs text-slate-600 mb-1">Dosis</label>
                <input type="text" name="medicamentos[${contador}][dosis]"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-xs text-slate-600 mb-1">Frecuencia</label>
                <input type="text" name="medicamentos[${contador}][frecuencia]"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-xs text-slate-600 mb-1">Duración</label>
                <input type="text" name="medicamentos[${contador}][duracion]"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-xs text-slate-600 mb-1">Indicaciones</label>
                <input type="text" name="medicamentos[${contador}][indicaciones]"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
        </div>
    `;
    container.appendChild(div);
    contador++;
});
</script>

@endsection
