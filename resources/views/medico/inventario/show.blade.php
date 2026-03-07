@extends('layouts.medico')
@section('titulo', $inventario->nombre)
@section('contenido')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
    <a href="{{ route('medico.inventario.index') }}" style="color:#94a3b8;text-decoration:none;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h3 class="font-serif" style="font-size:21px;">{{ $inventario->nombre }}</h3>
    @if($inventario->codigo)
    <span style="font-size:12px;color:#64748b;background:#f1f5f9;padding:3px 9px;border-radius:6px;font-family:monospace;">{{ $inventario->codigo }}</span>
    @endif
</div>

<div style="display:grid;grid-template-columns:1fr 300px;gap:18px;">

    <!-- Movimientos -->
    <div style="display:flex;flex-direction:column;gap:14px;">

        <!-- Registrar movimiento -->
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;">Registrar movimiento</h4>
            <form method="POST" action="{{ route('medico.inventario.movimiento', $inventario) }}">
                @csrf
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Tipo *</label>
                        <select name="tipo" required style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                            <option value="entrada">Entrada</option>
                            <option value="salida">Salida</option>
                            <option value="ajuste">Ajuste</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Cantidad *</label>
                        <input type="number" name="cantidad" min="1" required
                            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                    </div>
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Motivo</label>
                        <input type="text" name="motivo" placeholder="Ej: Compra, Uso..."
                            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                    </div>
                </div>
                <button type="submit" style="margin-top:12px;padding:8px 20px;border-radius:8px;font-size:13px;font-weight:600;background:#ea580c;color:white;border:none;cursor:pointer;">
                    <i class="fa-solid fa-plus"></i> Registrar
                </button>
            </form>
        </div>

        <!-- Historial de movimientos -->
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
            <div style="padding:14px 18px;border-bottom:1px solid #e2e8f0;">
                <h4 style="font-size:13px;font-weight:700;">Historial de movimientos</h4>
            </div>
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;color:#64748b;">Fecha</th>
                        <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;color:#64748b;">Tipo</th>
                        <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;color:#64748b;">Cantidad</th>
                        <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;color:#64748b;">Stock</th>
                        <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;color:#64748b;">Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventario->movimientos->sortByDesc('created_at') as $mov)
                    <tr style="border-bottom:1px solid #f1f5f9;">
                        <td style="padding:10px 16px;font-size:12px;color:#64748b;">{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                        <td style="padding:10px 16px;">
                            @if($mov->tipo === 'entrada')
                            <span style="background:#d1fae5;color:#059669;font-size:11px;font-weight:600;padding:2px 8px;border-radius:5px;">Entrada</span>
                            @elseif($mov->tipo === 'salida')
                            <span style="background:#fee2e2;color:#e11d48;font-size:11px;font-weight:600;padding:2px 8px;border-radius:5px;">Salida</span>
                            @else
                            <span style="background:#e0f2fe;color:#0284c7;font-size:11px;font-weight:600;padding:2px 8px;border-radius:5px;">Ajuste</span>
                            @endif
                        </td>
                        <td style="padding:10px 16px;font-weight:600;">{{ $mov->cantidad }} {{ $inventario->unidad }}</td>
                        <td style="padding:10px 16px;font-size:12px;color:#64748b;">{{ $mov->stock_anterior }} → {{ $mov->stock_nuevo }}</td>
                        <td style="padding:10px 16px;font-size:12px;color:#64748b;">{{ $mov->motivo ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:30px;text-align:center;color:#94a3b8;font-size:12px;">Sin movimientos registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Info del producto -->
    <div style="display:flex;flex-direction:column;gap:14px;">
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:12px;">Stock actual</h4>
            @php $bajo = $inventario->stock_actual <= $inventario->stock_minimo; @endphp
            <div style="text-align:center;padding:20px 0;">
                <div style="font-size:48px;font-weight:700;color:{{ $bajo ? '#ea580c' : '#059669' }};">{{ $inventario->stock_actual }}</div>
                <div style="font-size:13px;color:#64748b;margin-top:4px;">{{ $inventario->unidad }}</div>
                @if($bajo)
                <div style="margin-top:8px;background:#fff7ed;color:#ea580c;font-size:12px;font-weight:600;padding:5px 12px;border-radius:7px;display:inline-block;">
                    ⚠ Stock bajo mínimo ({{ $inventario->stock_minimo }})
                </div>
                @endif
            </div>
        </div>

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:12px;">Detalles</h4>
            <div style="display:flex;flex-direction:column;gap:8px;font-size:13px;">
                <div style="display:flex;justify-content:space-between;">
                    <span style="color:#64748b;">Categoría:</span>
                    <span style="font-weight:600;">{{ $inventario->categoria ?? '—' }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="color:#64748b;">Unidad:</span>
                    <span style="font-weight:600;">{{ $inventario->unidad }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="color:#64748b;">Stock mínimo:</span>
                    <span style="font-weight:600;">{{ $inventario->stock_minimo }}</span>
                </div>
                @if($inventario->precio_compra)
                <div style="display:flex;justify-content:space-between;">
                    <span style="color:#64748b;">P. compra:</span>
                    <span style="font-weight:600;">${{ number_format($inventario->precio_compra, 2) }}</span>
                </div>
                @endif
                @if($inventario->precio_venta)
                <div style="display:flex;justify-content:space-between;">
                    <span style="color:#64748b;">P. venta:</span>
                    <span style="font-weight:600;">${{ number_format($inventario->precio_venta, 2) }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
