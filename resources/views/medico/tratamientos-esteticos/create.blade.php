@extends('layouts.medico')
@section('titulo', 'Nueva Historia Clínica Estética')
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
    <h3 class="font-serif" style="font-size:21px;">Nueva Historia Clínica Estética</h3>
</div>

@if($errors->any())
<div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px;">
    <i class="fa-solid fa-circle-xmark" style="margin-right:6px;"></i>{{ $errors->first() }}
</div>
@endif

<form action="{{ route('medico.tratamientos-esteticos.store') }}" method="POST" id="formHCE">
@csrf
<input type="hidden" name="puntos_libres" id="puntosLibresInput" value="[]">

<div style="display:grid;grid-template-columns:1fr 320px;gap:18px;">

{{-- COLUMNA PRINCIPAL --}}
<div style="display:flex;flex-direction:column;gap:14px;">

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
        <input type="date" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
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
          <span class="trat-icon">�</span>
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
            <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Simetr��a facial</label>
            <select name="simetria" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
              <option>Alineaciíón adecuada</option><option>Leve asimetría</option><option>Asimetría moderada</option>
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

  {{-- PRODUCTO --}}
  <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
    <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;gap:7px;">
      <span style="width:26px;height:26px;border-radius:7px;background:#f3e8ff;color:#9333ea;display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-box" style="font-size:11px;"></i></span>
      Producto Utilizado
    </h4>
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

  {{-- EVALUACIÓN --}}
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
<div style="display:flex;flex-direction:column;gap:14px;">

  {{-- ACCIONES --}}
  <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
    <button type="submit" style="width:100%;padding:11px;border-radius:9px;font-size:14px;font-weight:600;background:#9333ea;color:white;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;margin-bottom:8px;">
      <i class="fa-solid fa-floppy-disk"></i> Guardar historia clínica
    </button>
    <a href="{{ route('medico.tratamientos-esteticos.index') }}"
      style="display:flex;align-items:center;justify-content:center;padding:9px;border-radius:9px;font-size:13px;font-weight:600;background:white;color:#64748b;border:1.5px solid #e2e8f0;text-decoration:none;">
      Cancelar
    </a>
  </div>

  {{-- MAPA FACIAL --}}
  <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:16px;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
      <span style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Mapa de zonas</span>
      <div style="display:flex;gap:6px;">
        <button type="button" id="btnMarcar" onclick="setMode('marcar')"
          style="padding:3px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#9333ea;color:white;border:none;cursor:pointer;">✚ Punto</button>
        <button type="button" id="btnVer" onclick="setMode('ver')"
          style="padding:3px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#f1f5f9;color:#64748b;border:none;cursor:pointer;">� Ver</button>
      </div>
    </div>

    <svg id="faceSvg" viewBox="0 0 200 290" width="100%" style="display:block;cursor:crosshair;max-width:260px;margin:0 auto;" xmlns="http://www.w3.org/2000/svg">
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
      {{-- Zonas predefinidas --}}
      @php $zonasDefSvg=['F'=>[100,74],'GL'=>[100,100],'PGI'=>[52,122],'PGD'=>[148,122],'BL'=>[100,140],'L'=>[100,172],'MI'=>[44,158],'MD'=>[156,158],'C'=>[100,228]]; @endphp
      @foreach($zonasDefSvg as $key=>$coords)
      <g style="cursor:pointer;" onclick="toggleZonaPred('{{ $key }}',this)" id="zpG{{ $key }}">
        <circle cx="{{ $coords[0] }}" cy="{{ $coords[1] }}" r="7" fill="#9333ea" opacity="0.35" id="dot{{ $key }}"/>
        <text x="{{ $coords[0] }}" y="{{ $coords[1]+4 }}" text-anchor="middle" font-size="7" fill="white" font-weight="700">{{ $key }}</text>
      </g>
      @endforeach
      <g id="puntosLibresSvg"></g>
    </svg>

    {{-- Config punto --}}
    <div style="background:#f8fafc;border-radius:9px;padding:10px;margin-top:10px;">
      <div style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Color del punto</div>
      <div style="display:flex;gap:6px;margin-bottom:8px;">
        @foreach(['#dc2626'=>'Rojo','#059669'=>'Verde','#2563eb'=>'Azul','#d97706'=>'Naranja','#7c3aed'=>'Morado','#be185d'=>'Rosa'] as $color=>$nombre)
        <div class="color-dot {{ $loop->first?'sel':'' }}" style="background:{{ $color }};width:20px;height:20px;border-radius:50%;cursor:pointer;border:2px solid {{ $loop->first?'#1e293b':'transparent' }};transition:all .12s;" data-color="{{ $color }}" onclick="selColor(this)" title="{{ $nombre }}"></div>
        @endforeach
      </div>
      <div style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:4px;">Etiqueta (m��x 5 chars)</div>
      <input type="text" id="labelPunto" maxlength="5" placeholder="ej: 2U"
        style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:6px 10px;font-size:12px;font-family:'DM Sans',sans-serif;outline:none;">
    </div>

    {{-- Lista puntos --}}
    <div id="puntosListaWrap" style="display:none;margin-top:8px;">
      <div style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Puntos agregados</div>
      <div id="puntosLista"></div>
    </div>
  </div>

  {{-- DOSIFICACIáÓN --}}
  <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
    <div style="padding:12px 16px;border-bottom:1px solid #e2e8f0;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">
      Dosificación por zona
    </div>
    <div style="padding:12px 14px;">
      @php $zonasDef=['F'=>['label'=>'Frente','unidad'=>'U'],'GL'=>['label'=>'Glabela','unidad'=>'U'],'PGI'=>['label'=>'P. Gallo izq.','unidad'=>'U'],'PGD'=>['label'=>'P. Gallo der.','unidad'=>'U'],'BL'=>['label'=>'Bunny lines','unidad'=>'U'],'L'=>['label'=>'Labios','unidad'=>'ml'],'MI'=>['label'=>'Masetero izq.','unidad'=>'U'],'MD'=>['label'=>'Masetero der.','unidad'=>'U'],'C'=>['label'=>'Cuello','unidad'=>'U']]; @endphp
      @foreach($zonasDef as $key=>$zona)
      <div style="display:grid;grid-template-columns:1fr 60px 28px;gap:6px;align-items:center;padding:5px 0;border-bottom:1px solid #f8fafc;" id="rowZona{{ $key }}">
        <div style="display:flex;align-items:center;gap:6px;">
          <div style="width:7px;height:7px;border-radius:50%;background:#e2e8f0;" id="dotRowZ{{ $key }}"></div>
          <span style="font-size:12px;font-weight:600;color:#374151;">{{ $zona['label'] }}</span>
        </div>
        <input type="number" name="zonas_predefinidas[{{ $key }}][cantidad]" id="cantZ{{ $key }}" value="0" min="0" step="0.5"
          style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:4px 8px;font-size:12px;font-family:'DM Sans',sans-serif;outline:none;text-align:center;">
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

