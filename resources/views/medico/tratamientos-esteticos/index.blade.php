@extends('layouts.medico')
@section('titulo', 'Historias Clínicas Estéticas')
@section('contenido')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
    <h3 class="font-serif" style="font-size:21px;">Historias Clínicas Estéticas</h3>
    <a href="{{ route('medico.tratamientos-esteticos.create') }}"
        style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:8px;font-size:13px;font-weight:600;background:#9333ea;color:white;text-decoration:none;">
        <i class="fa-solid fa-plus"></i> Nueva historia
    </a>
</div>

@if(session('success'))
<div style="background:#d1fae5;border:1px solid #a7f3d0;color:#065f46;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px;">
    <i class="fa-solid fa-circle-check" style="margin-right:6px;"></i>{{ session('success') }}
</div>
@endif

@php
$grupoNombres = ['A'=>'Neuromoduladores','B'=>'Rellenos','C'=>'Bioestimulación','D'=>'Lipolíticos','E'=>'Piel'];
$grupoColors  = ['A'=>'#d97706','B'=>'#059669','C'=>'#2563eb','D'=>'#7c3aed','E'=>'#dc2626'];
$grupoBg      = ['A'=>'#fef3c7','B'=>'#d1fae5','C'=>'#dbeafe','D'=>'#ede9fe','E'=>'#fee2e2'];
@endphp

<div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;font-size:13px;">
        <thead style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
            <tr>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Fecha</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Paciente</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Tratamiento</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Grupo</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Sesión</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tratamientos as $t)
            <tr style="border-bottom:1px solid #f1f5f9;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                <td style="padding:12px 16px;font-size:12px;color:#64748b;">{{ $t->fecha?->format('d/m/Y') }}</td>
                <td style="padding:12px 16px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:30px;height:30px;border-radius:50%;background:#f3e8ff;color:#9333ea;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;flex-shrink:0;">
                            {{ strtoupper(substr($t->paciente?->nombre ?? 'P', 0, 1)) }}
                        </div>
                        <span style="font-weight:600;">{{ $t->paciente?->nombre }} {{ $t->paciente?->apellidos }}</span>
                    </div>
                </td>
                <td style="padding:12px 16px;font-weight:600;color:#1e293b;">{{ $t->titulo ?? $t->tipoTratamiento?->nombre ?? '—' }}</td>
                <td style="padding:12px 16px;">
                    @if($t->grupo)
                    <span style="background:{{ $grupoBg[$t->grupo] ?? '#f1f5f9' }};color:{{ $grupoColors[$t->grupo] ?? '#64748b' }};font-size:11px;font-weight:700;padding:3px 9px;border-radius:6px;">
                        {{ $grupoNombres[$t->grupo] ?? $t->grupo }}
                    </span>
                    @endif
                </td>
                <td style="padding:12px 16px;font-size:12px;color:#64748b;">{{ $t->sesion_numero }}ª</td>
                <td style="padding:12px 16px;display:flex;gap:6px;">
                    <a href="{{ route('medico.tratamientos-esteticos.show', $t) }}"
                        style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#f3e8ff;color:#9333ea;text-decoration:none;">
                        <i class="fa-solid fa-eye" style="font-size:10px;"></i> Ver
                    </a>
                    <a href="{{ route('medico.tratamientos-esteticos.pdf', $t) }}" target="_blank"
                        style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#d1fae5;color:#059669;text-decoration:none;">
                        <i class="fa-solid fa-file-pdf" style="font-size:10px;"></i> PDF
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding:50px;text-align:center;color:#94a3b8;">
                    <i class="fa-solid fa-wand-magic-sparkles" style="font-size:36px;margin-bottom:12px;display:block;color:#e2e8f0;"></i>
                    <p style="font-size:13px;margin-bottom:12px;">No hay historias clínicas estéticas</p>
                    <a href="{{ route('medico.tratamientos-esteticos.create') }}"
                        style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:8px;font-size:13px;font-weight:600;background:#9333ea;color:white;text-decoration:none;">
                        <i class="fa-solid fa-plus"></i> Nueva historia
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($tratamientos->hasPages())
    <div style="padding:14px 18px;border-top:1px solid #e2e8f0;">{{ $tratamientos->links() }}</div>
    @endif
</div>

@endsection
