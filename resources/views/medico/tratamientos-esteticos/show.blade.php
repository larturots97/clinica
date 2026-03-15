@extends('layouts.medico')
@section('titulo', 'Historia Clínica Estética')
@section('contenido')

@php
$grupoNombres = ['A'=>'Neuromoduladores','B'=>'Rellenos / Hidratación','C'=>'Bioestimulación','D'=>'Lipolíticos / Corporales','E'=>'Piel Superficial'];
$grupoColors  = ['A'=>'#d97706','B'=>'#059669','C'=>'#2563eb','D'=>'#7c3aed','E'=>'#dc2626'];
$grupoBg      = ['A'=>'#fef3c7','B'=>'#d1fae5','C'=>'#dbeafe','D'=>'#ede9fe','E'=>'#fee2e2'];
$coordsZonas  = ['F'=>[100,74],'GL'=>[100,100],'PGI'=>[52,122],'PGD'=>[148,122],'BL'=>[100,140],'L'=>[100,172],'MI'=>[44,158],'MD'=>[156,158],'C'=>[100,228]];
$zonasActivas = $tratamiento->zonasPredefinidas->pluck('zona')->toArray();
@endphp

{{-- CABECERA --}}
<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
    <a href="{{ route('medico.tratamientos-esteticos.index') }}" style="color:#94a3b8;text-decoration:none;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h3 class="font-serif" style="font-size:21px;">{{ $tratamiento->titulo ?? $tratamiento->tipoTratamiento?->nombre }}</h3>
    @if($tratamiento->grupo)
    <span style="background:{{ $grupoBg[$tratamiento->grupo] ?? '#f1f5f9' }};color:{{ $grupoColors[$tratamiento->grupo] ?? '#64748b' }};font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
        Grupo {{ $tratamiento->grupo }} — {{ $grupoNombres[$tratamiento->grupo] ?? '' }}
    </span>
    @endif

    <div style="margin-left:auto;display:flex;gap:8px;flex-wrap:wrap;align-items:center;">

        {{-- Consentimiento PDF --}}
        <a href="{{ route('medico.tratamientos-esteticos.consentimiento', $tratamiento) }}" target="_blank"
            style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:13px;font-weight:600;background:#0f766e;color:white;text-decoration:none;">
            <i class="fa-solid fa-file-signature"></i> Consentimiento
        </a>

        {{-- Botón firma paciente --}}
        @if($tratamiento->consentimiento_bloqueado)
            <span style="background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;padding:7px 14px;border-radius:8px;font-size:13px;font-weight:600;display:inline-flex;align-items:center;gap:6px;">
                <i class="fas fa-lock"></i> Consentimiento firmado
            </span>
        @else
            <button onclick="abrirFirma()"
                style="background:#0ea5e9;color:#fff;border:none;padding:7px 14px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;"
                onmouseover="this.style.background='#0284c7'"
                onmouseout="this.style.background='#0ea5e9'">
                <i class="fas fa-pen-nib"></i>
                {{ $tratamiento->firma_paciente ? 'Actualizar firma' : 'Solicitar firma paciente' }}
            </button>
        @endif

        {{-- Historia Clínica PDF --}}
        <a href="{{ route('medico.tratamientos-esteticos.pdf', $tratamiento) }}" target="_blank"
            style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:13px;font-weight:600;background:#9333ea;color:white;text-decoration:none;">
            <i class="fa-solid fa-file-pdf"></i> Historia Clínica
        </a>
    </div>
</div>

