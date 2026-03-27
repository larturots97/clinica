@extends('layouts.medico')

@section('titulo', $paciente->nombre_completo)

@section('contenido')

@php
$fitzLabels = [1=>'Muy clara',2=>'Clara',3=>'Media',4=>'Morena',5=>'Oscura',6=>'Negra'];
$fitzColors = [1=>'#fde8d8',2=>'#f5c9a0',3=>'#e8a87c',4=>'#c47c4a',5=>'#8b4513',6=>'#3d1c02'];
$antecedentesLabels = [
    'embarazo_lactancia' => 'Embarazo o lactancia',
    'enf_neuromuscular'  => 'Enf. neuromuscular',
    'medicacion_actual'  => 'Medicacion actual',
    'cirugias_previas'   => 'Cirugias previas',
    'tabaco_alcohol'     => 'Consumo tabaco/alcohol',
];
@endphp

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
    <a href="{{ route('medico.pacientes.index') }}" style="color:#94a3b8;text-decoration:none;"><i class="fa-solid fa-arrow-left"></i></a>
    <h3 class="font-serif" style="font-size:21px;">{{ $paciente->nombre_completo }}</h3>
    <span style="font-family:monospace;font-size:12px;color:#64748b;background:#f1f5f9;padding:3px 9px;border-radius:6px;">{{ $paciente->numero_expediente ?? $paciente->expediente }}</span>
</div>

<!-- ACCIONES RAPIDAS -->
<div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap;align-items:center;justify-content:space-between;">
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <a href="{{ route('medico.pacientes.edit', $paciente) }}"
            style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;background:#e0f2fe;color:#0284c7;text-decoration:none;">
            <i class="fa-solid fa-pen-to-square"></i> Editar paciente
        </a>
        <a href="{{ route('medico.historial.create', ['paciente_id' => $paciente->id]) }}"
            style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;background:#ffe4e6;color:#e11d48;text-decoration:none;">
            <i class="fa-solid fa-file-medical"></i> Nueva consulta
        </a>
        <a href="{{ route('medico.recetas.create', ['paciente_id' => $paciente->id]) }}"
            style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;background:#ede9fe;color:#7c3aed;text-decoration:none;">
            <i class="fa-solid fa-prescription"></i> Nueva receta
        </a>
        <a href="{{ route('medico.pagos.create', ['paciente_id' => $paciente->id]) }}"
            style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;background:#d1fae5;color:#059669;text-decoration:none;">
            <i class="fa-solid fa-credit-card"></i> Nuevo pago
        </a>
        @if($esMedicoEstetico)
        <a href="{{ route('medico.tratamientos-esteticos.create', ['paciente_id' => $paciente->id]) }}"
            style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;background:#fef3c7;color:#92400e;text-decoration:none;">
            <i class="fa-solid fa-wand-magic-sparkles"></i> Nuevo tratamiento
        </a>
        @endif
        <form action="{{ route('medico.pacientes.destroy', $paciente) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            {{-- BOTÓN que abre el modal --}}
            <button type="button"
                onclick="document.getElementById('modal-eliminar').style.display='flex'"
                style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;background:#fee2e2;color:#dc2626;border:none;cursor:pointer;font-family:inherit;">
                <i class="fa-solid fa-trash"></i> Eliminar paciente
            </button>
        </form>
    </div>

    <button onclick="document.getElementById('modal-expediente').style.display='flex'"
        style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:8px;font-size:12px;font-weight:600;background:#9cfdb9;color:#16a34a;border:1.5px solid #00f455;cursor:pointer;font-family:inherit;">
        <i class="fa-solid fa-id-card"></i> Ver expediente
    </button>
</div>

