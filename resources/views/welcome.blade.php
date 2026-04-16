<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Velinex Cloud — Enterprise Web & Email Hosting</title>
    <meta name="description" content="Production-grade web hosting and business email infrastructure. Built for teams that demand reliability, security, and control.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800|jetbrains-mono:400,500&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        /* ─── Landing-specific overrides & additions ─── */
        :root {
            --bg:         #06080D;
            --bg-surface: #0A0D18;
            --bg-card:    #0F1320;
            --bg-hover:   #141826;
            --border:     rgba(255,255,255,0.055);
            --border-hi:  rgba(255,255,255,0.11);
            --accent:     #00E5FF;
            --accent-dim: rgba(0,229,255,0.10);
            --success:    #00E599;
            --warning:    #FFB020;
            --danger:     #FF4D6A;
            --purple:     #A78BFA;
            --text:       #D8E0EF;
            --text-muted: #556070;
            --text-dim:   #283040;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { -webkit-font-smoothing: antialiased; scroll-behavior: smooth; }
        a { text-decoration: none; }
        button { cursor: pointer; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ─── Background ─── */
        .page-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .page-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        .page-bg-glow-1 {
            position: absolute;
            top: -200px; left: -200px;
            width: 800px; height: 800px;
            background: radial-gradient(ellipse, rgba(0,229,255,0.05) 0%, transparent 65%);
        }

        .page-bg-glow-2 {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 1000px; height: 600px;
            background: radial-gradient(ellipse, rgba(167,139,250,0.03) 0%, transparent 65%);
        }

        .page-bg-glow-3 {
            position: absolute;
            bottom: -200px; right: -200px;
            width: 700px; height: 700px;
            background: radial-gradient(ellipse, rgba(0,229,153,0.04) 0%, transparent 65%);
        }

        /* ─── Wrapper ─── */
        .wrap {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 32px;
            position: relative;
            z-index: 1;
        }

        /* ─── Nav ─── */
        nav.site-nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            background: rgba(6, 8, 13, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-mark {
            width: 28px; height: 28px;
            background: var(--accent);
            color: #000;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 11px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 6px;
            box-shadow: 0 0 18px rgba(0,229,255,0.3);
        }

        .nav-brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 15px;
            color: var(--text);
        }

        .nav-brand-sub {
            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            color: var(--accent);
            letter-spacing: 0.2em;
            text-transform: uppercase;
            display: block;
            line-height: 1;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link {
            padding: 6px 14px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
            transition: all 0.14s;
        }

        .nav-link:hover {
            color: var(--text);
            background: var(--bg-hover);
        }

        .nav-cta {
            background: var(--accent);
            color: #000 !important;
            font-weight: 600 !important;
            box-shadow: 0 0 16px rgba(0,229,255,0.25);
        }

        .nav-cta:hover {
            background: #33ECFF !important;
            box-shadow: 0 0 26px rgba(0,229,255,0.4) !important;
            transform: translateY(-1px);
        }

        /* ─── Hero ─── */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 80px;
            position: relative;
            overflow: hidden;
        }

        /* Scan-line effect */
        .hero::after {
            content: '';
            position: absolute;
            top: -100%; left: 0; right: 0;
            height: 200%;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 3px,
                rgba(255,255,255,0.005) 3px,
                rgba(255,255,255,0.005) 4px
            );
            pointer-events: none;
            animation: scanlines 8s linear infinite;
        }

        @keyframes scanlines {
            from { transform: translateY(0); }
            to   { transform: translateY(50%); }
        }

        .hero-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            width: 100%;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 4px 12px 4px 8px;
            background: var(--accent-dim);
            border: 1px solid rgba(0,229,255,0.18);
            border-radius: 99px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 22px;
        }

        .hero-eyebrow-dot {
            width: 6px; height: 6px;
            background: var(--accent);
            border-radius: 50%;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; box-shadow: 0 0 4px var(--accent); }
            50%       { opacity: 0.5; box-shadow: 0 0 10px var(--accent); }
        }

        .hero-h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(36px, 5vw, 58px);
            font-weight: 800;
            line-height: 1.08;
            letter-spacing: -0.02em;
            color: var(--text);
            margin-bottom: 20px;
        }

        .hero-h1 em {
            font-style: normal;
            color: var(--accent);
            position: relative;
        }

        .hero-sub {
            font-size: 16px;
            color: var(--text-muted);
            line-height: 1.65;
            max-width: 440px;
            margin-bottom: 36px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 24px;
            background: var(--accent);
            color: #000;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 700;
            border-radius: 10px;
            border: none;
            box-shadow: 0 0 30px rgba(0,229,255,0.3);
            transition: all 0.15s;
            white-space: nowrap;
        }

        .btn-hero-primary:hover {
            background: #33ECFF;
            box-shadow: 0 0 48px rgba(0,229,255,0.45);
            transform: translateY(-2px);
        }

        .btn-hero-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 24px;
            background: transparent;
            color: var(--text-muted);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            border-radius: 10px;
            border: 1px solid var(--border-hi);
            transition: all 0.15s;
            white-space: nowrap;
        }

        .btn-hero-secondary:hover {
            color: var(--text);
            border-color: var(--accent);
            background: var(--accent-dim);
        }

        /* Hero visual */
        .hero-visual {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .server-diagram {
            position: relative;
            width: 100%;
            max-width: 460px;
        }

        .server-unit {
            background: var(--bg-card);
            border: 1px solid var(--border-hi);
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: border-color 0.2s;
            position: relative;
            overflow: hidden;
        }

        .server-unit::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--unit-color, var(--accent)), transparent);
            opacity: 0.4;
        }

        .server-unit:hover { border-color: var(--border-hi); }

        .server-lights {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .s-light {
            width: 6px; height: 6px;
            border-radius: 50%;
        }

        .s-light.on  { background: var(--success); box-shadow: 0 0 6px var(--success); animation: blink 3s ease-in-out infinite; }
        .s-light.mid { background: var(--warning); box-shadow: 0 0 6px var(--warning); animation: blink 4.5s ease-in-out infinite; }
        .s-light.off { background: var(--text-dim); }

        @keyframes blink {
            0%, 95%, 100% { opacity: 1; }
            97% { opacity: 0.2; }
        }

        .server-bars {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .server-bar-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .server-bar-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            color: var(--text-muted);
            letter-spacing: 0.1em;
            width: 32px;
            flex-shrink: 0;
        }

        .server-bar-track {
            flex: 1;
            height: 4px;
            background: var(--bg-hover);
            border-radius: 2px;
            overflow: hidden;
        }

        .server-bar-fill {
            height: 100%;
            border-radius: 2px;
            background: var(--fill-color, var(--accent));
        }

        .server-tag {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 4px;
            flex-shrink: 0;
        }

        .server-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: var(--text);
            flex: 1;
        }

        .diagram-uptime {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background: rgba(0, 229, 153, 0.06);
            border: 1px solid rgba(0, 229, 153, 0.15);
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .uptime-val {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 20px;
            color: var(--success);
        }

        .uptime-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        /* ─── Metrics strip ─── */
        .metrics-strip {
            padding: 28px 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            margin: 80px 0;
            position: relative;
            z-index: 1;
        }

        .metrics-inner {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0;
        }

        .metric-item {
            text-align: center;
            border-right: 1px solid var(--border);
            padding: 0 20px;
        }

        .metric-item:last-child { border-right: none; }

        .metric-val {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 32px;
            font-weight: 800;
            color: var(--text);
            line-height: 1;
            margin-bottom: 6px;
        }

        .metric-val span { color: var(--accent); }

        .metric-desc {
            font-family: 'JetBrains Mono', monospace;
            font-size: 9.5px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        /* ─── Section shared styles ─── */
        section { position: relative; z-index: 1; }

        .section-eyebrow {
            font-family: 'JetBrains Mono', monospace;
            font-size: 9.5px;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 12px;
        }

        .section-h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(28px, 3.5vw, 42px);
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--text);
            line-height: 1.1;
            margin-bottom: 14px;
        }

        .section-sub {
            font-size: 15px;
            color: var(--text-muted);
            max-width: 520px;
            line-height: 1.65;
        }

        /* ─── Services ─── */
        .services-section { padding: 80px 0; }

        .services-header {
            text-align: center;
            margin-bottom: 56px;
        }

        .services-header .section-sub { margin: 0 auto; }

        .services-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .service-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 36px;
            position: relative;
            overflow: hidden;
            transition: border-color 0.2s, transform 0.2s;
        }

        .service-card:hover {
            border-color: var(--border-hi);
            transform: translateY(-3px);
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--s-color, var(--accent)), transparent);
            opacity: 0.5;
        }

        .service-card-glow {
            position: absolute;
            top: -60px; right: -60px;
            width: 200px; height: 200px;
            background: radial-gradient(ellipse, var(--s-glow, rgba(0,229,255,0.06)) 0%, transparent 65%);
            pointer-events: none;
        }

        .service-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 22px;
        }

        .service-icon svg { width: 22px; height: 22px; }

        .service-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 10px;
        }

        .service-desc {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.65;
            margin-bottom: 26px;
        }

        .service-features {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .service-features li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13.5px;
            color: var(--text-muted);
        }

        .check-icon {
            width: 18px; height: 18px;
            border-radius: 50%;
            background: var(--s-icon-bg, rgba(0,229,255,0.12));
            color: var(--s-icon-color, var(--accent));
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .check-icon svg { width: 10px; height: 10px; }

        /* ─── Features grid ─── */
        .features-section { padding: 80px 0; }

        .features-layout {
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 60px;
            align-items: center;
        }

        .features-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .feat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            transition: border-color 0.18s;
        }

        .feat-card:hover { border-color: var(--border-hi); }

        .feat-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 12px;
        }

        .feat-icon svg { width: 15px; height: 15px; }

        .feat-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 6px;
        }

        .feat-desc {
            font-size: 12.5px;
            color: var(--text-muted);
            line-height: 1.55;
        }

        /* ─── How it works ─── */
        .how-section { padding: 80px 0; }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-top: 50px;
            position: relative;
        }

        .steps-grid::before {
            content: '';
            position: absolute;
            top: 32px; left: calc(16.66% + 20px); right: calc(16.66% + 20px);
            height: 1px;
            background: linear-gradient(90deg, var(--accent) 0%, var(--purple) 100%);
            opacity: 0.2;
        }

        .step-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 28px 24px;
            position: relative;
            text-align: center;
        }

        .step-number {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: var(--bg-hover);
            border: 1px solid var(--border-hi);
            font-family: 'JetBrains Mono', monospace;
            font-size: 14px;
            font-weight: 500;
            color: var(--accent);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 18px;
        }

        .step-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
        }

        .step-desc {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ─── CTA Section ─── */
        .cta-section { padding: 100px 0; }

        .cta-box {
            background: var(--bg-card);
            border: 1px solid var(--border-hi);
            border-radius: 24px;
            padding: 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-box::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent), var(--purple), transparent);
            opacity: 0.5;
        }

        .cta-glow-1 {
            position: absolute;
            top: -80px; left: -80px;
            width: 300px; height: 300px;
            background: radial-gradient(ellipse, rgba(0,229,255,0.05) 0%, transparent 65%);
            pointer-events: none;
        }

        .cta-glow-2 {
            position: absolute;
            bottom: -80px; right: -80px;
            width: 300px; height: 300px;
            background: radial-gradient(ellipse, rgba(167,139,250,0.05) 0%, transparent 65%);
            pointer-events: none;
        }

        .cta-h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(28px, 4vw, 44px);
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--text);
            margin-bottom: 14px;
            line-height: 1.1;
            position: relative;
        }

        .cta-sub {
            font-size: 15px;
            color: var(--text-muted);
            margin-bottom: 36px;
            max-width: 480px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
        }

        .cta-actions {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            position: relative;
        }

        /* ─── Footer ─── */
        .site-footer {
            border-top: 1px solid var(--border);
            padding: 40px 0;
            position: relative;
            z-index: 1;
        }

        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-copy {
            font-size: 12px;
            color: var(--text-muted);
        }

        .footer-links {
            display: flex;
            gap: 20px;
        }

        .footer-links a {
            font-size: 12px;
            color: var(--text-muted);
            transition: color 0.14s;
        }

        .footer-links a:hover { color: var(--text); }

        /* ─── Animations ─── */
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .hero-eyebrow { animation: fade-up 0.5s ease 0.1s both; }
        .hero-h1      { animation: fade-up 0.5s ease 0.2s both; }
        .hero-sub     { animation: fade-up 0.5s ease 0.32s both; }
        .hero-actions { animation: fade-up 0.5s ease 0.44s both; }
        .hero-visual  { animation: fade-up 0.6s ease 0.3s both; }

        /* ─── Scroll reveal ─── */
        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

