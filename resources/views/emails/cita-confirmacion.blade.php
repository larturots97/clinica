<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Confirmaci√≥n de cita</title></head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:30px 0;">
  <tr><td align="center">
    <table width="560" cellpadding="0" cellspacing="0" style="background:white;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.08);">

      {{-- Header --}}
      <tr>
        <td style="background:linear-gradient(135deg,#9333ea,#7c3aed);padding:32px;text-align:center;">
          <div style="font-size:28px;margin-bottom:8px;">Ì≥Ö</div>
          <h1 style="color:white;font-size:22px;margin:0;font-weight:700;">Cita Confirmada</h1>
          <p style="color:rgba(255,255,255,.8);font-size:14px;margin:6px 0 0;">Le esperamos en nuestra cl√≠nica</p>
        </td>
      </tr>

      {{-- Contenido --}}
      <tr>
        <td style="padding:32px;">
          <p style="font-size:15px;color:#374151;margin:0 0 24px;">Hola <strong>{{ $cita->paciente->nombre }}</strong>,</p>
          <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0 0 24px;">
            Su cita ha sido registrada exitosamente. A continuaci√≥n encontrar√° los detalles:
          </p>

          {{-- Detalles cita --}}
          <table width="100%" cellpadding="0" cellspacing="0" style="background:#faf5ff;border-radius:12px;overflow:hidden;margin-bottom:24px;">
            <tr>
              <td style="padding:16px 20px;border-bottom:1px solid #ede9fe;">
                <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#7c3aed;">Ì≥Ü Fecha</span>
                <p style="font-size:16px;font-weight:700;color:#1e293b;margin:4px 0 0;">
                  {{ \Carbon\Carbon::parse($cita->fecha_hora)->locale('es')->isoFormat('dddd D [de] MMMM, YYYY') }}
                </p>
              </td>
            </tr>
            <tr>
              <td style="padding:16px 20px;border-bottom:1px solid #ede9fe;">
                <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#7c3aed;">Ìµê Hora</span>
                <p style="font-size:16px;font-weight:700;color:#1e293b;margin:4px 0 0;">
                  {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('h:i A') }} ({{ $cita->duracion_minutos }} minutos)
                </p>
              </td>
            </tr>
            @if($cita->motivo)
            <tr>
              <td style="padding:16px 20px;border-bottom:1px solid #ede9fe;">
                <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#7c3aed;">Ì≤â Motivo</span>
                <p style="font-size:14px;color:#374151;margin:4px 0 0;">{{ $cita->motivo }}</p>
              </td>
            </tr>
            @endif
            <tr>
              <td style="padding:16px 20px;">
                <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#7c3aed;">Ì±®‚Äç‚öïÔ∏è M√©dico</span>
                <p style="font-size:14px;font-weight:600;color:#374151;margin:4px 0 0;">
                  Dr(a). {{ $cita->medico->nombre }} {{ $cita->medico->apellidos }}
                </p>
              </td>
            </tr>
          </table>

          @if($cita->notas)
          <div style="background:#fffbeb;border-left:4px solid #f59e0b;padding:14px 18px;border-radius:0 8px 8px 0;margin-bottom:24px;">
            <p style="font-size:12px;font-weight:700;color:#d97706;margin:0 0 4px;text-transform:uppercase;">Indicaciones</p>
            <p style="font-size:13px;color:#374151;margin:0;line-height:1.5;">{{ $cita->notas }}</p>
          </div>
          @endif

          <p style="font-size:13px;color:#6b7280;line-height:1.6;margin:0 0 8px;">
            Si necesita cancelar o reprogramar su cita, por favor cont√°ctenos con anticipaci√≥n.
          </p>
        </td>
      </tr>

      {{-- Footer --}}
      <tr>
        <td style="background:#f8fafc;padding:20px;text-align:center;border-top:1px solid #e2e8f0;">
          <p style="font-size:12px;color:#94a3b8;margin:0;">Este es un mensaje autom√°tico. Por favor no responda a este correo.</p>
        </td>
      </tr>

    </table>
  </td></tr>
</table>
</body>
</html>
