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
        <div style="display:flex;align-items:center;gap:11px;padding:12px 18px;border-bottom:1px solid #f1f5f9;transition:background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
            <div style="text-align:center;min-width:48px;">
                <div style="font-size:13px;font-weight:700;">{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('H:i') }}</div>
                <div style="font-size:10px;color:#64748b;">{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('A') }}</div>
            </div>
            <div style="width:3px;height:32px;border-radius:2px;flex-shrink:0;background:
                {{ $cita->estado === 'en_curso' ? '#10b981' : ($cita->estado === 'confirmada' ? '#0ea5a0' : '#f59e0b') }};">
            </div>
            <div style="flex:1;">
                <div style="font-size:13px;font-weight:600;">{{ $cita->paciente->nombre_completo }}</div>
                <div style="font-size:11px;color:#64748b;margin-top:1px;">{{ $cita->motivo ?? 'Sin motivo especificado' }}</div>
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
                <a href="{{ route('historial.create') }}" style="display:flex;flex-direction:column;align-items:center;gap:5px;padding:12px 7px;border-radius:11px;border:1.5px solid #e2e8f0;background:white;cursor:pointer;transition:all 0.2s;text-decoration:none;" onmouseover="this.style.borderColor='#0ea5a0';this.style.background='#e0f7f6'" onmouseout="this.style.borderColor='#e2e8f0';this.style.background='white'">
                    <span style="width:34px;height:34px;border-radius:9px;background:#ffe4e6;color:#e11d48;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-file-medical" style="font-size:14px;"></i>
                    </span>
                    <span style="font-size:11px;font-weight:600;color:#1e293b;">Nueva consulta</span>
                </a>
                <a href="{{ route('recetas.create') }}" style="display:flex;flex-direction:column;align-items:center;gap:5px;padding:12px 7px;border-radius:11px;border:1.5px solid #e2e8f0;background:white;cursor:pointer;transition:all 0.2s;text-decoration:none;" onmouseover="this.style.borderColor='#0ea5a0';this.style.background='#e0f7f6'" onmouseout="this.style.borderColor='#e2e8f0';this.style.background='white'">
                    <span style="width:34px;height:34px;border-radius:9px;background:#ede9fe;color:#7c3aed;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-prescription" style="font-size:14px;"></i>
                    </span>
                    <span style="font-size:11px;font-weight:600;color:#1e293b;">Nueva receta</span>
                </a>
                @if($esMedicoEstetico)
                <a href="{{ route('estetica.create') }}" style="display:flex;flex-direction:column;align-items:center;gap:5px;padding:12px 7px;border-radius:11px;border:1.5px solid #e2e8f0;background:white;cursor:pointer;transition:all 0.2s;text-decoration:none;" onmouseover="this.style.borderColor='#a855f7';this.style.background='#f3e8ff'" onmouseout="this.style.borderColor='#e2e8f0';this.style.background='white'">
                    <span style="width:34px;height:34px;border-radius:9px;background:#f3e8ff;color:#9333ea;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-wand-magic-sparkles" style="font-size:14px;"></i>
                    </span>
                    <span style="font-size:11px;font-weight:600;color:#1e293b;">Tratamiento</span>
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
            <div style="display:flex;align-items:center;gap:9px;padding:10px 18px;border-bottom:1px solid #f1f5f9;">
                <div style="width:32px;height:32px;border-radius:50%;background:#e0f7f6;color:#065f5f;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;flex-shrink:0;">
                    {{ strtoupper(substr($cita->paciente->nombre, 0, 1)) }}{{ strtoupper(substr($cita->paciente->apellido_paterno ?? '', 0, 1)) }}
                </div>
                <div style="flex:1;">
                    <div style="font-size:13px;font-weight:600;">{{ $cita->paciente->nombre_completo }}</div>
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
