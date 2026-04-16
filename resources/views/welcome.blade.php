<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Velinex Cloud — Web & Email Hosting for Business</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta name="description" content="Enterprise-grade web hosting and business email. Built for reliability, security, and scale.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root {
            --bg:         #ffffff;
            --bg-2:       #f5f6f9;
            --bg-3:       #eef0f5;
            --text:       #0d1117;
            --text-2:     #4b5563;
            --text-3:     #9ca3af;
            --blue:       #1a6cf0;
            --blue-2:     #1558cc;
            --blue-dim:   rgba(26,108,240,0.07);
            --blue-mid:   rgba(26,108,240,0.15);
            --green:      #059669;
            --green-dim:  rgba(5,150,105,0.08);
            --border:     rgba(0,0,0,0.07);
            --border-hi:  rgba(0,0,0,0.12);
            --shadow-sm:  0 1px 4px rgba(0,0,0,0.06);
            --shadow-md:  0 4px 20px rgba(0,0,0,0.08);
            --shadow-lg:  0 12px 40px rgba(0,0,0,0.1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { -webkit-font-smoothing: antialiased; scroll-behavior: smooth; }
        a { text-decoration: none; color: inherit; }
        button { cursor: pointer; font-family: inherit; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Figtree', system-ui, sans-serif;
            font-weight: 400;
            font-size: 15px;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .wrap { max-width: 1100px; margin: 0 auto; padding: 0 32px; }

        /* ─── Nav ─── */
        .nav {
            position: sticky; top: 0; z-index: 100;
            background: rgba(255,255,255,0.93);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            height: 56px;
            display: flex; align-items: center;
        }
        .nav-inner { display: flex; align-items: center; justify-content: space-between; width: 100%; }
        .nav-brand { display: flex; align-items: center; }
        .nav-logo {
            width: 118px;
            height: auto;
            display: block;
        }
        .nav-name { font-size: 14px; font-weight: 400; color: var(--text); }
        .nav-name span { color: var(--text-3); font-weight: 300; }
        .nav-links { display: flex; align-items: center; gap: 2px; }
        .nav-link { padding: 5px 12px; font-size: 13px; font-weight: 300; color: var(--text-2); border-radius: 5px; transition: color .12s, background .12s; }
        .nav-link:hover { color: var(--text); background: var(--bg-2); }
        .nav-btn { padding: 6px 16px; font-size: 13px; font-weight: 400; background: var(--blue); color: #fff; border: none; border-radius: 5px; display: inline-block; transition: background .12s, box-shadow .12s; }
        .nav-btn:hover { background: var(--blue-2); box-shadow: 0 2px 10px rgba(26,108,240,0.3); }
        .nav-login { font-size: 13px; font-weight: 300; color: var(--text-2); padding: 6px 12px; transition: color .12s; }
        .nav-login:hover { color: var(--blue); }

        /* ─── HERO ─── */
        .hero {
            position: relative;
            padding: 88px 0 80px;
            overflow: hidden;
            background: linear-gradient(160deg, #ffffff 0%, #f4f7ff 60%, #eef2fb 100%);
        }

        /* Large geometric ring decoration — top right */
        .hero-ring-1 {
            position: absolute;
            top: -120px; right: -120px;
            width: 560px; height: 560px;
            border-radius: 50%;
            border: 1.5px solid rgba(26,108,240,0.10);
            pointer-events: none;
        }
        .hero-ring-2 {
            position: absolute;
            top: -60px; right: -60px;
            width: 380px; height: 380px;
            border-radius: 50%;
            border: 1px solid rgba(26,108,240,0.07);
            pointer-events: none;
        }
        .hero-ring-3 {
            position: absolute;
            top: 20px; right: 20px;
            width: 200px; height: 200px;
            border-radius: 50%;
            border: 1px solid rgba(26,108,240,0.05);
            pointer-events: none;
        }

        /* Diagonal accent bar */
        .hero-diagonal {
            position: absolute;
            bottom: -40px; left: -60px;
            width: 500px; height: 220px;
            background: linear-gradient(135deg, rgba(26,108,240,0.04) 0%, transparent 60%);
            transform: skewY(-8deg);
            pointer-events: none;
        }

        .hero-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 56px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 3px 11px 3px 8px;
            background: var(--blue-dim);
            border: 1px solid var(--blue-mid);
            border-radius: 99px;
            font-size: 11px; font-weight: 400; color: var(--blue);
            margin-bottom: 20px; letter-spacing: 0.02em;
        }
        .hero-badge-dot { width: 5px; height: 5px; background: var(--blue); border-radius: 50%; animation: pulse 2.5s ease-in-out infinite; }

        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.3} }

        .hero-h1 {
            font-size: 42px; font-weight: 400;
            line-height: 1.13; letter-spacing: -0.025em;
            color: var(--text); margin-bottom: 18px;
        }
        .hero-h1 strong { font-weight: 500; color: var(--blue); }

        .hero-sub {
            font-size: 15px; font-weight: 300; color: var(--text-2);
            line-height: 1.68; max-width: 400px; margin-bottom: 34px;
        }

        .hero-actions { display: flex; align-items: center; gap: 10px; margin-bottom: 40px; }

        .btn-primary {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 10px 22px; background: var(--blue); color: #fff;
            font-size: 13px; font-weight: 400; border: none; border-radius: 6px;
            box-shadow: 0 2px 10px rgba(26,108,240,0.25);
            transition: background .13s, box-shadow .13s, transform .13s;
        }
        .btn-primary:hover { background: var(--blue-2); box-shadow: 0 4px 18px rgba(26,108,240,0.35); transform: translateY(-1px); }
        .btn-primary svg { width: 13px; height: 13px; }

        .btn-secondary {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 10px 20px; background: transparent; color: var(--text-2);
            font-size: 13px; font-weight: 300;
            border: 1px solid var(--border-hi); border-radius: 6px;
            transition: border-color .13s, color .13s, background .13s;
        }
        .btn-secondary:hover { border-color: var(--blue); color: var(--blue); background: var(--blue-dim); }

        /* Hero social proof strip */
        .hero-proof {
            display: flex; align-items: center; gap: 16px;
            padding-top: 22px;
            border-top: 1px solid var(--border);
        }
        .hero-proof-avatars { display: flex; }
        .hero-proof-avatar {
            width: 26px; height: 26px; border-radius: 50%;
            border: 2px solid #fff;
            margin-left: -7px;
            font-size: 9px; font-weight: 400; color: #fff;
            display: flex; align-items: center; justify-content: center;
            background: var(--blue);
        }
        .hero-proof-avatar:first-child { margin-left: 0; }
        .hero-proof-avatar:nth-child(2) { background: #7c3aed; }
        .hero-proof-avatar:nth-child(3) { background: #059669; }
        .hero-proof-avatar:nth-child(4) { background: #d97706; }

        .hero-proof-text { font-size: 12px; font-weight: 300; color: var(--text-3); }
        .hero-proof-text strong { font-weight: 400; color: var(--text-2); }

        /* ─── Product mockup — perspective tilt ─── */
        .hero-visual {
            position: relative;
            perspective: 1400px;
            padding: 24px 30px 30px 0;
        }

        .product-card {
            background: #fff;
            border: 1px solid var(--border-hi);
            border-radius: 12px;
            box-shadow: 0 24px 60px rgba(0,0,0,0.11), 0 4px 16px rgba(0,0,0,0.06);
            overflow: hidden;
            position: relative;
            transform: perspective(1400px) rotateX(6deg) rotateY(-14deg) rotateZ(1deg);
            transform-origin: center center;
            transition: transform .6s ease;
        }
        .hero-visual:hover .product-card {
            transform: perspective(1400px) rotateX(3deg) rotateY(-7deg) rotateZ(0.5deg);
        }

        .pc-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 10px 14px;
            border-bottom: 1px solid var(--border);
            background: var(--bg-2);
        }
        .pc-header-left { display: flex; align-items: center; gap: 7px; }
        .pc-header-dot { width: 7px; height: 7px; border-radius: 50%; }
        .pc-header-title { font-size: 11px; font-weight: 400; color: var(--text-2); }
        .pc-header-url {
            font-size: 9.5px; font-weight: 300; color: var(--text-3);
            font-family: 'Courier New', monospace; letter-spacing: .02em;
        }

        .pc-body { padding: 14px; }

        .pc-stat-row {
            display: grid; grid-template-columns: repeat(3,1fr); gap: 8px; margin-bottom: 14px;
        }
        .pc-stat {
            background: var(--bg-2); border: 1px solid var(--border);
            border-radius: 8px; padding: 10px 12px;
        }
        .pc-stat-val { font-size: 20px; font-weight: 400; color: var(--text); line-height: 1; margin-bottom: 3px; }
        .pc-stat-lbl { font-size: 9.5px; font-weight: 300; color: var(--text-3); text-transform: uppercase; letter-spacing: .05em; }

        .pc-table { width: 100%; border-collapse: collapse; }
        .pc-th { font-size: 9px; font-weight: 300; color: var(--text-3); text-transform: uppercase; letter-spacing: .12em; padding: 5px 8px; text-align: left; border-bottom: 1px solid var(--border); }
        .pc-tr { border-bottom: 1px solid var(--border); transition: background .1s; }
        .pc-tr:last-child { border-bottom: none; }
        .pc-tr:hover { background: var(--bg-2); }
        .pc-td { padding: 8px 8px; font-size: 11.5px; font-weight: 300; color: var(--text-2); vertical-align: middle; }
        .pc-domain { font-family: 'Courier New', monospace; font-size: 11px; color: var(--text); font-weight: 400; }
        .pc-badge { display: inline-flex; align-items: center; gap: 3px; padding: 2px 7px; border-radius: 99px; font-size: 9.5px; font-weight: 400; }
        .pc-badge-green { background: var(--green-dim); color: var(--green); }
        .pc-badge-amber { background: rgba(245,158,11,.08); color: #d97706; }
        .pc-badge-dot { width: 4px; height: 4px; border-radius: 50%; background: currentColor; }

        /* Floating chips — sit outside the tilted card */
        .pc-float-1 {
            position: absolute; bottom: 8px; right: -8px;
            background: #fff; border: 1px solid var(--border-hi);
            border-radius: 10px; padding: 10px 14px;
            box-shadow: var(--shadow-md);
            display: flex; align-items: center; gap: 10px;
            white-space: nowrap; z-index: 2;
        }
        .pc-float-2 {
            position: absolute; top: 14px; left: -8px;
            background: #fff; border: 1px solid var(--border-hi);
            border-radius: 10px; padding: 10px 14px;
            box-shadow: var(--shadow-md);
            display: flex; align-items: center; gap: 8px;
            white-space: nowrap; z-index: 2;
        }
        .float-icon {
            width: 28px; height: 28px; border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .float-icon svg { width: 13px; height: 13px; }
        .float-val { font-size: 14px; font-weight: 400; color: var(--text); line-height: 1; }
        .float-lbl { font-size: 9.5px; font-weight: 300; color: var(--text-3); text-transform: uppercase; letter-spacing: .06em; }

        /* ─── Metrics ─── */
        .metrics {
            padding: 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            background: var(--bg);
            position: relative;
            overflow: hidden;
        }
        .metrics-grid { display: grid; grid-template-columns: repeat(4,1fr); }
        .metric {
            text-align: center; padding: 30px 20px;
            border-right: 1px solid var(--border);
            position: relative;
        }
        .metric:last-child { border-right: none; }
        .metric::before {
            content: ''; position: absolute;
            top: 0; left: 50%; transform: translateX(-50%);
            width: 40px; height: 2px;
            background: var(--blue); opacity: 0;
            transition: opacity .2s;
        }
        .metric:hover::before { opacity: 1; }
        .metric-val { font-size: 30px; font-weight: 300; color: var(--text); letter-spacing: -0.03em; line-height: 1; margin-bottom: 5px; }
        .metric-val em { font-style: normal; color: var(--blue); }
        .metric-lbl { font-size: 11.5px; font-weight: 300; color: var(--text-3); }

        /* ─── Section shared ─── */
        section { position: relative; }
        .section-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 11px; font-weight: 400; color: var(--blue);
            letter-spacing: .1em; text-transform: uppercase; margin-bottom: 10px;
        }
        .section-eyebrow::before { content: ''; width: 16px; height: 1.5px; background: var(--blue); border-radius: 1px; }
        .section-h2 { font-size: 30px; font-weight: 400; letter-spacing: -0.02em; color: var(--text); line-height: 1.18; margin-bottom: 10px; }
        .section-sub { font-size: 14px; font-weight: 300; color: var(--text-2); line-height: 1.68; max-width: 500px; }

        /* ─── SERVICES ─── */
        .services { padding: 88px 0; position: relative; overflow: hidden; }

        /* Angled background shape behind services */
        .services-shape {
            position: absolute;
            top: 0; right: -100px;
            width: 500px; height: 100%;
            background: linear-gradient(135deg, transparent 40%, rgba(26,108,240,0.025) 100%);
            transform: skewX(-8deg);
            pointer-events: none;
        }

        .services-head { margin-bottom: 48px; }
        .services-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; position: relative; z-index: 1; }

        .svc-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 36px;
            position: relative;
            overflow: hidden;
            transition: border-color .18s, box-shadow .18s, transform .18s;
        }
        .svc-card:hover { border-color: var(--border-hi); box-shadow: var(--shadow-md); transform: translateY(-2px); }

        /* Top accent line */
        .svc-card::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 2px;
            background: var(--svc-accent, var(--blue));
            transform: scaleX(0); transform-origin: left;
            transition: transform .28s ease;
        }
        .svc-card:hover::before { transform: scaleX(1); }

        /* Large background icon */
        .svc-bg-icon {
            position: absolute;
            bottom: -20px; right: -20px;
            width: 140px; height: 140px;
            opacity: 0.04;
            color: var(--svc-accent, var(--blue));
            pointer-events: none;
        }
        .svc-bg-icon svg { width: 100%; height: 100%; }

        /* Diagonal stripe accent */
        .svc-stripe {
            position: absolute;
            top: 0; right: 0;
            width: 80px; height: 80px;
            overflow: hidden;
            pointer-events: none;
        }
        .svc-stripe::before {
            content: ''; position: absolute;
            top: -30px; right: -30px;
            width: 80px; height: 80px;
            background: var(--svc-accent, var(--blue));
            opacity: 0.05;
            transform: rotate(45deg);
        }

        .svc-icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px; position: relative; z-index: 1;
        }
        .svc-icon svg { width: 18px; height: 18px; }

        .svc-title { font-size: 18px; font-weight: 400; color: var(--text); margin-bottom: 8px; letter-spacing: -0.01em; position: relative; z-index: 1; }
        .svc-desc { font-size: 13px; font-weight: 300; color: var(--text-2); line-height: 1.65; margin-bottom: 24px; position: relative; z-index: 1; }

        .svc-list { list-style: none; display: flex; flex-direction: column; gap: 8px; position: relative; z-index: 1; }
        .svc-list li { display: flex; align-items: flex-start; gap: 8px; font-size: 13px; font-weight: 300; color: var(--text-2); line-height: 1.5; }
        .svc-check { width: 15px; height: 15px; border-radius: 50%; background: var(--green-dim); color: var(--green); display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
        .svc-check svg { width: 8px; height: 8px; }

        /* ─── FEATURES — asymmetric layout ─── */
        .features {
            padding: 88px 0;
            background: var(--bg-2);
            position: relative;
            overflow: hidden;
        }

        /* Angled top edge */
        .features::before {
            content: ''; position: absolute;
            top: -32px; left: 0; right: 0; height: 64px;
            background: var(--bg-2);
            clip-path: polygon(0 100%, 100% 0, 100% 100%);
        }

        /* Angled bottom edge */
        .features::after {
            content: ''; position: absolute;
            bottom: -32px; left: 0; right: 0; height: 64px;
            background: var(--bg-2);
            clip-path: polygon(0 0, 100% 100%, 0 100%);
        }

        .features-head { margin-bottom: 48px; position: relative; z-index: 1; }

        /* Asymmetric grid: big card + 5 small */
        .feat-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            grid-template-rows: auto auto;
            gap: 14px;
            position: relative; z-index: 1;
        }

        .feat-hero {
            grid-row: 1 / 3;
            background: var(--blue);
            border-radius: 12px;
            padding: 36px;
            position: relative;
            overflow: hidden;
            color: #fff;
        }

        /* Rings inside the hero feat card */
        .feat-hero::before {
            content: ''; position: absolute;
            bottom: -60px; right: -60px;
            width: 240px; height: 240px;
            border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,0.12);
        }
        .feat-hero::after {
            content: ''; position: absolute;
            bottom: -20px; right: -20px;
            width: 140px; height: 140px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .feat-hero-icon {
            width: 44px; height: 44px; border-radius: 10px;
            background: rgba(255,255,255,0.14);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 80px;
        }
        .feat-hero-icon svg { width: 20px; height: 20px; color: #fff; }

        .feat-hero-title { font-size: 22px; font-weight: 400; color: #fff; margin-bottom: 10px; letter-spacing: -0.02em; position: relative; z-index: 1; }
        .feat-hero-desc { font-size: 13px; font-weight: 300; color: rgba(255,255,255,0.72); line-height: 1.65; position: relative; z-index: 1; }

        .feat {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 22px;
            transition: border-color .15s, box-shadow .15s;
        }
        .feat:hover { border-color: var(--border-hi); box-shadow: var(--shadow-sm); }

        .feat-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
        .feat-icon svg { width: 15px; height: 15px; }
        .feat-title { font-size: 13.5px; font-weight: 400; color: var(--text); margin-bottom: 5px; }
        .feat-desc { font-size: 12.5px; font-weight: 300; color: var(--text-2); line-height: 1.6; }

        /* ─── STEPS ─── */
        .steps {
            padding: 100px 0 88px;
            position: relative;
            overflow: hidden;
        }

        /* Faint horizontal ruled lines across section */
        .steps-ruled {
            position: absolute;
            inset: 0; pointer-events: none;
            background-image: repeating-linear-gradient(
                0deg,
                rgba(0,0,0,0.025) 0px, rgba(0,0,0,0.025) 1px,
                transparent 1px, transparent 56px
            );
            mask-image: linear-gradient(90deg, transparent 0%, black 15%, black 85%, transparent 100%);
        }

        .steps-head { margin-bottom: 56px; position: relative; z-index: 1; }

        .steps-grid {
            display: grid; grid-template-columns: repeat(3,1fr);
            gap: 0; position: relative; z-index: 1;
        }

        /* SVG connector line drawn between steps */
        .steps-connector {
            position: absolute;
            top: 18px; left: 0; right: 0;
            height: 2px; pointer-events: none;
            z-index: 0;
        }

        .step {
            padding: 0 32px 0 24px;
            border-right: 1px solid var(--border);
            position: relative;
        }
        .step:last-child { border-right: none; }

        .step-num {
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--bg); border: 1.5px solid var(--blue);
            font-size: 12px; font-weight: 400; color: var(--blue);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 22px; position: relative; z-index: 1;
            box-shadow: 0 0 0 4px rgba(26,108,240,0.08);
        }

        .step-title { font-size: 15px; font-weight: 400; color: var(--text); margin-bottom: 8px; letter-spacing: -0.01em; }
        .step-desc { font-size: 13px; font-weight: 300; color: var(--text-2); line-height: 1.65; }

        /* ─── TRUST STRIP ─── */
        .trust {
            padding: 48px 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            background: var(--bg-2);
        }
        .trust-inner { display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 10px 40px; }
        .trust-label { font-size: 11px; font-weight: 300; color: var(--text-3); letter-spacing: .08em; text-transform: uppercase; margin-right: 12px; }
        .trust-logo {
            font-size: 14px; font-weight: 400; color: var(--text-3);
            letter-spacing: .04em; transition: color .15s;
            display: flex; align-items: center; gap: 6px;
        }
        .trust-logo:hover { color: var(--text-2); }
        .trust-dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; opacity: .4; }

        /* ─── CTA ─── */
        .cta-section {
            padding: 100px 0;
            background: var(--text);
            position: relative;
            overflow: hidden;
            clip-path: polygon(0 32px, 100% 0, 100% calc(100% - 32px), 0 100%);
            margin: 40px 0;
        }

        /* Geometric line grid in CTA */
        .cta-geo {
            position: absolute; inset: 0; pointer-events: none;
            overflow: hidden;
        }
        .cta-geo svg { position: absolute; top: 0; right: 0; width: 420px; height: 100%; opacity: 0.06; }

        /* Large ring bottom-left */
        .cta-ring {
            position: absolute; bottom: -80px; left: -80px;
            width: 320px; height: 320px; border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,0.08);
            pointer-events: none;
        }
        .cta-ring-2 {
            position: absolute; bottom: -30px; left: -30px;
            width: 180px; height: 180px; border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.05);
            pointer-events: none;
        }

        .cta-inner {
            display: grid; grid-template-columns: 1fr auto;
            gap: 48px; align-items: center;
            position: relative; z-index: 1;
        }
        .cta-h2 { font-size: 30px; font-weight: 400; color: #fff; letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 10px; }
        .cta-sub { font-size: 13px; font-weight: 300; color: rgba(255,255,255,0.5); line-height: 1.65; max-width: 420px; }
        .cta-actions { display: flex; flex-direction: column; gap: 8px; flex-shrink: 0; }
        .cta-btn-primary {
            padding: 10px 24px; background: #fff; color: var(--text);
            font-size: 13px; font-weight: 400; border: none; border-radius: 6px;
            display: inline-flex; align-items: center; gap: 6px;
            transition: background .13s, box-shadow .13s;
            white-space: nowrap;
        }
        .cta-btn-primary:hover { background: #eef2ff; box-shadow: 0 2px 12px rgba(0,0,0,.14); }
        .cta-btn-secondary {
            padding: 10px 20px; background: transparent;
            color: rgba(255,255,255,0.55); font-size: 13px; font-weight: 300;
            border: 1px solid rgba(255,255,255,0.14); border-radius: 6px;
            display: inline-flex; align-items: center; justify-content: center;
            gap: 6px; transition: border-color .13s, color .13s;
            white-space: nowrap;
        }
        .cta-btn-secondary:hover { border-color: rgba(255,255,255,0.4); color: #fff; }

        /* ─── Footer ─── */
        .footer { padding: 32px 0; border-top: 1px solid var(--border); }
        .footer-inner { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; }
        .footer-brand { display: flex; align-items: center; }
        .footer-name { font-size: 13px; font-weight: 300; color: var(--text-2); }
        .footer-copy { font-size: 12px; font-weight: 300; color: var(--text-3); }
        .footer-links { display: flex; gap: 20px; }
        .footer-links a { font-size: 12px; font-weight: 300; color: var(--text-3); transition: color .12s; }
        .footer-links a:hover { color: var(--text-2); }

        /* ─── Reveal ─── */
        @keyframes rise { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:none} }
        .hero-badge  { animation: rise .4s ease .05s both; }
        .hero-h1     { animation: rise .4s ease .12s both; }
        .hero-sub    { animation: rise .4s ease .2s  both; }
        .hero-actions{ animation: rise .4s ease .27s both; }
        .hero-proof  { animation: rise .4s ease .34s both; }
        .hero-visual { animation: rise .5s ease .22s both; }
        .reveal { opacity:0; transform:translateY(14px); transition: opacity .5s ease, transform .5s ease; }
        .reveal.in  { opacity:1; transform:none; }
        .reveal-d1 { transition-delay:.08s; }
        .reveal-d2 { transition-delay:.16s; }
        .reveal-d3 { transition-delay:.24s; }
    </style>
</head>
<body>

<!-- Nav -->
<nav class="nav">
    <div class="wrap nav-inner">
        <a href="/" class="nav-brand">
            <img src="{{ asset('logo.svg') }}" alt="Velinex Cloud" class="nav-logo">
        </a>
        <div class="nav-links">
            <a href="#services" class="nav-link">Services</a>
            <a href="#features" class="nav-link">Features</a>
            <a href="#how" class="nav-link">How it works</a>
            @auth
                <a href="{{ route('mail.dashboard') }}" class="nav-btn">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="nav-login">Sign in</a>
                <a href="{{ route('auth.register') }}" class="nav-btn">Get started</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="hero">
    <div class="hero-ring-1"></div>
    <div class="hero-ring-2"></div>
    <div class="hero-ring-3"></div>
    <div class="hero-diagonal"></div>

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
                <div class="hero-proof">
                    <div class="hero-proof-avatars">
                        <div class="hero-proof-avatar">AK</div>
                        <div class="hero-proof-avatar">SM</div>
                        <div class="hero-proof-avatar">JN</div>
                        <div class="hero-proof-avatar">RO</div>
                    </div>
                    <div class="hero-proof-text">
                        Trusted by <strong>40+ businesses</strong> across East Africa
                    </div>
                </div>
            </div>

            <!-- Product mockup — perspective tilt -->
            <div class="hero-visual">

                <div class="pc-float-2">
                    <div class="float-icon" style="background:rgba(5,150,105,0.08);color:#059669;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <div>
                        <div class="float-val">99.97<small style="font-size:10px;font-weight:300;">%</small></div>
                        <div class="float-lbl">Uptime SLA</div>
                    </div>
                </div>

                <div class="product-card">
                    <div class="pc-header">
                        <div class="pc-header-left">
                            <div class="pc-header-dot" style="background:var(--blue);"></div>
                            <span class="pc-header-title">Mail Domains</span>
                        </div>
                        <div class="pc-header-url">cloud.velinexlabs.com</div>
                    </div>
                    <div class="pc-body">
                        <div class="pc-stat-row">
                            <div class="pc-stat">
                                <div class="pc-stat-val">12</div>
                                <div class="pc-stat-lbl">Domains</div>
                            </div>
                            <div class="pc-stat">
                                <div class="pc-stat-val" style="color:var(--green);">9</div>
                                <div class="pc-stat-lbl">Verified</div>
                            </div>
                            <div class="pc-stat">
                                <div class="pc-stat-val">48</div>
                                <div class="pc-stat-lbl">Mailboxes</div>
                            </div>
                        </div>
                        <table class="pc-table">
                            <thead>
                                <tr>
                                    <th class="pc-th">Domain</th>
                                    <th class="pc-th">Status</th>
                                    <th class="pc-th">DNS</th>
                                    <th class="pc-th">Mail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $rows = [['acme.co.ke','verified','7','12'],['runfast.io','verified','7','6'],['buildlabs.dev','pending','3','0'],['skyline.co.ke','verified','7','9']]; @endphp
                                @foreach($rows as $r)
                                <tr class="pc-tr">
                                    <td class="pc-td"><span class="pc-domain">{{ $r[0] }}</span></td>
                                    <td class="pc-td"><span class="pc-badge {{ $r[1]==='verified'?'pc-badge-green':'pc-badge-amber' }}"><span class="pc-badge-dot"></span>{{ $r[1] }}</span></td>
                                    <td class="pc-td">{{ $r[2] }}</td>
                                    <td class="pc-td">{{ $r[3] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="pc-float-1">
                    <div class="float-icon" style="background:var(--blue-dim);color:var(--blue);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <div>
                        <div class="float-val">48 active</div>
                        <div class="float-lbl">Mailboxes</div>
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
    <div class="services-shape"></div>
    <div class="wrap">
        <div class="services-head reveal">
            <div class="section-eyebrow">What we offer</div>
            <h2 class="section-h2">Two services, one platform.</h2>
            <p class="section-sub">Everything your business needs to host and communicate — managed from a single dashboard.</p>
        </div>
        <div class="services-grid">
            <div class="svc-card reveal" style="--svc-accent: var(--blue);">
                <div class="svc-stripe"></div>
                <div class="svc-bg-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <div class="svc-icon" style="background:var(--blue-dim);color:var(--blue);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <div class="svc-title">Web Hosting</div>
                <div class="svc-desc">High-performance hosting powered by nginx. SSD storage, HTTP/3, automatic SSL, and global CDN edge caching for sub-50ms TTFB worldwide.</div>
                <ul class="svc-list">
                    <li><span class="svc-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>Automatic SSL via Let's Encrypt</li>
                    <li><span class="svc-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>PHP 8.3, Node.js 20, Python runtimes</li>
                    <li><span class="svc-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>Daily backups, 30-day retention</li>
                    <li><span class="svc-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>One-click staging environments</li>
                </ul>
            </div>
            <div class="svc-card reveal reveal-d1" style="--svc-accent: #7c3aed;">
                <div class="svc-stripe" style="--svc-accent:#7c3aed;"></div>
                <div class="svc-bg-icon" style="color:#7c3aed;">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/></svg>
                </div>
                <div class="svc-icon" style="background:rgba(124,58,237,0.07);color:#7c3aed;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <div class="svc-title">Business Email</div>
                <div class="svc-desc">Self-hosted iRedMail with full DNS control. Your domain, your data — SPF, DKIM, and DMARC configured automatically in under a minute.</div>
                <ul class="svc-list">
                    <li><span class="svc-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>Auto-generated SPF, DKIM & DMARC</li>
                    <li><span class="svc-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>Unlimited mailboxes per domain</li>
                    <li><span class="svc-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>Webmail + IMAP/SMTP/POP3</li>
                    <li><span class="svc-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>Spam filtering & virus scanning</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Features — asymmetric -->
<section id="features" class="features">
    <div class="wrap">
        <div class="features-head reveal">
            <div class="section-eyebrow">Platform</div>
            <h2 class="section-h2">Built for professionals.</h2>
            <p class="section-sub">The infrastructure capabilities that matter to teams running real workloads.</p>
        </div>
        <div class="feat-grid reveal">
            <!-- Large hero feature -->
            <div class="feat-hero">
                <div class="feat-hero-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div class="feat-hero-title">Zero-compromise security</div>
                <div class="feat-hero-desc">TLS 1.3 everywhere, hardened server configurations, automated vulnerability scanning, and fail2ban protection across all entry points. Built to withstand production threats.</div>
            </div>
            <!-- 5 smaller features -->
            <div class="feat">
                <div class="feat-icon" style="background:var(--green-dim);color:var(--green);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <div class="feat-title">Live monitoring</div>
                <div class="feat-desc">Real-time visibility into uptime, mail queues, and DNS propagation.</div>
            </div>
            <div class="feat">
                <div class="feat-icon" style="background:rgba(124,58,237,0.07);color:#7c3aed;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                </div>
                <div class="feat-title">DNS management</div>
                <div class="feat-desc">Records auto-generated on creation. One-click verification.</div>
            </div>
            <div class="feat">
                <div class="feat-icon" style="background:rgba(245,158,11,0.08);color:#d97706;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div class="feat-title">99.97% uptime SLA</div>
                <div class="feat-desc">Guaranteed availability backed by redundant infrastructure.</div>
            </div>
            <div class="feat">
                <div class="feat-icon" style="background:rgba(239,68,68,0.07);color:#dc2626;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                </div>
                <div class="feat-title">REST API</div>
                <div class="feat-desc">Automate domain, mailbox, and DNS management via API.</div>
            </div>
            <div class="feat">
                <div class="feat-icon" style="background:var(--blue-dim);color:var(--blue);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="feat-title">Multi-tenant</div>
                <div class="feat-desc">Manage multiple client organizations from one dashboard.</div>
            </div>
        </div>
    </div>
</section>

<!-- Trust strip -->
<div class="trust reveal">
    <div class="wrap trust-inner">
        <span class="trust-label">Powering businesses at</span>
        <span class="trust-logo"><span class="trust-dot"></span>Acme Digital</span>
        <span class="trust-logo"><span class="trust-dot"></span>RunFast Agency</span>
        <span class="trust-logo"><span class="trust-dot"></span>BuildLabs</span>
        <span class="trust-logo"><span class="trust-dot"></span>Skyline Group</span>
        <span class="trust-logo"><span class="trust-dot"></span>NovaTech</span>
    </div>
</div>

<!-- How it works -->
<section id="how" class="steps">
    <div class="steps-ruled"></div>
    <div class="wrap">
        <div class="steps-head reveal">
            <div class="section-eyebrow">Getting started</div>
            <h2 class="section-h2">Three steps to go live.</h2>
            <p class="section-sub">No servers to configure. No command line required.</p>
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
                <div class="step-desc">Enter your domain. SPF, DKIM, DMARC, and MX records are generated immediately, ready to add at your registrar.</div>
            </div>
            <div class="step">
                <div class="step-num">03</div>
                <div class="step-title">Verify and launch</div>
                <div class="step-desc">Click Verify DNS — propagation is checked automatically. Once confirmed, provision mailboxes and you're live.</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="cta-geo">
        <svg viewBox="0 0 420 400" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMid slice">
            <line x1="0" y1="0" x2="420" y2="400" stroke="white" stroke-width="1"/>
            <line x1="60" y1="0" x2="420" y2="340" stroke="white" stroke-width="1"/>
            <line x1="120" y1="0" x2="420" y2="280" stroke="white" stroke-width="1"/>
            <line x1="180" y1="0" x2="420" y2="220" stroke="white" stroke-width="1"/>
            <line x1="240" y1="0" x2="420" y2="160" stroke="white" stroke-width="1"/>
            <line x1="300" y1="0" x2="420" y2="100" stroke="white" stroke-width="1"/>
            <line x1="360" y1="0" x2="420" y2="40"  stroke="white" stroke-width="1"/>
            <circle cx="380" cy="80"  r="60"  stroke="white" stroke-width="1" fill="none"/>
            <circle cx="380" cy="80"  r="110" stroke="white" stroke-width="1" fill="none"/>
        </svg>
    </div>
    <div class="cta-ring"></div>
    <div class="cta-ring-2"></div>
    <div class="wrap">
        <div class="cta-inner reveal">
            <div class="cta-text">
                <div class="cta-h2">Ready to take control<br>of your infrastructure?</div>
                <p class="cta-sub">Join businesses across East Africa running their web and email on Velinex Cloud. Get started free — no credit card needed.</p>
            </div>
            <div class="cta-actions">
                <a href="{{ route('auth.register') }}" class="cta-btn-primary">
                    Start for free
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:13px;height:13px;"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="{{ route('login') }}" class="cta-btn-secondary">Sign in to dashboard →</a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="wrap footer-inner">
        <div class="footer-brand">
            <img src="{{ asset('logo.svg') }}" alt="Velinex Cloud" class="nav-logo" style="width:102px;">
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
    }, { threshold: 0.08 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
</script>
</body>
</html>
