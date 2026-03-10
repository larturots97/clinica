<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:DejaVu Sans,sans-serif;font-size:9.5px;color:#2c1a0e;background:white;}
.page{padding:22px 28px 18px;background:#fffdf8;}

/* HEADER */
.header{display:table;width:100%;border-bottom:2.5px solid #b8860b;padding-bottom:10px;margin-bottom:14px;}
.header-left{display:table-cell;vertical-align:middle;width:65%;}
.header-right{display:table-cell;vertical-align:middle;text-align:right;width:35%;}
.doc-title{font-size:13px;font-weight:bold;color:#5c3d0e;text-transform:uppercase;letter-spacing:.4px;}
.medico-info{font-size:9px;color:#8b6914;margin-top:3px;}
.folio-box{display:inline-block;border:1.5px solid #b8860b;border-radius:6px;padding:5px 12px;text-align:center;background:#fdf8ee;}
.folio-num{font-size:14px;font-weight:bold;color:#5c3d0e;}
.folio-label{font-size:8px;color:#b8860b;text-transform:uppercase;letter-spacing:.5px;}
.fecha-info{font-size:8.5px;color:#8b6914;margin-top:4px;text-align:right;}

/* SECCIONES */
.seccion{margin-bottom:12px;}
.sec-titulo{font-size:8px;font-weight:bold;text-transform:uppercase;letter-spacing:.6px;color:#b8860b;
  border-bottom:1.5px solid #e8d5a3;padding-bottom:3px;margin-bottom:7px;}

/* GRIDS */
.grid2{display:table;width:100%;}
.col2{display:table-cell;width:50%;padding-right:12px;vertical-align:top;}
.col2:last-child{padding-right:0;}
.grid3{display:table;width:100%;}
.col3{display:table-cell;width:33.3%;padding-right:10px;vertical-align:top;}
.col3:last-child{padding-right:0;}
.grid4{display:table;width:100%;}
.col4{display:table-cell;width:25%;padding-right:8px;vertical-align:top;}
.col4:last-child{padding-right:0;}

/* FIELDS */
.field{margin-bottom:6px;}
.field-label{font-size:7.5px;color:#8b6914;text-transform:uppercase;letter-spacing:.3px;margin-bottom:1px;}
.field-value{font-size:9.5px;color:#2c1a0e;font-weight:bold;border-bottom:1px solid #e8d5a3;padding-bottom:1px;min-height:13px;}
.field-value-normal{font-size:9.5px;color:#2c1a0e;}

/* BADGES */
.badge{display:inline-block;padding:1.5px 7px;border-radius:10px;font-size:8px;font-weight:bold;margin:1px;}
.badge-gold{background:#fef3c7;color:#78350f;}
.badge-cream{background:#fdf8ee;color:#5c3d0e;}
.badge-brown{background:#e8d5a3;color:#5c3d0e;}
.badge-gray{background:#f5f0e8;color:#6b5a3e;}

/* CHECKBOX ESTILO */
.cb-row{display:table;width:100%;margin-bottom:3px;}
.cb-cell{display:table-cell;width:14px;vertical-align:top;}
.cb-box{width:10px;height:10px;border:1.5px solid #c9a96e;display:inline-block;border-radius:2px;background:white;text-align:center;line-height:9px;font-size:8px;}
.cb-box.checked{background:#b8860b;border-color:#b8860b;color:white;}
.cb-text{display:table-cell;vertical-align:top;font-size:9px;padding-left:2px;color:#2c1a0e;}

/* TABLA DOSIFICACIÓN */
.tabla-dosis{width:100%;border-collapse:collapse;font-size:9px;}
.tabla-dosis th{background:#5c3d0e;color:#fdf8ee;padding:4px 7px;text-align:left;font-size:8px;text-transform:uppercase;letter-spacing:.3px;}
.tabla-dosis td{padding:4px 7px;border-bottom:1px solid #f0e6cc;vertical-align:middle;color:#2c1a0e;}
.tabla-dosis tr:nth-child(even) td{background:#fdf8ee;}
.tabla-dosis .td-num{font-weight:bold;color:#5c3d0e;text-align:center;}
.tabla-dosis .td-total{background:#e8d5a3!important;font-weight:bold;color:#5c3d0e;}

/* MAPA + TABLA LADO A LADO */
.mapa-tabla{display:table;width:100%;}
.mapa-col{display:table-cell;width:190px;vertical-align:top;padding-right:14px;}
.tabla-col{display:table-cell;vertical-align:top;}

/* FITZPATRICK */
.fitz-row{display:table;width:100%;}
.fitz-cell{display:table-cell;text-align:center;padding:3px 2px;}
.fitz-circle{width:18px;height:18px;border-radius:50%;margin:0 auto 2px;border:1.5px solid rgba(0,0,0,.15);}
.fitz-num{font-size:8px;font-weight:bold;color:#374151;}
.fitz-label{font-size:7px;color:#8b6914;}
.fitz-selected .fitz-circle{border:2.5px solid #b8860b!important;}
.fitz-selected .fitz-num{color:#b8860b;}

/* FIRMAS */
.firmas{display:table;width:100%;margin-top:16px;border-top:1.5px solid #e8d5a3;padding-top:12px;}
.firma-col{display:table-cell;width:50%;text-align:center;padding:0 14px;vertical-align:bottom;}
.firma-img-wrap{height:50px;display:flex;align-items:flex-end;justify-content:center;margin-bottom:4px;}
.firma-linea{border-top:1.5px solid #5c3d0e;width:85%;margin:0 auto 3px;}
.firma-nombre{font-size:9px;font-weight:bold;color:#2c1a0e;}
.firma-sub{font-size:7.5px;color:#8b6914;}

/* FOOTER */
.footer{margin-top:10px;border-top:1px solid #e8d5a3;padding-top:6px;text-align:center;font-size:7.5px;color:#c9a96e;}

/* CONSENTIMIENTO */
.consent-box{border:1px solid #e8d5a3;border-radius:6px;padding:10px 12px;background:#fdf8ee;margin-bottom:10px;}
.consent-text{font-size:8.5px;color:#2c1a0e;line-height:1.6;}

/* RIESGOS */
.riesgo-item{font-size:8.5px;color:#2c1a0e;margin-bottom:3px;padding-left:10px;position:relative;}
.riesgo-item:before{content:"•";position:absolute;left:2px;color:#b8860b;}

/* SEPARADOR */
.sep{border:none;border-top:1px dashed #e8d5a3;margin:10px 0;}

/* NEGADO */
.negado{font-size:8px;color:#8b6914;font-style:italic;}
</style>
</head>
<body>
<div class="page">

{{-- ===== HEADER ===== --}}
<div class="header">
  <div class="header-left">
    @if($tratamiento->medico?->logo)
    <img src="{{ storage_path('app/public/'.$tratamiento->medico->logo) }}" height="36" style="margin-bottom:4px;display:block;">
    @endif
    <div class="doc-title">Historia Clínica — {{ $tratamiento->titulo ?? $tratamiento->tipoTratamiento?->nombre ?? 'Tratamiento Estético' }}</div>
    <div class="medico-info">
      Dr(a). {{ $tratamiento->medico?->nombre }} {{ $tratamiento->medico?->apellidos }}
      @if($tratamiento->medico?->especialidad) · {{ $tratamiento->medico->especialidad->nombre }} @endif
      @if($tratamiento->medico?->cedula_profesional) · Cédula: {{ $tratamiento->medico->cedula_profesional }} @endif
    </div>
  </div>
  <div class="header-right">
    <div class="folio-box">
      <div class="folio-num">HCE-{{ str_pad($tratamiento->id, 5, '0', STR_PAD_LEFT) }}</div>
      <div class="folio-label">Folio</div>
    </div>
    <div class="fecha-info">
      Fecha: {{ $tratamiento->fecha?->format('d/m/Y') }}<br>
      Sesión N°: {{ $tratamiento->sesion_numero ?? 1 }}<br>
      @if($tratamiento->grupo)
        Grupo {{ $tratamiento->grupo }}
        @php $gNombres=['A'=>'Neuromoduladores','B'=>'Rellenos','C'=>'Bioestimulación','D'=>'Lipolíticos','E'=>'Piel']; @endphp
        · {{ $gNombres[$tratamiento->grupo] ?? '' }}
      @endif
    </div>
  </div>
</div>

{{-- ===== DATOS DEL PACIENTE ===== --}}
<div class="seccion">
  <div class="sec-titulo">Datos del Paciente</div>
  <div class="grid2">
    <div class="col2">
      <div class="field">
        <div class="field-label">Nombre completo</div>
        <div class="field-value">{{ $tratamiento->paciente?->nombre }} {{ $tratamiento->paciente?->apellidos }}</div>
      </div>
      <div class="grid2">
        <div class="col2">
          <div class="field">
            <div class="field-label">Fecha de nacimiento</div>
            <div class="field-value">{{ $tratamiento->paciente?->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</div>
          </div>
        </div>
        <div class="col2">
          <div class="field">
            <div class="field-label">Edad</div>
            <div class="field-value">{{ $tratamiento->paciente?->fecha_nacimiento ? \Carbon\Carbon::parse($tratamiento->paciente->fecha_nacimiento)->age.' años' : '—' }}</div>
          </div>
        </div>
      </div>
      <div class="field">
        <div class="field-label">Teléfono de contacto</div>
        <div class="field-value">{{ $tratamiento->paciente?->telefono ?? '—' }}</div>
      </div>
    </div>
    <div class="col2">
      <div class="field">
        <div class="field-label">N° Expediente</div>
        <div class="field-value">{{ $tratamiento->paciente?->numero_expediente ?? 'EXP-'.str_pad($tratamiento->paciente?->id, 5,'0',STR_PAD_LEFT) }}</div>
      </div>
      <div class="field">
        <div class="field-label">Sexo</div>
        <div class="field-value">{{ $tratamiento->paciente?->genero ? ucfirst($tratamiento->paciente->genero) : '—' }}</div>
      </div>
      <div class="field">
        <div class="field-label">Email</div>
        <div class="field-value">{{ $tratamiento->paciente?->email ?? '—' }}</div>
      </div>
      <div class="field">
        <div class="field-label">Tipo de sangre</div>
        <div class="field-value" style="color:#8b1a1a;">{{ $tratamiento->paciente?->tipo_sangre ?? '—' }}</div>
      </div>
    </div>
  </div>
</div>

<hr class="sep">

{{-- ===== ANTECEDENTES MÉDICOS ===== --}}
<div class="seccion">
  <div class="sec-titulo">Antecedentes Médicos</div>
  <div class="grid2">
    <div class="col2">
      <div class="field">
        <div class="field-label">Alergias conocidas</div>
        <div class="field-value-normal">{{ $tratamiento->paciente?->alergias ?: '—' }}</div>
      </div>
      <div class="field" style="margin-top:4px;">
        <div class="field-label">Antecedentes patológicos / Enfermedades</div>
        <div class="field-value-normal">{{ $tratamiento->paciente?->antecedentes ?: '—' }}</div>
      </div>
    </div>
    <div class="col2">
      @php
        $ants = is_array($tratamiento->antecedentes) ? $tratamiento->antecedentes : [];
        $antList = ['Embarazo o lactancia','Enf. neuromuscular','Medicación actual','Cirugías previas','Consumo tabaco/alcohol'];
      @endphp
      @foreach($antList as $ant)
      <div style="margin-bottom:3px;">
        <div class="cb-row">
          <div class="cb-cell"><div class="cb-box {{ in_array($ant,$ants)?'checked':'' }}">{{ in_array($ant,$ants)?'✓':'' }}</div></div>
          <div class="cb-text">{{ $ant }}: <span class="{{ in_array($ant,$ants)?'':'negado' }}">{{ in_array($ant,$ants)?'Sí':'Negado' }}</span></div>
        </div>
      </div>
      @endforeach
      @if($tratamiento->paciente?->antecedentes)
      <div style="margin-top:4px;font-size:8px;color:#6b7280;font-style:italic;">{{ Str::limit($tratamiento->paciente->antecedentes,120) }}</div>
      @endif
    </div>
  </div>
</div>

<hr class="sep">

{{-- ===== EVALUACIÓN CLÍNICA ===== --}}
<div class="seccion">
  <div class="sec-titulo">Evaluación Clínica y Estética</div>
  <div class="grid2">
    <div class="col2">

      {{-- TIPO DE PIEL --}}
      <div style="margin-bottom:7px;">
        <div class="field-label" style="margin-bottom:4px;">Tipo de piel</div>
        @php $tiposPiel=['Seca','Grasa','Mixta','Normal','Sensible']; $selTipos=is_array($tratamiento->tipo_piel)?$tratamiento->tipo_piel:[]; @endphp
        <div>
          @foreach($tiposPiel as $tp)
          <div class="cb-row" style="display:inline-table;margin-right:8px;">
            <div class="cb-cell"><div class="cb-box {{ in_array($tp,$selTipos)?'checked':'' }}">{{ in_array($tp,$selTipos)?'✓':'' }}</div></div>
            <div class="cb-text">{{ $tp }}</div>
          </div>
          @endforeach
        </div>
      </div>

      {{-- CONDICIONES --}}
      <div style="margin-bottom:7px;">
        <div class="field-label" style="margin-bottom:4px;">Estado / Condiciones presentes</div>
        @php $condList=['Arrugas finas','Líneas dinámicas','Flacidez','Manchas','Lesiones activas','Cicatrices','Poros dilatados']; $selCond=is_array($tratamiento->condiciones_piel)?$tratamiento->condiciones_piel:[]; @endphp
        <div>
          @foreach($condList as $c)
          <div class="cb-row" style="display:inline-table;margin-right:6px;margin-bottom:2px;">
            <div class="cb-cell"><div class="cb-box {{ in_array($c,$selCond)?'checked':'' }}">{{ in_array($c,$selCond)?'✓':'' }}</div></div>
            <div class="cb-text">{{ $c }}</div>
          </div>
          @endforeach
        </div>
      </div>

      {{-- SIMETRÍA Y TONICIDAD --}}
      <div class="grid2">
        <div class="col2">
          <div class="field-label" style="margin-bottom:3px;">Simetría facial</div>
          @php $simOpts=['Alineación adecuada','Leve asimetría','Asimetría moderada']; @endphp
          @foreach($simOpts as $s)
          <div class="cb-row" style="margin-bottom:2px;">
            <div class="cb-cell"><div class="cb-box {{ $tratamiento->simetria===$s?'checked':'' }}">{{ $tratamiento->simetria===$s?'✓':'' }}</div></div>
            <div class="cb-text">{{ $s }}</div>
          </div>
          @endforeach
        </div>
        <div class="col2">
          <div class="field-label" style="margin-bottom:3px;">Tonicidad muscular</div>
          @php $tonOpts=['Hiperactividad visible','Actividad moderada','Actividad leve']; @endphp
          @foreach($tonOpts as $t)
          <div class="cb-row" style="margin-bottom:2px;">
            <div class="cb-cell"><div class="cb-box {{ $tratamiento->tonicidad===$t?'checked':'' }}">{{ $tratamiento->tonicidad===$t?'✓':'' }}</div></div>
            <div class="cb-text">{{ $t }}</div>
          </div>
          @endforeach
        </div>
      </div>

    </div>
    <div class="col2">

      {{-- FITZPATRICK --}}
      <div style="margin-bottom:8px;">
        <div class="field-label" style="margin-bottom:5px;">Fototipo cutáneo (Escala de Fitzpatrick)</div>
        @php
          $fitzColors=['#fde8d8','#f5cba7','#e59866','#ca8a5e','#a0522d','#4a2c17'];
          $fitzLabels=['Muy clara','Clara','Media','Morena','Oscura','Negra'];
        @endphp
        <div class="fitz-row">
          @foreach([1,2,3,4,5,6] as $n)
          <div class="fitz-cell {{ $tratamiento->fitzpatrick==$n?'fitz-selected':'' }}">
            <div class="fitz-circle" style="background:{{ $fitzColors[$n-1] }};{{ $tratamiento->fitzpatrick==$n?'border-color:#b8860b;':'' }}"></div>
            <div class="fitz-num" style="{{ $tratamiento->fitzpatrick==$n?'color:#b8860b;':'' }}">{{ $n }}</div>
            <div class="fitz-label">{{ $fitzLabels[$n-1] }}</div>
          </div>
          @endforeach
        </div>
      </div>

      {{-- MOTIVO Y OBJETIVO --}}
      @if($tratamiento->motivo_consulta)
      <div class="field" style="margin-top:6px;">
        <div class="field-label">Motivo de consulta</div>
        <div class="field-value-normal">{{ $tratamiento->motivo_consulta }}</div>
      </div>
      @endif
      @if($tratamiento->objetivo)
      <div class="field" style="margin-top:6px;">
        <div class="field-label">Plan del tratamiento</div>
        <div class="field-value-normal" style="border:1px solid #e5e7eb;border-radius:4px;padding:5px 7px;min-height:36px;background:#fdf8ee;">{{ $tratamiento->objetivo }}</div>
      </div>
      @endif

    </div>
  </div>
</div>

<hr class="sep">

{{-- ===== SIGNOS VITALES ===== --}}
<div class="seccion">
  <div class="sec-titulo">Signos Vitales</div>
  @php
    $sv = is_array($tratamiento->signos_vitales) ? $tratamiento->signos_vitales : [];
    $svPeso    = $sv['peso']    ?? $tratamiento->peso    ?? null;
    $svTalla   = $sv['talla']   ?? $tratamiento->talla   ?? null;
    $svTemp    = $sv['temperatura'] ?? $tratamiento->temperatura ?? null;
    $svTA      = $sv['tension_arterial'] ?? $tratamiento->tension_arterial ?? null;
    $svFC      = $sv['frecuencia_cardiaca'] ?? $tratamiento->frecuencia_cardiaca ?? null;
    $svSat     = $sv['saturacion_o2'] ?? $tratamiento->saturacion_o2 ?? null;
  @endphp
  <div style="display:table;width:100%;border:1px solid #e8d5a3;border-radius:6px;overflow:hidden;">
    {{-- fila de labels --}}
    <div style="display:table-row;background:#5c3d0e;">
      @foreach(['Peso','Talla','Temperatura','T/A','F.C.','Sat O₂'] as $lbl)
      <div style="display:table-cell;padding:4px 0;text-align:center;font-size:7.5px;font-weight:bold;color:white;text-transform:uppercase;letter-spacing:.3px;width:16.6%;">{{ $lbl }}</div>
      @endforeach
    </div>
    {{-- fila de valores --}}
    <div style="display:table-row;background:#fdf8ee;">
      <div style="display:table-cell;padding:8px 4px;text-align:center;font-size:12px;font-weight:bold;color:#1e1b4b;border-right:1px solid #e8d5a3;">{{ $svPeso ? $svPeso.' kg' : '—' }}</div>
      <div style="display:table-cell;padding:8px 4px;text-align:center;font-size:12px;font-weight:bold;color:#1e1b4b;border-right:1px solid #e8d5a3;">{{ $svTalla ? $svTalla.' cm' : '—' }}</div>
      <div style="display:table-cell;padding:8px 4px;text-align:center;font-size:12px;font-weight:bold;color:#1e1b4b;border-right:1px solid #e8d5a3;">{{ $svTemp ? $svTemp.' °C' : '—' }}</div>
      <div style="display:table-cell;padding:8px 4px;text-align:center;font-size:12px;font-weight:bold;color:#5c3d0e;border-right:1px solid #e8d5a3;">{{ $svTA ?: '—' }}</div>
      <div style="display:table-cell;padding:8px 4px;text-align:center;font-size:12px;font-weight:bold;color:#1e1b4b;border-right:1px solid #e8d5a3;">{{ $svFC ? $svFC.' lpm' : '—' }}</div>
      <div style="display:table-cell;padding:8px 4px;text-align:center;font-size:12px;font-weight:bold;color:#5c3d0e;">{{ $svSat ? $svSat.' %' : '—' }}</div>
    </div>
  </div>
</div>

<hr class="sep">

{{-- ===== EXPLORACIÓN FÍSICA ===== --}}
@if($tratamiento->exploracion_fisica)
<div class="seccion">
  <div class="sec-titulo">Exploración Física</div>
  <div style="border:1px solid #e5e7eb;border-radius:5px;padding:8px 10px;font-size:9px;color:#374151;line-height:1.7;background:#fdf8ee;min-height:40px;">{{ $tratamiento->exploracion_fisica }}</div>
</div>
<hr class="sep">
@endif

{{-- ===== MAPA / ZONAS ===== --}}
@php $mapaVisible = (int)($tratamiento->mapa_activo ?? 1) === 1; @endphp

@if($mapaVisible)
<div class="seccion">
  <div class="sec-titulo">Distribución de Zonas y Dosificación</div>
  @php
    $predefinidas  = $tratamiento->zonas->where('tipo','predefinida')->where('activa',true)->filter(fn($z)=>$z->cantidad>0);
    $libres        = $tratamiento->zonas->where('tipo','libre');
    $totalUnidades = $predefinidas->sum('cantidad') + $libres->sum('cantidad');
    $zonaLabels    = ['F'=>'Frente','GL'=>'Glabela (entrecejo)','PGI'=>'Patas de gallo izq.','PGD'=>'Patas de gallo der.','BL'=>'Bunny lines','L'=>'Labios / Peribucales','MI'=>'Masetero izq.','MD'=>'Masetero der.','C'=>'Cuello'];
  @endphp
  <table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td width="185" valign="top" style="padding-right:12px;">
        <img src="{{ $mapaBase64 }}" width="180" height="243" style="display:block;"/>
        <div style="font-size:7.5px;color:#6b7280;text-align:center;margin-top:3px;">
          <span style="color:#b8860b;">&#9679;</span> Zona predefinida &nbsp;
          <span style="color:#8b1a1a;">&#9679;</span> Punto libre
        </div>
      </td>
      <td valign="top">
        @if($predefinidas->count())
        <table class="tabla-dosis" style="margin-bottom:8px;">
          <thead><tr><th>Zona</th><th style="text-align:center;">Unidades</th><th>Notas</th></tr></thead>
          <tbody>
            @foreach($predefinidas as $zona)
            <tr>
              <td><strong>{{ $zonaLabels[$zona->zona] ?? $zona->zona_label }}</strong></td>
              <td class="td-num">{{ $zona->cantidad ?? '—' }} {{ $zona->unidad }}</td>
              <td style="color:#6b7280;font-size:8.5px;">{{ $zona->notas ?? '' }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @endif
        @if($libres->count())
        <table class="tabla-dosis" style="margin-bottom:8px;">
          <thead>
            <tr><th colspan="3">Puntos de aplicación personalizados</th></tr>
            <tr style="background:#7a5c1e;"><th>Nombre / Zona</th><th style="text-align:center;">Cantidad</th><th>Etiqueta</th></tr>
          </thead>
          <tbody>
            @foreach($libres as $pl)
            <tr>
              <td><strong>{{ $pl->zona_label ?: 'Punto personalizado' }}</strong></td>
              <td class="td-num">{{ $pl->cantidad ?? '—' }} {{ $pl->unidad }}</td>
              <td style="font-size:8px;color:#6b7280;">{{ $pl->notas ?? '' }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @endif
        <table class="tabla-dosis">
          <tbody>
            <tr>
              <td class="td-total" colspan="2" style="font-size:11px;">TOTAL APLICADO</td>
              <td class="td-total" style="text-align:center;font-size:13px;">{{ $totalUnidades }} U</td>
            </tr>
          </tbody>
        </table>
        @if($tratamiento->tecnica || $tratamiento->profundidad || $tratamiento->intervalo)
        <div style="margin-top:8px;background:#fdf8ee;border-radius:5px;padding:6px 9px;">
          @if($tratamiento->tecnica)<div style="font-size:8px;margin-bottom:2px;"><span style="color:#6b7280;text-transform:uppercase;">Técnica:</span> <strong>{{ $tratamiento->tecnica }}</strong></div>@endif
          @if($tratamiento->profundidad)<div style="font-size:8px;margin-bottom:2px;"><span style="color:#6b7280;text-transform:uppercase;">Profundidad:</span> <strong>{{ $tratamiento->profundidad }}</strong></div>@endif
          @if($tratamiento->intervalo)<div style="font-size:8px;"><span style="color:#6b7280;text-transform:uppercase;">Intervalo:</span> <strong>{{ $tratamiento->intervalo }}</strong></div>@endif
        </div>
        @endif
      </td>
    </tr>
  </table>
</div>
<hr class="sep">
@endif

{{-- Zonas a aplicar (cuando mapa desactivado) --}}
@if(!$mapaVisible && $tratamiento->zonas_texto)
<div class="seccion">
  <div class="sec-titulo">Zonas a Aplicar</div>
  <div style="border:1px solid #e8d5a3;border-radius:5px;padding:8px 10px;font-size:9px;color:#2c1a0e;line-height:1.7;background:#fdf8ee;min-height:40px;">{{ $tratamiento->zonas_texto }}</div>
</div>
<hr class="sep">
@endif

<hr class="sep">

{{-- ===== PRODUCTO UTILIZADO ===== --}}
@if($tratamiento->producto_marca || $tratamiento->producto_lote)
<div class="seccion">
  <div class="sec-titulo">Producto Utilizado</div>
  <div class="grid3">
    <div class="col3">
      <div class="field">
        <div class="field-label">Marca / Nombre del producto</div>
        <div class="field-value">{{ $tratamiento->producto_marca ?? '—' }}</div>
      </div>
    </div>
    <div class="col3">
      <div class="field">
        <div class="field-label">N° de lote</div>
        <div class="field-value">{{ $tratamiento->producto_lote ?? '—' }}</div>
      </div>
    </div>
    <div class="col3">
      <div class="field">
        <div class="field-label">Fecha de caducidad</div>
        <div class="field-value">{{ $tratamiento->producto_caducidad?->format('d/m/Y') ?? '—' }}</div>
      </div>
    </div>
  </div>
</div>
<hr class="sep">
@endif

{{-- ===== OBSERVACIONES POST ===== --}}
@if($tratamiento->observaciones_generales || $tratamiento->observaciones_post)
<div class="seccion">
  <div class="sec-titulo">Notas Clínicas</div>
  <div class="grid2">
    @if($tratamiento->observaciones_generales)
    <div class="col2">
      <div class="field-label" style="margin-bottom:3px;">Observaciones generales</div>
      <div style="border:1px solid #e5e7eb;border-radius:4px;padding:6px 8px;font-size:9px;min-height:32px;background:#fdf8ee;">{{ $tratamiento->observaciones_generales }}</div>
    </div>
    @endif
    @if($tratamiento->observaciones_post)
    <div class="col2">
      <div class="field-label" style="margin-bottom:3px;">Observaciones post-aplicación</div>
      <div style="border:1px solid #e5e7eb;border-radius:4px;padding:6px 8px;font-size:9px;min-height:32px;background:#fdf8ee;">{{ $tratamiento->observaciones_post }}</div>
    </div>
    @endif
  </div>
</div>
<hr class="sep">
@endif

{{-- ===== FOOTER ===== --}}
<div class="footer">
  Documento generado el {{ now()->format('d/m/Y H:i') }} &nbsp;·&nbsp;
  Historia Clínica Estética #HCE-{{ str_pad($tratamiento->id,5,'0',STR_PAD_LEFT) }} &nbsp;·&nbsp;
  Sesión N° {{ $tratamiento->sesion_numero ?? 1 }} &nbsp;·&nbsp;
  <strong>DOCUMENTO CONFIDENCIAL</strong>
</div>

</div>
</body>
</html>