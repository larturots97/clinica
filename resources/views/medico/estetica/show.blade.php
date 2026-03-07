@extends('layouts.medico')
@section('titulo', 'Tratamiento Estético')
@section('contenido')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
    <a href="{{ route('medico.pacientes.show', $tratamientoEstetico->paciente) }}" style="color:#94a3b8;text-decoration:none;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h3 class="font-serif" style="font-size:21px;">Tratamiento Estético</h3>
    <span style="font-size:12px;color:#64748b;background:#f1f5f9;padding:3px 9px;border-radius:6px;">
        {{ \Carbon\Carbon::parse($tratamientoEstetico->fecha)->format('d/m/Y') }}
    </span>
</div>

<div style="display:grid;grid-template-columns:1fr 300px;gap:18px;">
    <div style="display:flex;flex-direction:column;gap:14px;">

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:13px;font-weight:700;margin-bottom:16px;">Mapa Facial</h4>
            <div style="display:flex;justify-content:center;">
                @php
                $zonaCoords = [
                    'frente'          => ['cx'=>100,'cy'=>82,'rx'=>55,'ry'=>22],
                    'entrecejo'       => ['cx'=>100,'cy'=>107,'rx'=>18,'ry'=>10],
                    'patas_gallo_izq' => ['cx'=>52,'cy'=>115,'rx'=>18,'ry'=>12],
                    'patas_gallo_der' => ['cx'=>148,'cy'=>115,'rx'=>18,'ry'=>12],
                    'mejilla_izq'     => ['cx'=>58,'cy'=>148,'rx'=>22,'ry'=>18],
                    'mejilla_der'     => ['cx'=>142,'cy'=>148,'rx'=>22,'ry'=>18],
                    'nariz'           => ['cx'=>100,'cy'=>138,'rx'=>14,'ry'=>16],
                    'labios'          => ['cx'=>100,'cy'=>170,'rx'=>22,'ry'=>12],
                    'menton'          => ['cx'=>100,'cy'=>192,'rx'=>22,'ry'=>14],
                    'cuello'          => ['cx'=>100,'cy'=>232,'rx'=>22,'ry'=>18],
                    'mandibula_izq'   => ['cx'=>42,'cy'=>175,'rx'=>18,'ry'=>14],
                    'mandibula_der'   => ['cx'=>158,'cy'=>175,'rx'=>18,'ry'=>14],
                ];
                @endphp
                <svg viewBox="0 0 200 320" width="220" height="320">
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
                    @foreach($tratamientoEstetico->zonas as $zona)
                        @if(isset($zonaCoords[$zona->zona]))
                            @php $c = $zonaCoords[$zona->zona]; @endphp
                            <ellipse cx="{{ $c['cx'] }}" cy="{{ $c['cy'] }}" rx="{{ $c['rx'] }}" ry="{{ $c['ry'] }}" fill="rgba(147,51,234,0.25)" stroke="#9333ea" stroke-width="2"/>
                            <text x="{{ $c['cx'] }}" y="{{ $c['cy'] + 3 }}" text-anchor="middle" font-size="6" fill="#7c3aed" font-weight="bold">{{ $zona->zona_label }}</text>
                        @endif
                    @endforeach
                </svg>
            </div>
        </div>

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;">Zonas Tratadas</h4>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">
                @foreach($tratamientoEstetico->zonas as $zona)
                <div style="background:#f3e8ff;border-radius:10px;padding:12px;">
                    <div style="font-size:12px;font-weight:700;color:#9333ea;margin-bottom:5px;">{{ $zona->zona_label }}</div>
                    @if($zona->producto)
                    <div style="font-size:11px;color:#64748b;">{{ $zona->producto->nombre }}</div>
                    <div style="font-size:11px;color:#64748b;">{{ $zona->cantidad }} {{ $zona->unidad }}</div>
                    @endif
                    @if($zona->notas)
                    <div style="font-size:11px;color:#94a3b8;margin-top:4px;font-style:italic;">{{ $zona->notas }}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

    </div>

    <div style="display:flex;flex-direction:column;gap:14px;">
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:12px;">Información</h4>
            <div style="display:flex;flex-direction:column;gap:8px;font-size:13px;">
                <div style="display:flex;justify-content:space-between;">
                    <span style="color:#64748b;">Paciente:</span>
                    <span style="font-weight:600;">{{ $tratamientoEstetico->paciente->nombre_completo }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="color:#64748b;">Fecha:</span>
                    <span style="font-weight:600;">{{ \Carbon\Carbon::parse($tratamientoEstetico->fecha)->format('d/m/Y') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="color:#64748b;">Título:</span>
                    <span style="font-weight:600;">{{ $tratamientoEstetico->titulo ?? '—' }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="color:#64748b;">Zonas:</span>
                    <span style="font-weight:600;">{{ $tratamientoEstetico->zonas->count() }}</span>
                </div>
            </div>
            @if($tratamientoEstetico->observaciones_generales)
            <div style="margin-top:12px;padding-top:12px;border-top:1px solid #f1f5f9;">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:5px;">Observaciones</div>
                <div style="font-size:13px;color:#1e293b;">{{ $tratamientoEstetico->observaciones_generales }}</div>
            </div>
            @endif
        </div>

        <a href="{{ route('medico.pacientes.show', $tratamientoEstetico->paciente) }}"
            style="display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:9px;font-size:13px;font-weight:600;background:#f3e8ff;color:#9333ea;text-decoration:none;">
            <i class="fa-solid fa-user"></i> Ver expediente
        </a>
    </div>
</div>

@endsection
