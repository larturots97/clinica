<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1e293b; padding: 30px; }

        .header { border-bottom: 3px solid #0d9488; padding-bottom: 15px; margin-bottom: 20px; }
        .header-grid { display: flex; justify-content: space-between; align-items: start; }
        .clinica-nombre { font-size: 20px; font-weight: bold; color: #0d9488; }
        .clinica-info { font-size: 10px; color: #64748b; margin-top: 4px; }
        .folio-box { text-align: right; }
        .folio { font-size: 16px; font-weight: bold; color: #7c3aed; }
        .fecha { font-size: 11px; color: #64748b; margin-top: 4px; }

        .section { margin-bottom: 16px; }
        .section-title { font-size: 10px; font-weight: bold; color: #64748b; text-transform: uppercase;
            letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px; margin-bottom: 8px; }

        .info-grid { display: flex; gap: 40px; }
        .info-block { flex: 1; }
        .info-label { font-size: 10px; color: #64748b; }
        .info-value { font-size: 12px; font-weight: bold; color: #1e293b; }

        .medicamento { border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px; margin-bottom: 8px; background: #f8fafc; }
        .med-nombre { font-size: 13px; font-weight: bold; color: #1e293b; margin-bottom: 6px; }
        .med-grid { display: flex; gap: 20px; }
        .med-item { }
        .med-label { font-size: 9px; color: #94a3b8; text-transform: uppercase; }
        .med-value { font-size: 11px; color: #334155; font-weight: 500; }

        .firma { margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 15px; }
        .firma-grid { display: flex; justify-content: space-between; }
        .firma-box { text-align: center; width: 200px; }
        .firma-linea { border-top: 1px solid #334155; margin-bottom: 5px; }
        .firma-nombre { font-size: 11px; font-weight: bold; }
        .firma-cedula { font-size: 10px; color: #64748b; }

        .footer { margin-top: 20px; text-align: center; font-size: 9px; color: #94a3b8; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="header-grid">
            <div>
                <div class="clinica-nombre">{{ $receta->clinica->nombre }}</div>
                <div class="clinica-info">
                    {{ $receta->clinica->direccion }}<br>
                    Tel: {{ $receta->clinica->telefono }} | {{ $receta->clinica->email }}
                </div>
            </div>
            <div class="folio-box">
                <div class="folio">{{ $receta->folio }}</div>
                <div class="fecha">{{ $receta->fecha->format('d/m/Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Paciente y Médico -->
    <div class="section">
        <div class="info-grid">
            <div class="info-block">
                <div class="section-title">Paciente</div>
                <div class="info-value">{{ $receta->paciente->nombre_completo }}</div>
                <div class="info-label">Expediente: {{ $receta->paciente->numero_expediente }}</div>
                @if($receta->paciente->fecha_nacimiento)
                <div class="info-label">Fecha de nacimiento: {{ $receta->paciente->fecha_nacimiento->format('d/m/Y') }}</div>
                @endif
            </div>
            <div class="info-block">
                <div class="section-title">Médico</div>
                <div class="info-value">Dr. {{ $receta->medico->nombre_completo }}</div>
                <div class="info-label">{{ $receta->medico->especialidad->nombre }}</div>
                @if($receta->medico->cedula_profesional)
                <div class="info-label">Cédula: {{ $receta->medico->cedula_profesional }}</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Diagnóstico -->
    @if($receta->diagnostico)
    <div class="section">
        <div class="section-title">Diagnóstico</div>
        <div style="font-size:12px; color:#1e293b;">{{ $receta->diagnostico }}</div>
    </div>
    @endif

    <!-- Medicamentos -->
    <div class="section">
        <div class="section-title">Medicamentos Prescritos</div>
        @foreach($receta->items as $i => $item)
        <div class="medicamento">
            <div class="med-nombre">{{ $i + 1 }}. {{ $item->medicamento }}</div>
            <div class="med-grid">
                @if($item->dosis)
                <div class="med-item">
                    <div class="med-label">Dosis</div>
                    <div class="med-value">{{ $item->dosis }}</div>
                </div>
                @endif
                @if($item->frecuencia)
                <div class="med-item">
                    <div class="med-label">Frecuencia</div>
                    <div class="med-value">{{ $item->frecuencia }}</div>
                </div>
                @endif
                @if($item->duracion)
                <div class="med-item">
                    <div class="med-label">Duración</div>
                    <div class="med-value">{{ $item->duracion }}</div>
                </div>
                @endif
                @if($item->indicaciones)
                <div class="med-item">
                    <div class="med-label">Indicaciones</div>
                    <div class="med-value">{{ $item->indicaciones }}</div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Indicaciones generales -->
    @if($receta->indicaciones)
    <div class="section">
        <div class="section-title">Indicaciones Generales</div>
        <div style="font-size:12px; color:#1e293b;">{{ $receta->indicaciones }}</div>
    </div>
    @endif

    <!-- Firma -->
    <div class="firma">
        <div class="firma-grid">
            <div></div>
            <div class="firma-box">
                <div style="height:40px;"></div>
                <div class="firma-linea"></div>
                <div class="firma-nombre">Dr. {{ $receta->medico->nombre_completo }}</div>
                <div class="firma-cedula">{{ $receta->medico->especialidad->nombre }}</div>
                @if($receta->medico->cedula_profesional)
                <div class="firma-cedula">Cédula: {{ $receta->medico->cedula_profesional }}</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        Receta generada el {{ now()->format('d/m/Y H:i') }} — {{ $receta->clinica->nombre }}
    </div>

</body>
</html>
