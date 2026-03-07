@extends('layouts.medico')
@section('titulo', 'Recibo ' . $pago->folio)
@section('contenido')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
    <div style="display:flex;align-items:center;gap:10px;">
        <a href="{{ route('medico.pagos.index') }}" style="color:#94a3b8;text-decoration:none;">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h3 class="font-serif" style="font-size:21px;">Recibo</h3>
        <span style="background:#e0f2fe;color:#0284c7;font-size:12px;font-weight:700;padding:3px 10px;border-radius:6px;font-family:monospace;">{{ $pago->folio }}</span>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="{{ route('medico.pagos.pdf', $pago) }}" target="_blank"
            style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:13px;font-weight:600;background:#0284c7;color:white;text-decoration:none;">
            <i class="fa-solid fa-file-pdf"></i> PDF
        </a>
        <button type="button" onclick="document.getElementById('modal-correo').style.display='flex'"
            style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:13px;font-weight:600;background:#059669;color:white;border:none;cursor:pointer;">
            <i class="fa-solid fa-envelope"></i> Enviar por correo
        </button>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 280px;gap:18px;">

    <div style="display:flex;flex-direction:column;gap:14px;">

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:14px;">Conceptos</h4>
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead>
                    <tr style="background:#f8fafc;border-radius:8px;">
                        <th style="padding:8px 12px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;color:#64748b;">Concepto</th>
                        <th style="padding:8px 12px;text-align:center;font-size:10px;font-weight:700;text-transform:uppercase;color:#64748b;">Cant.</th>
                        <th style="padding:8px 12px;text-align:right;font-size:10px;font-weight:700;text-transform:uppercase;color:#64748b;">Precio</th>
                        <th style="padding:8px 12px;text-align:right;font-size:10px;font-weight:700;text-transform:uppercase;color:#64748b;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pago->items as $item)
                    <tr style="border-bottom:1px solid #f1f5f9;">
                        <td style="padding:10px 12px;">
                            <div style="font-weight:600;">{{ $item->concepto }}</div>
                            @if($item->descripcion)<div style="font-size:11px;color:#94a3b8;">{{ $item->descripcion }}</div>@endif
                        </td>
                        <td style="padding:10px 12px;text-align:center;">{{ $item->cantidad }}</td>
                        <td style="padding:10px 12px;text-align:right;">${{ number_format($item->precio_unitario, 2) }}</td>
                        <td style="padding:10px 12px;text-align:right;font-weight:600;">${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="display:flex;justify-content:flex-end;margin-top:14px;">
                <div style="width:220px;">
                    <div style="display:flex;justify-content:space-between;font-size:12px;color:#64748b;padding:5px 0;border-bottom:1px solid #f1f5f9;">
                        <span>Subtotal:</span><span>${{ number_format($pago->subtotal, 2) }}</span>
                    </div>
                    @if($pago->descuento > 0)
                    <div style="display:flex;justify-content:space-between;font-size:12px;color:#e11d48;padding:5px 0;border-bottom:1px solid #f1f5f9;">
                        <span>Descuento:</span><span>-${{ number_format($pago->descuento, 2) }}</span>
                    </div>
                    @endif
                    <div style="display:flex;justify-content:space-between;font-size:12px;color:#64748b;padding:5px 0;border-bottom:1px solid #f1f5f9;">
                        <span>IVA (16%):</span><span>${{ number_format($pago->impuesto, 2) }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:16px;font-weight:700;color:#0284c7;padding:8px 0;">
                        <span>TOTAL:</span><span>${{ number_format($pago->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actualizar estado -->
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
            <h4 style="font-size:13px;font-weight:700;margin-bottom:14px;">Actualizar estado de pago</h4>
            <form method="POST" action="{{ route('medico.pagos.update', $pago) }}">
                @csrf @method('PUT')
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Estado</label>
                        <select name="estado" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                            <option value="pendiente" {{ $pago->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="pagada" {{ $pago->estado === 'pagada' ? 'selected' : '' }}>Pagada</option>
                            <option value="cancelada" {{ $pago->estado === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Método de pago</label>
                        <select name="metodo_pago" style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;">
                            <option value="">Sin definir</option>
                            <option value="efectivo" {{ $pago->metodo_pago === 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="tarjeta" {{ $pago->metodo_pago === 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                            <option value="transferencia" {{ $pago->metodo_pago === 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                            <option value="otro" {{ $pago->metodo_pago === 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                </div>
                <button type="submit" style="margin-top:12px;padding:8px 20px;border-radius:8px;font-size:13px;font-weight:600;background:#0284c7;color:white;border:none;cursor:pointer;">
                    Actualizar
                </button>
            </form>
        </div>

    </div>

    <!-- Lateral -->
    <div style="display:flex;flex-direction:column;gap:14px;">

        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:12px;">Paciente</h4>
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:10px;">
                <div style="width:36px;height:36px;border-radius:50%;background:#e0f2fe;color:#0284c7;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;">
                    {{ strtoupper(substr($pago->paciente->nombre, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:13px;font-weight:600;">{{ $pago->paciente->nombre_completo }}</div>
                    <div style="font-size:11px;color:#64748b;">{{ $pago->paciente->email ?? 'Sin correo' }}</div>
                </div>
            </div>
            <a href="{{ route('medico.pacientes.show', $pago->paciente) }}"
                style="display:flex;align-items:center;justify-content:center;gap:6px;padding:8px;border-radius:8px;font-size:12px;font-weight:600;background:#e0f2fe;color:#0284c7;text-decoration:none;">
                <i class="fa-solid fa-user"></i> Ver expediente
            </a>
        </div>

        <!-- Logo y firma -->
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:18px;">
            <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;margin-bottom:12px;">Mi logo y firma</h4>

            <!-- Logo -->
            <div style="margin-bottom:14px;">
                <div style="font-size:12px;font-weight:600;color:#374151;margin-bottom:6px;">Logo del médico</div>
                @if($pago->medico->logo)
                <img src="{{ Storage::url($pago->medico->logo) }}" style="width:80px;height:80px;object-fit:contain;border-radius:8px;border:1px solid #e2e8f0;margin-bottom:6px;display:block;">
                @else
                <div style="width:80px;height:80px;border-radius:8px;border:1.5px dashed #e2e8f0;display:flex;align-items:center;justify-content:center;margin-bottom:6px;">
                    <i class="fa-solid fa-image" style="color:#cbd5e1;font-size:20px;"></i>
                </div>
                @endif
                <form method="POST" action="{{ route('medico.perfil.logo') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="logo" accept="image/*" onchange="this.form.submit()"
                        style="font-size:11px;color:#64748b;width:100%;">
                </form>
            </div>

            <!-- Firma -->
            <div>
                <div style="font-size:12px;font-weight:600;color:#374151;margin-bottom:6px;">Firma del médico</div>
                @if($pago->medico->firma)
                <img src="{{ Storage::url($pago->medico->firma) }}" style="width:120px;height:50px;object-fit:contain;border-radius:8px;border:1px solid #e2e8f0;margin-bottom:6px;display:block;">
                @else
                <div style="width:120px;height:50px;border-radius:8px;border:1.5px dashed #e2e8f0;display:flex;align-items:center;justify-content:center;margin-bottom:6px;">
                    <i class="fa-solid fa-signature" style="color:#cbd5e1;font-size:16px;"></i>
                </div>
                @endif
                <form method="POST" action="{{ route('medico.perfil.firma') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="firma" accept="image/*" onchange="this.form.submit()"
                        style="font-size:11px;color:#64748b;width:100%;">
                </form>
            </div>
        </div>

    </div>
</div>
<!-- Modal enviar correo -->
<div id="modal-correo" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:999;align-items:center;justify-content:center;">
    <div style="background:white;border-radius:16px;padding:28px;width:100%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,0.2);position:relative;">

        <!-- Cerrar -->
        <button onclick="document.getElementById('modal-correo').style.display='none'"
            style="position:absolute;top:14px;right:14px;background:#f1f5f9;border:none;border-radius:8px;width:30px;height:30px;cursor:pointer;font-size:16px;color:#64748b;">✕</button>

        <!-- Icono + título -->
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
            <div style="width:46px;height:46px;border-radius:12px;background:#d1fae5;color:#059669;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div>
                <div style="font-size:16px;font-weight:700;color:#1e293b;">Enviar recibo por correo</div>
                <div style="font-size:12px;color:#64748b;">{{ $pago->folio }} · ${{ number_format($pago->total, 2) }}</div>
            </div>
        </div>

        <!-- Paciente info -->
        <div style="background:#f8fafc;border-radius:10px;padding:12px 14px;margin-bottom:16px;display:flex;align-items:center;gap:10px;">
            <div style="width:36px;height:36px;border-radius:50%;background:#e0f2fe;color:#0284c7;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0;">
                {{ strtoupper(substr($pago->paciente->nombre, 0, 1)) }}
            </div>
            <div>
                <div style="font-size:13px;font-weight:600;">{{ $pago->paciente->nombre_completo }}</div>
                <div style="font-size:11px;color:#64748b;">Expediente: {{ $pago->paciente->numero_expediente }}</div>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('medico.pagos.correo', $pago) }}">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">
                    <i class="fa-solid fa-envelope" style="color:#059669;margin-right:4px;"></i>
                    Correo electrónico del paciente
                </label>
                <input type="email" name="email_destino"
                    value="{{ $pago->paciente->email ?? '' }}"
                    placeholder="correo@ejemplo.com"
                    required
                    style="width:100%;border:1.5px solid #e2e8f0;border-radius:9px;padding:10px 13px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;transition:border 0.2s;"
                    onfocus="this.style.borderColor='#059669'" onblur="this.style.borderColor='#e2e8f0'">
                <div style="font-size:11px;color:#94a3b8;margin-top:5px;">
                    <i class="fa-solid fa-circle-info" style="margin-right:3px;"></i>
                    Puedes editar el correo antes de enviar. El PDF se adjuntará automáticamente.
                </div>
            </div>

            <!-- Guardar email si se cambia -->
            <label style="display:flex;align-items:center;gap:8px;font-size:12px;color:#64748b;margin-bottom:18px;cursor:pointer;">
                <input type="checkbox" name="guardar_email" value="1" style="width:15px;height:15px;accent-color:#059669;">
                Guardar este correo en el expediente del paciente
            </label>

            <div style="display:flex;gap:10px;">
                <button type="button" onclick="document.getElementById('modal-correo').style.display='none'"
                    style="flex:1;padding:10px;border-radius:9px;font-size:13px;font-weight:600;background:white;color:#64748b;border:1.5px solid #e2e8f0;cursor:pointer;">
                    Cancelar
                </button>
                <button type="submit"
                    style="flex:2;padding:10px;border-radius:9px;font-size:13px;font-weight:600;background:#059669;color:white;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;">
                    <i class="fa-solid fa-paper-plane"></i> Enviar recibo
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
