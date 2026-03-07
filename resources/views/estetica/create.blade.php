@extends('layouts.panel')

@section('titulo', 'Nuevo Tratamiento Estético')

@section('contenido')

<div class="max-w-6xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('estetica.index') }}" class="text-slate-400 hover:text-slate-600">
            <x-heroicon-o-arrow-left class="w-5 h-5"/>
        </a>
        <h2 class="text-lg font-semibold text-slate-800">Nuevo Tratamiento Estético</h2>
    </div>

    <form method="POST" action="{{ route('estetica.store') }}" id="form-tratamiento">
        @csrf

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px;">

            <!-- Columna izquierda: datos + mapa -->
            <div style="display:flex; flex-direction:column; gap:16px;">

                <!-- Datos generales -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                        Datos del Tratamiento
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Paciente *</label>
                            <select name="paciente_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option value="">Seleccionar...</option>
                                @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}">{{ $paciente->nombre_completo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Médico *</label>
                            <select name="medico_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option value="">Seleccionar...</option>
                                @foreach($medicos as $medico)
                                    <option value="{{ $medico->id }}">Dr. {{ $medico->nombre_completo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Fecha *</label>
                            <input type="date" name="fecha" value="{{ now()->format('Y-m-d') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Título</label>
                            <input type="text" name="titulo"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                                placeholder="Ej: Botox frente + patas de gallo">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Observaciones generales</label>
                            <textarea name="observaciones_generales" rows="2"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                                placeholder="Notas generales del tratamiento..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Mapa facial SVG -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                        Mapa Facial — Haz clic en una zona
                    </h3>
                    <div class="flex justify-center">
                        <svg id="mapa-facial" viewBox="0 0 200 320" width="220" height="350" style="cursor:pointer;">

                            <!-- Cabeza/cara -->
                            <ellipse cx="100" cy="130" rx="72" ry="90" fill="#fde8d0" stroke="#d4a574" stroke-width="1.5"/>

                            <!-- Cuello -->
                            <rect x="78" y="210" width="44" height="50" rx="8" fill="#fde8d0" stroke="#d4a574" stroke-width="1.5"/>

                            <!-- Cabello -->
                            <ellipse cx="100" cy="52" rx="72" ry="30" fill="#8B6340"/>
                            <rect x="28" y="52" width="18" height="45" rx="9" fill="#8B6340"/>
                            <rect x="154" y="52" width="18" height="45" rx="9" fill="#8B6340"/>

                            <!-- Ojos -->
                            <ellipse cx="72" cy="115" rx="14" ry="8" fill="white" stroke="#666" stroke-width="1"/>
                            <circle cx="72" cy="115" r="5" fill="#4a3728"/>
                            <ellipse cx="128" cy="115" rx="14" ry="8" fill="white" stroke="#666" stroke-width="1"/>
                            <circle cx="128" cy="115" r="5" fill="#4a3728"/>

                            <!-- Cejas -->
                            <path d="M58 104 Q72 98 86 104" stroke="#4a3728" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                            <path d="M114 104 Q128 98 142 104" stroke="#4a3728" stroke-width="2.5" fill="none" stroke-linecap="round"/>

                            <!-- Nariz -->
                            <path d="M100 120 L94 148 Q100 152 106 148 Z" fill="#f5c5a0" stroke="#d4a574" stroke-width="1"/>

                            <!-- Boca -->
                            <path d="M82 168 Q100 178 118 168" stroke="#c97b7b" stroke-width="2" fill="none" stroke-linecap="round"/>
                            <path d="M82 168 Q100 162 118 168" stroke="#c97b7b" stroke-width="1.5" fill="none" stroke-linecap="round"/>

                            <!-- Orejas -->
                            <ellipse cx="28" cy="135" rx="10" ry="16" fill="#fde8d0" stroke="#d4a574" stroke-width="1.5"/>
                            <ellipse cx="172" cy="135" rx="10" ry="16" fill="#fde8d0" stroke="#d4a574" stroke-width="1.5"/>

                            <!-- ZONAS CLICKEABLES -->

                            <!-- Frente -->
                            <ellipse id="zona-frente" cx="100" cy="82" rx="55" ry="22"
                                fill="transparent" stroke="transparent" stroke-width="2"
                                class="zona-facial" data-zona="frente" data-label="Frente"
                                style="cursor:pointer;" />

                            <!-- Entrecejo -->
                            <ellipse id="zona-entrecejo" cx="100" cy="107" rx="18" ry="10"
                                fill="transparent" stroke="transparent" stroke-width="2"
                                class="zona-facial" data-zona="entrecejo" data-label="Entrecejo"
                                style="cursor:pointer;" />

                            <!-- Patas de gallo izquierda -->
                            <ellipse id="zona-patas-gallo-izq" cx="52" cy="115" rx="18" ry="12"
                                fill="transparent" stroke="transparent" stroke-width="2"
                                class="zona-facial" data-zona="patas_gallo_izq" data-label="Patas de gallo izquierda"
                                style="cursor:pointer;" />

                            <!-- Patas de gallo derecha -->
                            <ellipse id="zona-patas-gallo-der" cx="148" cy="115" rx="18" ry="12"
                                fill="transparent" stroke="transparent" stroke-width="2"
                                class="zona-facial" data-zona="patas_gallo_der" data-label="Patas de gallo derecha"
                                style="cursor:pointer;" />

                            <!-- Mejilla izquierda -->
                            <ellipse id="zona-mejilla-izq" cx="58" cy="148" rx="22" ry="18"
                                fill="transparent" stroke="transparent" stroke-width="2"
                                class="zona-facial" data-zona="mejilla_izq" data-label="Mejilla izquierda"
                                style="cursor:pointer;" />

                            <!-- Mejilla derecha -->
                            <ellipse id="zona-mejilla-der" cx="142" cy="148" rx="22" ry="18"
                                fill="transparent" stroke="transparent" stroke-width="2"
                                class="zona-facial" data-zona="mejilla_der" data-label="Mejilla derecha"
                                style="cursor:pointer;" />

                            <!-- Nariz zona -->
                            <ellipse id="zona-nariz" cx="100" cy="138" rx="14" ry="16"
                                fill="transparent" stroke="transparent" stroke-width="2"
                                class="zona-facial" data-zona="nariz" data-label="Nariz"
                                style="cursor:pointer;" />

                            <!-- Labios -->
                            <ellipse id="zona-labios" cx="100" cy="170" rx="22" ry="12"
                                fill="transparent" stroke="transparent" stroke-width="2"
                                class="zona-facial" data-zona="labios" data-label="Labios"
                                style="cursor:pointer;" />

                            <!-- Mentón -->
                            <ellipse id="zona-menton" cx="100" cy="192" rx="22" ry="14"
                                fill="transparent" stroke="transparent" stroke-width="2"
                                class="zona-facial" data-zona="menton" data-label="Mentón"
                                style="cursor:pointer;" />

                            <!-- Cuello zona -->
                            <ellipse id="zona-cuello" cx="100" cy="232" rx="22" ry="18"
                                fill="transparent" stroke="transparent" stroke-width="2"
                                class="zona-facial" data-zona="cuello" data-label="Cuello"
                                style="cursor:pointer;" />

                            <!-- Líneas mandíbula -->
                            <ellipse id="zona-mandibula-izq" cx="42" cy="175" rx="18" ry="14"
                                fill="transparent" stroke="transparent" stroke-width="2"
                                class="zona-facial" data-zona="mandibula_izq" data-label="Mandíbula izquierda"
                                style="cursor:pointer;" />

                            <ellipse id="zona-mandibula-der" cx="158" cy="175" rx="18" ry="14"
                                fill="transparent" stroke="transparent" stroke-width="2"
                                class="zona-facial" data-zona="mandibula_der" data-label="Mandíbula derecha"
                                style="cursor:pointer;" />

                            <!-- Etiquetas de zonas (aparecen al activar) -->
                            <text id="label-frente" x="100" y="86" text-anchor="middle" font-size="8" fill="#0d9488" font-weight="bold" opacity="0">Frente</text>
                            <text id="label-entrecejo" x="100" y="110" text-anchor="middle" font-size="7" fill="#0d9488" font-weight="bold" opacity="0">Entrecejo</text>
                            <text id="label-patas_gallo_izq" x="52" y="118" text-anchor="middle" font-size="6" fill="#0d9488" font-weight="bold" opacity="0">P.Gallo Izq</text>
                            <text id="label-patas_gallo_der" x="148" y="118" text-anchor="middle" font-size="6" fill="#0d9488" font-weight="bold" opacity="0">P.Gallo Der</text>
                            <text id="label-mejilla_izq" x="58" y="151" text-anchor="middle" font-size="7" fill="#0d9488" font-weight="bold" opacity="0">Mejilla Izq</text>
                            <text id="label-mejilla_der" x="142" y="151" text-anchor="middle" font-size="7" fill="#0d9488" font-weight="bold" opacity="0">Mejilla Der</text>
                            <text id="label-nariz" x="100" y="141" text-anchor="middle" font-size="7" fill="#0d9488" font-weight="bold" opacity="0">Nariz</text>
                            <text id="label-labios" x="100" y="173" text-anchor="middle" font-size="7" fill="#0d9488" font-weight="bold" opacity="0">Labios</text>
                            <text id="label-menton" x="100" y="195" text-anchor="middle" font-size="7" fill="#0d9488" font-weight="bold" opacity="0">Mentón</text>
                            <text id="label-cuello" x="100" y="235" text-anchor="middle" font-size="7" fill="#0d9488" font-weight="bold" opacity="0">Cuello</text>
                            <text id="label-mandibula_izq" x="42" y="178" text-anchor="middle" font-size="6" fill="#0d9488" font-weight="bold" opacity="0">Mandíb. Izq</text>
                            <text id="label-mandibula_der" x="158" y="178" text-anchor="middle" font-size="6" fill="#0d9488" font-weight="bold" opacity="0">Mandíb. Der</text>

                        </svg>
                    </div>
                    <p class="text-xs text-slate-400 text-center mt-2">Haz clic en una zona para agregar tratamiento</p>
                </div>

            </div>

            <!-- Columna derecha: zonas seleccionadas -->
            <div style="display:flex; flex-direction:column; gap:16px;">

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                        Zonas Seleccionadas
                    </h3>

                    <div id="zonas-container" class="space-y-3">
                        <div id="sin-zonas" class="text-center py-8 text-slate-400">
                            <p class="text-3xl mb-2">���</p>
                            <p class="text-sm">Haz clic en el mapa facial para agregar zonas</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="flex items-center gap-3 mt-6">
            <button type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                Registrar tratamiento
            </button>
            <a href="{{ route('estetica.index') }}"
                class="text-slate-600 hover:text-slate-800 px-4 py-2 rounded-lg text-sm font-medium border border-gray-300 transition">
                Cancelar
            </a>
        </div>

    </form>
</div>

<script>
const productos = @json($productos->map(fn($p) => ['id' => $p->id, 'nombre' => $p->nombre, 'unidad' => $p->unidad]));
const zonasSeleccionadas = {};
let zonaIndex = 0;

document.querySelectorAll('.zona-facial').forEach(zona => {
    zona.addEventListener('mouseenter', function() {
        if (!zonasSeleccionadas[this.dataset.zona]) {
            this.setAttribute('fill', 'rgba(13, 148, 136, 0.15)');
            this.setAttribute('stroke', '#0d9488');
        }
    });
    zona.addEventListener('mouseleave', function() {
        if (!zonasSeleccionadas[this.dataset.zona]) {
            this.setAttribute('fill', 'transparent');
            this.setAttribute('stroke', 'transparent');
        }
    });
    zona.addEventListener('click', function() {
        const zonaId   = this.dataset.zona;
        const zonaLabel = this.dataset.label;

        if (zonasSeleccionadas[zonaId]) return;

        zonasSeleccionadas[zonaId] = true;
        this.setAttribute('fill', 'rgba(13, 148, 136, 0.3)');
        this.setAttribute('stroke', '#0d9488');
        this.setAttribute('stroke-width', '2');

        const label = document.getElementById('label-' + zonaId);
        if (label) label.setAttribute('opacity', '1');

        agregarZonaForm(zonaId, zonaLabel);
    });
});

function agregarZonaForm(zonaId, zonaLabel) {
    const sinZonas = document.getElementById('sin-zonas');
    if (sinZonas) sinZonas.style.display = 'none';

    const container = document.getElementById('zonas-container');
    const div = document.createElement('div');
    div.id = 'zona-form-' + zonaId;
    div.className = 'border border-teal-200 rounded-lg p-4 bg-teal-50';

    let productosOptions = '<option value="">Sin producto</option>';
    productos.forEach(p => {
        productosOptions += `<option value="${p.id}">${p.nombre}</option>`;
    });

    div.innerHTML = `
        <div class="flex justify-between items-center mb-3">
            <h4 class="text-sm font-semibold text-teal-700">${zonaLabel}</h4>
            <button type="button" onclick="eliminarZona('${zonaId}')"
                class="text-red-500 hover:text-red-700 text-xs">Eliminar</button>
        </div>
        <input type="hidden" name="zonas[${zonaIndex}][zona]" value="${zonaId}">
        <input type="hidden" name="zonas[${zonaIndex}][zona_label]" value="${zonaLabel}">
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs text-slate-600 mb-1">Producto</label>
                <select name="zonas[${zonaIndex}][producto_id]" onchange="actualizarUnidad(this, ${zonaIndex})"
                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-teal-500">
                    ${productosOptions}
                </select>
            </div>
            <div>
                <label class="block text-xs text-slate-600 mb-1">Cantidad</label>
                <input type="number" name="zonas[${zonaIndex}][cantidad]" value="1" min="0" step="0.5"
                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-teal-500">
            </div>
            <div class="col-span-2">
                <label class="block text-xs text-slate-600 mb-1">Notas de la zona</label>
                <input type="text" name="zonas[${zonaIndex}][notas]"
                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-teal-500"
                    placeholder="Ej: 4 unidades distribuidas uniformemente">
            </div>
        </div>
    `;
    container.appendChild(div);
    zonaIndex++;
}

function eliminarZona(zonaId) {
    delete zonasSeleccionadas[zonaId];
    const zona = document.querySelector(`[data-zona="${zonaId}"]`);
    if (zona) {
        zona.setAttribute('fill', 'transparent');
        zona.setAttribute('stroke', 'transparent');
    }
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
