@extends('layouts.medico')
@section('titulo', 'Recetas')
@section('contenido')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
    <h3 class="font-serif" style="font-size:21px;">Recetas</h3>
    <a href="{{ route('medico.recetas.create') }}"
        style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:8px;font-size:13px;font-weight:600;background:#7c3aed;color:white;text-decoration:none;">
        <i class="fa-solid fa-plus"></i> Nueva receta
    </a>
</div>

<form method="GET">
    <div style="display:flex;gap:8px;margin-bottom:14px;">
        <div style="flex:1;display:flex;align-items:center;gap:7px;background:white;border:1px solid #e2e8f0;border-radius:9px;padding:8px 13px;">
            <i class="fa-solid fa-magnifying-glass" style="color:#94a3b8;font-size:12px;"></i>
            <input name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por paciente o folio..."
                style="border:none;background:transparent;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;flex:1;">
        </div>
        <button type="submit" style="padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;background:#7c3aed;color:white;border:none;cursor:pointer;">Buscar</button>
        @if(request('buscar'))
        <a href="{{ route('medico.recetas.index') }}" style="padding:8px 14px;border-radius:8px;font-size:13px;font-weight:600;background:white;color:#64748b;border:1.5px solid #e2e8f0;text-decoration:none;">Limpiar</a>
        @endif
    </div>
</form>

<div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;font-size:13px;">
        <thead style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
            <tr>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Folio</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Fecha</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Paciente</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Medicamentos</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recetas as $receta)
            <tr style="border-bottom:1px solid #f1f5f9;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                <td style="padding:12px 16px;">
                    <span style="background:#ede9fe;color:#7c3aed;font-size:11px;font-weight:700;padding:3px 9px;border-radius:6px;font-family:monospace;">{{ $receta->folio }}</span>
                </td>
                <td style="padding:12px 16px;font-size:12px;color:#64748b;">{{ \Carbon\Carbon::parse($receta->fecha)->format('d/m/Y') }}</td>
                <td style="padding:12px 16px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:30px;height:30px;border-radius:50%;background:#ede9fe;color:#7c3aed;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;flex-shrink:0;">
                            {{ strtoupper(substr($receta->paciente->nombre, 0, 1)) }}
                        </div>
                        <span style="font-weight:600;">{{ $receta->paciente->nombre_completo }}</span>
                    </div>
                </td>
                <td style="padding:12px 16px;font-size:12px;color:#64748b;">{{ $receta->items->count() }} medicamento(s)</td>
                <td style="padding:12px 16px;display:flex;gap:6px;">
                    <a href="{{ route('medico.recetas.show', $receta) }}"
                        style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#ede9fe;color:#7c3aed;text-decoration:none;">
                        <i class="fa-solid fa-eye" style="font-size:10px;"></i> Ver
                    </a>
                    <a href="{{ route('recetas.pdf', $receta) }}" target="_blank"
                        style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;background:#d1fae5;color:#059669;text-decoration:none;">
                        <i class="fa-solid fa-file-pdf" style="font-size:10px;"></i> PDF
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding:50px;text-align:center;color:#94a3b8;">
                    <i class="fa-solid fa-prescription" style="font-size:36px;margin-bottom:12px;display:block;"></i>
                    <p style="font-size:13px;">No hay recetas registradas</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($recetas->hasPages())
    <div style="padding:14px 18px;border-top:1px solid #e2e8f0;">{{ $recetas->links() }}</div>
    @endif
</div>

@endsection
