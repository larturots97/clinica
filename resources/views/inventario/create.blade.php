@extends('layouts.panel')

@section('titulo', 'Nuevo Producto')

@section('contenido')

<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('inventario.index') }}" class="text-slate-400 hover:text-slate-600">
            <x-heroicon-o-arrow-left class="w-5 h-5"/>
        </a>
        <h2 class="text-lg font-semibold text-slate-800">Registrar nuevo producto</h2>
    </div>

    <form method="POST" action="{{ route('inventario.store') }}">
        @csrf

        <div class="space-y-6">

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                    Datos del Producto
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nombre *</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="Ej: Botox 100u, Ácido Hialurónico...">
                        @error('nombre')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Código</label>
                        <input type="text" name="codigo" value="{{ old('codigo') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="Ej: BOT-001">
                        @error('codigo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Categoría</label>
                        <input type="text" name="categoria" value="{{ old('categoria') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="Ej: Toxinas, Rellenos, Skincare...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Unidad *</label>
                        <select name="unidad"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option value="pieza">Pieza</option>
                            <option value="frasco">Frasco</option>
                            <option value="caja">Caja</option>
                            <option value="ampolleta">Ampolleta</option>
                            <option value="ml">ml</option>
                            <option value="unidad">Unidad</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Descripción</label>
                        <textarea name="descripcion" rows="2"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="Descripción opcional...">{{ old('descripcion') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                    Precios y Stock
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Precio de Compra</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-slate-400 text-sm">$</span>
                            <input type="number" step="0.01" name="precio_compra" value="{{ old('precio_compra', 0) }}"
                                class="w-full border border-gray-300 rounded-lg pl-6 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Precio de Venta</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-slate-400 text-sm">$</span>
                            <input type="number" step="0.01" name="precio_venta" value="{{ old('precio_venta', 0) }}"
                                class="w-full border border-gray-300 rounded-lg pl-6 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Stock Inicial *</label>
                        <input type="number" name="stock_actual" value="{{ old('stock_actual', 0) }}" min="0"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        @error('stock_actual')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Stock Mínimo *</label>
                        <input type="number" name="stock_minimo" value="{{ old('stock_minimo', 5) }}" min="0"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <p class="text-xs text-slate-400 mt-1">Alerta cuando el stock baje de este número</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="flex items-center gap-3 mt-6">
            <button type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                Registrar producto
            </button>
            <a href="{{ route('inventario.index') }}"
                class="text-slate-600 hover:text-slate-800 px-4 py-2 rounded-lg text-sm font-medium border border-gray-300 transition">
                Cancelar
            </a>
        </div>

    </form>
</div>

@endsection
