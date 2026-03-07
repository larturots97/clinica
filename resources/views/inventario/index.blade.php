@extends('layouts.panel')

@section('titulo', 'Inventario')

@section('contenido')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-800">Inventario</h2>
        <p class="text-sm text-slate-500">Total: {{ $productos->total() }} productos
            @if($bajoStock > 0)
                — <span class="text-red-600 font-medium">⚠ {{ $bajoStock }} con stock bajo</span>
            @endif
        </p>
    </div>
    <a href="{{ route('inventario.create') }}"
        class="flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
        <x-heroicon-o-plus class="w-4 h-4"/>
        Nuevo Producto
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Producto</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Categoría</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Stock</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Mínimo</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Precio Venta</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Estado</th>
                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($productos as $producto)
            <tr class="hover:bg-slate-50 transition {{ $producto->bajo_stock ? 'bg-red-50' : '' }}">
                <td class="px-6 py-4">
                    <p class="font-medium text-slate-800">{{ $producto->nombre }}</p>
                    @if($producto->codigo)
                    <p class="text-xs text-slate-400 font-mono">{{ $producto->codigo }}</p>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if($producto->categoria)
                    <span class="bg-purple-50 text-purple-700 px-2 py-1 rounded text-xs">{{ $producto->categoria }}</span>
                    @else
                    <span class="text-slate-400">—</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="font-bold {{ $producto->bajo_stock ? 'text-red-600' : 'text-green-600' }}">
                        {{ $producto->stock_actual }}
                    </span>
                    <span class="text-slate-400 text-xs ml-1">{{ $producto->unidad }}</span>
                </td>
                <td class="px-6 py-4 text-slate-600">{{ $producto->stock_minimo }}</td>
                <td class="px-6 py-4 font-medium text-slate-800">${{ number_format($producto->precio_venta, 2) }}</td>
                <td class="px-6 py-4">
                    @if($producto->bajo_stock)
                        <span class="bg-red-50 text-red-700 px-2 py-1 rounded text-xs font-medium">Stock bajo</span>
                    @else
                        <span class="bg-green-50 text-green-700 px-2 py-1 rounded text-xs font-medium">OK</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('inventario.show', $producto) }}" class="text-blue-600 hover:text-blue-800">
                            <x-heroicon-o-eye class="w-4 h-4"/>
                        </a>
                        <a href="{{ route('inventario.edit', $producto) }}" class="text-amber-600 hover:text-amber-800">
                            <x-heroicon-o-pencil class="w-4 h-4"/>
                        </a>
                        <form method="POST" action="{{ route('inventario.destroy', $producto) }}"
                            onsubmit="return confirm('¿Eliminar este producto?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <x-heroicon-o-trash class="w-4 h-4"/>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                    <x-heroicon-o-archive-box class="w-12 h-12 mx-auto mb-3 text-slate-300"/>
                    <p>No hay productos registrados</p>
                    <a href="{{ route('inventario.create') }}" class="text-teal-600 hover:underline text-sm mt-1 inline-block">
                        Agregar primer producto
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($productos->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $productos->links() }}
    </div>
    @endif
</div>

@endsection
