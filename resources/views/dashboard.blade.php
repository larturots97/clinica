@extends('layouts.panel')

@section('titulo', 'Dashboard')

@section('contenido')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <!-- Card Pacientes -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium">Pacientes</p>
                <p class="text-3xl font-bold text-slate-800 mt-1">0</p>
            </div>
            <div class="bg-blue-50 rounded-xl p-3">
                <x-heroicon-o-users class="w-7 h-7 text-blue-500"/>
            </div>
        </div>
    </div>

    <!-- Card Citas Hoy -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium">Citas hoy</p>
                <p class="text-3xl font-bold text-slate-800 mt-1">0</p>
            </div>
            <div class="bg-teal-50 rounded-xl p-3">
                <x-heroicon-o-calendar class="w-7 h-7 text-teal-500"/>
            </div>
        </div>
    </div>

    <!-- Card Médicos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium">Médicos activos</p>
                <p class="text-3xl font-bold text-slate-800 mt-1">0</p>
            </div>
            <div class="bg-purple-50 rounded-xl p-3">
                <x-heroicon-o-user-circle class="w-7 h-7 text-purple-500"/>
            </div>
        </div>
    </div>

    <!-- Card Ingresos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium">Ingresos del mes</p>
                <p class="text-3xl font-bold text-slate-800 mt-1">$0</p>
            </div>
            <div class="bg-green-50 rounded-xl p-3">
                <x-heroicon-o-banknotes class="w-7 h-7 text-green-500"/>
            </div>
        </div>
    </div>

</div>

<!-- Próximas citas -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h2 class="text-lg font-semibold text-slate-800 mb-4">Próximas citas del día</h2>
    <div class="text-center py-12 text-slate-400">
        <x-heroicon-o-calendar class="w-12 h-12 mx-auto mb-3 text-slate-300"/>
        <p class="text-sm">No hay citas programadas para hoy</p>
    </div>
</div>

@endsection