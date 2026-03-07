@extends('layouts.medico')

@section('titulo', 'Nueva Consulta')

@section('contenido')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
    <a href="{{ route('medico.historial.index') }}"
        style="color:#94a3b8;text-decoration:none;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h3 class="font-serif" style="font-size:21px;">Nueva Consulta</h3>
</div>

<form method="POST" action="{{ route('medico.historial.store') }}">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 340px;gap:18px;">

        <!-- Columna principal -->
        <div style="display:flex;flex-direction:column;gap:14px;">

            <!-- Paciente y fecha -->
            <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
                <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;gap:7px;">
                    <span style="width:26px;height:26px;border-radius:7px;background:#ffe4e6;color:#e11d48;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-user" style="font-size:11px;"></i>
                    </span>
                    Datos de la consulta
                </h4>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Paciente *</label>
                        <select name="paciente_id" required
                            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;color:#1e293b;">
                            <option value="">Seleccionar paciente...</option>
                            @foreach($pacientes as $paciente)
                            <option value="{{ $paciente->id }}" {{ (old('paciente_id', $pacienteSeleccionado?->id) == $paciente->id) ? 'selected' : '' }}>
                                {{ $paciente->nombre_completo }} — {{ $paciente->expediente }}
                            </option>
                            @endforeach
                        </select>
                        @error('paciente_id')<p style="color:#e11d48;font-size:11px;margin-top:3px;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Fecha *</label>
                        <input type="date" name="fecha" value="{{ old('fecha', today()->format('Y-m-d')) }}" required
                            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                        @error('fecha')<p style="color:#e11d48;font-size:11px;margin-top:3px;">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Motivo y diagnóstico -->
            <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
                <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;gap:7px;">
                    <span style="width:26px;height:26px;border-radius:7px;background:#ffe4e6;color:#e11d48;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-stethoscope" style="font-size:11px;"></i>
                    </span>
                    Información clínica
                </h4>
                <div style="display:flex;flex-direction:column;gap:14px;">
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Motivo de consulta *</label>
                        <textarea name="motivo_consulta" rows="2" required
                            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;resize:vertical;">{{ old('motivo_consulta') }}</textarea>
                        @error('motivo_consulta')<p style="color:#e11d48;font-size:11px;margin-top:3px;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Diagnóstico *</label>
                        <textarea name="diagnostico" rows="3" required
                            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;resize:vertical;">{{ old('diagnostico') }}</textarea>
                        @error('diagnostico')<p style="color:#e11d48;font-size:11px;margin-top:3px;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Tratamiento indicado</label>
                        <textarea name="tratamiento" rows="3"
                            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;resize:vertical;">{{ old('tratamiento') }}</textarea>
                    </div>
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Notas adicionales</label>
                        <textarea name="notas" rows="2"
                            style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;resize:vertical;">{{ old('notas') }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- Columna lateral -->
        <div style="display:flex;flex-direction:column;gap:14px;">
            <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
                <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;">Acciones</h4>
                <button type="submit"
                    style="width:100%;padding:10px;border-radius:9px;font-size:14px;font-weight:600;background:#e11d48;color:white;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;margin-bottom:8px;">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar consulta
                </button>
                <a href="{{ route('medico.historial.index') }}"
                    style="display:flex;align-items:center;justify-content:center;padding:9px;border-radius:9px;font-size:13px;font-weight:600;background:white;color:#64748b;border:1.5px solid #e2e8f0;text-decoration:none;">
                    Cancelar
                </a>
            </div>

            @if($pacienteSeleccionado)
            <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
                <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:10px;">Paciente</h4>
                <div style="display:flex;align-items:center;gap:9px;">
                    <div style="width:36px;height:36px;border-radius:50%;background:#ffe4e6;color:#e11d48;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;">
                        {{ strtoupper(substr($pacienteSeleccionado->nombre, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:600;">{{ $pacienteSeleccionado->nombre_completo }}</div>
                        <div style="font-size:11px;color:#64748b;">{{ $pacienteSeleccionado->expediente }}</div>
                    </div>
                </div>
                @if($pacienteSeleccionado->alergias)
                <div style="margin-top:10px;background:#fee2e2;border-radius:7px;padding:8px 10px;font-size:12px;color:#991b1b;">
                    <i class="fa-solid fa-triangle-exclamation" style="margin-right:4px;"></i>
                    <strong>Alergias:</strong> {{ $pacienteSeleccionado->alergias }}
                </div>
                @endif
            </div>
            @endif
        </div>

    </div>
</form>

@endsection
