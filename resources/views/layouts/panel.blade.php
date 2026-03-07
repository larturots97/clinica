<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} — @yield('titulo', 'Panel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0">

            <!-- Logo -->
            <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-700">
                <div class="bg-teal-500 rounded-lg p-2">
                    <x-heroicon-o-heart class="w-6 h-6 text-white"/>
                </div>
                <div>
                    <p class="font-bold text-white text-sm">Sistema Clínica</p>
                    <p class="text-slate-400 text-xs">Panel de gestión</p>
                </div>
            </div>

            <!-- Navegación -->
            <nav class="flex-1 px-4 py-4 overflow-y-auto space-y-1">

                <a href="/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->is('dashboard') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <x-heroicon-o-home class="w-5 h-5"/>
                    Dashboard
                </a>

                <div class="pt-3 pb-1 px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    Clínica
                </div>

                <a href="/pacientes" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->is('pacientes*') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <x-heroicon-o-users class="w-5 h-5"/>
                    Pacientes
                </a>

                <a href="/medicos" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->is('medicos*') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <x-heroicon-o-user-circle class="w-5 h-5"/>
                    Médicos
                </a>

                <a href="/citas" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->is('citas*') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <x-heroicon-o-calendar class="w-5 h-5"/>
                    Citas / Agenda
                </a>

                <a href="/historial" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->is('historial*') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <x-heroicon-o-clipboard-document-list class="w-5 h-5"/>
                    Historial Clínico
                </a>

                <a href="/recetas" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->is('recetas*') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <x-heroicon-o-document-text class="w-5 h-5"/>
                    Recetas
                </a>

               <div class="pt-3 pb-1 px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    Administración
                </div>

                <a href="/facturas" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->is('facturas*') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <x-heroicon-o-banknotes class="w-5 h-5"/>
                    Pagos
                </a>

                <a href="/inventario" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->is('inventario*') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <x-heroicon-o-archive-box class="w-5 h-5"/>
                    Inventario
                </a>

                <div class="pt-3 pb-1 px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    Especialidades
                </div>

              <!--  <a href="/estetica" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                  
                    <x-heroicon-o-sparkles class="w-5 h-5"/>
                    Medicina Estética
                </a>
            -->
                <div class="pt-3 pb-1 px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    Sistema
                </div>

                <a href="/roles" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->is('roles*') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <x-heroicon-o-shield-check class="w-5 h-5"/>
                    Roles y Permisos
                </a>

                <a href="/reportes" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->is('reportes*') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <x-heroicon-o-chart-bar class="w-5 h-5"/>
                    Reportes
                </a>

            </nav>

            <!-- Usuario -->
            <div class="px-4 py-4 border-t border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="bg-teal-500 rounded-full w-8 h-8 flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                        <p class="text-slate-400 text-xs truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Cerrar sesión">
                            <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5 text-slate-400 hover:text-white"/>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                <h1 class="text-xl font-semibold text-slate-800">@yield('titulo', 'Dashboard')</h1>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-slate-500">{{ now()->format('d/m/Y') }}</span>
                </div>
            </header>

            <!-- Página -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                        {{ session('error') }}
                    </div>
                @endif
                @yield('contenido')
            </main>

        </div>
    </div>

</body>
</html>
