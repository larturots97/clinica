@extends('layouts.medico')

@section('titulo', 'Mis Pacientes')

@section('contenido')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
    <h3 class="font-serif" style="font-size:21px;">Mis Pacientes</h3>
    <a href="{{ route('medico.pacientes.create') }}"
        style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:8px;font-size:13px;font-weight:600;background:#0ea5a0;color:white;text-decoration:none;">
        <i class="fa-solid fa-plus"></i> Nuevo paciente
    </a>
</div>

@php $vista = request('vista', 'citas'); @endphp

<!-- PESTAÑAS -->
<div style="display:flex;gap:4px;margin-bottom:16px;background:#f1f5f9;border-radius:10px;padding:4px;width:fit-content;">
    <a href="{{ route('medico.pacientes.index', ['vista'=>'citas', 'buscar'=>request('buscar')]) }}"
        style="padding:7px 18px;border-radius:7px;font-size:12px;font-weight:600;text-decoration:none;transition:all .15s;
        {{ $vista === 'citas' ? 'background:white;color:#0ea5a0;box-shadow:0 1px 4px rgba(0,0,0,.08);' : 'color:#64748b;' }}">
        <i class="fa-solid fa-calendar-check" style="margin-right:5px;font-size:11px;"></i> Con citas
        <span style="background:{{ $vista==='citas' ? '#d1fae5' : '#e2e8f0' }};color:{{ $vista==='citas' ? '#059669' : '#94a3b8' }};border-radius:20px;padding:1px 7px;font-size:10px;margin-left:4px;">
            {{ $totalCitas }}
        </span>
    </a>
    <a href="{{ route('medico.pacientes.index', ['vista'=>'todos', 'buscar'=>request('buscar')]) }}"
        style="padding:7px 18px;border-radius:7px;font-size:12px;font-weight:600;text-decoration:none;transition:all .15s;
        {{ $vista === 'todos' ? 'background:white;color:#0ea5a0;box-shadow:0 1px 4px rgba(0,0,0,.08);' : 'color:#64748b;' }}">
        <i class="fa-solid fa-users" style="margin-right:5px;font-size:11px;"></i> Todos
        <span style="background:{{ $vista==='todos' ? '#d1fae5' : '#e2e8f0' }};color:{{ $vista==='todos' ? '#059669' : '#94a3b8' }};border-radius:20px;padding:1px 7px;font-size:10px;margin-left:4px;">
            {{ $totalTodos }}
        </span>
    </a>
    <a href="{{ route('medico.pacientes.index', ['vista'=>'web', 'buscar'=>request('buscar')]) }}"
        style="padding:7px 18px;border-radius:7px;font-size:12px;font-weight:600;text-decoration:none;transition:all .15s;
        {{ $vista === 'web' ? 'background:white;color:#7c3aed;box-shadow:0 1px 4px rgba(0,0,0,.08);' : 'color:#64748b;' }}">
        <i class="fa-solid fa-globe" style="margin-right:5px;font-size:11px;"></i> Pacientes Web
        <span style="background:{{ $vista==='web' ? '#ede9fe' : '#e2e8f0' }};color:{{ $vista==='web' ? '#7c3aed' : '#94a3b8' }};border-radius:20px;padding:1px 7px;font-size:10px;margin-left:4px;">
            {{ $totalWeb }}
        </span>
    </a>
</div>

@if($vista === 'web')
{{-- ═══════ PESTAÑA PACIENTES WEB ═══════ --}}
<div style="background:#faf5ff;border:1px solid #e9d5ff;border-radius:10px;padding:12px 16px;margin-bottom:16px;font-size:12px;color:#7c3aed;display:flex;gap:8px;align-items:center;">
    <i class="fa-solid fa-circle-info"></i>
    <span>Estos pacientes solicitaron cita desde la página web. Puedes <strong>ver sus datos</strong> o <strong>registrarlos</strong> como pacientes formales.</span>
</div>

