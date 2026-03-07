@extends('layouts.panel')

@section('titulo', 'Dr. ' . $medico->nombre_completo)

@section('contenido')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('medicos.index') }}" class="text-slate-400 hover:text-slate-600">
        <x-heroicon-o-arrow-left class="w-5 h-5"/>
    </a>
    <h2 class="text-lg font-semibold text-slate-800">Perfil del médico</h2>
    <a href="{{ route('medicos.edit', $medico) }}"
        style="margin-left:auto; display:flex; align-items:center; gap:8px; background:#f59e0b; color:white; padding:8px 16px; border-radius:8px; font-size:14px; font-weight:500; text-decoration:none;">
        <x-heroicon-o-pencil class="w-4 h-4"/>
        Editar
    </a>
</div>

<div style="display:grid; grid-template-columns: 280px 1fr; gap:24px; align-items:start; padding:0 8px;">

    <!-- Columna izquierda -->
    <div style="display:flex; flex-direction:column; gap:16px;">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
            <div class="bg-blue-500 rounded-full w-20 h-20 flex items-center justify-center text-white text-3xl font-bold mx-auto mb-3">
                {{ strtoupper(substr($medico->nombre, 0, 1)) }}
            </div>
            <h3 class="text-lg font-bold text-slate-800">Dr. {{ $medico->nombre_completo }}</h3>
            <span class="inline-block mt-1 bg-purple-50 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">
                {{ $medico->especialidad->nombre }}
            </span>
            @if($medico->activo)
                <div class="mt-2">
                    <span class="inline-block bg-green-50 text-green-700 px-3 py-1 rounded-full text-xs font-medium">Activo</span>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-sm font-semibold text-slate-700 mb-4">Información</h4>
            <div class="space-y-3 text-sm text-slate-600 px-2">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-phone class="w-4 h-4 text-slate-400 flex-shrink-0"/>
                    <span>{{ $medico->telefono ?? 'No registrado' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <x-heroicon-o-envelope class="w-4 h-4 text-slate-400 flex-shrink-0"/>
                    <span class="truncate">{{ $medico->user->email ?? '' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <x-heroicon-o-identification class="w-4 h-4 text-slate-400 flex-shrink-0"/>
                    <span>Cédula: {{ $medico->cedula_profesional ?? 'No registrada' }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Columna derecha -->
    <div style="display:flex; flex-direction:column; gap:16px;">

        @if($medico->biografia)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-sm font-semibold text-slate-700 mb-3">Biografía</h4>
            <p class="text-sm text-slate-600 leading-relaxed">{{ $medico->biografia }}</p>
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-sm font-semibold text-slate-700 mb-4">Citas recientes</h4>
            @forelse($medico->citas as $cita)
            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                <div>
                    <p class="text-sm font-medium text-slate-700">{{ $cita->paciente->nombre_completo }}</p>
                    <p class="text-xs text-slate-400">{{ $cita->fecha_hora->format('d/m/Y H:i') }}</p>
                </div>
                <span class="text-xs px-2 py-1 rounded bg-slate-100 text-slate-600">{{ $cita->estado }}</span>
            </div>
            @empty
           <div class="text-center py-8 text-slate-400">
                <x-heroicon-o-calendar class="w-6 h-6 text-slate-400 mx-auto mb-1"/>
                <p class="text-3xl mb-2"></p>
                <p class="text-sm">Sin citas registradas</p>
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection
