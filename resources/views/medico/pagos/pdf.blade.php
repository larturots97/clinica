<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Georgia, 'Times New Roman', serif; font-size: 11px; color: #3d3228; background: #faf8f4; }
        .page { width: 100%; min-height: 100vh; background: #faf8f4; display: flex; flex-direction: column; }

        /* ── HEADER ── */
        .header { background: #c9b99a; padding: 18px 32px 16px; text-align: center; }
        .logo-wrap { height: 100px; display: block; margin-bottom: 10px; text-align: center; }
        .logo-img { height: 130px; max-width: 280px; object-fit: contain; }
        .logo-initials { display: inline-block; width: 70px; height: 70px; border-radius: 50%; border: 1.5px solid rgba(255,255,255,.65); line-height: 70px; text-align: center; font-size: 24px; font-weight: bold; color: white; letter-spacing: 1px; }
        .header-nombre { font-size: 16px; font-weight: bold; color: white; letter-spacing: 2.5px; text-transform: uppercase; font-family: Georgia, serif; margin-bottom: 4px; }
        .header-sub { font-size: 9px; color: rgba(255,255,255,.82); letter-spacing: 1.8px; text-transform: uppercase; font-family: Arial, sans-serif; }

        /* ── BODY ── */
        .body { padding: 26px 36px 110px; flex: 1; position: relative; }
        .logo-watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 600px; height: 700px; opacity: 0.2; object-fit: contain; z-index: 0; }
        .body-content { position: relative; z-index: 1; }

        /* Ornamento */
        .ornament { display: table; width: 100%; margin: 14px 0; }
        .ornament-line { display: table-cell; vertical-align: middle; }
        .ornament-line::before { content: ''; display: block; height: 1px; background: #c9b99a; }
        .ornament-diamond { display: table-cell; width: 16px; text-align: center; vertical-align: middle; padding: 0 5px; }
        .ornament-diamond::before { content: ''; display: inline-block; width: 6px; height: 6px; background: #c9b99a; transform: rotate(45deg); }

        /* Título recibo */
        .recibo-title { text-align: center; font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: #8a7d6b; font-family: Arial, sans-serif; margin-bottom: 16px; }

        /* Folio y fecha */
        .top-row { overflow: hidden; margin-bottom: 18px; }
        .folio-badge { float: left; font-size: 9px; font-weight: bold; color: #8a7d6b; background: #f2ede5; border: 1px solid #d6cfc4; border-radius: 3px; padding: 3px 10px; font-family: Arial, sans-serif; letter-spacing: .5px; }
        .fecha-col { float: right; text-align: right; }
        .fecha-label { font-size: 7.5px; color: #a09080; text-transform: uppercase; letter-spacing: 1.2px; font-family: Arial, sans-serif; margin-bottom: 2px; }
        .fecha-valor { font-size: 11px; color: #3d3228; letter-spacing: .5px; }
        .clearfix::after { content: ''; display: table; clear: both; }

        /* Paciente */
        .paciente-label { font-size: 8px; color: #a09080; text-transform: uppercase; letter-spacing: 1.2px; font-family: Arial, sans-serif; margin-bottom: 4px; }
        .paciente-nombre { font-size: 17px; font-weight: 300; color: #3d3228; letter-spacing: 2px; text-transform: uppercase; }
        .paciente-dato { font-size: 9px; color: #8a7d6b; font-family: Arial, sans-serif; margin-top: 3px; }

        /* Sección servicios */
        .section-title { font-size: 8px; color: #a09080; text-transform: uppercase; letter-spacing: 1.2px; font-family: Arial, sans-serif; margin-bottom: 8px; }

        /* Tabla de servicios */
        .tabla-servicios { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
        .tabla-servicios thead tr { border-bottom: 1px solid #c9b99a; }
        .tabla-servicios thead th { font-size: 7.5px; text-transform: uppercase; letter-spacing: 1px; color: #c9b99a; font-family: Arial, sans-serif; font-weight: normal; padding: 0 0 5px 0; text-align: left; }
        .tabla-servicios thead th:last-child { text-align: right; }
        .tabla-servicios tbody tr { border-bottom: 1px solid #ede8e0; }
        .tabla-servicios tbody td { font-size: 10px; color: #3d3228; padding: 7px 0; font-family: Georgia, serif; }
        .tabla-servicios tbody td:last-child { text-align: right; font-family: Arial, sans-serif; font-size: 10px; }
        .tabla-servicios tbody td.concepto-sub { font-size: 8px; color: #8a7d6b; font-family: Arial, sans-serif; display: block; margin-top: 1px; }

        /* Totales */
        .totales-wrap { margin-top: 4px; }
        .total-row { display: table; width: 100%; padding: 4px 0; }
        .total-label { display: table-cell; font-size: 9px; color: #8a7d6b; font-family: Arial, sans-serif; text-transform: uppercase; letter-spacing: .8px; }
        .total-valor { display: table-cell; text-align: right; font-size: 9px; color: #3d3228; font-family: Arial, sans-serif; }
        .total-row.descuento .total-valor { color: #7a9e6a; }
        .total-final { background: #c9b99a; border-radius: 4px; padding: 8px 14px; display: table; width: 100%; margin-top: 8px; }
        .total-final .lbl { display: table-cell; font-size: 11px; font-weight: bold; color: white; letter-spacing: 1.5px; text-transform: uppercase; font-family: Arial, sans-serif; }
        .total-final .val { display: table-cell; text-align: right; font-size: 14px; font-weight: bold; color: white; font-family: Georgia, serif; }

        /* Pago */
        .pago-wrap { margin-top: 14px; background: #f2ede5; border-radius: 4px; padding: 10px 14px; }
        .pago-grid { display: table; width: 100%; }
        .pago-col { display: table-cell; width: 50%; vertical-align: top; }
        .pago-label { font-size: 7.5px; color: #a09080; text-transform: uppercase; letter-spacing: 1px; font-family: Arial, sans-serif; margin-bottom: 3px; }
        .pago-valor { font-size: 11px; color: #3d3228; font-family: Georgia, serif; }
        .pago-badge { display: inline-block; background: #c9b99a; color: white; font-size: 7.5px; padding: 2px 9px; border-radius: 10px; font-family: Arial, sans-serif; letter-spacing: .5px; margin-top: 2px; }

        /* Notas */
        .notas-wrap { margin-top: 12px; }
        .notas-label { font-size: 7.5px; color: #a09080; text-transform: uppercase; letter-spacing: 1px; font-family: Arial, sans-serif; margin-bottom: 4px; }
        .notas-text { font-size: 9.5px; color: #8a7d6b; line-height: 1.6; font-family: Arial, sans-serif; font-style: italic; }

        /* Firma */
        .firma-wrap { margin-top: 24px; text-align: center; }
        .firma-img { max-height: 50px; max-width: 130px; object-fit: contain; margin-bottom: 4px; }
        .firma-linea { width: 130px; border-top: 1px solid #8a7d6b; margin: 0 auto 7px; }
        .firma-nombre { font-size: 13px; color: #3d3228; font-style: italic; }
        .firma-sub { font-size: 8px; color: #8a7d6b; letter-spacing: .8px; text-transform: uppercase; font-family: Arial, sans-serif; margin-top: 2px; }

        /* ── FOOTER ── */
        .footer { background: #c9b99a; padding: 11px 24px 13px; text-align: center; position: fixed; bottom: 0; left: 0; right: 0; }
        .footer-linea { width: 40px; border-top: 1px solid rgba(255,255,255,.5); margin: 0 auto 6px; }
        .footer-nombre { font-size: 10px; font-weight: bold; color: white; letter-spacing: 1.5px; text-transform: uppercase; font-family: Georgia, serif; margin-bottom: 5px; }
        .footer-datos { font-size: 8.5px; color: rgba(255,255,255,.92); font-family: Arial, sans-serif; }
        .footer-sep { color: rgba(255,255,255,.35); margin: 0 7px; }
        .footer-prefix { color: rgba(255,255,255,.6); font-size: 7.5px; margin-right: 2px; }
    </style>
</head>
<body>
<div class="page">

    @php
        $config = \App\Models\ConfiguracionMedico::where('medico_id', $factura->medico_id)->first();
        $ced = $factura->medico->cedula ?? $factura->medico->cedula_profesional ?? null;
    @endphp

    {{-- HEADER --}}
    <div class="header">
        <div class="logo-wrap">
            @if($config && $config->logo)
                <img src="{{ storage_path('app/public/' . $config->logo) }}" class="logo-img" alt="Logo">
            @else
                <div class="logo-initials">
                    {{ strtoupper(substr($factura->medico->nombre, 0, 1)) }}{{ strtoupper(substr($factura->medico->apellido_paterno ?? $factura->medico->apellidos ?? '', 0, 1)) }}
                </div>
            @endif
        </div>
        <div class="header-nombre">{{ $factura->medico->nombre_completo }}</div>
        <div class="header-sub">
            {{ $factura->medico->especialidad->nombre ?? 'Medicina Estética' }}
            @if($factura->medico->telefono)
                &nbsp;·&nbsp; {{ $factura->medico->telefono }}
            @endif
        </div>
    </div>

    {{-- BODY --}}
    <div class="body">

        {{-- Marca de agua --}}
        @if($config && ($config->receta_logo_fondo ?? $config->logo))
            @php $logoWm = $config->receta_logo_fondo ?? $config->logo; @endphp
            <img src="{{ storage_path('app/public/' . $logoWm) }}" class="logo-watermark" alt="">
        @endif

        <div class="body-content">

            {{-- Título --}}
            <div class="recibo-title">Recibo de Pago</div>

            {{-- Folio y fecha --}}
            <div class="top-row clearfix">
                <span class="folio-badge">REC-{{ $factura->folio }}</span>
                <div class="fecha-col">
                    <div class="fecha-label">Fecha</div>
                    <div class="fecha-valor">{{ \Carbon\Carbon::parse($factura->fecha)->translatedFormat('j \d\e F \d\e Y') }}</div>
                </div>
            </div>

            {{-- Ornamento --}}
            <div class="ornament">
                <div class="ornament-line"></div>
                <div class="ornament-diamond"></div>
                <div class="ornament-line"></div>
            </div>

            {{-- Paciente --}}
            <div class="paciente-label">Paciente</div>
            <div class="paciente-nombre">{{ $factura->paciente->nombre_completo }}</div>
            @if($factura->paciente->expediente ?? null)
            <div class="paciente-dato">Exp: {{ $factura->paciente->expediente }}</div>
            @endif
            @if($factura->paciente->telefono || $factura->paciente->email)
            <div class="paciente-dato">
                @if($factura->paciente->telefono) {{ $factura->paciente->telefono }} @endif
                @if($factura->paciente->telefono && $factura->paciente->email) &nbsp;·&nbsp; @endif
                @if($factura->paciente->email) {{ $factura->paciente->email }} @endif
            </div>
            @endif

            {{-- Ornamento --}}
            <div class="ornament">
                <div class="ornament-line"></div>
                <div class="ornament-diamond"></div>
                <div class="ornament-line"></div>
            </div>

            {{-- Tabla de servicios --}}
            <div class="section-title">Servicios / Productos</div>
            <table class="tabla-servicios">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th style="text-align:center; width:50px;">Cant.</th>
                        <th style="text-align:right; width:80px;">P. Unit.</th>
                        <th style="text-align:right; width:80px;">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factura->items as $item)
                    <tr>
                        <td>
                            {{ $item->concepto }}
                            @if($item->descripcion)
                                <span class="concepto-sub">{{ $item->descripcion }}</span>
                            @endif
                        </td>
                        <td style="text-align:center; font-family:Arial,sans-serif; font-size:10px;">{{ $item->cantidad }}</td>
                        <td style="text-align:right; font-family:Arial,sans-serif; font-size:10px;">${{ number_format($item->precio_unitario, 2) }}</td>
                        <td>${{ number_format($item->cantidad * $item->precio_unitario, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Totales --}}
            <div class="totales-wrap">
                <div class="total-row">
                    <span class="total-label">Subtotal</span>
                    <span class="total-valor">${{ number_format($factura->subtotal, 2) }}</span>
                </div>
                @if($factura->descuento > 0)
                <div class="total-row descuento">
                    <span class="total-label">Descuento</span>
                    <span class="total-valor">- ${{ number_format($factura->descuento, 2) }}</span>
                </div>
                @endif
                @if($factura->impuesto > 0)
                <div class="total-row">
                    <span class="total-label">Impuestos</span>
                    <span class="total-valor">${{ number_format($factura->impuesto, 2) }}</span>
                </div>
                @endif
                <div class="total-final">
                    <span class="lbl">Total</span>
                    <span class="val">${{ number_format($factura->total, 2) }}</span>
                </div>
            </div>

            {{-- Método de pago --}}
            <div class="pago-wrap">
                <div class="pago-grid">
                    <div class="pago-col">
                        <div class="pago-label">Método de pago</div>
                        <div class="pago-valor">{{ $factura->metodo_pago ? ucfirst($factura->metodo_pago) : 'Por definir' }}</div>
                    </div>
                    <div class="pago-col">
                        <div class="pago-label">Estado</div>
                        <span class="pago-badge">
                            {{ ucfirst($factura->estado) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Notas --}}
            @if($factura->notas)
            <div class="notas-wrap">
                <div class="notas-label">Notas</div>
                <div class="notas-text">{{ $factura->notas }}</div>
            </div>
            @endif

            {{-- Firma --}}
            <div class="firma-wrap">
                @if($config && $factura->medico->firma)
                    <img src="{{ storage_path('app/public/' . $factura->medico->firma) }}" class="firma-img" alt="Firma">
                @endif
                <div class="firma-linea"></div>
                <div class="firma-nombre">{{ $factura->medico->nombre_completo }}</div>
                <div class="firma-sub">
                    {{ $factura->medico->especialidad->nombre ?? 'Medicina Estética' }}
                    @if($ced) &nbsp;·&nbsp; Céd. {{ $ced }} @endif
                </div>
            </div>

        </div>{{-- /body-content --}}
    </div>{{-- /body --}}

    {{-- FOOTER --}}
    <div class="footer">
        <div class="footer-linea"></div>
        <div class="footer-nombre">{{ $factura->medico->nombre_completo }}</div>
        <div class="footer-datos">
            @php
                $items = [];
                if ($ced) $items[] = 'Ced. Prof. ' . $ced;
                if (!empty($config->receta_direccion)) $items[] = $config->receta_direccion;
                if (!empty($config->receta_instagram))  $items[] = 'IG @' . $config->receta_instagram;
                if (!empty($config->receta_facebook))   $items[] = 'FB @' . $config->receta_facebook;
                if (!empty($config->receta_whatsapp))   $items[] = 'WA ' . $config->receta_whatsapp;
            @endphp
            {{ implode('  |  ', $items) }}
        </div>
    </div>

</div>
</body>
</html>