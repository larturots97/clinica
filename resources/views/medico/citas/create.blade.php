@extends('layouts.medico')
@section('titulo', 'Nueva Cita')
@section('contenido')

<div style="padding:1.5rem 2rem; background:#f8fafc; min-height:100vh;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:1.5rem;">
        <a href="{{ route('medico.citas.index') }}" style="color:#94a3b8;text-decoration:none;font-size:1.1rem;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div style="width:36px;height:36px;border-radius:9px;background:#fef3c7;display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-calendar-plus" style="color:#d97706;font-size:14px;"></i>
        </div>
        <div>
            <h1 style="font-size:1.3rem;font-weight:700;color:#0f172a;margin:0;">Nueva Cita</h1>
            <p style="font-size:0.8rem;color:#64748b;margin:0;">Solo se muestran horarios disponibles según tu agenda</p>
        </div>
    </div>

    @if($errors->any())
    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:1.25rem;font-size:13px;color:#991b1b;">
        <i class="fas fa-circle-exclamation" style="margin-right:6px;"></i>
        @foreach($errors->all() as $error) {{ $error }}<br> @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('medico.citas.store') }}">
        @csrf
        <div style="display:flex;flex-direction:column;gap:1.25rem;max-width:720px;">

            {{-- PACIENTE --}}
            <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.07);overflow:hidden;">
                <div style="padding:0.85rem 1.25rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.6rem;">
                    <div style="width:26px;height:26px;background:#e0f2fe;border-radius:7px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-user" style="color:#0284c7;font-size:11px;"></i>
                    </div>
                    <span style="font-size:0.9rem;font-weight:600;color:#0f172a;">Paciente</span>
                </div>
                <div style="padding:1.25rem;">
                    <label style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Seleccionar paciente *</label>
                    <select name="paciente_id" required
                        style="width:100%;padding:0.6rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;background:white;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                        onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                        <option value="">— Seleccionar paciente —</option>
                        @foreach($pacientes as $p)
                        <option value="{{ $p->id }}" {{ old('paciente_id', request('paciente_id')) == $p->id ? 'selected' : '' }}>
                            {{ $p->nombre_completo }} — {{ $p->numero_expediente }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- FECHA Y HORA --}}
            <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.07);overflow:hidden;">
                <div style="padding:0.85rem 1.25rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.6rem;">
                    <div style="width:26px;height:26px;background:#fef3c7;border-radius:7px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-calendar-days" style="color:#d97706;font-size:11px;"></i>
                    </div>
                    <span style="font-size:0.9rem;font-weight:600;color:#0f172a;">Fecha y Hora</span>
                </div>
                <div style="padding:1.25rem;">

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.25rem;">
                        <div>
                            <label style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Fecha *</label>
                            <input type="date" id="inp-fecha" name="_fecha_selector"
                                value="{{ old('_fecha_selector', request('fecha', date('Y-m-d'))) }}"
                                min="{{ date('Y-m-d') }}"
                                style="width:100%;padding:0.6rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                        </div>
                        <div>
                            <label style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Duración *</label>
                            <select name="duracion_minutos" id="sel-duracion"
                                style="width:100%;padding:0.6rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;background:white;"
                                onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                                @foreach([15,20,30,45,60,90,120] as $min)
                                <option value="{{ $min }}" {{ old('duracion_minutos', $duracionDefecto ?? 30) == $min ? 'selected' : '' }}>
                                    {{ $min }} minutos
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Slots --}}
                    <div>
                        <label style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:0.5rem;text-transform:uppercase;letter-spacing:0.4px;">
                            Hora disponible *
                            <span id="horario-label" style="color:#94a3b8;font-weight:400;font-size:0.72rem;text-transform:none;letter-spacing:0;"></span>
                        </label>

                        <input type="hidden" name="fecha_hora" id="inp-fecha-hora" value="{{ old('fecha_hora') }}">

                        <div id="slots-loading" style="display:none;padding:1.5rem;text-align:center;color:#94a3b8;font-size:13px;">
                            <i class="fas fa-circle-notch fa-spin" style="margin-right:6px;"></i> Cargando horarios...
                        </div>

                        <div id="slots-empty" style="padding:1.25rem;background:#f8fafc;border-radius:10px;text-align:center;color:#94a3b8;font-size:13px;border:1px dashed #e2e8f0;">
                            <i class="fas fa-calendar-xmark" style="font-size:1.5rem;margin-bottom:6px;display:block;"></i>
                            Selecciona una fecha para ver los horarios disponibles
                        </div>

                        <div id="slots-nodisponible" style="display:none;padding:1rem;background:#fef2f2;border:1px solid #fecaca;border-radius:10px;text-align:center;color:#991b1b;font-size:13px;">
                            <i class="fas fa-ban" style="margin-right:5px;"></i>
                            <span id="slots-nodisponible-msg">El médico no trabaja ese día</span>
                        </div>

                        <div id="slots-grid" style="display:none;flex-wrap:wrap;gap:8px;"></div>

                        @error('fecha_hora')
                        <span style="color:#e11d48;font-size:11px;display:block;margin-top:4px;">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- MOTIVO Y NOTAS --}}
            <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.07);overflow:hidden;">
                <div style="padding:0.85rem 1.25rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.6rem;">
                    <div style="width:26px;height:26px;background:#f0fdf4;border-radius:7px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-notes-medical" style="color:#16a34a;font-size:11px;"></i>
                    </div>
                    <span style="font-size:0.9rem;font-weight:600;color:#0f172a;">Detalles</span>
                </div>
                <div style="padding:1.25rem;display:flex;flex-direction:column;gap:1rem;">
                    <div>
                        <label style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Motivo de la cita *</label>
                        <input type="text" name="motivo" value="{{ old('motivo') }}" required
                            placeholder="Ej. Consulta general, revisión, seguimiento..."
                            style="width:100%;padding:0.6rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Notas adicionales</label>
                        <textarea name="notas" rows="3"
                            placeholder="Instrucciones previas, observaciones..."
                            style="width:100%;padding:0.6rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;resize:vertical;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">{{ old('notas') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- BOTONES --}}
            <div style="display:flex;justify-content:flex-end;gap:10px;padding-bottom:2rem;">
                <a href="{{ route('medico.citas.index') }}"
                    style="padding:0.6rem 1.5rem;background:#f1f5f9;color:#64748b;border-radius:8px;text-decoration:none;font-size:0.875rem;font-weight:600;display:flex;align-items:center;gap:6px;">
                    <i class="fas fa-xmark"></i> Cancelar
                </a>
                <button type="submit"
                    style="padding:0.6rem 1.75rem;background:#7c3aed;color:white;border:none;border-radius:8px;font-size:0.875rem;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:6px;"
                    onmouseover="this.style.background='#6d28d9'" onmouseout="this.style.background='#7c3aed'">
                    <i class="fas fa-calendar-check"></i> Agendar cita
                </button>
            </div>

        </div>
    </form>
