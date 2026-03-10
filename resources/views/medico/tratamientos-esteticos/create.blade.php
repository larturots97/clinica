@extends('layouts.medico')
@section('titulo', 'Nuevo Tratamiento Estético')
@section('contenido')

<style>
.trat-btn{padding:8px 6px;border-radius:9px;border:1.5px solid #e2e8f0;cursor:pointer;text-align:center;transition:all .15s;background:white;}
.trat-btn:hover{border-color:#9333ea;background:#faf5ff;}
.trat-btn.sel{border-color:#9333ea;background:#faf5ff;box-shadow:0 0 0 2px rgba(147,51,234,.12);}
.trat-btn .trat-icon{font-size:18px;display:block;margin-bottom:3px;}
.trat-btn .trat-name{font-size:10px;font-weight:700;color:#1e293b;line-height:1.2;}
.trat-btn .trat-grupo{font-size:9px;color:#94a3b8;margin-top:2px;}
.trat-section{display:none;}.trat-section.visible{display:block;}
.ck-item{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:6px;border:1.5px solid #e2e8f0;cursor:pointer;font-size:12px;transition:all .15s;background:white;margin:2px;}
.ck-item:hover{border-color:#9333ea;background:#faf5ff;}
.ck-item.on{border-color:#9333ea;background:#faf5ff;font-weight:600;color:#7c3aed;}
.fi-item{flex:1;padding:6px 4px;border-radius:7px;border:1.5px solid #e2e8f0;text-align:center;cursor:pointer;transition:all .15s;}
.fi-item:hover,.fi-item.sel{border-color:#9333ea;background:#faf5ff;}
.color-dot{width:20px;height:20px;border-radius:50%;cursor:pointer;border:2px solid transparent;transition:all .12s;display:inline-block;}
.color-dot:hover{transform:scale(1.2);}
.color-dot.sel{border-color:#1e293b;transform:scale(1.15);}
label-field{font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;}
</style>

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
    <a href="{{ route('medico.tratamientos-esteticos.index') }}" style="color:#94a3b8;text-decoration:none;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h3 class="font-serif" style="font-size:21px;">Nuevo Tratamiento Estético</h3>
</div>

@if($errors->any())
<div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px;">
    <i class="fa-solid fa-circle-xmark" style="margin-right:6px;"></i>{{ $errors->first() }}
</div>
@endif

<form action="{{ route('medico.tratamientos-esteticos.store') }}" method="POST" id="formHCE">
@csrf
<input type="hidden" name="puntos_libres" id="puntosLibresInput" value="[]">

<div style="display:grid;grid-template-columns:1fr 300px;gap:18px;align-items:start;">

{{-- COLUMNA PRINCIPAL --}}
<div style="display:flex;flex-direction:column;gap:14px;min-width:0;">

  {{-- PACIENTE Y FECHA --}}
  <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
    <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;gap:7px;">
      <span style="width:26px;height:26px;border-radius:7px;background:#f3e8ff;color:#9333ea;display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-user" style="font-size:11px;"></i></span>
      Datos de la consulta
    </h4>
    <div style="display:grid;grid-template-columns:1fr 1fr 120px;gap:14px;">
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Paciente *</label>
        <select name="paciente_id" required style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
          <option value="">Seleccionar...</option>
          @foreach($pacientes as $p)
          <option value="{{ $p->id }}" {{ old('paciente_id', $paciente?->id)==$p->id?'selected':'' }}>{{ $p->nombre }} {{ $p->apellidos }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Fecha *</label>
        <input type="date" name="fecha" value="{{ date('Y-m-d') }}" required readonly style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;background:#f8fafc;color:#64748b;cursor:not-allowed;">
      </div>
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Sesión N°</label>
        <input type="number" name="sesion_numero" value="{{ old('sesion_numero',1) }}" min="1" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
      </div>
      <div style="grid-column:span 3;">
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Motivo de consulta</label>
        <input type="text" name="motivo_consulta" value="{{ old('motivo_consulta') }}" placeholder="ej: Aplicación preventiva frente" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
      </div>
    </div>
  </div>

  {{-- SELECTOR TRATAMIENTO --}}
  <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
    <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;gap:7px;">
      <span style="width:26px;height:26px;border-radius:7px;background:#f3e8ff;color:#9333ea;display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-syringe" style="font-size:11px;"></i></span>
      Tipo de Tratamiento *
    </h4>
    <input type="hidden" name="tipo_tratamiento_id" id="tipoTratamientoId">
    <input type="hidden" name="grupo" id="grupoInput">
    <input type="hidden" name="tipo_clave" id="tipoClave">

    @if($tipos->isEmpty())
    <div style="background:#fef3c7;border:1px solid #fde68a;color:#92400e;padding:12px 16px;border-radius:9px;font-size:13px;">
      No tienes tratamientos en tu catálogo.
      <a href="{{ route('medico.tipo-tratamientos.create') }}" style="color:#7c3aed;font-weight:600;">Agregar uno aquí →</a>
    </div>
    @else
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(90px,1fr));gap:8px;margin-bottom:16px;" id="tratSelector">
      @foreach($tipos as $grupo => $lista)
        @foreach($lista as $tipo)
        <div class="trat-btn" data-id="{{ $tipo->id }}" data-grupo="{{ $tipo->grupo }}" data-clave="{{ $tipo->clave }}" onclick="selTrat(this)">
          <span class="trat-icon">✨</span>
          <div class="trat-name">{{ $tipo->nombre }}</div>
          <div class="trat-grupo">Grupo {{ $tipo->grupo }}</div>
        </div>
        @endforeach
      @endforeach
    </div>

    {{-- SECCIONES POR TIPO --}}
    <div id="seccionesTrat">

      <div class="trat-section" id="sec-botox">
        <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:12px;">
          @foreach(['Frente','Glabela','Patas de gallo','Bunny lines','Peribucales','Cuello','Masetero','Son. gingival'] as $z)
          <label class="ck-item"><input type="checkbox" name="zonas_tags[]" value="{{ $z }}" class="d-none" style="display:none;"> {{ $z }}</label>
          @endforeach
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <div>
            <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Simetría facial</label>
            <select name="simetria" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
              <option>Alineación adecuada</option><option>Leve asimetría</option><option>Asimetría moderada</option>
            </select>
          </div>
          <div>
            <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Tonicidad muscular</label>
            <select name="tonicidad" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
              <option>Hiperactividad visible</option><option>Actividad moderada</option><option>Actividad leve</option>
            </select>
          </div>
        </div>
      </div>

      <div class="trat-section" id="sec-ha">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Técnica</label>
          <select name="tecnica" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            <option>Bolus</option><option>Lineal anterógrado</option><option>Retrotracing</option><option>Fanning</option>
          </select></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Profundidad</label>
          <select name="profundidad" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            <option>Subdérmico</option><option>Supraperióstico</option><option>Intradérmico</option>
          </select></div>
        </div>
      </div>

      <div class="trat-section" id="sec-profhilo">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Tipo de sesión</label>
          <select name="campos_extra[sesion_tipo]" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            <option>1ª sesión</option><option>2ª sesión (1 mes)</option><option>Mantenimiento</option>
          </select></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Volumen total (ml)</label>
          <input type="number" name="volumen_total" step="0.1" placeholder="ej: 2" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
        </div>
      </div>

      <div class="trat-section" id="sec-skinbooster">
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Zona facial</label>
          <select name="campos_extra[zona_facial]" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            <option>Cara completa</option><option>Contorno de ojos</option><option>Cuello y escote</option><option>Manos</option>
          </select></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Técnica</label>
          <select name="tecnica" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            <option>Microbolus</option><option>Nappage</option><option>Mixta</option>
          </select></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Intervalo</label>
          <input type="text" name="intervalo" placeholder="ej: 4 semanas" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
        </div>
      </div>

      <div class="trat-section" id="sec-pdrn">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Indicación</label>
          <select name="campos_extra[indicacion]" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            <option>Rejuvenecimiento</option><option>Cicatrices acné</option><option>Manchas</option><option>Post-laser</option>
          </select></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Concentración</label>
          <input type="text" name="campos_extra[concentracion]" placeholder="ej: 3.2 mg/ml" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
        </div>
      </div>

      <div class="trat-section" id="sec-nctf">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Formulación</label>
          <select name="campos_extra[formulacion]" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            <option>NCTF 135</option><option>NCTF 135 HA</option>
          </select></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Volumen (ml)</label>
          <input type="number" name="volumen_total" step="0.1" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
        </div>
      </div>

      <div class="trat-section" id="sec-prf">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Tipo de PRF</label>
          <select name="campos_extra[tipo_prf]" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            <option>PRF líquido</option><option>PRF membrana</option><option>i-PRF</option><option>A-PRF</option>
          </select></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Volumen obtenido (ml)</label>
          <input type="number" name="volumen_total" step="0.1" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
        </div>
      </div>

      <div class="trat-section" id="sec-microneedling">
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Profundidad (mm)</label>
          <input type="text" name="profundidad" placeholder="ej: 1.5 mm" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">N° pasadas</label>
          <input type="number" name="campos_extra[pasadas]" value="3" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Sérum</label>
          <input type="text" name="campos_extra[serum]" placeholder="ej: Vitamina C + HA" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
        </div>
      </div>

      <div class="trat-section" id="sec-lipoenzimas">
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Producto</label>
          <input type="text" name="producto_marca" placeholder="ej: Fosfatidilcolina" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Concentración</label>
          <input type="text" name="campos_extra[concentracion]" placeholder="ej: 50 mg/ml" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Volumen total (ml)</label>
          <input type="number" name="volumen_total" step="0.1" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
        </div>
      </div>

      <div class="trat-section" id="sec-glp1">
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Medicamento</label>
          <select name="campos_extra[medicamento]" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            <option>Semaglutida</option><option>Tirzepatida</option><option>Liraglutida</option>
          </select></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Dosis</label>
          <input type="text" name="campos_extra[dosis]" placeholder="ej: 0.25 mg" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Vía</label>
          <select name="campos_extra[via]" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            <option>Subcutánea</option><option>Oral</option>
          </select></div>
        </div>
      </div>

      <div class="trat-section" id="sec-escleroterapia">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Esclerosante</label>
          <select name="campos_extra[esclerosante]" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            <option>Polidocanol</option><option>Tetradecilsulfato</option><option>Solución salina hipert.</option>
          </select></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Concentración (%)</label>
          <input type="text" name="campos_extra[concentracion]" placeholder="ej: 1%" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
        </div>
      </div>

      <div class="trat-section" id="sec-peeling">
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:12px;">
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Tipo</label>
          <select name="campos_extra[tipo_peeling]" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            <option>Superficial</option><option>Medio</option><option>Profundo</option><option>Combinado</option>
          </select></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Agente</label>
          <input type="text" name="campos_extra[agente]" placeholder="ej: Glicólico" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Concentración</label>
          <input type="text" name="campos_extra[concentracion]" placeholder="ej: 30%" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Tiempo contacto</label>
          <input type="text" name="campos_extra[tiempo]" placeholder="ej: 3 min" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
        </div>
      </div>

      <div class="trat-section" id="sec-mesoterapia">
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Tipo</label>
          <select name="campos_extra[tipo_meso]" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            <option>Facial rejuvenecimiento</option><option>Alopecia</option><option>Corporal</option>
          </select></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Cóctel</label>
          <input type="text" name="campos_extra[coctel]" placeholder="Componentes..." style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Técnica</label>
          <select name="tecnica" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            <option>Nappage</option><option>Punto por punto</option><option>Mesoperfusión</option>
          </select></div>
        </div>
      </div>

      <div class="trat-section" id="sec-capilar">
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Diagnóstico</label>
          <select name="campos_extra[diagnostico_capilar]" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            <option>Alopecia androgénica</option><option>Alopecia areata</option><option>Efluvio telógeno</option>
          </select></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Patrón Hamilton</label>
          <select name="campos_extra[hamilton]" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            @foreach(['I','II','III','IV','V','VI','VII'] as $h)<option>{{ $h }}</option>@endforeach
          </select></div>
          <div><label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Intervalo</label>
          <input type="text" name="intervalo" placeholder="ej: 2 semanas" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"></div>
        </div>
      </div>

    </div>{{-- /seccionesTrat --}}

    <hr style="border:none;border-top:1px solid #f1f5f9;margin:16px 0;">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Objetivo del tratamiento</label>
        <textarea name="objetivo" rows="2" placeholder="Describe el objetivo..." style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;resize:vertical;">{{ old('objetivo') }}</textarea>
      </div>
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Observaciones post-aplicación</label>
        <textarea name="observaciones_post" rows="2" placeholder="Reacciones, indicaciones al paciente..." style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;resize:vertical;">{{ old('observaciones_post') }}</textarea>
      </div>
    </div>
    @endif
  </div>

  {{-- SIGNOS VITALES --}}
  <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
    <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;gap:7px;">
      <span style="width:26px;height:26px;border-radius:7px;background:#dbeafe;color:#1d4ed8;display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-heart-pulse" style="font-size:11px;"></i></span>
      Signos Vitales
    </h4>
    <div style="display:grid;grid-template-columns:repeat(6,1fr);gap:10px;">
      <div>
        <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px;">Peso</label>
        <div style="position:relative;">
          <input type="number" name="peso" value="{{ old('peso') }}" step="0.1" min="0" placeholder="kg" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 28px 8px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
          <span style="position:absolute;right:8px;top:50%;transform:translateY(-50%);font-size:10px;color:#94a3b8;font-weight:600;">kg</span>
        </div>
      </div>
      <div>
        <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px;">Talla</label>
        <div style="position:relative;">
          <input type="number" name="talla" value="{{ old('talla') }}" step="0.1" min="0" placeholder="cm" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 28px 8px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
          <span style="position:absolute;right:8px;top:50%;transform:translateY(-50%);font-size:10px;color:#94a3b8;font-weight:600;">cm</span>
        </div>
      </div>
      <div>
        <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px;">Temperatura</label>
        <div style="position:relative;">
          <input type="number" name="temperatura" value="{{ old('temperatura') }}" step="0.1" min="30" max="45" placeholder="°C" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 28px 8px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
          <span style="position:absolute;right:8px;top:50%;transform:translateY(-50%);font-size:10px;color:#94a3b8;font-weight:600;">°C</span>
        </div>
      </div>
      <div>
        <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px;">T / A</label>
        <input type="text" name="tension_arterial" value="{{ old('tension_arterial') }}" placeholder="120/80" style="width:100%;border:1.5px solid #fee2e2;border-radius:8px;padding:8px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;color:#dc2626;font-weight:600;">
      </div>
      <div>
        <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px;">F.C.</label>
        <div style="position:relative;">
          <input type="number" name="frecuencia_cardiaca" value="{{ old('frecuencia_cardiaca') }}" step="1" min="30" max="250" placeholder="lpm" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 32px 8px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
          <span style="position:absolute;right:5px;top:50%;transform:translateY(-50%);font-size:9px;color:#94a3b8;font-weight:600;">lpm</span>
        </div>
      </div>
      <div>
        <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px;">Sat O₂</label>
        <div style="position:relative;">
          <input type="number" name="saturacion_o2" value="{{ old('saturacion_o2') }}" step="1" min="50" max="100" placeholder="%" style="width:100%;border:1.5px solid #dbeafe;border-radius:8px;padding:8px 22px 8px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;color:#1d4ed8;font-weight:600;">
          <span style="position:absolute;right:7px;top:50%;transform:translateY(-50%);font-size:11px;color:#60a5fa;font-weight:700;">%</span>
        </div>
      </div>
    </div>
  </div>

  {{-- EXPLORACIÓN FÍSICA --}}
  <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
    <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;gap:7px;">
      <span style="width:26px;height:26px;border-radius:7px;background:#d1fae5;color:#065f46;display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-stethoscope" style="font-size:11px;"></i></span>
      Exploración Física
    </h4>
    <textarea name="exploracion_fisica" rows="3" placeholder="Describe los hallazgos de la exploración física..." style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:10px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;resize:vertical;color:#374151;">{{ old('exploracion_fisica') }}</textarea>
  </div>

  {{-- PRODUCTO --}}
  <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
    <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;gap:7px;">
      <span style="width:26px;height:26px;border-radius:7px;background:#f3e8ff;color:#9333ea;display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-box" style="font-size:11px;"></i></span>
      Producto Utilizado
    </h4>

    {{-- Selector del inventario --}}
    <div style="margin-bottom:16px;padding:14px;background:#faf5ff;border-radius:10px;border:1px solid #e9d5ff;">
      <label style="font-size:12px;font-weight:700;color:#7c3aed;display:block;margin-bottom:10px;">
        <i class="fa-solid fa-boxes-stacked" style="margin-right:5px;"></i>
        Seleccionar del inventario <span style="font-weight:400;color:#9ca3af;">(descuenta stock automáticamente)</span>
      </label>
      <div style="display:grid;grid-template-columns:1fr 140px;gap:10px;align-items:end;">
        <div>
          <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Producto</label>
          <select name="producto_id" id="producto_id" onchange="actualizarInfoProducto(this)"
            style="width:100%;border:1.5px solid #e9d5ff;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;background:white;">
            <option value="">— Sin producto del inventario —</option>
            @foreach($productos as $prod)
            <option value="{{ $prod->id }}"
              data-stock="{{ $prod->stock_actual }}"
              data-unidad="{{ $prod->unidad }}"
              data-nombre="{{ $prod->nombre }}"
              {{ old('producto_id') == $prod->id ? 'selected' : '' }}>
              {{ $prod->nombre }} ({{ $prod->codigo }}) — Stock: {{ $prod->stock_actual }} {{ $prod->unidad }}
            </option>
            @endforeach
          </select>
        </div>
        <div>
          <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Cantidad usada</label>
          <div style="position:relative;">
            <input type="number" name="producto_cantidad" id="producto_cantidad"
              value="{{ old('producto_cantidad') }}" min="0.01" step="0.01" placeholder="0"
              style="width:100%;border:1.5px solid #e9d5ff;border-radius:8px;padding:8px 36px 8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            <span id="producto_unidad" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:11px;font-weight:700;color:#9333ea;"></span>
          </div>
        </div>
      </div>
      <div id="producto_info" style="display:none;margin-top:10px;padding:8px 12px;background:white;border-radius:8px;border:1px solid #e9d5ff;font-size:12px;color:#374151;">
        <i class="fa-solid fa-circle-info" style="color:#9333ea;margin-right:5px;"></i>
        <span id="producto_info_text"></span>
      </div>
      @error('producto_cantidad')
        <div style="color:#dc2626;font-size:12px;margin-top:6px;"><i class="fa-solid fa-circle-xmark" style="margin-right:4px;"></i>{{ $message }}</div>
      @enderror
    </div>

    {{-- Datos manuales --}}
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;">
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Marca / Nombre</label>
        <input type="text" name="producto_marca" value="{{ old('producto_marca') }}" placeholder="ej: Botox® Allergan" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
      </div>
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Lote</label>
        <input type="text" name="producto_lote" value="{{ old('producto_lote') }}" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
      </div>
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Caducidad</label>
        <input type="date" name="producto_caducidad" value="{{ old('producto_caducidad') }}" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
      </div>
    </div>
  </div>

  {{-- EVALUACIÓN CLÍNICA --}}
  <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
    <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;gap:7px;">
      <span style="width:26px;height:26px;border-radius:7px;background:#f3e8ff;color:#9333ea;display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-microscope" style="font-size:11px;"></i></span>
      Evaluación Clínica
    </h4>
    <div style="margin-bottom:14px;">
      <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:8px;">Fototipo Fitzpatrick</label>
      <div style="display:flex;gap:6px;" id="fitzRow">
        @php $fitzColors=['#fde8d8','#f5cba7','#e59866','#ca8a5e','#a0522d','#4a2c17']; $fitzLabels=['Muy clara','Clara','Media','Morena','Oscura','Negra']; @endphp
        @foreach([1,2,3,4,5,6] as $n)
        <div class="fi-item" onclick="selFitz({{ $n }}, this)" style="flex:1;padding:6px 4px;border-radius:7px;border:1.5px solid #e2e8f0;text-align:center;cursor:pointer;">
          <div style="font-size:12px;font-weight:700;color:#1e293b;">{{ $n }}</div>
          <div style="width:16px;height:16px;border-radius:50%;margin:3px auto;background:{{ $fitzColors[$n-1] }};border:1px solid rgba(0,0,0,.1);"></div>
          <div style="font-size:9px;color:#64748b;">{{ $fitzLabels[$n-1] }}</div>
        </div>
        @endforeach
      </div>
      <input type="hidden" name="fitzpatrick" id="fitzInput" value="{{ old('fitzpatrick') }}">
    </div>
    <div style="margin-bottom:14px;">
      <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:8px;">Tipo de piel</label>
      <div style="display:flex;flex-wrap:wrap;gap:6px;">
        @foreach(['Seca','Grasa','Mixta','Normal','Sensible'] as $tp)
        <label class="ck-item"><input type="checkbox" name="tipo_piel[]" value="{{ $tp }}" style="display:none;" {{ in_array($tp, old('tipo_piel',[])) ? 'checked':'' }}> {{ $tp }}</label>
        @endforeach
      </div>
    </div>
    <div>
      <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:8px;">Condiciones presentes</label>
      <div style="display:flex;flex-wrap:wrap;gap:6px;">
        @foreach(['Arrugas finas','Líneas dinámicas','Flacidez','Manchas','Lesiones activas','Cicatrices','Poros dilatados'] as $cp)
        <label class="ck-item"><input type="checkbox" name="condiciones_piel[]" value="{{ $cp }}" style="display:none;" {{ in_array($cp, old('condiciones_piel',[])) ? 'checked':'' }}> {{ $cp }}</label>
        @endforeach
      </div>
    </div>
  </div>

</div>{{-- /col principal --}}

{{-- COLUMNA DERECHA --}}
<div style="display:flex;flex-direction:column;gap:14px;min-width:0;overflow:hidden;position:sticky;top:72px;">

  {{-- ACCIONES --}}
  <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
    <button type="submit" style="width:100%;padding:11px;border-radius:9px;font-size:14px;font-weight:600;background:#9333ea;color:white;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;margin-bottom:8px;">
      <i class="fa-solid fa-floppy-disk"></i> Guardar tratamiento
    </button>
    <a href="{{ route('medico.tratamientos-esteticos.index') }}"
      style="display:flex;align-items:center;justify-content:center;padding:9px;border-radius:9px;font-size:13px;font-weight:600;background:white;color:#64748b;border:1.5px solid #e2e8f0;text-decoration:none;">
      Cancelar
    </a>
  </div>

  {{-- MAPA DE ZONAS --}}
  <div id="mapaContainer" style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:14px;display:none;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
      <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:160px;" id="mapaTitulo">Mapa de zonas</span>
      <div style="display:flex;align-items:center;gap:5px;flex-shrink:0;">
        <span style="font-size:10px;color:#94a3b8;" id="mapaSwLabel">Activado</span>
        <div id="mapaSwitch" onclick="toggleMapa()" style="width:34px;height:18px;border-radius:20px;background:#9333ea;cursor:pointer;position:relative;transition:background .2s;flex-shrink:0;">
          <div id="mapaSwitchDot" style="width:12px;height:12px;border-radius:50%;background:white;position:absolute;top:3px;right:3px;transition:right .2s;"></div>
        </div>
      </div>
    </div>
    <div id="mapaBtns" style="display:flex;gap:6px;margin-bottom:10px;">
      <button type="button" id="btnMarcar" onclick="setMode('marcar')" style="flex:1;padding:4px 8px;border-radius:6px;font-size:11px;font-weight:600;background:#9333ea;color:white;border:none;cursor:pointer;">✚ Punto</button>
      <button type="button" id="btnVer" onclick="setMode('ver')" style="flex:1;padding:4px 8px;border-radius:6px;font-size:11px;font-weight:600;background:#f1f5f9;color:#64748b;border:none;cursor:pointer;">👁 Ver</button>
    </div>

    <div id="mapaBody">
      <div id="mapaCara" style="display:none;">
        <svg id="faceSvg" viewBox="0 0 200 290" width="100%" style="display:block;cursor:crosshair;max-width:100%;margin:0 auto;" xmlns="http://www.w3.org/2000/svg">
          <clipPath id="clipFace"><ellipse cx="100" cy="132" rx="64" ry="84"/></clipPath>
          <g clip-path="url(#clipFace)" opacity="0.07">
            <line x1="36" y1="80" x2="55" y2="220" stroke="#3d2010" stroke-width="0.8"/>
            <line x1="44" y1="60" x2="63" y2="220" stroke="#3d2010" stroke-width="0.8"/>
            <line x1="52" y1="50" x2="68" y2="200" stroke="#3d2010" stroke-width="0.8"/>
            <line x1="152" y1="50" x2="136" y2="200" stroke="#3d2010" stroke-width="0.8"/>
            <line x1="158" y1="60" x2="140" y2="220" stroke="#3d2010" stroke-width="0.8"/>
            <line x1="164" y1="80" x2="148" y2="220" stroke="#3d2010" stroke-width="0.8"/>
          </g>
          <ellipse cx="100" cy="132" rx="64" ry="84" fill="#fdf8ee" stroke="#3d2010" stroke-width="1.5"/>
          <path d="M82 208 L80 240 Q100 248 120 240 L118 208" fill="#fdf8ee" stroke="#3d2010" stroke-width="1.2"/>
          <path d="M36 95 Q38 65 60 48 Q80 34 100 32 Q120 34 140 48 Q162 65 164 95 Q152 68 100 66 Q48 68 36 95 Z" fill="#2c1408"/>
          <ellipse cx="36" cy="132" rx="9" ry="15" fill="#fdf0d8" stroke="#3d2010" stroke-width="1.2"/>
          <ellipse cx="164" cy="132" rx="9" ry="15" fill="#fdf0d8" stroke="#3d2010" stroke-width="1.2"/>
          <path d="M62 102 Q75 96 90 100" stroke="#2c1408" stroke-width="2" stroke-linecap="round"/>
          <path d="M110 100 Q125 96 138 102" stroke="#2c1408" stroke-width="2" stroke-linecap="round"/>
          <path d="M62 112 Q76 106 90 112" stroke="#2c1408" stroke-width="2" stroke-linecap="round"/>
          <path d="M110 112 Q124 106 138 112" stroke="#2c1408" stroke-width="2" stroke-linecap="round"/>
          <ellipse cx="76" cy="118" rx="14" ry="9" fill="#fdf8ee" stroke="#2c1408" stroke-width="1.2"/>
          <ellipse cx="124" cy="118" rx="14" ry="9" fill="#fdf8ee" stroke="#2c1408" stroke-width="1.2"/>
          <circle cx="76" cy="118" r="6" fill="#1a0a04"/>
          <circle cx="124" cy="118" r="6" fill="#1a0a04"/>
          <circle cx="74" cy="116" r="2" fill="white"/>
          <circle cx="122" cy="116" r="2" fill="white"/>
          <path d="M80 170 Q100 182 120 170" fill="#c08878" stroke="#3d2010" stroke-width="0.8"/>
          <path d="M80 170 Q100 164 120 170" fill="#a06858" stroke="#3d2010" stroke-width="0.8"/>
          @php $zonasDefSvg=['F'=>[100,74],'GL'=>[100,100],'PGI'=>[52,122],'PGD'=>[148,122],'BL'=>[100,140],'L'=>[100,172],'MI'=>[44,158],'MD'=>[156,158],'C'=>[100,228]]; @endphp
          @foreach($zonasDefSvg as $key=>$coords)
          <g style="cursor:pointer;" onclick="toggleZonaPred('{{ $key }}',this)" id="zpG{{ $key }}">
            <circle cx="{{ $coords[0] }}" cy="{{ $coords[1] }}" r="7" fill="#9333ea" opacity="0" id="dot{{ $key }}"/>
            <text x="{{ $coords[0] }}" y="{{ $coords[1]+4 }}" text-anchor="middle" font-size="7" fill="white" font-weight="700" id="lbl{{ $key }}" opacity="0">{{ $key }}</text>
          </g>
          @endforeach
          <g id="puntosLibresSvg"></g>
        </svg>
      </div>

      <div id="mapaCapilar" style="display:none;">
        <svg id="capilarSvg" viewBox="0 0 200 200" width="100%" style="display:block;cursor:crosshair;max-width:100%;margin:0 auto;" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="100" cy="100" rx="78" ry="88" fill="#fdf8ee" stroke="#3d2010" stroke-width="1.5"/>
          <ellipse cx="100" cy="100" rx="78" ry="88" fill="none" stroke="#2c1408" stroke-width="8" opacity="0.15"/>
          <line x1="100" y1="12" x2="100" y2="188" stroke="#c0906a" stroke-width="0.8" stroke-dasharray="4,3" opacity="0.5"/>
          <line x1="22" y1="100" x2="178" y2="100" stroke="#c0906a" stroke-width="0.8" stroke-dasharray="4,3" opacity="0.5"/>
          <g style="cursor:pointer;" onclick="toggleZonaPred('TOP',this)" id="zpGTOP"><circle cx="100" cy="55" r="18" fill="#9333ea" opacity="0" id="dotTOP"/><text x="100" y="59" text-anchor="middle" font-size="7" fill="white" font-weight="700" id="lblTOP" opacity="0">TOP</text></g>
          <g style="cursor:pointer;" onclick="toggleZonaPred('FR',this)" id="zpGFR"><circle cx="100" cy="28" r="12" fill="#9333ea" opacity="0" id="dotFR"/><text x="100" y="32" text-anchor="middle" font-size="7" fill="white" font-weight="700" id="lblFR" opacity="0">FR</text></g>
          <g style="cursor:pointer;" onclick="toggleZonaPred('OCC',this)" id="zpGOCC"><circle cx="100" cy="170" r="14" fill="#9333ea" opacity="0" id="dotOCC"/><text x="100" y="174" text-anchor="middle" font-size="7" fill="white" font-weight="700" id="lblOCC" opacity="0">OCC</text></g>
          <g style="cursor:pointer;" onclick="toggleZonaPred('TI',this)" id="zpGTI"><circle cx="38" cy="100" r="14" fill="#9333ea" opacity="0" id="dotTI"/><text x="38" y="104" text-anchor="middle" font-size="7" fill="white" font-weight="700" id="lblTI" opacity="0">TI</text></g>
          <g style="cursor:pointer;" onclick="toggleZonaPred('TD',this)" id="zpGTD"><circle cx="162" cy="100" r="14" fill="#9333ea" opacity="0" id="dotTD"/><text x="162" y="104" text-anchor="middle" font-size="7" fill="white" font-weight="700" id="lblTD" opacity="0">TD</text></g>
          <g style="cursor:pointer;" onclick="toggleZonaPred('PI',this)" id="zpGPI"><circle cx="60" cy="65" r="12" fill="#9333ea" opacity="0" id="dotPI"/><text x="60" y="69" text-anchor="middle" font-size="7" fill="white" font-weight="700" id="lblPI" opacity="0">PI</text></g>
          <g style="cursor:pointer;" onclick="toggleZonaPred('PD',this)" id="zpGPD"><circle cx="140" cy="65" r="12" fill="#9333ea" opacity="0" id="dotPD"/><text x="140" y="69" text-anchor="middle" font-size="7" fill="white" font-weight="700" id="lblPD" opacity="0">PD</text></g>
          <g id="puntosLibresSvgCapilar"></g>
        </svg>
        <div style="display:flex;flex-wrap:wrap;gap:4px;margin-top:8px;justify-content:center;">
          @foreach(['TOP'=>'Coronilla','FR'=>'Frontal','OCC'=>'Occipital','TI'=>'Temporal izq.','TD'=>'Temporal der.','PI'=>'Parietal izq.','PD'=>'Parietal der.'] as $k=>$label)
          <span style="font-size:9px;background:#f3e8ff;color:#6b21a8;padding:2px 6px;border-radius:4px;cursor:pointer;" onclick="toggleZonaPred('{{ $k }}', document.getElementById('zpG{{ $k }}'))">{{ $k }} – {{ $label }}</span>
          @endforeach
        </div>
      </div>

      <div id="mapaAbdomen" style="display:none;">
        <svg id="abdomenSvg" viewBox="0 0 200 280" width="100%" style="display:block;cursor:crosshair;max-width:100%;margin:0 auto;" xmlns="http://www.w3.org/2000/svg">
          <path d="M60 10 Q40 10 35 30 L28 120 Q26 150 30 180 L35 260 Q50 275 100 275 Q150 275 165 260 L170 180 Q174 150 172 120 L165 30 Q160 10 140 10 Z" fill="#fdf8ee" stroke="#3d2010" stroke-width="1.5"/>
          <path d="M60 10 Q50 5 38 18 Q30 28 28 40" fill="none" stroke="#3d2010" stroke-width="1.2"/>
          <path d="M140 10 Q150 5 162 18 Q170 28 172 40" fill="none" stroke="#3d2010" stroke-width="1.2"/>
          <ellipse cx="100" cy="148" rx="6" ry="7" fill="none" stroke="#c0906a" stroke-width="1.2"/>
          <line x1="100" y1="30" x2="100" y2="260" stroke="#c0906a" stroke-width="0.8" stroke-dasharray="4,3" opacity="0.5"/>
          <line x1="34" y1="120" x2="166" y2="120" stroke="#c0906a" stroke-width="0.8" stroke-dasharray="4,3" opacity="0.5"/>
          <line x1="34" y1="185" x2="166" y2="185" stroke="#c0906a" stroke-width="0.8" stroke-dasharray="4,3" opacity="0.5"/>
          <g style="cursor:pointer;" onclick="toggleZonaPred('EPI',this)" id="zpGEPI"><circle cx="100" cy="75" r="16" fill="#9333ea" opacity="0" id="dotEPI"/><text x="100" y="79" text-anchor="middle" font-size="7" fill="white" font-weight="700" id="lblEPI" opacity="0">EPI</text></g>
          <g style="cursor:pointer;" onclick="toggleZonaPred('FLI',this)" id="zpGFLI"><circle cx="52" cy="110" r="14" fill="#9333ea" opacity="0" id="dotFLI"/><text x="52" y="114" text-anchor="middle" font-size="7" fill="white" font-weight="700" id="lblFLI" opacity="0">FLI</text></g>
          <g style="cursor:pointer;" onclick="toggleZonaPred('FLD',this)" id="zpGFLD"><circle cx="148" cy="110" r="14" fill="#9333ea" opacity="0" id="dotFLD"/><text x="148" y="114" text-anchor="middle" font-size="7" fill="white" font-weight="700" id="lblFLD" opacity="0">FLD</text></g>
          <g style="cursor:pointer;" onclick="toggleZonaPred('PU',this)" id="zpGPU"><circle cx="100" cy="148" r="16" fill="#9333ea" opacity="0" id="dotPU"/><text x="100" y="152" text-anchor="middle" font-size="7" fill="white" font-weight="700" id="lblPU" opacity="0">PU</text></g>
          <g style="cursor:pointer;" onclick="toggleZonaPred('HIP',this)" id="zpGHIP"><circle cx="100" cy="215" r="16" fill="#9333ea" opacity="0" id="dotHIP"/><text x="100" y="219" text-anchor="middle" font-size="7" fill="white" font-weight="700" id="lblHIP" opacity="0">HIP</text></g>
          <g style="cursor:pointer;" onclick="toggleZonaPred('CI',this)" id="zpGCI"><circle cx="46" cy="165" r="14" fill="#9333ea" opacity="0" id="dotCI"/><text x="46" y="169" text-anchor="middle" font-size="7" fill="white" font-weight="700" id="lblCI" opacity="0">CI</text></g>
          <g style="cursor:pointer;" onclick="toggleZonaPred('CD',this)" id="zpGCD"><circle cx="154" cy="165" r="14" fill="#9333ea" opacity="0" id="dotCD"/><text x="154" y="169" text-anchor="middle" font-size="7" fill="white" font-weight="700" id="lblCD" opacity="0">CD</text></g>
          <g id="puntosLibresSvgAbdomen"></g>
        </svg>
        <div style="display:flex;flex-wrap:wrap;gap:4px;margin-top:8px;justify-content:center;">
          @foreach(['EPI'=>'Epigastrio','FLI'=>'Flanco izq.','FLD'=>'Flanco der.','PU'=>'Periumbilical','HIP'=>'Hipogastrio','CI'=>'Costado izq.','CD'=>'Costado der.'] as $k=>$label)
          <span style="font-size:9px;background:#f3e8ff;color:#6b21a8;padding:2px 6px;border-radius:4px;cursor:pointer;" onclick="toggleZonaPred('{{ $k }}', document.getElementById('zpG{{ $k }}'))">{{ $k }} – {{ $label }}</span>
          @endforeach
        </div>
      </div>

      <div style="background:#f8fafc;border-radius:9px;padding:10px;margin-top:10px;">
        <div style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Color del punto</div>
        <div style="display:flex;gap:6px;margin-bottom:10px;">
          @foreach(['#dc2626'=>'Rojo','#059669'=>'Verde','#2563eb'=>'Azul','#d97706'=>'Naranja','#7c3aed'=>'Morado','#be185d'=>'Rosa'] as $color=>$nombre)
          <div class="color-dot {{ $loop->first?'sel':'' }}" style="background:{{ $color }};width:20px;height:20px;border-radius:50%;cursor:pointer;border:2px solid {{ $loop->first?'#1e293b':'transparent' }};transition:all .12s;" data-color="{{ $color }}" onclick="selColor(this)" title="{{ $nombre }}"></div>
          @endforeach
        </div>
        <div style="margin-bottom:8px;">
          <div style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:4px;">Nombre del punto</div>
          <input type="text" id="nombrePunto" maxlength="40" placeholder="ej: Pata de gallo izq." style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:6px 10px;font-size:12px;font-family:'DM Sans',sans-serif;outline:none;background:white;">
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
          <div>
            <div style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:4px;">Unidades</div>
            <input type="number" id="cantidadPunto" min="0" step="0.5" placeholder="ej: 4" style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:6px 10px;font-size:12px;font-family:'DM Sans',sans-serif;outline:none;background:white;">
          </div>
          <div>
            <div style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:4px;">Etiqueta mapa (máx 5)</div>
            <input type="text" id="labelPunto" maxlength="5" placeholder="ej: 4U" style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:6px 10px;font-size:12px;font-family:'DM Sans',sans-serif;outline:none;background:white;">
          </div>
        </div>
      </div>

      <div id="puntosListaWrap" style="display:none;margin-top:8px;">
        <div style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Puntos agregados</div>
        <div id="puntosLista"></div>
      </div>
    </div>{{-- /mapaBody --}}
  </div>{{-- /mapaContainer --}}

  <input type="hidden" name="mapa_activo" id="mapaActivoInput" value="1">

  {{-- DOSIFICACIÓN --}}
  <div id="dosificacionCard" style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
    <div style="padding:12px 16px;border-bottom:1px solid #e2e8f0;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Dosificación por zona</div>
    <div style="padding:12px 14px;">
      @php $zonasDef=['F'=>['label'=>'Frente','unidad'=>'U'],'GL'=>['label'=>'Glabela','unidad'=>'U'],'PGI'=>['label'=>'P. Gallo izq.','unidad'=>'U'],'PGD'=>['label'=>'P. Gallo der.','unidad'=>'U'],'BL'=>['label'=>'Bunny lines','unidad'=>'U'],'L'=>['label'=>'Labios','unidad'=>'ml'],'MI'=>['label'=>'Masetero izq.','unidad'=>'U'],'MD'=>['label'=>'Masetero der.','unidad'=>'U'],'C'=>['label'=>'Cuello','unidad'=>'U']]; @endphp
      @foreach($zonasDef as $key=>$zona)
      <div style="display:grid;grid-template-columns:1fr 60px 28px;gap:6px;align-items:center;padding:5px 0;border-bottom:1px solid #f8fafc;" id="rowZona{{ $key }}">
        <div style="display:flex;align-items:center;gap:6px;">
          <div style="width:7px;height:7px;border-radius:50%;background:#e2e8f0;" id="dotRowZ{{ $key }}"></div>
          <span style="font-size:12px;font-weight:600;color:#374151;">{{ $zona['label'] }}</span>
        </div>
        <input type="number" name="zonas_predefinidas[{{ $key }}][cantidad]" id="cantZ{{ $key }}" value="0" min="0" step="0.5" style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:4px 8px;font-size:12px;font-family:'DM Sans',sans-serif;outline:none;text-align:center;">
        <span style="font-size:10px;color:#94a3b8;text-align:center;">{{ $zona['unidad'] }}</span>
        <input type="hidden" name="zonas_predefinidas[{{ $key }}][activa]" value="0" id="activaZ{{ $key }}">
        <input type="hidden" name="zonas_predefinidas[{{ $key }}][label]" value="{{ $zona['label'] }}">
        <input type="hidden" name="zonas_predefinidas[{{ $key }}][unidad]" value="{{ $zona['unidad'] }}">
      </div>
      @endforeach
      <div style="display:flex;justify-content:space-between;align-items:center;margin-top:10px;padding:8px 10px;background:#1e293b;border-radius:8px;">
        <span style="font-size:12px;font-weight:700;color:white;">Total</span>
        <span style="font-size:14px;font-weight:700;color:#a78bfa;" id="totalUnidades">0 U</span>
      </div>
    </div>
  </div>

  {{-- ZONAS TEXTO --}}
  <div id="zonasTextoCard" style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:14px;display:none;">
    <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:8px;">Zonas a aplicar</div>
    <textarea name="zonas_texto" id="zonasTexto" rows="4" placeholder="Describe las zonas donde se aplicará el tratamiento..." style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 10px;font-size:12px;font-family:'DM Sans',sans-serif;outline:none;resize:vertical;color:#374151;"></textarea>
  </div>

</div>{{-- /col derecha --}}
</div>{{-- /grid --}}
</form>

<script>
const zonasState={F:true,GL:true,PGI:true,PGD:true,BL:false,L:false,MI:false,MD:false,C:false};
let puntosLibres=[],pidCounter=0,currentColor='#dc2626',currentMode='marcar',mapaActivo=true;

function actualizarInfoProducto(sel) {
  const opt     = sel.options[sel.selectedIndex];
  const info    = document.getElementById('producto_info');
  const infoTx  = document.getElementById('producto_info_text');
  const unidad  = document.getElementById('producto_unidad');
  const cantInput = document.getElementById('producto_cantidad');
  if (!sel.value) {
    info.style.display = 'none';
    unidad.textContent = '';
    cantInput.removeAttribute('max');
    return;
  }
  const stock  = opt.dataset.stock;
  const uni    = opt.dataset.unidad;
  const nombre = opt.dataset.nombre;
  unidad.textContent = uni;
  cantInput.setAttribute('max', stock);
  info.style.display = 'block';
  infoTx.textContent = `${nombre} — Disponible: ${stock} ${uni}. Al guardar se descontará la cantidad indicada.`;
}

function toggleMapa(){
  mapaActivo=!mapaActivo;
  const body=document.getElementById('mapaBody');
  const btns=document.getElementById('mapaBtns');
  const sw=document.getElementById('mapaSwitch');
  const dot=document.getElementById('mapaSwitchDot');
  const lbl=document.getElementById('mapaSwLabel');
  const dosiCard=document.getElementById('dosificacionCard');
  const zonasCard=document.getElementById('zonasTextoCard');
  if(mapaActivo){
    body.style.display='block';btns.style.display='flex';sw.style.background='#9333ea';dot.style.right='3px';
    lbl.textContent='Mapa activado';lbl.style.color='#94a3b8';dosiCard.style.display='block';zonasCard.style.display='none';
    document.getElementById('mapaActivoInput').value='1';
  } else {
    body.style.display='none';btns.style.display='none';sw.style.background='#cbd5e1';dot.style.right='19px';
    lbl.textContent='Mapa desactivado';lbl.style.color='#cbd5e1';dosiCard.style.display='none';zonasCard.style.display='block';
    document.getElementById('mapaActivoInput').value='0';
  }
}

function selTrat(el){
  document.querySelectorAll('.trat-btn').forEach(b=>b.classList.remove('sel'));
  el.classList.add('sel');
  document.getElementById('tipoTratamientoId').value=el.dataset.id;
  document.getElementById('grupoInput').value=el.dataset.grupo;
  document.getElementById('tipoClave').value=el.dataset.clave;
  document.querySelectorAll('.trat-section').forEach(s=>s.classList.remove('visible'));
  const sec=document.getElementById('sec-'+el.dataset.clave);
  if(sec)sec.classList.add('visible');
  const grupo=el.dataset.grupo;
  const mc=document.getElementById('mapaContainer');
  const mCara=document.getElementById('mapaCara');
  const mCap=document.getElementById('mapaCapilar');
  const mAbd=document.getElementById('mapaAbdomen');
  const dosiCard=document.getElementById('dosificacionCard');
  const zonasCard=document.getElementById('zonasTextoCard');
  mCara.style.display=mCap.style.display=mAbd.style.display='none';
  const titulos={'A':'Mapa Facial · Neuromod.','B':'Mapa Facial · Rellenos','C':'Mapa Facial · Bioestim.','D':'Mapa Corporal · Lipolíticos','E':'Mapa Capilar'};
  mapaActivo=true;
  document.getElementById('mapaSwitch').style.background='#9333ea';
  document.getElementById('mapaSwitchDot').style.right='3px';
  document.getElementById('mapaSwLabel').textContent='Mapa activado';
  document.getElementById('mapaSwLabel').style.color='#94a3b8';
  document.getElementById('mapaBody').style.display='block';
  document.getElementById('mapaBtns').style.display='flex';
  document.getElementById('mapaActivoInput').value='1';
  if(['A','B','C'].includes(grupo)){
    mc.style.display='block';mCara.style.display='block';dosiCard.style.display='block';zonasCard.style.display='none';
  } else if(grupo==='D'){
    mc.style.display='block';mAbd.style.display='block';dosiCard.style.display='none';zonasCard.style.display='block';
  } else if(grupo==='E'){
    mc.style.display='block';mCap.style.display='block';dosiCard.style.display='none';zonasCard.style.display='block';
  } else {
    mc.style.display='none';dosiCard.style.display='none';zonasCard.style.display='block';
  }
  const t=document.getElementById('mapaTitulo');
  if(t)t.textContent=titulos[grupo]||'Mapa de zonas';
}

function selFitz(n,el){
  document.querySelectorAll('#fitzRow .fi-item').forEach(f=>{f.style.borderColor='#e2e8f0';f.style.background='white';});
  el.style.borderColor='#9333ea';el.style.background='#faf5ff';
  document.getElementById('fitzInput').value=n;
}

document.querySelectorAll('.ck-item').forEach(item=>{
  const cb=item.querySelector('input[type=checkbox]');
  if(cb&&cb.checked)item.classList.add('on');
  item.addEventListener('click',()=>{cb.checked=!cb.checked;item.classList.toggle('on',cb.checked);});
});

function setMode(mode){
  currentMode=mode;
  ['faceSvg','capilarSvg','abdomenSvg'].forEach(id=>{const s=document.getElementById(id);if(s)s.style.cursor=mode==='marcar'?'crosshair':'default';});
  document.getElementById('btnMarcar').style.background=mode==='marcar'?'#9333ea':'#f1f5f9';
  document.getElementById('btnMarcar').style.color=mode==='marcar'?'white':'#64748b';
  document.getElementById('btnVer').style.background=mode==='ver'?'#64748b':'#f1f5f9';
  document.getElementById('btnVer').style.color=mode==='ver'?'white':'#64748b';
}

function toggleZonaPred(key,g){
  if(currentMode!=='marcar')return;
  zonasState[key]=!zonasState[key];
  const dot=document.getElementById('dot'+key);
  const lbl=document.getElementById('lbl'+key);
  const rowDot=document.getElementById('dotRowZ'+key);
  const row=document.getElementById('rowZona'+key);
  const activa=document.getElementById('activaZ'+key);
  if(zonasState[key]){
    dot.setAttribute('opacity','0.9');if(lbl)lbl.setAttribute('opacity','1');
    if(rowDot)rowDot.style.background='#9333ea';if(row)row.style.background='#faf5ff';if(activa)activa.value='1';
  } else {
    dot.setAttribute('opacity','0');if(lbl)lbl.setAttribute('opacity','0');
    if(rowDot)rowDot.style.background='#e2e8f0';if(row)row.style.background='';if(activa)activa.value='0';
  }
  calcTotal();
}

function calcTotal(){
  let total=0;
  document.querySelectorAll('[id^=cantZ]').forEach(i=>{
    const key=i.id.replace('cantZ','');
    if(zonasState[key])total+=parseFloat(i.value)||0;
  });
  document.getElementById('totalUnidades').textContent=total+' U';
}
document.querySelectorAll('[id^=cantZ]').forEach(i=>i.addEventListener('input',calcTotal));

function selColor(el){
  document.querySelectorAll('.color-dot').forEach(c=>{c.classList.remove('sel');c.style.border='2px solid transparent';});
  el.classList.add('sel');el.style.border='2px solid #1e293b';
  currentColor=el.dataset.color;
}

document.getElementById('faceSvg').addEventListener('click',function(e){
  if(currentMode!=='marcar')return;
  if(e.target.closest('[id^=zpG]'))return;
  const svg=document.getElementById('faceSvg');
  const rect=svg.getBoundingClientRect();
  const x=(e.clientX-rect.left)*(200/rect.width);
  const y=(e.clientY-rect.top)*(290/rect.height);
  if(Math.pow((x-100)/64,2)+Math.pow((y-132)/84,2)>1&&!(x>=82&&x<=118&&y>=208&&y<=242))return;
  const nombre=document.getElementById('nombrePunto').value.trim();
  const cantidad=parseFloat(document.getElementById('cantidadPunto').value)||null;
  const label=document.getElementById('labelPunto').value.trim();
  addPunto(x,y,currentColor,label,nombre,cantidad);
});

function addPunto(x,y,color,label,nombre,cantidad){
  const id='p'+(++pidCounter);
  puntosLibres.push({id,x,y,color,label,nombre:nombre||'',cantidad:cantidad||null});
  const g=document.createElementNS('http://www.w3.org/2000/svg','g');
  g.setAttribute('id','svgP'+id);g.style.cursor='pointer';
  const ring=document.createElementNS('http://www.w3.org/2000/svg','circle');
  ring.setAttribute('cx',x);ring.setAttribute('cy',y);ring.setAttribute('r','9');
  ring.setAttribute('fill',color);ring.setAttribute('opacity','0.2');g.appendChild(ring);
  const c=document.createElementNS('http://www.w3.org/2000/svg','circle');
  c.setAttribute('cx',x);c.setAttribute('cy',y);c.setAttribute('r','5.5');
  c.setAttribute('fill',color);c.setAttribute('stroke','white');c.setAttribute('stroke-width','1.2');g.appendChild(c);
  const svgLabel=label||(cantidad?cantidad+'U':'');
  if(svgLabel){
    const t=document.createElementNS('http://www.w3.org/2000/svg','text');
    t.setAttribute('x',x+8);t.setAttribute('y',y-5);t.setAttribute('font-size','7');
    t.setAttribute('fill',color);t.setAttribute('font-weight','700');t.textContent=svgLabel;g.appendChild(t);
  }
  g.addEventListener('click',e=>{e.stopPropagation();removePunto(id);});
  document.getElementById('puntosLibresSvg').appendChild(g);
  updatePuntosInput();
}

function removePunto(id){
  puntosLibres=puntosLibres.filter(p=>p.id!==id);
  const el=document.getElementById('svgP'+id);if(el)el.remove();
  updatePuntosInput();
}

function updatePuntosInput(){
  document.getElementById('puntosLibresInput').value=JSON.stringify(puntosLibres.map(p=>({x:p.x,y:p.y,color:p.color,label:p.label,nombre:p.nombre,cantidad:p.cantidad})));
  const lista=document.getElementById('puntosLista');
  const wrap=document.getElementById('puntosListaWrap');
  lista.innerHTML='';
  if(!puntosLibres.length){wrap.style.display='none';return;}
  wrap.style.display='block';
  puntosLibres.forEach((p,i)=>{
    const nombreText=p.nombre||('Punto '+(i+1));
    const cantText=p.cantidad?`<span style="background:#ede9fe;color:#7c3aed;font-size:10px;font-weight:700;padding:1px 6px;border-radius:5px;margin-left:4px;">${p.cantidad} U</span>`:'';
    lista.innerHTML+=`<div style="display:flex;align-items:center;justify-content:space-between;padding:6px 8px;background:#f8fafc;border-radius:7px;margin-bottom:4px;font-size:12px;">
      <div style="display:flex;align-items:center;gap:6px;flex:1;min-width:0;">
        <div style="width:8px;height:8px;border-radius:50%;flex-shrink:0;background:${p.color};"></div>
        <span style="color:#374151;font-weight:600;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">${nombreText}</span>${cantText}
      </div>
      <span style="cursor:pointer;color:#94a3b8;font-size:14px;margin-left:8px;flex-shrink:0;" onclick="removePunto('${p.id}')">✕</span>
    </div>`;
  });
}

['F','GL','PGI','PGD'].forEach(k=>{
  zonasState[k]=true;
  const activa=document.getElementById('activaZ'+k);if(activa)activa.value='1';
  const dot=document.getElementById('dot'+k);if(dot){dot.setAttribute('fill','#9333ea');dot.setAttribute('opacity','0.9');}
  const lbl=document.getElementById('lbl'+k);if(lbl)lbl.setAttribute('opacity','1');
  const rowDot=document.getElementById('dotRowZ'+k);if(rowDot)rowDot.style.background='#9333ea';
  const row=document.getElementById('rowZona'+k);if(row)row.style.background='#faf5ff';
});
calcTotal();
</script>

@endsection