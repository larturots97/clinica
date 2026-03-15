<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landing->hero_titulo ?? 'Dra. ' . $medico->nombre_completo }} · Medicina Estética Mazatlán</title>
    <meta name="description" content="{{ $landing->hero_descripcion ?? 'Especialista en medicina estética y antienvejecimiento en Mazatlán.' }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --beige:     #c9b99a;
            --beige-lt:  #f0ebe3;
            --beige-md:  #e8ddd0;
            --cream:     #faf8f4;
            --cream-md:  #f5f1eb;
            --brown:     #3d3228;
            --brown-lt:  #8a7d6b;
            --brown-xs:  #a09080;
            --white:     #ffffff;
        }

        html { scroll-behavior: smooth; }
        body { font-family: 'DM Sans', sans-serif; color: var(--brown); background: var(--cream); overflow-x: hidden; }

        /* ── UTILIDADES ── */
        .container { max-width: 1140px; margin: 0 auto; padding: 0 24px; }
        .eyebrow { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
        .ey-line { width: 22px; height: 1.5px; background: var(--beige); flex-shrink: 0; }
        .ey-txt { font-size: 10px; color: var(--beige); font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase; }
        .section-title { font-family: 'Playfair Display', serif; font-size: clamp(26px, 4vw, 36px); font-weight: 700; color: var(--brown); line-height: 1.2; }
        .section-title em { font-style: italic; color: var(--beige); }
        .btn-primary { display: inline-flex; align-items: center; gap: 8px; background: var(--white); color: var(--brown); font-size: 13px; font-weight: 700; padding: 12px 28px; border-radius: 30px; text-decoration: none; letter-spacing: 0.3px; transition: all .2s; }
        .btn-primary:hover { background: var(--cream); transform: translateY(-1px); }
        .btn-outline { display: inline-flex; align-items: center; gap: 8px; border: 1.5px solid rgba(255,255,255,0.5); color: white; font-size: 13px; padding: 12px 24px; border-radius: 30px; text-decoration: none; transition: all .2s; }
        .btn-outline:hover { background: rgba(255,255,255,0.1); }
        img { max-width: 100%; }

        /* ══════════ NAVBAR ══════════ */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: rgba(250,248,244,0.96);
            border-bottom: 1px solid var(--beige-md);
            backdrop-filter: blur(8px);
            padding: 0 24px;
            height: 64px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-logo { display: flex; align-items: center; gap: 11px; text-decoration: none; }
        .nav-logo-icon { width: 36px; height: 36px; background: var(--beige); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .nav-logo-icon i { color: white; font-size: 15px; }
        .nav-logo-name { font-family: 'Playfair Display', serif; font-size: 14px; font-weight: 700; color: var(--brown); line-height: 1.1; }
        .nav-logo-name small { display: block; font-family: 'DM Sans', sans-serif; font-size: 9px; color: var(--brown-xs); letter-spacing: 1.5px; text-transform: uppercase; font-weight: 400; margin-top: 1px; }
        .nav-links { display: flex; gap: 28px; align-items: center; }
        .nav-link { font-size: 12px; color: var(--brown-lt); text-decoration: none; letter-spacing: 0.3px; transition: color .2s; }
        .nav-link:hover { color: var(--brown); }
        .nav-cta { background: var(--beige); color: white; font-size: 12px; font-weight: 700; padding: 9px 22px; border-radius: 25px; text-decoration: none; letter-spacing: 0.3px; transition: all .2s; }
        .nav-cta:hover { background: #b8a88a; transform: translateY(-1px); }
        .nav-hamburger { display: none; background: none; border: none; cursor: pointer; padding: 4px; }
        .nav-hamburger span { display: block; width: 22px; height: 2px; background: var(--brown); margin: 5px 0; border-radius: 2px; transition: all .3s; }
        .nav-mobile { display: none; position: fixed; top: 64px; left: 0; right: 0; background: var(--cream); border-bottom: 1px solid var(--beige-md); padding: 20px 24px; z-index: 99; flex-direction: column; gap: 16px; }
        .nav-mobile.open { display: flex; }
        .nav-mobile .nav-link { font-size: 14px; padding: 6px 0; border-bottom: 1px solid var(--beige-lt); }
        .nav-mobile .nav-cta { text-align: center; padding: 12px; }

        /* ══════════ HERO ══════════ */
        .hero { background: var(--beige); padding: 110px 0 70px; position: relative; overflow: hidden; }
        .hero::before { content: ''; position: absolute; right: -80px; top: -80px; width: 360px; height: 360px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.1); }
        .hero::after { content: ''; position: absolute; right: 60px; bottom: -60px; width: 200px; height: 200px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.07); }
        .hero-inner { display: flex; align-items: center; gap: 56px; position: relative; z-index: 1; }
        .hero-content { flex: 1; }
        .hero-eyebrow { display: flex; align-items: center; gap: 10px; margin-bottom: 18px; }
        .hero-ey-line { width: 24px; height: 1.5px; background: rgba(255,255,255,0.5); }
        .hero-ey-txt { font-size: 10px; color: rgba(255,255,255,0.7); font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase; }
        .hero-title { font-family: 'Playfair Display', serif; font-size: clamp(32px, 5vw, 48px); font-weight: 700; color: white; line-height: 1.1; margin-bottom: 10px; }
        .hero-title em { font-style: italic; color: rgba(255,255,255,0.72); }
        .hero-name { font-size: 12px; color: rgba(255,255,255,0.7); letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 18px; }
        .hero-desc { font-size: 14px; color: rgba(255,255,255,0.85); line-height: 1.75; max-width: 400px; margin-bottom: 32px; }
        .hero-btns { display: flex; gap: 12px; flex-wrap: wrap; }
        .hero-photo { width: 260px; height: 400px; border-radius: 20px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2); overflow: hidden; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
        .hero-photo img { width: 100%; height: 100%; object-fit: cover; }
        .hero-photo-placeholder { text-align: center; color: rgba(255,255,255,0.4); }
        .hero-photo-placeholder i { font-size: 36px; margin-bottom: 8px; }
        .hero-photo-placeholder p { font-size: 11px; }
        .hero-stats { display: flex; gap: 36px; margin-top: 36px; padding-top: 28px; border-top: 1px solid rgba(255,255,255,0.18); flex-wrap: wrap; }
        .hero-stat-num { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; color: white; }
        .hero-stat-lbl { font-size: 10px; color: rgba(255,255,255,0.55); letter-spacing: 1px; text-transform: uppercase; margin-top: 2px; }

        /* ══════════ SOBRE MÍ ══════════ */
        .sobre { padding: 80px 0; background: var(--cream); }
        .sobre-inner { display: flex; gap: 60px; align-items: center; }
        .sobre-img { width: 260px; height: 300px; border-radius: 16px; background: var(--beige-lt); border: 1px solid var(--beige-md); overflow: hidden; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
        .sobre-img img { width: 100%; height: 100%; object-fit: cover; }
        .sobre-img-placeholder { text-align: center; color: var(--brown-xs); }
        .sobre-img-placeholder i { font-size: 32px; margin-bottom: 8px; }
        .sobre-content { flex: 1; }
        .sobre-texto { font-size: 14px; color: var(--brown-lt); line-height: 1.8; margin: 16px 0 24px; }
        .sobre-tags { display: flex; gap: 8px; flex-wrap: wrap; }
        .sobre-tag { background: var(--beige-lt); border: 1px solid var(--beige-md); color: var(--brown-lt); font-size: 11px; padding: 5px 14px; border-radius: 20px; }
        .sobre-credenciales { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 20px; }
        .cred-item { background: var(--cream-md); border-radius: 8px; padding: 12px 14px; border: 1px solid var(--beige-lt); }
        .cred-title { font-size: 11px; font-weight: 600; color: var(--brown); }
        .cred-sub { font-size: 10px; color: var(--brown-xs); margin-top: 2px; }

        /* ══════════ SERVICIOS ══════════ */
        .servicios { padding: 80px 0; background: var(--cream-md); }
        .servicios-header { text-align: center; margin-bottom: 48px; }
        .servicios-header .eyebrow { justify-content: center; }
        .servicios-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .servicio-card { background: var(--white); border-radius: 16px; padding: 28px 22px; border: 1px solid var(--beige-md); text-align: center; transition: transform .2s, box-shadow .2s; }
        .servicio-card:hover { transform: translateY(-4px); box-shadow: 0 8px 28px rgba(201,185,154,.2); }
        .servicio-icon { width: 52px; height: 52px; background: var(--beige-lt); border-radius: 14px; margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; }
        .servicio-icon i { color: var(--beige); font-size: 20px; }
        .servicio-nombre { font-family: 'Playfair Display', serif; font-size: 15px; font-weight: 600; color: var(--brown); margin-bottom: 8px; }
        .servicio-desc { font-size: 12px; color: var(--brown-xs); line-height: 1.65; }

        /* ══════════ GALERÍA ══════════ */
        .galeria { padding: 80px 0; background: var(--cream); }
        .galeria-header { margin-bottom: 36px; }
        .galeria-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .galeria-item { aspect-ratio: 1; border-radius: 12px; overflow: hidden; background: var(--beige-lt); border: 1px solid var(--beige-md); }
        .galeria-item img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s; }
        .galeria-item:hover img { transform: scale(1.04); }
        .galeria-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
        .galeria-placeholder i { font-size: 24px; color: var(--beige-md); }

        /* ══════════ CITAS ══════════ */
        .citas { padding: 80px 0; background: var(--beige); }
        .citas-inner { display: flex; gap: 60px; align-items: flex-start; }
        .citas-left { flex: 1; padding-top: 8px; }
        .citas-left .ey-line { background: rgba(255,255,255,0.4); }
        .citas-left .ey-txt { color: rgba(255,255,255,0.65); }
        .citas-title { font-family: 'Playfair Display', serif; font-size: clamp(26px, 4vw, 36px); font-weight: 700; color: white; line-height: 1.2; margin-bottom: 14px; }
        .citas-title em { font-style: italic; color: rgba(255,255,255,0.7); }
        .citas-desc { font-size: 14px; color: rgba(255,255,255,0.8); line-height: 1.75; max-width: 340px; margin-bottom: 28px; }
        .citas-info { display: flex; flex-direction: column; gap: 12px; }
        .cita-info-item { display: flex; align-items: center; gap: 10px; }
        .cita-info-dot { width: 6px; height: 6px; background: rgba(255,255,255,0.5); border-radius: 50%; flex-shrink: 0; }
        .cita-info-txt { font-size: 13px; color: rgba(255,255,255,0.75); }

        /* Formulario */
        .citas-form { background: white; border-radius: 20px; padding: 36px 32px; width: 400px; flex-shrink: 0; box-shadow: 0 8px 40px rgba(0,0,0,0.1); }
        .cf-title { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 700; color: var(--brown); margin-bottom: 4px; }
        .cf-sub { font-size: 12px; color: var(--brown-xs); margin-bottom: 20px; }
        .cf-divider { height: 1px; background: var(--beige-lt); margin-bottom: 20px; }
        .cf-group { margin-bottom: 14px; }
        .cf-label { display: block; font-size: 10px; font-weight: 700; color: var(--brown-xs); text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 5px; }
        .cf-input, .cf-select, .cf-textarea { width: 100%; padding: 11px 13px; background: var(--cream); border: 1.5px solid var(--beige-md); border-radius: 9px; font-size: 13px; color: var(--brown); font-family: 'DM Sans', sans-serif; outline: none; transition: border-color .2s, box-shadow .2s; }
        .cf-input:focus, .cf-select:focus, .cf-textarea:focus { border-color: var(--beige); box-shadow: 0 0 0 3px rgba(201,185,154,0.15); }
        .cf-textarea { resize: vertical; min-height: 72px; }
        .cf-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .cf-btn { width: 100%; padding: 13px; background: var(--beige); color: white; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; font-family: 'DM Sans', sans-serif; letter-spacing: 0.3px; cursor: pointer; margin-top: 6px; transition: background .2s, transform .1s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .cf-btn:hover { background: #b8a88a; }
        .cf-btn:active { transform: scale(0.99); }
        .cf-note { text-align: center; font-size: 11px; color: var(--brown-xs); margin-top: 10px; line-height: 1.5; }

        /* Alerta éxito */
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 14px 18px; font-size: 13px; color: #166534; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: 14px 18px; font-size: 13px; color: #b91c1c; margin-bottom: 20px; }

        /* ══════════ FOOTER ══════════ */
        .footer { background: var(--brown); padding: 40px 0 28px; }
        .footer-inner { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
        .footer-brand { font-family: 'Playfair Display', serif; font-size: 16px; font-weight: 700; color: var(--beige); }
        .footer-sub { font-size: 11px; color: rgba(201,185,154,0.5); margin-top: 3px; }
        .footer-links { display: flex; gap: 20px; }
        .footer-link { font-size: 12px; color: rgba(201,185,154,0.6); text-decoration: none; display: flex; align-items: center; gap: 6px; transition: color .2s; }
        .footer-link:hover { color: var(--beige); }
        .footer-copy { font-size: 11px; color: rgba(201,185,154,0.35); }
        .footer-divider { border: none; border-top: 1px solid rgba(201,185,154,0.1); margin: 20px 0 16px; }

        /* ══════════ RESPONSIVE ══════════ */
        @media (max-width: 1024px) {
            .servicios-grid { grid-template-columns: repeat(2, 1fr); }
            .galeria-grid { grid-template-columns: repeat(3, 1fr); }
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .nav-hamburger { display: block; }

            .hero-inner { flex-direction: column-reverse; gap: 32px; }
            .hero-photo { width: 100%; max-width: 320px; height: auto; aspect-ratio: 3/4; margin: 0 auto; }
            .hero-stats { gap: 24px; }

            .sobre-inner { flex-direction: column; gap: 32px; }
            .sobre-img { width: 100%; height: 220px; }
            .sobre-credenciales { grid-template-columns: 1fr 1fr; }

            .servicios-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }

            .galeria-grid { grid-template-columns: repeat(2, 1fr); }

            .citas-inner { flex-direction: column; gap: 36px; }
            .citas-form { width: 100%; }
            .cf-row { grid-template-columns: 1fr; }

            .footer-inner { flex-direction: column; text-align: center; }
            .footer-links { justify-content: center; }
        }

        @media (max-width: 480px) {
            .hero { padding: 90px 0 56px; }
            .hero-title { font-size: 30px; }
            .hero-btns { flex-direction: column; }
            .btn-primary, .btn-outline { justify-content: center; }

            .servicios-grid { grid-template-columns: 1fr; }
            .galeria-grid { grid-template-columns: repeat(2, 1fr); }

            .sobre-credenciales { grid-template-columns: 1fr; }

            .citas-form { padding: 24px 20px; }
        }
    </style>
</head>
<body>

{{-- ══ NAVBAR ══ --}}
<nav class="navbar">
    <a href="#" class="nav-logo">
        <div class="nav-logo-icon"><i class="fas fa-plus"></i></div>
        <div>
            <div class="nav-logo-name">{{ $medico->nombre_completo }}
                <small>{{ $medico->especialidad->nombre ?? 'Medicina Estética' }}</small>
            </div>
        </div>
    </a>
    <div class="nav-links">
        <a href="#inicio" class="nav-link">Inicio</a>
        <a href="#sobre" class="nav-link">Sobre mí</a>
        <a href="#servicios" class="nav-link">Servicios</a>
        <a href="#galeria" class="nav-link">Galería</a>
        <a href="#citas" class="nav-cta">Agendar cita</a>
    </div>
    <button class="nav-hamburger" onclick="toggleMenu()" aria-label="Menú">
        <span></span><span></span><span></span>
    </button>
</nav>

{{-- Menú móvil --}}
<div class="nav-mobile" id="navMobile">
    <a href="#inicio" class="nav-link" onclick="toggleMenu()">Inicio</a>
    <a href="#sobre" class="nav-link" onclick="toggleMenu()">Sobre mí</a>
    <a href="#servicios" class="nav-link" onclick="toggleMenu()">Servicios</a>
    <a href="#galeria" class="nav-link" onclick="toggleMenu()">Galería</a>
    <a href="#citas" class="nav-cta" onclick="toggleMenu()">Agendar cita</a>
</div>

{{-- ══ HERO ══ --}}
<section class="hero" id="inicio">
    <div class="container">
        <div class="hero-inner">
            <div class="hero-content">
                <div class="hero-eyebrow">
                    <div class="hero-ey-line"></div>
                    <span class="hero-ey-txt">{{ $medico->especialidad->nombre ?? 'Medicina Estética' }} · Mazatlán</span>
                </div>
                <h1 class="hero-title">
                    @if($landing && $landing->hero_titulo)
                        @php
                            $words   = explode(' ', trim($landing->hero_titulo));
                            $last    = array_pop($words);
                            $cursiva = array_pop($words);
                            $rest    = implode(' ', $words);
                        @endphp
                        {{ $rest }} <em style="font-style:italic;color:rgba(255,255,255,0.72);">{{ $cursiva }}</em> {{ $last }}
                    @else
                        Realza tu <em style="font-style:italic;color:rgba(255,255,255,0.72);">belleza</em> natural.
                    @endif
                </h1>
                <div class="hero-name">{{ $medico->nombre_completo }}</div>
                <p class="hero-desc">{{ $landing->hero_descripcion ?? 'Especialista en medicina estética y antienvejecimiento. Tratamientos personalizados para que luzcas y te sientas mejor.' }}</p>
                <div class="hero-btns">
                    <a href="#citas" class="btn-primary">
                        <i class="fas fa-calendar-plus"></i> Agendar valoración
                    </a>
                    <a href="#servicios" class="btn-outline">Ver servicios</a>
                </div>
                <div class="hero-stats">
                    <div>
                        <div class="hero-stat-num">{{ $landing->num_pacientes ?? '500+' }}</div>
                        <div class="hero-stat-lbl">Pacientes</div>
                    </div>
                    <div>
                        <div class="hero-stat-num">{{ $landing->anos_experiencia ?? '5+' }}</div>
                        <div class="hero-stat-lbl">Años exp.</div>
                    </div>
                    <div>
                        <div class="hero-stat-num">98%</div>
                        <div class="hero-stat-lbl">Satisfacción</div>
                    </div>
                </div>
            </div>
            <div class="hero-photo">
                @if($landing && $landing->foto_doctora)
                    <img src="{{ Storage::url($landing->foto_doctora) }}" alt="Dra. {{ $medico->nombre_completo }}">
                @else
                    <div class="hero-photo-placeholder">
                        <i class="fas fa-user-md"></i>
                        <p>Foto de la doctora</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ══ SOBRE MÍ ══ --}}
<section class="sobre" id="sobre">
    <div class="container">
        <div class="sobre-inner">
            <div class="sobre-img">
                @if($landing && $landing->foto_consultorio)
                    <img src="{{ Storage::url($landing->foto_consultorio) }}" alt="Consultorio">
                @else
                    <div class="sobre-img-placeholder">
                        <i class="fas fa-hospital"></i>
                        <p style="font-size:11px;color:var(--brown-xs);margin-top:6px;">Foto consultorio</p>
                    </div>
                @endif
            </div>
            <div class="sobre-content">
                <div class="eyebrow"><div class="ey-line"></div><span class="ey-txt">Sobre mí</span></div>
                <h2 class="section-title">Tu salud y <em>bienestar</em><br>son mi prioridad</h2>
                <p class="sobre-texto">{{ $landing->sobre_mi ?? 'Soy médico especialista en medicina estética y antienvejecimiento. Me dedico a ofrecer tratamientos seguros, efectivos y personalizados para cada paciente, siempre con un enfoque natural.' }}</p>
                <div class="sobre-credenciales">
                    <div class="cred-item">
                        <div class="cred-title">Especialidad</div>
                        <div class="cred-sub">{{ $medico->especialidad->nombre ?? 'Medicina Estética' }}</div>
                    </div>
                    <div class="cred-item">
                        <div class="cred-title">Cédula Profesional</div>
                        <div class="cred-sub">{{ $medico->cedula ?? $medico->cedula_profesional ?? '—' }}</div>
                    </div>
                    <div class="cred-item">
                        <div class="cred-title">Ubicación</div>
                        <div class="cred-sub">{{ $landing->direccion ?? 'Mazatlán, Sinaloa' }}</div>
                    </div>
                    <div class="cred-item">
                        <div class="cred-title">Experiencia</div>
                        <div class="cred-sub">{{ $landing->anos_experiencia ?? '5+ años' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ SERVICIOS ══ --}}
<section class="servicios" id="servicios">
    <div class="container">
        <div class="servicios-header">
            <div class="eyebrow"><div class="ey-line"></div><span class="ey-txt">Servicios</span><div class="ey-line"></div></div>
            <h2 class="section-title">Tratamientos <em>especializados</em></h2>
        </div>
        <div class="servicios-grid">
            @forelse($servicios as $servicio)
            <div class="servicio-card">
                <div class="servicio-icon">
                    <i class="fas {{ $servicio->icono ?? 'fa-star' }}"></i>
                </div>
                <div class="servicio-nombre">{{ $servicio->nombre }}</div>
                @if($servicio->descripcion)
                <p class="servicio-desc">{{ $servicio->descripcion }}</p>
                @endif
            </div>
            @empty
            {{-- Servicios por defecto si no hay en BD --}}
            @foreach([
                ['fa-syringe', 'Toxina Botulínica', 'Reducción de líneas de expresión con resultados naturales y duraderos.'],
                ['fa-tint', 'Ácido Hialurónico', 'Relleno de volumen en labios, pómulos y ojeras.'],
                ['fa-leaf', 'Bioestimulación', 'Regeneración celular para mejorar la calidad de la piel.'],
                ['fa-vial', 'PRP', 'Plasma Rico en Plaquetas para rejuvenecer de forma natural.'],
                ['fa-magic', 'Hilos Tensores', 'Lifting no quirúrgico para redefinir el óvalo facial.'],
                ['fa-heart', 'Valoración Gratuita', 'Primera consulta sin costo para diseñar tu plan personalizado.'],
            ] as [$icon, $nombre, $desc])
            <div class="servicio-card">
                <div class="servicio-icon"><i class="fas {{ $icon }}"></i></div>
                <div class="servicio-nombre">{{ $nombre }}</div>
                <p class="servicio-desc">{{ $desc }}</p>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- ══ GALERÍA ══ --}}
