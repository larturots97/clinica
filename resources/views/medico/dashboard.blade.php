@extends('layouts.medico')

@section('titulo', 'Dashboard')

@section('contenido')

<div style="margin-bottom:20px;">
    <h2 class="font-serif" style="font-size:22px;">
        Buenos días, Dr(a). {{ $medico->nombre }}
    </h2>
    <p style="color:#64748b;font-size:13px;margin-top:3px;">
        Tienes {{ $citasHoy->count() }} cita(s) programadas para hoy
    </p>
</div>

<!-- STATS -->
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:13px;margin-bottom:20px;">

    <div style="background:white;border-radius:13px;padding:16px;border:1px solid #e2e8f0;position:relative;overflow:hidden;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 5px 18px rgba(0,0,0,0.07)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#0ea5a0,#0891b2);border-radius:13px 13px 0 0;"></div>
        <div style="width:34px;height:34px;border-radius:9px;background:#e0f7f6;color:#0ea5a0;display:flex;align-items:center;justify-content:center;margin-bottom:9px;">
            <i class="fa-solid fa-calendar-days" style="font-size:14px;"></i>
        </div>
        <div style="font-size:24px;font-weight:700;line-height:1;">{{ $citasHoy->count() }}</div>
        <div style="font-size:12px;color:#64748b;margin-top:3px;">Citas hoy</div>
    </div>

    <div style="background:white;border-radius:13px;padding:16px;border:1px solid #e2e8f0;position:relative;overflow:hidden;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 5px 18px rgba(0,0,0,0.07)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#3b82f6,#60a5fa);border-radius:13px 13px 0 0;"></div>
        <div style="width:34px;height:34px;border-radius:9px;background:#dbeafe;color:#2563eb;display:flex;align-items:center;justify-content:center;margin-bottom:9px;">
            <i class="fa-solid fa-users" style="font-size:14px;"></i>
        </div>
        <div style="font-size:24px;font-weight:700;line-height:1;">{{ $totalPacientesMes }}</div>
        <div style="font-size:12px;color:#64748b;margin-top:3px;">Pacientes este mes</div>
    </div>

    @if($esMedicoEstetico)
    <div style="background:white;border-radius:13px;padding:16px;border:1px solid #e2e8f0;position:relative;overflow:hidden;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 5px 18px rgba(0,0,0,0.07)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#a855f7,#7c3aed);border-radius:13px 13px 0 0;"></div>
        <div style="width:34px;height:34px;border-radius:9px;background:#f3e8ff;color:#9333ea;display:flex;align-items:center;justify-content:center;margin-bottom:9px;">
            <i class="fa-solid fa-wand-magic-sparkles" style="font-size:14px;"></i>
        </div>
        <div style="font-size:24px;font-weight:700;line-height:1;">{{ $totalTratamientosMes }}</div>
        <div style="font-size:12px;color:#64748b;margin-top:3px;">Tratamientos estéticos</div>
    </div>
    @else
    <div style="background:white;border-radius:13px;padding:16px;border:1px solid #e2e8f0;position:relative;overflow:hidden;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 5px 18px rgba(0,0,0,0.07)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#a855f7,#7c3aed);border-radius:13px 13px 0 0;"></div>
        <div style="width:34px;height:34px;border-radius:9px;background:#ede9fe;color:#7c3aed;display:flex;align-items:center;justify-content:center;margin-bottom:9px;">
            <i class="fa-solid fa-prescription" style="font-size:14px;"></i>
        </div>
        <div style="font-size:24px;font-weight:700;line-height:1;">{{ $totalRecetasMes }}</div>
        <div style="font-size:12px;color:#64748b;margin-top:3px;">Recetas emitidas</div>
    </div>
    @endif

    <div style="background:white;border-radius:13px;padding:16px;border:1px solid #e2e8f0;position:relative;overflow:hidden;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 5px 18px rgba(0,0,0,0.07)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#f97316,#fb923c);border-radius:13px 13px 0 0;"></div>
        <div style="width:34px;height:34px;border-radius:9px;background:#ffedd5;color:#ea580c;display:flex;align-items:center;justify-content:center;margin-bottom:9px;">
            <i class="fa-solid fa-calendar-check" style="font-size:14px;"></i>
        </div>
        <div style="font-size:24px;font-weight:700;line-height:1;">{{ $totalCitasMes }}</div>
        <div style="font-size:12px;color:#64748b;margin-top:3px;">Citas este mes</div>
    </div>

