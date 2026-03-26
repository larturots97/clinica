<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 9.5px; color: #2d2d2d; background: white; }
  .page { padding: 28px 38px 24px; position: relative; }
  .watermark { position: fixed; top: 50%; left: 50%; transform: translateX(-50%) translateY(-50%); opacity: 0.40; z-index: 0; }
  .watermark img { width: 420px; height: auto; }
  .content { position: relative; z-index: 1; }
  .header { display: table; width: 100%; padding-bottom: 10px; margin-bottom: 10px; border-bottom: 2px solid #b08d6e; }
  .header-left  { display: table-cell; vertical-align: middle; width: 55%; }
  .header-right { display: table-cell; vertical-align: middle; text-align: right; width: 45%; }
  .clinica-name { font-size: 15px; font-weight: 700; color: #1e293b; letter-spacing: 0.3px; }
  .clinica-sub  { font-size: 8.5px; color: #64748b; margin-top: 2px; }
  .clinica-contact { font-size: 8px; color: #94a3b8; margin-top: 4px; }
  .doc-main-title { font-size: 10px; font-weight: 700; color: #1e293b; text-transform: uppercase; letter-spacing: 0.5px; }
  .doc-subtitle   { font-size: 9px; color: #b08d6e; font-style: italic; margin-top: 3px; }
  .fecha-box { margin-top: 6px; font-size: 9px; color: #374151; }
  .campos { margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px; }
  .campo-row { display: table; width: 100%; margin-bottom: 5px; }
  .campo-cell { display: table-cell; vertical-align: bottom; padding-right: 10px; }
  .campo-label { font-size: 9px; font-weight: 700; color: #374151; }
  .campo-line { border-bottom: 1px solid #94a3b8; min-width: 80px; display: inline-block; padding: 0 4px; font-size: 9px; color: #1e293b; }
  .punto { margin-bottom: 7px; line-height: 1.55; }
  .punto-num { font-weight: 700; font-size: 9.5px; color: #1e293b; }
  .punto-text { font-size: 9px; color: #374151; text-align: justify; }
  .punto-text strong { color: #1e293b; }
  .sub-item { padding-left: 10px; margin-top: 3px; font-size: 9px; color: #374151; line-height: 1.5; text-align: justify; }
  .sub-item strong { color: #1e293b; }
  .sep { border: none; border-top: 1.5px solid #b08d6e; margin: 10px 0; }
  .sep-light { border: none; border-top: 1px dashed #e2e8f0; margin: 6px 0; }
  .footer { margin-top: 10px; border-top: 1px solid #e2e8f0; padding-top: 6px; display: table; width: 100%; }
  .footer-left  { display: table-cell; font-size: 7.5px; color: #94a3b8; }
  .footer-right { display: table-cell; text-align: right; font-size: 7.5px; color: #94a3b8; }
  .blank { border-bottom: 1px solid #94a3b8; display: inline-block; min-width: 130px; padding: 0 3px; }
  .blank-sm { border-bottom: 1px solid #94a3b8; display: inline-block; min-width: 60px; padding: 0 3px; }
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
          <div style="display:table-cell; vertical-align:middle; width:90px; padding-right:10px;">
            <img src="{{ $logoBase64 }}" style="max-height:60px; max-width:100px; object-fit:contain; display:block;">
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
        <div class="campo-cell" style="width:65%;"><span class="campo-label">Fecha de nacimiento del Paciente: </span><span class="campo-line">{{ $tratamiento->paciente?->fecha_nacimiento?->format('d/m/Y') ?? '' }}</span></div>
        <div class="campo-cell" style="width:35%;"><span class="campo-label">Edad: </span><span class="campo-line">{{ $tratamiento->paciente?->fecha_nacimiento ? $tratamiento->paciente->fecha_nacimiento->age . ' anos' : '' }}</span></div>
      </div>
    </div>

    {{-- PUNTO 1 --}}
    @php
      $zonaLabelsMap = [
        'F'   => 'Frente',
        'GL'  => 'Glabela (entrecejo)',
        'PGI' => 'Patas de gallo izq.',
        'PGD' => 'Patas de gallo der.',
        'BL'  => 'Bunny lines',
        'L'   => 'Labios / Peribucales',
        'MI'  => 'Masetero izq.',
        'MD'  => 'Masetero der.',
        'C'   => 'Cuello',
      ];
      $zonasTexto = $tratamiento->zonas?->map(function($z) use ($zonaLabelsMap) {
          return $z->zona_label ?: ($zonaLabelsMap[$z->zona] ?? $z->zona);
      })->filter()->unique()->join(', ');

      if (!$zonasTexto && $tratamiento->zonas_texto) {
          $zonasTexto = $tratamiento->zonas_texto;
      }
    @endphp
    <div class="punto">
      <span class="punto-num">1) </span>
      <span class="punto-text">Por medio de la presente autorizo a la <strong>Dr(a). {{ $tratamiento->medico?->nombre }} {{ $tratamiento->medico?->apellidos }}</strong>, con numero de cedula profesional <strong>{{ $tratamiento->medico?->cedula_profesional ?? '__________' }}</strong> a realizar el tratamiento estetico de minima invasion de <span class="blank">{{ $tratamiento->titulo ?? $tratamiento->tipoTratamiento?->nombre }}</span>, con numero de lote <span class="blank-sm">{{ $tratamiento->producto_lote ?? '' }}</span> y fecha de caducidad del biologico: <span class="blank-sm">{{ $tratamiento->producto_caducidad ? \Carbon\Carbon::parse($tratamiento->producto_caducidad)->format('m/Y') : '' }}</span> en las siguientes zonas: <span class="blank">{{ $zonasTexto ?: '________________________' }}</span></span>
    </div>

    <hr class="sep">

    {{-- PUNTO 2 --}}
    @if(!empty($config?->consentimiento_punto_2))
      <div class="punto"><span class="punto-num">2) </span><span class="punto-text">{!! nl2br(e($config->consentimiento_punto_2)) !!}</span></div>
    @else
      <div class="punto"><span class="punto-num">2) </span><span class="punto-text">He recibido explicacion previa por parte del medico sobre el procedimiento a realizarse. Entiendo los beneficios, riesgos y consecuencias, asi como posibles efectos adversos que son reversibles:<br><strong>RIESGOS/EVENTOS ADVERSOS:</strong></span>
        <div class="sub-item"><strong>Inflamacion:</strong> Efecto adverso mas frecuente, evolucion dentro de los 7-15 dias.</div>
        <div class="sub-item"><strong>Hematomas y eritema local:</strong> Son frecuentes e inherentes al procedimiento, evolucionan normalmente de 7-21 dias.</div>
        <div class="sub-item"><strong>Asimetria:</strong> La cara humana es asimetrica normalmente. Puede existir variacion entre los dos lados despues del procedimiento.</div>
        <div class="sub-item"><strong>Reacciones alergicas:</strong> En casos excepcionales se han descrito alergias locales o reacciones sistemicas de mayor complicacion.</div>
        <div class="sub-item"><strong>Cambios en la pigmentacion:</strong> Posible cambio de coloracion temporal dependiendo del biotipo de piel y exposicion solar.</div>
        <div class="sub-item"><strong>Efectos a largo plazo:</strong> Pueden ocurrir alteraciones por envejecimiento, cambios de peso u otras circunstancias no relacionadas.</div>
      </div>
    @endif

    {{-- PUNTO 3 --}}
    <div class="punto">
      <span class="punto-num">3) </span>
      @if(!empty($config?->consentimiento_punto_3))
        <span class="punto-text">{!! nl2br(e($config->consentimiento_punto_3)) !!}</span>
      @else
        <span class="punto-text">Acepto que el resultado del tratamiento y la duracion del efecto pueden variar de un paciente a otro por lo que eximo a la <strong>Dr(a). {{ $tratamiento->medico?->nombre }} {{ $tratamiento->medico?->apellidos }}</strong> de la responsabilidad, al tratarse de la aplicacion de un producto biologico, por lo que previo al procedimiento se me informa que:</span>
        <div class="sub-item">Existen riesgos y beneficios que conlleva el tratamiento.</div>
        <div class="sub-item">El tiempo de permanencia del resultado puede variar por causas propias del metabolismo corporal normal.</div>
        <div class="sub-item">Puede haber variantes anatomicas propias de cada individuo que pudieran interferir con el resultado deseado.</div>
        <div class="sub-item">Se pueden requerir una o mas sesiones en el futuro o tratamientos coadyuvantes para mantener los resultados.</div>
        <div class="sub-item">Por tratarse de zonas donde hay irrigacion, puede haber sangrado al momento de realizar el procedimiento.</div>
        <div class="sub-item">Debo seguir al pie de la letra las indicaciones y cuidados posteriores al tratamiento realizado.</div>
        <div class="sub-item">La practica de la medicina no es una ciencia exacta, y aunque se esperan buenos resultados, no hay garantia explicita o implicita sobre los resultados.</div>
      @endif
    </div>

    <hr class="sep-light">

    {{-- PUNTOS 4-12 --}}
    @php
      $defaultPuntos = [
        4  => 'Confirmo que no he omitido datos sobre mis antecedentes clinicos, tales como intervenciones, alergias, patologias existentes, riesgos personales, etc.',
        5  => 'Soy consciente de que, durante el curso del tratamiento, pueden darse condiciones imprevistas que necesiten procedimientos diferentes a los propuestos.',
        6  => 'Doy mi consentimiento para la administracion de anestesicos que se consideren necesarios. Comprendo que cualquier forma de anestesia conlleva un riesgo y la posibilidad de complicaciones.',
        7  => 'Recibi advertencias de que no se puede practicar dicho procedimiento en: mujeres embarazadas o en periodo de lactancia, pacientes con infeccion en la zona, pacientes tratados con aminoglucosidos, o que padezcan enfermedades neuromusculares.',
        8  => 'Doy mi autorizacion a ser fotografiado antes, durante y despues del tratamiento, para mi expediente medico, con fines de seguimiento clinico y/o academicos.',
        9  => 'Se me hizo saber que puedo ponerme en contacto con mi medico si tengo cualquier pregunta acerca del presente consentimiento.',
        10 => 'Entiendo que los terminos del presente tienen caracter obligatorio y que este consentimiento es legalmente obligatorio para mi.',
        11 => 'Mediante la firma del presente consentimiento otorgo a los autorizados la liberacion de responsabilidad mas amplia que en derecho proceda con respecto a cualquier responsabilidad derivada de los actos para los que he otorgado mi consentimiento.',
        12 => 'Manifiesto bajo protesta de decir verdad que he leido, entendido y me he informado cabalmente del contenido de este consentimiento previamente a su firma y que he tenido la oportunidad de realizar preguntas acerca del mismo.',
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
    <table style="width:100%; margin-top:20px; border-collapse:collapse;">
      <tr>
        <td style="width:40%; text-align:center; padding:0 10px; vertical-align:bottom;">
          @if($tratamiento->firma_paciente)
            <img src="{{ $tratamiento->firma_paciente }}" style="max-height:60px; max-width:160px; display:block; margin:0 auto;">
          @endif
          <div style="border-top:1.5px solid #334155; padding-top:4px; margin-top:2px;">
            <div style="font-size:9.5px; font-weight:700; color:#1e293b;">{{ $tratamiento->paciente?->nombre }} {{ $tratamiento->paciente?->apellidos }}</div>
            <div style="font-size:8px; color:#64748b; margin-top:1px;">Nombre completo y firma del paciente</div>
            @if($tratamiento->firma_paciente_at)
              <div style="font-size:7px; color:#94a3b8; margin-top:1px;">Firmado el {{ \Carbon\Carbon::parse($tratamiento->firma_paciente_at)->format('d/m/Y H:i') }}</div>
            @endif
          </div>
        </td>
        <td style="width:32%; text-align:center; padding:0 10px; vertical-align:bottom;">
          @if($firmaBase64)
            <img src="{{ $firmaBase64 }}" style="max-height:60px; max-width:150px; display:block; margin:0 auto;">
          @else
            <div style="height:60px;"></div>
          @endif
          <div style="border-top:1.5px solid #334155; padding-top:4px; margin-top:2px;">
            <div style="font-size:9.5px; font-weight:700; color:#1e293b;">Dr(a). {{ $tratamiento->medico?->nombre }} {{ $tratamiento->medico?->apellidos }}</div>
            <div style="font-size:8px; color:#64748b; margin-top:1px;">Firma del Médico autorizado</div>
            <div style="font-size:7px; color:#94a3b8; margin-top:1px;">Cédula: {{ $tratamiento->medico?->cedula_profesional ?? '-' }}</div>
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