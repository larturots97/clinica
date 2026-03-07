@extends('layouts.panel')

@section('titulo', 'Editar Cita')

@section('contenido')

<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('citas.show', $cita) }}" class="text-slate-400 hover:text-slate-600">
            <x-heroicon-o-arrow-left class="w-5 h-5"/>
        </a>
        <h2 class="text-lg font-semibold text-slate-800">Editar cita</h2>
    </div>

    <form method="POST" action="{{ route('citas.update', $cita) }}">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">

            <div>
                <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                    Paciente y Médico
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Paciente *</label>
                        <select name="paciente_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ old('paciente_id', $cita->paciente_id) == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nombre_completo }} — {{ $paciente->numero_expediente }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Médico *</label>
                        <select name="medico_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            @foreach($medicos as $medico)
                                <option value="{{ $medico->id }}" {{ old('medico_id', $cita->medico_id) == $medico->id ? 'selected' : '' }}>
                                    Dr. {{ $medico->nombre_completo }} — {{ $medico->especialidad->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                    Fecha y Estado
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Fecha y hora *</label>
                        <input type="datetime-local" name="fecha_hora"
                            value="{{ old('fecha_hora', $cita->fecha_hora->format('Y-m-d\TH:i')) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Duración</label>
                        <select name="duracion_minutos"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            @foreach([15,30,45,60,90,120] as $min)
                                <option value="{{ $min }}" {{ old('duracion_minutos', $cita->duracion_minutos) == $min ? 'selected' : '' }}>
                                    {{ $min }} minutos
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Estado</label>
                        <select name="estado"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            @foreach(['pendiente','confirmada','en_curso','completada','cancelada'] as $estado)
                                <option value="{{ $estado }}" {{ old('estado', $cita->estado) == $estado ? 'selected' : '' }}>
                                    {{ ucfirst($estado) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Motivo</label>
                        <input type="text" name="motivo" value="{{ old('motivo', $cita->motivo) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Notas</label>
                    <textarea name="notas" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('notas', $cita->notas) }}</textarea>
                </div>
            </div>

        </div>

        <div class="flex items-center gap-3 mt-6">
            <button type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                Guardar cambios
            </button>
            <a href="{{ route('citas.show', $cita) }}"
                class="text-slate-600 hover:text-slate-800 px-4 py-2 rounded-lg text-sm font-medium border border-gray-300 transition">
                Cancelar
            </a>
        </div>

    </form>
</div>

@endsection
