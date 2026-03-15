<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión · ClinicaSistema</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --lila-50:  #ede9fe;
            --lila-100: #ddd6fe;
            --lila-200: #c4b5fd;
            --lila-400: #a78bfa;
            --purple:   #7c3aed;
            --purple-d: #6d28d9;
            --navy:     #1e1b4b;
            --text:     #334155;
            --muted:    #94a3b8;
            --border:   #e8e4f0;
            --bg:       #fafafa;
        }

        html, body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            overflow: hidden;
        }

        /* ══════════════ LAYOUT SPLIT ══════════════ */
        .login-wrap {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* ── PANEL IZQUIERDO: lila suave ── */
        .panel-left {
            width: 42%;
            background: var(--lila-50);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 44px;
            position: relative;
            overflow: hidden;
        }

        /* Círculo decorativo */
        .panel-left::before {
            content: '';
            position: absolute;
            bottom: -80px;
            right: -80px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: rgba(124, 58, 237, 0.07);
        }
        .panel-left::after {
            content: '';
            position: absolute;
            bottom: -20px;
            right: -20px;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: rgba(124, 58, 237, 0.05);
        }

        /* Logo */
        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }
        .brand-icon {
            width: 44px;
            height: 44px;
            background: var(--purple);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .brand-icon i { color: white; font-size: 18px; }
        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--navy);
            line-height: 1.1;
        }
        .brand-name span {
            display: block;
            font-size: 10px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            color: var(--purple);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 1px;
        }

        /* Contenido central izquierdo */
        .panel-left-body {
            position: relative;
            z-index: 1;
        }
        .panel-tagline {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--navy);
            line-height: 1.15;
            margin-bottom: 14px;
        }
        .panel-tagline em {
            font-style: italic;
            color: var(--purple);
        }
        .panel-desc {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.7;
            max-width: 260px;
            margin-bottom: 32px;
        }

        /* Features */
        .features { display: flex; flex-direction: column; gap: 10px; }
        .feature {
            display: flex;
            align-items: center;
            gap: 10px;
            opacity: 0;
            animation: slideIn 0.5s forwards;
        }
        .feature:nth-child(1) { animation-delay: 0.2s; }
        .feature:nth-child(2) { animation-delay: 0.35s; }
        .feature:nth-child(3) { animation-delay: 0.5s; }
        .feature:nth-child(4) { animation-delay: 0.65s; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-12px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .feature-bar {
            width: 18px;
            height: 2px;
            background: var(--lila-200);
            border-radius: 2px;
            flex-shrink: 0;
            transition: width 0.3s;
        }
        .feature:hover .feature-bar { width: 26px; background: var(--purple); }
        .feature-txt {
            font-size: 12px;
            color: var(--purple);
            font-weight: 500;
            letter-spacing: 0.2px;
        }

        /* Footer izquierdo */
        .panel-left-footer {
            position: relative;
            z-index: 1;
            font-size: 11px;
            color: var(--lila-200);
            letter-spacing: 0.3px;
        }

        /* ── PANEL DERECHO: blanco ── */
        .panel-right {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 60px;
            position: relative;
        }

        /* Línea sutil de separación */
        .panel-right::before {
            content: '';
            position: absolute;
            left: 0;
            top: 10%;
            bottom: 10%;
            width: 1px;
            background: var(--lila-100);
        }

        /* Formulario */
        .form-wrap {
            width: 100%;
            max-width: 380px;
            opacity: 0;
            animation: fadeUp 0.6s 0.1s forwards;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .form-eyebrow {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .eyebrow-dot {
            width: 8px;
            height: 8px;
            background: var(--purple);
            border-radius: 50%;
        }
        .eyebrow-txt {
            font-size: 11px;
            color: var(--purple);
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 6px;
            line-height: 1.15;
        }
        .form-title em { color: var(--purple); font-style: italic; }

        .form-sub {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 32px;
            line-height: 1.5;
        }

        /* Grupos de campo */
        .field-group {
            margin-bottom: 20px;
        }
        .field-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 6px;
        }
        .field-wrap {
            position: relative;
        }
        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--lila-200);
            font-size: 13px;
            transition: color 0.2s;
        }
        .field-input {
            width: 100%;
            padding: 12px 14px 12px 40px;
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 13px;
            color: var(--navy);
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .field-input:focus {
            border-color: var(--purple);
            background: white;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.08);
        }
        .field-input:focus + .field-icon,
        .field-wrap:focus-within .field-icon {
            color: var(--purple);
        }
        .field-input::placeholder { color: #cbd5e1; }

        /* Fila recuérdame / olvidé */
        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .remember-wrap {
            display: flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
        }
        .remember-wrap input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: var(--purple);
            cursor: pointer;
        }
        .remember-txt {
            font-size: 12px;
            color: var(--muted);
        }
        .forgot-link {
            font-size: 12px;
            color: var(--purple);
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.2s;
        }
        .forgot-link:hover { opacity: 0.7; }

        /* Botón */
        .btn-login {
            width: 100%;
            padding: 13px;
            background: var(--purple);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            letter-spacing: 0.3px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
        }
        .btn-login:hover {
            background: var(--purple-d);
            box-shadow: 0 4px 16px rgba(124, 58, 237, 0.3);
        }
        .btn-login:active { transform: scale(0.99); }
        .btn-arrow { transition: transform 0.2s; }
        .btn-login:hover .btn-arrow { transform: translateX(4px); }

        /* Mensajes de error */
        .error-msg {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 12px;
            color: #b91c1c;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Footer derecho */
        .form-footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
            text-align: center;
            font-size: 11px;
            color: #cbd5e1;
            letter-spacing: 0.3px;
        }

        /* Responsive básico */
        @media (max-width: 768px) {
            .panel-left { display: none; }
            .panel-right { padding: 40px 28px; }
            .panel-right::before { display: none; }
        }
    </style>
