@extends('layouts.medico')
@section('titulo', 'Nuevo Recibo')
@section('contenido')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
    <a href="{{ route('medico.pagos.index') }}" style="color:#94a3b8;text-decoration:none;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h3 class="font-serif" style="font-size:21px;">Nuevo Recibo</h3>
</div>

<form method="POST" action="{{ route('medico.pagos.store') }}">
@csrf
<div style="display:grid;grid-template-columns:1fr 320px;gap:18px;">

    <div style="display:flex;flex-direction:column;gap:14px;">

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;">Datos del recibo</h4>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div>
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Paciente *</label>
                    <select name="paciente_id" required style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                        <option value="">Seleccionar...</option>
                        @foreach($pacientes as $p)
                        <option value="{{ $p->id }}" {{ old('paciente_id', $pacienteSeleccionado?->id) == $p->id ? 'selected' : '' }}>
                            {{ $p->nombre_completo }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Fecha *</label>
                    <input type="date" name="fecha" value="{{ old('fecha', today()->format('Y-m-d')) }}" required
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                </div>
                <div style="grid-column:span 2;">
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Notas</label>
                    <textarea name="notas" rows="2" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;resize:vertical;">{{ old('notas') }}</textarea>
                </div>
            </div>
        </div>

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                <h4 style="font-size:13px;font-weight:700;">Conceptos</h4>
                <button type="button" onclick="agregarConcepto()"
                    style="display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:7px;font-size:12px;font-weight:600;background:#e0f2fe;color:#0284c7;border:none;cursor:pointer;">
                    <i class="fa-solid fa-plus"></i> Agregar
                </button>
            </div>
            <div id="conceptos">
                <div class="concepto-item" style="border:1.5px solid #e2e8f0;border-radius:10px;padding:14px;margin-bottom:10px;">
                    <div style="display:grid;grid-template-columns:1fr 80px 120px;gap:10px;align-items:end;">
                        <div>
                            <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Concepto *</label>
                            <input type="text" name="conceptos[0][concepto]" placeholder="Ej: Consulta médica" required
                                style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Cantidad *</label>
                            <input type="number" name="conceptos[0][cantidad]" value="1" min="1" required onchange="calcularTotal()"
                                style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Precio unitario *</label>
                            <input type="number" name="conceptos[0][precio_unitario]" value="0" min="0" step="0.01" required onchange="calcularTotal()"
                                style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                        </div>
                    </div>
                    <div style="margin-top:8px;">
                        <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Descripción</label>
                        <input type="text" name="conceptos[0][descripcion]" placeholder="Detalle opcional"
                            style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                    </div>
                </div>
            </div>

            <!-- Totales -->
            <div style="display:flex;justify-content:flex-end;margin-top:10px;">
                <div style="width:240px;background:#f8fafc;border-radius:10px;padding:14px;">
                    <div style="display:flex;justify-content:space-between;font-size:12px;color:#64748b;padding:4px 0;border-bottom:1px solid #e2e8f0;">
                        <span>Subtotal:</span><span id="txt-subtotal">$0.00</span>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;font-size:12px;color:#64748b;padding:6px 0;border-bottom:1px solid #e2e8f0;gap:8px;">
                        <span>Descuento:</span>
                        <input type="number" name="descuento" value="0" min="0" step="0.01" onchange="calcularTotal()"
                            style="width:80px;border:1.5px solid #e2e8f0;border-radius:6px;padding:3px 7px;font-size:12px;font-family:'DM Sans',sans-serif;outline:none;text-align:right;">
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;font-size:12px;color:#64748b;padding:6px 0;border-bottom:1px solid #e2e8f0;">
                        <label style="display:flex;align-items:center;gap:5px;cursor:pointer;">
                            <input type="checkbox" name="sin_impuesto" value="1" onchange="calcularTotal()"> Sin IVA
                        </label>
                        <span id="txt-iva">$0.00</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:15px;font-weight:700;padding:8px 0;color:#0284c7;">
                        <span>TOTAL:</span><span id="txt-total">$0.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:14px;">
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;">Acciones</h4>
            <button type="submit" style="width:100%;padding:10px;border-radius:9px;font-size:14px;font-weight:600;background:#0284c7;color:white;border:none;cursor:pointer;margin-bottom:8px;">
                <i class="fa-solid fa-floppy-disk"></i> Guardar recibo
            </button>
            <a href="{{ route('medico.pagos.index') }}" style="display:flex;align-items:center;justify-content:center;padding:9px;border-radius:9px;font-size:13px;font-weight:600;background:white;color:#64748b;border:1.5px solid #e2e8f0;text-decoration:none;">
                Cancelar
            </a>
        </div>

        @if($pacienteSeleccionado)
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:10px;">Paciente</h4>
            <div style="display:flex;align-items:center;gap:9px;">
                <div style="width:36px;height:36px;border-radius:50%;background:#e0f2fe;color:#0284c7;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;">
                    {{ strtoupper(substr($pacienteSeleccionado->nombre, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:13px;font-weight:600;">{{ $pacienteSeleccionado->nombre_completo }}</div>
                    <div style="font-size:11px;color:#64748b;">{{ $pacienteSeleccionado->expediente }}</div>
                </div>
            </div>
        </div>
        @endif
    </div>

</div>
</form>

<script>
let idx = 1;
function agregarConcepto() {
    const div = document.createElement('div');
    div.className = 'concepto-item';
    div.style.cssText = 'border:1.5px solid #e2e8f0;border-radius:10px;padding:14px;margin-bottom:10px;position:relative;';
    div.innerHTML = `
        <button type="button" onclick="this.parentElement.remove();calcularTotal()" style="position:absolute;top:10px;right:10px;background:#fee2e2;color:#e11d48;border:none;border-radius:5px;width:22px;height:22px;cursor:pointer;font-size:12px;">✕</button>
        <div style="display:grid;grid-template-columns:1fr 80px 120px;gap:10px;align-items:end;">
            <div>
                <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Concepto *</label>
                <input type="text" name="conceptos[${idx}][concepto]" placeholder="Ej: Consulta médica" required style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            </div>
            <div>
                <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Cantidad *</label>
                <input type="number" name="conceptos[${idx}][cantidad]" value="1" min="1" required onchange="calcularTotal()" style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            </div>
            <div>
                <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Precio unitario *</label>
                <input type="number" name="conceptos[${idx}][precio_unitario]" value="0" min="0" step="0.01" required onchange="calcularTotal()" style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
            </div>
        </div>
        <div style="margin-top:8px;">
            <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Descripción</label>
            <input type="text" name="conceptos[${idx}][descripcion]" placeholder="Detalle opcional" style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
        </div>`;
    document.getElementById('conceptos').appendChild(div);
    idx++;
}

function calcularTotal() {
    let subtotal = 0;
    document.querySelectorAll('.concepto-item').forEach(item => {
        const cant = parseFloat(item.querySelector('input[name*="[cantidad]"]')?.value || 0);
        const precio = parseFloat(item.querySelector('input[name*="[precio_unitario]"]')?.value || 0);
        subtotal += cant * precio;
    });
    const descuento = parseFloat(document.querySelector('input[name="descuento"]')?.value || 0);
    const sinIva = document.querySelector('input[name="sin_impuesto"]')?.checked;
    const iva = sinIva ? 0 : (subtotal - descuento) * 0.16;
    const total = subtotal - descuento + iva;
    document.getElementById('txt-subtotal').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('txt-iva').textContent = '$' + iva.toFixed(2);
    document.getElementById('txt-total').textContent = '$' + total.toFixed(2);
}
</script>
@endsection
