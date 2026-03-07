<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\MovimientoInventario;
use App\Models\Clinica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('nombre')->paginate(15);
        $bajoStock = Producto::where('stock_actual', '<=', DB::raw('stock_minimo'))->count();
        return view('inventario.index', compact('productos', 'bajoStock'));
    }

    public function create()
    {
        return view('inventario.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'        => 'required|string|max:255',
            'codigo'        => 'nullable|string|unique:productos,codigo',
            'categoria'     => 'nullable|string|max:100',
            'unidad'        => 'required|string|max:50',
            'precio_compra' => 'nullable|numeric|min:0',
            'precio_venta'  => 'nullable|numeric|min:0',
            'stock_actual'  => 'required|integer|min:0',
            'stock_minimo'  => 'required|integer|min:0',
        ]);

        $clinica  = Clinica::first();
        $producto = Producto::create([
            'clinica_id'    => $clinica->id,
            'nombre'        => $request->nombre,
            'codigo'        => $request->codigo,
            'descripcion'   => $request->descripcion,
            'categoria'     => $request->categoria,
            'unidad'        => $request->unidad,
            'precio_compra' => $request->precio_compra ?? 0,
            'precio_venta'  => $request->precio_venta ?? 0,
            'stock_actual'  => $request->stock_actual,
            'stock_minimo'  => $request->stock_minimo,
        ]);

        if ($request->stock_actual > 0) {
            MovimientoInventario::create([
                'clinica_id'     => $clinica->id,
                'producto_id'    => $producto->id,
                'user_id'        => Auth::id(),
                'tipo'           => 'entrada',
                'cantidad'       => $request->stock_actual,
                'stock_anterior' => 0,
                'stock_nuevo'    => $request->stock_actual,
                'motivo'         => 'Stock inicial',
            ]);
        }

        return redirect()->route('inventario.index')
            ->with('success', 'Producto registrado exitosamente.');
    }

    public function show(Producto $inventario)
    {
        $inventario->load('movimientos.user');
        return view('inventario.show', compact('inventario'));
    }

    public function edit(Producto $inventario)
    {
        return view('inventario.edit', compact('inventario'));
    }

    public function update(Request $request, Producto $inventario)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'precio_venta' => 'nullable|numeric|min:0',
            'stock_minimo' => 'required|integer|min:0',
        ]);

        $inventario->update($request->only([
            'nombre', 'codigo', 'descripcion', 'categoria',
            'unidad', 'precio_compra', 'precio_venta', 'stock_minimo', 'activo'
        ]));

        return redirect()->route('inventario.show', $inventario)
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $inventario)
    {
        $inventario->delete();
        return redirect()->route('inventario.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    public function movimiento(Request $request, Producto $inventario)
    {
        $request->validate([
            'tipo'     => 'required|in:entrada,salida,ajuste',
            'cantidad' => 'required|integer|min:1',
            'motivo'   => 'nullable|string',
        ]);

        $stockAnterior = $inventario->stock_actual;

        if ($request->tipo === 'entrada') {
            $stockNuevo = $stockAnterior + $request->cantidad;
        } elseif ($request->tipo === 'salida') {
            $stockNuevo = max(0, $stockAnterior - $request->cantidad);
        } else {
            $stockNuevo = $request->cantidad;
        }

        $inventario->update(['stock_actual' => $stockNuevo]);

        MovimientoInventario::create([
            'clinica_id'     => $inventario->clinica_id,
            'producto_id'    => $inventario->id,
            'user_id'        => Auth::id(),
            'tipo'           => $request->tipo,
            'cantidad'       => $request->cantidad,
            'stock_anterior' => $stockAnterior,
            'stock_nuevo'    => $stockNuevo,
            'motivo'         => $request->motivo,
        ]);

        return redirect()->route('inventario.show', $inventario)
            ->with('success', 'Movimiento registrado exitosamente.');
    }
}