@if($galeria->count() > 0)
<section class="galeria" id="galeria">
    <div class="container">
        <div class="galeria-header">
            <div class="eyebrow"><div class="ey-line"></div><span class="ey-txt">Galería</span></div>
            <h2 class="section-title">Antes y <em>después</em></h2>
        </div>
        <div class="galeria-grid">
            @foreach($galeria as $foto)
            <div class="galeria-item">
                <img src="{{ Storage::url($foto->imagen) }}" alt="{{ $foto->titulo ?? 'Resultado' }}" loading="lazy">
            </div>
            @endforeach
        </div>
    </div>
</section>
@else
<section class="galeria" id="galeria">
    <div class="container">
        <div class="galeria-header">
            <div class="eyebrow"><div class="ey-line"></div><span class="ey-txt">Galería</span></div>
            <h2 class="section-title">Antes y <em>después</em></h2>
        </div>
        <div class="galeria-grid">
            @for($i = 1; $i <= 4; $i++)
            <div class="galeria-item">
                <div class="galeria-placeholder"><i class="fas fa-image"></i></div>
            </div>
            @endfor
        </div>
        <p style="text-align:center;font-size:12px;color:var(--brown-xs);margin-top:16px;">Las fotos se mostrarán cuando las subas desde el panel.</p>
    </div>
