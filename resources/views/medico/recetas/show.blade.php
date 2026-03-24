@extends('layouts.medico')
@section('titulo', 'Receta ' . $receta->folio)
@section('contenido')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
    <div style="display:flex;align-items:center;gap:10px;">
        <a href="{{ route('medico.recetas.index') }}" style="color:#94a3b8;text-decoration:none;">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h3 class="font-serif" style="font-size:21px;">Receta</h3>
        <span style="background:#ede9fe;color:#7c3aed;font-size:12px;font-weight:700;padding:3px 10px;border-radius:6px;font-family:monospace;">{{ $receta->folio }}</span>
    </div>
    <a href="{{ route('medico.recetas.pdf', $receta) }}" target="_blank"
        style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:8px;font-size:13px;font-weight:600;background:#7c3aed;color:white;text-decoration:none;">
        <i class="fa-solid fa-file-pdf"></i> Descargar PDF
    </a>
</div>

<div style="display:grid;grid-template-columns:1fr 280px;gap:18px;">

    <div style="display:flex;flex-direction:column;gap:14px;">
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:14px;">Medicamentos prescritos</h4>
            @foreach($receta->items as $i => $item)
            <div style="border:1.5px solid #ede9fe;border-radius:10px;padding:14px;margin-bottom:10px;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                    <span style="width:22px;height:22px;border-radius:50%;background:#7c3aed;color:white;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;">{{ $i+1 }}</span>
                    <span style="font-size:14px;font-weight:700;color:#1e293b;">{{ $item->nombre }}</span>
                </div>
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;font-size:12px;">
                    <div><span style="color:#94a3b8;">Dosis:</span> <span style="font-weight:600;">{{ $item->dosis }}</span></div>
                    <div><span style="color:#94a3b8;">Frecuencia:</span> <span style="font-weight:600;">{{ $item->frecuencia }}</span></div>
                    @if($item->duracion)
                    <div><span style="color:#94a3b8;">Duración:</span> <span style="font-weight:600;">{{ $item->duracion }}</span></div>
                    @endif
                    @if($item->indicaciones)
                    <div style="grid-column:span 3;color:#64748b;font-style:italic;">{{ $item->indicaciones }}</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @if($receta->diagnostico || $receta->indicaciones)
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            @if($receta->diagnostico)
            <div style="margin-bottom:12px;">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:4px;">Diagnóstico</div>
                <div style="font-size:14px;color:#1e293b;">{{ $receta->diagnostico }}</div>
            </div>
            @endif
            @if($receta->indicaciones)
            <div>
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:4px;">Indicaciones generales</div>
                <div style="font-size:14px;color:#1e293b;">{{ $receta->indicaciones }}</div>
            </div>
            @endif
        </div>
        @endif
    </div>

    <div style="display:flex;flex-direction:column;gap:14px;">
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:12px;">Paciente</h4>
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:12px;">
                <div style="width:36px;height:36px;border-radius:50%;background:#ede9fe;color:#7c3aed;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;">
                    {{ strtoupper(substr($receta->paciente->nombre, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:13px;font-weight:600;">{{ $receta->paciente->nombre_completo }}</div>
                    <div style="font-size:11px;color:#64748b;">{{ $receta->paciente->expediente }}</div>
                </div>
            </div>
            <div style="font-size:12px;color:#64748b;display:flex;justify-content:space-between;margin-bottom:4px;">
                <span>Fecha:</span><span style="font-weight:600;color:#1e293b;">{{ \Carbon\Carbon::parse($receta->fecha)->format('d/m/Y') }}</span>
            </div>
            <a href="{{ route('medico.pacientes.show', $receta->paciente) }}"
                style="display:flex;align-items:center;justify-content:center;gap:6px;margin-top:12px;padding:8px;border-radius:8px;font-size:12px;font-weight:600;background:#ede9fe;color:#7c3aed;text-decoration:none;">
                <i class="fa-solid fa-user"></i> Ver expediente
            </a>
        </div>

        <a href="{{ route('medico.recetas.create', ['paciente_id' => $receta->paciente_id]) }}"
            style="display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:9px;font-size:13px;font-weight:600;background:#7c3aed;color:white;text-decoration:none;">
            <i class="fa-solid fa-plus"></i> Nueva receta
        </a>
    </div>

</div>
@endsection