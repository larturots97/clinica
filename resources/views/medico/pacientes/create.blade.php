@extends('layouts.medico')
@section('titulo', 'Nuevo Paciente')
@section('contenido')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ route('medico.pacientes.index') }}" style="color:#94a3b8;text-decoration:none;"><i class="fa-solid fa-arrow-left"></i></a>
  <h3 style="font-size:20px;font-weight:700;margin:0;">Nuevo Paciente</h3>
</div>

<form action="{{ route('medico.pacientes.store') }}" method="POST">
@csrf
<div style="display:grid;grid-template-columns:1fr 340px;gap:18px;">

  {{-- COLUMNA PRINCIPAL --}}
  <div style="display:flex;flex-direction:column;gap:14px;">

    {{-- Datos personales --}}
    <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
      <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin:0 0 16px;">Datos personales</h4>
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Nombre *</label>
          <input type="text" name="nombre" value="{{ old('nombre') }}" required
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;">
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Apellido paterno *</label>
          <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;">
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Apellido materno</label>
          <input type="text" name="apellido_materno" value="{{ old('apellido_materno') }}"
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;">
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Fecha de nacimiento *</label>
          <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;">
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Sexo *</label>
          <select name="sexo" required style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;">
            <option value="">Seleccionar...</option>
            <option value="M" {{ old('sexo')=='M'?'selected':'' }}>Masculino</option>
            <option value="F" {{ old('sexo')=='F'?'selected':'' }}>Femenino</option>
            <option value="O" {{ old('sexo')=='O'?'selected':'' }}>Otro</option>
          </select>
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Teléfono</label>
          <input type="text" name="telefono" value="{{ old('telefono') }}"
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;">
        </div>
        <div style="grid-column:span 3;">
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Correo electrónico</label>
          <input type="email" name="email" value="{{ old('email') }}"
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;">
        </div>
      </div>
    </div>

    {{-- Antecedentes --}}
    <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
      <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin:0 0 16px;">Antecedentes médicos</h4>
      <div style="display:flex;flex-direction:column;gap:12px;">
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Alergias</label>
          <textarea name="alergias" rows="3" placeholder="Ej: Penicilina, látex..."
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;resize:vertical;font-family:'DM Sans',sans-serif;">{{ old('alergias') }}</textarea>
        </div>
        <div>
          <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;display:block;margin-bottom:5px;">Antecedentes patológicos</label>
          <textarea name="antecedentes" rows="3" placeholder="Ej: Diabetes, hipertensión..."
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;resize:vertical;font-family:'DM Sans',sans-serif;">{{ old('antecedentes') }}</textarea>
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
@endsection
