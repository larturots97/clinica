<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:DejaVu Sans,sans-serif;font-size:10px;color:#2d2420;background:white;}
.page{padding:20px 28px;}
/* HEADER */
.header{display:table;width:100%;border-bottom:2px solid #c9a96e;padding-bottom:12px;margin-bottom:14px;}
.header-left{display:table-cell;vertical-align:middle;width:70%;}
.header-right{display:table-cell;vertical-align:middle;text-align:right;width:30%;}
.clinica-nombre{font-size:16px;font-weight:bold;color:#3d1f0a;}
.medico-nombre{font-size:11px;color:#7a5c38;margin-top:2px;}
.cedula{font-size:9px;color:#a08060;}
.folio{font-size:9px;color:#a08060;text-align:right;}
.folio strong{font-size:13px;color:#3d1f0a;display:block;}
/* SECCION */
.seccion{margin-bottom:12px;}
.sec-titulo{font-size:9px;font-weight:bold;text-transform:uppercase;letter-spacing:.5px;color:#b08060;border-bottom:1px solid #f0e6d3;padding-bottom:3px;margin-bottom:6px;}
/* GRID */
.grid2{display:table;width:100%;}
.col2{display:table-cell;width:50%;padding-right:10px;vertical-align:top;}
.col2:last-child{padding-right:0;}
.grid3{display:table;width:100%;}
.col3{display:table-cell;width:33%;padding-right:8px;vertical-align:top;}
.col3:last-child{padding-right:0;}
.field{margin-bottom:6px;}
.field-label{font-size:8px;color:#8a6a50;text-transform:uppercase;letter-spacing:.3px;}
.field-value{font-size:10px;color:#2d2420;font-weight:bold;}
/* BADGE */
.badge{display:inline-block;padding:2px 7px;border-radius:4px;font-size:9px;font-weight:bold;}
.badge-a{background:#fef3c7;color:#92400e;}
.badge-b{background:#d1fae5;color:#065f46;}
.badge-c{background:#dbeafe;color:#1e40af;}
.badge-d{background:#ede9fe;color:#5b21b6;}
.badge-e{background:#fee2e2;color:#991b1b;}
/* MAPA */
.mapa-wrap{text-align:center;margin:0 auto;}
/* TABLA ZONAS */
table{width:100%;border-collapse:collapse;}
th{background:#f5f0e8;font-size:8px;text-transform:uppercase;letter-spacing:.3px;color:#8a6a50;padding:4px 6px;text-align:left;}
td{padding:4px 6px;font-size:9px;border-bottom:1px solid #f5f0e8;}
/* FIRMAS */
.firmas{display:table;width:100%;margin-top:20px;border-top:1px solid #f0e6d3;padding-top:16px;}
.firma-col{display:table-cell;width:50%;text-align:center;padding:0 10px;}
.firma-linea{border-top:1px solid #3d2010;width:80%;margin:0 auto 4px;}
.firma-label{font-size:9px;color:#8a6a50;}
.firma-nombre{font-size:10px;font-weight:bold;color:#3d1f0a;}
/* FOOTER */
.footer{margin-top:16px;border-top:1px solid #f0e6d3;padding-top:8px;text-align:center;font-size:8px;color:#a08060;}
/* ORNAMENTO */
.ornamento{text-align:center;color:#c9a96e;font-size:11px;margin:8px 0;}
</style>
</head>
<body>
<div class="page">

  {{-- HEADER --}}
  <div class="header">
    <div class="header-left">
      @if($tratamiento->medico?->logo)
      <img src="{{ storage_path('app/public/'.$tratamiento->medico->logo) }}" height="40" style="margin-bottom:4px;"><br>
      @endif
      <div class="clinica-nombre">Historia Clínica Estética</div>
      <div class="medico-nombre">{{ $tratamiento->medico?->nombre }} {{ $tratamiento->medico?->apellidos }}</div>
      <div class="cedula">Cédula: {{ $tratamiento->medico?->cedula_profesional ?? '—' }}</div>
    </div>
    <div class="header-right">
      <div class="folio">
        <strong>HCE-{{ str_pad($tratamiento->id, 5, '0', STR_PAD_LEFT) }}</strong>
        Folio
      </div>
      <div style="margin-top:6px;font-size:9px;color:#8a6a50;">
        Fecha: {{ $tratamiento->fecha?->format('d/m/Y') }}<br>
        Sesión N°: {{ $tratamiento->sesion_numero }}
      </div>
    </div>
  </div>

  <div class="ornamento">✦</div>

  {{-- PACIENTE --}}
  <div class="seccion">
    <div class="sec-titulo">Datos del Paciente</div>
    <div class="grid2">
      <div class="col2">
        <div class="field"><div class="field-label">Nombre completo</div><div class="field-value">{{ $tratamiento->paciente?->nombre }} {{ $tratamiento->paciente?->apellidos }}</div></div>
        <div class="field"><div class="field-label">Expediente</div><div class="field-value">EXP-{{ str_pad($tratamiento->paciente?->id, 5, '0', STR_PAD_LEFT) }}</div></div>
      </div>
      <div class="col2">
        <div class="field"><div class="field-label">Tratamiento</div>
          <div class="field-value">
            {{ $tratamiento->titulo ?? $tratamiento->tipoTratamiento?->nombre }}
            @if($tratamiento->grupo)
            <span class="badge badge-{{ strtolower($tratamiento->grupo) }}">Grupo {{ $tratamiento->grupo }}</span>
            @endif
          </div>
        </div>
        @if($tratamiento->motivo_consulta)
        <div class="field"><div class="field-label">Motivo de consulta</div><div class="field-value">{{ $tratamiento->motivo_consulta }}</div></div>
        @endif
      </div>
    </div>
  </div>

  {{-- EVALUACIÓN --}}
  <div class="seccion">
    <div class="sec-titulo">Evaluación Clínica</div>
    <div class="grid3">
      <div class="col3">
        <div class="field"><div class="field-label">Fototipo Fitzpatrick</div><div class="field-value">{{ $tratamiento->fitzpatrick ? 'Tipo '.$tratamiento->fitzpatrick : '—' }}</div></div>
      </div>
      <div class="col3">
        <div class="field"><div class="field-label">Tipo de piel</div><div class="field-value">{{ $tratamiento->tipo_piel ? implode(', ', $tratamiento->tipo_piel) : '—' }}</div></div>
      </div>
      <div class="col3">
        <div class="field"><div class="field-label">Condiciones</div><div class="field-value">{{ $tratamiento->condiciones_piel ? implode(', ', $tratamiento->condiciones_piel) : '—' }}</div></div>
      </div>
    </div>
  </div>

  {{-- ZONAS --}}
  @if($tratamiento->zonas->count())
  <div class="seccion">
    <div class="sec-titulo">Zonas de Aplicación</div>
    <table>
      <thead><tr><th>Zona</th><th>Tipo</th><th>Cantidad</th><th>Unidad</th><th>Notas</th></tr></thead>
      <tbody>
        @foreach($tratamiento->zonas as $zona)
        <tr>
          <td><strong>{{ $zona->zona_label ?: $zona->zona }}</strong></td>
          <td>{{ $zona->tipo === 'libre' ? 'Punto libre' : 'Predefinida' }}</td>
          <td>{{ $zona->cantidad ?? '—' }}</td>
          <td>{{ $zona->unidad ?? '—' }}</td>
          <td>{{ $zona->notas ?? '—' }}</td>
        </tr>
        @endforeach
        @if($tratamiento->zonas->where('tipo','predefinida')->sum('cantidad') > 0)
        <tr style="background:#f5f0e8;">
          <td colspan="2"><strong>Total</strong></td>
          <td><strong>{{ $tratamiento->zonas->where('tipo','predefinida')->sum('cantidad') }}</strong></td>
          <td>U</td><td></td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>
  @endif

  {{-- PRODUCTO --}}
  @if($tratamiento->producto_marca)
  <div class="seccion">
    <div class="sec-titulo">Producto Utilizado</div>
    <div class="grid3">
      <div class="col3"><div class="field"><div class="field-label">Marca / Nombre</div><div class="field-value">{{ $tratamiento->producto_marca }}</div></div></div>
      <div class="col3"><div class="field"><div class="field-label">Lote</div><div class="field-value">{{ $tratamiento->producto_lote ?? '—' }}</div></div></div>
      <div class="col3"><div class="field"><div class="field-label">Caducidad</div><div class="field-value">{{ $tratamiento->producto_caducidad?->format('d/m/Y') ?? '—' }}</div></div></div>
    </div>
  </div>
  @endif

  {{-- OBJETIVO --}}
  @if($tratamiento->objetivo || $tratamiento->observaciones_post)
  <div class="seccion">
    <div class="sec-titulo">Notas Clínicas</div>
    @if($tratamiento->objetivo)
    <div class="field"><div class="field-label">Objetivo</div><div class="field-value">{{ $tratamiento->objetivo }}</div></div>
    @endif
    @if($tratamiento->observaciones_post)
    <div class="field"><div class="field-label">Observaciones post-aplicación</div><div class="field-value">{{ $tratamiento->observaciones_post }}</div></div>
    @endif
  </div>
  @endif

  <div class="ornamento">✦</div>

  {{-- FIRMAS --}}
  <div class="firmas">
    <div class="firma-col">
      <div style="height:50px;"></div>
      @if($tratamiento->medico?->firma)
      <img src="{{ storage_path('app/public/'.$tratamiento->medico->firma) }}" height="40" style="margin-bottom:4px;">
      @endif
      <div class="firma-linea"></div>
      <div class="firma-nombre">{{ $tratamiento->medico?->nombre }} {{ $tratamiento->medico?->apellidos }}</div>
      <div class="firma-label">Médico responsable · Cédula {{ $tratamiento->medico?->cedula_profesional ?? '—' }}</div>
    </div>
    <div class="firma-col">
      <div style="height:50px;"></div>
      <div class="firma-linea"></div>
      <div class="firma-nombre">{{ $tratamiento->paciente?->nombre }} {{ $tratamiento->paciente?->apellidos }}</div>
      <div class="firma-label">Paciente · Firma de conformidad</div>
    </div>
  </div>

  {{-- FOOTER --}}
  <div class="footer">
    Documento generado el {{ now()->format('d/m/Y H:i') }} · Historia Clínica Estética #HCE-{{ str_pad($tratamiento->id,5,'0',STR_PAD_LEFT) }} · Confidencial
  </div>

</div>
</body>
</html>