{{-- CONTENIDO --}}
<div style="display:grid;grid-template-columns:1fr 300px;gap:18px;">

    {{-- COLUMNA PRINCIPAL --}}
    <div style="display:flex;flex-direction:column;gap:14px;">

        {{-- DATOS CONSULTA --}}
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;gap:7px;">
                <span style="width:26px;height:26px;border-radius:7px;background:#f3e8ff;color:#9333ea;display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-user" style="font-size:11px;"></i>
                </span>
                Datos de la consulta
            </h4>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;">
                <div>
                    <div style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:3px;">Paciente</div>
                    <div style="font-size:13px;font-weight:600;">{{ $tratamiento->paciente?->nombre }} {{ $tratamiento->paciente?->apellidos }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:3px;">Fecha</div>
                    <div style="font-size:13px;font-weight:600;">{{ $tratamiento->fecha?->format('d/m/Y') }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:3px;">Sesión N°</div>
                    <div style="font-size:13px;font-weight:600;">{{ $tratamiento->sesion_numero }}</div>
                </div>
                @if($tratamiento->motivo_consulta)
                <div style="grid-column:span 3;">
                    <div style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:3px;">Motivo de consulta</div>
                    <div style="font-size:13px;">{{ $tratamiento->motivo_consulta }}</div>
                </div>
                @endif
                @if($tratamiento->objetivo)
                <div style="grid-column:span 3;">
                    <div style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:3px;">Objetivo</div>
                    <div style="font-size:13px;">{{ $tratamiento->objetivo }}</div>
                </div>
                @endif
                @if($tratamiento->observaciones_post)
                <div style="grid-column:span 3;">
                    <div style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:3px;">Observaciones post-aplicación</div>
                    <div style="font-size:13px;">{{ $tratamiento->observaciones_post }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- EVALUACIÓN --}}
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;gap:7px;">
                <span style="width:26px;height:26px;border-radius:7px;background:#f3e8ff;color:#9333ea;display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-microscope" style="font-size:11px;"></i>
                </span>
                Evaluación clínica
            </h4>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;">
                <div>
                    <div style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:3px;">Fototipo Fitzpatrick</div>
                    <div style="font-size:13px;font-weight:600;">{{ $tratamiento->fitzpatrick ? 'Tipo '.$tratamiento->fitzpatrick : '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:3px;">Tipo de piel</div>
                    <div style="font-size:13px;">{{ $tratamiento->tipo_piel ? implode(', ', $tratamiento->tipo_piel) : '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:3px;">Condiciones</div>
                    <div style="font-size:13px;">{{ $tratamiento->condiciones_piel ? implode(', ', $tratamiento->condiciones_piel) : '—' }}</div>
                </div>
            </div>
        </div>

        {{-- PRODUCTO --}}
        @if($tratamiento->producto_marca)
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;gap:7px;">
                <span style="width:26px;height:26px;border-radius:7px;background:#f3e8ff;color:#9333ea;display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-box" style="font-size:11px;"></i>
                </span>
                Producto utilizado
            </h4>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;">
                <div>
                    <div style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:3px;">Marca / Nombre</div>
                    <div style="font-size:13px;font-weight:600;">{{ $tratamiento->producto_marca }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:3px;">Lote</div>
                    <div style="font-size:13px;">{{ $tratamiento->producto_lote ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:3px;">Caducidad</div>
                    <div style="font-size:13px;">{{ $tratamiento->producto_caducidad?->format('d/m/Y') ?? '—' }}</div>
                </div>
            </div>
        </div>
        @endif

        {{-- ZONAS --}}
        @if($tratamiento->zonas->count())
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
            <div style="padding:14px 20px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;gap:7px;">
                <span style="width:26px;height:26px;border-radius:7px;background:#f3e8ff;color:#9333ea;display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-location-dot" style="font-size:11px;"></i>
                </span>
                <span style="font-size:13px;font-weight:700;">Zonas de aplicación</span>
            </div>
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th style="padding:8px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Zona</th>
                        <th style="padding:8px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Tipo</th>
                        <th style="padding:8px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Cantidad</th>
                        <th style="padding:8px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Unidad</th>
                        <th style="padding:8px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Notas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tratamiento->zonas as $zona)
                    <tr style="border-top:1px solid #f1f5f9;">
                        <td style="padding:10px 16px;font-weight:600;">{{ $zona->zona_label ?: $zona->zona }}</td>
                        <td style="padding:10px 16px;">
                            <span style="background:{{ $zona->tipo==='libre'?'#fef3c7':'#f1f5f9' }};color:{{ $zona->tipo==='libre'?'#d97706':'#64748b' }};font-size:11px;font-weight:600;padding:2px 8px;border-radius:5px;">
                                {{ $zona->tipo==='libre' ? 'Punto libre' : 'Predefinida' }}
                            </span>
                        </td>
                        <td style="padding:10px 16px;">{{ $zona->cantidad ?? '—' }}</td>
                        <td style="padding:10px 16px;color:#64748b;">{{ $zona->unidad ?? '—' }}</td>
                        <td style="padding:10px 16px;color:#64748b;">{{ $zona->notas ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

    </div>

    {{-- COLUMNA LATERAL --}}
    <div style="display:flex;flex-direction:column;gap:14px;">

        {{-- ESTADO FIRMA PACIENTE --}}
        @if($tratamiento->firma_paciente)
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:13px;padding:16px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                <i class="fas fa-check-circle" style="color:#16a34a;font-size:14px;"></i>
                <span style="font-size:12px;font-weight:700;color:#166534;">Paciente firmó el consentimiento</span>
            </div>
            @if($tratamiento->firma_paciente_at)
            <p style="font-size:11px;color:#64748b;margin-bottom:8px;">
                {{ \Carbon\Carbon::parse($tratamiento->firma_paciente_at)->format('d/m/Y H:i') }}
            </p>
            @endif
            <img src="{{ $tratamiento->firma_paciente }}"
                 style="max-height:50px;max-width:100%;border:1px solid #bbf7d0;border-radius:6px;padding:3px;background:#fff;display:block;">
        </div>
        @endif

        {{-- MAPA --}}
        @if((int)($tratamiento->mapa_activo ?? 1) === 1)
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:16px;text-align:center;">
            <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:10px;">Mapa de zonas</div>
            <svg viewBox="0 0 200 290" width="100%" style="max-width:200px;" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="100" cy="132" rx="64" ry="84" fill="#fdf8ee" stroke="#3d2010" stroke-width="1.5"/>
                <path d="M82 208 L80 240 Q100 248 120 240 L118 208" fill="#fdf8ee" stroke="#3d2010" stroke-width="1.2"/>
                <path d="M36 95 Q38 65 60 48 Q80 34 100 32 Q120 34 140 48 Q162 65 164 95 Q152 68 100 66 Q48 68 36 95 Z" fill="#2c1408"/>
                <ellipse cx="36" cy="132" rx="9" ry="15" fill="#fdf0d8" stroke="#3d2010" stroke-width="1.2"/>
                <ellipse cx="164" cy="132" rx="9" ry="15" fill="#fdf0d8" stroke="#3d2010" stroke-width="1.2"/>
                <path d="M62 102 Q75 96 90 100" stroke="#2c1408" stroke-width="2" stroke-linecap="round"/>
                <path d="M110 100 Q125 96 138 102" stroke="#2c1408" stroke-width="2" stroke-linecap="round"/>
                <ellipse cx="76" cy="118" rx="14" ry="9" fill="#fdf8ee" stroke="#2c1408" stroke-width="1.2"/>
                <ellipse cx="124" cy="118" rx="14" ry="9" fill="#fdf8ee" stroke="#2c1408" stroke-width="1.2"/>
                <circle cx="76" cy="118" r="6" fill="#1a0a04"/>
                <circle cx="124" cy="118" r="6" fill="#1a0a04"/>
                <circle cx="74" cy="116" r="2" fill="white"/>
                <circle cx="122" cy="116" r="2" fill="white"/>
                <path d="M80 170 Q100 182 120 170" fill="#c08878" stroke="#3d2010" stroke-width="0.8"/>
                <path d="M80 170 Q100 164 120 170" fill="#a06858" stroke="#3d2010" stroke-width="0.8"/>
                @foreach($coordsZonas as $key => $coords)
                @if(in_array($key, $zonasActivas))
                <circle cx="{{ $coords[0] }}" cy="{{ $coords[1] }}" r="7" fill="#9333ea" opacity="0.9"/>
                <text x="{{ $coords[0] }}" y="{{ $coords[1]+4 }}" text-anchor="middle" font-size="7" fill="white" font-weight="700">{{ $key }}</text>
                @else
                <circle cx="{{ $coords[0] }}" cy="{{ $coords[1] }}" r="5" fill="#e2e8f0" opacity="0.7"/>
                @endif
                @endforeach
                @foreach($tratamiento->zonasLibres as $pl)
                <circle cx="{{ $pl->coord_x }}" cy="{{ $pl->coord_y }}" r="9" fill="{{ $pl->color ?? '#9333ea' }}" opacity="0.2"/>
                <circle cx="{{ $pl->coord_x }}" cy="{{ $pl->coord_y }}" r="5.5" fill="{{ $pl->color ?? '#9333ea' }}" stroke="white" stroke-width="1.2"/>
                @if($pl->zona_label)
                <text x="{{ $pl->coord_x+8 }}" y="{{ $pl->coord_y-5 }}" font-size="7" fill="{{ $pl->color ?? '#9333ea' }}" font-weight="700">{{ $pl->zona_label }}</text>
                @endif
                @endforeach
            </svg>
        </div>
        @elseif($tratamiento->zonas_texto)
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:16px;">
            <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:10px;">Zonas a aplicar</div>
            <p style="font-size:13px;color:#374151;line-height:1.6;">{{ $tratamiento->zonas_texto }}</p>
        </div>
        @endif

        {{-- MÉDICO --}}
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:10px;">Médico responsable</div>
            <div style="display:flex;align-items:center;gap:9px;">
                <div style="width:36px;height:36px;border-radius:50%;background:#f3e8ff;color:#9333ea;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;">
                    {{ strtoupper(substr($tratamiento->medico?->nombre ?? 'M', 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:13px;font-weight:600;">{{ $tratamiento->medico?->nombre }} {{ $tratamiento->medico?->apellidos }}</div>
                    <div style="font-size:11px;color:#64748b;">Céd. {{ $tratamiento->medico?->cedula_profesional ?? '—' }}</div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- MODAL DE FIRMA — solo si el consentimiento NO está bloqueado --}}
@if(!$tratamiento->consentimiento_bloqueado)
<div id="modalFirma" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:16px;padding:1.5rem;width:95vw;max-width:680px;box-shadow:0 20px 60px rgba(0,0,0,0.3);">

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
            <div>
                <h3 style="font-size:1rem;font-weight:700;color:#0f172a;margin:0;">Firma del Paciente</h3>
                <p style="font-size:0.8rem;color:#64748b;margin-top:0.2rem;">
                    {{ $tratamiento->paciente?->nombre }} {{ $tratamiento->paciente?->apellidos }}
                </p>
            </div>
            <button onclick="cerrarFirma()" style="background:#f1f5f9;border:none;border-radius:8px;width:32px;height:32px;cursor:pointer;font-size:1rem;color:#64748b;">✕</button>
        </div>

        @if($tratamiento->firma_paciente)
        <div style="margin-bottom:1rem;padding:0.75rem;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;display:flex;align-items:center;gap:0.75rem;">
            <i class="fas fa-check-circle" style="color:#16a34a;"></i>
            <div>
                <p style="font-size:0.8rem;font-weight:600;color:#166534;margin:0;">Paciente ya firmó</p>
                <p style="font-size:0.75rem;color:#64748b;margin:0;">
                    {{ $tratamiento->firma_paciente_at ? \Carbon\Carbon::parse($tratamiento->firma_paciente_at)->format('d/m/Y H:i') : '' }}
                </p>
            </div>
            <img src="{{ $tratamiento->firma_paciente }}" style="height:40px;margin-left:auto;border:1px solid #e2e8f0;border-radius:6px;padding:2px;background:#fff;">
        </div>
        @endif

        <div style="border:2px solid #e2e8f0;border-radius:10px;overflow:hidden;margin-bottom:1rem;">
            <div style="background:#f8fafc;padding:0.4rem 0.75rem;border-bottom:1px solid #e2e8f0;display:flex;justify-content:space-between;align-items:center;">
                <span style="font-size:0.75rem;color:#64748b;">Firme en el área de abajo</span>
                <button onclick="limpiarFirma()" style="background:#fee2e2;color:#dc2626;border:none;border-radius:6px;padding:0.25rem 0.6rem;font-size:0.72rem;font-weight:600;cursor:pointer;">
                    <i class="fas fa-trash"></i> Limpiar
                </button>
            </div>
            <canvas id="canvasFirma" style="display:block;width:100%;height:220px;cursor:crosshair;touch-action:none;background:#fff;"></canvas>
        </div>

        <div style="display:flex;gap:0.75rem;justify-content:flex-end;">
            <button onclick="cerrarFirma()" style="background:#f1f5f9;color:#475569;border:none;padding:0.6rem 1.25rem;border-radius:8px;font-size:0.875rem;font-weight:600;cursor:pointer;">
                Cancelar
            </button>
            <button id="btnGuardarFirma" onclick="guardarFirma()"
                style="background:#7c3aed;color:#fff;border:none;padding:0.6rem 1.5rem;border-radius:8px;font-size:0.875rem;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:0.5rem;"
                onmouseover="this.style.background='#6d28d9'"
                onmouseout="this.style.background='#7c3aed'">
                <i class="fas fa-save"></i> Guardar firma
            </button>
        </div>
    </div>
</div>

<script>
(function() {
    const RUTA_GUARDAR = "{{ route('medico.tratamientos-esteticos.firma-paciente', $tratamiento) }}";
    const CSRF = "{{ csrf_token() }}";
    let canvas, ctx, dibujando = false, ultimoX, ultimoY;

    function init() {
        canvas = document.getElementById('canvasFirma');
        const rect = canvas.getBoundingClientRect();
        canvas.width  = rect.width  || 640;
        canvas.height = rect.height || 220;
        ctx = canvas.getContext('2d');
        ctx.strokeStyle = '#1e293b';
        ctx.lineWidth   = 2.5;
        ctx.lineCap     = 'round';
        ctx.lineJoin    = 'round';

        canvas.addEventListener('mousedown',  e => { dibujando = true; [ultimoX, ultimoY] = getPos(e); });
        canvas.addEventListener('mousemove',  e => { if (dibujando) dibujar(e); });
        canvas.addEventListener('mouseup',    () => dibujando = false);
        canvas.addEventListener('mouseleave', () => dibujando = false);
        canvas.addEventListener('touchstart', e => { e.preventDefault(); dibujando = true; [ultimoX, ultimoY] = getPos(e.touches[0]); }, { passive: false });
        canvas.addEventListener('touchmove',  e => { e.preventDefault(); if (dibujando) dibujar(e.touches[0]); }, { passive: false });
        canvas.addEventListener('touchend',   () => dibujando = false);
    }

    function getPos(e) {
        const r = canvas.getBoundingClientRect();
        return [
            (e.clientX - r.left) * (canvas.width  / r.width),
            (e.clientY - r.top)  * (canvas.height / r.height)
        ];
    }

    function dibujar(e) {
        const [x, y] = getPos(e);
        ctx.beginPath();
        ctx.moveTo(ultimoX, ultimoY);
        ctx.lineTo(x, y);
        ctx.stroke();
        [ultimoX, ultimoY] = [x, y];
    }

    window.abrirFirma = function() {
        document.getElementById('modalFirma').style.display = 'flex';
        setTimeout(init, 50);
    };

    window.cerrarFirma = function() {
        document.getElementById('modalFirma').style.display = 'none';
    };

    window.limpiarFirma = function() {
        if (ctx) ctx.clearRect(0, 0, canvas.width, canvas.height);
    };

    window.guardarFirma = async function() {
        if (!canvas) return;
        const pixeles = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
        if (!pixeles.some((v, i) => i % 4 === 3 && v > 0)) {
            alert('Por favor dibuja tu firma antes de guardar.');
            return;
        }
        const base64 = canvas.toDataURL('image/png');
        const btn = document.getElementById('btnGuardarFirma');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        try {
            const res = await fetch(RUTA_GUARDAR, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ firma_paciente: base64 })
            });
            const data = await res.json();
            if (data.success) {
                cerrarFirma();
                location.reload();
            } else {
                alert(data.error ?? 'Error al guardar la firma.');
            }
        } catch(e) {
            alert('Error de conexión.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save"></i> Guardar firma';
        }
    };
})();
</script>
@endif

@endsection