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

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
    <a href="{{ route('medico.tratamientos-esteticos.index') }}" style="color:#94a3b8;text-decoration:none;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h3 class="font-serif" style="font-size:21px;">{{ $tratamiento->titulo ?? $tratamiento->tipoTratamiento?->nombre }}</h3>
    @if($tratamiento->grupo)
    <span style="background:{{ $grupoBg[$tratamiento->grupo] ?? '#f1f5f9' }};color:{{ $grupoColors[$tratamiento->grupo] ?? '#64748b' }};font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
        Grupo {{ $tratamiento->grupo }} — {{ $grupoNombres[$tratamiento->grupo] ?? '' }}
    </span>
    @endif
    <a href="{{ route('medico.tratamientos-esteticos.pdf', $tratamiento) }}" target="_blank"
        style="margin-left:auto;display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:13px;font-weight:600;background:#9333ea;color:white;text-decoration:none;">
        <i class="fa-solid fa-file-pdf"></i> PDF
    </a>
</div>

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

        {{-- MAPA --}}
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

@endsection