<div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;font-size:13px;">
        <thead style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
            <tr>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Visitante</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Teléfono</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Cita solicitada</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Estado</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($citasWeb as $cita)
            <tr style="border-bottom:1px solid #f1f5f9;" onmouseover="this.style.background='#faf5ff'" onmouseout="this.style.background=''">
                <td style="padding:12px 16px;">
                    <div style="display:flex;align-items:center;gap:9px;">
                        <div style="width:34px;height:34px;border-radius:50%;background:#ede9fe;color:#7c3aed;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;flex-shrink:0;">
                            {{ strtoupper(substr($cita->nombre_visitante ?? 'V', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight:600;color:#1e293b;">{{ $cita->nombre_visitante ?? '—' }}</div>
                            <div style="font-size:11px;color:#94a3b8;">{{ $cita->email_visitante ?? 'Sin correo' }}</div>
                        </div>
                    </div>
                </td>
                <td style="padding:12px 16px;font-size:12px;color:#64748b;">{{ $cita->telefono_visitante ?? '—' }}</td>
                <td style="padding:12px 16px;font-size:12px;color:#64748b;">
                    @if($cita->fecha_cita)
                        {{ \Carbon\Carbon::parse($cita->fecha_cita)->format('d/m/Y') }}
                        @if($cita->hora_cita) · {{ $cita->hora_cita }} @endif
                    @else
                        {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m/Y H:i') }}
                    @endif
                </td>
                <td style="padding:12px 16px;">
                    @php
                        $estadoColor = match($cita->estado) {
                            'pendiente'  => ['bg'=>'#fef3c7','color'=>'#92400e','label'=>'Pendiente'],
                            'confirmada' => ['bg'=>'#d1fae5','color'=>'#059669','label'=>'Confirmada'],
                            'cancelada'  => ['bg'=>'#fee2e2','color'=>'#991b1b','label'=>'Cancelada'],
                            default      => ['bg'=>'#f1f5f9','color'=>'#64748b','label'=>ucfirst($cita->estado)],
                        };
                    @endphp
                    <span style="background:{{ $estadoColor['bg'] }};color:{{ $estadoColor['color'] }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">
                        {{ $estadoColor['label'] }}
                    </span>
                </td>
                <td style="padding:12px 16px;">
                    <div style="display:flex;gap:5px;">
                        {{-- Ver datos --}}
                        <button onclick="verVisitante({{ $cita->id }})"
                            style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#ede9fe;color:#7c3aed;border:none;cursor:pointer;">
                            <i class="fa-solid fa-eye" style="font-size:10px;"></i> Ver
                        </button>
                        {{-- Registrar como paciente --}}
                        <a href="{{ route('medico.pacientes.create', ['desde_cita' => $cita->id]) }}"
                            style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#d1fae5;color:#059669;text-decoration:none;">
                            <i class="fa-solid fa-user-plus" style="font-size:10px;"></i> Registrar
                        </a>
                        {{-- Confirmar cita --}}
                        @if($cita->estado === 'pendiente')
                        <form method="POST" action="{{ route('medico.citas.estado', $cita) }}" style="display:inline;">
                            @csrf
                            <input type="hidden" name="estado" value="confirmada">
                            <button type="submit" style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#dbeafe;color:#1d4ed8;border:none;cursor:pointer;">
                                <i class="fa-solid fa-check" style="font-size:10px;"></i> Confirmar
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>

            {{-- Modal datos visitante --}}
            <div id="modal-visitante-{{ $cita->id }}" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:1000;align-items:center;justify-content:center;padding:20px;">
                <div style="background:white;border-radius:16px;width:100%;max-width:440px;box-shadow:0 25px 60px rgba(0,0,0,.25);">
                    <div style="padding:16px 20px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:36px;height:36px;border-radius:50%;background:#ede9fe;color:#7c3aed;display:flex;align-items:center;justify-content:center;font-weight:700;">
                                {{ strtoupper(substr($cita->nombre_visitante ?? 'V', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size:14px;font-weight:700;color:#1e293b;">{{ $cita->nombre_visitante }}</div>
                                <div style="font-size:11px;color:#94a3b8;">Solicitud desde la landing</div>
                            </div>
                        </div>
                        <button onclick="document.getElementById('modal-visitante-{{ $cita->id }}').style.display='none'"
                            style="width:30px;height:30px;border-radius:8px;background:#f1f5f9;border:none;cursor:pointer;font-size:14px;color:#64748b;">✕</button>
                    </div>
                    <div style="padding:20px;display:flex;flex-direction:column;gap:12px;">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                            <div style="background:#f8fafc;border-radius:8px;padding:10px 12px;">
                                <div style="font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:3px;">Teléfono</div>
                                <div style="font-size:13px;font-weight:600;color:#1e293b;">{{ $cita->telefono_visitante ?? '—' }}</div>
                            </div>
                            <div style="background:#f8fafc;border-radius:8px;padding:10px 12px;">
                                <div style="font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:3px;">Correo</div>
                                <div style="font-size:12px;font-weight:600;color:#1e293b;">{{ $cita->email_visitante ?? '—' }}</div>
                            </div>
                            <div style="background:#f8fafc;border-radius:8px;padding:10px 12px;">
                                <div style="font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:3px;">Fecha deseada</div>
                                <div style="font-size:13px;font-weight:600;color:#1e293b;">
                                    {{ $cita->fecha_cita ? \Carbon\Carbon::parse($cita->fecha_cita)->format('d/m/Y') : '—' }}
                                    @if($cita->hora_cita) · {{ $cita->hora_cita }} @endif
                                </div>
                            </div>
                            <div style="background:#f8fafc;border-radius:8px;padding:10px 12px;">
                                <div style="font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:3px;">Solicitó</div>
                                <div style="font-size:12px;font-weight:600;color:#1e293b;">{{ \Carbon\Carbon::parse($cita->created_at)->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                        @if($cita->motivo_visitante)
                        <div style="background:#faf5ff;border:1px solid #e9d5ff;border-radius:8px;padding:12px;">
                            <div style="font-size:10px;color:#7c3aed;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:5px;">Motivo</div>
                            <div style="font-size:13px;color:#374151;line-height:1.6;">{{ $cita->motivo_visitante }}</div>
                        </div>
                        @endif
                    </div>
                    <div style="padding:14px 20px;border-top:1px solid #f1f5f9;display:flex;justify-content:space-between;gap:8px;">
                        @if($cita->telefono_visitante)
                        <a href="https://wa.me/52{{ preg_replace('/\D/','',$cita->telefono_visitante) }}" target="_blank"
                            style="padding:8px 14px;background:#d1fae5;color:#059669;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:5px;">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        @endif
                        <div style="display:flex;gap:8px;margin-left:auto;">
                            <a href="{{ route('medico.pacientes.create', ['desde_cita' => $cita->id]) }}"
                                style="padding:8px 14px;background:#7c3aed;color:white;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;">
                                <i class="fa-solid fa-user-plus"></i> Registrar
                            </a>
                            <button onclick="document.getElementById('modal-visitante-{{ $cita->id }}').style.display='none'"
                                style="padding:8px 14px;background:#f1f5f9;color:#64748b;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">
                                Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <tr>
                <td colspan="5" style="padding:50px;text-align:center;color:#94a3b8;">
                    <i class="fa-solid fa-globe" style="font-size:36px;margin-bottom:12px;display:block;color:#e9d5ff;"></i>
                    <p style="font-size:13px;">No hay solicitudes desde la landing todavía</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@else
{{-- ═══════ PESTAÑAS CON CITAS Y TODOS ═══════ --}}

<!-- Buscador -->
<form method="GET" action="{{ route('medico.pacientes.index') }}">
    <input type="hidden" name="vista" value="{{ $vista }}">
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
        <div style="flex:1;display:flex;align-items:center;gap:7px;background:white;border:1px solid #e2e8f0;border-radius:9px;padding:8px 13px;">
            <i class="fa-solid fa-magnifying-glass" style="color:#94a3b8;font-size:12px;"></i>
            <input name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre, expediente..."
                style="border:none;background:transparent;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;flex:1;">
        </div>
        <button type="submit" style="padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;background:#0ea5a0;color:white;border:none;cursor:pointer;">Buscar</button>
        @if(request('buscar'))
        <a href="{{ route('medico.pacientes.index', ['vista'=>$vista]) }}"
            style="padding:8px 14px;border-radius:8px;font-size:13px;font-weight:600;background:white;color:#64748b;border:1.5px solid #e2e8f0;text-decoration:none;">Limpiar</a>
        @endif
    </div>
</form>

<div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;font-size:13px;">
        <thead style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
            <tr>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Paciente</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Expediente</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Teléfono</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">
                    {{ $vista === 'citas' ? 'Última cita' : 'Registrado' }}
                </th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pacientes as $paciente)
            <tr style="border-bottom:1px solid #f1f5f9;transition:background 0.15s;"
                onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                <td style="padding:12px 16px;">
                    <div style="display:flex;align-items:center;gap:9px;">
                        <div style="width:34px;height:34px;border-radius:50%;background:#d1fae5;color:#059669;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;flex-shrink:0;">
                            {{ strtoupper(substr($paciente->nombre, 0, 1)) }}{{ strtoupper(substr($paciente->apellidos ?? '', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight:600;color:#1e293b;">{{ $paciente->nombre_completo }}</div>
                            <div style="font-size:11px;color:#64748b;">{{ $paciente->fecha_nacimiento ? \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age . ' años' : '' }}</div>
                        </div>
                    </div>
                </td>
                <td style="padding:12px 16px;font-family:monospace;font-size:12px;color:#64748b;">{{ $paciente->numero_expediente ?? '—' }}</td>
                <td style="padding:12px 16px;font-size:12px;color:#64748b;">{{ $paciente->telefono ?? '—' }}</td>
                <td style="padding:12px 16px;font-size:12px;color:#64748b;">
                    @if($vista === 'citas')
                        {{ $paciente->citas->first() ? \Carbon\Carbon::parse($paciente->citas->first()->fecha_hora)->format('d/m/Y') : '—' }}
                    @else
                        {{ $paciente->created_at->format('d/m/Y') }}
                    @endif
                </td>
                <td style="padding:12px 16px;">
                    <div style="display:flex;align-items:center;gap:5px;">
                        <a href="{{ route('medico.pacientes.show', $paciente) }}"
                            style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#d1fae5;color:#059669;text-decoration:none;">
                            <i class="fa-solid fa-eye" style="font-size:10px;"></i> Ver
                        </a>
                        <a href="{{ route('medico.historial.create', ['paciente_id' => $paciente->id]) }}"
                            style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#ffe4e6;color:#e11d48;text-decoration:none;">
                            <i class="fa-solid fa-file-medical" style="font-size:10px;"></i> Consulta
                        </a>
                        <a href="{{ route('medico.recetas.create', ['paciente_id' => $paciente->id]) }}"
                            style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#ede9fe;color:#7c3aed;text-decoration:none;">
                            <i class="fa-solid fa-prescription" style="font-size:10px;"></i> Receta
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding:50px;text-align:center;color:#94a3b8;">
                    <i class="fa-solid fa-users" style="font-size:36px;margin-bottom:12px;display:block;"></i>
                    <p style="font-size:13px;">No se encontraron pacientes</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if(isset($pacientes) && $pacientes->hasPages())
    <div style="padding:14px 18px;border-top:1px solid #e2e8f0;">
        {{ $pacientes->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endif

<script>
function verVisitante(id) {
    document.getElementById('modal-visitante-' + id).style.display = 'flex';
}
document.querySelectorAll('[id^="modal-visitante-"]').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });
});
</script>

@endsection