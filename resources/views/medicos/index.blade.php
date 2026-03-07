@extends('layouts.panel')

@section('titulo', 'Médicos')

@section('contenido')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-800">Lista de Médicos</h2>
        <p class="text-sm text-slate-500">Total: {{ $medicos->total() }} médicos</p>
    </div>
    <a href="{{ route('medicos.create') }}"
        class="flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
        <x-heroicon-o-plus class="w-4 h-4"/>
        Nuevo Médico
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Médico</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Especialidad</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Cédula</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Teléfono</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Estado</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($medicos as $medico)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-100 rounded-full w-9 h-9 flex items-center justify-center text-blue-600 font-bold text-sm">
                            {{ strtoupper(substr($medico->nombre, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-medium text-slate-800">Dr. {{ $medico->nombre_completo }}</p>
                            <p class="text-xs text-slate-400">{{ $medico->user->email ?? '' }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="bg-purple-50 text-purple-700 px-2 py-1 rounded text-xs font-medium">
                        {{ $medico->especialidad->nombre }}
                    </span>
                </td>
                <td class="px-6 py-4 text-slate-600">{{ $medico->cedula_profesional ?? '—' }}</td>
                <td class="px-6 py-4 text-slate-600">{{ $medico->telefono ?? '—' }}</td>
                <td class="px-6 py-4">
                    @if($medico->activo)
                        <span class="bg-green-50 text-green-700 px-2 py-1 rounded text-xs font-medium">Activo</span>
                    @else
                        <span class="bg-red-50 text-red-700 px-2 py-1 rounded text-xs font-medium">Inactivo</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('medicos.show', $medico) }}" class="text-blue-600 hover:text-blue-800">
                            <x-heroicon-o-eye class="w-4 h-4"/>
                        </a>
                        <a href="{{ route('medicos.edit', $medico) }}" class="text-amber-600 hover:text-amber-800">
                            <x-heroicon-o-pencil class="w-4 h-4"/>
                        </a>
                        <form method="POST" action="{{ route('medicos.destroy', $medico) }}"
                            onsubmit="return confirm('¿Eliminar este médico?')">
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
                    <x-heroicon-o-user-circle class="w-12 h-12 mx-auto mb-3 text-slate-300"/>
                    <p>No hay médicos registrados</p>
                    <a href="{{ route('medicos.create') }}" class="text-teal-600 hover:underline text-sm mt-1 inline-block">
                        Registrar primer médico
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($medicos->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $medicos->links() }}
    </div>
    @endif
</div>

@endsection
