<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NovaSystem — @yield('titulo', 'Panel Médico')</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  body { font-family: 'DM Sans', sans-serif; }
  .font-serif { font-family: 'DM Serif Display', serif; }

  .sidebar { width: 255px; min-height: 100vh; background: #0f1f2e; position: fixed; left: 0; top: 0; bottom: 0; z-index: 100; display: flex; flex-direction: column; }
  .main-content { margin-left: 255px; }

  .nav-item { display: flex; align-items: center; gap: 9px; padding: 7px 10px; border-radius: 9px; color: rgba(255,255,255,0.48); font-size: 13px; cursor: pointer; transition: all 0.2s; margin-bottom: 1px; text-decoration: none; }
  .nav-item:hover { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.82); }
  .nav-item.active { background: rgba(14,165,160,0.18); color: #5eead4; }
  .nav-item.est-nav { color: rgba(216,180,254,0.65); }
  .nav-item.est-nav:hover { background: rgba(168,85,247,0.18); color: #e9d5ff; }
  .nav-item.est-nav.active { background: rgba(168,85,247,0.18); color: #e9d5ff; }
  .nav-label { color: rgba(255,255,255,0.2); font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; padding: 9px 10px 4px; }

  .icon-box { width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; }

  /* Colores por módulo */
  .ic-dashboard  { background: #dbeafe; color: #2563eb; }
  .ic-agenda     { background: #fef3c7; color: #d97706; }
  .ic-pacientes  { background: #d1fae5; color: #059669; }
  .ic-historial  { background: #ffe4e6; color: #e11d48; }
  .ic-recetas    { background: #ede9fe; color: #7c3aed; }
  .ic-inventario { background: #ffedd5; color: #ea580c; }
  .ic-pagos      { background: #e0f2fe; color: #0284c7; }
  .ic-estetica   { background: #f3e8ff; color: #9333ea; }
</style>
</head>
<body class="bg-slate-50">

<aside class="sidebar">
    <!-- Logo -->
    <div style="padding:20px 16px 14px; border-bottom:1px solid rgba(255,255,255,0.07);">
        <div style="display:flex; align-items:center; gap:10px;">
            <div style="width:36px;height:36px;background:linear-gradient(135deg,#0ea5a0,#0891b2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fa-solid fa-heart-pulse" style="color:white;font-size:15px;"></i>
            </div>
            <div>
                <div style="font-family:'DM Serif Display',serif;color:white;font-size:16px;line-height:1.1;">NovaSystem</div>
                <div style="color:rgba(255,255,255,0.35);font-size:10px;margin-top:1px;">Panel del Médico</div>
            </div>
        </div>
    </div>

    <!-- Doctor card -->
    <div style="margin:10px;background:#1a3548;border-radius:12px;padding:13px;border:1px solid rgba(255,255,255,0.06);">
        <div style="width:38px;height:38px;background:linear-gradient(135deg,#a855f7,#7c3aed);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:14px;margin-bottom:7px;">
            {{ strtoupper(substr(auth()->user()->medico->nombre ?? 'M', 0, 1)) }}{{ strtoupper(substr(auth()->user()->medico->apellido_paterno ?? '', 0, 1)) }}
        </div>
        <div style="color:white;font-size:13px;font-weight:600;">Dr(a). {{ auth()->user()->medico->nombre_completo ?? auth()->user()->name }}</div>
        @if(auth()->user()->medico?->especialidad)
        <div style="display:inline-flex;align-items:center;gap:3px;margin-top:5px;background:rgba(168,85,247,0.2);color:#d8b4fe;font-size:10px;padding:2px 7px;border-radius:20px;font-weight:500;">
            <i class="fa-solid fa-star" style="font-size:8px;"></i>
            {{ auth()->user()->medico->especialidad->nombre }}
        </div>
        @endif
    </div>

    <!-- Nav -->
    <nav style="padding:5px 9px;flex:1;overflow-y:auto;">
        <div class="nav-label">Principal</div>
        <a href="{{ route('medico.dashboard') }}" class="nav-item {{ request()->routeIs('medico.dashboard') ? 'active' : '' }}">
            <span class="icon-box ic-dashboard"><i class="fa-solid fa-grip"></i></span>
            Dashboard
            @php $citasHoy = auth()->user()->medico ? \App\Models\Cita::where('medico_id', auth()->user()->medico->id)->whereDate('fecha_hora', today())->whereIn('estado',['pendiente','confirmada'])->count() : 0; @endphp
            @if($citasHoy > 0)
            <span style="margin-left:auto;background:#f97316;color:white;font-size:10px;font-weight:700;padding:1px 6px;border-radius:20px;">{{ $citasHoy }}</span>
            @endif
        </a>
        <a href="{{ route('medico.agenda.index') }}" class="nav-item {{ request()->routeIs('medico.agenda*') ? 'active' : '' }}">
            <span class="icon-box ic-agenda"><i class="fa-solid fa-calendar-days"></i></span>
            Mi Agenda
        </a>

        <div class="nav-label" style="margin-top:4px;">Clínica</div>
        <a href="{{ route('medico.pacientes.index') }}" class="nav-item {{ request()->routeIs('medico.pacientes*') ? 'active' : '' }}">
            <span class="icon-box ic-pacientes"><i class="fa-solid fa-users"></i></span>
            Mis Pacientes
        </a>
        <a href="{{ route('medico.historial.index') }}" class="nav-item {{ request()->routeIs('medico.historial*') ? 'active' : '' }}">
            <span class="icon-box ic-historial"><i class="fa-solid fa-file-medical"></i></span>
            Historial Clínico
        </a>
        <a href="{{ route('medico.recetas.index') }}" class="nav-item {{ request()->routeIs('medico.recetas*') ? 'active' : '' }}">
            <span class="icon-box ic-recetas"><i class="fa-solid fa-prescription"></i></span>
            Recetas
        </a>

        <div class="nav-label" style="margin-top:4px;">Administración</div>
        <a href="{{ route('medico.inventario.index') }}" class="nav-item {{ request()->routeIs('medico.inventario*') ? 'active' : '' }}">
            <span class="icon-box ic-inventario"><i class="fa-solid fa-boxes-stacked"></i></span>
            Inventario
        </a>
        <a href="{{ route('medico.pagos.index') }}" class="nav-item {{ request()->routeIs('medico.pagos*') ? 'active' : '' }}">
            <span class="icon-box ic-pagos"><i class="fa-solid fa-credit-card"></i></span>
            Pagos
        </a>

        <div class="nav-label" style="margin-top:4px;">Especialidad</div>
        <a href="{{ route('medico.tratamientos-esteticos.index') }}" class="nav-item est-nav {{ request()->routeIs('medico.tratamientos-esteticos*') ? 'active' : '' }}">
            <span class="icon-box ic-estetica"><i class="fa-solid fa-wand-magic-sparkles"></i></span>
            Historia Estética
        </a>
        <a href="{{ route('medico.tipo-tratamientos.index') }}" class="nav-item est-nav {{ request()->routeIs('medico.tipo-tratamientos*') ? 'active' : '' }}">
            <span class="icon-box" style="background:#fce7f3;color:#be185d;width:28px;height:28px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;"><i class="fa-solid fa-list-check"></i></span>
            Mis Tratamientos
        </a>
    </nav>

    <!-- Footer -->
    <div style="padding:10px;border-top:1px solid rgba(255,255,255,0.07);">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="display:flex;align-items:center;gap:7px;color:rgba(255,255,255,0.28);font-size:12px;cursor:pointer;padding:7px 10px;border-radius:7px;transition:all 0.2s;background:none;border:none;width:100%;">
                <i class="fa-solid fa-right-from-bracket"></i>
                Cerrar sesión
            </button>
        </form>
    </div>
</aside>

<!-- MAIN -->
<div class="main-content">
    <!-- Topbar -->
    <header style="background:white;border-bottom:1px solid #e2e8f0;padding:0 26px;height:56px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;">
        <div>
            <div style="font-size:14px;font-weight:600;color:#1e293b;">@yield('titulo', 'Dashboard')</div>
            <div style="font-size:11px;color:#64748b;margin-top:1px;">{{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}</div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="display:flex;align-items:center;gap:7px;background:#f0f4f8;border:1px solid #e2e8f0;border-radius:9px;padding:6px 12px;width:240px;">
                <i class="fa-solid fa-magnifying-glass" style="color:#94a3b8;font-size:12px;"></i>
                <input placeholder="Buscar..." style="border:none;background:transparent;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;flex:1;color:#1e293b;" class="search-global">
            </div>
        </div>
    </header>

    <!-- Alerts -->
    <div style="padding:0 26px;margin-top:16px;">
        @if(session('success'))
        <div style="background:#d1fae5;border:1px solid #a7f3d0;color:#065f46;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px;">
            <i class="fa-solid fa-circle-check" style="margin-right:6px;"></i>{{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px;">
            <i class="fa-solid fa-circle-xmark" style="margin-right:6px;"></i>{{ session('error') }}
        </div>
        @endif
    </div>

    <!-- Content -->
    <main style="padding:0 26px 26px;">
        @yield('contenido')
    </main>
</div>

</body>
</html>