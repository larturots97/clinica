@extends('layouts.medico')
@section('titulo', 'Editar Paciente')
@section('contenido')

@php
// Separar apellidos guardados en la BD en paterno y materno
$apellidosParts = explode(' ', $paciente->apellidos ?? '', 2);
$apellidoPaterno = $apellidosParts[0] ?? '';
$apellidoMaterno = $apellidosParts[1] ?? '';

// Convertir genero BD → valor del select
$sexoValor = match($paciente->genero ?? '') {
    'masculino' => 'M',
    'femenino'  => 'F',
    'otro'      => 'O',
    default     => ''
};
@endphp

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
    <a href="{{ route('medico.pacientes.show', $paciente) }}" style="color:#94a3b8;text-decoration:none;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h3 style="font-size:20px;font-weight:700;margin:0;">Editar Paciente</h3>
    <span style="font-size:12px;color:#94a3b8;background:#f1f5f9;padding:3px 10px;border-radius:20px;font-family:monospace;">
        {{ $paciente->numero_expediente }}
    </span>
</div>

<form action="{{ route('medico.pacientes.update', $paciente) }}" method="POST">
@csrf
@method('PUT')
<div style="display:grid;grid-template-columns:1fr 340px;gap:18px;">

    <div style="display:flex;flex-direction:column;gap:14px;">

        {{-- DATOS PERSONALES --}}
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
                    <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $apellidoPaterno) }}" required
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Apellido materno</label>
                    <input type="text" name="apellido_materno" value="{{ old('apellido_materno', $apellidoMaterno) }}"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Fecha de nacimiento *</label>
                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento?->format('Y-m-d')) }}" required
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Sexo *</label>
                    <select name="sexo" required style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
                        <option value="">Seleccionar...</option>
                        <option value="M" {{ old('sexo', $sexoValor) == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('sexo', $sexoValor) == 'F' ? 'selected' : '' }}>Femenino</option>
                        <option value="O" {{ old('sexo', $sexoValor) == 'O' ? 'selected' : '' }}>Otro</option>
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
                <div style="grid-column:span 2;">
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion', $paciente->direccion) }}"
                        placeholder="Calle, número, colonia..."
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Ocupación</label>
                    <input type="text" name="ocupacion" value="{{ old('ocupacion', $paciente->ocupacion) }}"
                        placeholder="Ej: Médico, docente, estudiante..."
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>
            </div>
        </div>

        {{-- ANTECEDENTES MÉDICOS --}}
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin:0 0 16px;">
                <i class="fa-solid fa-notes-medical" style="margin-right:6px;color:#0ea5a0;"></i> Antecedentes médicos
            </h4>
            <div style="display:flex;flex-direction:column;gap:12px;">
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Alergias</label>
                    <textarea name="alergias" rows="2" placeholder="Ej: Penicilina, látex..."
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;resize:vertical;font-family:'DM Sans',sans-serif;box-sizing:border-box;">{{ old('alergias', $paciente->alergias) }}</textarea>
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Antecedentes patológicos</label>
                    <textarea name="antecedentes" rows="2" placeholder="Ej: Diabetes, hipertensión..."
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;resize:vertical;font-family:'DM Sans',sans-serif;box-sizing:border-box;">{{ old('antecedentes', $paciente->antecedentes) }}</textarea>
                </div>

                {{-- Checkboxes antecedentes adicionales --}}
                @php
                    $antecedentesExtra = is_array($paciente->antecedentes_extra)
                        ? $paciente->antecedentes_extra
                        : json_decode($paciente->antecedentes_extra ?? '[]', true) ?? [];
                    $opcionesExtra = [
                        'embarazo_lactancia' => 'Embarazo o lactancia',
                        'enf_neuromuscular'  => 'Enf. neuromuscular',
                        'medicacion_actual'  => 'Medicación actual',
                        'cirugias_previas'   => 'Cirugías previas',
                        'tabaco_alcohol'     => 'Consumo tabaco/alcohol',
                    ];
                @endphp
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:8px;">Antecedentes adicionales</label>
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        @foreach($opcionesExtra as $key => $label)
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:12px;color:#374151;">
                            <input type="checkbox" name="antecedentes_extra[]" value="{{ $key }}"
                                {{ in_array($key, (array)$antecedentesExtra) ? 'checked' : '' }}
                                style="width:15px;height:15px;accent-color:#9333ea;cursor:pointer;">
                            {{ $label }}:
                            <span style="font-size:11px;color:{{ in_array($key, (array)$antecedentesExtra) ? '#9333ea' : '#94a3b8' }};font-weight:600;">
                                {{ in_array($key, (array)$antecedentesExtra) ? 'Sí' : 'Negado' }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- PERFIL DE PIEL --}}
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
            <div style="padding:14px 18px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;gap:8px;">
                <span style="width:26px;height:26px;border-radius:7px;background:#f3e8ff;color:#9333ea;display:flex;align-items:center;justify-content:center;font-size:12px;">🧴</span>
                <span style="font-size:13px;font-weight:700;">Perfil de Piel</span>
            </div>
            <div style="padding:18px;display:flex;flex-direction:column;gap:16px;">

                {{-- Fototipo --}}
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:8px;">Fototipo Fitzpatrick</label>
                    <div style="display:flex;gap:8px;">
                        @php $fitzColors = ['#fde8d8','#f5c9a0','#e8a87c','#c47c4a','#8b4513','#3d1c02']; @endphp
                        @foreach([1=>'Muy clara',2=>'Clara',3=>'Media',4=>'Morena',5=>'Oscura',6=>'Negra'] as $num => $label)
                        @php $isActive = old('fitzpatrick', $paciente->fitzpatrick) == $num; @endphp
                        <label style="flex:1;cursor:pointer;">
                            <input type="radio" name="fitzpatrick" value="{{ $num }}" {{ $isActive ? 'checked' : '' }} style="display:none;" class="fitz-radio">
                            <div class="fitz-card" style="border:1.5px solid {{ $isActive ? '#9333ea' : '#e2e8f0' }};border-radius:8px;padding:8px 4px;text-align:center;background:{{ $isActive ? '#faf5ff' : 'white' }};transition:all .15s;">
                                <div style="width:22px;height:22px;border-radius:50%;background:{{ $fitzColors[$num-1] }};margin:0 auto 4px;"></div>
                                <div style="font-size:11px;font-weight:700;color:#374151;">{{ $num }}</div>
                                <div style="font-size:9px;color:#94a3b8;">{{ $label }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Tipo de piel --}}
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:8px;">Tipo de piel</label>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;">
                        @php $tipoPielActual = old('tipo_piel', $paciente->tipo_piel ?? []); @endphp
                        @foreach(['Seca','Grasa','Mixta','Normal','Sensible'] as $tipo)
                        @php $isActive = in_array($tipo, (array)$tipoPielActual); @endphp
                        <label style="cursor:pointer;">
                            <input type="checkbox" name="tipo_piel[]" value="{{ $tipo }}" {{ $isActive ? 'checked' : '' }} style="display:none;" class="tag-check">
                            <div class="tag-pill" style="border:1.5px solid {{ $isActive ? '#9333ea' : '#e2e8f0' }};border-radius:20px;padding:5px 14px;font-size:12px;font-weight:600;color:{{ $isActive ? '#7c3aed' : '#374151' }};background:{{ $isActive ? '#faf5ff' : 'white' }};transition:all .15s;">{{ $tipo }}</div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Condiciones --}}
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:8px;">Condiciones presentes</label>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;">
                        @php $condActual = old('condiciones_piel', $paciente->condiciones_piel ?? []); @endphp
                        @foreach(['Arrugas finas','Líneas dinámicas','Flacidez','Manchas','Lesiones activas','Cicatrices','Poros dilatados'] as $cond)
                        @php $isActive = in_array($cond, (array)$condActual); @endphp
                        <label style="cursor:pointer;">
                            <input type="checkbox" name="condiciones_piel[]" value="{{ $cond }}" {{ $isActive ? 'checked' : '' }} style="display:none;" class="tag-check">
                            <div class="tag-pill" style="border:1.5px solid {{ $isActive ? '#9333ea' : '#e2e8f0' }};border-radius:20px;padding:5px 14px;font-size:12px;font-weight:600;color:{{ $isActive ? '#7c3aed' : '#374151' }};background:{{ $isActive ? '#faf5ff' : 'white' }};transition:all .15s;">{{ $cond }}</div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Nota médica --}}
                <div>
                    <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:8px;">Nota médica</label>
                    <textarea name="nota_medica" rows="3" placeholder="Observaciones generales, notas relevantes para tratamientos futuros..."
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:10px 12px;font-size:13px;outline:none;resize:vertical;font-family:'DM Sans',sans-serif;color:#1e293b;box-sizing:border-box;">{{ old('nota_medica', $paciente->nota_medica) }}</textarea>
                </div>

            </div>
        </div>

    </div>

    {{-- COLUMNA DERECHA --}}
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
                    <span style="font-family:monospace;font-weight:600;color:#1e293b;">{{ $paciente->numero_expediente }}</span>
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

<script>
document.querySelectorAll('.fitz-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.fitz-card').forEach(card => {
            card.style.borderColor = '#e2e8f0';
            card.style.background = 'white';
        });
        this.closest('label').querySelector('.fitz-card').style.borderColor = '#9333ea';
        this.closest('label').querySelector('.fitz-card').style.background = '#faf5ff';
    });
});
document.querySelectorAll('.tag-check').forEach(chk => {
    chk.addEventListener('change', function() {
        const pill = this.closest('label').querySelector('.tag-pill');
        if (this.checked) {
            pill.style.borderColor = '#9333ea';
            pill.style.color = '#7c3aed';
            pill.style.background = '#faf5ff';
        } else {
            pill.style.borderColor = '#e2e8f0';
            pill.style.color = '#374151';
            pill.style.background = 'white';
        }
    });
});
</script>

@endsection