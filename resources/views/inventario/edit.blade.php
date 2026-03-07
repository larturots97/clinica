@extends('layouts.panel')

@section('titulo', 'Editar Producto')

@section('contenido')

<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('inventario.show', $inventario) }}" class="text-slate-400 hover:text-slate-600">
            <x-heroicon-o-arrow-left class="w-5 h-5"/>
        </a>
        <h2 class="text-lg font-semibold text-slate-800">Editar — {{ $inventario->nombre }}</h2>
    </div>

    <form method="POST" action="{{ route('inventario.update', $inventario) }}">
        @csrf
        @method('PUT')

        <div class="space-y-6">

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                    Datos del Producto
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nombre *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $inventario->nombre) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Código</label>
                        <input type="text" name="codigo" value="{{ old('codigo', $inventario->codigo) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Categoría</label>
                        <input type="text" name="categoria" value="{{ old('categoria', $inventario->categoria) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Unidad</label>
                        <select name="unidad"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            @foreach(['pieza','frasco','caja','ampolleta','ml','unidad'] as $unidad)
                                <option value="{{ $unidad }}" {{ old('unidad', $inventario->unidad) == $unidad ? 'selected' : '' }}>
                                    {{ ucfirst($unidad) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Estado</label>
                        <select name="activo"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option value="1" {{ $inventario->activo ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ !$inventario->activo ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Descripción</label>
                        <textarea name="descripcion" rows="2"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('descripcion', $inventario->descripcion) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                    Precios y Stock Mínimo
                </h3>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Precio Compra</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-slate-400 text-sm">$</span>
                            <input type="number" step="0.01" name="precio_compra" value="{{ old('precio_compra', $inventario->precio_compra) }}"
                                class="w-full border border-gray-300 rounded-lg pl-6 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Precio Venta</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-slate-400 text-sm">$</span>
                            <input type="number" step="0.01" name="precio_venta" value="{{ old('precio_venta', $inventario->precio_venta) }}"
                                class="w-full border border-gray-300 rounded-lg pl-6 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Stock Mínimo *</label>
                        <input type="number" name="stock_minimo" value="{{ old('stock_minimo', $inventario->stock_minimo) }}" min="0"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>
                <div class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <p class="text-sm text-blue-700">Para modificar el stock usa <strong>Registrar Movimiento</strong> desde la vista del producto.</p>
                </div>
            </div>

        </div>

        <div class="flex items-center gap-3 mt-6">
            <button type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                Guardar cambios
            </button>
            <a href="{{ route('inventario.show', $inventario) }}"
                class="text-slate-600 hover:text-slate-800 px-4 py-2 rounded-lg text-sm font-medium border border-gray-300 transition">
                Cancelar
            </a>
        </div>

    </form>
</div>

@endsection
