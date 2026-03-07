@extends('layouts.panel')

@section('titulo', 'Consulta — ' . $historial->fecha->format('d/m/Y'))

@section('contenido')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('historial.index') }}" class="text-slate-400 hover:text-slate-600">
        <x-heroicon-o-arrow-left class="w-5 h-5"/>
    </a>
    <h2 class="text-lg font-semibold text-slate-800">Detalle de consulta</h2>
    <a href="{{ route('historial.edit', $historial) }}"
        style="margin-left:auto; display:flex; align-items:center; gap:8px; background:#f59e0b; color:white; padding:8px 16px; border-radius:8px; font-size:14px; font-weight:500; text-decoration:none;">
        <x-heroicon-o-pencil class="w-4 h-4"/>
        Editar
    </a>
</div>

<div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; padding:0 8px;">

    <!-- Paciente -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-semibold text-slate-700 mb-4">Paciente</h4>
        <div class="flex items-center gap-3 mb-3">
            <div class="bg-teal-500 rounded-full w-10 h-10 flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr($historial->paciente->nombre, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-slate-800">{{ $historial->paciente->nombre_completo }}</p>
                <p class="text-xs text-slate-400">{{ $historial->paciente->numero_expediente }}</p>
            </div>
        </div>
        <a href="{{ route('pacientes.show', $historial->paciente) }}" class="text-teal-600 text-sm">Ver expediente →</a>
    </div>

    <!-- Médico y fecha -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-semibold text-slate-700 mb-4">Médico</h4>
        <div class="flex items-center gap-3 mb-3">
            <div class="bg-blue-500 rounded-full w-10 h-10 flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr($historial->medico->nombre, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-slate-800">Dr. {{ $historial->medico->nombre_completo }}</p>
                <p class="text-xs text-slate-400">{{ $historial->fecha->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Signos vitales -->
    @if($historial->peso || $historial->temperatura || $historial->presion_sistolica)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-semibold text-slate-700 mb-4">Signos Vitales</h4>
        <div style="display:grid; grid-template-columns: repeat(3,1fr); gap:12px;">
            @if($historial->peso)
            <div class="bg-blue-50 rounded-lg p-3 text-center">
                <p class="text-xs text-slate-500">Peso</p>
                <p class="text-lg font-bold text-slate-800">{{ $historial->peso }}</p>
                <p class="text-xs text-slate-400">kg</p>
            </div>
            @endif
            @if($historial->talla)
            <div class="bg-green-50 rounded-lg p-3 text-center">
                <p class="text-xs text-slate-500">Talla</p>
                <p class="text-lg font-bold text-slate-800">{{ $historial->talla }}</p>
                <p class="text-xs text-slate-400">cm</p>
            </div>
            @endif
            @if($historial->temperatura)
            <div class="bg-orange-50 rounded-lg p-3 text-center">
                <p class="text-xs text-slate-500">Temperatura</p>
                <p class="text-lg font-bold text-slate-800">{{ $historial->temperatura }}</p>
                <p class="text-xs text-slate-400">°C</p>
            </div>
            @endif
            @if($historial->presion_sistolica)
            <div class="bg-red-50 rounded-lg p-3 text-center">
                <p class="text-xs text-slate-500">Presión</p>
                <p class="text-lg font-bold text-slate-800">{{ $historial->presion }}</p>
                <p class="text-xs text-slate-400">mmHg</p>
            </div>
            @endif
            @if($historial->frecuencia_cardiaca)
            <div class="bg-purple-50 rounded-lg p-3 text-center">
                <p class="text-xs text-slate-500">Frec. Cardíaca</p>
                <p class="text-lg font-bold text-slate-800">{{ $historial->frecuencia_cardiaca }}</p>
                <p class="text-xs text-slate-400">bpm</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Consulta -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-semibold text-slate-700 mb-4">Consulta</h4>
        <div class="space-y-3 text-sm">
            <div>
                <p class="text-xs text-slate-500 uppercase font-semibold mb-1">Motivo</p>
                <p class="text-slate-800">{{ $historial->motivo_consulta }}</p>
            </div>
            @if($historial->sintomas)
            <div>
                <p class="text-xs text-slate-500 uppercase font-semibold mb-1">Síntomas</p>
                <p class="text-slate-800">{{ $historial->sintomas }}</p>
            </div>
            @endif
            @if($historial->exploracion_fisica)
            <div>
                <p class="text-xs text-slate-500 uppercase font-semibold mb-1">Exploración física</p>
                <p class="text-slate-800">{{ $historial->exploracion_fisica }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Diagnóstico y tratamiento -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 col-span-2" style="grid-column: span 2;">
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px;">
            <div>
                <p class="text-xs text-slate-500 uppercase font-semibold mb-2">Diagnóstico</p>
                <p class="text-slate-800 text-sm leading-relaxed">{{ $historial->diagnostico }}</p>
            </div>
            @if($historial->tratamiento)
            <div>
                <p class="text-xs text-slate-500 uppercase font-semibold mb-2">Tratamiento</p>
                <p class="text-slate-800 text-sm leading-relaxed">{{ $historial->tratamiento }}</p>
            </div>
            @endif
        </div>
        @if($historial->observaciones)
        <div class="mt-4 pt-4 border-t border-gray-100">
            <p class="text-xs text-slate-500 uppercase font-semibold mb-2">Observaciones</p>
            <p class="text-slate-800 text-sm leading-relaxed">{{ $historial->observaciones }}</p>
        </div>
        @endif
    </div>

</div>

@endsection
