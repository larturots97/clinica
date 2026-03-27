@extends('layouts.medico')
@section('titulo', 'Nuevo Paciente')
@section('contenido')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ route('medico.pacientes.index') }}" style="color:#94a3b8;text-decoration:none;"><i class="fa-solid fa-arrow-left"></i></a>
  <h3 style="font-size:20px;font-weight:700;margin:0;">Nuevo Paciente</h3>
</div>

<form action="{{ route('medico.pacientes.store') }}" method="POST">
@csrf
  @if(isset($citaWeb) && $citaWeb)
  <input type="hidden" name="cita_web_id" value="{{ $citaWeb->id }}">
  <div style="background:#ede9fe;border:1px solid #ddd6fe;border-radius:10px;padding:12px 16px;margin-bottom:16px;font-size:12px;color:#7c3aed;display:flex;gap:8px;align-items:center;">
      <i class="fas fa-globe"></i>
      <span>Registrando a <strong>{{ $citaWeb->nombre_visitante }}</strong> desde solicitud web. La cita quedará vinculada automáticamente.</span>
  </div>
  @endif
<div style="display:grid;grid-template-columns:1fr 340px;gap:18px;">

  {{-- COLUMNA PRINCIPAL --}}
  <div style="display:flex;flex-direction:column;gap:14px;">

    {{-- DATOS PERSONALES --}}
    <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
      <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin:0 0 16px;">
        <i class="fa-solid fa-user" style="margin-right:6px;color:#0ea5a0;"></i> Datos personales
      </h4>
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Nombre *</label>
          <input type="text" name="nombre" value="{{ old('nombre') }}" required
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Apellido paterno *</label>
          <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Apellido materno</label>
          <input type="text" name="apellido_materno" value="{{ old('apellido_materno') }}"
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Fecha de nacimiento *</label>
          <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Sexo *</label>
          <select name="sexo" required style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
            <option value="">Seleccionar...</option>
            <option value="M" {{ old('sexo')=='M'?'selected':'' }}>Masculino</option>
            <option value="F" {{ old('sexo')=='F'?'selected':'' }}>Femenino</option>
            <option value="O" {{ old('sexo')=='O'?'selected':'' }}>Otro</option>
          </select>
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Teléfono</label>
          <input type="text" name="telefono" value="{{ old('telefono') }}"
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Tipo de sangre</label>
          <select name="tipo_sangre" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
            <option value="">No especificado</option>
            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $tipo)
            <option value="{{ $tipo }}" {{ old('tipo_sangre') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
            @endforeach
          </select>
        </div>
        <div style="grid-column:span 3;">
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Correo electrónico</label>
          <input type="email" name="email" value="{{ old('email') }}"
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
        </div>
        <div style="grid-column:span 2;">
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Dirección</label>
          <input type="text" name="direccion" value="{{ old('direccion') }}" placeholder="Calle, número, colonia..."
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;box-sizing:border-box;">
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Ocupación</label>
          <input type="text" name="ocupacion" value="{{ old('ocupacion') }}" placeholder="Ej: Docente, estudiante..."
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
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;resize:vertical;font-family:'DM Sans',sans-serif;box-sizing:border-box;">{{ old('alergias') }}</textarea>
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Antecedentes patológicos</label>
          <textarea name="antecedentes" rows="2" placeholder="Ej: Diabetes, hipertensión..."
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;resize:vertical;font-family:'DM Sans',sans-serif;box-sizing:border-box;">{{ old('antecedentes') }}</textarea>
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:8px;">Antecedentes adicionales</label>
          <div style="display:flex;flex-direction:column;gap:6px;">
            @foreach([
              'embarazo_lactancia' => 'Embarazo o lactancia',
              'enf_neuromuscular'  => 'Enf. neuromuscular',
              'medicacion_actual'  => 'Medicación actual',
              'cirugias_previas'   => 'Cirugías previas',
              'tabaco_alcohol'     => 'Consumo tabaco/alcohol',
            ] as $key => $label)
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:12px;color:#374151;">
              <input type="checkbox" name="antecedentes_extra[]" value="{{ $key }}"
                {{ in_array($key, (array)old('antecedentes_extra', [])) ? 'checked' : '' }}
                style="width:15px;height:15px;accent-color:#9333ea;cursor:pointer;">
              {{ $label }}
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
        <span style="font-size:11px;color:#94a3b8;margin-left:4px;">(opcional)</span>
      </div>
      <div style="padding:18px;display:flex;flex-direction:column;gap:16px;">

        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:8px;">Fototipo Fitzpatrick</label>
          <div style="display:flex;gap:8px;">
            @php $fitzColors = ['#fde8d8','#f5c9a0','#e8a87c','#c47c4a','#8b4513','#3d1c02']; @endphp
            @foreach([1=>'Muy clara',2=>'Clara',3=>'Media',4=>'Morena',5=>'Oscura',6=>'Negra'] as $num => $lbl)
            @php $isActive = old('fitzpatrick') == $num; @endphp
            <label style="flex:1;cursor:pointer;">
              <input type="radio" name="fitzpatrick" value="{{ $num }}" {{ $isActive ? 'checked' : '' }} style="display:none;" class="fitz-radio">
              <div class="fitz-card" style="border:1.5px solid {{ $isActive ? '#9333ea' : '#e2e8f0' }};border-radius:8px;padding:8px 4px;text-align:center;background:{{ $isActive ? '#faf5ff' : 'white' }};transition:all .15s;">
                <div style="width:22px;height:22px;border-radius:50%;background:{{ $fitzColors[$num-1] }};margin:0 auto 4px;"></div>
                <div style="font-size:11px;font-weight:700;color:#374151;">{{ $num }}</div>
                <div style="font-size:9px;color:#94a3b8;">{{ $lbl }}</div>
              </div>
            </label>
            @endforeach
          </div>
        </div>

        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:8px;">Tipo de piel</label>
          <div style="display:flex;flex-wrap:wrap;gap:8px;">
            @foreach(['Seca','Grasa','Mixta','Normal','Sensible'] as $tipo)
            @php $isActive = in_array($tipo, (array)old('tipo_piel', [])); @endphp
            <label style="cursor:pointer;">
              <input type="checkbox" name="tipo_piel[]" value="{{ $tipo }}" {{ $isActive ? 'checked' : '' }} style="display:none;" class="tag-check">
              <div class="tag-pill" style="border:1.5px solid {{ $isActive ? '#9333ea' : '#e2e8f0' }};border-radius:20px;padding:5px 14px;font-size:12px;font-weight:600;color:{{ $isActive ? '#7c3aed' : '#374151' }};background:{{ $isActive ? '#faf5ff' : 'white' }};transition:all .15s;">{{ $tipo }}</div>
            </label>
            @endforeach
          </div>
        </div>

        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:8px;">Condiciones presentes</label>
          <div style="display:flex;flex-wrap:wrap;gap:8px;">
            @foreach(['Arrugas finas','Líneas dinámicas','Flacidez','Manchas','Lesiones activas','Cicatrices','Poros dilatados'] as $cond)
            @php $isActive = in_array($cond, (array)old('condiciones_piel', [])); @endphp
            <label style="cursor:pointer;">
              <input type="checkbox" name="condiciones_piel[]" value="{{ $cond }}" {{ $isActive ? 'checked' : '' }} style="display:none;" class="tag-check">
              <div class="tag-pill" style="border:1.5px solid {{ $isActive ? '#9333ea' : '#e2e8f0' }};border-radius:20px;padding:5px 14px;font-size:12px;font-weight:600;color:{{ $isActive ? '#7c3aed' : '#374151' }};background:{{ $isActive ? '#faf5ff' : 'white' }};transition:all .15s;">{{ $cond }}</div>
            </label>
            @endforeach
          </div>
        </div>

        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:8px;">Nota médica</label>
          <textarea name="nota_medica" rows="3" placeholder="Observaciones generales, notas relevantes para tratamientos futuros..."
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:10px 12px;font-size:13px;outline:none;resize:vertical;font-family:'DM Sans',sans-serif;color:#1e293b;box-sizing:border-box;">{{ old('nota_medica') }}</textarea>
        </div>

      </div>
    </div>

  </div>

  {{-- COLUMNA LATERAL --}}
  <div style="display:flex;flex-direction:column;gap:14px;">
    <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
      <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin:0 0 14px;">Resumen</h4>
      <p style="font-size:12px;color:#94a3b8;line-height:1.6;margin:0 0 16px;">Complete los datos del paciente. Se generará un número de expediente automáticamente.</p>
      <button type="submit" style="width:100%;padding:10px;background:#0ea5a0;color:white;border:none;border-radius:9px;font-size:13px;font-weight:700;cursor:pointer;">
        <i class="fa-solid fa-user-plus" style="margin-right:6px;"></i> Registrar paciente
      </button>
      <a href="{{ route('medico.pacientes.index') }}" style="display:block;text-align:center;margin-top:10px;font-size:12px;color:#94a3b8;text-decoration:none;">Cancelar</a>
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