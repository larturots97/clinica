@extends('layouts.medico')
@section('titulo', 'Editar Paciente')
@section('contenido')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
    <a href="{{ route('medico.pacientes.show', $paciente) }}" style="color:#94a3b8;text-decoration:none;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h3 style="font-size:20px;font-weight:700;margin:0;">Editar Paciente</h3>
    <span style="font-size:12px;color:#94a3b8;background:#f1f5f9;padding:3px 10px;border-radius:20px;font-family:monospace;">
        {{ $paciente->expediente }}
    </span>
</div>

<form action="{{ route('medico.pacientes.update', $paciente) }}" method="POST">
@csrf
@method('PUT')
<div style="display:grid;grid-template-columns:1fr 340px;gap:18px;">

    <div style="display:flex;flex-direction:column;gap:14px;">

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin:0 0 16px;">
                <i class="fa-solid fa-user" style="margin-right:6px;color:#0ea5a0;"></i> Datos personales
            </h4>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Nombre *</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $paciente->nombre) }}" required
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Apellido paterno *</label>
                    <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $paciente->apellido_paterno) }}" required
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Apellido materno</label>
                    <input type="text" name="apellido_materno" value="{{ old('apellido_materno', $paciente->apellido_materno) }}"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Fecha de nacimiento *</label>
                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento) }}" required
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Sexo *</label>
                    <select name="sexo" required style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
                        <option value="">Seleccionar...</option>
                        <option value="M" {{ old('sexo', $paciente->sexo) == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('sexo', $paciente->sexo) == 'F' ? 'selected' : '' }}>Femenino</option>
                        <option value="O" {{ old('sexo', $paciente->sexo) == 'O' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono', $paciente->telefono) }}"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>
                <div style="grid-column:span 3;">
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email', $paciente->email) }}"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>
            </div>
        </div>

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin:0 0 16px;">
                <i class="fa-solid fa-notes-medical" style="margin-right:6px;color:#0ea5a0;"></i> Antecedentes médicos
            </h4>
            <div style="display:flex;flex-direction:column;gap:12px;">
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Alergias</label>
                    <textarea name="alergias" rows="3" placeholder="Ej: Penicilina, látex..."
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;resize:vertical;font-family:'DM Sans',sans-serif;box-sizing:border-box;">{{ old('alergias', $paciente->alergias) }}</textarea>
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Antecedentes patológicos</label>
                    <textarea name="antecedentes" rows="3" placeholder="Ej: Diabetes, hipertensión..."
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;resize:vertical;font-family:'DM Sans',sans-serif;box-sizing:border-box;">{{ old('antecedentes', $paciente->antecedentes) }}</textarea>
                </div>
            </div>
        </div>

    </div>

    <div style="display:flex;flex-direction:column;gap:14px;">

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin:0 0 14px;">Acciones</h4>
            <button type="submit" style="width:100%;padding:10px;background:#0ea5a0;color:white;border:none;border-radius:9px;font-size:13px;font-weight:700;cursor:pointer;">
                <i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> Guardar cambios
            </button>
            <a href="{{ route('medico.pacientes.show', $paciente) }}"
                style="display:block;text-align:center;margin-top:10px;font-size:12px;color:#94a3b8;text-decoration:none;">
                Cancelar
            </a>
        </div>

        <div style="background:#f8fafc;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin:0 0 12px;">Información del expediente</h4>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <div style="display:flex;justify-content:space-between;font-size:12px;">
                    <span style="color:#94a3b8;">Expediente</span>
                    <span style="font-family:monospace;font-weight:600;color:#1e293b;">{{ $paciente->expediente }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:12px;">
                    <span style="color:#94a3b8;">Registrado</span>
                    <span style="color:#1e293b;">{{ $paciente->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        @if($errors->any())
        <div style="background:#fee2e2;border-radius:10px;padding:14px 16px;">
            <div style="font-size:12px;font-weight:700;color:#dc2626;margin-bottom:6px;">Corrige los siguientes errores:</div>
            @foreach($errors->all() as $error)
            <div style="font-size:12px;color:#dc2626;">• {{ $error }}</div>
            @endforeach
        </div>
        @endif

    </div>

</div>
</form>
@endsection
