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

  /* ════════════════════════════════
     RAIL SIDEBAR
  ════════════════════════════════ */

  :root {
    --rail-collapsed: 58px;
    --rail-expanded: 248px;
    --rail-bg: #0f1f2e;
    --rail-accent: #0ea5a0;
    --transition: 0.28s cubic-bezier(0.4, 0, 0.2, 1);
  }

  /* Rail container */
  .rail {
    position: fixed;
    left: 0; top: 0; bottom: 0;
    width: var(--rail-collapsed);
    background: var(--rail-bg);
    z-index: 200;
    display: flex;
    flex-direction: column;
    transition: width var(--transition), box-shadow var(--transition);
    overflow: hidden;
    border-radius: 0 16px 16px 0;
  }

  .rail:hover,
  .rail.rail-pinned {
    width: var(--rail-expanded);
    box-shadow: 6px 0 40px rgba(0,0,0,0.35);
  }

  /* Acento lateral izquierdo */
  .rail::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, #0ea5a0 0%, #0891b2 50%, #818cf8 100%);
    opacity: 0.7;
    border-radius: 0 2px 2px 0;
    transition: opacity var(--transition);
    z-index: 1;
  }
  .rail:hover::before,
  .rail.rail-pinned::before {
    opacity: 0;
  }

  /* Header del rail */
  .rail-header {
    padding: 16px 10px 12px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
    min-height: 60px;
    overflow: hidden;
  }

  .rail-logo {
    width: 36px; height: 36px;
    background: linear-gradient(135deg,#0ea5a0,#0891b2);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .rail-logo i { color: white; font-size: 15px; }

  .rail-brand {
    opacity: 0;
    white-space: nowrap;
    transition: opacity var(--transition);
    pointer-events: none;
  }
  .rail:hover .rail-brand,
  .rail.rail-pinned .rail-brand {
    opacity: 1;
    pointer-events: auto;
  }
  .rail-brand-name {
    font-family: 'DM Serif Display', serif;
    color: white;
    font-size: 16px;
    line-height: 1.1;
  }
  .rail-brand-sub {
    color: rgba(255,255,255,0.35);
    font-size: 10px;
    margin-top: 1px;
  }

  /* Botón pin */
  .rail-pin-btn {
    width: 24px; height: 24px;
    border-radius: 6px;
    background: rgba(255,255,255,0.06);
    border: none;
    color: rgba(255,255,255,0.3);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px;
    transition: background 0.15s, color 0.15s, opacity var(--transition);
    margin-left: auto;
    flex-shrink: 0;
    opacity: 0;
  }
  .rail:hover .rail-pin-btn,
  .rail.rail-pinned .rail-pin-btn {
    opacity: 1;
  }
  .rail-pin-btn:hover { background: rgba(255,255,255,0.12); color: white; }
  .rail-pin-btn.pinned { color: #0ea5a0; background: rgba(14,165,160,0.18); }

  /* Perfil mini */
  .rail-profile {
    margin: 8px 8px 4px;
    background: #1a3548;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.06);
    overflow: hidden;
    flex-shrink: 0;
    transition: all var(--transition);
  }
  .rail-profile-inner {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 10px 9px;
  }
  .rail-avatar {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg,#a855f7,#7c3aed);
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: 12px;
    flex-shrink: 0;
  }
  .rail-profile-info {
    opacity: 0;
    white-space: nowrap;
    overflow: hidden;
    transition: opacity var(--transition);
    pointer-events: none;
  }
  .rail:hover .rail-profile-info,
  .rail.rail-pinned .rail-profile-info {
    opacity: 1;
    pointer-events: auto;
  }
  .rail-profile-name {
    color: white;
    font-size: 12px;
    font-weight: 600;
  }
  .rail-profile-esp {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    background: rgba(168,85,247,0.2);
    color: #d8b4fe;
    font-size: 9px;
    padding: 1px 6px;
    border-radius: 20px;
    font-weight: 500;
    margin-top: 3px;
  }

  /* Nav */
  .rail-nav {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 6px 7px;
    scrollbar-width: none;
  }
  .rail-nav::-webkit-scrollbar { display: none; }

  .rail-label {
    color: rgba(255,255,255,0.18);
    font-size: 8px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    padding: 8px 4px 3px;
    white-space: nowrap;
    overflow: hidden;
    opacity: 0;
    height: 0;
    transition: opacity var(--transition), height var(--transition);
  }
  .rail:hover .rail-label,
  .rail.rail-pinned .rail-label {
    opacity: 1;
    height: 24px;
  }

  .rail-item {
    display: flex;
    align-items: center;
    gap: 0;
    padding: 7px;
    border-radius: 9px;
    color: rgba(255,255,255,0.45);
    font-size: 12px;
    cursor: pointer;
    transition: all 0.18s;
    margin-bottom: 1px;
    text-decoration: none;
    white-space: nowrap;
    overflow: hidden;
    position: relative;
  }
  .rail-item:hover {
    background: rgba(255,255,255,0.06);
    color: rgba(255,255,255,0.82);
  }
  .rail-item.active {
    background: rgba(14,165,160,0.18);
    color: #5eead4;
  }
  .rail-item.est-item {
    color: rgba(216,180,254,0.6);
  }
  .rail-item.est-item:hover {
    background: rgba(168,85,247,0.15);
    color: #e9d5ff;
  }
  .rail-item.est-item.active {
    background: rgba(168,85,247,0.2);
    color: #e9d5ff;
  }

  .rail-icon {
    width: 30px; height: 30px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px;
    flex-shrink: 0;
    transition: transform 0.18s;
  }
  .rail-item:hover .rail-icon { transform: scale(1.08); }

  .rail-item-text {
    margin-left: 9px;
    opacity: 0;
    transition: opacity var(--transition);
    pointer-events: none;
    font-weight: 500;
  }
  .rail:hover .rail-item-text,
  .rail.rail-pinned .rail-item-text {
    opacity: 1;
    pointer-events: auto;
  }

  /* Badge de notificación */
  .rail-badge {
    position: absolute;
    top: 4px;
    left: 26px;
    background: #f97316;
    color: white;
    font-size: 8px;
    font-weight: 700;
    width: 14px; height: 14px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    transition: left var(--transition), top var(--transition);
    z-index: 2;
  }
  .rail:hover .rail-badge,
  .rail.rail-pinned .rail-badge {
    position: static;
    margin-left: auto;
    width: auto;
    height: auto;
    padding: 1px 6px;
    border-radius: 20px;
    font-size: 9px;
  }

  /* Divider */
  .rail-divider {
    height: 1px;
    background: rgba(255,255,255,0.05);
    margin: 4px 8px;
  }

  /* Footer */
  .rail-footer {
    padding: 8px 7px;
    border-top: 1px solid rgba(255,255,255,0.06);
    flex-shrink: 0;
  }

  /* Tooltip cuando está colapsado */
  .rail-item .rail-tooltip {
    position: absolute;
    left: calc(var(--rail-collapsed) + 8px);
    top: 50%;
    transform: translateY(-50%);
    background: #1e293b;
    color: white;
    font-size: 11px;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 7px;
    white-space: nowrap;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.15s;
    z-index: 300;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    border: 1px solid rgba(255,255,255,0.08);
  }
  .rail-item .rail-tooltip::before {
    content: '';
    position: absolute;
    right: 100%;
    top: 50%;
    transform: translateY(-50%);
    border: 5px solid transparent;
    border-right-color: #1e293b;
  }
  /* Solo mostrar tooltip cuando el rail está colapsado */
  .rail:not(:hover):not(.rail-pinned) .rail-item:hover .rail-tooltip {
    opacity: 1;
  }

  /* Contenido principal */
  .main-wrap {
    margin-left: var(--rail-collapsed);
    transition: margin-left var(--transition);
    min-height: 100vh;
  }
  .main-wrap.wrap-pinned {
    margin-left: var(--rail-expanded);
  }

  /* Topbar */
  .topbar {
    background: white;
    border-bottom: 1px solid #e2e8f0;
    padding: 0 26px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 50;
  }

  /* ── Icons colores ── */
  .ic-dashboard  { background: #dbeafe; color: #2563eb; }
  .ic-agenda     { background: #fef3c7; color: #d97706; }
  .ic-pacientes  { background: #d1fae5; color: #059669; }
  .ic-historial  { background: #ffe4e6; color: #e11d48; }
  .ic-recetas    { background: #ede9fe; color: #7c3aed; }
  .ic-inventario { background: #ffedd5; color: #ea580c; }
  .ic-pagos      { background: #e0f2fe; color: #0284c7; }
  .ic-estetica   { background: #f3e8ff; color: #9333ea; }
  .ic-tipos      { background: #fce7f3; color: #be185d; }
  .ic-config     { background: #f1f5f9; color: #64748b; }

  /* ── Loading overlay ── */
  #loading-overlay {
    position: fixed; inset: 0;
    background: rgba(15, 31, 46, 0.92);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center; gap: 20px;
    z-index: 9999; opacity: 0; pointer-events: none;
    transition: opacity 0.25s ease;
  }
  #loading-overlay.show { opacity: 1; pointer-events: all; }
  .loading-pulse { position: relative; width: 64px; height: 64px; }
  .loading-ring { position: absolute; inset: 0; border-radius: 50%; border: 2px solid rgba(14,165,160,0.35); animation: ripple 1.6s ease-out infinite; }
  .loading-ring:nth-child(2) { animation-delay: 0.53s; }
  .loading-ring:nth-child(3) { animation-delay: 1.06s; }
  .loading-center { position: absolute; inset: 12px; background: linear-gradient(135deg,#0ea5a0,#0891b2); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 20px rgba(14,165,160,0.5); }
  .loading-center i { color: white; font-size: 18px; }
  @keyframes ripple { 0% { transform: scale(1); opacity: 1; } 100% { transform: scale(2.4); opacity: 0; } }
  .loading-ecg { width: 140px; height: 36px; }
  .ecg-path { stroke: #0ea5a0; stroke-width: 2; fill: none; stroke-linecap: round; stroke-linejoin: round; stroke-dasharray: 260; stroke-dashoffset: 260; }
  #loading-overlay.show .ecg-path { animation: draw-ecg 1.8s linear infinite; }
  @keyframes draw-ecg { 0% { stroke-dashoffset: 260; opacity: 1; } 80% { stroke-dashoffset: -260; opacity: 1; } 81% { opacity: 0; } 100% { stroke-dashoffset: -260; opacity: 0; } }
  .loading-text { color: white; font-size: 13px; font-weight: 600; letter-spacing: 0.3px; }
  .loading-brand { color: rgba(255,255,255,0.3); font-size: 11px; font-family: 'DM Serif Display', serif; letter-spacing: 1px; }

  [x-cloak] { display: none !important; }
</style>
</head>
<body class="bg-slate-50">

{{-- ══ Loading ══ --}}
<div id="loading-overlay">
  <div class="loading-pulse">
    <div class="loading-ring"></div>
    <div class="loading-ring"></div>
    <div class="loading-ring"></div>
    <div class="loading-center"><i class="fa-solid fa-heart-pulse"></i></div>
  </div>
  <svg class="loading-ecg" viewBox="0 0 140 36">
    <path class="ecg-path" d="M0,18 L24,18 L29,6 L34,30 L39,12 L46,18 L70,18 L75,6 L80,30 L85,12 L92,18 L140,18"/>
  </svg>
  <div class="loading-text">Cargando...</div>
  <div class="loading-brand">NOVASYSTEM</div>
</div>

{{-- ══ RAIL ══ --}}
<aside class="rail" id="rail">

  {{-- Header --}}
  <div class="rail-header">
    <div class="rail-logo">
      <i class="fa-solid fa-heart-pulse"></i>
    </div>
    <div class="rail-brand">
      <div class="rail-brand-name">NovaSystems</div>
      <div class="rail-brand-sub">Panel del Médico</div>
    </div>
    <button class="rail-pin-btn" id="rail-pin-btn" onclick="railTogglePin()" title="Fijar sidebar">
      <i class="fa-solid fa-thumbtack"></i>
    </button>
  </div>

  {{-- Perfil --}}
  <div class="rail-profile">
    <div class="rail-profile-inner">
      <div class="rail-avatar">
        {{ strtoupper(substr(auth()->user()->medico->nombre ?? 'M', 0, 1)) }}{{ strtoupper(substr(auth()->user()->medico->apellido_paterno ?? '', 0, 1)) }}
      </div>
      <div class="rail-profile-info">
        <div class="rail-profile-name">Dr(a). {{ auth()->user()->medico->nombre_completo ?? auth()->user()->name }}</div>
        @if(auth()->user()->medico?->especialidad)
        <div class="rail-profile-esp">
          <i class="fa-solid fa-star" style="font-size:7px;"></i>
          {{ auth()->user()->medico->especialidad->nombre }}
        </div>
        @endif
      </div>
    </div>
  </div>

  {{-- Navegación --}}
  <nav class="rail-nav">

    <div class="rail-label">Principal</div>

    @php $citasHoy = auth()->user()->medico ? \App\Models\Cita::where('medico_id', auth()->user()->medico->id)->whereDate('fecha_hora', today())->whereIn('estado',['pendiente','confirmada'])->count() : 0; @endphp

    <a href="{{ route('medico.dashboard') }}" class="rail-item {{ request()->routeIs('medico.dashboard') ? 'active' : '' }}">
      <span class="rail-icon ic-dashboard"><i class="fa-solid fa-grip"></i></span>
      <span class="rail-item-text">Dashboard</span>
      @if($citasHoy > 0)
        <span class="rail-badge">{{ $citasHoy }}</span>
      @endif
      <span class="rail-tooltip">Dashboard</span>
    </a>

    <a href="{{ route('medico.citas.index') }}" class="rail-item {{ request()->routeIs('medico.citas*') ? 'active' : '' }}">
      <span class="rail-icon ic-agenda"><i class="fa-solid fa-calendar-days"></i></span>
      <span class="rail-item-text">Mi Agenda</span>
      <span class="rail-tooltip">Mi Agenda</span>
    </a>

    <div class="rail-divider"></div>
    <div class="rail-label">Clínica</div>

    <a href="{{ route('medico.pacientes.index') }}" class="rail-item {{ request()->routeIs('medico.pacientes*') ? 'active' : '' }}">
      <span class="rail-icon ic-pacientes"><i class="fa-solid fa-users"></i></span>
      <span class="rail-item-text">Mis Pacientes</span>
      <span class="rail-tooltip">Mis Pacientes</span>
    </a>

    <a href="{{ route('medico.historial.index') }}" class="rail-item {{ request()->routeIs('medico.historial*') ? 'active' : '' }}">
      <span class="rail-icon ic-historial"><i class="fa-solid fa-file-medical"></i></span>
      <span class="rail-item-text">Consulta Básica</span>
      <span class="rail-tooltip">Consulta Básica</span>
    </a>

    <a href="{{ route('medico.recetas.index') }}" class="rail-item {{ request()->routeIs('medico.recetas*') ? 'active' : '' }}">
      <span class="rail-icon ic-recetas"><i class="fa-solid fa-prescription"></i></span>
      <span class="rail-item-text">Recetas</span>
      <span class="rail-tooltip">Recetas</span>
    </a>

    <div class="rail-divider"></div>
    <div class="rail-label">Administración</div>

    <a href="{{ route('medico.inventario.index') }}" class="rail-item {{ request()->routeIs('medico.inventario*') ? 'active' : '' }}">
      <span class="rail-icon ic-inventario"><i class="fa-solid fa-boxes-stacked"></i></span>
      <span class="rail-item-text">Inventario</span>
      <span class="rail-tooltip">Inventario</span>
    </a>

    <a href="{{ route('medico.pagos.index') }}" class="rail-item {{ request()->routeIs('medico.pagos*') ? 'active' : '' }}">
      <span class="rail-icon ic-pagos"><i class="fa-solid fa-credit-card"></i></span>
      <span class="rail-item-text">Pagos</span>
      <span class="rail-tooltip">Pagos</span>
    </a>

    <div class="rail-divider"></div>
    <div class="rail-label">Especialidad</div>

    <a href="{{ route('medico.tratamientos-esteticos.create') }}" class="rail-item est-item {{ request()->routeIs('medico.tratamientos-esteticos.create') ? 'active' : '' }}">
      <span class="rail-icon ic-estetica"><i class="fa-solid fa-wand-magic-sparkles"></i></span>
      <span class="rail-item-text">Consulta Estética</span>
      <span class="rail-tooltip">Consulta Estética</span>
    </a>

    <a href="{{ route('medico.tratamientos-esteticos.index') }}" class="rail-item est-item {{ request()->routeIs('medico.tratamientos-esteticos.index') || request()->routeIs('medico.tratamientos-esteticos.show') ? 'active' : '' }}">
      <span class="rail-icon ic-estetica"><i class="fa-solid fa-file-waveform"></i></span>
      <span class="rail-item-text">Historia Clínica</span>
      <span class="rail-tooltip">Historia Clínica</span>
    </a>

    <a href="{{ route('medico.tipo-tratamientos.index') }}" class="rail-item est-item {{ request()->routeIs('medico.tipo-tratamientos*') ? 'active' : '' }}">
      <span class="rail-icon ic-tipos"><i class="fa-solid fa-list-check"></i></span>
      <span class="rail-item-text">Tipos de Tratamiento</span>
      <span class="rail-tooltip">Tipos de Tratamiento</span>
    </a>

    <a href="{{ route('medico.configuraciones.index') }}" class="rail-item {{ request()->routeIs('medico.configuraciones.*') ? 'active' : '' }}">
      <span class="rail-icon ic-config"><i class="fa-solid fa-gear"></i></span>
      <span class="rail-item-text">Configuraciones</span>
      <span class="rail-tooltip">Configuraciones</span>
    </a>

  </nav>

  {{-- Cerrar sesión --}}
  <div class="rail-footer">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="rail-item" style="width:100%;background:none;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;">
        <span class="rail-icon" style="background:rgba(239,68,68,0.1);color:#ef4444;">
          <i class="fa-solid fa-right-from-bracket"></i>
        </span>
        <span class="rail-item-text" style="color:rgba(255,255,255,0.35);font-size:12px;">Cerrar sesión</span>
        <span class="rail-tooltip">Cerrar sesión</span>
      </button>
    </form>
  </div>

</aside>

{{-- ══ CONTENIDO PRINCIPAL ══ --}}
<div class="main-wrap" id="main-wrap">

  {{-- Topbar --}}
  <header class="topbar">
    <div style="display:flex;align-items:center;gap:12px;">
      <div>
        <div style="font-size:14px;font-weight:600;color:#1e293b;">@yield('titulo', 'Dashboard')</div>
        <div style="font-size:11px;color:#64748b;margin-top:1px;">{{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}</div>
      </div>
    </div>
    <div style="display:flex;align-items:center;gap:10px;">
      <div style="display:flex;align-items:center;gap:7px;background:#f0f4f8;border:1px solid #e2e8f0;border-radius:9px;padding:6px 12px;width:240px;">
        <i class="fa-solid fa-magnifying-glass" style="color:#94a3b8;font-size:12px;"></i>
        <input placeholder="Buscar..." style="border:none;background:transparent;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;flex:1;color:#1e293b;">
      </div>
    </div>
  </header>

  {{-- Alertas de sesión --}}
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

  <main style="padding:0 26px 26px;">
    @yield('contenido')
  </main>

</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
/* ══ RAIL PIN ══ */
const RAIL_PIN_KEY = 'nova_rail_pinned';
const railEl     = document.getElementById('rail');
const mainWrapEl = document.getElementById('main-wrap');
const pinBtn     = document.getElementById('rail-pin-btn');

let railPinned = localStorage.getItem(RAIL_PIN_KEY) === 'true';

function railApply() {
  if (railPinned) {
    railEl.classList.add('rail-pinned');
    mainWrapEl.classList.add('wrap-pinned');
    pinBtn.classList.add('pinned');
    pinBtn.title = 'Desfijar sidebar';
  } else {
    railEl.classList.remove('rail-pinned');
    mainWrapEl.classList.remove('wrap-pinned');
    pinBtn.classList.remove('pinned');
    pinBtn.title = 'Fijar sidebar';
  }
}

function railTogglePin() {
  railPinned = !railPinned;
  localStorage.setItem(RAIL_PIN_KEY, railPinned);
  railApply();
}

railApply();

/* ══ LOADING ══ */
const loadingOv = document.getElementById('loading-overlay');
const startLoading = () => loadingOv.classList.add('show');
const stopLoading  = () => loadingOv.classList.remove('show');

document.addEventListener('click', function(e) {
  const link = e.target.closest('a');
  if (!link || !link.href) return;
  if (link.target === '_blank') return;
  if (link.href.startsWith('javascript:') || link.href.startsWith('#')) return;
  if (link.href.startsWith('mailto:') || link.href.startsWith('tel:')) return;
  if (!link.href.startsWith(window.location.origin)) return;
  startLoading();
});
document.addEventListener('submit', startLoading);
window.addEventListener('pageshow', stopLoading);
window.addEventListener('load', stopLoading);
</script>

</body>
</html>