@extends('layouts.panel')

@section('titulo', 'Detalle de Cita')

@section('contenido')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('citas.index') }}" class="text-slate-400 hover:text-slate-600">
        <x-heroicon-o-arrow-left class="w-5 h-5"/>
    </a>
    <h2 class="text-lg font-semibold text-slate-800">Detalle de la cita</h2>
    <a href="{{ route('citas.edit', $cita) }}"
        style="margin-left:auto; display:flex; align-items:center; gap:8px; background:#f59e0b; color:white; padding:8px 16px; border-radius:8px; font-size:14px; font-weight:500; text-decoration:none;">
        <x-heroicon-o-pencil class="w-4 h-4"/>
        Editar
    </a>
</div>

<div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; padding:0 8px;">

    <!-- Paciente -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
            <x-heroicon-o-user class="w-4 h-4 text-teal-500"/>
            Paciente
        </h4>
        <div class="flex items-center gap-3 mb-4">
            <div class="bg-teal-500 rounded-full w-12 h-12 flex items-center justify-center text-white text-lg font-bold">
                {{ strtoupper(substr($cita->paciente->nombre, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-slate-800">{{ $cita->paciente->nombre_completo }}</p>
                <p class="text-xs text-slate-400">{{ $cita->paciente->numero_expediente }}</p>
            </div>
        </div>
        <a href="{{ route('pacientes.show', $cita->paciente) }}"
            class="text-teal-600 hover:text-teal-800 text-sm font-medium">
            Ver expediente →
        </a>
    </div>

    <!-- Médico -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
            <x-heroicon-o-user-circle class="w-4 h-4 text-blue-500"/>
            Médico
        </h4>
        <div class="flex items-center gap-3 mb-4">
            <div class="bg-blue-500 rounded-full w-12 h-12 flex items-center justify-center text-white text-lg font-bold">
                {{ strtoupper(substr($cita->medico->nombre, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-slate-800">Dr. {{ $cita->medico->nombre_completo }}</p>
                <p class="text-xs text-slate-400">{{ $cita->medico->especialidad->nombre }}</p>
            </div>
        </div>
    </div>

    <!-- Detalles de la cita -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
            <x-heroicon-o-calendar class="w-4 h-4 text-purple-500"/>
            Detalles
        </h4>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-slate-500">Fecha:</span>
                <span class="font-medium text-slate-800">{{ $cita->fecha_hora->format('d/m/Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Hora:</span>
                <span class="font-medium text-slate-800">{{ $cita->fecha_hora->format('H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Duración:</span>
                <span class="font-medium text-slate-800">{{ $cita->duracion_minutos }} minutos</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Estado:</span>
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
            </div>
            @if($cita->motivo)
            <div class="flex justify-between">
                <span class="text-slate-500">Motivo:</span>
                <span class="font-medium text-slate-800">{{ $cita->motivo }}</span>
            </div>
            @endif
        </div>
    </div>

    <!-- Notas -->
    @if($cita->notas)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
            <x-heroicon-o-document-text class="w-4 h-4 text-slate-400"/>
            Notas
        </h4>
        <p class="text-sm text-slate-600 leading-relaxed">{{ $cita->notas }}</p>
    </div>
    @endif

</div>

@endsection
