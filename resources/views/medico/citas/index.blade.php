@extends('layouts.medico')
@section('titulo', 'Mi Agenda')
@section('contenido')

{{-- FullCalendar + Alpine --}}
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
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
</style>

<div x-data="citasApp()" x-init="init()">

{{-- Header --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px;">
  <div>
    <h3 style="font-size:20px;font-weight:700;margin:0;">Mi Agenda</h3>
    <p style="font-size:12px;color:#94a3b8;margin:2px 0 0;">{{ now()->locale('es')->isoFormat('dddd D [de] MMMM, YYYY') }}</p>
  </div>
  <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
    <div style="display:flex;background:#f1f5f9;border-radius:8px;padding:3px;gap:2px;">
      <button @click="vistaActual='calendario'" :style="vistaActual==='calendario'?'background:white;box-shadow:0 1px 3px rgba(0,0,0,.1);':''" style="padding:5px 12px;border-radius:6px;font-size:12px;font-weight:600;border:none;cursor:pointer;color:#374151;">
        <i class="fa-solid fa-calendar-days" style="margin-right:4px;"></i>Calendario
      </button>
      <button @click="vistaActual='lista'" :style="vistaActual==='lista'?'background:white;box-shadow:0 1px 3px rgba(0,0,0,.1);':''" style="padding:5px 12px;border-radius:6px;font-size:12px;font-weight:600;border:none;cursor:pointer;color:#374151;">
        <i class="fa-solid fa-list" style="margin-right:4px;"></i>Lista
      </button>
    </div>
    <button @click="abrirModal()" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#9333ea;color:white;border:none;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;">
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
  <select x-model="vistaCalendario" @change="cambiarVista()" style="border:1.5px solid #e2e8f0;border-radius:8px;padding:7px 12px;font-size:13px;outline:none;width:130px;">
    <option value="dayGridMonth">Mes</option>
    <option value="timeGridWeek">Semana</option>
    <option value="timeGridDay">Día</option>
  </select>
  <button @click="limpiarFiltros()" style="padding:7px 14px;background:#f1f5f9;border:none;border-radius:8px;font-size:12px;font-weight:600;color:#64748b;cursor:pointer;white-space:nowrap;">
    <i class="fa-solid fa-rotate-left" style="margin-right:4px;"></i>Limpiar
  </button>
</div>


{{-- Filtros Lista --}}
<div x-show="vistaActual==='lista'" style="background:white;border-radius:12px;border:1px solid #e2e8f0;padding:12px 18px;margin-bottom:16px;display:flex;gap:10px;align-items:center;">
  <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;white-space:nowrap;">Buscar paciente</label>
  <div style="position:relative;flex:1;max-width:300px;">
    <i class="fa-solid fa-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:12px;"></i>
    <input type="text" x-model="filtroPaciente" @input="filtrarLista()" placeholder="Nombre del paciente..."
      style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:7px 10px 7px 30px;font-size:13px;outline:none;">
  </div>
  <button @click="limpiarFiltros()" style="padding:7px 14px;background:#f1f5f9;border:none;border-radius:8px;font-size:12px;font-weight:600;color:#64748b;cursor:pointer;white-space:nowrap;margin-top:0.5%">
    <i class="fa-solid fa-rotate-left" style="margin-right:4px;"></i>Limpiar
  </button>
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
  <div class="cita-row" data-paciente="{{ $cita->paciente->nombre }} {{ $cita->paciente->apellidos }}" style="padding:14px 18px;border-bottom:1px solid #f8fafc;display:flex;align-items:center;gap:14px;">
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
      <div style="font-size:13px;font-weight:600;color:#1e293b;">{{ $cita->paciente->nombre }} {{ $cita->paciente->apellidos }}</div>
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

{{-- MODAL NUEVA CITA --}}
<div x-show="modalOpen" x-cloak x-transition style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,.4);z-index:9999;display:flex;align-items:center;justify-content:center;padding:20px;" @click.self="modalOpen=false">
  <div style="background:white;border-radius:16px;width:520px;max-height:90vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,.2);margin:auto;">
    <div style="padding:20px 24px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
      <h4 style="font-size:15px;font-weight:700;margin:0;">Nueva Cita</h4>
      <button @click="modalOpen=false" style="background:none;border:none;font-size:18px;cursor:pointer;color:#94a3b8;">✕</button>
    </div>
    <form @submit.prevent="guardarCita()" style="padding:20px 24px;display:flex;flex-direction:column;gap:14px;">
      @csrf
      <div>
        <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Paciente *</label>
        <select x-model="form.paciente_id" required style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;">
          <option value="">Seleccionar paciente...</option>
          @foreach($pacientes as $p)
          <option value="{{ $p->id }}">{{ $p->nombre }} {{ $p->apellidos }}</option>
          @endforeach
        </select>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Fecha y hora *</label>
          <input type="datetime-local" x-model="form.fecha_hora" required
            min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;">
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Duración (min)</label>
          <select x-model="form.duracion_minutos" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;">
            <option value="15">15 min</option>
            <option value="30" selected>30 min</option>
            <option value="45">45 min</option>
            <option value="60">1 hora</option>
            <option value="90">1h 30min</option>
            <option value="120">2 horas</option>
          </select>
        </div>
      </div>
      <div>
        <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Tipo de tratamiento</label>
        <select x-model="form.tipo_tratamiento_id" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;">
          <option value="">Sin especificar</option>
          @foreach($tiposTratamiento as $t)
          <option value="{{ $t->id }}">{{ $t->nombre }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Motivo</label>
        <input type="text" x-model="form.motivo" placeholder="ej: Aplicación de toxina botulínica" maxlength="255"
          style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;">
      </div>
      <div>
        <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Notas adicionales</label>
        <textarea x-model="form.notas" rows="3" placeholder="Observaciones, indicaciones especiales..."
          style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;resize:vertical;font-family:'DM Sans',sans-serif;"></textarea>
      </div>
      <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:4px;">
        <button type="button" @click="modalOpen=false" style="padding:9px 18px;background:#f1f5f9;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;color:#374151;">Cancelar</button>
        <button type="submit" :disabled="guardando" style="padding:9px 20px;background:#9333ea;color:white;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:6px;">
          <span x-show="guardando"><i class="fa-solid fa-spinner fa-spin"></i></span>
          <span x-text="guardando ? 'Guardando...' : 'Agendar cita'"></span>
        </button>
      </div>
    </form>
  </div>
</div>

{{-- Toast --}}
<div x-show="toast.show" x-transition style="position:fixed;bottom:24px;right:24px;z-index:2000;background:#1e293b;color:white;padding:12px 20px;border-radius:10px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:10px;">
  <i class="fa-solid fa-check-circle" style="color:#10b981;"></i>
  <span x-text="toast.msg"></span>
</div>

</div>{{-- /x-data --}}

<script>
function citasApp() {
  return {
    vistaActual: 'calendario',
    modalOpen: false,
    guardando: false,
    mesLista: '{{ now()->format("Y-m") }}',
    calendar: null,
    toast: { show: false, msg: '' },
    filtroPaciente: '',
    fechaBuscar: '',
    vistaCalendario: 'dayGridMonth',
    form: {
      paciente_id: '',
      fecha_hora: '',
      duracion_minutos: '30',
      tipo_tratamiento_id: '',
      motivo: '',
      notas: '',
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
        events: function(info, successCallback, failureCallback) {
          const params = new URLSearchParams({
            start: info.startStr,
            end: info.endStr,
          });
          fetch('{{ route("medico.citas.index") }}?' + params.toString(), {
            headers: {
              'Accept': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
          })
          .then(r => r.json())
          .then(data => successCallback(data))
          .catch(e => failureCallback(e));
        },
        eventClick: (info) => { info.jsEvent.preventDefault(); window.location.href = info.event.url; },
        dateClick: (info) => {
          this.form.fecha_hora = info.dateStr + 'T09:00';
          this.modalOpen = true;
        },
        height: 'auto',
        eventTimeFormat: { hour: '2-digit', minute: '2-digit', meridiem: 'short' },
      });
      this.calendar.render();
    },

    abrirModal(fecha = null) {
      this.form = { paciente_id:'', fecha_hora: fecha ?? '', duracion_minutos:'30', tipo_tratamiento_id:'', motivo:'', notas:'' };
      this.modalOpen = true;
    },

    async guardarCita() {
      this.guardando = true;
      try {
        const res = await fetch('{{ route("medico.citas.store") }}', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
          body: JSON.stringify(this.form),
        });
        const data = await res.json();
        if (data.success) {
          this.modalOpen = false;
          if (this.calendar) this.calendar.refetchEvents();
          this.mostrarToast('¡Cita agendada correctamente!');
          setTimeout(() => window.location.reload(), 1200);
        }
      } catch (e) {
        alert('Error al guardar la cita.');
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
      if (this.calendar) {
        this.calendar.changeView(this.vistaCalendario);
      }
    },

    filtrarLista() {
      const q = this.filtroPaciente.toLowerCase();
      document.querySelectorAll('.cita-row').forEach(row => {
        const nombre = row.dataset.paciente.toLowerCase();
        row.style.display = nombre.includes(q) ? '' : 'none';
      });
    },

    limpiarFiltros() {
      this.filtroPaciente = '';
      this.fechaBuscar = '';
      this.vistaCalendario = 'dayGridMonth';
      if (this.calendar) this.calendar.changeView('dayGridMonth');
      document.querySelectorAll('.cita-row').forEach(r => r.style.display = '');
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