<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Velinex Cloud — Web & Email Hosting for Business</title>
    <meta name="description" content="Enterprise-grade web hosting and business email. Built for reliability, security, and scale.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root {
            --bg:         #ffffff;
            --bg-2:       #f7f8fa;
            --bg-3:       #eef0f4;
            --text:       #0e1117;
            --text-2:     #4b5563;
            --text-3:     #9ca3af;
            --blue:       #1a6cf0;
            --blue-dim:   rgba(26, 108, 240, 0.07);
            --blue-mid:   rgba(26, 108, 240, 0.14);
            --green:      #059669;
            --green-dim:  rgba(5, 150, 105, 0.08);
            --border:     rgba(0, 0, 0, 0.08);
            --border-hi:  rgba(0, 0, 0, 0.13);
            --shadow-sm:  0 1px 3px rgba(0,0,0,0.07), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md:  0 4px 16px rgba(0,0,0,0.08);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { -webkit-font-smoothing: antialiased; scroll-behavior: smooth; }
        a { text-decoration: none; color: inherit; }
        button { cursor: pointer; font-family: inherit; }
        img { display: block; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Figtree', system-ui, sans-serif;
            font-weight: 400;
            font-size: 15px;
            line-height: 1.6;
        }

        .wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 28px;
        }

        /* ─── Nav ─── */
        .nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            height: 56px;
            display: flex;
            align-items: center;
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-logo {
            width: 26px; height: 26px;
            background: var(--blue);
            color: #fff;
            font-size: 10px;
            font-weight: 400;
            letter-spacing: 0.06em;
            display: flex; align-items: center; justify-content: center;
            border-radius: 5px;
        }

        .nav-name {
            font-size: 14px;
            font-weight: 400;
            color: var(--text);
            letter-spacing: 0.01em;
        }

        .nav-name span {
            color: var(--text-2);
            font-weight: 300;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .nav-link {
            padding: 5px 12px;
            font-size: 13px;
            font-weight: 300;
            color: var(--text-2);
            border-radius: 5px;
            transition: color 0.12s, background 0.12s;
        }

        .nav-link:hover { color: var(--text); background: var(--bg-2); }

        .nav-btn {
            padding: 6px 16px;
            font-size: 13px;
            font-weight: 400;
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 5px;
            transition: background 0.12s, box-shadow 0.12s;
            display: inline-block;
        }

        .nav-btn:hover {
            background: #1558cc;
            box-shadow: 0 2px 8px rgba(26,108,240,0.28);
        }

        .nav-login {
            font-size: 13px;
            font-weight: 300;
            color: var(--text-2);
            padding: 6px 12px;
            transition: color 0.12s;
        }

        .nav-login:hover { color: var(--blue); }

        /* ─── Hero ─── */
        .hero {
            padding: 80px 0 64px;
            position: relative;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 60% 50%, rgba(26,108,240,0.04) 0%, transparent 70%),
                linear-gradient(180deg, #ffffff 0%, #f7f8fa 100%);
            z-index: 0;
        }

        /* subtle grid */
        .hero-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(0,0,0,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,0,0,0.025) 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: radial-gradient(ellipse 70% 70% at 60% 40%, black 20%, transparent 80%);
        }

        .hero-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 64px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 3px 10px 3px 8px;
            background: var(--blue-dim);
            border: 1px solid var(--blue-mid);
            border-radius: 99px;
            font-size: 11px;
            font-weight: 400;
            color: var(--blue);
            margin-bottom: 20px;
            letter-spacing: 0.02em;
        }

        .hero-badge-dot {
            width: 5px; height: 5px;
            background: var(--blue);
            border-radius: 50%;
            animation: blink 2.5s ease-in-out infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.35; }
        }

        .hero-h1 {
            font-size: 40px;
            font-weight: 300;
            line-height: 1.15;
            letter-spacing: -0.02em;
            color: var(--text);
            margin-bottom: 16px;
        }

        .hero-h1 strong {
            font-weight: 400;
            color: var(--blue);
        }

        .hero-sub {
            font-size: 15px;
            font-weight: 300;
            color: var(--text-2);
            line-height: 1.65;
            max-width: 400px;
            margin-bottom: 32px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            background: var(--blue);
            color: #fff;
            font-size: 13px;
            font-weight: 400;
            border: none;
            border-radius: 6px;
            transition: background 0.13s, box-shadow 0.13s, transform 0.13s;
        }

        .btn-primary:hover {
            background: #1558cc;
            box-shadow: 0 3px 12px rgba(26,108,240,0.32);
            transform: translateY(-1px);
        }

        .btn-primary svg { width: 13px; height: 13px; }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            background: transparent;
            color: var(--text-2);
            font-size: 13px;
            font-weight: 300;
            border: 1px solid var(--border-hi);
            border-radius: 6px;
            transition: border-color 0.13s, color 0.13s, background 0.13s;
        }

        .btn-secondary:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-dim);
        }

        /* Hero visual — product card mockup */
        .hero-visual {
            position: relative;
        }

        .product-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .pc-topbar {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-bottom: 1px solid var(--border);
            background: var(--bg-2);
        }

        .pc-dots { display: flex; gap: 5px; }
        .pc-dot { width: 9px; height: 9px; border-radius: 50%; }

        .pc-title {
            font-size: 11px;
            font-weight: 300;
            color: var(--text-3);
            font-family: 'Figtree', sans-serif;
            letter-spacing: 0.03em;
        }

        .pc-body { padding: 16px; }

        .pc-stat-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 14px;
        }

        .pc-stat {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 10px 12px;
        }

        .pc-stat-val {
            font-size: 18px;
            font-weight: 300;
            color: var(--text);
            line-height: 1;
            margin-bottom: 3px;
        }

        .pc-stat-lbl {
            font-size: 10px;
            font-weight: 300;
            color: var(--text-3);
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .pc-table-head {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 6px;
            padding: 6px 8px;
            border-bottom: 1px solid var(--border);
        }

        .pc-th {
            font-size: 9.5px;
            font-weight: 300;
            color: var(--text-3);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .pc-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 6px;
            padding: 8px 8px;
            border-bottom: 1px solid var(--border);
            align-items: center;
            transition: background 0.1s;
        }

        .pc-row:last-child { border-bottom: none; }
        .pc-row:hover { background: var(--bg-2); }

        .pc-domain {
            font-size: 12px;
            font-weight: 400;
            color: var(--text);
            font-family: 'Courier New', monospace;
        }

        .pc-cell {
            font-size: 11px;
            font-weight: 300;
            color: var(--text-2);
        }

        .pc-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 7px;
            border-radius: 99px;
            font-size: 9.5px;
            font-weight: 400;
        }

        .pc-badge-green {
            background: var(--green-dim);
            color: var(--green);
        }

        .pc-badge-amber {
            background: rgba(245,158,11,0.08);
            color: #d97706;
        }

        .pc-badge-dot {
            width: 4px; height: 4px;
            border-radius: 50%;
            background: currentColor;
        }

        /* floating accent card */
        .pc-float {
            position: absolute;
            bottom: -16px;
            right: -20px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px 16px;
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        .pc-float-icon {
            width: 30px; height: 30px;
            background: var(--green-dim);
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            color: var(--green);
            flex-shrink: 0;
        }

        .pc-float-icon svg { width: 14px; height: 14px; }
        .pc-float-val { font-size: 15px; font-weight: 300; color: var(--text); }
        .pc-float-lbl { font-size: 10px; font-weight: 300; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.06em; }

        /* ─── Metrics bar ─── */
        .metrics {
            padding: 32px 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
        }

        .metric {
            text-align: center;
            padding: 0 16px;
            border-right: 1px solid var(--border);
        }

        .metric:last-child { border-right: none; }

        .metric-val {
            font-size: 28px;
            font-weight: 300;
            color: var(--text);
            letter-spacing: -0.02em;
            line-height: 1;
            margin-bottom: 5px;
        }

        .metric-val em {
            font-style: normal;
            color: var(--blue);
        }

        .metric-lbl {
            font-size: 12px;
            font-weight: 300;
            color: var(--text-3);
            letter-spacing: 0.02em;
        }

        /* ─── Section shared ─── */
        section { position: relative; }

        .section-label {
            font-size: 11px;
            font-weight: 400;
            color: var(--blue);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-label::before {
            content: '';
            width: 18px; height: 1px;
            background: var(--blue);
            border-radius: 1px;
        }

        .section-h2 {
            font-size: 30px;
            font-weight: 300;
            letter-spacing: -0.02em;
            color: var(--text);
            line-height: 1.2;
            margin-bottom: 10px;
        }

        .section-sub {
            font-size: 14px;
            font-weight: 300;
            color: var(--text-2);
            line-height: 1.65;
            max-width: 500px;
        }

        /* ─── Services ─── */
        .services { padding: 80px 0; }

        .services-head { margin-bottom: 48px; }

        .services-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .svc-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 36px;
            transition: border-color 0.15s, box-shadow 0.15s;
            position: relative;
            overflow: hidden;
        }

        .svc-card:hover {
            border-color: var(--border-hi);
            box-shadow: var(--shadow-md);
        }

        .svc-card::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: var(--svc-color, var(--blue));
            opacity: 0;
            transition: opacity 0.15s;
        }

        .svc-card:hover::after { opacity: 1; }

        .svc-icon {
            width: 36px; height: 36px;
            border-radius: 8px;
            background: var(--svc-bg, var(--blue-dim));
            color: var(--svc-color, var(--blue));
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px;
        }

        .svc-icon svg { width: 17px; height: 17px; }

        .svc-title {
            font-size: 17px;
            font-weight: 400;
            color: var(--text);
            margin-bottom: 8px;
            letter-spacing: -0.01em;
        }

        .svc-desc {
            font-size: 13px;
            font-weight: 300;
            color: var(--text-2);
            line-height: 1.65;
            margin-bottom: 24px;
        }

        .svc-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .svc-list li {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 13px;
            font-weight: 300;
            color: var(--text-2);
            line-height: 1.5;
        }

        .svc-check {
            width: 15px; height: 15px;
            border-radius: 50%;
            background: var(--green-dim);
            color: var(--green);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .svc-check svg { width: 8px; height: 8px; }

        /* ─── Features ─── */
        .features { padding: 80px 0; background: var(--bg-2); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }

        .features-head { margin-bottom: 48px; }

        .feat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2px;
            background: var(--border);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
        }

        .feat {
            background: var(--bg);
            padding: 28px 24px;
            transition: background 0.12s;
        }

        .feat:hover { background: #fafbff; }

        .feat-icon {
            width: 32px; height: 32px;
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 14px;
        }

        .feat-icon svg { width: 15px; height: 15px; }

        .feat-title {
            font-size: 14px;
            font-weight: 400;
            color: var(--text);
            margin-bottom: 6px;
            letter-spacing: -0.005em;
        }

        .feat-desc {
            font-size: 12.5px;
            font-weight: 300;
            color: var(--text-2);
            line-height: 1.6;
        }

        /* ─── Steps ─── */
        .steps { padding: 80px 0; }

        .steps-head { margin-bottom: 48px; }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
            position: relative;
        }

        .steps-grid::before {
            content: '';
            position: absolute;
            top: 18px;
            left: calc(16.7% + 18px);
            right: calc(16.7% + 18px);
            height: 1px;
            background: repeating-linear-gradient(90deg, var(--blue) 0, var(--blue) 6px, transparent 6px, transparent 14px);
            opacity: 0.3;
        }

        .step {
            padding: 0 24px;
            border-right: 1px solid var(--border);
        }

        .step:last-child { border-right: none; }

        .step-num {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--bg);
            border: 1px solid var(--border-hi);
            font-size: 13px;
            font-weight: 300;
            color: var(--blue);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px;
        }

        .step-title {
            font-size: 15px;
            font-weight: 400;
            color: var(--text);
            margin-bottom: 7px;
            letter-spacing: -0.01em;
        }

        .step-desc {
            font-size: 13px;
            font-weight: 300;
            color: var(--text-2);
            line-height: 1.65;
        }

        /* ─── CTA ─── */
        .cta-section {
            padding: 80px 0;
            background: var(--text);
        }

        .cta-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            flex-wrap: wrap;
        }

        .cta-text {}

        .cta-h2 {
            font-size: 28px;
            font-weight: 300;
            color: #fff;
            letter-spacing: -0.02em;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .cta-sub {
            font-size: 13px;
            font-weight: 300;
            color: rgba(255,255,255,0.55);
            line-height: 1.6;
            max-width: 400px;
        }

        .cta-actions { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }

        .cta-btn-primary {
            padding: 9px 22px;
            background: #fff;
            color: var(--text);
            font-size: 13px;
            font-weight: 400;
            border: none;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.12s, box-shadow 0.12s;
        }

        .cta-btn-primary:hover {
            background: #f0f4ff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.12);
        }

        .cta-btn-secondary {
            padding: 9px 20px;
            background: transparent;
            color: rgba(255,255,255,0.6);
            font-size: 13px;
            font-weight: 300;
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: border-color 0.12s, color 0.12s;
        }

        .cta-btn-secondary:hover {
            border-color: rgba(255,255,255,0.5);
            color: #fff;
        }

        /* ─── Footer ─── */
        .footer {
            padding: 32px 0;
            border-top: 1px solid var(--border);
            background: var(--bg);
        }

        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-brand-name {
            font-size: 13px;
            font-weight: 300;
            color: var(--text-2);
        }

        .footer-copy {
            font-size: 12px;
            font-weight: 300;
            color: var(--text-3);
        }

        .footer-links {
            display: flex;
            gap: 18px;
        }

        .footer-links a {
            font-size: 12px;
            font-weight: 300;
            color: var(--text-3);
            transition: color 0.12s;
        }

        .footer-links a:hover { color: var(--text-2); }

        /* ─── Animations ─── */
        @keyframes rise {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .hero-badge  { animation: rise 0.4s ease 0.05s both; }
        .hero-h1     { animation: rise 0.4s ease 0.12s both; }
        .hero-sub    { animation: rise 0.4s ease 0.19s both; }
        .hero-actions{ animation: rise 0.4s ease 0.26s both; }
        .hero-visual { animation: rise 0.5s ease 0.2s both; }

        .reveal {
            opacity: 0;
            transform: translateY(12px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .reveal.in { opacity: 1; transform: none; }
    </style>
</head>
<body>

<!-- Nav -->
<nav class="nav">
    <div class="wrap nav-inner">
        <a href="/" class="nav-brand">
            <div class="nav-logo">VX</div>
            <span class="nav-name">Velinex <span>Cloud</span></span>
        </a>
        <div class="nav-links">
            <a href="#services" class="nav-link">Services</a>
            <a href="#features" class="nav-link">Features</a>
            <a href="#how" class="nav-link">How it works</a>
            @auth
                <a href="{{ route('mail.domains.index') }}" class="nav-btn">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="nav-login">Sign in</a>
                <a href="{{ route('auth.register') }}" class="nav-btn">Get started</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="wrap">
        <div class="hero-inner">
            <div>
                <div class="hero-badge">
                    <span class="hero-badge-dot"></span>
                    Enterprise infrastructure
                </div>
                <h1 class="hero-h1">
                    Web hosting and<br>
                    business email that<br>
                    <strong>just works.</strong>
                </h1>
                <p class="hero-sub">
                    Production-grade hosting and self-hosted email built for teams that need reliability, deliverability, and full control over their infrastructure.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('auth.register') }}" class="btn-primary">
                        Start for free
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                    <a href="#services" class="btn-secondary">View services</a>
                </div>
            </div>

            <!-- Product mockup -->
            <div class="hero-visual">
                <div class="product-card">
                    <div class="pc-topbar">
                        <div class="pc-dots">
                            <div class="pc-dot" style="background:#f87171;"></div>
                            <div class="pc-dot" style="background:#fbbf24;"></div>
                            <div class="pc-dot" style="background:#34d399;"></div>
                        </div>
                        <span class="pc-title">cloud.velinexlabs.com — Mail Dashboard</span>
                    </div>
                    <div class="pc-body">
                        <div class="pc-stat-row">
                            <div class="pc-stat">
                                <div class="pc-stat-val">12</div>
                                <div class="pc-stat-lbl">Domains</div>
                            </div>
                            <div class="pc-stat">
                                <div class="pc-stat-val" style="color: var(--green);">9</div>
                                <div class="pc-stat-lbl">Verified</div>
                            </div>
                            <div class="pc-stat">
                                <div class="pc-stat-val">48</div>
                                <div class="pc-stat-lbl">Mailboxes</div>
                            </div>
                        </div>
                        <div class="pc-table-head">
                            <span class="pc-th">Domain</span>
                            <span class="pc-th">Status</span>
                            <span class="pc-th">Records</span>
                            <span class="pc-th">Mail</span>
                        </div>
                        @php
                            $rows = [
                                ['acme.co.ke', 'verified', '7', '12'],
                                ['runfast.io', 'verified', '7', '6'],
                                ['buildlabs.dev', 'pending', '3', '0'],
                                ['skyline.co.ke', 'verified', '7', '9'],
                            ];
                        @endphp
                        @foreach($rows as $row)
                        <div class="pc-row">
                            <span class="pc-domain">{{ $row[0] }}</span>
                            <span>
                                <span class="pc-badge {{ $row[1] === 'verified' ? 'pc-badge-green' : 'pc-badge-amber' }}">
                                    <span class="pc-badge-dot"></span>{{ $row[1] }}
                                </span>
                            </span>
                            <span class="pc-cell">{{ $row[2] }}</span>
                            <span class="pc-cell">{{ $row[3] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="pc-float">
                    <div class="pc-float-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <div>
                        <div class="pc-float-val">99.97<small style="font-size:11px;">%</small></div>
                        <div class="pc-float-lbl">Uptime SLA</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Metrics -->
<div class="metrics reveal">
    <div class="wrap">
        <div class="metrics-grid">
            <div class="metric">
                <div class="metric-val">99<em>.97%</em></div>
                <div class="metric-lbl">Uptime guarantee</div>
            </div>
            <div class="metric">
                <div class="metric-val">&lt;<em>5ms</em></div>
                <div class="metric-lbl">DNS propagation</div>
            </div>
            <div class="metric">
                <div class="metric-val">24<em>/7</em></div>
                <div class="metric-lbl">Expert support</div>
            </div>
            <div class="metric">
                <div class="metric-val"><em>∞</em></div>
                <div class="metric-lbl">Mailboxes per domain</div>
            </div>
        </div>
    </div>
</div>

<!-- Services -->
<section id="services" class="services">
    <div class="wrap">
        <div class="services-head reveal">
            <div class="section-label">What we offer</div>
            <h2 class="section-h2">Two services, one platform.</h2>
            <p class="section-sub">Everything your business needs to host and communicate — managed from a single dashboard.</p>
        </div>
        <div class="services-grid">
            <div class="svc-card reveal" style="--svc-color: var(--blue); --svc-bg: var(--blue-dim);">
                <div class="svc-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <div class="svc-title">Web Hosting</div>
                <div class="svc-desc">High-performance hosting powered by nginx. SSD storage, HTTP/3, automatic SSL, and global CDN edge caching for sub-50ms TTFB worldwide.</div>
                <ul class="svc-list">
                    <li><span class="svc-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span> Automatic SSL via Let's Encrypt</li>
                    <li><span class="svc-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span> PHP 8.3, Node.js 20, Python runtimes</li>
                    <li><span class="svc-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span> Daily backups with 30-day retention</li>
                    <li><span class="svc-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span> One-click staging environments</li>
                </ul>
            </div>
            <div class="svc-card reveal" style="--svc-color: #7c3aed; --svc-bg: rgba(124,58,237,0.07); transition-delay: 0.1s;">
                <div class="svc-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <div class="svc-title">Business Email</div>
                <div class="svc-desc">Self-hosted iRedMail with full DNS control. Your domain, your data — with SPF, DKIM, and DMARC configured automatically in under a minute.</div>
                <ul class="svc-list">
                    <li><span class="svc-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span> Auto-generated SPF, DKIM & DMARC</li>
                    <li><span class="svc-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span> Unlimited mailboxes per domain</li>
                    <li><span class="svc-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span> Webmail + IMAP/SMTP/POP3</li>
                    <li><span class="svc-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span> Spam filtering & virus scanning</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section id="features" class="features">
    <div class="wrap">
        <div class="features-head reveal">
            <div class="section-label">Platform</div>
            <h2 class="section-h2">Built for professionals.</h2>
            <p class="section-sub">The infrastructure features that matter to teams running real workloads in production.</p>
        </div>
        <div class="feat-grid reveal">
            <div class="feat">
                <div class="feat-icon" style="background:var(--blue-dim);color:var(--blue);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div class="feat-title">TLS everywhere</div>
                <div class="feat-desc">Automatic certificate provisioning and renewal. TLS 1.3 enforced across all services.</div>
            </div>
            <div class="feat">
                <div class="feat-icon" style="background:var(--green-dim);color:var(--green);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <div class="feat-title">Live monitoring</div>
                <div class="feat-desc">Real-time visibility into uptime, mail queues, DNS propagation, and delivery rates.</div>
            </div>
            <div class="feat">
                <div class="feat-icon" style="background:rgba(124,58,237,0.07);color:#7c3aed;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                </div>
                <div class="feat-title">DNS management</div>
                <div class="feat-desc">DNS records auto-generated on domain creation. One-click verification to confirm propagation.</div>
            </div>
            <div class="feat">
                <div class="feat-icon" style="background:rgba(245,158,11,0.08);color:#d97706;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <div class="feat-title">Instant provisioning</div>
                <div class="feat-desc">Domains, mailboxes, and DNS records go live in under 60 seconds from the dashboard.</div>
            </div>
            <div class="feat">
                <div class="feat-icon" style="background:rgba(239,68,68,0.07);color:#dc2626;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                </div>
                <div class="feat-title">REST API</div>
                <div class="feat-desc">Automate domain management, mailbox provisioning, and DNS configuration via API.</div>
            </div>
            <div class="feat">
                <div class="feat-icon" style="background:var(--blue-dim);color:var(--blue);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="feat-title">Multi-tenant</div>
                <div class="feat-desc">Manage domains and mailboxes across multiple clients and organizations from one place.</div>
            </div>
        </div>
    </div>
</section>

<!-- How it works -->
<section id="how" class="steps">
    <div class="wrap">
        <div class="steps-head reveal">
            <div class="section-label">Getting started</div>
            <h2 class="section-h2">Three steps to go live.</h2>
            <p class="section-sub">No servers to configure, no command line required.</p>
        </div>
        <div class="steps-grid reveal">
            <div class="step">
                <div class="step-num">01</div>
                <div class="step-title">Create an account</div>
                <div class="step-desc">Register in under a minute. Your company workspace is created automatically — no card required to start.</div>
            </div>
            <div class="step">
                <div class="step-num">02</div>
                <div class="step-title">Add your domain</div>
                <div class="step-desc">Enter your domain name. SPF, DKIM, DMARC, and MX records are generated immediately, ready to add at your registrar.</div>
            </div>
            <div class="step">
                <div class="step-num">03</div>
                <div class="step-title">Verify and launch</div>
                <div class="step-desc">Click Verify DNS — we check propagation automatically. Once confirmed, provision mailboxes and you're live.</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="wrap">
        <div class="cta-inner reveal">
            <div class="cta-text">
                <div class="cta-h2">Ready to take control<br>of your infrastructure?</div>
                <p class="cta-sub">Join businesses across East Africa running their web and email on Velinex Cloud.</p>
            </div>
            <div class="cta-actions">
                <a href="{{ route('auth.register') }}" class="cta-btn-primary">
                    Start for free
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:13px;height:13px;"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="{{ route('login') }}" class="cta-btn-secondary">Sign in →</a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="wrap footer-inner">
        <div class="footer-brand">
            <div class="nav-logo" style="width:22px;height:22px;font-size:9px;">VX</div>
            <span class="footer-brand-name">Velinex Cloud</span>
        </div>
        <span class="footer-copy">© {{ date('Y') }} Velinex Labs. All rights reserved.</span>
        <div class="footer-links">
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
            <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>
</footer>

<script>
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('in'); });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
</script>

</body>
</html>
