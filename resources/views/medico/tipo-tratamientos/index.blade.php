@extends('layouts.medico')
@section('titulo', 'Mis Tratamientos')
@section('contenido')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
    <h3 class="font-serif" style="font-size:21px;">Mis Tipos de Tratamiento</h3>
    <a href="{{ route('medico.tipo-tratamientos.create') }}"
        style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:8px;font-size:13px;font-weight:600;background:#9333ea;color:white;text-decoration:none;">
        <i class="fa-solid fa-plus"></i> Agregar tratamiento
    </a>
</div>

@if(session('success'))
<div style="background:#d1fae5;border:1px solid #a7f3d0;color:#065f46;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px;">
    <i class="fa-solid fa-circle-check" style="margin-right:6px;"></i>{{ session('success') }}
</div>
@endif

@php
$grupoNombres = ['A'=>'Neuromoduladores','B'=>'Rellenos / HidrataciÃ³n','C'=>'BioestimulaciÃ³n','D'=>'LipolÃ­ticos / Corporales','E'=>'Piel Superficial'];
$grupoColors  = ['A'=>'#d97706','B'=>'#059669','C'=>'#2563eb','D'=>'#7c3aed','E'=>'#dc2626'];
$grupoBg      = ['A'=>'#fef3c7','B'=>'#d1fae5','C'=>'#dbeafe','D'=>'#ede9fe','E'=>'#fee2e2'];
@endphp

@if($tratamientos->isEmpty())
<div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:48px;text-align:center;">
    <div style="font-size:3rem;margin-bottom:12px;">í</div>
    <div style="font-size:16px;font-weight:600;color:#1e293b;margin-bottom:6px;">Sin tratamientos registrados</div>
    <div style="font-size:13px;color:#64748b;margin-bottom:20px;">Agrega los tratamientos que ofreces para usarlos en las historias cl²‰nicas.</div>
    <a href="{{ route('medico.tipo-tratamientos.create') }}"
        style="display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:8px;font-size:13px;font-weight:600;background:#9333ea;color:white;text-decoration:none;">
        <i class="fa-solid fa-plus"></i> Agregar primer tratamiento
    </a>
</div>
@else
    @foreach(['A','B','C','D','E'] as $grupo)
        @if(isset($tratamientos[$grupo]))
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;margin-bottom:14px;">
            <div style="padding:10px 18px;background:#f8fafc;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;gap:10px;">
                <span style="background:{{ $grupoBg[$grupo] }};color:{{ $grupoColors[$grupo] }};font-size:10px;font-weight:700;padding:2px 9px;border-radius:20px;">Grupo {{ $grupo }}</span>
                <span style="font-size:13px;font-weight:600;color:#1e293b;">{{ $grupoNombres[$grupo] }}</span>
                <span style="margin-left:auto;font-size:11px;color:#94a3b8;">{{ $tratamientos[$grupo]->count() }} tratamiento(s)</span>
            </div>
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead style="background:#fafafa;">
                    <tr>
                        <th style="padding:8px 18px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Nombre</th>
                        <th style="padding:8px 18px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Clave</th>
                        <th style="padding:8px 18px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Precio base</th>
                        <th style="padding:8px 18px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Estado</th>
                        <th style="padding:8px 18px;text-align:right;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tratamientos[$grupo] as $tipo)
                    <tr style="border-top:1px solid #f1f5f9;">
                        <td style="padding:10px 18px;font-weight:600;color:#1e293b;">{{ $tipo->nombre }}</td>
                        <td style="padding:10px 18px;"><code style="background:#f1f5f9;color:#7c3aed;padding:2px 7px;border-radius:5px;font-size:11px;">{{ $tipo->clave }}</code></td>
                        <td style="padding:10px 18px;color:#059669;font-weight:600;">${{ number_format($tipo->precio_base, 2) }}</td>
                        <td style="padding:10px 18px;">
                            <form action="{{ route('medico.tipo-tratamientos.toggle', $tipo) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;border:none;cursor:pointer;background:{{ $tipo->activo ? '#d1fae5' : '#f1f5f9' }};color:{{ $tipo->activo ? '#065f46' : '#64748b' }};">
                                    {{ $tipo->activo ? 'Activo' : 'Inactivo' }}
                                </button>
                            </form>
                        </td>
                        <td style="padding:10px 18px;text-align:right;display:flex;gap:6px;justify-content:flex-end;">
                            <a href="{{ route('medico.tipo-tratamientos.edit', $tipo) }}"
                                style="padding:4px 12px;border-radius:7px;font-size:12px;font-weight:600;background:#dbeafe;color:#1d4ed8;text-decoration:none;">Editar</a>
                            <form action="{{ route('medico.tipo-tratamientos.destroy', $tipo) }}" method="POST" style="display:inline;" onsubmit="return confirm('Ã­Â¿Eliminar?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="padding:4px 12px;border-radius:7px;font-size:12px;font-weight:600;background:#fee2e2;color:#dc2626;border:none;cursor:pointer;">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    @endforeach
@endif
@endsection
