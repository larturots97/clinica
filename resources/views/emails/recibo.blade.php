<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
body { font-family:Arial,sans-serif; background:#f0ebe4; padding:30px; color:#2d2420; }
.container { max-width:520px; margin:0 auto; background:white; border-radius:12px; overflow:hidden; box-shadow:0 4px 16px rgba(0,0,0,0.08); }
.header { background:#f5f1ec; border-bottom:2px solid #b08060; padding:20px 24px; text-align:center; }
.header h1 { font-size:20px; color:#3d1f0a; margin-bottom:4px; }
.header p { font-size:12px; color:#8a7060; }
.body { padding:24px; }
.body p { font-size:14px; color:#2d2420; line-height:1.6; margin-bottom:12px; }
.folio-box { background:#f5f1ec; border:1px solid #e8d5b8; border-radius:8px; padding:14px 18px; margin:16px 0; text-align:center; }
.folio-box .folio { font-size:22px; font-weight:bold; color:#3d1f0a; font-family:monospace; }
.folio-box .total { font-size:16px; font-weight:bold; color:#b08060; margin-top:4px; }
.nota { font-size:12px; color:#a07840; font-style:italic; border-left:2px solid #c9a96e; padding-left:10px; margin-top:16px; }
.footer { background:#e8d5b8; padding:14px 24px; text-align:center; font-size:11px; color:#6a4828; border-top:1px solid #c9a96e; }
.footer strong { color:#8a5020; }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>{{ $factura->medico->nombre_completo }}</h1>
        <p>{{ $factura->medico->especialidad->nombre ?? 'Médico' }}</p>
    </div>
    <div class="body">
        <p>Estimado(a) <strong>{{ $factura->paciente->nombre_completo }}</strong>,</p>
        <p>Adjunto encontrará el recibo de pago por los servicios médicos recibidos.</p>
        <div class="folio-box">
            <div class="folio">{{ $factura->folio }}</div>
            <div class="total">Total: ${{ number_format($factura->total, 2) }}</div>
        </div>
        <p>Fecha de emisión: <strong>{{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</strong></p>
        @if($factura->metodo_pago)
        <p>Método de pago: <strong>{{ ucfirst($factura->metodo_pago) }}</strong></p>
        @endif
        <div class="nota">
            Este correo fue enviado automáticamente. Si tiene alguna duda o aclaración, 
            por favor comuníquese directamente con su médico.
        </div>
    </div>
    <div class="footer">
        <strong>NovaSystem Clínica</strong> · {{ now()->format('d/m/Y') }}
    </div>
</div>
</body>
</html>
