@extends('layouts.medico')
@section('titulo', 'Nuevo Tratamiento Estético')
@section('contenido')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
    <a href="{{ $pacienteSeleccionado ? route('medico.pacientes.show', $pacienteSeleccionado) : route('medico.pacientes.index') }}"
        style="color:#94a3b8;text-decoration:none;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h3 class="font-serif" style="font-size:21px;">Nuevo Tratamiento Estético</h3>
</div>

<form method="POST" action="{{ route('medico.estetica.store') }}" id="form-tratamiento">
@csrf
<div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">

    <!-- Columna izquierda: datos + mapa -->
    <div style="display:flex;flex-direction:column;gap:14px;">

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;">Datos del tratamiento</h4>
            <div style="display:flex;flex-direction:column;gap:12px;">
                <div>
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Paciente *</label>
                    <select name="paciente_id" required style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                        <option value="">Seleccionar...</option>
                        @foreach($pacientes as $p)
                        <option value="{{ $p->id }}" {{ old('paciente_id', $pacienteSeleccionado?->id) == $p->id ? 'selected' : '' }}>
                            {{ $p->nombre_completo }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Fecha *</label>
                    <input type="date" name="fecha" value="{{ old('fecha', today()->format('Y-m-d')) }}" required
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Título</label>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" placeholder="Ej: Botox frente + patas de gallo"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Observaciones generales</label>
                    <textarea name="observaciones_generales" rows="2"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;resize:vertical;"
                        placeholder="Notas generales...">{{ old('observaciones_generales') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Mapa facial -->
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:13px;font-weight:700;margin-bottom:4px;">Mapa Facial</h4>
            <p style="font-size:11px;color:#94a3b8;margin-bottom:12px;">Haz clic en una zona para agregarla</p>
            <div style="display:flex;justify-content:center;">
                <svg id="mapa-facial" viewBox="0 0 200 320" width="220" height="320" style="cursor:pointer;">
                    <ellipse cx="100" cy="130" rx="72" ry="90" fill="#fde8d0" stroke="#d4a574" stroke-width="1.5"/>
                    <rect x="78" y="210" width="44" height="50" rx="8" fill="#fde8d0" stroke="#d4a574" stroke-width="1.5"/>
                    <ellipse cx="100" cy="52" rx="72" ry="30" fill="#8B6340"/>
                    <rect x="28" y="52" width="18" height="45" rx="9" fill="#8B6340"/>
                    <rect x="154" y="52" width="18" height="45" rx="9" fill="#8B6340"/>
                    <ellipse cx="72" cy="115" rx="14" ry="8" fill="white" stroke="#666" stroke-width="1"/>
                    <circle cx="72" cy="115" r="5" fill="#4a3728"/>
                    <ellipse cx="128" cy="115" rx="14" ry="8" fill="white" stroke="#666" stroke-width="1"/>
                    <circle cx="128" cy="115" r="5" fill="#4a3728"/>
                    <path d="M58 104 Q72 98 86 104" stroke="#4a3728" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                    <path d="M114 104 Q128 98 142 104" stroke="#4a3728" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                    <path d="M100 120 L94 148 Q100 152 106 148 Z" fill="#f5c5a0" stroke="#d4a574" stroke-width="1"/>
                    <path d="M82 168 Q100 178 118 168" stroke="#c97b7b" stroke-width="2" fill="none" stroke-linecap="round"/>
                    <path d="M82 168 Q100 162 118 168" stroke="#c97b7b" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                    <ellipse cx="28" cy="135" rx="10" ry="16" fill="#fde8d0" stroke="#d4a574" stroke-width="1.5"/>
                    <ellipse cx="172" cy="135" rx="10" ry="16" fill="#fde8d0" stroke="#d4a574" stroke-width="1.5"/>

                    <!-- Zonas clickeables -->
                    <ellipse class="zona-facial" data-zona="frente" data-label="Frente" cx="100" cy="82" rx="55" ry="22" fill="transparent" stroke="transparent" stroke-width="2" style="cursor:pointer;"/>
                    <ellipse class="zona-facial" data-zona="entrecejo" data-label="Entrecejo" cx="100" cy="107" rx="18" ry="10" fill="transparent" stroke="transparent" stroke-width="2" style="cursor:pointer;"/>
                    <ellipse class="zona-facial" data-zona="patas_gallo_izq" data-label="Patas de gallo izquierda" cx="52" cy="115" rx="18" ry="12" fill="transparent" stroke="transparent" stroke-width="2" style="cursor:pointer;"/>
                    <ellipse class="zona-facial" data-zona="patas_gallo_der" data-label="Patas de gallo derecha" cx="148" cy="115" rx="18" ry="12" fill="transparent" stroke="transparent" stroke-width="2" style="cursor:pointer;"/>
                    <ellipse class="zona-facial" data-zona="mejilla_izq" data-label="Mejilla izquierda" cx="58" cy="148" rx="22" ry="18" fill="transparent" stroke="transparent" stroke-width="2" style="cursor:pointer;"/>
                    <ellipse class="zona-facial" data-zona="mejilla_der" data-label="Mejilla derecha" cx="142" cy="148" rx="22" ry="18" fill="transparent" stroke="transparent" stroke-width="2" style="cursor:pointer;"/>
                    <ellipse class="zona-facial" data-zona="nariz" data-label="Nariz" cx="100" cy="138" rx="14" ry="16" fill="transparent" stroke="transparent" stroke-width="2" style="cursor:pointer;"/>
                    <ellipse class="zona-facial" data-zona="labios" data-label="Labios" cx="100" cy="170" rx="22" ry="12" fill="transparent" stroke="transparent" stroke-width="2" style="cursor:pointer;"/>
                    <ellipse class="zona-facial" data-zona="menton" data-label="Mentón" cx="100" cy="192" rx="22" ry="14" fill="transparent" stroke="transparent" stroke-width="2" style="cursor:pointer;"/>
                    <ellipse class="zona-facial" data-zona="cuello" data-label="Cuello" cx="100" cy="232" rx="22" ry="18" fill="transparent" stroke="transparent" stroke-width="2" style="cursor:pointer;"/>
                    <ellipse class="zona-facial" data-zona="mandibula_izq" data-label="Mandíbula izquierda" cx="42" cy="175" rx="18" ry="14" fill="transparent" stroke="transparent" stroke-width="2" style="cursor:pointer;"/>
                    <ellipse class="zona-facial" data-zona="mandibula_der" data-label="Mandíbula derecha" cx="158" cy="175" rx="18" ry="14" fill="transparent" stroke="transparent" stroke-width="2" style="cursor:pointer;"/>

                    <!-- Labels -->
                    <text id="label-frente" x="100" y="86" text-anchor="middle" font-size="8" fill="#9333ea" font-weight="bold" opacity="0">Frente</text>
                    <text id="label-entrecejo" x="100" y="110" text-anchor="middle" font-size="7" fill="#9333ea" font-weight="bold" opacity="0">Entrecejo</text>
                    <text id="label-patas_gallo_izq" x="52" y="118" text-anchor="middle" font-size="6" fill="#9333ea" font-weight="bold" opacity="0">P.Gallo Izq</text>
                    <text id="label-patas_gallo_der" x="148" y="118" text-anchor="middle" font-size="6" fill="#9333ea" font-weight="bold" opacity="0">P.Gallo Der</text>
                    <text id="label-mejilla_izq" x="58" y="151" text-anchor="middle" font-size="7" fill="#9333ea" font-weight="bold" opacity="0">Mejilla Izq</text>
                    <text id="label-mejilla_der" x="142" y="151" text-anchor="middle" font-size="7" fill="#9333ea" font-weight="bold" opacity="0">Mejilla Der</text>
                    <text id="label-nariz" x="100" y="141" text-anchor="middle" font-size="7" fill="#9333ea" font-weight="bold" opacity="0">Nariz</text>
                    <text id="label-labios" x="100" y="173" text-anchor="middle" font-size="7" fill="#9333ea" font-weight="bold" opacity="0">Labios</text>
                    <text id="label-menton" x="100" y="195" text-anchor="middle" font-size="7" fill="#9333ea" font-weight="bold" opacity="0">Mentón</text>
                    <text id="label-cuello" x="100" y="235" text-anchor="middle" font-size="7" fill="#9333ea" font-weight="bold" opacity="0">Cuello</text>
                    <text id="label-mandibula_izq" x="42" y="178" text-anchor="middle" font-size="6" fill="#9333ea" font-weight="bold" opacity="0">Mandíb. Izq</text>
                    <text id="label-mandibula_der" x="158" y="178" text-anchor="middle" font-size="6" fill="#9333ea" font-weight="bold" opacity="0">Mandíb. Der</text>
                </svg>
            </div>
        </div>

    </div>

    <!-- Columna derecha: zonas seleccionadas -->
    <div style="display:flex;flex-direction:column;gap:14px;">

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;">Zonas Seleccionadas</h4>
            <div id="zonas-container">
                <div id="sin-zonas" style="text-align:center;padding:40px 0;color:#94a3b8;">
                    <i class="fa-solid fa-hand-pointer" style="font-size:28px;margin-bottom:10px;display:block;"></i>
                    <p style="font-size:12px;">Haz clic en el mapa facial para agregar zonas</p>
                </div>
            </div>
        </div>

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <button type="submit"
                style="width:100%;padding:10px;border-radius:9px;font-size:14px;font-weight:600;background:#9333ea;color:white;border:none;cursor:pointer;margin-bottom:8px;">
                <i class="fa-solid fa-floppy-disk"></i> Registrar tratamiento
            </button>
            <a href="{{ $pacienteSeleccionado ? route('medico.pacientes.show', $pacienteSeleccionado) : route('medico.pacientes.index') }}"
                style="display:flex;align-items:center;justify-content:center;padding:9px;border-radius:9px;font-size:13px;font-weight:600;background:white;color:#64748b;border:1.5px solid #e2e8f0;text-decoration:none;">
                Cancelar
            </a>
        </div>

        @if($pacienteSeleccionado)
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:10px;">Paciente</h4>
            <div style="display:flex;align-items:center;gap:9px;">
                <div style="width:36px;height:36px;border-radius:50%;background:#f3e8ff;color:#9333ea;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;">
                    {{ strtoupper(substr($pacienteSeleccionado->nombre, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:13px;font-weight:600;">{{ $pacienteSeleccionado->nombre_completo }}</div>
                    <div style="font-size:11px;color:#64748b;">{{ $pacienteSeleccionado->expediente }}</div>
                </div>
            </div>
            @if($pacienteSeleccionado->alergias)
            <div style="margin-top:10px;background:#fee2e2;border-radius:7px;padding:8px 10px;font-size:12px;color:#991b1b;">
                <i class="fa-solid fa-triangle-exclamation" style="margin-right:4px;"></i>
                <strong>Alergias:</strong> {{ $pacienteSeleccionado->alergias }}
            </div>
            @endif
        </div>
        @endif

    </div>

</div>
</form>

<script>
const productos = @json($productos->map(fn($p) => ['id' => $p->id, 'nombre' => $p->nombre, 'unidad' => $p->unidad ?? '']));
const zonasSeleccionadas = {};
let zonaIndex = 0;

document.querySelectorAll('.zona-facial').forEach(zona => {
    zona.addEventListener('mouseenter', function() {
        if (!zonasSeleccionadas[this.dataset.zona]) {
            this.setAttribute('fill', 'rgba(147,51,234,0.15)');
            this.setAttribute('stroke', '#9333ea');
        }
    });
    zona.addEventListener('mouseleave', function() {
        if (!zonasSeleccionadas[this.dataset.zona]) {
            this.setAttribute('fill', 'transparent');
            this.setAttribute('stroke', 'transparent');
        }
    });
    zona.addEventListener('click', function() {
        const zonaId    = this.dataset.zona;
        const zonaLabel = this.dataset.label;
        if (zonasSeleccionadas[zonaId]) return;
        zonasSeleccionadas[zonaId] = true;
        this.setAttribute('fill', 'rgba(147,51,234,0.3)');
        this.setAttribute('stroke', '#9333ea');
        this.setAttribute('stroke-width', '2');
        const label = document.getElementById('label-' + zonaId);
        if (label) label.setAttribute('opacity', '1');
        agregarZonaForm(zonaId, zonaLabel);
    });
});

function agregarZonaForm(zonaId, zonaLabel) {
    document.getElementById('sin-zonas').style.display = 'none';
    const container = document.getElementById('zonas-container');
    const div = document.createElement('div');
    div.id = 'zona-form-' + zonaId;
    div.style.cssText = 'border:1.5px solid #e9d5ff;border-radius:10px;padding:14px;margin-bottom:10px;background:#faf5ff;';

    let opts = '<option value="">Sin producto</option>';
    productos.forEach(p => { opts += `<option value="${p.id}">${p.nombre}</option>`; });

    div.innerHTML = `
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
            <span style="font-size:13px;font-weight:700;color:#7c3aed;">${zonaLabel}</span>
            <button type="button" onclick="eliminarZona('${zonaId}')"
                style="background:#fee2e2;color:#e11d48;border:none;border-radius:5px;padding:2px 8px;font-size:11px;cursor:pointer;">
                Eliminar
            </button>
        </div>
        <input type="hidden" name="zonas[${zonaIndex}][zona]" value="${zonaId}">
        <input type="hidden" name="zonas[${zonaIndex}][zona_label]" value="${zonaLabel}">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
            <div>
                <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:3px;">Producto</label>
                <select name="zonas[${zonaIndex}][producto_id]"
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:6px 8px;font-size:12px;font-family:'DM Sans',sans-serif;outline:none;">
                    ${opts}
                </select>
            </div>
            <div>
                <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:3px;">Cantidad</label>
                <input type="number" name="zonas[${zonaIndex}][cantidad]" value="1" min="0" step="0.5"
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:6px 8px;font-size:12px;font-family:'DM Sans',sans-serif;outline:none;">
            </div>
            <div style="grid-column:span 2;">
                <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:3px;">Notas</label>
                <input type="text" name="zonas[${zonaIndex}][notas]" placeholder="Ej: 4 unidades distribuidas uniformemente"
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:6px 8px;font-size:12px;font-family:'DM Sans',sans-serif;outline:none;">
            </div>
        </div>`;
    container.appendChild(div);
    zonaIndex++;
}

function eliminarZona(zonaId) {
    delete zonasSeleccionadas[zonaId];
    const zona = document.querySelector(`[data-zona="${zonaId}"]`);
    if (zona) { zona.setAttribute('fill', 'transparent'); zona.setAttribute('stroke', 'transparent'); }
    const label = document.getElementById('label-' + zonaId);
    if (label) label.setAttribute('opacity', '0');
    const form = document.getElementById('zona-form-' + zonaId);
    if (form) form.remove();
    if (Object.keys(zonasSeleccionadas).length === 0) {
        document.getElementById('sin-zonas').style.display = 'block';
    }
}
</script>
@endsection
