@extends('layouts.medico')

@section('titulo', $paciente->nombre_completo)

@section('contenido')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
    <a href="{{ route('medico.pacientes.index') }}"
        style="color:#94a3b8;text-decoration:none;display:flex;align-items:center;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h3 class="font-serif" style="font-size:21px;">{{ $paciente->nombre_completo }}</h3>
    <span style="font-family:monospace;font-size:12px;color:#64748b;background:#f1f5f9;padding:3px 9px;border-radius:6px;">{{ $paciente->expediente }}</span>
</div>

<!-- ACCIONES RÁPIDAS DEL PACIENTE -->
<div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap;">
    <a href="{{ route('medico.pacientes.edit', $paciente) }}"
        style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;background:#e0f2fe;color:#0284c7;text-decoration:none;">
        <i class="fa-solid fa-pen-to-square"></i> Editar paciente
    </a>
    <a href="{{ route('medico.historial.create', ['paciente_id' => $paciente->id]) }}"
        style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;background:#ffe4e6;color:#e11d48;text-decoration:none;">
        <i class="fa-solid fa-file-medical"></i> Nueva consulta
    </a>
    <a href="#"
        style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;background:#ede9fe;color:#7c3aed;text-decoration:none;">
        <i class="fa-solid fa-prescription"></i> Nueva receta
    </a>
    <a href="#"
        style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;background:#d1fae5;color:#059669;text-decoration:none;">
        <i class="fa-solid fa-credit-card"></i> Nuevo pago
    </a>
    @if($esMedicoEstetico)
    <a href="{{ route('medico.tratamientos-esteticos.create', ['paciente_id' => $paciente->id]) }}"
        style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;background:#fef3c7;color:#92400e;text-decoration:none;">
        <i class="fa-solid fa-wand-magic-sparkles"></i> Nuevo tratamiento
    </a>
    @endif
</div>

