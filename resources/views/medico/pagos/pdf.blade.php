<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:Arial,sans-serif; font-size:12px; color:#2d2420; padding:28px; background:white; }

.header { background:#f5f1ec; border-bottom:2px solid #b08060; padding:18px 20px; display:flex; justify-content:space-between; align-items:center; margin-bottom:0; }
.logo-area { display:flex; align-items:center; gap:12px; }
.logo-img { width:60px; height:60px; object-fit:contain; border-radius:8px; border:1px solid #e8ddd0; }
.logo-placeholder { width:60px; height:60px; border-radius:8px; border:1.5px dashed #b08060; display:flex; align-items:center; justify-content:center; background:white; }
.medico-nombre { font-size:16px; font-weight:bold; color:#3d1f0a; }
.medico-esp { font-size:10px; color:#b08060; font-weight:bold; margin-top:2px; }
.medico-contacto { font-size:9px; color:#8a7060; margin-top:4px; line-height:1.5; }
.folio-area { text-align:right; }
.folio-tipo { font-size:9px; text-transform:uppercase; letter-spacing:1.5px; color:#b08060; }
.folio-num { font-size:22px; font-weight:bold; color:#3d1f0a; }
.folio-fecha { font-size:10px; color:#8a7060; margin-top:3px; }
.estado-badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:10px; font-weight:bold; margin-top:5px; }
.estado-pagada { background:#d4edda; color:#155724; }
.estado-pendiente { background:#fff3cd; color:#856404; }
.estado-cancelada { background:#f8d7da; color:#721c24; }

.gold-line { height:1px; background:#c9a96e; opacity:0.4; margin:0; }

.info-grid { display:flex; gap:0; border-bottom:1px solid #f0e6d3; }
.info-block { flex:1; padding:12px 20px; border-right:1px solid #f0e6d3; }
.info-block:last-child { border-right:none; }
.info-label { font-size:8px; font-weight:bold; text-transform:uppercase; letter-spacing:0.8px; color:#b08060; margin-bottom:4px; }
.info-name { font-size:12px; font-weight:bold; color:#2d2420; }
.info-detail { font-size:9px; color:#8a7060; margin-top:1px; }

.tabla-section { padding:16px 20px; }
.tabla-titulo { font-size:9px; font-weight:bold; text-transform:uppercase; letter-spacing:0.8px; color:#b08060; margin-bottom:8px; }
table { width:100%; border-collapse:collapse; }
thead tr { background:#f5f1ec; border-left:3px solid #b08060; }
th { padding:7px 10px; text-align:left; font-size:9px; font-weight:bold; text-transform:uppercase; color:#7a5c48; }
th.r { text-align:right; }
td { padding:8px 10px; border-bottom:1px solid #faf0e8; font-size:11px; }
td.r { text-align:right; }
td.c { text-align:center; }
.concepto-name { font-weight:bold; }
.concepto-desc { font-size:9px; color:#b08060; }

.totales { display:flex; justify-content:flex-end; padding:6px 20px 14px; }
.totales-box { width:200px; }
.t-row { display:flex; justify-content:space-between; font-size:10px; color:#8a7060; padding:4px 0; border-bottom:1px solid #f0e6d3; }
.t-row strong { color:#2d2420; }
.t-desc { color:#c0392b; }
.t-final { display:flex; justify-content:space-between; padding:8px 10px; background:#e8d5b8; border-radius:7px; margin-top:6px; border:1px solid #c9a96e; }
.t-final span { font-size:12px; font-weight:bold; color:#4a2810; }
.t-final .amt { color:#8a5020; font-size:14px; }

.pago-section { margin:0 20px 14px; background:#f5f1ec; border:1px solid #e8d5b8; border-radius:8px; padding:10px 14px; display:flex; align-items:center; gap:10px; }
.pago-text { font-size:11px; color:#6b3a1f; }
.pago-text strong { display:block; font-size:12px; color:#3d1f0a; }

.ornamento { text-align:center; color:#c9a96e; font-size:14px; letter-spacing:8px; padding:6px 0; }

.firma-section { display:flex; justify-content:space-between; align-items:flex-end; padding:8px 20px 20px; }
.nota-legal { font-size:9px; color:#a07840; max-width:240px; line-height:1.7; font-style:italic; border-left:2px solid #c9a96e; padding-left:8px; }
.firma-box { text-align:center; }
.firma-img { width:120px; height:45px; object-fit:contain; display:block; margin:0 auto 4px; }
.firma-linea { width:160px; border-top:1.5px solid #3d1f0a; margin:0 auto 5px; }
.firma-nombre { font-size:11px; font-weight:bold; color:#2d2420; }
.firma-esp { font-size:10px; color:#b08060; font-weight:bold; }
.firma-cedula { font-size:9px; color:#8a7060; margin-top:1px; }

.footer { background:#e8d5b8; padding:10px 20px; display:flex; justify-content:space-between; align-items:center; border-top:1px solid #c9a96e; }
.footer-text { font-size:9px; color:#6a4828; }
.footer-logo { font-size:11px; font-weight:bold; color:#8a5020; }
</style>
</head>
<body>

<div class="header">
    <div class="logo-area">
        @if($factura->medico->logo)
        <img src="{{ storage_path('app/public/' . $factura->medico->logo) }}" class="logo-img">
        @else
        <div class="logo-placeholder">
            <span style="font-size:8px;color:#b08060;text-align:center;">Sin<br>logo</span>
        </div>
        @endif
        <div>
            <div class="medico-nombre">{{ $factura->medico->nombre_completo }}</div>
            <div class="medico-esp">✦ {{ $factura->medico->especialidad->nombre ?? 'Médico' }}</div>
            <div class="medico-contacto">
                {{ $factura->clinica->direccion ?? '' }}<br>
                Tel: {{ $factura->clinica->telefono ?? '' }}
                @if($factura->clinica->email) · {{ $factura->clinica->email }} @endif
            </div>
        </div>
    </div>
    <div class="folio-area">
        <div class="folio-tipo">Recibo de Pago</div>
        <div class="folio-num">{{ $factura->folio }}</div>
        <div class="folio-fecha">{{ \Carbon\Carbon::parse($factura->fecha)->format('d \d\e F \d\e Y') }}</div>
        <span class="estado-badge estado-{{ $factura->estado }}">
            {{ ucfirst($factura->estado) }}
        </span>
    </div>
</div>

<div class="gold-line"></div>

<div class="info-grid">
    <div class="info-block">
        <div class="info-label">Paciente</div>
        <div class="info-name">{{ $factura->paciente->nombre_completo }}</div>
        <div class="info-detail">Exp: {{ $factura->paciente->expediente }}</div>
        @if($factura->paciente->telefono)
        <div class="info-detail">Tel: {{ $factura->paciente->telefono }}</div>
        @endif
    </div>
    <div class="info-block">
        <div class="info-label">Médico tratante</div>
        <div class="info-name">{{ $factura->medico->nombre_completo }}</div>
        <div class="info-detail">{{ $factura->medico->especialidad->nombre ?? '' }}</div>
        @if($factura->medico->cedula)
        <div class="info-detail">Cédula: {{ $factura->medico->cedula }}</div>
        @endif
    </div>
    <div class="info-block">
        <div class="info-label">Método de pago</div>
        <div class="info-name">{{ $factura->metodo_pago ? ucfirst($factura->metodo_pago) : 'Por definir' }}</div>
        <div class="info-detail">Emitido: {{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</div>
    </div>
</div>

<div class="tabla-section">
    <div class="tabla-titulo">Servicios y conceptos</div>
    <table>
        <thead>
            <tr>
                <th>Concepto</th>
                <th>Descripción</th>
                <th class="c">Cant.</th>
                <th class="r">Precio Unit.</th>
                <th class="r">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factura->items as $item)
            <tr>
                <td><span class="concepto-name">{{ $item->concepto }}</span></td>
                <td><span class="concepto-desc">{{ $item->descripcion ?? '—' }}</span></td>
                <td class="c">{{ $item->cantidad }}</td>
                <td class="r">${{ number_format($item->precio_unitario, 2) }}</td>
                <td class="r">${{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="totales">
    <div class="totales-box">
        <div class="t-row"><span>Subtotal:</span><strong>${{ number_format($factura->subtotal, 2) }}</strong></div>
        @if($factura->descuento > 0)
        <div class="t-row t-desc"><span>Descuento:</span><strong>-${{ number_format($factura->descuento, 2) }}</strong></div>
        @endif
        <div class="t-row"><span>IVA (16%):</span><strong>${{ number_format($factura->impuesto, 2) }}</strong></div>
        <div class="t-final"><span>TOTAL</span><span class="amt">${{ number_format($factura->total, 2) }}</span></div>
    </div>
</div>

@if($factura->metodo_pago)
<div class="pago-section">
    <div class="pago-text">
        <strong>{{ ucfirst($factura->metodo_pago) }}</strong>
        Pago recibido el {{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }} · {{ ucfirst($factura->estado) }}
    </div>
</div>
@endif

@if($factura->notas)
<div style="margin:0 20px 10px;font-size:10px;color:#8a7060;font-style:italic;">
    <strong style="color:#3d1f0a;">Notas:</strong> {{ $factura->notas }}
</div>
@endif

<div class="ornamento">— ✦ —</div>

<div class="firma-section">
    <div class="nota-legal">
        Este recibo es comprobante de los servicios médicos prestados.<br>
        Consérvelo para cualquier aclaración posterior.<br>
        Gracias por su preferencia.
    </div>
    <div class="firma-box">
        @if($factura->medico->firma)
        <img src="{{ storage_path('app/public/' . $factura->medico->firma) }}" class="firma-img">
        @else
        <div class="firma-linea"></div>
        @endif
        <div class="firma-nombre">{{ $factura->medico->nombre_completo }}</div>
        <div class="firma-esp">{{ $factura->medico->especialidad->nombre ?? '' }}</div>
        @if($factura->medico->cedula)
        <div class="firma-cedula">Cédula: {{ $factura->medico->cedula }}</div>
        @endif
    </div>
</div>

<div class="footer">
    <div class="footer-text">Generado el {{ now()->format('d/m/Y H:i') }} hrs · {{ $factura->clinica->nombre }}</div>
    <div class="footer-logo">NovaSystem ♥</div>
</div>

</body>
</html>
