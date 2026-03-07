@extends('layouts.medico')

@section('titulo', 'Mis Pacientes')

@section('contenido')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
    <h3 class="font-serif" style="font-size:21px;">Mis Pacientes</h3>
    <a href="{{ route('pacientes.create') }}"
        style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:8px;font-size:13px;font-weight:600;background:#0ea5a0;color:white;text-decoration:none;">
        <i class="fa-solid fa-plus"></i> Nuevo paciente
    </a>
</div>

<!-- Buscador -->
<form method="GET" action="{{ route('medico.pacientes.index') }}">
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
        <div style="flex:1;display:flex;align-items:center;gap:7px;background:white;border:1px solid #e2e8f0;border-radius:9px;padding:8px 13px;">
            <i class="fa-solid fa-magnifying-glass" style="color:#94a3b8;font-size:12px;"></i>
            <input name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre, expediente..."
                style="border:none;background:transparent;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;flex:1;">
        </div>
        <button type="submit"
            style="padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;background:#0ea5a0;color:white;border:none;cursor:pointer;">
            Buscar
        </button>
        @if(request('buscar'))
        <a href="{{ route('medico.pacientes.index') }}"
            style="padding:8px 14px;border-radius:8px;font-size:13px;font-weight:600;background:white;color:#64748b;border:1.5px solid #e2e8f0;text-decoration:none;">
            Limpiar
        </a>
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
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Última cita</th>
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
                            {{ strtoupper(substr($paciente->nombre, 0, 1)) }}{{ strtoupper(substr($paciente->apellido_paterno ?? '', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight:600;color:#1e293b;">{{ $paciente->nombre_completo }}</div>
                            <div style="font-size:11px;color:#64748b;">{{ $paciente->fecha_nacimiento ? \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age . ' años' : '' }}</div>
                        </div>
                    </div>
                </td>
                <td style="padding:12px 16px;font-family:monospace;font-size:12px;color:#64748b;">{{ $paciente->expediente }}</td>
                <td style="padding:12px 16px;font-size:12px;color:#64748b;">{{ $paciente->telefono ?? '—' }}</td>
                <td style="padding:12px 16px;font-size:12px;color:#64748b;">
                    {{ $paciente->citas->first() ? \Carbon\Carbon::parse($paciente->citas->first()->fecha)->format('d/m/Y') : '—' }}
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

    @if($pacientes->hasPages())
    <div style="padding:14px 18px;border-top:1px solid #e2e8f0;">
        {{ $pacientes->links() }}
    </div>
    @endif
</div>

@endsection
