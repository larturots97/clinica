@extends('layouts.panel')

@section('titulo', 'Expediente — ' . $paciente->nombre_completo)

@section('contenido')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('pacientes.index') }}" class="text-slate-400 hover:text-slate-600">
        <x-heroicon-o-arrow-left class="w-5 h-5"/>
    </a>
    <h2 class="text-lg font-semibold text-slate-800">Expediente del paciente</h2>
    <a href="{{ route('pacientes.edit', $paciente) }}"
        style="margin-left:auto; display:flex; align-items:center; gap:8px; background:#f59e0b; color:white; padding: 8px 16px; border-radius:8px; font-size:14px; font-weight:500; text-decoration:none;">
        <x-heroicon-o-pencil class="w-4 h-4"/>
        Editar
    </a>
</div>

<div style="display:grid; grid-template-columns: 280px 1fr; gap: 24px; align-items: start;">

    <!-- Columna izquierda -->
    <div style="display:flex; flex-direction:column; gap:16px;">

        <!-- Foto y datos básicos -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
            <div class="bg-teal-500 rounded-full w-20 h-20 flex items-center justify-center text-white text-3xl font-bold mx-auto mb-3">
                {{ strtoupper(substr($paciente->nombre, 0, 1)) }}
            </div>
            <h3 class="text-lg font-bold text-slate-800">{{ $paciente->nombre_completo }}</h3>
            <span class="inline-block mt-1 bg-teal-50 text-teal-700 px-3 py-1 rounded-full text-xs font-mono font-bold">
                {{ $paciente->numero_expediente }}
            </span>
            @if($paciente->tipo_sangre)
            <div class="mt-3">
                <span class="inline-block bg-red-50 text-red-700 px-3 py-1 rounded-full text-sm font-bold border border-red-200">
                    {{ $paciente->tipo_sangre }}
                </span>
            </div>
            @endif
        </div>

        <!-- Contacto -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-sm font-semibold text-slate-700 mb-4">Contacto</h4>
            <div class="space-y-3 text-sm text-slate-600 px-2">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-phone class="w-4 h-4 text-slate-400 flex-shrink-0"/>
                    <span>{{ $paciente->telefono ?? 'No registrado' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <x-heroicon-o-envelope class="w-4 h-4 text-slate-400 flex-shrink-0"/>
                    <span class="truncate">{{ $paciente->email ?? 'No registrado' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <x-heroicon-o-map-pin class="w-4 h-4 text-slate-400 flex-shrink-0"/>
                    <span>{{ $paciente->direccion ?? 'No registrada' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <x-heroicon-o-cake class="w-4 h-4 text-slate-400 flex-shrink-0"/>
                    <span>{{ $paciente->fecha_nacimiento?->format('d/m/Y') ?? 'No registrada' }}</span>
                </div>
            </div>
        </div>

        <!-- Alergias -->
        @if($paciente->alergias)
        <div class="bg-red-50 rounded-xl border border-red-200 p-4">
            <h4 class="text-sm font-semibold text-red-700 mb-2 flex items-center gap-2">
                <x-heroicon-o-exclamation-triangle class="w-4 h-4"/>
                Alergias
            </h4>
            <p class="text-sm text-red-600">{{ $paciente->alergias }}</p>
        </div>
        @endif

    </div>

    <!-- Columna derecha -->
    <div style="display:flex; flex-direction:column; gap:16px;">

        <!-- Acciones rápidas -->
        <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:12px;">
            <a href="#" class="bg-white rounded-xl border border-gray-200 p-4 text-center hover:border-teal-300 hover:bg-teal-50 transition">
                <x-heroicon-o-calendar class="w-6 h-6 text-teal-500 mx-auto mb-1"/>
                <p class="text-xs font-medium text-slate-700">Nueva Cita</p>
            </a>
            <a href="#" class="bg-white rounded-xl border border-gray-200 p-4 text-center hover:border-blue-300 hover:bg-blue-50 transition">
                <x-heroicon-o-clipboard-document-list class="w-6 h-6 text-blue-500 mx-auto mb-1"/>
                <p class="text-xs font-medium text-slate-700">Ver Historial</p>
            </a>
            <a href="#" class="bg-white rounded-xl border border-gray-200 p-4 text-center hover:border-purple-300 hover:bg-purple-50 transition">
                <x-heroicon-o-document-text class="w-6 h-6 text-purple-500 mx-auto mb-1"/>
                <p class="text-xs font-medium text-slate-700">Nueva Receta</p>
            </a>
        </div>

        <!-- Antecedentes -->
        @if($paciente->antecedentes)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-sm font-semibold text-slate-700 mb-3">Antecedentes médicos</h4>
            <p class="text-sm text-slate-600 leading-relaxed">{{ $paciente->antecedentes }}</p>
        </div>
        @endif

        <!-- Citas recientes -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-sm font-semibold text-slate-700 mb-4">Citas recientes</h4>
            <div class="text-center py-8 text-slate-400">
                <x-heroicon-o-calendar class="w-6 h-6 text-slate-400 mx-auto mb-1"/>
                <p class="text-3xl mb-2"></p>
                <p class="text-sm">Sin citas registradas</p>
            </div>
        </div>

    </div>
</div>

@endsection