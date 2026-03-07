@extends('layouts.medico')
@section('titulo', 'Nuevo Tratamiento')
@section('contenido')

<div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
    <a href="{{ route('medico.tipo-tratamientos.index') }}"
        style="display:inline-flex;align-items:center;gap:6px;padding:6px 13px;border-radius:8px;font-size:13px;font-weight:600;background:white;color:#64748b;border:1.5px solid #e2e8f0;text-decoration:none;">
        ← Volver
    </a>
    <h3 class="font-serif" style="font-size:21px;">Nuevo Tipo de Tratamiento</h3>
</div>

<div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:24px;max-width:580px;">
    <form action="{{ route('medico.tipo-tratamientos.store') }}" method="POST">
        @csrf

        @if($errors->any())
        <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px;">
            {{ $errors->first() }}
        </div>
        @endif

        <div style="margin-bottom:14px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.4px;">Grupo *</label>
            <select name="grupo" id="grupoSel" onchange="actualizarClaves()"
                style="width:100%;padding:9px 13px;border-radius:9px;border:1.5px solid #e2e8f0;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;background:white;">
                <option value="">Selecciona grupo...</option>
                @foreach(['A'=>'Neuromoduladores','B'=>'Rellenos / Hidratación','C'=>'Bioestimulación','D'=>'Lipolíticos / Corporales','E'=>'Piel Superficial'] as $g => $nombre)
                <option value="{{ $g }}" {{ old('grupo')==$g?'selected':'' }}>Grupo {{ $g }} — {{ $nombre }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:14px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.4px;">Tratamiento predefinido</label>
            <select id="claveSel" onchange="autocompletar()"
                style="width:100%;padding:9px 13px;border-radius:9px;border:1.5px solid #e2e8f0;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;background:white;">
                <option value="">— Selecciona uno o escribe abajo —</option>
            </select>
            <div style="font-size:11px;color:#94a3b8;margin-top:4px;">Selecciona para autocompletar, o escribe tu propio nombre abajo</div>
        </div>

        <div style="margin-bottom:14px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.4px;">Nombre del tratamiento *</label>
            <input type="text" name="nombre"
                style="width:100%;padding:9px 13px;border-radius:9px;border:1.5px solid #e2e8f0;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"
                value="{{ old('nombre') }}" placeholder="ej: Toxina Botulínica" required>
        </div>

        <input type="hidden" name="clave" id="claveHidden" value="{{ old('clave') }}">

        <div style="margin-bottom:14px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.4px;">Precio base *</label>
            <div style="display:flex;align-items:center;gap:0;">
                <span style="padding:9px 13px;background:#f8fafc;border:1.5px solid #e2e8f0;border-right:none;border-radius:9px 0 0 9px;font-size:13px;color:#64748b;">$</span>
                <input type="number" name="precio_base" min="0" step="0.01"
                    style="flex:1;padding:9px 13px;border-radius:0 9px 9px 0;border:1.5px solid #e2e8f0;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"
                    value="{{ old('precio_base', 0) }}" required>
            </div>
        </div>

        <div style="margin-bottom:14px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.4px;">Descripción</label>
            <textarea name="descripcion" rows="2"
                style="width:100%;padding:9px 13px;border-radius:9px;border:1.5px solid #e2e8f0;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;resize:vertical;"
                placeholder="Descripción breve opcional...">{{ old('descripcion') }}</textarea>
        </div>

        <div style="margin-bottom:14px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.4px;">Orden de aparición</label>
            <input type="number" name="orden" min="0"
                style="width:100px;padding:9px 13px;border-radius:9px;border:1.5px solid #e2e8f0;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;"
                value="{{ old('orden', 0) }}">
        </div>

        <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
            <input type="checkbox" name="activo" id="activo" value="1" {{ old('activo',true)?'checked':'' }}
                style="width:16px;height:16px;accent-color:#9333ea;cursor:pointer;">
            <label for="activo" style="font-size:13px;color:#374151;cursor:pointer;">Activo (aparece en formularios)</label>
        </div>

        <div style="display:flex;gap:10px;">
            <button type="submit"
                style="padding:9px 22px;border-radius:9px;font-size:13px;font-weight:600;background:#9333ea;color:white;border:none;cursor:pointer;">
                Guardar tratamiento
            </button>
            <a href="{{ route('medico.tipo-tratamientos.index') }}"
                style="padding:9px 18px;border-radius:9px;font-size:13px;font-weight:600;background:white;color:#64748b;border:1.5px solid #e2e8f0;text-decoration:none;">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
const claves = @json($claves);
function actualizarClaves() {
    const grupo = document.getElementById('grupoSel').value;
    const sel = document.getElementById('claveSel');
    sel.innerHTML = '<option value="">— Selecciona uno o escribe abajo —</option>';
    if (grupo && claves[grupo]) {
        Object.entries(claves[grupo]).forEach(([k, v]) => {
            sel.innerHTML += `<option value="${k}" data-nombre="${v}">${v}</option>`;
        });
    }
}
function autocompletar() {
    const sel = document.getElementById('claveSel');
    const opt = sel.options[sel.selectedIndex];
    if (!opt.value) return;
    document.querySelector('[name=nombre]').value = opt.dataset.nombre;
    document.getElementById('claveHidden').value = opt.value;
}
actualizarClaves();
</script>
@endsection