<div class="page-bg">
    <div class="page-bg-glow-1"></div>
    <div class="page-bg-glow-2"></div>
    <div class="page-bg-glow-3"></div>
</div>

{{-- ─── Nav ─── --}}
<nav class="site-nav">
    <div class="nav-brand">
        <div class="nav-mark">VX</div>
        <div>
            <div class="nav-brand-name">Velinex</div>
            <span class="nav-brand-sub">Cloud</span>
        </div>
    </div>
    <div class="nav-links">
        <a href="#services" class="nav-link">Services</a>
        <a href="#features" class="nav-link">Features</a>
        <a href="#how" class="nav-link">How it works</a>
        @auth
            <a href="{{ route('mail.domains.index') }}" class="nav-link nav-cta">Dashboard →</a>
        @else
            <a href="{{ route('login') }}" class="nav-link">Sign in</a>
            <a href="{{ route('auth.register') }}" class="nav-link nav-cta">Get started →</a>
        @endauth
    </div>
</nav>

{{-- ─── Hero ─── --}}
<section class="hero">
    <div class="wrap">
        <div class="hero-inner">
            <div>
                <div class="hero-eyebrow">
                    <span class="hero-eyebrow-dot"></span>
                    Enterprise Infrastructure
                </div>
                <h1 class="hero-h1">
                    Hosting that<br>
                    works as hard<br>
                    as <em>you do.</em>
                </h1>
                <p class="hero-sub">
                    Production-grade web hosting and business email built
                    for teams that won't compromise on uptime, security, or
                    deliverability. Your infrastructure, fully under control.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('auth.register') }}" class="btn-hero-primary">
                        Start for free
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                            <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </a>
                    <a href="#features" class="btn-hero-secondary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px;height:15px;">
                            <circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/>
                        </svg>
                        See how it works
                    </a>
                </div>
            </div>

            {{-- Server Diagram --}}
            <div class="hero-visual">
                <div class="server-diagram">
                    <div class="diagram-uptime">
                        <div>
                            <div class="uptime-val">99.97%</div>
                            <div class="uptime-label">Uptime SLA</div>
                        </div>
                        <div style="flex:1; display:flex; gap: 3px; align-items: flex-end; height: 36px; padding: 0 12px;">
                            @php $bars = [60, 75, 55, 80, 90, 70, 95, 85, 100, 88, 92, 78, 95, 100, 96]; @endphp
                            @foreach($bars as $h)
                                <div style="flex:1; background: rgba(0,229,153,0.3); border-radius: 2px; height: {{ $h }}%;"></div>
                            @endforeach
                        </div>
                        <div style="font-family:'DM Mono',monospace; font-size:10px; color: var(--success);">● LIVE</div>
                    </div>

                    <div class="server-unit" style="--unit-color: var(--accent);">
                        <div class="server-lights">
                            <div class="s-light on"></div>
                            <div class="s-light on" style="animation-delay: 1s;"></div>
                            <div class="s-light mid"></div>
                        </div>
                        <div style="flex:1;">
                            <div class="server-title">Web Cluster — KE-01</div>
                            <div class="server-bars" style="margin-top: 6px;">
                                <div class="server-bar-row">
                                    <span class="server-bar-label">CPU</span>
                                    <div class="server-bar-track"><div class="server-bar-fill" style="width:42%;--fill-color:var(--accent);"></div></div>
                                </div>
                                <div class="server-bar-row">
                                    <span class="server-bar-label">RAM</span>
                                    <div class="server-bar-track"><div class="server-bar-fill" style="width:67%;--fill-color:var(--purple);"></div></div>
                                </div>
                            </div>
                        </div>
                        <span class="server-tag" style="background: rgba(0,229,255,0.12); color: var(--accent);">nginx</span>
                    </div>

                    <div class="server-unit" style="--unit-color: var(--purple);">
                        <div class="server-lights">
                            <div class="s-light on" style="animation-delay: 0.5s;"></div>
                            <div class="s-light on" style="animation-delay: 2s;"></div>
                            <div class="s-light off"></div>
                        </div>
                        <div style="flex:1;">
                            <div class="server-title">Mail Server — iRedMail</div>
                            <div class="server-bars" style="margin-top: 6px;">
                                <div class="server-bar-row">
                                    <span class="server-bar-label">SMTP</span>
                                    <div class="server-bar-track"><div class="server-bar-fill" style="width:28%;--fill-color:var(--success);"></div></div>
                                </div>
                                <div class="server-bar-row">
                                    <span class="server-bar-label">Queue</span>
                                    <div class="server-bar-track"><div class="server-bar-fill" style="width:15%;--fill-color:var(--warning);"></div></div>
                                </div>
                            </div>
                        </div>
                        <span class="server-tag" style="background: rgba(167,139,250,0.12); color: var(--purple);">postfix</span>
                    </div>

                    <div class="server-unit" style="--unit-color: var(--success);">
                        <div class="server-lights">
                            <div class="s-light on" style="animation-delay: 1.5s;"></div>
                            <div class="s-light mid" style="animation-delay: 0.8s;"></div>
                            <div class="s-light on"></div>
                        </div>
                        <div style="flex:1;">
                            <div class="server-title">DNS Resolver — Anycast</div>
                            <div class="server-bars" style="margin-top: 6px;">
                                <div class="server-bar-row">
                                    <span class="server-bar-label">Lat.</span>
                                    <div class="server-bar-track"><div class="server-bar-fill" style="width:12%;--fill-color:var(--success);"></div></div>
                                </div>
                                <div class="server-bar-row">
                                    <span class="server-bar-label">RPS</span>
                                    <div class="server-bar-track"><div class="server-bar-fill" style="width:58%;--fill-color:var(--accent);"></div></div>
                                </div>
                            </div>
                        </div>
                        <span class="server-tag" style="background: rgba(0,229,153,0.12); color: var(--success);">bind9</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ─── Metrics ─── --}}
