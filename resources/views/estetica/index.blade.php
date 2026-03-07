@extends('layouts.panel')

@section('titulo', 'Medicina Estética')

@section('contenido')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-800">Tratamientos Estéticos</h2>
        <p class="text-sm text-slate-500">Total: {{ $tratamientos->total() }} tratamientos</p>
    </div>
    @if(auth()->user()->hasRole('medico') && auth()->user()->medico?->especialidad?->nombre === 'Medicina Estética')
    <a href="{{ route('estetica.create') }}"
        class="flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
        <x-heroicon-o-plus class="w-4 h-4"/>
        Nuevo Tratamiento
    </a>
    @endif
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Fecha</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Paciente</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Médico</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Título</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Zonas</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($tratamientos as $tratamiento)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-6 py-4 text-slate-700">{{ $tratamiento->fecha->format('d/m/Y') }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <div class="bg-teal-100 rounded-full w-7 h-7 flex items-center justify-center text-teal-700 font-bold text-xs">
                            {{ strtoupper(substr($tratamiento->paciente->nombre, 0, 1)) }}
                        </div>
                        <span class="text-slate-700">{{ $tratamiento->paciente->nombre_completo }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-slate-600">Dr. {{ $tratamiento->medico->nombre_completo }}</td>
                <td class="px-6 py-4 text-slate-600">{{ $tratamiento->titulo ?? '—' }}</td>
                <td class="px-6 py-4">
                    <span class="bg-pink-50 text-pink-700 px-2 py-1 rounded text-xs font-medium">
                        {{ $tratamiento->zonas->count() }} zona(s)
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('estetica.show', $tratamiento) }}" class="text-blue-600 hover:text-blue-800">
                            <x-heroicon-o-eye class="w-4 h-4"/>
                        </a>
                        <form method="POST" action="{{ route('estetica.destroy', $tratamiento) }}"
                            onsubmit="return confirm('¿Eliminar este tratamiento?')">
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
                    <x-heroicon-o-sparkles class="w-12 h-12 mx-auto mb-3 text-slate-300"/>
                    <p>No hay tratamientos registrados</p>
                    <a href="{{ route('estetica.create') }}" class="text-teal-600 hover:underline text-sm mt-1 inline-block">
                        Registrar primer tratamiento
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($tratamientos->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $tratamientos->links() }}
    </div>
    @endif
</div>

@endsection
