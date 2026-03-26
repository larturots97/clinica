<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 8.5px; color: #2d2d2d; background: white; }
  .page { padding: 18px 32px 16px; position: relative; }
  .watermark { position: fixed; top: 50%; left: 50%; transform: translateX(-50%) translateY(-50%); opacity: 0.40; z-index: 0; }
  .watermark img { width: 380px; height: auto; }
  .content { position: relative; z-index: 1; }
  .header { display: table; width: 100%; padding-bottom: 7px; margin-bottom: 7px; border-bottom: 2px solid #b08d6e; }
  .header-left  { display: table-cell; vertical-align: middle; width: 55%; }
  .header-right { display: table-cell; vertical-align: middle; text-align: right; width: 45%; }
  .clinica-name { font-size: 13px; font-weight: 700; color: #1e293b; letter-spacing: 0.3px; }
  .clinica-sub  { font-size: 7.5px; color: #64748b; margin-top: 1px; }
  .clinica-contact { font-size: 7px; color: #94a3b8; margin-top: 3px; }
  .doc-main-title { font-size: 9px; font-weight: 700; color: #1e293b; text-transform: uppercase; letter-spacing: 0.5px; }
  .doc-subtitle   { font-size: 8px; color: #b08d6e; font-style: italic; margin-top: 2px; }
  .fecha-box { margin-top: 4px; font-size: 8px; color: #374151; }
  .campos { margin-bottom: 7px; border-bottom: 1px solid #e2e8f0; padding-bottom: 6px; }
  .campo-row { display: table; width: 100%; margin-bottom: 3px; }
  .campo-cell { display: table-cell; vertical-align: bottom; padding-right: 8px; }
  .campo-label { font-size: 8px; font-weight: 700; color: #374151; }
  .campo-line { border-bottom: 1px solid #94a3b8; min-width: 80px; display: inline-block; padding: 0 4px; font-size: 8px; color: #1e293b; }
  .punto { margin-bottom: 5px; line-height: 1.45; }
  .punto-num { font-weight: 700; font-size: 8.5px; color: #1e293b; }
  .punto-text { font-size: 8px; color: #374151; text-align: justify; }
  .punto-text strong { color: #1e293b; }
  .sub-item { padding-left: 8px; margin-top: 2px; font-size: 7.5px; color: #374151; line-height: 1.4; text-align: justify; }
  .sub-item strong { color: #1e293b; }
  .sep { border: none; border-top: 1.5px solid #b08d6e; margin: 6px 0; }
  .sep-light { border: none; border-top: 1px dashed #e2e8f0; margin: 4px 0; }
  .footer { margin-top: 6px; border-top: 1px solid #e2e8f0; padding-top: 4px; display: table; width: 100%; }
  .footer-left  { display: table-cell; font-size: 7px; color: #94a3b8; }
  .footer-right { display: table-cell; text-align: right; font-size: 7px; color: #94a3b8; }
  .blank { border-bottom: 1px solid #94a3b8; display: inline-block; min-width: 100px; padding: 0 3px; }
  .blank-sm { border-bottom: 1px solid #94a3b8; display: inline-block; min-width: 50px; padding: 0 3px; }
</style>
</head>
<body>
<div class="page">

  @if($logoBase64)
  <div class="watermark">
    <img src="{{ $logoBase64 }}" alt="">
  </div>
  @endif

  <div class="content">

    {{-- HEADER --}}
    <div class="header">
      <div class="header-left">
        <div style="display:table; width:100%;">
          @if($logoBase64)
          <div style="display:table-cell; vertical-align:middle; width:70px; padding-right:8px;">
            <img src="{{ $logoBase64 }}" style="max-height:46px; max-width:80px; object-fit:contain; display:block;">
          </div>
          @endif
          <div style="display:table-cell; vertical-align:middle;">
            <div class="clinica-name">{{ $config?->clinica_nombre ?? $tratamiento->medico?->clinica?->nombre ?? 'Clinica Medico Estetica' }}</div>
            <div class="clinica-sub">
              {{ $config?->clinica_direccion ?? $tratamiento->medico?->clinica?->direccion ?? '' }}
              @if($config?->clinica_ciudad ?? $tratamiento->medico?->clinica?->ciudad ?? '')
                &nbsp;&mdash;&nbsp;{{ $config?->clinica_ciudad ?? $tratamiento->medico?->clinica?->ciudad ?? '' }}
              @endif
            </div>
            <div class="clinica-contact">
              @if($config?->clinica_telefono) Tel: {{ $config->clinica_telefono }} @if($config?->clinica_email) &nbsp;&middot;&nbsp; @endif @endif
              @if($config?->clinica_email) {{ $config->clinica_email }} &nbsp;&middot;&nbsp; @endif
              Dr(a). {{ $tratamiento->medico?->nombre }} {{ $tratamiento->medico?->apellidos }}
              &nbsp;&middot;&nbsp; Cedula: {{ $tratamiento->medico?->cedula_profesional ?? '-' }}
            </div>
          </div>
        </div>
      </div>
      <div class="header-right">
        <div class="doc-main-title">Consentimiento Informado<br>para Pacientes</div>
        <div class="doc-subtitle">Tu bienestar, nuestra prioridad</div>
        <div class="fecha-box"><strong>Fecha:</strong> {{ now()->format('d') }} / {{ now()->format('m') }} / {{ now()->format('Y') }}</div>
      </div>
    </div>

    {{-- DATOS PACIENTE --}}
    <div class="campos">
      <div class="campo-row">
        <div class="campo-cell" style="width:38%;"><span class="campo-label">Lugar: </span><span class="campo-line">{{ $config?->clinica_ciudad ?? $tratamiento->medico?->clinica?->ciudad ?? '' }}</span></div>
        <div class="campo-cell" style="width:62%;"><span class="campo-label">Nombre Completo del Paciente: </span><span class="campo-line">{{ $tratamiento->paciente?->nombre }} {{ $tratamiento->paciente?->apellidos }}</span></div>
      </div>
      <div class="campo-row">
        <div class="campo-cell" style="width:65%;"><span class="campo-label">Fecha de nacimiento: </span><span class="campo-line">{{ $tratamiento->paciente?->fecha_nacimiento?->format('d/m/Y') ?? '' }}</span></div>
        <div class="campo-cell" style="width:35%;"><span class="campo-label">Edad: </span><span class="campo-line">{{ $tratamiento->paciente?->fecha_nacimiento ? $tratamiento->paciente->fecha_nacimiento->age . ' anos' : '' }}</span></div>
      </div>
    </div>

    {{-- PUNTO 1 --}}
    @php
      $zonaLabelsMap = [
        'F'=>'Frente','GL'=>'Glabela','PGI'=>'Patas de gallo izq.','PGD'=>'Patas de gallo der.',
        'BL'=>'Bunny lines','L'=>'Labios','MI'=>'Masetero izq.','MD'=>'Masetero der.','C'=>'Cuello',
      ];
      $zonasTexto = $tratamiento->zonas?->map(function($z) use ($zonaLabelsMap) {
          return $z->zona_label ?: ($zonaLabelsMap[$z->zona] ?? $z->zona);
      })->filter()->unique()->join(', ');
      if (!$zonasTexto && $tratamiento->zonas_texto) $zonasTexto = $tratamiento->zonas_texto;
    @endphp
    <div class="punto">
      <span class="punto-num">1) </span>
      <span class="punto-text">Por medio de la presente autorizo a la <strong>Dr(a). {{ $tratamiento->medico?->nombre }} {{ $tratamiento->medico?->apellidos }}</strong>, cedula <strong>{{ $tratamiento->medico?->cedula_profesional ?? '__________' }}</strong> a realizar el tratamiento de <span class="blank">{{ $tratamiento->titulo ?? $tratamiento->tipoTratamiento?->nombre }}</span>, lote <span class="blank-sm">{{ $tratamiento->producto_lote ?? '' }}</span> caducidad: <span class="blank-sm">{{ $tratamiento->producto_caducidad ? \Carbon\Carbon::parse($tratamiento->producto_caducidad)->format('m/Y') : '' }}</span> en zonas: <span class="blank">{{ $zonasTexto ?: '________________________' }}</span></span>
    </div>

    <hr class="sep">

    {{-- PUNTO 2 --}}
    @if(!empty($config?->consentimiento_punto_2))
      <div class="punto"><span class="punto-num">2) </span><span class="punto-text">{!! nl2br(e($config->consentimiento_punto_2)) !!}</span></div>
    @else
      <div class="punto"><span class="punto-num">2) </span><span class="punto-text">He recibido explicacion previa sobre el procedimiento. Entiendo beneficios, riesgos y posibles efectos adversos reversibles. <strong>RIESGOS/EVENTOS ADVERSOS:</strong></span>
        <div class="sub-item"><strong>Inflamacion:</strong> Mas frecuente, evoluciona en 7-15 dias.</div>
        <div class="sub-item"><strong>Hematomas y eritema:</strong> Frecuentes e inherentes, evolucionan en 7-21 dias.</div>
        <div class="sub-item"><strong>Asimetria:</strong> La cara es asimetrica normalmente, puede variar tras el procedimiento.</div>
        <div class="sub-item"><strong>Reacciones alergicas:</strong> En casos excepcionales pueden ocurrir reacciones locales o sistemicas.</div>
        <div class="sub-item"><strong>Cambios en pigmentacion:</strong> Posible cambio temporal segun biotipo de piel y exposicion solar.</div>
        <div class="sub-item"><strong>Efectos a largo plazo:</strong> Alteraciones por envejecimiento, cambios de peso u otras circunstancias.</div>
      </div>
    @endif

    {{-- PUNTO 3 --}}
    <div class="punto">
      <span class="punto-num">3) </span>
      @if(!empty($config?->consentimiento_punto_3))
        <span class="punto-text">{!! nl2br(e($config->consentimiento_punto_3)) !!}</span>
      @else
        <span class="punto-text">Acepto que el resultado puede variar entre pacientes y eximo a la <strong>Dr(a). {{ $tratamiento->medico?->nombre }} {{ $tratamiento->medico?->apellidos }}</strong> de responsabilidad. Se me informa que: el tiempo de permanencia varia por metabolismo; puede requerir sesiones adicionales; puede haber sangrado; debo seguir indicaciones post-tratamiento; no hay garantia de resultados.</span>
      @endif
    </div>

    <hr class="sep-light">

    {{-- PUNTOS 4-12 --}}
    @php
      $defaultPuntos = [
        4  => 'Confirmo que no he omitido datos sobre mis antecedentes clinicos, alergias, patologias existentes o riesgos personales.',
        5  => 'Soy consciente de que pueden darse condiciones imprevistas que necesiten procedimientos diferentes a los propuestos.',
        6  => 'Doy consentimiento para anestesicos que se consideren necesarios, comprendiendo que conllevan riesgo y posibilidad de complicaciones.',
        7  => 'Fui advertido de que no se puede practicar en: mujeres embarazadas o lactando, infeccion en la zona, tratados con aminoglucosidos, o enfermedades neuromusculares.',
        8  => 'Autorizo ser fotografiado antes, durante y despues del tratamiento para mi expediente medico y fines academicos.',
        9  => 'Se me indico que puedo contactar a mi medico si tengo preguntas sobre este consentimiento.',
        10 => 'Entiendo que los terminos del presente tienen caracter obligatorio y son legalmente vinculantes.',
        11 => 'Mediante esta firma otorgo la liberacion de responsabilidad mas amplia en derecho con respecto a los actos autorizados.',
        12 => 'Manifiesto bajo protesta de decir verdad que he leido, entendido y me he informado del contenido de este consentimiento antes de firmarlo.',
      ];
    @endphp

    @for($i = 4; $i <= 12; $i++)
      @php $texto = !empty($config?->{"consentimiento_punto_$i"}) ? $config->{"consentimiento_punto_$i"} : ($defaultPuntos[$i] ?? ''); @endphp
      @if($texto)
        <div class="punto"><span class="punto-num">{{ $i }}) </span><span class="punto-text">{!! nl2br(e($texto)) !!}</span></div>
        @if($i === 7) <hr class="sep-light"> @endif
        @if($i === 11) <hr class="sep-light"> @endif
      @endif
    @endfor

    <hr class="sep-light">

    {{-- FIRMAS --}}
    <table style="width:100%; margin-top:12px; border-collapse:collapse;">
      <tr>
        <td style="width:40%; text-align:center; padding:0 10px; vertical-align:bottom;">
          @if($tratamiento->firma_paciente)
            <img src="{{ $tratamiento->firma_paciente }}" style="max-height:50px; max-width:140px; display:block; margin:0 auto;">
          @else
            <div style="height:50px;"></div>
          @endif
          <div style="border-top:1.5px solid #334155; padding-top:3px; margin-top:2px;">
            <div style="font-size:8.5px; font-weight:700; color:#1e293b;">{{ $tratamiento->paciente?->nombre }} {{ $tratamiento->paciente?->apellidos }}</div>
            <div style="font-size:7px; color:#64748b; margin-top:1px;">Nombre completo y firma del paciente</div>
            @if($tratamiento->firma_paciente_at)
              <div style="font-size:6.5px; color:#94a3b8; margin-top:1px;">Firmado el {{ \Carbon\Carbon::parse($tratamiento->firma_paciente_at)->format('d/m/Y H:i') }}</div>
            @endif
          </div>
        </td>
        <td style="width:32%; text-align:center; padding:0 10px; vertical-align:bottom;">
          @if($firmaBase64)
            <img src="{{ $firmaBase64 }}" style="max-height:50px; max-width:130px; display:block; margin:0 auto;">
          @else
            <div style="height:50px;"></div>
          @endif
          <div style="border-top:1.5px solid #334155; padding-top:3px; margin-top:2px;">
            <div style="font-size:8.5px; font-weight:700; color:#1e293b;">Dr(a). {{ $tratamiento->medico?->nombre }} {{ $tratamiento->medico?->apellidos }}</div>
            <div style="font-size:7px; color:#64748b; margin-top:1px;">Firma del Médico autorizado</div>
            <div style="font-size:6.5px; color:#94a3b8; margin-top:1px;">Cédula: {{ $tratamiento->medico?->cedula_profesional ?? '-' }}</div>
          </div>
        </td>
      </tr>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
      <div class="footer-left">{{ $config?->clinica_nombre ?? $tratamiento->medico?->clinica?->nombre ?? 'Clinica' }} &nbsp;&middot;&nbsp; Folio CI-{{ str_pad($tratamiento->id, 5, '0', STR_PAD_LEFT) }}</div>
      <div class="footer-right">Generado el {{ now()->format('d/m/Y H:i') }} &nbsp;&middot;&nbsp; NOVASYSTEM</div>
    </div>

  </div>
</div>
</body>
</html>