</head>
<body>

<div class="login-wrap">

    {{-- ── PANEL IZQUIERDO ── --}}
    <div class="panel-left">

        {{-- Logo --}}
        <div class="brand-wrap">
            <div class="brand-icon">
                <i class="fas fa-plus"></i>
            </div>
            <div class="brand-name">
               Nova Systems
                <span>Sistema médico</span>
            </div>
        </div>

        {{-- Tagline + features --}}
        <div class="panel-left-body">
            <div class="panel-tagline">
                Hola,<br><em>doctor.</em>
            </div>
            <p class="panel-desc">
                Tu plataforma clínica integral. Gestiona citas, expedientes, recetas y más desde un solo lugar.
            </p>
            <div class="features">
                <div class="feature">
                    <div class="feature-bar"></div>
                    <span class="feature-txt">Agenda inteligente de citas</span>
                </div>
                <div class="feature">
                    <div class="feature-bar"></div>
                    <span class="feature-txt">Expedientes clínicos digitales</span>
                </div>
                <div class="feature">
                    <div class="feature-bar"></div>
                    <span class="feature-txt">Recetas médicas en PDF</span>
                </div>
                <div class="feature">
                    <div class="feature-bar"></div>
                    <span class="feature-txt">Recordatorios de Citas</span>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="panel-left-footer">
            © {{ date('Y') }} Nova Systems · Mazatlán, Sin.
        </div>

    </div>

    {{-- ── PANEL DERECHO: FORMULARIO ── --}}
    <div class="panel-right">
        <div class="form-wrap">

            {{-- Eyebrow --}}
            <div class="form-eyebrow">
                <div class="eyebrow-dot"></div>
                <span class="eyebrow-txt">Acceso médico</span>
            </div>

            {{-- Título --}}
            <h1 class="form-title">Iniciar <em>sesión</em></h1>
            <p class="form-sub">Ingresa tus credenciales para acceder a tu panel</p>

            {{-- Errores --}}
            @if($errors->any())
            <div class="error-msg">
                <i class="fas fa-circle-exclamation"></i>
                {{ $errors->first() }}
            </div>
            @endif

            {{-- Session status (Breeze) --}}
            @if (session('status'))
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:10px 14px;font-size:12px;color:#15803d;margin-bottom:20px;">
                {{ session('status') }}
            </div>
            @endif

            {{-- Formulario --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="field-group">
                    <label class="field-label" for="email">Correo electrónico</label>
                    <div class="field-wrap">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="field-input"
                            value="{{ old('email') }}"
                            placeholder="medico@clinica.com"
                            required
                            autofocus
                            autocomplete="username">
                        <i class="fas fa-envelope field-icon"></i>
                    </div>
                    @error('email')
                    <span style="font-size:11px;color:#b91c1c;margin-top:4px;display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="field-group">
                    <label class="field-label" for="password">Contraseña</label>
                    <div class="field-wrap">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="field-input"
                            placeholder="••••••••"
                            required
                            autocomplete="current-password">
                        <i class="fas fa-lock field-icon"></i>
                    </div>
                    @error('password')
                    <span style="font-size:11px;color:#b91c1c;margin-top:4px;display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Recuérdame / Olvidé --}}
                <div class="form-row">
                    <label class="remember-wrap">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="remember-txt">Recuérdame</span>
                    </label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">
                        ¿Olvidaste tu contraseña?
                    </a>
                    @endif
                </div>

                {{-- Botón --}}
                <button type="submit" class="btn-login">
                    Entrar al sistema
                    <i class="fas fa-arrow-right btn-arrow"></i>
                </button>

            </form>

            {{-- Footer --}}
            <div class="form-footer">
                Sistema clínico NOVASYSTEMS Create by Arturo-Tirado · v2.0
            </div>

        </div>
    </div>

</div>

</body>
</html>