@extends('layouts.panel')

@section('titulo', $inventario->nombre)

@section('contenido')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('inventario.index') }}" class="text-slate-400 hover:text-slate-600">
        <x-heroicon-o-arrow-left class="w-5 h-5"/>
    </a>
    <h2 class="text-lg font-semibold text-slate-800">{{ $inventario->nombre }}</h2>
    <a href="{{ route('inventario.edit', $inventario) }}"
        style="margin-left:auto; display:flex; align-items:center; gap:8px; background:#f59e0b; color:white; padding:8px 16px; border-radius:8px; font-size:14px; font-weight:500; text-decoration:none;">
        <x-heroicon-o-pencil class="w-4 h-4"/>
        Editar
    </a>
</div>

<div style="display:grid; grid-template-columns: 280px 1fr; gap:24px; padding:0 8px;">

    <!-- Columna izquierda -->
    <div style="display:flex; flex-direction:column; gap:16px;">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
            <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
                <x-heroicon-o-archive-box class="w-8 h-8 text-purple-600"/>
            </div>
            <h3 class="font-bold text-slate-800">{{ $inventario->nombre }}</h3>
            @if($inventario->codigo)
            <p class="text-xs font-mono text-slate-400 mt-1">{{ $inventario->codigo }}</p>
            @endif
            @if($inventario->categoria)
            <span class="inline-block mt-2 bg-purple-50 text-purple-700 px-3 py-1 rounded-full text-xs">
                {{ $inventario->categoria }}
            </span>
            @endif
        </div>

        <!-- Stock -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-sm font-semibold text-slate-700 mb-4">Stock</h4>
            <div class="text-center mb-4">
                <p class="text-4xl font-bold {{ $inventario->bajo_stock ? 'text-red-600' : 'text-green-600' }}">
                    {{ $inventario->stock_actual }}
                </p>
                <p class="text-sm text-slate-400">{{ $inventario->unidad }}(s) disponibles</p>
                @if($inventario->bajo_stock)
                <span class="inline-block mt-2 bg-red-50 text-red-700 px-3 py-1 rounded-full text-xs font-medium">
                    Stock bajo
                </span>
                @endif
            </div>
            <div class="text-sm text-slate-600 space-y-1 px-2">
                <div class="flex justify-between">
                    <span>Mínimo:</span>
                    <span class="font-medium">{{ $inventario->stock_minimo }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Precio compra:</span>
                    <span class="font-medium">${{ number_format($inventario->precio_compra, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Precio venta:</span>
                    <span class="font-medium">${{ number_format($inventario->precio_venta, 2) }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Columna derecha -->
    <div style="display:flex; flex-direction:column; gap:16px;">

        <!-- Registrar movimiento -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-sm font-semibold text-slate-700 mb-4">Registrar Movimiento</h4>
            <form method="POST" action="{{ route('inventario.movimiento', $inventario) }}">
                @csrf
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs text-slate-600 mb-1">Tipo *</label>
                        <select name="tipo"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option value="entrada">Entrada</option>
                            <option value="salida">Salida</option>
                            <option value="ajuste">Ajuste</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-600 mb-1">Cantidad *</label>
                        <input type="number" name="cantidad" min="1" value="1"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-600 mb-1">Motivo</label>
                        <input type="text" name="motivo"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="Ej: Compra, Uso en consulta...">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit"
                        class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        Registrar movimiento
                    </button>
                </div>
            </form>
        </div>

        <!-- Historial de movimientos -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-sm font-semibold text-slate-700 mb-4">Historial de Movimientos</h4>
            @forelse($inventario->movimientos->take(10) as $movimiento)
            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0 text-sm">
                <div class="flex items-center gap-3">
                    @if($movimiento->tipo === 'entrada')
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">+{{ $movimiento->cantidad }}</span>
                    @elseif($movimiento->tipo === 'salida')
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">-{{ $movimiento->cantidad }}</span>
                    @else
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">={{ $movimiento->cantidad }}</span>
                    @endif
                    <div>
                        <p class="text-slate-700">{{ $movimiento->motivo ?? ucfirst($movimiento->tipo) }}</p>
                        <p class="text-xs text-slate-400">{{ $movimiento->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-400">{{ $movimiento->stock_anterior }} → <span class="font-medium text-slate-700">{{ $movimiento->stock_nuevo }}</span></p>
                </div>
            </div>
            @empty
            <div class="text-center py-6 text-slate-400">
                <p class="text-sm">Sin movimientos registrados</p>
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection
