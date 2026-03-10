<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 9.5px; color: #2d2d2d; background: white; }
  .page { padding: 28px 38px 24px; }
  .header { display: table; width: 100%; padding-bottom: 10px; margin-bottom: 10px; border-bottom: 2px solid #b08d6e; }
  .header-left  { display: table-cell; vertical-align: middle; width: 55%; }
  .header-right { display: table-cell; vertical-align: middle; text-align: right; width: 45%; }
  .clinica-name { font-size: 15px; font-weight: 700; color: #1e293b; letter-spacing: 0.3px; }
  .clinica-sub  { font-size: 8.5px; color: #64748b; margin-top: 2px; }
  .clinica-contact { font-size: 8px; color: #94a3b8; margin-top: 4px; }
  .doc-main-title { font-size: 13px; font-weight: 700; color: #1e293b; text-transform: uppercase; letter-spacing: 0.5px; }
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
  .firma-line-box { border-top: 1.5px solid #334155; padding-top: 4px; margin-top: 38px; }
  .firma-name  { font-size: 9.5px; font-weight: 700; color: #1e293b; }
  .firma-label { font-size: 8px; color: #64748b; margin-top: 1px; }
  .prox-cita { margin-top: 10px; }
  .prox-label { font-size: 9.5px; font-weight: 700; color: #1e293b; margin-bottom: 3px; }
  .prox-line  { border-bottom: 1.5px solid #b08d6e; width: 100%; display: block; height: 14px; }
  .footer { margin-top: 10px; border-top: 1px solid #e2e8f0; padding-top: 6px; display: table; width: 100%; }
  .footer-left  { display: table-cell; font-size: 7.5px; color: #94a3b8; }
  .footer-right { display: table-cell; text-align: right; font-size: 7.5px; color: #94a3b8; }
  .blank { border-bottom: 1px solid #94a3b8; display: inline-block; min-width: 130px; padding: 0 3px; }
  .blank-sm { border-bottom: 1px solid #94a3b8; display: inline-block; min-width: 60px; padding: 0 3px; }
</style>
</head>
<body>
<div class="page">

  <div class="header">
    <div class="header-left">
      <div class="clinica-name">{{ $tratamiento->medico?->clinica?->nombre ?? 'Clinica Medico Estetica' }}</div>
      <div class="clinica-sub">{{ $tratamiento->medico?->clinica?->direccion ?? '' }}</div>
      <div class="clinica-contact">
        Dr(a). {{ $tratamiento->medico?->nombre }} {{ $tratamiento->medico?->apellidos }}
        &nbsp;&middot;&nbsp; Cedula: {{ $tratamiento->medico?->cedula_profesional ?? '-' }}
      </div>
    </div>
    <div class="header-right">
      <div class="doc-main-title">Consentimiento Informado<br>para Pacientes</div>
      <div class="doc-subtitle">Tu bienestar, nuestra prioridad</div>
      <div class="fecha-box">
        <strong>Fecha:</strong> {{ now()->format('d') }} / {{ now()->format('m') }} / {{ now()->format('Y') }}
      </div>
    </div>
  </div>

  <div class="campos">
    <div class="campo-row">
      <div class="campo-cell" style="width:38%;">
        <span class="campo-label">Lugar: </span>
        <span class="campo-line">{{ $tratamiento->medico?->clinica?->ciudad ?? '' }}</span>
      </div>
      <div class="campo-cell" style="width:62%;">
        <span class="campo-label">Nombre Completo del Paciente: </span>
        <span class="campo-line">{{ $tratamiento->paciente?->nombre }} {{ $tratamiento->paciente?->apellidos }}</span>
      </div>
    </div>
    <div class="campo-row">
      <div class="campo-cell" style="width:65%;">
        <span class="campo-label">Fecha de nacimiento del Paciente: </span>
        <span class="campo-line">{{ $tratamiento->paciente?->fecha_nacimiento?->format('d/m/Y') ?? '' }}</span>
      </div>
      <div class="campo-cell" style="width:35%;">
        <span class="campo-label">Edad: </span>
        <span class="campo-line">{{ $tratamiento->paciente?->fecha_nacimiento ? $tratamiento->paciente->fecha_nacimiento->age . ' anos' : '' }}</span>
      </div>
    </div>
  </div>

  <div class="punto">
    <span class="punto-num">1) </span>
    <span class="punto-text">Por medio de la presente autorizo a la <strong>Dr(a). {{ $tratamiento->medico?->nombre }} {{ $tratamiento->medico?->apellidos }}</strong>, con numero de cedula profesional <strong>{{ $tratamiento->medico?->cedula_profesional ?? '__________' }}</strong> a realizar el tratamiento cosmetico de minima invasion de <span class="blank">{{ $tratamiento->titulo ?? $tratamiento->tipoTratamiento?->nombre }}</span>, con numero de lote <span class="blank-sm">{{ $tratamiento->producto_lote ?? '' }}</span> y fecha de caducidad del biologico: <span class="blank-sm">{{ $tratamiento->producto_caducidad ? \Carbon\Carbon::parse($tratamiento->producto_caducidad)->format('m/Y') : '' }}</span> en las siguientes zonas: <span class="blank">{{ $tratamiento->zonas?->pluck('zona_label')->filter()->join(', ') }}</span></span>
  </div>

  <hr class="sep">

  <div class="punto">
    <span class="punto-num">2) </span>
    <span class="punto-text">He recibido explicacion previa por parte del medico sobre el procedimiento a realizarse. Entiendo los beneficios, riesgos y consecuencias, asi como posibles efectos adversos que son reversibles que se describen a continuacion:<br>
    <strong>RIESGOS/EVENTOS ADVERSOS:</strong> Cualquier procedimiento medico-estetico entrana un cierto grado de riesgo y es importante que se comprenda los riesgos asociados a este procedimiento:</span>
    <div class="sub-item"><strong>Inflamacion:</strong> Efecto adverso mas frecuente posterior al procedimiento inmediato y tardio, evolucion dentro de los 7-15 dias.</div>
    <div class="sub-item"><strong>Hematomas y eritema local (enrojecimiento cutaneo):</strong> Son frecuentes e inherentes al procedimiento, evolucionan normalmente de 7-21 dias, pudiendo haber variaciones.</div>
    <div class="sub-item"><strong>Asimetria:</strong> La cara humana es asimetrica normalmente. Puede existir variacion entre los dos lados despues del procedimiento.</div>
    <div class="sub-item"><strong>Reacciones alergicas:</strong> En casos excepcionales se han descrito alergias locales (rash, prurito, rubor). Pueden ocurrir reacciones sistemicas de mayor complicacion (fiebre), frente a biologicos utilizados durante el procedimiento o prescritas despues, las cuales pueden requerir tratamiento adicional.</div>
    <div class="sub-item"><strong>Cambios en la pigmentacion y marcas en la piel:</strong> Durante el proceso de recuperacion es posible que se produzca un cambio de coloracion (mas claro o mas oscuro) y/o alguna marca en los puntos de entrada de las agujas. Normalmente es temporal y el tiempo que demora en retornar al color natural dependera del biotipo de piel, el uso de fotoproteccion y exposicion solar.</div>
    <div class="sub-item"><strong>Efectos a largo plazo:</strong> Pueden ocurrir alteraciones subsecuentes como resultado del envejecimiento, perdidas o ganancias de peso, exposicion solar u otras circunstancias no relacionadas con el procedimiento.</div>
  </div>

  <div class="punto">
    <span class="punto-num">3) </span>
    <span class="punto-text">Acepto que el resultado del tratamiento y la duracion del efecto pueden variar de un paciente a otro por lo que eximo a la <strong>Dr(a). {{ $tratamiento->medico?->nombre }} {{ $tratamiento->medico?->apellidos }}</strong> de la responsabilidad, al tratarse de la aplicacion de un producto biologico, por lo que previo al procedimiento se me informa que:</span>
    <div class="sub-item">Existen riesgos y beneficios que conlleva el tratamiento.</div>
    <div class="sub-item">El tiempo de permanencia del resultado en cada paciente puede variar por causas propias del metabolismo corporal normal o de actividades que el propio paciente realice.</div>
    <div class="sub-item">Puede haber variantes anatomicas propias de cada individuo que pudieran interferir con el resultado deseado.</div>
    <div class="sub-item">Se pueden requerir una o mas sesiones en el futuro o tratamientos coadyuvantes (de ayuda) para mantener o intensificar los resultados.</div>
    <div class="sub-item">Por tratarse de zonas donde hay irrigacion (venas, arterias y capilares), puede haber sangrado al momento de realizar el procedimiento.</div>
    <div class="sub-item">Debo seguir al pie de la letra las indicaciones y cuidados posteriores al tratamiento realizado.</div>
    <div class="sub-item">La practica de la medicina no es una ciencia exacta, y aunque se esperan buenos resultados, no hay garantia explicita o implicita sobre los resultados a obtenerse.</div>
  </div>

  <hr class="sep-light">

  <div class="punto">
    <span class="punto-num">4) </span>
    <span class="punto-text">Confirmo que no he omitido datos sobre mis antecedentes clinicos, tales como intervenciones, alergias, patologias existentes, riesgos personales, etc.</span>
  </div>

  <div class="punto">
    <span class="punto-num">5) </span>
    <span class="punto-text">Soy consciente de que, durante el curso del tratamiento medico o anestesia, pueden darse condiciones imprevistas que necesiten procedimientos diferentes a los propuestos.</span>
  </div>

  <div class="punto">
    <span class="punto-num">6) </span>
    <span class="punto-text">Doy mi consentimiento para la administracion de anestesicos que se consideren necesarios o aconsejables. Comprendo que cualquier forma de anestesia conlleva un riesgo y la posibilidad de complicaciones, lesiones y a veces perdida de la vida.</span>
  </div>

  <div class="punto">
    <span class="punto-num">7) </span>
    <span class="punto-text">Recibi advertencias de que no se puede practicar la aplicacion de dicho procedimiento previamente mencionado con fines cosmeticos en los siguientes tipos de pacientes: mujeres embarazadas o en periodo de lactancia, pacientes con infeccion o inflamacion en la zona a realizar el procedimiento, pacientes tratados con aminoglucosidos, o que padezcan enfermedades neuromusculares.</span>
  </div>

  <div class="punto">
    <span class="punto-num">8) </span>
    <span class="punto-text">Doy mi autorizacion a ser fotografiado y/o filmado antes, durante y despues del tratamiento, para mi expediente medico, con fines exclusivamente de seguimiento clinico y/o academicos.</span>
  </div>

  <div class="punto">
    <span class="punto-num">9) </span>
    <span class="punto-text">Se me hizo saber que puedo ponerme en contacto con mi medico si tengo cualquier pregunta o comentario acerca del presente consentimiento unico.</span>
  </div>

  <div class="punto">
    <span class="punto-num">10) </span>
    <span class="punto-text">Entiendo que los terminos del presente tienen caracter obligatorio y no meramente declarativo y que este consentimiento unico es legalmente obligatorio para mi.</span>
  </div>

  <div class="punto">
    <span class="punto-num">11) </span>
    <span class="punto-text">Mediante la firma del presente consentimiento unico otorgo a los autorizados la liberacion de responsabilidad mas amplia que en derecho proceda con respecto a cualquier responsabilidad que se les quiera llegar a imponer derivada de cualquier hecho, acto u omision para los que he otorgado mi consentimiento, autorizacion o permiso de conformidad con el presente documento, incluidos los otorgados de conformidad con las clausulas anteriores e inclusive aun en el caso de que no se obtenga los resultados deseados. Por lo anterior, manifiesto bajo protesta de decir que: no me reservo derecho y/o accion legal alguno que ejercitar en contra de los autorizados; y renuncio a cualquier derecho que pueda tener para reclamar pagos o regalias de los autorizados.</span>
  </div>

  <div class="punto">
    <span class="punto-num">12) </span>
    <span class="punto-text">Manifiesto bajo protesta de decir verdad que he leido, entendido y me he informado cabalmente del contenido de este consentimiento unico previamente a su firma y que he tenido la oportunidad de realizar preguntas acerca del mismo.</span>
  </div>

  <hr class="sep-light">

  <div style="display:table;width:100%;margin-top:4px;">
    <div style="display:table-cell;width:50%;text-align:center;padding:0 24px;">
      <div class="firma-line-box">
        <div class="firma-name">{{ $tratamiento->paciente?->nombre }} {{ $tratamiento->paciente?->apellidos }}</div>
        <div class="firma-label">Nombre completo y firma del paciente</div>
      </div>
    </div>
    <div style="display:table-cell;width:50%;text-align:center;padding:0 24px;">
      <div class="firma-line-box">
        <div class="firma-name">&nbsp;</div>
        <div class="firma-label">Nombre completo y firma del testigo (opcional)</div>
      </div>
    </div>
  </div>

  <div style="text-align:center;margin-top:18px;">
    <div style="width:55%;margin:0 auto;">
      <div class="firma-line-box">
        <div class="firma-name">Dr(a). {{ $tratamiento->medico?->nombre }} {{ $tratamiento->medico?->apellidos }}</div>
        <div class="firma-label">Nombre completo y firma del Medico autorizado</div>
        <div style="font-size:7.5px;color:#94a3b8;margin-top:1px;">Cedula: {{ $tratamiento->medico?->cedula_profesional ?? '-' }}</div>
      </div>
    </div>
  </div>

  <div class="prox-cita">
    <div class="prox-label">Proxima cita:</div>
    <span class="prox-line"></span>
  </div>

  <div class="footer">
    <div class="footer-left">{{ $tratamiento->medico?->clinica?->nombre ?? 'Clinica' }} &nbsp;&middot;&nbsp; Folio CI-{{ str_pad($tratamiento->id, 5, '0', STR_PAD_LEFT) }}</div>
    <div class="footer-right">Generado el {{ now()->format('d/m/Y H:i') }} &nbsp;&middot;&nbsp; NOVASYSTEM</div>
  </div>

</div>
</body>
</html>
