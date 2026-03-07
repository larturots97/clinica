@extends('layouts.panel')

@section('titulo', 'Citas / Agenda')

@section('contenido')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-800">Agenda de Citas</h2>
        <p class="text-sm text-slate-500">Total: {{ $citas->total() }} citas</p>
    </div>
    <a href="{{ route('citas.create') }}"
        class="flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
        <x-heroicon-o-plus class="w-4 h-4"/>
        Nueva Cita
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Fecha y Hora</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Paciente</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Médico</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Motivo</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Estado</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($citas as $cita)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-6 py-4">
                    <p class="font-medium text-slate-800">{{ $cita->fecha_hora->format('d/m/Y') }}</p>
                    <p class="text-xs text-slate-400">{{ $cita->fecha_hora->format('H:i') }} — {{ $cita->duracion_minutos }} min</p>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <div class="bg-teal-100 rounded-full w-7 h-7 flex items-center justify-center text-teal-700 font-bold text-xs">
                            {{ strtoupper(substr($cita->paciente->nombre, 0, 1)) }}
                        </div>
                        <span class="text-slate-700">{{ $cita->paciente->nombre_completo }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-slate-600">Dr. {{ $cita->medico->nombre_completo }}</td>
                <td class="px-6 py-4 text-slate-600">{{ $cita->motivo ?? '—' }}</td>
                <td class="px-6 py-4">
                    @php
                        $colores = [
                            'pendiente'  => 'bg-yellow-50 text-yellow-700',
                            'confirmada' => 'bg-blue-50 text-blue-700',
                            'en_curso'   => 'bg-purple-50 text-purple-700',
                            'completada' => 'bg-green-50 text-green-700',
                            'cancelada'  => 'bg-red-50 text-red-700',
                        ];
                    @endphp
                    <span class="px-2 py-1 rounded text-xs font-medium {{ $colores[$cita->estado] ?? '' }}">
                        {{ ucfirst($cita->estado) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('citas.show', $cita) }}" class="text-blue-600 hover:text-blue-800">
                            <x-heroicon-o-eye class="w-4 h-4"/>
                        </a>
                        <a href="{{ route('citas.edit', $cita) }}" class="text-amber-600 hover:text-amber-800">
                            <x-heroicon-o-pencil class="w-4 h-4"/>
                        </a>
                        <form method="POST" action="{{ route('citas.destroy', $cita) }}"
                            onsubmit="return confirm('¿Eliminar esta cita?')">
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
                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                    <x-heroicon-o-calendar class="w-6 h-6 text-slate-400 mx-auto mb-1"/>
                    <p class="text-3xl mb-2"></p>
                    <p>No hay citas registradas</p>
                    <a href="{{ route('citas.create') }}" class="text-teal-600 hover:underline text-sm mt-1 inline-block">
                        Agendar primera cita
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($citas->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $citas->links() }}
    </div>
    @endif
</div>

@endsection
