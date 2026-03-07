<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\MovimientoInventario;
use App\Models\Clinica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::orderBy('nombre');

        if ($request->buscar) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%')
                  ->orWhere('codigo', 'like', '%' . $request->buscar . '%')
                  ->orWhere('categoria', 'like', '%' . $request->buscar . '%');
        }

        $productos = $query->paginate(15);
        $bajoStock = Producto::where('stock_actual', '<=', DB::raw('stock_minimo'))->count();

        return view('medico.inventario.index', compact('productos', 'bajoStock'));
    }

    public function create()
    {
        return view('medico.inventario.create');
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

        return redirect()->route('medico.inventario.index')
            ->with('success', 'Producto registrado correctamente.');
    }

    public function show(Producto $inventario)
    {
        $inventario->load('movimientos.user');
        return view('medico.inventario.show', compact('inventario'));
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

        return redirect()->route('medico.inventario.show', $inventario)
            ->with('success', 'Movimiento registrado correctamente.');
    }
}