</div>

{{-- ALERTA STOCK BAJO --}}
@if($productosStockBajo->count() > 0)
<div id="alerta-stock" style="border-radius:13px;border:1px solid #fca5a5;border-left:4px solid #ef4444;background:linear-gradient(135deg,rgba(254,242,242,0.9) 0%,rgba(255,247,237,0.85) 100%);padding:14px 18px;margin-bottom:20px;display:flex;align-items:flex-start;gap:13px;box-shadow:0 2px 12px rgba(239,68,68,0.08);">
    <div style="width:36px;height:36px;background:linear-gradient(135deg,#ef4444,#f97316);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <i class="fa-solid fa-triangle-exclamation" style="color:white;font-size:15px;"></i>
    </div>
    <div style="flex:1;min-width:0;">
        <div style="font-size:13px;font-weight:700;color:#991b1b;margin-bottom:4px;">
            ⚠️ {{ $productosStockBajo->count() }} producto{{ $productosStockBajo->count() > 1 ? 's' : '' }} con stock mínimo alcanzado
        </div>
        <div style="font-size:12px;color:#b45309;margin-bottom:10px;">
            {{ $productosStockBajo->count() === 1 ? 'Este producto requiere' : 'Estos productos requieren' }} reposición pronto.
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:7px;">
            @foreach($productosStockBajo->take(4) as $prod)
            <span style="display:inline-flex;align-items:center;gap:5px;background:white;border:1.5px solid #fca5a5;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:600;color:#991b1b;">
                <span style="width:6px;height:6px;background:#ef4444;border-radius:50%;display:inline-block;"></span>
                {{ $prod->nombre }} · <span style="color:#dc2626;">{{ $prod->stock_actual }} {{ $prod->unidad }}</span>
            </span>
            @endforeach
            @if($productosStockBajo->count() > 4)
            <span style="background:white;border:1.5px solid #e2e8f0;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:600;color:#64748b;">+{{ $productosStockBajo->count() - 4 }} más</span>
            @endif
        </div>
    </div>
    <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
        <a href="{{ route('medico.inventario.index') }}" style="display:inline-flex;align-items:center;gap:5px;background:#ef4444;color:white;font-size:12px;font-weight:700;padding:7px 14px;border-radius:8px;text-decoration:none;">
            <i class="fa-solid fa-boxes-stacked" style="font-size:11px;"></i> Ver inventario
        </a>
        <button onclick="document.getElementById('alerta-stock').style.display='none'" style="background:none;border:none;cursor:pointer;color:#94a3b8;font-size:16px;padding:4px;">✕</button>
    </div>
</div>
@endif

