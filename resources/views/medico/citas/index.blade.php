@extends('layouts.medico')
@section('titulo', 'Mi Agenda')
@section('contenido')

{{-- FullCalendar --}}
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/es.global.min.js'></script>

<style>
.fc .fc-toolbar-title { font-size: 16px !important; font-weight: 700; }
.fc .fc-button { background: #9333ea !important; border-color: #9333ea !important; font-size: 12px !important; }
.fc .fc-button:hover { background: #7e22ce !important; }
.fc .fc-button-active { background: #6b21a8 !important; }
.fc-event { border-radius: 5px !important; padding: 2px 5px !important; font-size: 11px !important; cursor: pointer; }
.fc-daygrid-day-number { font-size: 12px; color: #64748b; }
.fc-col-header-cell-cushion { font-size: 12px; font-weight: 700; color: #374151; text-decoration: none !important; }
.fc-daygrid-day.fc-day-today { background: #faf5ff !important; }
[x-cloak] { display: none !important; }

/* Slot buttons */
.slot-btn-libre {
    padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;
    background:#f0fdf4;color:#16a34a;border:1.5px solid #bbf7d0;
    cursor:pointer;transition:all .15s;
}
.slot-btn-libre:hover { background:#dcfce7; }
.slot-btn-libre.selected {
    background:#16a34a !important;color:white !important;
    border-color:#16a34a !important;
    box-shadow:0 3px 10px rgba(22,163,74,.25);
    transform:scale(1.05);
}
.slot-btn-ocupado {
    padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;
    background:#f8fafc;color:#cbd5e1;border:1.5px solid #e2e8f0;
    cursor:not-allowed;text-decoration:line-through;
}

.cita-row-hidden { display: none !important; }

/* Botón Hoy */
.btn-hoy {
    padding:7px 16px;border:none;border-radius:8px;
    font-size:12px;font-weight:600;cursor:pointer;white-space:nowrap;
    display:inline-flex;align-items:center;gap:5px;
    background:#f3e8ff;color:#9333ea;
    transition:background .15s,color .15s;
}
.btn-hoy:hover { background:#ede9fe; }
.btn-hoy.activo { background:#9333ea;color:white; }
</style>

<div x-data="citasApp()" x-init="init()">

{{-- Header --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px;">
  <div>
    <h3 style="font-size:20px;font-weight:700;margin:0;">Mi Agenda</h3>
    <p style="font-size:12px;color:#94a3b8;margin:2px 0 0;">{{ now()->locale('es')->isoFormat('dddd D [de] MMMM, YYYY') }}</p>
  </div>
  <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
    <div style="display:flex;background:#ede9fe;border-radius:20px;padding:4px;gap:2px;border:1.5px solid #ddd6fe;">
      <button @click="vistaActual='calendario'"
        :style="vistaActual==='calendario'
          ? 'background:#9333ea;color:white;box-shadow:0 2px 8px rgba(147,51,234,.3);border-radius:20px;'
          : 'background:transparent;color:#7c3aed;border-radius:20px;'"
        style="display:inline-flex;align-items:center;padding:6px 14px;border-radius:7px;font-size:12px;font-weight:600;border:none;cursor:pointer;transition:all .18s;white-space:nowrap;">
        <i class="fa-solid fa-calendar-days" style="margin-right:6px;font-size:11px;"></i>Calendario
      </button>
      <button @click="vistaActual='lista'"
        :style="vistaActual==='lista'
          ? 'background:#9333ea;color:white;box-shadow:0 2px 8px rgba(147,51,234,.3);border-radius:20px;'
          : 'background:transparent;color:#7c3aed;border-radius:20px;'"
        style="display:inline-flex;align-items:center;padding:6px 14px;border-radius:7px;font-size:12px;font-weight:600;border:none;cursor:pointer;transition:all .18s;white-space:nowrap;">
        <i class="fa-solid fa-list" style="margin-right:6px;font-size:11px;"></i>Lista
      </button>
    </div>
    <button @click="abrirModal()"
      style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#9333ea;color:white;border:none;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;"
      onmouseover="this.style.background='#7c3aed'" onmouseout="this.style.background='#9333ea'">
      <i class="fa-solid fa-plus"></i> Nueva cita
    </button>
  </div>
</div>

{{-- Filtros Calendario --}}
<div x-show="vistaActual==='calendario'" style="background:white;border-radius:12px;border:1px solid #e2e8f0;padding:12px 18px;margin-bottom:16px;display:flex;gap:10px;align-items:center;">
  <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;white-space:nowrap;">Ir a fecha</label>
  <input type="date" x-model="fechaBuscar" @change="irAFecha()"
    style="border:1.5px solid #e2e8f0;border-radius:8px;padding:7px 12px;font-size:13px;outline:none;width:160px;">
  <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;white-space:nowrap;">Vista</label>
  <select x-model="vistaCalendario" @change="cambiarVista()"
    style="border:1.5px solid #e2e8f0;border-radius:8px;padding:7px 12px;font-size:13px;outline:none;width:130px;">
    <option value="dayGridMonth">Mes</option>
    <option value="timeGridWeek">Semana</option>
    <option value="timeGridDay">Día</option>
  </select>
  <button @click="limpiarFiltros()"
    style="padding:7px 14px;background:#f1f5f9;border:none;border-radius:8px;font-size:12px;font-weight:600;color:#64748b;cursor:pointer;white-space:nowrap;">
    <i class="fa-solid fa-rotate-left" style="margin-right:4px;"></i>Limpiar
  </button>
</div>

{{-- Filtros Lista --}}
<div x-show="vistaActual==='lista'" style="background:white;border-radius:12px;border:1px solid #e2e8f0;padding:12px 18px;margin-bottom:16px;">

  {{-- Fila 1: buscador + botón Hoy --}}
  <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
    <div style="position:relative;flex:1;max-width:320px;">
      <i class="fa-solid fa-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:12px;"></i>
      <input type="text" x-model="filtroPaciente" @input="filtrarLista()" placeholder="Buscar paciente..."
        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:7px 10px 7px 30px;font-size:13px;outline:none;box-sizing:border-box;">
    </div>
    <button @click="filtrarHoy()"
      :class="filtrando === 'hoy' ? 'btn-hoy activo' : 'btn-hoy'">
      <i class="fa-solid fa-calendar-day" style="margin-right:4px;"></i>Hoy
    </button>
  </div>

  {{-- Fila 2: botón Limpiar con margen superior para separarlo --}}
  <div style="padding-top:6px;border-top:1px solid #f1f5f9;">
    <button @click="limpiarFiltros()"
      style="padding:6px 14px;background:#f1f5f9;border:none;border-radius:8px;font-size:12px;font-weight:600;color:#64748b;cursor:pointer;white-space:nowrap;display:inline-flex;align-items:center;gap:5px;"
      onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
      <i class="fa-solid fa-rotate-left"></i> Limpiar
    </button>
  </div>

</div>

{{-- Estadísticas --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:18px;">
  <div style="background:white;border-radius:12px;border:1px solid #e2e8f0;padding:14px 18px;display:flex;align-items:center;gap:12px;">
    <div style="width:40px;height:40px;border-radius:10px;background:#fef3c7;display:flex;align-items:center;justify-content:center;">
      <i class="fa-solid fa-calendar-day" style="color:#d97706;font-size:16px;"></i>
    </div>
    <div>
      <div style="font-size:22px;font-weight:700;color:#1e293b;">{{ $estadisticas['hoy'] }}</div>
      <div style="font-size:11px;color:#94a3b8;">Citas hoy</div>
    </div>
  </div>
  <div style="background:white;border-radius:12px;border:1px solid #e2e8f0;padding:14px 18px;display:flex;align-items:center;gap:12px;">
    <div style="width:40px;height:40px;border-radius:10px;background:#ede9fe;display:flex;align-items:center;justify-content:center;">
      <i class="fa-solid fa-calendar-week" style="color:#7c3aed;font-size:16px;"></i>
    </div>
    <div>
      <div style="font-size:22px;font-weight:700;color:#1e293b;">{{ $estadisticas['semana'] }}</div>
      <div style="font-size:11px;color:#94a3b8;">Esta semana</div>
    </div>
  </div>
  <div style="background:white;border-radius:12px;border:1px solid #e2e8f0;padding:14px 18px;display:flex;align-items:center;gap:12px;">
    <div style="width:40px;height:40px;border-radius:10px;background:#fce7f3;display:flex;align-items:center;justify-content:center;">
      <i class="fa-solid fa-clock" style="color:#be185d;font-size:16px;"></i>
    </div>
    <div>
      <div style="font-size:22px;font-weight:700;color:#1e293b;">{{ $estadisticas['pendientes'] }}</div>
      <div style="font-size:11px;color:#94a3b8;">Pendientes</div>
    </div>
  </div>
</div>

{{-- Calendario --}}
<div x-show="vistaActual==='calendario'" style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
  <div id="calendar"></div>
</div>

{{-- Lista --}}
<div x-show="vistaActual==='lista'" style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
  <div style="padding:14px 18px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
    <span style="font-size:13px;font-weight:700;color:#374151;">Citas del mes</span>
    <input type="month" x-model="mesLista" style="border:1.5px solid #e2e8f0;border-radius:7px;padding:5px 10px;font-size:12px;outline:none;">
  </div>
  @forelse($citas as $cita)
  <div class="cita-row"
    data-paciente="{{ ($cita->paciente?->nombre ?? $cita->nombre_visitante ?? 'Visitante') }} {{ $cita->paciente?->apellidos ?? '' }}"
    data-fecha="{{ $cita->fecha_hora->format('Y-m-d') }}"
    style="padding:14px 18px;border-bottom:1px solid #f8fafc;display:flex;align-items:center;gap:14px;flex-wrap:nowrap;">
    <div style="width:44px;text-align:center;flex-shrink:0;">
      <div style="font-size:18px;font-weight:700;color:#1e293b;">{{ $cita->fecha_hora->format('d') }}</div>
      <div style="font-size:10px;color:#94a3b8;text-transform:uppercase;">{{ $cita->fecha_hora->locale('es')->isoFormat('MMM') }}</div>
    </div>
    <div style="width:3px;height:40px;border-radius:3px;flex-shrink:0;background:
      @if($cita->estado==='pendiente') #f59e0b
      @elseif($cita->estado==='confirmada') #10b981
      @elseif($cita->estado==='en_curso') #6366f1
      @elseif($cita->estado==='completada') #64748b
      @else #ef4444 @endif;"></div>
    <div style="flex:1;min-width:0;">
      <div style="font-size:13px;font-weight:600;color:#1e293b;">{{ ($cita->paciente?->nombre ?? $cita->nombre_visitante ?? 'Visitante') }} {{ $cita->paciente?->apellidos ?? '' }}</div>
      <div style="font-size:11px;color:#94a3b8;">{{ $cita->fecha_hora->format('h:i A') }} · {{ $cita->duracion_minutos }} min @if($cita->motivo)· {{ $cita->motivo }}@endif</div>
    </div>
    <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:20px;
      background:{{ match($cita->estado) { 'pendiente'=>'#fef3c7','confirmada'=>'#d1fae5','en_curso'=>'#ede9fe','completada'=>'#f1f5f9',default=>'#fee2e2' } }};
      color:{{ match($cita->estado) { 'pendiente'=>'#d97706','confirmada'=>'#059669','en_curso'=>'#7c3aed','completada'=>'#64748b',default=>'#dc2626' } }};">
      {{ ucfirst($cita->estado) }}
    </span>
    <div style="display:flex;gap:6px;">
      <a href="{{ route('medico.citas.show', $cita) }}" style="padding:5px 10px;background:#f1f5f9;border-radius:6px;font-size:11px;font-weight:600;color:#374151;text-decoration:none;">Ver</a>
      <button onclick="enviarWhatsApp({{ $cita->id }})" style="padding:5px 10px;background:#dcfce7;border-radius:6px;font-size:11px;font-weight:600;color:#059669;border:none;cursor:pointer;" title="WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
      </button>
    </div>
  </div>
  @empty
  <div style="padding:40px;text-align:center;color:#94a3b8;">
    <i class="fa-solid fa-calendar-xmark" style="font-size:32px;margin-bottom:10px;display:block;"></i>
    No hay citas este mes
  </div>
  @endforelse
</div>

{{-- ═══════════ MODAL NUEVA CITA ═══════════ --}}
<div x-show="modalOpen" x-cloak x-transition
     style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,.45);z-index:9999;display:flex;align-items:center;justify-content:center;padding:20px;"
     @click.self="modalOpen=false">
  <div style="background:white;border-radius:16px;width:560px;max-height:90vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,.2);margin:auto;">

    {{-- Header modal --}}
    <div style="padding:18px 24px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;background:white;z-index:10;border-radius:16px 16px 0 0;">
      <div style="display:flex;align-items:center;gap:10px;">
        <div style="width:32px;height:32px;border-radius:8px;background:#fef3c7;display:flex;align-items:center;justify-content:center;">
          <i class="fa-solid fa-calendar-plus" style="color:#d97706;font-size:13px;"></i>
        </div>
        <div>
          <h4 style="font-size:14px;font-weight:700;margin:0;color:#0f172a;">Nueva Cita</h4>
          <p style="font-size:11px;color:#94a3b8;margin:0;" x-text="slots.horarioLabel ? slots.horarioLabel : 'Selecciona fecha para ver disponibilidad'"></p>
        </div>
      </div>
      <button @click="modalOpen=false"
        style="background:#f1f5f9;border:none;width:28px;height:28px;border-radius:7px;cursor:pointer;color:#64748b;font-size:14px;display:flex;align-items:center;justify-content:center;">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <form @submit.prevent="guardarCita()" style="padding:20px 24px;display:flex;flex-direction:column;gap:16px;">

      {{-- Paciente --}}
      <div>
        <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:5px;">Paciente *</label>
        <select x-model="form.paciente_id" required
          style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;background:white;"
          @focus="$el.style.borderColor='#9333ea';$el.style.boxShadow='0 0 0 3px rgba(147,51,234,.08)'"
          @blur="$el.style.borderColor='#e2e8f0';$el.style.boxShadow='none'">
          <option value="">Seleccionar paciente...</option>
          @foreach($pacientes as $p)
          <option value="{{ $p->id }}">{{ $p->nombre }} {{ $p->apellidos }}</option>
          @endforeach
        </select>
      </div>

      {{-- Fecha + Duración --}}
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:5px;">Fecha *</label>
          <input type="date" x-model="form.fecha"
            :min="hoy"
            @change="cargarSlots()"
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;"
            @focus="$el.style.borderColor='#9333ea';$el.style.boxShadow='0 0 0 3px rgba(147,51,234,.08)'"
            @blur="$el.style.borderColor='#e2e8f0';$el.style.boxShadow='none'">
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:5px;">Duración</label>
          <select x-model="form.duracion_minutos" @change="form.fecha && cargarSlots()"
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;background:white;"
            @focus="$el.style.borderColor='#9333ea'" @blur="$el.style.borderColor='#e2e8f0'">
            <option value="15">15 min</option>
            <option value="30">30 min</option>
            <option value="45">45 min</option>
            <option value="60">1 hora</option>
            <option value="90">1h 30min</option>
            <option value="120">2 horas</option>
          </select>
        </div>
      </div>

      {{-- Selector de slots --}}
      <div>
        <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:8px;">Hora disponible *</label>

        <div x-show="slots.estado === 'inicial'"
          style="padding:18px;background:#f8fafc;border:1.5px dashed #e2e8f0;border-radius:10px;text-align:center;color:#94a3b8;font-size:12px;">
          <i class="fa-solid fa-calendar-days" style="font-size:1.4rem;margin-bottom:6px;display:block;color:#cbd5e1;"></i>
          Selecciona una fecha para ver los horarios disponibles
        </div>

        <div x-show="slots.estado === 'cargando'"
          style="padding:18px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:10px;text-align:center;color:#94a3b8;font-size:12px;">
          <i class="fa-solid fa-circle-notch fa-spin" style="margin-right:6px;color:#9333ea;"></i> Cargando horarios...
        </div>

        <div x-show="slots.estado === 'noDia'"
          style="padding:14px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:10px;text-align:center;color:#991b1b;font-size:12px;">
          <i class="fa-solid fa-ban" style="margin-right:5px;"></i>
          <span x-text="slots.mensajeError"></span>
        </div>

        <div x-show="slots.estado === 'error'"
          style="padding:14px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:10px;text-align:center;color:#991b1b;font-size:12px;">
          <i class="fa-solid fa-triangle-exclamation" style="margin-right:5px;"></i>
          Error al cargar horarios. Intenta de nuevo.
        </div>

        <div x-show="slots.estado === 'ok'">
          <div style="display:flex;align-items:center;margin-bottom:10px;">
            <span style="font-size:11px;color:#64748b;">
              <i class="fa-solid fa-circle-check" style="color:#16a34a;margin-right:4px;"></i>
              <span x-text="slots.libres + ' disponibles'"></span>
              <span style="color:#cbd5e1;margin:0 6px;">·</span>
              <i class="fa-solid fa-circle-xmark" style="color:#ef4444;margin-right:4px;"></i>
              <span x-text="slots.ocupados + ' ocupados'"></span>
            </span>
          </div>
          <div style="display:flex;flex-wrap:wrap;gap:8px;">
            <template x-for="slot in slots.lista" :key="slot.hora">
              <button type="button"
                :disabled="!slot.libre"
                :class="!slot.libre ? 'slot-btn-ocupado' : (form.hora === slot.hora ? 'slot-btn-libre selected' : 'slot-btn-libre')"
                :title="!slot.libre ? 'Hora ocupada' : ''"
                @click="slot.libre && seleccionarSlot(slot.hora)"
                x-text="slot.hora">
              </button>
            </template>
          </div>
          <div x-show="slots.libres === 0"
            style="margin-top:10px;padding:10px;background:#fef9c3;border:1px solid #fde68a;border-radius:8px;font-size:12px;color:#854d0e;text-align:center;">
            <i class="fa-solid fa-calendar-plus" style="margin-right:5px;"></i>
            Todos los slots están ocupados. Prueba con otra fecha.
          </div>
        </div>

        <div x-show="form.hora" x-transition
          style="margin-top:10px;padding:8px 12px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:8px;display:flex;align-items:center;gap:8px;">
          <i class="fa-solid fa-circle-check" style="color:#16a34a;font-size:13px;"></i>
          <span style="font-size:12px;font-weight:600;color:#15803d;">
            Hora seleccionada: <span x-text="form.hora"></span>
          </span>
          <button type="button" @click="form.hora=''"
            style="margin-left:auto;background:none;border:none;color:#94a3b8;cursor:pointer;font-size:12px;">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
      </div>

      {{-- Tipo de tratamiento --}}
      <div>
        <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:5px;">Tipo de tratamiento</label>
        <select x-model="form.tipo_tratamiento_id"
          style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;background:white;"
          @focus="$el.style.borderColor='#9333ea'" @blur="$el.style.borderColor='#e2e8f0'">
          <option value="">Sin especificar</option>
          @foreach($tiposTratamiento as $t)
          <option value="{{ $t->id }}">{{ $t->nombre }}</option>
          @endforeach
        </select>
      </div>

      {{-- Motivo --}}
      <div>
        <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:5px;">Motivo</label>
        <input type="text" x-model="form.motivo" placeholder="ej: Aplicación de toxina botulínica" maxlength="255"
          style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;"
          @focus="$el.style.borderColor='#9333ea';$el.style.boxShadow='0 0 0 3px rgba(147,51,234,.08)'"
          @blur="$el.style.borderColor='#e2e8f0';$el.style.boxShadow='none'">
      </div>

      {{-- Notas --}}
      <div>
        <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:5px;">Notas adicionales</label>
        <textarea x-model="form.notas" rows="2" placeholder="Observaciones, indicaciones especiales..."
          style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;resize:vertical;font-family:'DM Sans',sans-serif;"
          @focus="$el.style.borderColor='#9333ea';$el.style.boxShadow='0 0 0 3px rgba(147,51,234,.08)'"
          @blur="$el.style.borderColor='#e2e8f0';$el.style.boxShadow='none'"></textarea>
      </div>

      {{-- Error --}}
      <div x-show="errorMsg" x-transition
        style="padding:10px 14px;background:#fef2f2;border:1px solid #fecaca;border-radius:8px;font-size:12px;color:#991b1b;display:flex;align-items:center;gap:8px;">
        <i class="fa-solid fa-circle-exclamation"></i>
        <span x-text="errorMsg"></span>
      </div>

      {{-- Botones --}}
      <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:4px;border-top:1px solid #f1f5f9;margin-top:4px;">
        <button type="button" @click="modalOpen=false"
          style="padding:9px 18px;background:#f1f5f9;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;color:#374151;"
          onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
          Cancelar
        </button>
        <button type="submit" :disabled="guardando || !form.hora"
          style="padding:9px 22px;background:#9333ea;color:white;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;"
          :style="(guardando || !form.hora) ? 'opacity:0.45;cursor:not-allowed;' : ''"
          onmouseover="if(!this.disabled)this.style.background='#7c3aed'"
          onmouseout="if(!this.disabled)this.style.background='#9333ea'">
          <span x-show="guardando" style="margin-right:4px;"><i class="fa-solid fa-spinner fa-spin"></i></span>
          <span x-text="guardando ? 'Guardando...' : 'Agendar cita'"></span>
        </button>
      </div>

    </form>
  </div>
</div>

{{-- Toast --}}
<div x-show="toast.show" x-transition
     style="position:fixed;bottom:24px;right:24px;z-index:10000;background:#1e293b;color:white;padding:12px 20px;border-radius:10px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:10px;box-shadow:0 8px 24px rgba(0,0,0,.2);">
  <i class="fa-solid fa-check-circle" style="color:#10b981;"></i>
  <span x-text="toast.msg"></span>
</div>

</div>{{-- /x-data --}}

<script>
const SLOTS_URL = '{{ route("medico.configuraciones.slots") }}';

function citasApp() {
  return {
    vistaActual: 'calendario',
    modalOpen: false,
    guardando: false,
    errorMsg: '',
    mesLista: '{{ now()->format("Y-m") }}',
    calendar: null,
    toast: { show: false, msg: '' },
    filtroPaciente: '',
    fechaBuscar: '',
    filtrando: '',
    vistaCalendario: 'dayGridMonth',
    hoy: new Date().toISOString().split('T')[0],

    form: {
      paciente_id: '',
      fecha: '',
      hora: '',
      duracion_minutos: '{{ auth()->user()->medico->duracion_cita ?? 30 }}',
      tipo_tratamiento_id: '',
      motivo: '',
      notas: '',
    },

    slots: {
      estado: 'inicial',
      lista: [],
      libres: 0,
      ocupados: 0,
      horarioLabel: '',
      mensajeError: '',
    },

    init() {
      this.$nextTick(() => this.initCalendar());
    },

    initCalendar() {
      const el = document.getElementById('calendar');
      if (!el) return;
      this.calendar = new FullCalendar.Calendar(el, {
        locale: 'es',
        initialView: 'dayGridMonth',
        headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay' },
        events: (info, success, failure) => {
          const params = new URLSearchParams({ start: info.startStr, end: info.endStr });
          fetch('{{ route("medico.citas.index") }}?' + params, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
          })
          .then(r => r.json())
          .then(success)
          .catch(failure);
        },
        eventClick: (info) => { info.jsEvent.preventDefault(); window.location.href = info.event.url; },
        dateClick: (info) => { this.abrirModal(info.dateStr); },
        height: 'auto',
        eventTimeFormat: { hour: '2-digit', minute: '2-digit', meridiem: 'short' },
      });
      this.calendar.render();
    },

    abrirModal(fecha = null) {
      this.errorMsg = '';
      this.form = {
        paciente_id: '',
        fecha: fecha ?? '',
        hora: '',
        duracion_minutos: '{{ auth()->user()->medico->duracion_cita ?? 30 }}',
        tipo_tratamiento_id: '',
        motivo: '',
        notas: '',
      };
      this.slots = { estado: 'inicial', lista: [], libres: 0, ocupados: 0, horarioLabel: '', mensajeError: '' };
      this.modalOpen = true;
      if (fecha) {
        this.$nextTick(() => this.cargarSlots());
      }
    },

    async cargarSlots() {
      if (!this.form.fecha) return;
      this.form.hora = '';
      this.slots.estado = 'cargando';
      this.slots.horarioLabel = '';
      try {
        const res = await fetch(`${SLOTS_URL}?fecha=${this.form.fecha}&duracion=${this.form.duracion_minutos}`, {
          headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        const data = await res.json();
        if (!data.slots || data.slots.length === 0) {
          this.slots.estado       = 'noDia';
          this.slots.mensajeError = data.mensaje || 'El médico no trabaja ese día';
          return;
        }
        this.slots.lista        = data.slots;
        this.slots.libres       = data.slots.filter(s => s.libre).length;
        this.slots.ocupados     = data.slots.filter(s => !s.libre).length;
        this.slots.horarioLabel = `${data.dia}  ·  ${data.horario}`;
        this.slots.estado       = 'ok';
      } catch (e) {
        this.slots.estado = 'error';
      }
    },

    seleccionarSlot(hora) {
      this.form.hora = hora;
      this.errorMsg  = '';
    },

    async guardarCita() {
      this.errorMsg = '';
      if (!this.form.paciente_id) { this.errorMsg = 'Selecciona un paciente.'; return; }
      if (!this.form.fecha)       { this.errorMsg = 'Selecciona una fecha.'; return; }
      if (!this.form.hora)        { this.errorMsg = 'Selecciona un horario disponible.'; return; }
      if (this.guardando) return;
      this.guardando = true;
      try {
        const res = await fetch('{{ route("medico.citas.store") }}', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
          body: JSON.stringify({
            paciente_id:         this.form.paciente_id,
            fecha_hora:          this.form.fecha + ' ' + this.form.hora + ':00',
            duracion_minutos:    this.form.duracion_minutos,
            tipo_tratamiento_id: this.form.tipo_tratamiento_id,
            motivo:              this.form.motivo,
            notas:               this.form.notas,
          }),
        });
        const data = await res.json();
        if (data.success) {
          this.modalOpen = false;
          if (this.calendar) this.calendar.refetchEvents();
          this.mostrarToast('¡Cita agendada correctamente!');
          setTimeout(() => window.location.reload(), 1200);
        } else {
          this.errorMsg = data.message || 'Error al guardar. Verifica los datos.';
        }
      } catch (e) {
        this.errorMsg = 'Error de conexión. Intenta de nuevo.';
      } finally {
        this.guardando = false;
      }
    },

    mostrarToast(msg) {
      this.toast = { show: true, msg };
      setTimeout(() => this.toast.show = false, 3000);
    },

    irAFecha() {
      if (this.calendar && this.fechaBuscar) {
        this.calendar.gotoDate(this.fechaBuscar);
        this.calendar.changeView('timeGridWeek');
        this.vistaCalendario = 'timeGridWeek';
        this.vistaActual = 'calendario';
      }
    },

    cambiarVista() {
      if (this.calendar) this.calendar.changeView(this.vistaCalendario);
    },

    filtrarLista() {
      if (this.filtrando === 'hoy') return;
      const q = this.filtroPaciente.toLowerCase();
      document.querySelectorAll('.cita-row').forEach(row => {
        const coincide = row.dataset.paciente.toLowerCase().includes(q);
        row.classList.toggle('cita-row-hidden', !coincide);
      });
    },

    filtrarHoy() {
      this.filtrando = 'hoy';
      this.filtroPaciente = '';
      const hoy = new Date().toISOString().split('T')[0];
      document.querySelectorAll('.cita-row').forEach(row => {
        row.classList.toggle('cita-row-hidden', row.dataset.fecha !== hoy);
      });
    },

    limpiarFiltros() {
      this.filtroPaciente = '';
      this.filtrando = '';
      // Solo resetear calendarios si estamos en esa vista
      if (this.vistaActual === 'calendario') {
        this.fechaBuscar = '';
        this.vistaCalendario = 'dayGridMonth';
        if (this.calendar) this.calendar.changeView('dayGridMonth');
      }
      document.querySelectorAll('.cita-row').forEach(r => r.classList.remove('cita-row-hidden'));
    },
  }
}

async function enviarWhatsApp(citaId) {
  const res = await fetch(`/medico/citas/${citaId}/whatsapp`);
  const data = await res.json();
  if (data.url) window.open(data.url, '_blank');
}
</script>

@endsection