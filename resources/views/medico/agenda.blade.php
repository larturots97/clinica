@extends('layouts.medico')

@section('titulo', 'Mi Agenda')

@section('contenido')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
    <h3 class="font-serif" style="font-size:21px;">Mi Agenda</h3>
    <div style="display:flex;gap:8px;">
        <a href="{{ route('medico.agenda.index', ['semana' => $semanaAnterior]) }}"
            style="display:inline-flex;align-items:center;gap:5px;padding:7px 14px;border-radius:8px;font-size:13px;font-weight:600;background:white;color:#1e293b;border:1.5px solid #e2e8f0;text-decoration:none;">
            <i class="fa-solid fa-chevron-left" style="font-size:11px;"></i> Anterior
        </a>
        <a href="{{ route('medico.agenda.index', ['semana' => $semanaSiguiente]) }}"
            style="display:inline-flex;align-items:center;gap:5px;padding:7px 14px;border-radius:8px;font-size:13px;font-weight:600;background:white;color:#1e293b;border:1.5px solid #e2e8f0;text-decoration:none;">
            Siguiente <i class="fa-solid fa-chevron-right" style="font-size:11px;"></i>
        </a>
    </div>
</div>

<!-- Buscador -->
<div style="display:flex;align-items:center;gap:7px;background:white;border:1px solid #e2e8f0;border-radius:9px;padding:8px 13px;margin-bottom:14px;max-width:400px;">
    <i class="fa-solid fa-magnifying-glass" style="color:#94a3b8;font-size:12px;"></i>
    <input id="buscar-agenda" placeholder="Buscar por paciente o motivo..."
        style="border:none;background:transparent;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;flex:1;">
</div>

<div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
    <div style="padding:14px 18px;border-bottom:1px solid #e2e8f0;background:#f8fafc;">
        <span style="font-size:13px;font-weight:600;">
            Semana del {{ $inicio->isoFormat('D [de] MMMM') }} al {{ $fin->isoFormat('D [de] MMMM, YYYY') }}
        </span>
    </div>

    <div id="lista-citas">
    @forelse($citas as $cita)
    <div class="cita-row" style="display:flex;align-items:center;gap:11px;padding:13px 18px;border-bottom:1px solid #f1f5f9;transition:background 0.15s;"
        onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">

        <div style="text-align:center;min-width:56px;">
            <div style="font-size:12px;font-weight:700;color:#64748b;">{{ \Carbon\Carbon::parse($cita->fecha_hora)->isoFormat('ddd DD') }}</div>
            <div style="font-size:13px;font-weight:700;">{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('H:i') }}</div>
        </div>

        <div style="width:3px;height:36px;border-radius:2px;flex-shrink:0;background:
            {{ $cita->estado === 'en_curso' ? '#10b981' : ($cita->estado === 'confirmada' ? '#0ea5a0' : ($cita->estado === 'completada' ? '#94a3b8' : '#f59e0b')) }};">
        </div>

        <div style="flex:1;">
            <div class="pac-nombre" style="font-size:13px;font-weight:600;">{{ $cita->paciente?->nombre_completo ?? $cita->nombre_visitante ?? 'Visitante' }}</div>
            <div class="pac-motivo" style="font-size:11px;color:#64748b;margin-top:1px;">{{ $cita->motivo ?? 'Sin motivo especificado' }}</div>
        </div>

        @php
            $badgeColor = match($cita->estado) {
                'en_curso'   => 'background:#d1fae5;color:#065f46;',
                'confirmada' => 'background:#e0f7f6;color:#065f5f;',
                'completada' => 'background:#f1f5f9;color:#475569;',
                'cancelada'  => 'background:#fee2e2;color:#991b1b;',
                default      => 'background:#fef3c7;color:#92400e;',
            };
        @endphp
        <span style="font-size:10px;font-weight:600;padding:3px 9px;border-radius:20px;{{ $badgeColor }}">
            {{ ucfirst(str_replace('_',' ',$cita->estado)) }}
        </span>

        <!-- Cambiar estado -->
        <form method="POST" action="{{ route('medico.agenda.update', $cita) }}">
            @csrf @method('PUT')
            <select name="estado" onchange="this.form.submit()"
                style="border:1px solid #e2e8f0;border-radius:7px;padding:4px 8px;font-size:11px;font-family:'DM Sans',sans-serif;outline:none;cursor:pointer;color:#1e293b;">
                @foreach(['pendiente','confirmada','en_curso','completada','cancelada'] as $estado)
                <option value="{{ $estado }}" {{ $cita->estado === $estado ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_',' ',$estado)) }}
                </option>
                @endforeach
            </select>
        </form>

        <a href="{{ $cita->paciente_id ? route('medico.pacientes.show', $cita->paciente) : '#' }}"
            style="display:flex;align-items:center;gap:5px;padding:5px 11px;border-radius:7px;background:#e0f7f6;color:#0ea5a0;font-size:11px;font-weight:600;text-decoration:none;">
            <i class="fa-solid fa-eye" style="font-size:10px;"></i> Ver
        </a>
    </div>
    @empty
    <div style="padding:50px;text-align:center;color:#94a3b8;">
        <i class="fa-solid fa-calendar-xmark" style="font-size:36px;margin-bottom:12px;display:block;"></i>
        <p style="font-size:13px;">No hay citas esta semana</p>
    </div>
    @endforelse
    </div>
</div>

<script>
document.getElementById('buscar-agenda').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.cita-row').forEach(row => {
        const nombre = row.querySelector('.pac-nombre')?.textContent.toLowerCase() || '';
        const motivo = row.querySelector('.pac-motivo')?.textContent.toLowerCase() || '';
        row.style.display = (nombre.includes(q) || motivo.includes(q)) ? '' : 'none';
    });
});
</script>

@endsection
