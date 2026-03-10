@extends('layouts.medico')
@section('titulo', 'Detalle de Cita')
@section('contenido')

@php
$colores = ['pendiente'=>['bg'=>'#fef3c7','txt'=>'#d97706'],'confirmada'=>['bg'=>'#d1fae5','txt'=>'#059669'],'en_curso'=>['bg'=>'#ede9fe','txt'=>'#7c3aed'],'completada'=>['bg'=>'#f1f5f9','txt'=>'#64748b'],'cancelada'=>['bg'=>'#fee2e2','txt'=>'#dc2626']];
$c = $colores[$cita->estado] ?? ['bg'=>'#f1f5f9','txt'=>'#64748b'];
@endphp

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ route('medico.citas.index') }}" style="color:#94a3b8;text-decoration:none;"><i class="fa-solid fa-arrow-left"></i></a>
  <h3 style="font-size:20px;font-weight:700;margin:0;">Detalle de Cita</h3>
  <span style="background:{{ $c['bg'] }};color:{{ $c['txt'] }};font-size:11px;font-weight:700;padding:4px 12px;border-radius:20px;">{{ ucfirst($cita->estado) }}</span>
  <div style="margin-left:auto;display:flex;gap:8px;">
    <button onclick="enviarWhatsApp({{ $cita->id }})" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;background:#dcfce7;color:#059669;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">
      <i class="fa-brands fa-whatsapp"></i> WhatsApp
    </button>
    <button onclick="document.getElementById('modalEstado').style.display='flex'" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;background:#9333ea;color:white;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">
      <i class="fa-solid fa-pen"></i> Cambiar estado
    </button>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 280px;gap:18px;">

  {{-- INFO PRINCIPAL --}}
  <div style="display:flex;flex-direction:column;gap:14px;">

    {{-- Fecha y hora --}}
    <div style="background:linear-gradient(135deg,#9333ea,#7c3aed);border-radius:13px;padding:22px 24px;color:white;">
      <div style="font-size:11px;opacity:.7;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">Fecha y hora de la cita</div>
      <div style="font-size:24px;font-weight:700;">{{ $cita->fecha_hora->locale('es')->isoFormat('dddd D [de] MMMM, YYYY') }}</div>
      <div style="font-size:16px;opacity:.85;margin-top:4px;">
        <i class="fa-solid fa-clock" style="margin-right:6px;"></i>{{ $cita->fecha_hora->format('h:i A') }}
        <span style="opacity:.6;margin:0 8px;">·</span>
        <i class="fa-solid fa-hourglass-half" style="margin-right:6px;"></i>{{ $cita->duracion_minutos }} minutos
      </div>
    </div>

    {{-- Paciente --}}
    <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
      <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin:0 0 14px;">Paciente</h4>
      <div style="display:flex;align-items:center;gap:14px;margin-bottom:14px;">
        <div style="width:48px;height:48px;border-radius:50%;background:#ede9fe;color:#7c3aed;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;flex-shrink:0;">
          {{ strtoupper(substr($cita->paciente->nombre, 0, 1)) }}
        </div>
        <div>
          <div style="font-size:15px;font-weight:700;">{{ $cita->paciente->nombre }} {{ $cita->paciente->apellidos }}</div>
          <div style="font-size:12px;color:#94a3b8;">Exp. {{ $cita->paciente->expediente ?? '—' }}</div>
        </div>
        <a href="{{ route('medico.pacientes.show', $cita->paciente) }}" style="margin-left:auto;padding:6px 12px;background:#f1f5f9;border-radius:7px;font-size:12px;font-weight:600;color:#374151;text-decoration:none;">Ver perfil</a>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div>
          <div style="font-size:11px;color:#94a3b8;margin-bottom:2px;">Teléfono</div>
          <div style="font-size:13px;font-weight:600;">{{ $cita->paciente->telefono ?? '—' }}</div>
        </div>
        <div>
          <div style="font-size:11px;color:#94a3b8;margin-bottom:2px;">Correo</div>
          <div style="font-size:13px;font-weight:600;">{{ $cita->paciente->email ?? '—' }}</div>
        </div>
      </div>
    </div>

    {{-- Motivo y notas --}}
    <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:20px;">
      <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin:0 0 14px;">Motivo y observaciones</h4>
      @if($cita->motivo)
      <div style="margin-bottom:12px;">
        <div style="font-size:11px;color:#94a3b8;margin-bottom:4px;">Motivo</div>
        <div style="font-size:13px;font-weight:600;">{{ $cita->motivo }}</div>
      </div>
      @endif
      @if($cita->tipoTratamiento)
      <div style="margin-bottom:12px;">
        <div style="font-size:11px;color:#94a3b8;margin-bottom:4px;">Tipo de tratamiento</div>
        <div style="font-size:13px;font-weight:600;">{{ $cita->tipoTratamiento->nombre }}</div>
      </div>
      @endif
      @if($cita->notas)
      <div>
        <div style="font-size:11px;color:#94a3b8;margin-bottom:4px;">Notas</div>
        <div style="font-size:13px;color:#374151;line-height:1.6;">{{ $cita->notas }}</div>
      </div>
      @endif
      @if(!$cita->motivo && !$cita->notas)
      <div style="color:#94a3b8;font-size:13px;">Sin observaciones registradas.</div>
      @endif
    </div>

  </div>

  {{-- COLUMNA LATERAL --}}
  <div style="display:flex;flex-direction:column;gap:14px;">

    {{-- Acciones rápidas --}}
    <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:16px;">
      <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:12px;">Cambiar estado</div>
      @foreach(['pendiente'=>'#f59e0b','confirmada'=>'#10b981','en_curso'=>'#6366f1','completada'=>'#64748b','cancelada'=>'#ef4444'] as $estado=>$color)
      <button onclick="cambiarEstado('{{ $estado }}')"
        style="width:100%;margin-bottom:6px;padding:8px 12px;border-radius:8px;font-size:12px;font-weight:600;border:2px solid {{ $cita->estado===$estado ? $color : '#e2e8f0' }};background:{{ $cita->estado===$estado ? $color : 'white' }};color:{{ $cita->estado===$estado ? 'white' : '#374151' }};cursor:pointer;text-align:left;display:flex;align-items:center;gap:8px;">
        <span style="width:8px;height:8px;border-radius:50%;background:{{ $color }};flex-shrink:0;"></span>
        {{ ucfirst($estado) }}
        @if($cita->estado===$estado)<i class="fa-solid fa-check" style="margin-left:auto;"></i>@endif
      </button>
      @endforeach
    </div>

    {{-- Notificaciones --}}
    <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;padding:16px;">
      <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;margin-bottom:12px;">Notificar paciente</div>
      <button onclick="enviarWhatsApp({{ $cita->id }})" style="width:100%;padding:9px;background:#dcfce7;color:#059669;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:8px;">
        <i class="fa-brands fa-whatsapp"></i> Enviar WhatsApp
      </button>
      <div style="font-size:10px;color:#94a3b8;text-align:center;">El correo se envió automáticamente al agendar</div>
      @if($cita->recordatorio_enviado)
      <div style="margin-top:8px;padding:6px 10px;background:#f0fdf4;border-radius:6px;font-size:11px;color:#059669;text-align:center;">
        <i class="fa-solid fa-check"></i> Recordatorio enviado
      </div>
      @endif
    </div>

    {{-- Info --}}
    <div style="background:#f8fafc;border-radius:13px;border:1px solid #e2e8f0;padding:14px;">
      <div style="font-size:11px;color:#94a3b8;margin-bottom:4px;">Agendada el</div>
      <div style="font-size:12px;font-weight:600;">{{ $cita->created_at->locale('es')->isoFormat('D MMM YYYY, h:mm A') }}</div>
    </div>

  </div>
</div>

<script>
async function cambiarEstado(estado) {
  const res = await fetch('{{ route("medico.citas.estado", $cita) }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
    body: JSON.stringify({ estado }),
  });
  const data = await res.json();
  if (data.success) window.location.reload();
}

async function enviarWhatsApp(citaId) {
  const res = await fetch(`/medico/citas/${citaId}/whatsapp`);
  const data = await res.json();
  if (data.url) window.open(data.url, '_blank');
}
</script>

@endsection