</div>

<script>
let slotSeleccionado = null;
const SLOTS_URL = '{{ route("medico.configuraciones.slots") }}';

document.getElementById('inp-fecha').addEventListener('change', cargarSlots);
document.getElementById('sel-duracion').addEventListener('change', cargarSlots);
window.addEventListener('load', () => {
    if (document.getElementById('inp-fecha').value) cargarSlots();
});

function cargarSlots() {
    const fecha    = document.getElementById('inp-fecha').value;
    const duracion = document.getElementById('sel-duracion').value;
    if (!fecha) return;

    slotSeleccionado = null;
    document.getElementById('inp-fecha-hora').value             = '';
    document.getElementById('slots-empty').style.display        = 'none';
    document.getElementById('slots-nodisponible').style.display = 'none';
    document.getElementById('slots-grid').style.display         = 'none';
    document.getElementById('slots-loading').style.display      = 'block';
    document.getElementById('horario-label').textContent        = '';

    fetch(`${SLOTS_URL}?fecha=${fecha}&duracion=${duracion}`)
        .then(r => r.json())
        .then(data => {
            document.getElementById('slots-loading').style.display = 'none';

            if (!data.slots || data.slots.length === 0) {
                document.getElementById('slots-nodisponible').style.display = 'block';
                document.getElementById('slots-nodisponible-msg').textContent =
                    data.mensaje || 'No hay horarios disponibles para ese día';
                return;
            }

            document.getElementById('horario-label').textContent =
                `— ${data.dia}  ${data.horario}`;

            const grid = document.getElementById('slots-grid');
            grid.innerHTML     = '';
            grid.style.display = 'flex';

            data.slots.forEach(slot => {
                const btn = document.createElement('button');
                btn.type          = 'button';
                btn.textContent   = slot.hora;
                btn.dataset.hora  = slot.hora;

                if (!slot.libre) {
                    btn.style.cssText = `
                        padding:7px 13px;border-radius:8px;font-size:12px;font-weight:600;
                        background:#f1f5f9;color:#cbd5e1;border:1px solid #e2e8f0;
                        cursor:not-allowed;text-decoration:line-through;
                    `;
                    btn.disabled = true;
                    btn.title    = 'Hora ocupada';
                } else {
                    btn.style.cssText = `
                        padding:7px 13px;border-radius:8px;font-size:12px;font-weight:600;
                        background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;
                        cursor:pointer;transition:all .15s;
                    `;
                    btn.addEventListener('click',      () => seleccionarSlot(btn, fecha));
                    btn.addEventListener('mouseenter', () => { if (slotSeleccionado !== btn) btn.style.background = '#dcfce7'; });
                    btn.addEventListener('mouseleave', () => { if (slotSeleccionado !== btn) btn.style.background = '#f0fdf4'; });
                }
                grid.appendChild(btn);
            });

            // Re-seleccionar si hay error de validación
            const prev = document.getElementById('inp-fecha-hora').value;
            if (prev) {
                const prevHora = prev.split(' ')[1]?.substring(0,5);
                const prevBtn  = grid.querySelector(`[data-hora="${prevHora}"]`);
                if (prevBtn && !prevBtn.disabled) seleccionarSlot(prevBtn, fecha);
            }
        })
        .catch(() => {
            document.getElementById('slots-loading').style.display      = 'none';
            document.getElementById('slots-nodisponible').style.display = 'block';
            document.getElementById('slots-nodisponible-msg').textContent = 'Error al cargar horarios. Intenta de nuevo.';
        });
}

function seleccionarSlot(btn, fecha) {
    if (slotSeleccionado) {
        slotSeleccionado.style.background = '#f0fdf4';
        slotSeleccionado.style.color      = '#16a34a';
        slotSeleccionado.style.border     = '1px solid #bbf7d0';
        slotSeleccionado.style.boxShadow  = 'none';
        slotSeleccionado.style.transform  = 'none';
    }
    slotSeleccionado            = btn;
    btn.style.background        = '#16a34a';
    btn.style.color             = 'white';
    btn.style.border            = '1px solid #16a34a';
    btn.style.boxShadow         = '0 3px 10px rgba(22,163,74,.25)';
    btn.style.transform         = 'scale(1.05)';
    document.getElementById('inp-fecha-hora').value = fecha + ' ' + btn.dataset.hora + ':00';
}
</script>

@endsection
