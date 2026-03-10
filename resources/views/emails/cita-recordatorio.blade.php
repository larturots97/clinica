<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Recordatorio de cita</title></head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:30px 0;">
  <tr><td align="center">
    <table width="560" cellpadding="0" cellspacing="0" style="background:white;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.08);">

      <tr>
        <td style="background:linear-gradient(135deg,#f59e0b,#d97706);padding:32px;text-align:center;">
          <div style="font-size:28px;margin-bottom:8px;">‚è∞</div>
          <h1 style="color:white;font-size:22px;margin:0;font-weight:700;">Recordatorio de Cita</h1>
          <p style="color:rgba(255,255,255,.85);font-size:14px;margin:6px 0 0;">Su cita es ma√±ana</p>
        </td>
      </tr>

      <tr>
        <td style="padding:32px;">
          <p style="font-size:15px;color:#374151;margin:0 0 16px;">Hola <strong>{{ $cita->paciente->nombre }}</strong>,</p>
          <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0 0 24px;">
            Le recordamos que tiene una cita programada para <strong>ma√±ana</strong>:
          </p>

          <table width="100%" cellpadding="0" cellspacing="0" style="background:#fffbeb;border-radius:12px;overflow:hidden;margin-bottom:24px;border:1px solid #fde68a;">
            <tr>
              <td style="padding:16px 20px;border-bottom:1px solid #fde68a;">
                <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#d97706;">Ì≥Ü Fecha</span>
                <p style="font-size:16px;font-weight:700;color:#1e293b;margin:4px 0 0;">
                  {{ \Carbon\Carbon::parse($cita->fecha_hora)->locale('es')->isoFormat('dddd D [de] MMMM, YYYY') }}
                </p>
              </td>
            </tr>
            <tr>
              <td style="padding:16px 20px;border-bottom:1px solid #fde68a;">
                <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#d97706;">Ìµê Hora</span>
                <p style="font-size:16px;font-weight:700;color:#1e293b;margin:4px 0 0;">
                  {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('h:i A') }}
                </p>
              </td>
            </tr>
            <tr>
              <td style="padding:16px 20px;">
                <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#d97706;">Ì±®‚Äç‚öïÔ∏è M√©dico</span>
                <p style="font-size:14px;font-weight:600;color:#374151;margin:4px 0 0;">
                  Dr(a). {{ $cita->medico->nombre }} {{ $cita->medico->apellidos }}
                </p>
              </td>
            </tr>
          </table>

          <p style="font-size:13px;color:#6b7280;margin:0;">
            Si necesita cancelar cont√°ctenos a la brevedad posible. ¬°Le esperamos!
          </p>
        </td>
      </tr>

      <tr>
        <td style="background:#f8fafc;padding:20px;text-align:center;border-top:1px solid #e2e8f0;">
          <p style="font-size:12px;color:#94a3b8;margin:0;">Mensaje autom√°tico ‚Äî No responder.</p>
        </td>
      </tr>

    </table>
  </td></tr>
</table>
</body>
</html>