<!-- GRID PRINCIPAL -->
<div style="display:grid;grid-template-columns:1fr 310px;gap:16px;">

    <!-- Citas de hoy -->
    <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
        <div style="padding:14px 18px 11px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:13px;font-weight:600;display:flex;align-items:center;gap:7px;">
                <span style="width:26px;height:26px;border-radius:7px;background:#fef3c7;color:#d97706;display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-calendar-days" style="font-size:11px;"></i>
                </span>
                Citas de hoy
            </span>
            <a href="{{ route('medico.agenda.index') }}" style="font-size:12px;color:#0ea5a0;font-weight:500;text-decoration:none;">Ver agenda →</a>
        </div>

        @forelse($citasHoy as $cita)
        @php
            $esVisitante = $cita->origen === 'landing' && !$cita->paciente_id;
            $nombreCita  = $cita->paciente?->nombre_completo ?? $cita->nombre_visitante ?? 'Sin nombre';
            $inicialCita = strtoupper(substr($nombreCita, 0, 1));
        @endphp
        <div style="display:flex;align-items:center;gap:11px;padding:12px 18px;border-bottom:1px solid #f1f5f9;transition:background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
            <div style="text-align:center;min-width:48px;">
                <div style="font-size:13px;font-weight:700;">{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('H:i') }}</div>
                <div style="font-size:10px;color:#64748b;">{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('A') }}</div>
            </div>
            <div style="width:3px;height:32px;border-radius:2px;flex-shrink:0;background:
                {{ $cita->estado === 'en_curso' ? '#10b981' : ($cita->estado === 'confirmada' ? '#0ea5a0' : '#f59e0b') }};">
            </div>
            <div style="flex:1;">
                <div style="font-size:13px;font-weight:600;display:flex;align-items:center;gap:5px;">
                    {{ $nombreCita }}
                    @if($esVisitante)
                    <span style="background:#ede9fe;color:#7c3aed;font-size:9px;font-weight:700;padding:2px 6px;border-radius:4px;">WEB</span>
                    @endif
                </div>
                <div style="font-size:11px;color:#64748b;margin-top:1px;">{{ $cita->motivo ?? $cita->motivo_visitante ?? 'Sin motivo especificado' }}</div>
            </div>
            @php
                $badgeColor = match($cita->estado) {
                    'en_curso'   => 'background:#d1fae5;color:#065f46;',
                    'confirmada' => 'background:#e0f7f6;color:#065f5f;',
                    'completada' => 'background:#f1f5f9;color:#475569;',
                    'cancelada'  => 'background:#fee2e2;color:#991b1b;',
                    default      => 'background:#fef3c7;color:#92400e;',
                };
            @endphp
            <span style="font-size:10px;font-weight:600;padding:3px 9px;border-radius:20px;{{ $badgeColor }}">
                {{ ucfirst(str_replace('_',' ',$cita->estado)) }}
            </span>
        </div>
        @empty
        <div style="padding:40px;text-align:center;color:#94a3b8;">
            <i class="fa-solid fa-calendar-xmark" style="font-size:32px;margin-bottom:10px;display:block;"></i>
            <p style="font-size:13px;">No hay citas para hoy</p>
        </div>
        @endforelse
    </div>

    <!-- Columna derecha -->
    <div style="display:flex;flex-direction:column;gap:14px;">

        <!-- Acciones rápidas -->
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
            <div style="padding:14px 18px 11px;border-bottom:1px solid #e2e8f0;">
                <span style="font-size:13px;font-weight:600;display:flex;align-items:center;gap:7px;">
                    <span style="width:26px;height:26px;border-radius:7px;background:#dbeafe;color:#2563eb;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-bolt" style="font-size:11px;"></i>
                    </span>
                    Acciones rápidas
                </span>
            </div>
            <div style="padding:12px;display:grid;grid-template-columns:1fr 1fr;gap:7px;">
                <a href="{{ route('medico.historial.create') }}" style="display:flex;flex-direction:column;align-items:center;gap:5px;padding:12px 7px;border-radius:11px;border:1.5px solid #e2e8f0;background:white;cursor:pointer;transition:all 0.2s;text-decoration:none;" onmouseover="this.style.borderColor='#0ea5a0';this.style.background='#e0f7f6'" onmouseout="this.style.borderColor='#e2e8f0';this.style.background='white'">
                    <span style="width:34px;height:34px;border-radius:9px;background:#ffe4e6;color:#e11d48;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-file-medical" style="font-size:14px;"></i>
                    </span>
                    <span style="font-size:11px;font-weight:600;color:#1e293b;">Nueva consulta básica</span>
                </a>
                <a href="{{ route('recetas.create') }}" style="display:flex;flex-direction:column;align-items:center;gap:5px;padding:12px 7px;border-radius:11px;border:1.5px solid #e2e8f0;background:white;cursor:pointer;transition:all 0.2s;text-decoration:none;" onmouseover="this.style.borderColor='#0ea5a0';this.style.background='#e0f7f6'" onmouseout="this.style.borderColor='#e2e8f0';this.style.background='white'">
                    <span style="width:34px;height:34px;border-radius:9px;background:#ede9fe;color:#7c3aed;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-prescription" style="font-size:14px;"></i>
                    </span>
                    <span style="font-size:11px;font-weight:600;color:#1e293b;">Nueva receta</span>
                </a>
                @if($esMedicoEstetico)
                <a href="{{ route('medico.tratamientos-esteticos.create') }}" style="display:flex;flex-direction:column;align-items:center;gap:5px;padding:12px 7px;border-radius:11px;border:1.5px solid #e2e8f0;background:white;cursor:pointer;transition:all 0.2s;text-decoration:none;" onmouseover="this.style.borderColor='#a855f7';this.style.background='#f3e8ff'" onmouseout="this.style.borderColor='#e2e8f0';this.style.background='white'">
                    <span style="width:34px;height:34px;border-radius:9px;background:#f3e8ff;color:#9333ea;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-wand-magic-sparkles" style="font-size:14px;"></i>
                    </span>
                    <span style="font-size:11px;font-weight:600;color:#1e293b;">Nueva consulta estetica</span>
                </a>
                @endif
                <a href="{{ route('facturas.create') }}" style="display:flex;flex-direction:column;align-items:center;gap:5px;padding:12px 7px;border-radius:11px;border:1.5px solid #e2e8f0;background:white;cursor:pointer;transition:all 0.2s;text-decoration:none;" onmouseover="this.style.borderColor='#0ea5a0';this.style.background='#e0f7f6'" onmouseout="this.style.borderColor='#e2e8f0';this.style.background='white'">
                    <span style="width:34px;height:34px;border-radius:9px;background:#e0f2fe;color:#0284c7;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-credit-card" style="font-size:14px;"></i>
                    </span>
                    <span style="font-size:11px;font-weight:600;color:#1e293b;">Nuevo pago</span>
                </a>
            </div>
        </div>

        <!-- Próximas citas -->
        <div style="background:white;border-radius:13px;border:1px solid #e2e8f0;overflow:hidden;">
            <div style="padding:14px 18px 11px;border-bottom:1px solid #e2e8f0;">
                <span style="font-size:13px;font-weight:600;display:flex;align-items:center;gap:7px;">
                    <span style="width:26px;height:26px;border-radius:7px;background:#d1fae5;color:#059669;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-clock" style="font-size:11px;"></i>
                    </span>
                    Próximas citas
                </span>
            </div>
            @forelse($citasProximas as $cita)
            @php
                $esVisitanteProx = $cita->origen === 'landing' && !$cita->paciente_id;
                $nombreProx = $cita->paciente?->nombre_completo ?? $cita->nombre_visitante ?? 'Sin nombre';
                $inicialProx = strtoupper(substr($nombreProx, 0, 1));
            @endphp
            <div style="display:flex;align-items:center;gap:9px;padding:10px 18px;border-bottom:1px solid #f1f5f9;">
                <div style="width:32px;height:32px;border-radius:50%;background:{{ $esVisitanteProx ? '#ede9fe' : '#e0f7f6' }};color:{{ $esVisitanteProx ? '#7c3aed' : '#065f5f' }};display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;flex-shrink:0;">
                    {{ $inicialProx }}
                </div>
                <div style="flex:1;">
                    <div style="font-size:13px;font-weight:600;display:flex;align-items:center;gap:5px;">
                        {{ $nombreProx }}
                        @if($esVisitanteProx)
                        <span style="background:#ede9fe;color:#7c3aed;font-size:9px;font-weight:700;padding:2px 6px;border-radius:4px;">WEB</span>
                        @endif
                    </div>
                    <div style="font-size:11px;color:#64748b;">{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m') }} — {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('H:i') }}</div>
                </div>
            </div>
            @empty
            <div style="padding:20px;text-align:center;color:#94a3b8;font-size:12px;">
                No hay citas próximas
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection