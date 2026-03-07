@extends('layouts.panel')

@section('titulo', 'Pacientes')

@section('contenido')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-800">Lista de Pacientes</h2>
        <p class="text-sm text-slate-500">Total: {{ $pacientes->total() }} pacientes</p>
    </div>
    <a href="{{ route('pacientes.create') }}"
        class="flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
        <x-heroicon-o-plus class="w-4 h-4"/>
        Nuevo Paciente
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Expediente</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Nombre</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Teléfono</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Email</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Tipo Sangre</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($pacientes as $paciente)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-6 py-4">
                    <span class="bg-teal-50 text-teal-700 px-2 py-1 rounded text-xs font-mono font-bold">
                        {{ $paciente->numero_expediente }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-slate-200 rounded-full w-8 h-8 flex items-center justify-center text-slate-600 font-bold text-xs">
                            {{ strtoupper(substr($paciente->nombre, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-medium text-slate-800">{{ $paciente->nombre_completo }}</p>
                            <p class="text-xs text-slate-400">{{ $paciente->fecha_nacimiento?->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-slate-600">{{ $paciente->telefono ?? '—' }}</td>
                <td class="px-6 py-4 text-slate-600">{{ $paciente->email ?? '—' }}</td>
                <td class="px-6 py-4">
                    @if($paciente->tipo_sangre)
                        <span class="bg-red-50 text-red-700 px-2 py-1 rounded text-xs font-bold">
                            {{ $paciente->tipo_sangre }}
                        </span>
                    @else
                        <span class="text-slate-400">—</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('pacientes.show', $paciente) }}"
                            class="text-blue-600 hover:text-blue-800">
                            <x-heroicon-o-eye class="w-4 h-4"/>
                        </a>
                        <a href="{{ route('pacientes.edit', $paciente) }}"
                            class="text-amber-600 hover:text-amber-800">
                            <x-heroicon-o-pencil class="w-4 h-4"/>
                        </a>
                        <form method="POST" action="{{ route('pacientes.destroy', $paciente) }}"
                            onsubmit="return confirm('¿Eliminar este paciente?')">
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
                    <x-heroicon-o-users class="w-12 h-12 mx-auto mb-3 text-slate-300"/>
                    <p>No hay pacientes registrados</p>
                    <a href="{{ route('pacientes.create') }}" class="text-teal-600 hover:underline text-sm mt-1 inline-block">
                        Registrar primer paciente
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($pacientes->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $pacientes->links() }}
    </div>
    @endif
</div>

@endsection
