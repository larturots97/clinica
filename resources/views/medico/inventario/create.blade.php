@extends('layouts.medico')
@section('titulo', 'Nuevo Producto')
@section('contenido')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
    <a href="{{ route('medico.inventario.index') }}" style="color:#94a3b8;text-decoration:none;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h3 class="font-serif" style="font-size:21px;">Nuevo Producto</h3>
</div>

<form method="POST" action="{{ route('medico.inventario.store') }}">
@csrf
<div style="display:grid;grid-template-columns:1fr 300px;gap:18px;">

    <div style="display:flex;flex-direction:column;gap:14px;">
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;">Información del producto</h4>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div style="grid-column:span 2;">
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Nombre *</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                    @error('nombre')<p style="color:#e11d48;font-size:11px;margin-top:3px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Código</label>
                    <input type="text" name="codigo" value="{{ old('codigo') }}"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Categoría</label>
                    <input type="text" name="categoria" value="{{ old('categoria') }}"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Unidad *</label>
                    <input type="text" name="unidad" value="{{ old('unidad') }}" placeholder="ej. ml, unidad, cc" required
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Stock inicial *</label>
                    <input type="number" name="stock_actual" value="{{ old('stock_actual', 0) }}" min="0" required
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Stock mínimo *</label>
                    <input type="number" name="stock_minimo" value="{{ old('stock_minimo', 5) }}" min="0" required
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Precio compra</label>
                    <input type="number" name="precio_compra" value="{{ old('precio_compra', 0) }}" min="0" step="0.01"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Precio venta</label>
                    <input type="number" name="precio_venta" value="{{ old('precio_venta', 0) }}" min="0" step="0.01"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                </div>
                <div style="grid-column:span 2;">
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Descripción</label>
                    <textarea name="descripcion" rows="2"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;resize:vertical;">{{ old('descripcion') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:14px;">
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;">Acciones</h4>
            <button type="submit" style="width:100%;padding:10px;border-radius:9px;font-size:14px;font-weight:600;background:#ea580c;color:white;border:none;cursor:pointer;margin-bottom:8px;">
                <i class="fa-solid fa-floppy-disk"></i> Guardar producto
            </button>
            <a href="{{ route('medico.inventario.index') }}" style="display:flex;align-items:center;justify-content:center;padding:9px;border-radius:9px;font-size:13px;font-weight:600;background:white;color:#64748b;border:1.5px solid #e2e8f0;text-decoration:none;">
                Cancelar
            </a>
        </div>
        <div style="background:#fff7ed;border:1.5px solid #fed7aa;border-radius:13px;padding:16px;">
            <h4 style="font-size:12px;font-weight:700;color:#9a3412;margin-bottom:8px;"><i class="fa-solid fa-circle-info" style="margin-right:5px;"></i>Nota</h4>
            <p style="font-size:12px;color:#c2410c;line-height:1.5;">El stock inicial se registrará automáticamente como una entrada en el historial de movimientos.</p>
        </div>
    </div>

</div>
</form>
@endsection