</div>{{-- /col derecha --}}
</div>{{-- /grid --}}
</form>

<script>
const zonasState={F:true,GL:true,PGI:true,PGD:true,BL:false,L:false,MI:false,MD:false,C:false};
let puntosLibres=[],pidCounter=0,currentColor='#dc2626',currentMode='marcar';

function selTrat(el){
  document.querySelectorAll('.trat-btn').forEach(b=>b.classList.remove('sel'));
  el.classList.add('sel');
  document.getElementById('tipoTratamientoId').value=el.dataset.id;
  document.getElementById('grupoInput').value=el.dataset.grupo;
  document.getElementById('tipoClave').value=el.dataset.clave;
  document.querySelectorAll('.trat-section').forEach(s=>s.classList.remove('visible'));
  const sec=document.getElementById('sec-'+el.dataset.clave);
  if(sec)sec.classList.add('visible');
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
  document.getElementById('faceSvg').style.cursor=mode==='marcar'?'crosshair':'default';
  document.getElementById('btnMarcar').style.background=mode==='marcar'?'#9333ea':'#f1f5f9';
  document.getElementById('btnMarcar').style.color=mode==='marcar'?'white':'#64748b';
  document.getElementById('btnVer').style.background=mode==='ver'?'#64748b':'#f1f5f9';
  document.getElementById('btnVer').style.color=mode==='ver'?'white':'#64748b';
}

