<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:DejaVu Sans,sans-serif; font-size:9.5px; color:#1a1208; background:#f6f1eb; }
.page { padding:0; background:#f6f1eb; }
.header { background:#fffcf7; border-bottom:2px solid #795300; padding:18px 26px 14px; }
.header-inner { display:table; width:100%; }
.header-left  { display:table-cell; vertical-align:middle; width:65%; }
.header-right { display:table-cell; vertical-align:middle; text-align:right; width:35%; }
.doc-type  { font-size:7.5px; font-weight:bold; letter-spacing:2.5px; text-transform:uppercase; color:#795300; margin-bottom:4px; }
.doc-title { font-size:15px; font-weight:bold; color:#1a1208; line-height:1.2; }
.doc-sub   { font-size:9px; color:#8a7355; margin-top:3px; }
.folio-badge { display:inline-block; background:#795300; color:#fffcf7; font-size:11px; font-weight:bold; padding:5px 16px; border-radius:3px; letter-spacing:.5px; }
.header-date { font-size:8px; color:#8a7355; margin-top:5px; }
.patient-band { background:#ffffff; border-bottom:1px solid #e5d4b8; padding:12px 26px; }
.patient-inner { display:table; width:100%; }
.pat-av-cell { display:table-cell; vertical-align:middle; width:44px; padding-right:12px; }
.pat-avatar { width:38px; height:38px; border-radius:50%; background:#f6f1eb; border:2px solid rgba(121,83,0,.2); text-align:center; line-height:38px; font-size:13px; font-weight:bold; color:#795300; }
.pat-info-cell { display:table-cell; vertical-align:middle; }
.pat-name { font-size:14px; font-weight:bold; color:#1a1208; margin-bottom:3px; }
.pat-meta { font-size:8.5px; color:#8a7355; }
.pat-tags-cell { display:table-cell; vertical-align:middle; text-align:right; white-space:nowrap; }
.ptag { display:inline-block; padding:3px 9px; border-radius:3px; font-size:8px; font-weight:bold; margin-left:5px; }
.ptag-blood { background:rgba(180,40,40,.07); color:#b42828; border:1px solid rgba(180,40,40,.2); }
.ptag-exp   { background:rgba(121,83,0,.07);  color:#795300; border:1px solid rgba(121,83,0,.25); }
.body { padding:12px 16px; }
.card { background:#ffffff; border-radius:7px; border:1px solid #e5d4b8; margin-bottom:10px; overflow:hidden; }
.card-head { padding:8px 14px; background:#fffcf7; border-bottom:1px solid #e5d4b8; }
.card-head-inner { display:table; width:100%; }
.ch-dot-cell  { display:table-cell; vertical-align:middle; width:12px; }
.ch-dot       { width:7px; height:7px; border-radius:50%; background:#795300; display:inline-block; }
.ch-title-cell{ display:table-cell; vertical-align:middle; }
.ch-title     { font-size:8px; font-weight:bold; text-transform:uppercase; letter-spacing:1px; color:#8a7355; }
.card-body    { padding:12px 14px; }
.g2   { display:table; width:100%; }
.g2-l { display:table-cell; width:50%; vertical-align:top; padding-right:14px; }
.g2-r { display:table-cell; width:50%; vertical-align:top; }
.g3   { display:table; width:100%; }
.g3-c { display:table-cell; width:33.3%; vertical-align:top; padding-right:10px; }
.g3-c:last-child { padding-right:0; }
.field     { margin-bottom:7px; }
.lbl       { font-size:7.5px; color:#c4a97a; text-transform:uppercase; letter-spacing:.4px; margin-bottom:2px; }
.val       { font-size:10px; color:#1a1208; font-weight:bold; }
.val-light { font-size:10px; color:#1a1208; }
.cb-table     { display:table; width:100%; margin-bottom:4px; }
.cb-icon-cell { display:table-cell; width:14px; vertical-align:top; }
.cb-box       { width:10px; height:10px; border-radius:2px; border:1.5px solid #e5d4b8; display:inline-block; text-align:center; line-height:9px; font-size:7px; color:white; }
.cb-box-on    { background:#795300; border-color:#795300; }
.cb-txt-cell  { display:table-cell; vertical-align:top; font-size:8.5px; padding-left:2px; }
.neg          { color:#c4a97a; font-style:italic; font-size:8px; }
.tag-item { display:inline-block; padding:2px 9px; border-radius:20px; font-size:8px; margin:0 3px 3px 0; }
.tag-on   { background:rgba(121,83,0,.08); border:1px solid rgba(121,83,0,.25); color:#795300; font-weight:bold; }
.tag-off  { background:#f6f1eb; border:1px solid #e5d4b8; color:#c4a97a; }
.fitz-table  { display:table; }
.fitz-cell   { display:table-cell; text-align:center; padding:0 4px 0 0; vertical-align:top; }
.fitz-circle { width:20px; height:20px; border-radius:50%; border:1.5px solid #e5d4b8; display:block; margin:0 auto 3px; }
.fitz-sel    { border:2.5px solid #795300; }
.fitz-num    { font-size:7.5px; color:#c4a97a; }
.fitz-numsel { font-size:7.5px; color:#795300; font-weight:bold; }
.vitals-table { display:table; width:100%; border:1px solid #e5d4b8; border-radius:5px; overflow:hidden; background:#ffffff; }
.vitals-row   { display:table-row; }
.vital-cell   { display:table-cell; width:16.66%; text-align:center; padding:10px 4px; border-right:1px solid #f6f1eb; vertical-align:top; }
.vital-cell:last-child { border-right:none; }
.vit-lbl      { font-size:7px; color:#c4a97a; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px; }
.vit-val      { font-size:15px; font-weight:bold; color:#1a1208; line-height:1; font-family:DejaVu Sans,sans-serif; }
.vit-unit     { font-size:7px; color:#c4a97a; }
.dosis-tbl    { width:100%; border-collapse:collapse; font-size:9px; }
.dosis-tbl th { background:#795300; color:#fffcf7; padding:4px 7px; text-align:left; font-size:7.5px; text-transform:uppercase; letter-spacing:.3px; }
.dosis-tbl td { padding:4px 7px; border-bottom:1px solid #f6f1eb; color:#1a1208; }
.dosis-tbl tr:nth-child(even) td { background:#fffcf7; }
.td-num   { text-align:center; font-weight:bold; color:#795300; }
.td-total { background:#f6f1eb !important; font-weight:bold; color:#795300; }
.mapa-layout { display:table; width:100%; }
.mapa-col    { display:table-cell; width:185px; vertical-align:top; padding-right:14px; }
.tabla-col   { display:table-cell; vertical-align:top; }
.obs-box { border:1px solid #e5d4b8; border-radius:5px; padding:7px 10px; font-size:9px; min-height:30px; background:#fffcf7; color:#1a1208; line-height:1.6; }
.firmas-table { display:table; width:100%; margin-top:14px; border-top:1.5px solid #e5d4b8; padding-top:12px; }
.firma-cell   { display:table-cell; width:50%; text-align:center; padding:0 14px; vertical-align:bottom; }
.firma-linea  { border-top:1.5px solid #795300; width:80%; margin:0 auto 3px; }
.firma-nombre { font-size:9px; font-weight:bold; color:#1a1208; }
.firma-sub    { font-size:7.5px; color:#8a7355; }
.footer { background:#fffcf7; border-top:1px solid #e5d4b8; padding:9px 26px; text-align:center; font-size:7.5px; color:#c4a97a; }
.footer strong { color:#795300; }
.watermark { position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); opacity:0.045; z-index:0; }
</style>
</head>
<body>
<div class="page">

{{-- WATERMARK --}}
@if($logoBase64)
<div class="watermark">
  <img src="{{ $logoBase64 }}" style="width:360px;">
</div>
@endif

{{-- HEADER --}}
<div class="header">
  <div class="header-inner">
    <div class="header-left">
      <div class="doc-type">Historia Clínica Estética</div>
      <div class="doc-title">{{ $tratamiento->titulo ?? $tratamiento->tipoTratamiento?->nombre ?? 'Tratamiento Estético' }}</div>
      <div class="doc-sub">
        Dr(a). {{ $tratamiento->medico?->nombre }} {{ $tratamiento->medico?->apellidos }}
        @if($tratamiento->medico?->especialidad) · {{ $tratamiento->medico->especialidad->nombre }} @endif
        @if($tratamiento->medico?->cedula_profesional) · Cédula: {{ $tratamiento->medico->cedula_profesional }} @endif
      </div>
    </div>
    <div class="header-right">
      @if($logoBase64)
        <div style="margin-bottom:8px;"><img src="{{ $logoBase64 }}" style="max-height:70px; max-width:160px; object-fit:contain;"></div>
      @endif
      <div class="folio-badge">HCE-{{ str_pad($tratamiento->id, 5, '0', STR_PAD_LEFT) }}</div>
      <div class="header-date">
        {{ $tratamiento->fecha?->format('d/m/Y') }} · Sesión N°: {{ $tratamiento->sesion_numero ?? 1 }}
        @if($tratamiento->grupo)
          @php $gN=['A'=>'Neuromoduladores','B'=>'Rellenos','C'=>'Bioestimulación','D'=>'Lipolíticos','E'=>'Piel']; @endphp
          · Grupo {{ $tratamiento->grupo }} · {{ $gN[$tratamiento->grupo] ?? '' }}
        @endif
      </div>
    </div>
  </div>
</div>

{{-- PACIENTE --}}
<div class="patient-band">
  <div class="patient-inner">
    <div class="pat-av-cell">
      @php $ini = strtoupper(substr($tratamiento->paciente?->nombre??'P',0,1)).strtoupper(substr($tratamiento->paciente?->apellidos??'',0,1)); @endphp
      <div class="pat-avatar">{{ $ini }}</div>
    </div>
    <div class="pat-info-cell">
      <div class="pat-name">{{ $tratamiento->paciente?->nombre }} {{ $tratamiento->paciente?->apellidos }}</div>
      <div class="pat-meta">
        {{ $tratamiento->paciente?->fecha_nacimiento ? \Carbon\Carbon::parse($tratamiento->paciente->fecha_nacimiento)->age.' años' : '' }}
        @if($tratamiento->paciente?->genero) · {{ ucfirst($tratamiento->paciente->genero) }} @endif
        @if($tratamiento->paciente?->telefono) · {{ $tratamiento->paciente->telefono }} @endif
        @if($tratamiento->paciente?->email) · {{ $tratamiento->paciente->email }} @endif
        @if($tratamiento->paciente?->direccion) · {{ $tratamiento->paciente->direccion }} @endif
      </div>
    </div>
    <div class="pat-tags-cell">
      @if($tratamiento->paciente?->tipo_sangre)
        <span class="ptag ptag-blood">{{ $tratamiento->paciente->tipo_sangre }}</span>
      @endif
      <span class="ptag ptag-exp">{{ $tratamiento->paciente?->numero_expediente ?? 'EXP-'.str_pad($tratamiento->paciente?->id,5,'0',STR_PAD_LEFT) }}</span>
    </div>
  </div>
</div>

{{-- BODY --}}
<div class="body">

  {{-- DATOS DEL PACIENTE --}}
  <div class="card">
    <div class="card-head"><div class="card-head-inner"><div class="ch-dot-cell"><div class="ch-dot"></div></div><div class="ch-title-cell"><div class="ch-title">Datos del Paciente</div></div></div></div>
    <div class="card-body">
      <div class="g2">
        <div class="g2-l">
          <div class="g3">
            <div class="g3-c"><div class="field"><div class="lbl">Fecha de nacimiento</div><div class="val-light">{{ $tratamiento->paciente?->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</div></div></div>
            <div class="g3-c"><div class="field"><div class="lbl">Edad</div><div class="val">{{ $tratamiento->paciente?->fecha_nacimiento ? \Carbon\Carbon::parse($tratamiento->paciente->fecha_nacimiento)->age.' años' : '—' }}</div></div></div>
            <div class="g3-c"><div class="field"><div class="lbl">Tipo de sangre</div><div class="val" style="color:#b42828;">{{ $tratamiento->paciente?->tipo_sangre ?? '—' }}</div></div></div>
          </div>
          <div class="field"><div class="lbl">Teléfono</div><div class="val-light">{{ $tratamiento->paciente?->telefono ?? '—' }}</div></div>
          <div class="field"><div class="lbl">Correo electrónico</div><div class="val-light">{{ $tratamiento->paciente?->email ?? '—' }}</div></div>
        </div>
        <div class="g2-r">
          <div class="field"><div class="lbl">N° Expediente</div><div class="val" style="color:#795300;">{{ $tratamiento->paciente?->numero_expediente ?? 'EXP-'.str_pad($tratamiento->paciente?->id,5,'0',STR_PAD_LEFT) }}</div></div>
          <div class="field"><div class="lbl">Sexo</div><div class="val-light">{{ $tratamiento->paciente?->genero ? ucfirst($tratamiento->paciente->genero) : '—' }}</div></div>
          <div class="field"><div class="lbl">Dirección</div><div class="val-light">{{ $tratamiento->paciente?->direccion ?? '—' }}</div></div>
        </div>
      </div>
    </div>
  </div>

  {{-- ANTECEDENTES --}}
  <div class="card">
    <div class="card-head"><div class="card-head-inner"><div class="ch-dot-cell"><div class="ch-dot" style="background:#b42828;"></div></div><div class="ch-title-cell"><div class="ch-title">Antecedentes Médicos</div></div></div></div>
    <div class="card-body">
      <div class="g2">
        <div class="g2-l">
          <div class="field"><div class="lbl">Alergias conocidas</div><div class="val-light">{{ $tratamiento->paciente?->alergias ?: '—' }}</div></div>
          <div class="field"><div class="lbl">Antecedentes patológicos / Enfermedades</div><div class="val-light">{{ $tratamiento->paciente?->antecedentes ?: '—' }}</div></div>
        </div>
        <div class="g2-r">
          @php
            $antExtra = is_array($tratamiento->paciente?->antecedentes_extra) ? $tratamiento->paciente->antecedentes_extra : [];
            $antMap = ['embarazo_lactancia'=>'Embarazo o lactancia','enf_neuromuscular'=>'Enf. neuromuscular','medicacion_actual'=>'Medicación actual','cirugias_previas'=>'Cirugías previas','tabaco_alcohol'=>'Consumo tabaco/alcohol'];
          @endphp
          @foreach($antMap as $key => $label)
            @php $marcado = in_array($key, $antExtra); @endphp
            <div class="cb-table">
              <div class="cb-icon-cell"><div class="cb-box {{ $marcado?'cb-box-on':'' }}">{{ $marcado?'✓':'' }}</div></div>
              <div class="cb-txt-cell">{{ $label }}: <span class="{{ $marcado?'':'neg' }}">{{ $marcado?'Sí':'Negado' }}</span></div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  {{-- EVALUACIÓN CLÍNICA --}}
  <div class="card">
    <div class="card-head"><div class="card-head-inner"><div class="ch-dot-cell"><div class="ch-dot"></div></div><div class="ch-title-cell"><div class="ch-title">Evaluación Clínica y Estética</div></div></div></div>
    <div class="card-body">
      <div class="g2">
        <div class="g2-l">
          @php $tiposPiel=['Seca','Grasa','Mixta','Normal','Sensible']; $selTipos=is_array($tratamiento->tipo_piel)?$tratamiento->tipo_piel:[]; @endphp
          <div class="lbl" style="margin-bottom:5px;">Tipo de piel</div>
          <div style="margin-bottom:10px;">@foreach($tiposPiel as $tp)<span class="tag-item {{ in_array($tp,$selTipos)?'tag-on':'tag-off' }}">{{ $tp }}</span>@endforeach</div>
          @php $condList=['Arrugas finas','Líneas dinámicas','Flacidez','Manchas','Lesiones activas','Cicatrices','Poros dilatados']; $selCond=is_array($tratamiento->condiciones_piel)?$tratamiento->condiciones_piel:[]; @endphp
          <div class="lbl" style="margin-bottom:5px;">Condiciones presentes</div>
          <div style="margin-bottom:10px;">@foreach($condList as $c)<span class="tag-item {{ in_array($c,$selCond)?'tag-on':'tag-off' }}">{{ $c }}</span>@endforeach</div>
          @if($tratamiento->simetria || $tratamiento->tonicidad)
          <div class="g2">
            @if($tratamiento->simetria)
            <div class="g2-l" style="padding-right:10px;">
              <div class="lbl" style="margin-bottom:5px;">Simetría facial</div>
              @foreach(['Alineación adecuada','Leve asimetría','Asimetría moderada'] as $s)
              <div class="cb-table"><div class="cb-icon-cell"><div class="cb-box {{ $tratamiento->simetria===$s?'cb-box-on':'' }}">{{ $tratamiento->simetria===$s?'✓':'' }}</div></div><div class="cb-txt-cell">{{ $s }}</div></div>
              @endforeach
            </div>
            @endif
            @if($tratamiento->tonicidad)
            <div class="g2-r">
              <div class="lbl" style="margin-bottom:5px;">Tonicidad muscular</div>
              @foreach(['Hiperactividad visible','Actividad moderada','Actividad leve'] as $t)
              <div class="cb-table"><div class="cb-icon-cell"><div class="cb-box {{ $tratamiento->tonicidad===$t?'cb-box-on':'' }}">{{ $tratamiento->tonicidad===$t?'✓':'' }}</div></div><div class="cb-txt-cell">{{ $t }}</div></div>
              @endforeach
            </div>
            @endif
          </div>
          @endif
        </div>
        <div class="g2-r">
          @php $fitzColors=['#fde8d8','#f5cba7','#e59866','#ca8a5e','#a0522d','#4a2c17']; @endphp
          <div class="lbl" style="margin-bottom:6px;">Fototipo cutáneo (Fitzpatrick)</div>
          <div class="fitz-table" style="margin-bottom:12px;">
            @foreach([1,2,3,4,5,6] as $n)
            <div class="fitz-cell">
              <div class="fitz-circle {{ $tratamiento->fitzpatrick==$n?'fitz-sel':'' }}" style="background:{{ $fitzColors[$n-1] }};"></div>
              <div class="{{ $tratamiento->fitzpatrick==$n?'fitz-numsel':'fitz-num' }}">{{ $n }}</div>
            </div>
            @endforeach
          </div>
          @if($tratamiento->motivo_consulta)
          <div class="field"><div class="lbl">Motivo de consulta</div><div class="val-light">{{ $tratamiento->motivo_consulta }}</div></div>
          @endif
          @if($tratamiento->objetivo)
          <div class="field"><div class="lbl">Plan del tratamiento</div><div class="obs-box" style="min-height:26px;">{{ $tratamiento->objetivo }}</div></div>
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- SIGNOS VITALES --}}
  <div class="card">
    <div class="card-head"><div class="card-head-inner"><div class="ch-dot-cell"><div class="ch-dot" style="background:#c4a97a;"></div></div><div class="ch-title-cell"><div class="ch-title">Signos Vitales</div></div></div></div>
    <div class="card-body">
      @php
        $sv=$tratamiento->signos_vitales??[];
        $svPeso=$sv['peso']??$tratamiento->peso??null;
        $svTall=$sv['talla']??$tratamiento->talla??null;
        $svTemp=$sv['temperatura']??$tratamiento->temperatura??null;
        $svTA=$sv['tension_arterial']??$tratamiento->tension_arterial??null;
        $svFC=$sv['frecuencia_cardiaca']??$tratamiento->frecuencia_cardiaca??null;
        $svSat=$sv['saturacion_o2']??$tratamiento->saturacion_o2??null;
      @endphp
      <div class="vitals-table"><div class="vitals-row">
        <div class="vital-cell"><div class="vit-lbl">Peso</div><div class="vit-val">{{ $svPeso?:'—' }}<span class="vit-unit"> kg</span></div></div>
        <div class="vital-cell"><div class="vit-lbl">Talla</div><div class="vit-val">{{ $svTall?:'—' }}<span class="vit-unit"> cm</span></div></div>
        <div class="vital-cell"><div class="vit-lbl">Temp</div><div class="vit-val">{{ $svTemp?:'—' }}<span class="vit-unit"> °C</span></div></div>
        <div class="vital-cell"><div class="vit-lbl">T/A</div><div class="vit-val" style="color:#b42828;font-size:13px;">{{ $svTA?:'—' }}</div></div>
        <div class="vital-cell"><div class="vit-lbl">F.C.</div><div class="vit-val">{{ $svFC?:'—' }}<span class="vit-unit"> lpm</span></div></div>
        <div class="vital-cell"><div class="vit-lbl">Sat O₂</div><div class="vit-val" style="color:#1d6aad;">{{ $svSat?:'—' }}<span class="vit-unit"> %</span></div></div>
      </div></div>
    </div>
  </div>

  {{-- EXPLORACIÓN FÍSICA --}}
  @if($tratamiento->exploracion_fisica)
  <div class="card">
    <div class="card-head"><div class="card-head-inner"><div class="ch-dot-cell"><div class="ch-dot"></div></div><div class="ch-title-cell"><div class="ch-title">Exploración Física</div></div></div></div>
    <div class="card-body"><div class="obs-box">{{ $tratamiento->exploracion_fisica }}</div></div>
  </div>
  @endif

  {{-- DISTRIBUCIÓN DE ZONAS --}}
  @php $mapaVisible = (int)($tratamiento->mapa_activo ?? 1) === 1; @endphp
  @if($mapaVisible)
  <div class="card">
    <div class="card-head"><div class="card-head-inner"><div class="ch-dot-cell"><div class="ch-dot"></div></div><div class="ch-title-cell"><div class="ch-title">Distribución de Zonas y Dosificación</div></div></div></div>
    <div class="card-body">
      @php
        $predefinidas=$tratamiento->zonas->where('tipo','predefinida')->where('activa',true)->filter(fn($z)=>$z->cantidad>0);
        $libres=$tratamiento->zonas->where('tipo','libre');
        $totalUnidades=$predefinidas->sum('cantidad')+$libres->sum('cantidad');
        $zonaLabels=['F'=>'Frente','GL'=>'Glabela (entrecejo)','PGI'=>'Patas de gallo izq.','PGD'=>'Patas de gallo der.','BL'=>'Bunny lines','L'=>'Labios / Peribucales','MI'=>'Masetero izq.','MD'=>'Masetero der.','C'=>'Cuello'];
      @endphp
      <div class="mapa-layout">
        <div class="mapa-col"><img src="{{ $mapaBase64 }}" width="178" height="240" style="display:block;"/><div style="font-size:7.5px;color:#c4a97a;text-align:center;margin-top:3px;"><span style="color:#795300;">&#9679;</span> Zona predefinida &nbsp;<span style="color:#b42828;">&#9679;</span> Punto libre</div></div>
        <div class="tabla-col">
          @if($predefinidas->count())
          <table class="dosis-tbl" style="margin-bottom:8px;">
            <thead><tr><th>Zona</th><th style="text-align:center;">Unidades</th><th>Notas</th></tr></thead>
            <tbody>@foreach($predefinidas as $zona)<tr><td><strong>{{ $zonaLabels[$zona->zona] ?? $zona->zona_label }}</strong></td><td class="td-num">{{ $zona->cantidad ?? '—' }} {{ $zona->unidad }}</td><td style="color:#8a7355;font-size:8.5px;">{{ $zona->notas ?? '' }}</td></tr>@endforeach</tbody>
          </table>
          @endif
          @if($libres->count())
          <table class="dosis-tbl" style="margin-bottom:8px;">
            <thead><tr><th colspan="3">Puntos de aplicación personalizados</th></tr><tr style="background:#a07a30;"><th>Nombre / Zona</th><th style="text-align:center;">Cantidad</th><th>Etiqueta</th></tr></thead>
            <tbody>@foreach($libres as $pl)<tr><td><strong>{{ $pl->zona_label ?: 'Punto personalizado' }}</strong></td><td class="td-num">{{ $pl->cantidad ?? '—' }} {{ $pl->unidad }}</td><td style="font-size:8px;color:#8a7355;">{{ $pl->notas ?? '' }}</td></tr>@endforeach</tbody>
          </table>
          @endif
          <table class="dosis-tbl"><tbody><tr><td class="td-total" colspan="2" style="font-size:11px;">TOTAL APLICADO</td><td class="td-total" style="text-align:center;font-size:14px;">{{ $totalUnidades }} U</td></tr></tbody></table>
          @if($tratamiento->tecnica || $tratamiento->profundidad || $tratamiento->intervalo)
          <div style="margin-top:8px;background:#fffcf7;border-radius:5px;padding:6px 9px;border:1px solid #e5d4b8;">
            @if($tratamiento->tecnica)<div style="font-size:8px;margin-bottom:2px;"><span style="color:#c4a97a;text-transform:uppercase;">Técnica:</span> <strong>{{ $tratamiento->tecnica }}</strong></div>@endif
            @if($tratamiento->profundidad)<div style="font-size:8px;margin-bottom:2px;"><span style="color:#c4a97a;text-transform:uppercase;">Profundidad:</span> <strong>{{ $tratamiento->profundidad }}</strong></div>@endif
            @if($tratamiento->intervalo)<div style="font-size:8px;"><span style="color:#c4a97a;text-transform:uppercase;">Intervalo:</span> <strong>{{ $tratamiento->intervalo }}</strong></div>@endif
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
  @endif

  @if(!$mapaVisible && $tratamiento->zonas_texto)
  <div class="card">
    <div class="card-head"><div class="card-head-inner"><div class="ch-dot-cell"><div class="ch-dot"></div></div><div class="ch-title-cell"><div class="ch-title">Zonas a Aplicar</div></div></div></div>
    <div class="card-body"><div class="obs-box">{{ $tratamiento->zonas_texto }}</div></div>
  </div>
  @endif

  {{-- PRODUCTO --}}
  @if($tratamiento->producto_marca || $tratamiento->producto_lote)
  <div class="card">
    <div class="card-head"><div class="card-head-inner"><div class="ch-dot-cell"><div class="ch-dot" style="background:#c4a97a;"></div></div><div class="ch-title-cell"><div class="ch-title">Producto Utilizado</div></div></div></div>
    <div class="card-body">
      <div class="g3">
        <div class="g3-c"><div class="field"><div class="lbl">Marca / Nombre</div><div class="val">{{ $tratamiento->producto_marca ?? '—' }}</div></div></div>
        <div class="g3-c"><div class="field"><div class="lbl">N° de lote</div><div class="val">{{ $tratamiento->producto_lote ?? '—' }}</div></div></div>
        <div class="g3-c"><div class="field"><div class="lbl">Fecha de caducidad</div><div class="val">{{ $tratamiento->producto_caducidad?->format('d/m/Y') ?? '—' }}</div></div></div>
      </div>
    </div>
  </div>
  @endif

  {{-- NOTAS --}}
  @if($tratamiento->observaciones_generales || $tratamiento->observaciones_post)
  <div class="card">
    <div class="card-head"><div class="card-head-inner"><div class="ch-dot-cell"><div class="ch-dot"></div></div><div class="ch-title-cell"><div class="ch-title">Notas Clínicas</div></div></div></div>
    <div class="card-body">
      <div class="g2">
        @if($tratamiento->observaciones_generales)<div class="g2-l"><div class="lbl" style="margin-bottom:4px;">Observaciones generales</div><div class="obs-box">{{ $tratamiento->observaciones_generales }}</div></div>@endif
        @if($tratamiento->observaciones_post)<div class="g2-r"><div class="lbl" style="margin-bottom:4px;">Observaciones post-aplicación</div><div class="obs-box">{{ $tratamiento->observaciones_post }}</div></div>@endif
      </div>
    </div>
  </div>
  @endif

</div>

{{-- FOOTER --}}
<div class="footer">
  Generado el {{ now()->format('d/m/Y H:i') }} &nbsp;·&nbsp;
  Historia Clínica Estética #HCE-{{ str_pad($tratamiento->id,5,'0',STR_PAD_LEFT) }} &nbsp;·&nbsp;
  Sesión N° {{ $tratamiento->sesion_numero ?? 1 }} &nbsp;·&nbsp;
  <strong>DOCUMENTO CONFIDENCIAL</strong>
</div>

</div>
</body>
</html>