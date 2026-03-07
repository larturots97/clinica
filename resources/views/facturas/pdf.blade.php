<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1e293b; padding: 30px; }

        .header { border-bottom: 3px solid #0d9488; padding-bottom: 15px; margin-bottom: 20px; display: flex; justify-content: space-between; }
        .clinica-nombre { font-size: 20px; font-weight: bold; color: #0d9488; }
        .clinica-info { font-size: 10px; color: #64748b; margin-top: 4px; }
        .folio { font-size: 22px; font-weight: bold; color: #1e40af; }
        .fecha { font-size: 11px; color: #64748b; }

        .info-grid { display: flex; gap: 40px; margin-bottom: 20px; }
        .info-block { flex: 1; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px; }
        .info-title { font-size: 10px; font-weight: bold; color: #64748b; text-transform: uppercase; margin-bottom: 6px; }
        .info-name { font-size: 13px; font-weight: bold; }
        .info-detail { font-size: 10px; color: #64748b; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        thead { background: #f1f5f9; }
        th { text-align: left; padding: 8px 10px; font-size: 10px; color: #64748b; text-transform: uppercase; }
        td { padding: 8px 10px; border-bottom: 1px solid #f1f5f9; font-size: 11px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .totales { display: flex; justify-content: flex-end; margin-bottom: 20px; }
        .totales-box { width: 220px; }
        .total-row { display: flex; justify-content: space-between; padding: 4px 0; font-size: 11px; }
        .total-final { display: flex; justify-content: space-between; padding: 8px 0; font-size: 14px; font-weight: bold; border-top: 2px solid #0d9488; color: #0d9488; }

        .estado { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; }
        .estado-pendiente { background: #fef9c3; color: #854d0e; }
        .estado-pagada { background: #dcfce7; color: #166534; }
        .estado-cancelada { background: #fee2e2; color: #991b1b; }

        .footer { text-align: center; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <div class="clinica-nombre">{{ $factura->clinica->nombre }}</div>
            <div class="clinica-info">
                {{ $factura->clinica->direccion }}<br>
                Tel: {{ $factura->clinica->telefono }} | {{ $factura->clinica->email }}
            </div>
        </div>
        <div style="text-align:right;">
            <div class="folio">{{ $factura->folio }}</div>
            <div class="fecha">{{ $factura->fecha->format('d/m/Y') }}</div>
            <div style="margin-top:4px;">
                <span class="estado estado-{{ $factura->estado }}">{{ ucfirst($factura->estado) }}</span>
            </div>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-block">
            <div class="info-title">Paciente</div>
            <div class="info-name">{{ $factura->paciente->nombre_completo }}</div>
            <div class="info-detail">Exp: {{ $factura->paciente->numero_expediente }}</div>
            @if($factura->paciente->telefono)
            <div class="info-detail">Tel: {{ $factura->paciente->telefono }}</div>
            @endif
        </div>
        @if($factura->medico)
        <div class="info-block">
            <div class="info-title">Médico</div>
            <div class="info-name">Dr. {{ $factura->medico->nombre_completo }}</div>
            <div class="info-detail">{{ $factura->medico->especialidad->nombre }}</div>
        </div>
        @endif
        <div class="info-block">
            <div class="info-title">Pago</div>
            <div class="info-name">{{ $factura->metodo_pago ? ucfirst($factura->metodo_pago) : 'Por definir' }}</div>
            <div class="info-detail">Emitida: {{ $factura->fecha->format('d/m/Y') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Concepto</th>
                <th>Descripción</th>
                <th class="text-center">Cant.</th>
                <th class="text-right">Precio Unit.</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factura->items as $item)
            <tr>
                <td><strong>{{ $item->concepto }}</strong></td>
                <td>{{ $item->descripcion ?? '—' }}</td>
                <td class="text-center">{{ $item->cantidad }}</td>
                <td class="text-right">${{ number_format($item->precio_unitario, 2) }}</td>
                <td class="text-right">${{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totales">
        <div class="totales-box">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>${{ number_format($factura->subtotal, 2) }}</span>
            </div>
            @if($factura->descuento > 0)
            <div class="total-row" style="color:#dc2626;">
                <span>Descuento:</span>
                <span>-${{ number_format($factura->descuento, 2) }}</span>
            </div>
            @endif
            <div class="total-row">
                <span>IVA (16%):</span>
                <span>${{ number_format($factura->impuesto, 2) }}</span>
            </div>
            <div class="total-final">
                <span>TOTAL:</span>
                <span>${{ number_format($factura->total, 2) }}</span>
            </div>
        </div>
    </div>

    @if($factura->notas)
    <div style="margin-bottom:20px; font-size:11px; color:#64748b;">
        <strong>Notas:</strong> {{ $factura->notas }}
    </div>
    @endif

    <div class="footer">
        Factura generada el {{ now()->format('d/m/Y H:i') }} — {{ $factura->clinica->nombre }}
    </div>

</body>
</html>
