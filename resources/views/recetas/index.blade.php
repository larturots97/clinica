@extends('layouts.panel')

@section('titulo', 'Recetas')

@section('contenido')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-800">Recetas Médicas</h2>
        <p class="text-sm text-slate-500">Total: {{ $recetas->total() }} recetas</p>
    </div>
    <a href="{{ route('recetas.create') }}"
        class="flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
        <x-heroicon-o-plus class="w-4 h-4"/>
        Nueva Receta
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Folio</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Fecha</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Paciente</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Médico</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Medicamentos</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($recetas as $receta)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-6 py-4">
                    <span class="bg-purple-50 text-purple-700 px-2 py-1 rounded text-xs font-mono font-bold">
                        {{ $receta->folio }}
                    </span>
                </td>
                <td class="px-6 py-4 text-slate-700">{{ $receta->fecha->format('d/m/Y') }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <div class="bg-teal-100 rounded-full w-7 h-7 flex items-center justify-center text-teal-700 font-bold text-xs">
                            {{ strtoupper(substr($receta->paciente->nombre, 0, 1)) }}
                        </div>
                        <span class="text-slate-700">{{ $receta->paciente->nombre_completo }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-slate-600">Dr. {{ $receta->medico->nombre_completo }}</td>
                <td class="px-6 py-4 text-slate-600">{{ $receta->items->count() }} medicamento(s)</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('recetas.show', $receta) }}" class="text-blue-600 hover:text-blue-800">
                            <x-heroicon-o-eye class="w-4 h-4"/>
                        </a>
                        <a href="{{ route('recetas.pdf', $receta) }}" class="text-green-600 hover:text-green-800" target="_blank">
                            <x-heroicon-o-document-arrow-down class="w-4 h-4"/>
                        </a>
                        <a href="{{ route('recetas.edit', $receta) }}" class="text-amber-600 hover:text-amber-800">
                            <x-heroicon-o-pencil class="w-4 h-4"/>
                        </a>
                        <form method="POST" action="{{ route('recetas.destroy', $receta) }}"
                            onsubmit="return confirm('¿Eliminar esta receta?')">
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
                    <p>No hay recetas registradas</p>
                    <a href="{{ route('recetas.create') }}" class="text-teal-600 hover:underline text-sm mt-1 inline-block">
                        Crear primera receta
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($recetas->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $recetas->links() }}
    </div>
    @endif
</div>

@endsection
