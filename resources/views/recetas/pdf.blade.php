<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
            padding: 0;
        }
        html, body {
            margin: 0;
            padding: 0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #3d3228; background: #faf8f4; padding: 0; }
        .page { width: 100%; min-height: 100vh; background: #faf8f4; display: flex; flex-direction: column; }
        .header { background: #c9b99a; padding: 18px 32px 16px; text-align: center; position: relative; }
        .logo-wrap { height: 100px; display: block; margin-bottom: 10px; }
        .logo-img { height: 130px; max-width: 280px; object-fit: contain; }
        .logo-initials { display: inline-block; width: 70px; height: 70px; border-radius: 50%; border: 1.5px solid rgba(255,255,255,.6); line-height: 70px; text-align: center; font-size: 24px; font-weight: bold; color: white; letter-spacing: 1px; }
        .header-nombre { font-size: 16px; font-weight: bold; color: white; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 3px; }
        .header-sub { font-size: 9px; color: rgba(255,255,255,.8); letter-spacing: 1.5px; text-transform: uppercase; }
        .body { padding: 24px 32px 90px; flex: 1; position: relative; }
        .logo-watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 600px; height: 700px; opacity: 0.2; object-fit: contain; z-index: 0; }
        .body-content { position: relative; z-index: 1; }
        .receta-titulo { text-align: center; margin-bottom: 16px; }
        .receta-titulo-table { display: table; width: 100%; }
        .receta-titulo-line { display: table-cell; vertical-align: middle; }
        .receta-titulo-line-inner { height: 1px; background: #c9b99a; }
        .receta-titulo-text-cell { display: table-cell; white-space: nowrap; padding: 0 14px; vertical-align: middle; }
        .receta-titulo-text { font-size: 8.5px; letter-spacing: 4px; text-transform: uppercase; color: #a09080; font-family: Arial, sans-serif; }
        .fecha-row { text-align: right; font-size: 9px; color: #8a7d6b; letter-spacing: 1px; margin-bottom: 18px; }
        .folio-badge { display: inline-block; font-size: 10px; font-weight: bold; color: #8a7d6b; background: #f2ede5; border: 1px solid #d6cfc4; border-radius: 4px; padding: 2px 8px; float: left; margin-top: -2px; }
        .divider { width: 100%; height: 1px; background: #d6cfc4; margin: 14px 0; }
        .paciente-nombre { font-size: 14px; font-weight: bold; color: #3d3228; letter-spacing: .5px; text-transform: uppercase; margin-bottom: 3px; }
        .paciente-dato { font-size: 9px; color: #8a7d6b; }
        .section { margin-bottom: 14px; }
        .section-label { font-size: 9px; color: #8a7d6b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
        .section-value { font-size: 11px; color: #3d3228; line-height: 1.6; }
        .med-item { background: #f2ede5; border-left: 3px solid #c9b99a; border-radius: 4px; padding: 10px 12px; margin-bottom: 8px; }
        .med-nombre { font-size: 12px; font-weight: bold; color: #3d3228; margin-bottom: 5px; }
        .med-detalle { font-size: 10px; color: #8a7d6b; line-height: 1.6; }
        .med-sep { color: #c9b99a; margin: 0 6px; }
        .firma-wrap { margin-top: 30px; text-align: center; }
        .firma-linea { width: 140px; border-top: 1px solid #8a7d6b; margin: 0 auto 6px; }
        .firma-nombre { font-size: 11px; font-weight: bold; color: #3d3228; letter-spacing: .5px; }
        .firma-sub { font-size: 9px; color: #8a7d6b; letter-spacing: .5px; margin-top: 2px; }
        .footer { background: #c9b99a; padding: 12px 24px 14px; text-align: center; position: fixed; bottom: 0; left: 0; right: 0; }
        .footer-linea { width: 40px; border-top: 1px solid rgba(255,255,255,.5); margin: 0 auto 6px; }
        .footer-nombre { font-size: 10px; font-weight: bold; color: white; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 6px; }
        .footer-datos { text-align: center; font-size: 8.5px; color: rgba(255,255,255,.95); line-height: 2; }
        .footer-item { font-size: 8.5px; color: white; letter-spacing: .2px; }
        .footer-sep { color: rgba(255,255,255,.35); font-size: 8px; margin: 0 4px; }
        .footer-prefix { font-size: 7.5px; color: rgba(255,255,255,.6); margin-right: 2px; }
        .clearfix::after { content: ''; display: table; clear: both; }
    </style>
</head>
<body>
<div class="page">

    {{-- HEADER --}}
    <div class="header">
        <div class="logo-wrap">
            @if($logoBase64)
                <img src="{{ $logoBase64 }}" class="logo-img" alt="Logo">
            @else
                <div class="logo-initials">
                    {{ strtoupper(substr($receta->medico->nombre, 0, 1)) }}{{ strtoupper(substr($receta->medico->apellido_paterno ?? $receta->medico->apellidos ?? '', 0, 1)) }}
                </div>
            @endif
        </div>
        <div class="header-nombre">{{ $receta->medico->nombre_completo }}</div>
        <div class="header-sub">
            {{ $receta->medico->especialidad->nombre ?? 'Medicina' }}
            @if($config && $config->clinica_telefono)
                &nbsp;·&nbsp; {{ $config->clinica_telefono }}
            @endif
        </div>
    </div>

    {{-- BODY --}}
    <div class="body">
        @if($logoFondoBase64)
        <img src="{{ $logoFondoBase64 }}" class="logo-watermark" alt="">
        @endif

        <div class="body-content">
            <div class="receta-titulo">
                <div class="receta-titulo-table">
                    <div class="receta-titulo-line"><div class="receta-titulo-line-inner"></div></div>
                    <div class="receta-titulo-text-cell"><span class="receta-titulo-text">Receta M&eacute;dica</span></div>
                    <div class="receta-titulo-line"><div class="receta-titulo-line-inner"></div></div>
                </div>
            </div>

            <div class="clearfix" style="margin-bottom:14px;">
                <span class="folio-badge">{{ $receta->folio }}</span>
                <div class="fecha-row">FECHA: {{ \Carbon\Carbon::parse($receta->fecha)->locale('es')->isoFormat('D [/] MMMM [/] YYYY') }}</div>
            </div>
            <div class="divider"></div>

            <div style="margin-bottom:14px;">
                <div class="section-label">Paciente</div>
                <div class="paciente-nombre">{{ $receta->paciente->nombre_completo }}</div>
                <div class="paciente-dato">
                    Exp: {{ $receta->paciente->numero_expediente ?? $receta->paciente->expediente ?? '—' }}
                    @if($receta->paciente->fecha_nacimiento)
                        &nbsp;·&nbsp; Nac: {{ \Carbon\Carbon::parse($receta->paciente->fecha_nacimiento)->format('d/m/Y') }}
                    @endif
                </div>
            </div>
            <div class="divider"></div>

            @if($receta->diagnostico)
            <div class="section">
                <div class="section-label">Diagnóstico</div>
                <div class="section-value">{{ $receta->diagnostico }}</div>
            </div>
            @endif

            <div class="section">
                <div class="section-label" style="margin-bottom:8px;">Medicamentos prescritos</div>
                @foreach($receta->items as $i => $item)
                <div class="med-item">
                    <div class="med-nombre">{{ $i + 1 }}. {{ $item->medicamento ?? $item->nombre }}</div>
                    <div class="med-detalle">
                        @if($item->dosis)<strong>Dosis:</strong> {{ $item->dosis }}@endif
                        @if($item->frecuencia)<span class="med-sep">·</span><strong>Frecuencia:</strong> {{ $item->frecuencia }}@endif
                        @if($item->duracion)<span class="med-sep">·</span><strong>Duración:</strong> {{ $item->duracion }}@endif
                        @if($item->indicaciones)<br>{{ $item->indicaciones }}@endif
                    </div>
                </div>
                @endforeach
            </div>

            @if($receta->indicaciones)
            <div class="section">
                <div class="section-label">Indicaciones generales</div>
                <div class="section-value">{{ $receta->indicaciones }}</div>
            </div>
            @endif

            <div class="firma-wrap">
                <div class="firma-linea"></div>
                <div class="firma-nombre">{{ $receta->medico->nombre_completo }}</div>
                <div class="firma-sub">{{ $receta->medico->especialidad->nombre ?? '' }}</div>
                @if($receta->medico->cedula ?? $receta->medico->cedula_profesional ?? null)
                <div class="firma-sub">Céd. Prof. {{ $receta->medico->cedula ?? $receta->medico->cedula_profesional }}</div>
                @endif
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <div class="footer-linea"></div>
        <div class="footer-nombre">{{ $receta->medico->nombre_completo }}</div>
        <div class="footer-datos">
            @php
                $ced = $receta->medico->cedula ?? $receta->medico->cedula_profesional ?? null;
                $footerParts = [];
                if ($ced) $footerParts[] = ['icon' => 'ced', 'text' => 'Ced. Prof. ' . $ced];
                if (!empty($config->receta_direccion))  $footerParts[] = ['icon' => 'loc', 'text' => $config->receta_direccion];
                if (!empty($config->receta_instagram))  $footerParts[] = ['icon' => 'ig',  'text' => '@' . $config->receta_instagram];
                if (!empty($config->receta_facebook))   $footerParts[] = ['icon' => 'fb',  'text' => '@' . $config->receta_facebook];
                if (!empty($config->receta_whatsapp))   $footerParts[] = ['icon' => 'wa',  'text' => $config->receta_whatsapp];
            @endphp
            @foreach($footerParts as $idx => $part)
                @if($idx > 0)<span class="footer-sep">|</span>@endif
                @if($part['icon'] === 'ig')<span class="footer-prefix">IG:</span>
                @elseif($part['icon'] === 'fb')<span class="footer-prefix">FB:</span>
                @elseif($part['icon'] === 'wa')<span class="footer-prefix">WA:</span>
                @endif
                <span class="footer-item">{{ $part['text'] }}</span>
            @endforeach
        </div>
    </div>

</div>
</body>
</html>