<div class="metrics-strip" style="position:relative;z-index:1;">
    <div class="wrap">
        <div class="metrics-inner">
            <div class="metric-item reveal">
                <div class="metric-val">99<span>.97%</span></div>
                <div class="metric-desc">Uptime Guarantee</div>
            </div>
            <div class="metric-item reveal" style="transition-delay:0.1s;">
                <div class="metric-val"><span>&lt;</span>5ms</div>
                <div class="metric-desc">DNS propagation</div>
            </div>
            <div class="metric-item reveal" style="transition-delay:0.2s;">
                <div class="metric-val">24<span>/7</span></div>
                <div class="metric-desc">Expert Support</div>
            </div>
            <div class="metric-item reveal" style="transition-delay:0.3s;">
                <div class="metric-val"><span>∞</span></div>
                <div class="metric-desc">Mailboxes per domain</div>
            </div>
        </div>
    </div>
</div>

{{-- ─── Services ─── --}}
<section id="services" class="services-section">
    <div class="wrap">
        <div class="services-header reveal">
            <div class="section-eyebrow">What we offer</div>
            <h2 class="section-h2">Two pillars of your<br>online presence.</h2>
            <p class="section-sub">Everything your business needs to communicate reliably and host at scale.</p>
        </div>
        <div class="services-grid">
            <div class="service-card reveal" style="--s-color: var(--accent);">
                <div class="service-card-glow" style="--s-glow: rgba(0,229,255,0.07);"></div>
                <div class="service-icon" style="background: rgba(0,229,255,0.10); color: var(--accent);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                </div>
                <div class="service-title">Web Hosting</div>
                <div class="service-desc">
                    High-performance hosting powered by nginx and LiteSpeed. SSD storage, HTTP/3, automatic SSL, and global CDN edge nodes for blazing-fast delivery anywhere.
                </div>
                <ul class="service-features" style="--s-icon-bg: rgba(0,229,255,0.10); --s-icon-color: var(--accent);">
                    <li>
                        <div class="check-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                        Automatic SSL certificates via Let's Encrypt
                    </li>
                    <li>
                        <div class="check-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                        PHP 8.3, Node.js, Python, Ruby runtimes
                    </li>
                    <li>
                        <div class="check-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                        One-click staging &amp; deployment pipelines
                    </li>
                    <li>
                        <div class="check-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                        Daily automated backups, 30-day retention
                    </li>
                </ul>
            </div>

            <div class="service-card reveal" style="--s-color: var(--purple); transition-delay: 0.12s;">
                <div class="service-card-glow" style="--s-glow: rgba(167,139,250,0.06);"></div>
                <div class="service-icon" style="background: rgba(167,139,250,0.10); color: var(--purple);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
                <div class="service-title">Business Email</div>
                <div class="service-desc">
                    Self-hosted iRedMail infrastructure with complete DNS control. Your brand, your domain, your data — with SPF, DKIM, and DMARC configured in minutes.
                </div>
                <ul class="service-features" style="--s-icon-bg: rgba(167,139,250,0.10); --s-icon-color: var(--purple);">
                    <li>
                        <div class="check-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                        Auto-generated SPF, DKIM &amp; DMARC records
                    </li>
                    <li>
                        <div class="check-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                        Unlimited mailboxes per domain
                    </li>
                    <li>
                        <div class="check-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                        Webmail (Roundcube) + IMAP/SMTP access
                    </li>
                    <li>
                        <div class="check-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                        Spam filtering, virus scanning, greylisting
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ─── Features ─── --}}
<section id="features" class="features-section">
    <div class="wrap">
        <div class="features-layout">
            <div class="reveal">
                <div class="section-eyebrow">Why Velinex</div>
                <h2 class="section-h2">Built different,<br>by design.</h2>
                <p class="section-sub" style="margin-bottom: 28px;">
                    We don't cut corners on infrastructure. Every service is engineered
                    for reliability, security, and full transparency.
                </p>
                <a href="{{ route('auth.register') }}" class="btn-hero-primary" style="font-size:13px; padding: 10px 20px;">
                    Get started free
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;">
                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            </div>
            <div class="features-grid reveal" style="transition-delay: 0.15s;">
                <div class="feat-card">
                    <div class="feat-icon" style="background: rgba(0,229,255,0.10); color: var(--accent);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div class="feat-title">Zero-trust Security</div>
                    <div class="feat-desc">TLS 1.3 everywhere, hardened server configs, and automated vulnerability scans.</div>
                </div>
                <div class="feat-card">
                    <div class="feat-icon" style="background: rgba(0,229,153,0.10); color: var(--success);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    </div>
                    <div class="feat-title">Real-time Monitoring</div>
                    <div class="feat-desc">Live dashboards for uptime, mail queues, DNS propagation, and delivery rates.</div>
                </div>
                <div class="feat-card">
                    <div class="feat-icon" style="background: rgba(167,139,250,0.10); color: var(--purple);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    </div>
                    <div class="feat-title">Instant Provisioning</div>
                    <div class="feat-desc">Domains, mailboxes, and DNS records provisioned in under 60 seconds via the dashboard.</div>
                </div>
                <div class="feat-card">
                    <div class="feat-icon" style="background: rgba(255,176,32,0.10); color: var(--warning);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div class="feat-title">99.97% Uptime SLA</div>
                    <div class="feat-desc">Guaranteed availability backed by redundant infrastructure and proactive failover.</div>
                </div>
                <div class="feat-card">
                    <div class="feat-icon" style="background: rgba(255,77,106,0.10); color: var(--danger);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    </div>
                    <div class="feat-title">Developer-first API</div>
                    <div class="feat-desc">Automate everything — domain creation, mailbox management, and DNS via REST API.</div>
                </div>
                <div class="feat-card">
                    <div class="feat-icon" style="background: rgba(0,229,255,0.10); color: var(--accent);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="feat-title">Multi-tenant Ready</div>
                    <div class="feat-desc">Manage multiple client domains and organizations from a single unified dashboard.</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ─── How it works ─── --}}