function toggleZonaPred(key,g){
  if(currentMode!=='marcar')return;
  zonasState[key]=!zonasState[key];
  const dot=document.getElementById('dot'+key);
  const rowDot=document.getElementById('dotRowZ'+key);
  const row=document.getElementById('rowZona'+key);
  const activa=document.getElementById('activaZ'+key);
  if(zonasState[key]){
    dot.setAttribute('fill','#9333ea');dot.setAttribute('opacity','0.9');
    if(rowDot){rowDot.style.background='#9333ea';}
    if(row)row.style.background='#faf5ff';
    if(activa)activa.value='1';
  }else{
    dot.setAttribute('fill','#9333ea');dot.setAttribute('opacity','0.35');
    if(rowDot){rowDot.style.background='#e2e8f0';}
    if(row)row.style.background='';
    if(activa)activa.value='0';
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
  addPunto(x,y,currentColor,document.getElementById('labelPunto').value.trim());
});

function addPunto(x,y,color,label){
  const id='p'+(++pidCounter);
  puntosLibres.push({id,x,y,color,label});
  const g=document.createElementNS('http://www.w3.org/2000/svg','g');
  g.setAttribute('id','svgP'+id);g.style.cursor='pointer';
  const ring=document.createElementNS('http://www.w3.org/2000/svg','circle');
  ring.setAttribute('cx',x);ring.setAttribute('cy',y);ring.setAttribute('r','9');
  ring.setAttribute('fill',color);ring.setAttribute('opacity','0.2');g.appendChild(ring);
  const c=document.createElementNS('http://www.w3.org/2000/svg','circle');
  c.setAttribute('cx',x);c.setAttribute('cy',y);c.setAttribute('r','5.5');
  c.setAttribute('fill',color);c.setAttribute('stroke','white');c.setAttribute('stroke-width','1.2');g.appendChild(c);
  if(label){
    const t=document.createElementNS('http://www.w3.org/2000/svg','text');
    t.setAttribute('x',x+8);t.setAttribute('y',y-5);t.setAttribute('font-size','7');
    t.setAttribute('fill',color);t.setAttribute('font-weight','700');t.textContent=label;g.appendChild(t);
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
  document.getElementById('puntosLibresInput').value=JSON.stringify(puntosLibres.map(p=>({x:p.x,y:p.y,color:p.color,label:p.label})));
  const lista=document.getElementById('puntosLista');
  const wrap=document.getElementById('puntosListaWrap');
  lista.innerHTML='';
  if(!puntosLibres.length){wrap.style.display='none';return;}
  wrap.style.display='block';
  puntosLibres.forEach((p,i)=>{
    lista.innerHTML+=`<div style="display:flex;align-items:center;justify-content:space-between;padding:5px 8px;background:#f8fafc;border-radius:7px;margin-bottom:4px;font-size:12px;">
      <div style="display:flex;align-items:center;gap:6px;">
        <div style="width:8px;height:8px;border-radius:50%;background:${p.color};"></div>
        <span style="color:#374151;">Punto ${i+1}${p.label?' · '+p.label:''}</span>
      </div>
      <span style="cursor:pointer;color:#94a3b8;font-size:14px;" onclick="removePunto('${p.id}')">✕</span>
    </div>`;
  });
}

// Init: activar zonas default
['F','GL','PGI','PGD'].forEach(k=>{
  const activa=document.getElementById('activaZ'+k);
  if(activa)activa.value='1';
  const dot=document.getElementById('dot'+k);
  if(dot){dot.setAttribute('fill','#9333ea');dot.setAttribute('opacity','0.9');}
  const rowDot=document.getElementById('dotRowZ'+k);
  if(rowDot)rowDot.style.background='#9333ea';
  const row=document.getElementById('rowZona'+k);
  if(row)row.style.background='#faf5ff';
});
calcTotal();
</script>

@endsection
