@extends('layouts.medico')

@section('titulo', 'Detalle de Consulta')

@section('contenido')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
    <a href="{{ route('medico.historial.index') }}"
        style="color:#94a3b8;text-decoration:none;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h3 class="font-serif" style="font-size:21px;">Detalle de Consulta</h3>
    <span style="font-size:12px;color:#64748b;background:#f1f5f9;padding:3px 9px;border-radius:6px;">
        {{ \Carbon\Carbon::parse($historial->fecha)->format('d/m/Y') }}
    </span>
</div>

<div style="display:grid;grid-template-columns:1fr 300px;gap:18px;">

    <div style="display:flex;flex-direction:column;gap:14px;">

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:14px;">Información clínica</h4>
            <div style="display:flex;flex-direction:column;gap:14px;">
                <div>
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:4px;">Motivo de consulta</div>
                    <div style="font-size:14px;color:#1e293b;">{{ $historial->motivo_consulta }}</div>
                </div>
                <div style="border-top:1px solid #f1f5f9;padding-top:14px;">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:4px;">Diagnóstico</div>
                    <div style="font-size:14px;color:#1e293b;">{{ $historial->diagnostico }}</div>
                </div>
                @if($historial->tratamiento)
                <div style="border-top:1px solid #f1f5f9;padding-top:14px;">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:4px;">Tratamiento indicado</div>
                    <div style="font-size:14px;color:#1e293b;">{{ $historial->tratamiento }}</div>
                </div>
                @endif
                @if($historial->notas)
                <div style="border-top:1px solid #f1f5f9;padding-top:14px;">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:4px;">Notas adicionales</div>
                    <div style="font-size:14px;color:#1e293b;">{{ $historial->notas }}</div>
                </div>
                @endif
            </div>
        </div>

    </div>

    <div style="display:flex;flex-direction:column;gap:14px;">

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:12px;">Paciente</h4>
            <div style="display:flex;align-items:center;gap:9px;">
                <div style="width:38px;height:38px;border-radius:50%;background:#ffe4e6;color:#e11d48;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;">
                    {{ strtoupper(substr($historial->paciente->nombre, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:13px;font-weight:600;">{{ $historial->paciente->nombre_completo }}</div>
                    <div style="font-size:11px;color:#64748b;">{{ $historial->paciente->expediente }}</div>
                </div>
            </div>
            <div style="margin-top:12px;">
                <a href="{{ route('medico.pacientes.show', $historial->paciente) }}"
                    style="display:flex;align-items:center;justify-content:center;gap:6px;padding:8px;border-radius:8px;font-size:12px;font-weight:600;background:#ffe4e6;color:#e11d48;text-decoration:none;">
                    <i class="fa-solid fa-user"></i> Ver expediente completo
                </a>
            </div>
        </div>

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:12px;">Acciones</h4>
            <a href="#"
                style="display:flex;align-items:center;gap:7px;padding:9px 12px;border-radius:8px;font-size:13px;font-weight:600;background:#ede9fe;color:#7c3aed;text-decoration:none;margin-bottom:7px;">
                <i class="fa-solid fa-prescription"></i> Emitir receta
            </a>
            <a href="{{ route('medico.historial.create', ['paciente_id' => $historial->paciente_id]) }}"
                style="display:flex;align-items:center;gap:7px;padding:9px 12px;border-radius:8px;font-size:13px;font-weight:600;background:#ffe4e6;color:#e11d48;text-decoration:none;">
                <i class="fa-solid fa-plus"></i> Nueva consulta
            </a>
        </div>

    </div>
</div>

@endsection