</section>
@endif

{{-- ══ CITAS ══ --}}
<section class="citas" id="citas">
    <div class="container">
        <div class="citas-inner">
            <div class="citas-left">
                <div class="eyebrow"><div class="ey-line" style="background:rgba(255,255,255,0.4);"></div><span class="ey-txt" style="color:rgba(255,255,255,0.6);">Agendar cita</span></div>
                <h2 class="citas-title">Agenda tu<br>valoración <em>gratuita</em></h2>
                <p class="citas-desc">Sin compromiso. Conoce tus opciones y recibe un plan personalizado de tratamiento.</p>
                <div class="citas-info">
                    <div class="cita-info-item"><div class="cita-info-dot"></div><span class="cita-info-txt">Consulta de valoración sin costo</span></div>
                    <div class="cita-info-item"><div class="cita-info-dot"></div><span class="cita-info-txt">Confirmación por WhatsApp</span></div>
                    <div class="cita-info-item"><div class="cita-info-dot"></div>
                        <span class="cita-info-txt">{{ $landing->horario ?? 'Lunes a viernes 9:00 – 18:00' }}</span>
                    </div>
                    <div class="cita-info-item"><div class="cita-info-dot"></div>
                        <span class="cita-info-txt">{{ $landing->direccion ?? 'Mazatlán, Sinaloa' }}</span>
                    </div>
                </div>
            </div>

            {{-- FORMULARIO --}}
            <div class="citas-form">
                @if(session('cita_success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('cita_success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
                @endif

                <div class="cf-title">Solicitar cita</div>
                <div class="cf-sub">Completa el formulario · Sin registro necesario</div>
                <div class="cf-divider"></div>

                <form method="POST" action="{{ route('landing.agendar') }}" id="form-cita">
                    @csrf
                    <div class="cf-group">
                        <label class="cf-label" for="nombre">Nombre completo *</label>
                        <input class="cf-input" type="text" id="nombre" name="nombre"
                               value="{{ old('nombre') }}" placeholder="Tu nombre completo" required>
                    </div>
                    <div class="cf-row">
                        <div class="cf-group">
                            <label class="cf-label" for="telefono">Teléfono *</label>
                            <input class="cf-input" type="tel" id="telefono" name="telefono"
                                   value="{{ old('telefono') }}" placeholder="669 000 0000" required>
                        </div>
                        <div class="cf-group">
                            <label class="cf-label" for="email">Correo</label>
                            <input class="cf-input" type="email" id="email" name="email"
                                   value="{{ old('email') }}" placeholder="tu@email.com">
                        </div>
                    </div>
                    <div class="cf-group">
                        <label class="cf-label" for="fecha">Fecha deseada *</label>
                        <input class="cf-input" type="date" id="fecha" name="fecha"
                               value="{{ old('fecha') }}" min="{{ date('Y-m-d') }}"
                               onchange="cargarHoras(this.value)" required>
                    </div>

                    {{-- Horas disponibles --}}
                    <div class="cf-group" id="contenedor-horas" style="display:none;">
                        <label class="cf-label">Hora *</label>
                        <div id="loading-horas" style="display:none;font-size:12px;color:var(--brown-xs);padding:8px 0;">
                            <i class="fas fa-spinner fa-spin"></i> Cargando horas...
                        </div>
                        <div style="display:flex;gap:8px;align-items:center;">
                            <select class="cf-select" id="hora-select" name="hora" onchange="verificarHora(this.value)" style="flex:1;" required>
                                <option value="">Selecciona una hora</option>
                            </select>
                            <div id="badge-disponibilidad" style="display:none;padding:6px 12px;border-radius:8px;font-size:12px;font-weight:700;white-space:nowrap;"></div>
                        </div>
                        <div id="sin-horas" style="display:none;font-size:12px;color:#e11d48;padding:8px 0;margin-top:6px;">
                            <i class="fas fa-exclamation-circle"></i> El médico no atiende ese día. Elige otra fecha.
                        </div>
                    </div>

                    <div class="cf-group">
                        <label class="cf-label" for="motivo">¿Qué te interesa tratar?</label>
                        <textarea class="cf-textarea" id="motivo" name="motivo"
                                  placeholder="Ej. me gustaría información sobre botox...">{{ old('motivo') }}</textarea>
                    </div>
                    <button type="submit" class="cf-btn" id="btn-agendar">
                        Solicitar valoración <i class="fas fa-arrow-right"></i>
                    </button>
                    <p class="cf-note">Sin costo · Sin compromiso · Respondemos en menos de 24h</p>
                </form>



                <script>
                let horasCargadas = [];

                function cargarHoras(fecha) {
                    if (!fecha) return;

                    const contenedor = document.getElementById('contenedor-horas');
                    const loading    = document.getElementById('loading-horas');
                    const select     = document.getElementById('hora-select');
                    const sinHoras   = document.getElementById('sin-horas');
                    const badge      = document.getElementById('badge-disponibilidad');

                    contenedor.style.display = 'block';
                    loading.style.display    = 'block';
                    select.style.display     = 'none';
                    sinHoras.style.display   = 'none';
                    badge.style.display      = 'none';
                    horasCargadas            = [];

                    fetch('/horas-disponibles?fecha=' + fecha)
                        .then(function(r) { return r.json(); })
                        .then(function(data) {
                            loading.style.display = 'none';

                            if (!data.horas || data.horas.length === 0) {
                                sinHoras.style.display = 'block';
                                sinHoras.innerHTML = '<i class="fas fa-calendar-times"></i> ' + (data.mensaje || 'No hay horarios disponibles para este día.');
                                return;
                            }

                            horasCargadas = data.horas;
                            select.innerHTML = '<option value="">Selecciona una hora</option>';
                            data.horas.forEach(function(slot) {
                                var opt = document.createElement('option');
                                opt.value = slot.hora;
                                opt.textContent = slot.label;
                                select.appendChild(opt);
                            });
                            select.style.display = 'block';
                        })
                        .catch(function() {
                            loading.style.display = 'none';
                            sinHoras.style.display = 'block';
                            sinHoras.innerHTML = '<i class="fas fa-exclamation-circle"></i> Error al cargar horas. Intenta de nuevo.';
                        });
                }

                function verificarHora(hora) {
                    var badge = document.getElementById('badge-disponibilidad');

                    if (!hora) {
                        badge.style.display = 'none';
                        return;
                    }

                    var slot = null;
                    for (var i = 0; i < horasCargadas.length; i++) {
                        if (horasCargadas[i].hora === hora) { slot = horasCargadas[i]; break; }
                    }

                    if (!slot) { badge.style.display = 'none'; return; }

                    badge.style.display = 'inline-block';

                    if (slot.disponible) {
                        badge.innerHTML = '<i class="fas fa-check-circle"></i> Disponible';
                        badge.style.background = '#d1fae5';
                        badge.style.color = '#059669';
                    } else {
                        badge.innerHTML = '<i class="fas fa-times-circle"></i> Ocupada';
                        badge.style.background = '#fee2e2';
                        badge.style.color = '#e11d48';
                        // Reset select después de 1.5s
                        setTimeout(function() {
                            document.getElementById('hora-select').value = '';
                            badge.style.display = 'none';
                        }, 1500);
                    }
                }

                document.addEventListener('DOMContentLoaded', function() {
                    var fechaInput = document.getElementById('fecha');
                    if (fechaInput && fechaInput.value) cargarHoras(fechaInput.value);
                });
                </script>
            </div>
        </div>
    </div>
</section>

{{-- ══ FOOTER ══ --}}
<footer class="footer">
    <div class="container">
        <div class="footer-inner">
            <div>
                <div class="footer-brand">{{ $medico->nombre_completo }}</div>
                <div class="footer-sub">
                    {{ $medico->especialidad->nombre ?? 'Medicina Estética' }}
                    @if($medico->cedula ?? $medico->cedula_profesional)
                        · Cédula {{ $medico->cedula ?? $medico->cedula_profesional }}
                    @endif
                    · Mazatlán, Sin.
                </div>
            </div>
            <div class="footer-links">
                @if($landing && $landing->instagram)
                <a href="https://instagram.com/{{ $landing->instagram }}" class="footer-link" target="_blank">
                    <i class="fab fa-instagram"></i> Instagram
                </a>
                @endif
                @if($landing && $landing->whatsapp)
                <a href="https://wa.me/52{{ preg_replace('/\D/','',$landing->whatsapp) }}" class="footer-link" target="_blank">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
                @endif
                @if($landing && $landing->facebook)
                <a href="https://facebook.com/{{ $landing->facebook }}" class="footer-link" target="_blank">
                    <i class="fab fa-facebook"></i> Facebook
                </a>
                @endif
            </div>
            <div class="footer-copy">© {{ date('Y') }} · Nova Systems</div>
        </div>
        <hr class="footer-divider">
        <div style="text-align:center;">
            <a href="{{ route('login') }}" style="font-size:10px;color:rgba(201,185,154,0.25);text-decoration:none;">Acceso médico</a>
        </div>
    </div>
</footer>

<script>
function toggleMenu() {
    const menu = document.getElementById('navMobile');
    menu.classList.toggle('open');
}
// Cerrar menú al hacer scroll
window.addEventListener('scroll', () => {
    document.getElementById('navMobile').classList.remove('open');
});
// Smooth scroll para links con #
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const target = document.querySelector(a.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});
</script>

</body>
</html>