<div style="display:grid;grid-template-columns:280px 1fr;gap:18px;">

    <!-- Columna izquierda: datos del paciente -->
    <div style="display:flex;flex-direction:column;gap:14px;">

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;text-align:center;">
            <div style="width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,#0ea5a0,#0891b2);color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:22px;margin:0 auto 12px;">
                {{ strtoupper(substr($paciente->nombre, 0, 1)) }}
            </div>
            <h4 style="font-weight:700;font-size:15px;color:#1e293b;">{{ $paciente->nombre_completo }}</h4>
            <p style="font-size:12px;color:#64748b;margin-top:3px;">{{ $paciente->expediente }}</p>
        </div>

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin:0;">Datos personales</h4>
                <a href="{{ route('medico.pacientes.edit', $paciente) }}"
                    style="font-size:11px;color:#0284c7;text-decoration:none;font-weight:600;">
                    <i class="fa-solid fa-pen-to-square" style="font-size:10px;"></i> Editar
                </a>
            </div>
            <div style="display:flex;flex-direction:column;gap:8px;font-size:13px;">
                @if($paciente->fecha_nacimiento)
                <div style="display:flex;justify-content:space-between;">
                    <span style="color:#64748b;">Edad:</span>
                    <span style="font-weight:600;">{{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años</span>
                </div>
                @endif
                @if($paciente->telefono)
                <div style="display:flex;justify-content:space-between;">
                    <span style="color:#64748b;">Teléfono:</span>
                    <span style="font-weight:600;">{{ $paciente->telefono }}</span>
                </div>
                @endif
                @if($paciente->email)
                <div style="display:flex;justify-content:space-between;">
                    <span style="color:#64748b;">Email:</span>
                    <span style="font-weight:600;font-size:12px;">{{ $paciente->email }}</span>
                </div>
                @endif
                @if($paciente->tipo_sangre)
                <div style="display:flex;justify-content:space-between;">
                    <span style="color:#64748b;">Tipo sangre:</span>
                    <span style="font-weight:700;color:#e11d48;">{{ $paciente->tipo_sangre }}</span>
                </div>
                @endif
                @if($paciente->alergias)
                <div style="margin-top:4px;">
                    <span style="color:#64748b;display:block;margin-bottom:3px;">Alergias:</span>
                    <span style="background:#fee2e2;color:#991b1b;padding:4px 8px;border-radius:6px;font-size:12px;display:block;">{{ $paciente->alergias }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Stats rápidos -->
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:12px;">Resumen</h4>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                <div style="background:#ffe4e6;border-radius:9px;padding:10px;text-align:center;">
                    <div style="font-size:18px;font-weight:700;color:#e11d48;">{{ $paciente->historiales->count() }}</div>
                    <div style="font-size:10px;color:#9f1239;margin-top:2px;">Consultas</div>
                </div>
                <div style="background:#ede9fe;border-radius:9px;padding:10px;text-align:center;">
                    <div style="font-size:18px;font-weight:700;color:#7c3aed;">{{ $paciente->recetas->count() }}</div>
                    <div style="font-size:10px;color:#5b21b6;margin-top:2px;">Recetas</div>
                </div>
                <div style="background:#fef3c7;border-radius:9px;padding:10px;text-align:center;">
                    <div style="font-size:18px;font-weight:700;color:#d97706;">{{ $paciente->citas->count() }}</div>
                    <div style="font-size:10px;color:#92400e;margin-top:2px;">Citas</div>
                </div>
                @if($esMedicoEstetico)
                <div style="background:#f3e8ff;border-radius:9px;padding:10px;text-align:center;">
                    <div style="font-size:18px;font-weight:700;color:#9333ea;">{{ count($tratamientos) }}</div>
                    <div style="font-size:10px;color:#6b21a8;margin-top:2px;">Tratamientos</div>
                </div>
                @endif
            </div>
        </div>

    </div>

    <!-- Columna derecha: historial, recetas, tratamientos -->
    <div style="display:flex;flex-direction:column;gap:14px;">

        <!-- Historial clínico -->
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
            <div style="padding:14px 18px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:13px;font-weight:600;display:flex;align-items:center;gap:7px;">
                    <span style="width:26px;height:26px;border-radius:7px;background:#ffe4e6;color:#e11d48;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-file-medical" style="font-size:11px;"></i>
                    </span>
                    Historial Clínico
                </span>
                <a href="{{ route('medico.historial.create', ['paciente_id' => $paciente->id]) }}"
                    style="font-size:12px;color:#0ea5a0;font-weight:500;text-decoration:none;">
                    + Nueva consulta
                </a>
            </div>
            @forelse($paciente->historiales->take(3) as $historial)
            <div style="padding:12px 18px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:11px;">
                <div style="min-width:56px;text-align:center;">
                    <div style="font-size:12px;font-weight:700;color:#64748b;">{{ \Carbon\Carbon::parse($historial->fecha)->format('d/m/Y') }}</div>
                </div>
                <div style="flex:1;">
                    <div style="font-size:13px;font-weight:600;">{{ $historial->motivo_consulta }}</div>
                    <div style="font-size:11px;color:#64748b;margin-top:1px;">{{ Str::limit($historial->diagnostico, 60) }}</div>
                </div>
                <a href="{{ route('medico.historial.show', $historial) }}"
                    style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#d1fae5;color:#059669;text-decoration:none;">
                    Ver
                </a>
            </div>
            @empty
            <div style="padding:24px;text-align:center;color:#94a3b8;font-size:12px;">
                Sin consultas registradas
            </div>
            @endforelse
        </div>

        <!-- Recetas -->
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
            <div style="padding:14px 18px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:13px;font-weight:600;display:flex;align-items:center;gap:7px;">
                    <span style="width:26px;height:26px;border-radius:7px;background:#ede9fe;color:#7c3aed;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-prescription" style="font-size:11px;"></i>
                    </span>
                    Recetas
                </span>
                <a href="#"
                    style="font-size:12px;color:#0ea5a0;font-weight:500;text-decoration:none;">
                    + Nueva receta
                </a>
            </div>
            @forelse($paciente->recetas->take(3) as $receta)
            <div style="padding:12px 18px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:11px;">
                <span style="background:#ede9fe;color:#7c3aed;font-size:11px;font-weight:700;padding:4px 10px;border-radius:7px;font-family:monospace;">{{ $receta->folio }}</span>
                <div style="flex:1;">
                    <div style="font-size:12px;color:#64748b;">{{ \Carbon\Carbon::parse($receta->fecha)->format('d/m/Y') }}</div>
                    <div style="font-size:11px;color:#64748b;">{{ $receta->items->count() }} medicamento(s)</div>
                </div>
                <a href="{{ route('recetas.pdf', $receta) }}" target="_blank"
                    style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#d1fae5;color:#059669;text-decoration:none;">
                    PDF
                </a>
            </div>
            @empty
            <div style="padding:24px;text-align:center;color:#94a3b8;font-size:12px;">
                Sin recetas registradas
            </div>
            @endforelse
        </div>

        <!-- Historial de Tratamientos -->
        @if($esMedicoEstetico)
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
            <div style="padding:14px 18px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:13px;font-weight:600;display:flex;align-items:center;gap:7px;">
                    <span style="width:26px;height:26px;border-radius:7px;background:#fef3c7;color:#b45309;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-file-waveform" style="font-size:11px;"></i>
                    </span>
                    Historial de Tratamientos
                </span>
                <a href="{{ route('medico.tratamientos-esteticos.create', ['paciente_id' => $paciente->id]) }}"
                    style="font-size:12px;color:#0ea5a0;font-weight:500;text-decoration:none;">
                    + Nuevo tratamiento
                </a>
            </div>
            <div style="max-height:280px;overflow-y:auto;">
                @forelse($tratamientos as $trat)
                <div style="padding:11px 18px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:11px;">
                    @php
                        $grupoColors = [
                            'A' => ['bg'=>'#fef3c7','color'=>'#92400e','label'=>'Neuromo.'],
                            'B' => ['bg'=>'#dbeafe','color'=>'#1e40af','label'=>'Rellenos'],
                            'C' => ['bg'=>'#d1fae5','color'=>'#065f46','label'=>'Bioest.'],
                            'D' => ['bg'=>'#fee2e2','color'=>'#991b1b','label'=>'Lipolít.'],
                            'E' => ['bg'=>'#f3e8ff','color'=>'#6b21a8','label'=>'Piel'],
                        ];
                        $gc = $grupoColors[$trat->grupo] ?? ['bg'=>'#f1f5f9','color'=>'#475569','label'=>$trat->grupo];
                    @endphp
                    <div style="min-width:56px;text-align:center;">
                        <div style="font-size:11px;font-weight:700;color:#64748b;">{{ \Carbon\Carbon::parse($trat->fecha)->format('d/m/Y') }}</div>
                        <span style="display:inline-block;margin-top:3px;padding:2px 6px;border-radius:5px;font-size:9px;font-weight:700;background:{{ $gc['bg'] }};color:{{ $gc['color'] }};">
                            {{ $gc['label'] }}
                        </span>
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:13px;font-weight:600;color:#1e293b;">{{ $trat->titulo ?? 'Historia clínica estética' }}</div>
                        <div style="font-size:11px;color:#64748b;margin-top:1px;display:flex;align-items:center;gap:8px;">
                            <span><i class="fa-solid fa-location-dot" style="font-size:9px;"></i> {{ $trat->zonas->count() }} zona(s)</span>
                            @if($trat->producto_marca)
                            <span style="color:#b45309;"><i class="fa-solid fa-flask" style="font-size:9px;"></i> {{ $trat->producto_marca }}</span>
                            @endif
                            @if($trat->sesion_numero)
                            <span>Sesión {{ $trat->sesion_numero }}</span>
                            @endif
                        </div>
                    </div>
                    <div style="display:flex;gap:5px;align-items:center;">
                        <a href="{{ route('medico.tratamientos-esteticos.show', $trat) }}"
                            style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#fef3c7;color:#92400e;text-decoration:none;">
                            Historia clínica
                        </a>
                        <a href="{{ route('medico.tratamientos-esteticos.pdf', $trat) }}" target="_blank"
                            style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#f1f5f9;color:#475569;text-decoration:none;">
                            PDF
                        </a>
                    </div>
                </div>
                @empty
                <div style="padding:24px;text-align:center;color:#94a3b8;font-size:12px;">
                    Sin historias clínicas estéticas registradas
                </div>
                @endforelse
            </div>
        </div>
        @endif

    </div>
</div>

@endsection