<section id="how" class="how-section">
    <div class="wrap">
        <div style="text-align: center;" class="reveal">
            <div class="section-eyebrow">Getting started</div>
            <h2 class="section-h2">Up and running in<br>three steps.</h2>
        </div>
        <div class="steps-grid">
            <div class="step-card reveal" style="transition-delay: 0.05s;">
                <div class="step-number">01</div>
                <div class="step-title">Create your account</div>
                <div class="step-desc">Register in under 60 seconds. No credit card required to start. Your company workspace is provisioned instantly.</div>
            </div>
            <div class="step-card reveal" style="transition-delay: 0.15s;">
                <div class="step-number">02</div>
                <div class="step-title">Add your domain</div>
                <div class="step-desc">Enter your domain name. We auto-generate all required DNS records — SPF, DKIM, DMARC, and MX — ready to copy-paste.</div>
            </div>
            <div class="step-card reveal" style="transition-delay: 0.25s;">
                <div class="step-number">03</div>
                <div class="step-title">Go live</div>
                <div class="step-desc">Verify DNS propagation with one click, provision mailboxes, and you're fully operational. No command line needed.</div>
            </div>
        </div>
    </div>
</section>

{{-- ─── CTA ─── --}}
<section class="cta-section">
    <div class="wrap">
        <div class="cta-box reveal">
            <div class="cta-glow-1"></div>
            <div class="cta-glow-2"></div>
            <div class="cta-h2">Your infrastructure.<br>Your control.</div>
            <p class="cta-sub">
                Join businesses across East Africa that trust Velinex Cloud
                for their web and email infrastructure.
            </p>
            <div class="cta-actions">
                <a href="{{ route('auth.register') }}" class="btn-hero-primary">
                    Start free today
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
                <a href="{{ route('login') }}" class="btn-hero-secondary">
                    Sign in →
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ─── Footer ─── --}}
<footer class="site-footer">
    <div class="wrap">
        <div class="footer-inner">
            <div class="footer-brand">
                <div class="nav-mark">VX</div>
                <div>
                    <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;color:var(--text);">Velinex Cloud</div>
                    <div style="font-family:'DM Mono',monospace;font-size:9px;color:var(--text-muted);">cloud.velinexlabs.com</div>
                </div>
            </div>
            <div class="footer-copy">© {{ date('Y') }} Velinex Labs. All rights reserved.</div>
            <div class="footer-links">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
                <a href="{{ route('login') }}">Sign in</a>
            </div>
        </div>
    </div>
</footer>

<script>
    // Scroll reveal
    const reveals = document.querySelectorAll('.reveal');
    const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
            }
        });
    }, { threshold: 0.12 });
    reveals.forEach((el) => io.observe(el));
</script>

</body>
</html>
