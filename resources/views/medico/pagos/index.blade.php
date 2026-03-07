@extends('layouts.medico')
@section('titulo', 'Pagos')
@section('contenido')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
    <h3 class="font-serif" style="font-size:21px;">Pagos & Recibos</h3>
    <a href="{{ route('medico.pagos.create') }}"
        style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:8px;font-size:13px;font-weight:600;background:#0284c7;color:white;text-decoration:none;">
        <i class="fa-solid fa-plus"></i> Nuevo recibo
    </a>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:18px;">
    <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:16px 20px;display:flex;align-items:center;gap:14px;">
        <div style="width:42px;height:42px;border-radius:11px;background:#e0f2fe;color:#0284c7;display:flex;align-items:center;justify-content:center;">
            <i class="fa-solid fa-peso-sign"></i>
        </div>
        <div>
            <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Total este mes</div>
            <div style="font-size:20px;font-weight:700;color:#0284c7;">${{ number_format($totalMes, 2) }}</div>
        </div>
    </div>
    <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:16px 20px;display:flex;align-items:center;gap:14px;">
        <div style="width:42px;height:42px;border-radius:11px;background:#fef3c7;color:#d97706;display:flex;align-items:center;justify-content:center;">
            <i class="fa-solid fa-clock"></i>
        </div>
        <div>
            <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Pendientes de pago</div>
            <div style="font-size:20px;font-weight:700;color:#d97706;">{{ $pendientes }}</div>
        </div>
    </div>
</div>

<form method="GET">
    <div style="display:flex;gap:8px;margin-bottom:14px;">
        <div style="flex:1;display:flex;align-items:center;gap:7px;background:white;border:1px solid #e2e8f0;border-radius:9px;padding:8px 13px;">
            <i class="fa-solid fa-magnifying-glass" style="color:#94a3b8;font-size:12px;"></i>
            <input name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por paciente..."
                style="border:none;background:transparent;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;flex:1;">
        </div>
        <button type="submit" style="padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;background:#0284c7;color:white;border:none;cursor:pointer;">Buscar</button>
        @if(request('buscar'))
        <a href="{{ route('medico.pagos.index') }}" style="padding:8px 14px;border-radius:8px;font-size:13px;font-weight:600;background:white;color:#64748b;border:1.5px solid #e2e8f0;text-decoration:none;">Limpiar</a>
        @endif
    </div>
</form>

<div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;font-size:13px;">
        <thead style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
            <tr>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Folio</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Fecha</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Paciente</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Total</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Estado</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($facturas as $factura)
            <tr style="border-bottom:1px solid #f1f5f9;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                <td style="padding:12px 16px;">
                    <span style="background:#e0f2fe;color:#0284c7;font-size:11px;font-weight:700;padding:3px 9px;border-radius:6px;font-family:monospace;">{{ $factura->folio }}</span>
                </td>
                <td style="padding:12px 16px;font-size:12px;color:#64748b;">{{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</td>
                <td style="padding:12px 16px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:30px;height:30px;border-radius:50%;background:#e0f2fe;color:#0284c7;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;flex-shrink:0;">
                            {{ strtoupper(substr($factura->paciente->nombre, 0, 1)) }}
                        </div>
                        <span style="font-weight:600;">{{ $factura->paciente->nombre_completo }}</span>
                    </div>
                </td>
                <td style="padding:12px 16px;font-weight:700;color:#0284c7;">${{ number_format($factura->total, 2) }}</td>
                <td style="padding:12px 16px;">
                    @if($factura->estado === 'pagada')
                    <span style="background:#d1fae5;color:#059669;font-size:11px;font-weight:600;padding:3px 9px;border-radius:6px;">Pagada</span>
                    @elseif($factura->estado === 'pendiente')
                    <span style="background:#fef3c7;color:#d97706;font-size:11px;font-weight:600;padding:3px 9px;border-radius:6px;">Pendiente</span>
                    @else
                    <span style="background:#fee2e2;color:#e11d48;font-size:11px;font-weight:600;padding:3px 9px;border-radius:6px;">Cancelada</span>
                    @endif
                </td>
                <td style="padding:12px 16px;display:flex;gap:6px;">
                    <a href="{{ route('medico.pagos.show', $factura) }}"
                        style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#e0f2fe;color:#0284c7;text-decoration:none;">
                        <i class="fa-solid fa-eye" style="font-size:10px;"></i> Ver
                    </a>
                    <a href="{{ route('medico.pagos.pdf', $factura) }}" target="_blank"
                        style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#d1fae5;color:#059669;text-decoration:none;">
                        <i class="fa-solid fa-file-pdf" style="font-size:10px;"></i> PDF
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding:50px;text-align:center;color:#94a3b8;">
                    <i class="fa-solid fa-file-invoice-dollar" style="font-size:36px;margin-bottom:12px;display:block;"></i>
                    <p style="font-size:13px;">No hay recibos registrados</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($facturas->hasPages())
    <div style="padding:14px 18px;border-top:1px solid #e2e8f0;">{{ $facturas->links() }}</div>
    @endif
</div>

@endsection
