@extends('layouts.medico')
@section('titulo', 'Inventario')
@section('contenido')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
    <h3 class="font-serif" style="font-size:21px;">Inventario</h3>
    <a href="{{ route('medico.inventario.create') }}"
        style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:8px;font-size:13px;font-weight:600;background:#ea580c;color:white;text-decoration:none;">
        <i class="fa-solid fa-plus"></i> Nuevo producto
    </a>
</div>

@if($bajoStock > 0)
<div style="background:#fff7ed;border:1.5px solid #fed7aa;border-radius:10px;padding:12px 16px;margin-bottom:14px;display:flex;align-items:center;gap:10px;">
    <i class="fa-solid fa-triangle-exclamation" style="color:#ea580c;font-size:16px;"></i>
    <span style="font-size:13px;color:#9a3412;font-weight:600;">{{ $bajoStock }} producto(s) con stock bajo el mínimo</span>
</div>
@endif

<form method="GET">
    <div style="display:flex;gap:8px;margin-bottom:14px;">
        <div style="flex:1;display:flex;align-items:center;gap:7px;background:white;border:1px solid #e2e8f0;border-radius:9px;padding:8px 13px;">
            <i class="fa-solid fa-magnifying-glass" style="color:#94a3b8;font-size:12px;"></i>
            <input name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre, código o categoría..."
                style="border:none;background:transparent;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;flex:1;">
        </div>
        <button type="submit" style="padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;background:#ea580c;color:white;border:none;cursor:pointer;">Buscar</button>
        @if(request('buscar'))
        <a href="{{ route('medico.inventario.index') }}" style="padding:8px 14px;border-radius:8px;font-size:13px;font-weight:600;background:white;color:#64748b;border:1.5px solid #e2e8f0;text-decoration:none;">Limpiar</a>
        @endif
    </div>
</form>

<div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;font-size:13px;">
        <thead style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
            <tr>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Producto</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Categoría</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Stock</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Unidad</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $producto)
            @php $bajStock = $producto->stock_actual <= $producto->stock_minimo; @endphp
            <tr style="border-bottom:1px solid #f1f5f9;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                <td style="padding:12px 16px;">
                    <div style="font-weight:600;">{{ $producto->nombre }}</div>
                    @if($producto->codigo)
                    <div style="font-size:11px;color:#94a3b8;font-family:monospace;">{{ $producto->codigo }}</div>
                    @endif
                </td>
                <td style="padding:12px 16px;font-size:12px;color:#64748b;">{{ $producto->categoria ?? '—' }}</td>
                <td style="padding:12px 16px;">
                    <span style="font-weight:700;font-size:15px;color:{{ $bajStock ? '#ea580c' : '#059669' }};">
                        {{ $producto->stock_actual }}
                    </span>
                    @if($bajStock)
                    <span style="font-size:10px;background:#fff7ed;color:#ea580c;padding:2px 6px;border-radius:5px;margin-left:4px;font-weight:600;">BAJO</span>
                    @endif
                    <div style="font-size:10px;color:#94a3b8;">mín: {{ $producto->stock_minimo }}</div>
                </td>
                <td style="padding:12px 16px;font-size:12px;color:#64748b;">{{ $producto->unidad }}</td>
                <td style="padding:12px 16px;">
                    <a href="{{ route('medico.inventario.show', $producto) }}"
                        style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#ffedd5;color:#ea580c;text-decoration:none;">
                        <i class="fa-solid fa-eye" style="font-size:10px;"></i> Ver
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding:50px;text-align:center;color:#94a3b8;">
                    <i class="fa-solid fa-boxes-stacked" style="font-size:36px;margin-bottom:12px;display:block;"></i>
                    <p style="font-size:13px;">No hay productos registrados</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($productos->hasPages())
    <div style="padding:14px 18px;border-top:1px solid #e2e8f0;">{{ $productos->links() }}</div>
    @endif
</div>

@endsection
