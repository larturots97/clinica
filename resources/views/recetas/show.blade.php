@extends('layouts.panel')

@section('titulo', 'Receta — ' . $receta->folio)

@section('contenido')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('recetas.index') }}" class="text-slate-400 hover:text-slate-600">
        <x-heroicon-o-arrow-left class="w-5 h-5"/>
    </a>
    <h2 class="text-lg font-semibold text-slate-800">Receta {{ $receta->folio }}</h2>
    <div style="margin-left:auto; display:flex; gap:8px;">
        <a href="{{ route('recetas.pdf', $receta) }}" target="_blank"
            style="display:flex; align-items:center; gap:8px; background:#16a34a; color:white; padding:8px 16px; border-radius:8px; font-size:14px; font-weight:500; text-decoration:none;">
            <x-heroicon-o-document-arrow-down class="w-4 h-4"/>
            Descargar PDF
        </a>
        <a href="{{ route('recetas.edit', $receta) }}"
            style="display:flex; align-items:center; gap:8px; background:#f59e0b; color:white; padding:8px 16px; border-radius:8px; font-size:14px; font-weight:500; text-decoration:none;">
            <x-heroicon-o-pencil class="w-4 h-4"/>
            Editar
        </a>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; padding:0 8px;">

    <!-- Paciente -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-semibold text-slate-700 mb-4">Paciente</h4>
        <div class="flex items-center gap-3 mb-3">
            <div class="bg-teal-500 rounded-full w-10 h-10 flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr($receta->paciente->nombre, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-slate-800">{{ $receta->paciente->nombre_completo }}</p>
                <p class="text-xs text-slate-400">{{ $receta->paciente->numero_expediente }}</p>
            </div>
        </div>
        @if($receta->paciente->fecha_nacimiento)
        <p class="text-sm text-slate-500">Fecha de nacimiento: {{ $receta->paciente->fecha_nacimiento->format('d/m/Y') }}</p>
        @endif
    </div>

    <!-- Médico -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-semibold text-slate-700 mb-4">Médico</h4>
        <div class="flex items-center gap-3 mb-3">
            <div class="bg-blue-500 rounded-full w-10 h-10 flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr($receta->medico->nombre, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-slate-800">Dr. {{ $receta->medico->nombre_completo }}</p>
                <p class="text-xs text-slate-400">{{ $receta->medico->especialidad->nombre }}</p>
            </div>
        </div>
        <p class="text-sm text-slate-500">Cédula: {{ $receta->medico->cedula_profesional ?? 'No registrada' }}</p>
        <p class="text-sm text-slate-500">Fecha: {{ $receta->fecha->format('d/m/Y') }}</p>
    </div>

    @if($receta->diagnostico)
    <!-- Diagnóstico -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-semibold text-slate-700 mb-3">Diagnóstico</h4>
        <p class="text-sm text-slate-600">{{ $receta->diagnostico }}</p>
    </div>
    @endif

    @if($receta->indicaciones)
    <!-- Indicaciones -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-semibold text-slate-700 mb-3">Indicaciones Generales</h4>
        <p class="text-sm text-slate-600">{{ $receta->indicaciones }}</p>
    </div>
    @endif

    <!-- Medicamentos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" style="grid-column: span 2;">
        <h4 class="text-sm font-semibold text-slate-700 mb-4">Medicamentos Prescritos</h4>
        <div class="space-y-3">
            @foreach($receta->items as $i => $item)
            <div class="border border-gray-100 rounded-lg p-4 bg-slate-50">
                <div style="display:grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap:16px; align-items:start;">
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Medicamento</p>
                        <p class="font-semibold text-slate-800">{{ $i + 1 }}. {{ $item->medicamento }}</p>
                        @if($item->indicaciones)
                        <p class="text-xs text-slate-500 mt-1">{{ $item->indicaciones }}</p>
                        @endif
                    </div>
                    @if($item->dosis)
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Dosis</p>
                        <p class="text-sm font-medium text-slate-700">{{ $item->dosis }}</p>
                    </div>
                    @endif
                    @if($item->frecuencia)
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Frecuencia</p>
                        <p class="text-sm font-medium text-slate-700">{{ $item->frecuencia }}</p>
                    </div>
                    @endif
                    @if($item->duracion)
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Duración</p>
                        <p class="text-sm font-medium text-slate-700">{{ $item->duracion }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

@endsection