<!-- MODAL EXPEDIENTE COMPLETO -->
<div id="modal-expediente" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:1000;align-items:center;justify-content:center;padding:20px;">
    <div style="background:white;border-radius:16px;width:100%;max-width:700px;max-height:90vh;overflow-y:auto;box-shadow:0 25px 60px rgba(0,0,0,.25);">

        <!-- Header -->
        <div style="padding:18px 22px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;background:white;z-index:1;border-radius:16px 16px 0 0;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#0ea5a0,#0891b2);color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:16px;">
                    {{ strtoupper(substr($paciente->nombre, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:15px;font-weight:700;color:#1e293b;">{{ $paciente->nombre_completo }}</div>
                    <div style="font-size:11px;color:#94a3b8;font-family:monospace;">{{ $paciente->numero_expediente ?? $paciente->expediente }}</div>
                </div>
            </div>
            <button onclick="document.getElementById('modal-expediente').style.display='none'"
                style="width:32px;height:32px;border-radius:8px;background:#f1f5f9;border:none;cursor:pointer;font-size:16px;color:#64748b;">✕</button>
        </div>

        <div style="padding:22px;display:flex;flex-direction:column;gap:18px;">

            <!-- DATOS PERSONALES -->
            <div style="background:#f8fafc;border-radius:12px;padding:16px;">
                <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;margin-bottom:12px;">
                    <i class="fa-solid fa-user" style="color:#0ea5a0;margin-right:5px;"></i> Datos Personales
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:13px;">
                    <div>
                        <span style="color:#94a3b8;font-size:11px;display:block;">Nombre completo</span>
                        <span style="font-weight:600;color:#1e293b;">{{ $paciente->nombre }} {{ $paciente->apellidos }}</span>
                    </div>
                    <div>
                        <span style="color:#94a3b8;font-size:11px;display:block;">Fecha de nacimiento</span>
                        <span style="font-weight:600;color:#1e293b;">
                            @if($paciente->fecha_nacimiento)
                                {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años)
                            @else — @endif
                        </span>
                    </div>
                    <div>
                        <span style="color:#94a3b8;font-size:11px;display:block;">Genero</span>
                        <span style="font-weight:600;color:#1e293b;">{{ ucfirst($paciente->genero ?? '—') }}</span>
                    </div>
                    <div>
                        <span style="color:#94a3b8;font-size:11px;display:block;">Telefono</span>
                        <span style="font-weight:600;color:#1e293b;">{{ $paciente->telefono ?? '—' }}</span>
                    </div>
                    <div>
                        <span style="color:#94a3b8;font-size:11px;display:block;">Correo electronico</span>
                        <span style="font-weight:600;color:#1e293b;font-size:12px;">{{ $paciente->email ?? '—' }}</span>
                    </div>
                    <div>
                        <span style="color:#94a3b8;font-size:11px;display:block;">Tipo de sangre</span>
                        <span style="font-weight:700;color:#e11d48;">{{ $paciente->tipo_sangre ?? '—' }}</span>
                    </div>
                    @if($paciente->ocupacion)
                    <div>
                        <span style="color:#94a3b8;font-size:11px;display:block;">Ocupacion</span>
                        <span style="font-weight:600;color:#1e293b;">{{ $paciente->ocupacion }}</span>
                    </div>
                    @endif
                    @if($paciente->direccion)
                    <div style="grid-column:span 2;">
                        <span style="color:#94a3b8;font-size:11px;display:block;">Direccion</span>
                        <span style="font-weight:600;color:#1e293b;">{{ $paciente->direccion }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- ANTECEDENTES -->
            <div style="background:#f8fafc;border-radius:12px;padding:16px;">
                <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;margin-bottom:12px;">
                    <i class="fa-solid fa-notes-medical" style="color:#0ea5a0;margin-right:5px;"></i> Antecedentes Medicos
                </div>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @if($paciente->alergias)
                    <div>
                        <span style="color:#94a3b8;font-size:11px;display:block;margin-bottom:3px;">Alergias</span>
                        <span style="background:#fee2e2;color:#991b1b;padding:5px 10px;border-radius:7px;font-size:12px;display:block;">{{ $paciente->alergias }}</span>
                    </div>
                    @endif
                    @if($paciente->antecedentes)
                    <div>
                        <span style="color:#94a3b8;font-size:11px;display:block;margin-bottom:3px;">Antecedentes patologicos</span>
                        <span style="background:#f1f5f9;color:#374151;padding:5px 10px;border-radius:7px;font-size:12px;display:block;">{{ $paciente->antecedentes }}</span>
                    </div>
                    @endif
                    @if($paciente->antecedentes_extra && count((array)$paciente->antecedentes_extra) > 0)
                    <div>
                        <span style="color:#94a3b8;font-size:11px;display:block;margin-bottom:6px;">Antecedentes adicionales</span>
                        @foreach($antecedentesLabels as $key => $label)
                        <div style="display:flex;align-items:center;justify-content:space-between;font-size:12px;padding:5px 0;border-bottom:1px solid #f1f5f9;">
                            <span style="color:#374151;">{{ $label }}</span>
                            @if(in_array($key, (array)$paciente->antecedentes_extra))
                            <span style="background:#fef3c7;color:#92400e;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700;">Si</span>
                            @else
                            <span style="color:#94a3b8;font-size:11px;">Negado</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- PERFIL DE PIEL -->
            @if($paciente->fitzpatrick || ($paciente->tipo_piel && count((array)$paciente->tipo_piel) > 0) || ($paciente->condiciones_piel && count((array)$paciente->condiciones_piel) > 0) || $paciente->nota_medica)
            <div style="background:#faf5ff;border-radius:12px;padding:16px;border:1px solid #e9d5ff;">
                <div style="font-size:11px;font-weight:700;color:#7c3aed;text-transform:uppercase;letter-spacing:.5px;margin-bottom:12px;">
                    Perfil de Piel
                </div>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @if($paciente->fitzpatrick)
                    <div>
                        <span style="color:#94a3b8;font-size:11px;display:block;margin-bottom:6px;">Fototipo Fitzpatrick</span>
                        <div style="display:flex;gap:5px;">
                            @foreach([1,2,3,4,5,6] as $n)
                            <div style="flex:1;border-radius:7px;padding:6px 3px;text-align:center;border:2px solid {{ $paciente->fitzpatrick == $n ? '#9333ea' : '#e2e8f0' }};background:{{ $paciente->fitzpatrick == $n ? '#faf5ff' : 'white' }};">
                                <div style="width:18px;height:18px;border-radius:50%;background:{{ $fitzColors[$n] }};margin:0 auto 3px;"></div>
                                <div style="font-size:10px;font-weight:700;color:{{ $paciente->fitzpatrick == $n ? '#7c3aed' : '#94a3b8' }};">{{ $n }}</div>
                            </div>
                            @endforeach
                        </div>
                        <div style="font-size:11px;color:#7c3aed;font-weight:600;margin-top:5px;">Tipo {{ $paciente->fitzpatrick }} — {{ $fitzLabels[$paciente->fitzpatrick] ?? '' }}</div>
                    </div>
                    @endif
                    @if($paciente->tipo_piel && count((array)$paciente->tipo_piel) > 0)
                    <div>
                        <span style="color:#94a3b8;font-size:11px;display:block;margin-bottom:5px;">Tipo de piel</span>
                        <div style="display:flex;flex-wrap:wrap;gap:5px;">
                            @foreach((array)$paciente->tipo_piel as $t)
                            <span style="background:#f3e8ff;color:#7c3aed;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:600;">{{ $t }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($paciente->condiciones_piel && count((array)$paciente->condiciones_piel) > 0)
                    <div>
                        <span style="color:#94a3b8;font-size:11px;display:block;margin-bottom:5px;">Condiciones presentes</span>
                        <div style="display:flex;flex-wrap:wrap;gap:5px;">
                            @foreach((array)$paciente->condiciones_piel as $c)
                            <span style="background:#e0f2fe;color:#0369a1;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:600;">{{ $c }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($paciente->nota_medica)
                    <div>
                        <span style="color:#94a3b8;font-size:11px;display:block;margin-bottom:4px;">Nota medica</span>
                        <div style="background:white;border:1px solid #e9d5ff;border-radius:8px;padding:10px 12px;font-size:12px;color:#374151;line-height:1.6;">{{ $paciente->nota_medica }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

        </div>

        <!-- Footer modal -->
        <div style="padding:14px 22px;border-top:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:11px;color:#94a3b8;">Registrado: {{ $paciente->created_at->format('d/m/Y') }}</span>
            <div style="display:flex;gap:8px;">
                <a href="{{ route('medico.pacientes.edit', $paciente) }}"
                    style="padding:8px 16px;background:#e0f2fe;color:#0284c7;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;">
                    <i class="fa-solid fa-pen-to-square" style="margin-right:4px;"></i> Editar
                </a>
                <button onclick="document.getElementById('modal-expediente').style.display='none'"
                    style="padding:8px 16px;background:#f1f5f9;color:#64748b;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('modal-expediente').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>

<div style="display:grid;grid-template-columns:280px 1fr;gap:18px;">

    <!-- Columna izquierda -->
    <div style="display:flex;flex-direction:column;gap:14px;">
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;text-align:center;">
            <div style="width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,#0ea5a0,#0891b2);color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:22px;margin:0 auto 12px;">
                {{ strtoupper(substr($paciente->nombre, 0, 1)) }}
            </div>
            <h4 style="font-weight:700;font-size:15px;color:#1e293b;">{{ $paciente->nombre_completo }}</h4>
            <p style="font-size:12px;color:#64748b;margin-top:3px;">{{ $paciente->numero_expediente ?? $paciente->expediente }}</p>
        </div>

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin:0;">Datos personales</h4>
                <a href="{{ route('medico.pacientes.edit', $paciente) }}" style="font-size:11px;color:#0284c7;text-decoration:none;font-weight:600;">
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
                    <span style="color:#64748b;">Telefono:</span>
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
                @if($paciente->fitzpatrick)
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span style="color:#64748b;">Fitzpatrick:</span>
                    <span style="display:flex;align-items:center;gap:5px;font-weight:600;">
                        <span style="width:12px;height:12px;border-radius:50%;background:{{ $fitzColors[$paciente->fitzpatrick] ?? '#e2e8f0' }};display:inline-block;"></span>
                        Tipo {{ $paciente->fitzpatrick }}
                    </span>
                </div>
                @endif
            </div>
        </div>

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

    <!-- Columna derecha -->
    <div style="display:flex;flex-direction:column;gap:14px;">

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
            <div style="padding:14px 18px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:13px;font-weight:600;display:flex;align-items:center;gap:7px;">
                    <span style="width:26px;height:26px;border-radius:7px;background:#ffe4e6;color:#e11d48;display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-file-medical" style="font-size:11px;"></i></span>
                    Historial Clinico
                </span>
                <a href="{{ route('medico.historial.create', ['paciente_id' => $paciente->id]) }}" style="font-size:12px;color:#0ea5a0;font-weight:500;text-decoration:none;">+ Nueva consulta</a>
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
                <a href="{{ route('medico.historial.show', $historial) }}" style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#d1fae5;color:#059669;text-decoration:none;">Ver</a>
            </div>
            @empty
            <div style="padding:24px;text-align:center;color:#94a3b8;font-size:12px;">Sin consultas registradas</div>
            @endforelse
        </div>

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
            <div style="padding:14px 18px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:13px;font-weight:600;display:flex;align-items:center;gap:7px;">
                    <span style="width:26px;height:26px;border-radius:7px;background:#ede9fe;color:#7c3aed;display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-prescription" style="font-size:11px;"></i></span>
                    Recetas
                </span>
                <a href="{{ route('medico.recetas.create', ['paciente_id' => $paciente->id]) }}" style="font-size:12px;color:#0ea5a0;font-weight:500;text-decoration:none;">+ Nueva receta</a>
            </div>
            @forelse($paciente->recetas->take(3) as $receta)
            <div style="padding:12px 18px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:11px;">
                <span style="background:#ede9fe;color:#7c3aed;font-size:11px;font-weight:700;padding:4px 10px;border-radius:7px;font-family:monospace;">{{ $receta->folio }}</span>
                <div style="flex:1;">
                    <div style="font-size:12px;color:#64748b;">{{ \Carbon\Carbon::parse($receta->fecha)->format('d/m/Y') }}</div>
                    <div style="font-size:11px;color:#64748b;">{{ $receta->items->count() }} medicamento(s)</div>
                </div>
                <a href="{{ route('medico.recetas.pdf', $receta) }}" target="_blank" style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#d1fae5;color:#059669;text-decoration:none;">PDF</a>
            </div>
            @empty
            <div style="padding:24px;text-align:center;color:#94a3b8;font-size:12px;">Sin recetas registradas</div>
            @endforelse
        </div>

        @if($esMedicoEstetico)
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
            <div style="padding:14px 18px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:13px;font-weight:600;display:flex;align-items:center;gap:7px;">
                    <span style="width:26px;height:26px;border-radius:7px;background:#fef3c7;color:#b45309;display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-file-waveform" style="font-size:11px;"></i></span>
                    Historial de Tratamientos
                </span>
                <a href="{{ route('medico.tratamientos-esteticos.create', ['paciente_id' => $paciente->id]) }}" style="font-size:12px;color:#0ea5a0;font-weight:500;text-decoration:none;">+ Nuevo tratamiento</a>
            </div>
            <div style="max-height:280px;overflow-y:auto;">
                @forelse($tratamientos as $trat)
                <div style="padding:11px 18px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:11px;">
                    @php
                        $grupoColors = [
                            'A'=>['bg'=>'#fef3c7','color'=>'#92400e','label'=>'Neuromo.'],
                            'B'=>['bg'=>'#dbeafe','color'=>'#1e40af','label'=>'Rellenos'],
                            'C'=>['bg'=>'#d1fae5','color'=>'#065f46','label'=>'Bioest.'],
                            'D'=>['bg'=>'#fee2e2','color'=>'#991b1b','label'=>'Lipolit.'],
                            'E'=>['bg'=>'#f3e8ff','color'=>'#6b21a8','label'=>'Piel'],
                        ];
                        $gc = $grupoColors[$trat->grupo] ?? ['bg'=>'#f1f5f9','color'=>'#475569','label'=>$trat->grupo];
                    @endphp
                    <div style="min-width:56px;text-align:center;">
                        <div style="font-size:11px;font-weight:700;color:#64748b;">{{ \Carbon\Carbon::parse($trat->fecha)->format('d/m/Y') }}</div>
                        <span style="display:inline-block;margin-top:3px;padding:2px 6px;border-radius:5px;font-size:9px;font-weight:700;background:{{ $gc['bg'] }};color:{{ $gc['color'] }};">{{ $gc['label'] }}</span>
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:13px;font-weight:600;color:#1e293b;">{{ $trat->titulo ?? 'Historia clinica estetica' }}</div>
                        <div style="font-size:11px;color:#64748b;margin-top:1px;display:flex;align-items:center;gap:8px;">
                            <span><i class="fa-solid fa-location-dot" style="font-size:9px;"></i> {{ $trat->zonas->count() }} zona(s)</span>
                            @if($trat->producto_marca)<span style="color:#b45309;"><i class="fa-solid fa-flask" style="font-size:9px;"></i> {{ $trat->producto_marca }}</span>@endif
                            @if($trat->sesion_numero)<span>Sesion {{ $trat->sesion_numero }}</span>@endif
                        </div>
                    </div>
                    <div style="display:flex;gap:5px;">
                        <a href="{{ route('medico.tratamientos-esteticos.show', $trat) }}" style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#fef3c7;color:#92400e;text-decoration:none;">Historia clinica</a>
                        <a href="{{ route('medico.tratamientos-esteticos.pdf', $trat) }}" target="_blank" style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#f1f5f9;color:#475569;text-decoration:none;">PDF</a>
                    </div>
                </div>
                @empty
                <div style="padding:24px;text-align:center;color:#94a3b8;font-size:12px;">Sin historias clinicas esteticas registradas</div>
                @endforelse
            </div>
        </div>
        @endif

    </div>
</div>
    {{-- MODAL ELIMINAR PACIENTE --}}
    <div id="modal-eliminar" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.5);z-index:1000;align-items:center;justify-content:center;padding:20px;">
        <div style="background:white;border-radius:12px;border-left:4px solid #dc2626;border-top:0.5px solid #e2e8f0;border-right:0.5px solid #e2e8f0;border-bottom:0.5px solid #e2e8f0;padding:24px;max-width:380px;width:100%;">
            <p style="font-size:15px;font-weight:600;color:#1e293b;margin:0 0 8px;">Eliminar paciente</p>
            <p style="font-size:13px;color:#64748b;margin:0;line-height:1.5;">
                <strong style="color:#1e293b;">{{ $paciente->nombre_completo }}</strong> y todo su historial clínico será eliminado permanentemente.
            </p>
            <div style="display:flex;gap:8px;margin-top:20px;justify-content:flex-end;">
                <button type="button"
                    onclick="document.getElementById('modal-eliminar').style.display='none'"
                    style="padding:8px 18px;border-radius:8px;font-size:13px;background:transparent;border:1px solid #e2e8f0;color:#64748b;cursor:pointer;font-family:inherit;">
                    Cancelar
                </button>
                <form action="{{ route('medico.pacientes.destroy', $paciente) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        style="padding:8px 18px;border-radius:8px;font-size:13px;background:#dc2626;border:none;color:white;font-weight:600;cursor:pointer;font-family:inherit;">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('modal-eliminar').addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });
    </script>

@endsection