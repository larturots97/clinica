@extends('layouts.medico')
@section('titulo', 'Nueva Receta')
@section('contenido')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
    <a href="{{ route('medico.recetas.index') }}" style="color:#94a3b8;text-decoration:none;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h3 class="font-serif" style="font-size:21px;">Nueva Receta</h3>
</div>

<form method="POST" action="{{ route('medico.recetas.store') }}">
@csrf
<div style="display:grid;grid-template-columns:1fr 320px;gap:18px;">

    <div style="display:flex;flex-direction:column;gap:14px;">

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;">Datos de la receta</h4>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div>
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Paciente *</label>
                    <select name="paciente_id" required style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                        <option value="">Seleccionar...</option>
                        @foreach($pacientes as $p)
                        <option value="{{ $p->id }}" {{ old('paciente_id', $pacienteSeleccionado?->id) == $p->id ? 'selected' : '' }}>
                            {{ $p->nombre_completo }} — {{ $p->expediente }}
                        </option>
                        @endforeach
                    </select>
                    @error('paciente_id')<p style="color:#e11d48;font-size:11px;margin-top:3px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Fecha *</label>
                    <input type="date" name="fecha" value="{{ old('fecha', today()->format('Y-m-d')) }}" required
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                </div>
                <div style="grid-column:span 2;">
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Diagnóstico</label>
                    <input type="text" name="diagnostico" value="{{ old('diagnostico') }}" placeholder="Diagnóstico principal..."
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                </div>
                <div style="grid-column:span 2;">
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Indicaciones generales</label>
                    <textarea name="indicaciones" rows="2" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;resize:vertical;">{{ old('indicaciones') }}</textarea>
                </div>
            </div>
        </div>

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                <h4 style="font-size:13px;font-weight:700;">Medicamentos</h4>
                <button type="button" onclick="agregarMedicamento()"
                    style="display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:7px;font-size:12px;font-weight:600;background:#ede9fe;color:#7c3aed;border:none;cursor:pointer;">
                    <i class="fa-solid fa-plus"></i> Agregar
                </button>
            </div>
            <div id="medicamentos">
                <div class="medicamento-item" style="border:1.5px solid #e2e8f0;border-radius:10px;padding:14px;margin-bottom:10px;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                        <div style="grid-column:span 2;">
                            <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Medicamento *</label>
                            <input type="text" name="medicamentos[0][nombre]" placeholder="Nombre del medicamento" required
                                style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Dosis *</label>
                            <input type="text" name="medicamentos[0][dosis]" placeholder="ej. 500mg" required
                                style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Frecuencia *</label>
                            <input type="text" name="medicamentos[0][frecuencia]" placeholder="ej. Cada 8 horas" required
                                style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Duración</label>
                            <input type="text" name="medicamentos[0][duracion]" placeholder="ej. 7 días"
                                style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Indicaciones</label>
                            <input type="text" name="medicamentos[0][indicaciones]" placeholder="ej. Tomar con alimentos"
                                style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div style="display:flex;flex-direction:column;gap:14px;">
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;">Acciones</h4>
            <button type="submit" style="width:100%;padding:10px;border-radius:9px;font-size:14px;font-weight:600;background:#7c3aed;color:white;border:none;cursor:pointer;margin-bottom:8px;">
                <i class="fa-solid fa-floppy-disk"></i> Guardar receta
            </button>
            <a href="{{ route('medico.recetas.index') }}" style="display:flex;align-items:center;justify-content:center;padding:9px;border-radius:9px;font-size:13px;font-weight:600;background:white;color:#64748b;border:1.5px solid #e2e8f0;text-decoration:none;">
                Cancelar
            </a>
        </div>
        @if($pacienteSeleccionado)
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:10px;">Paciente</h4>
            <div style="display:flex;align-items:center;gap:9px;">
                <div style="width:36px;height:36px;border-radius:50%;background:#ede9fe;color:#7c3aed;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;">
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

<script>
let idx = 1;
function agregarMedicamento() {
    const div = document.createElement('div');
    div.className = 'medicamento-item';
    div.style.cssText = 'border:1.5px solid #e2e8f0;border-radius:10px;padding:14px;margin-bottom:10px;position:relative;';
    div.innerHTML = `
        <button type="button" onclick="this.parentElement.remove()" style="position:absolute;top:10px;right:10px;background:#fee2e2;color:#e11d48;border:none;border-radius:5px;width:22px;height:22px;cursor:pointer;font-size:12px;">✕</button>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
            <div style="grid-column:span 2;">
                <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Medicamento *</label>
                <input type="text" name="medicamentos[${idx}][nombre]" placeholder="Nombre del medicamento" required style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            </div>
            <div>
                <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Dosis *</label>
                <input type="text" name="medicamentos[${idx}][dosis]" placeholder="ej. 500mg" required style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            </div>
            <div>
                <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Frecuencia *</label>
                <input type="text" name="medicamentos[${idx}][frecuencia]" placeholder="ej. Cada 8 horas" required style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            </div>
            <div>
                <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Duración</label>
                <input type="text" name="medicamentos[${idx}][duracion]" placeholder="ej. 7 días" style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            </div>
            <div>
                <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Indicaciones</label>
                <input type="text" name="medicamentos[${idx}][indicaciones]" placeholder="ej. Tomar con alimentos" style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            </div>
        </div>`;
    document.getElementById('medicamentos').appendChild(div);
    idx++;
}
</script>
@endsection
