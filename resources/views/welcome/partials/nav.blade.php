<!-- Nav -->
<nav class="nav">
    <div class="wrap nav-inner">
        <a href="/" class="nav-brand">
            <img src="{{ asset('logo.svg') }}" alt="Velinex Cloud" class="nav-logo">
        </a>
        <div class="nav-links nav-links-desktop">
            <a href="#services" class="nav-link">Services</a>
            <a href="#features" class="nav-link">Features</a>
            <a href="#how" class="nav-link">How it works</a>
            <a href="#pricing" class="nav-link">Pricing</a>
            @auth
                <a href="{{ route('mail.dashboard') }}" class="nav-btn">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="nav-login">Sign in</a>
                <a href="{{ route('auth.register') }}" class="nav-btn">Get started</a>
            @endauth
        </div>
        <button type="button" class="nav-menu-btn" id="nav-menu-open" aria-label="Open menu" aria-expanded="false" aria-controls="nav-drawer">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></svg>
        </button>
    </div>
</nav>
<div class="nav-drawer-backdrop" id="nav-drawer-backdrop" aria-hidden="true"></div>
<aside class="nav-drawer-panel" id="nav-drawer" role="dialog" aria-modal="true" aria-label="Site menu" aria-hidden="true">
    <div class="nav-drawer-head">Menu</div>
    <a href="#services" class="nav-link">Services</a>
    <a href="#features" class="nav-link">Features</a>
    <a href="#how" class="nav-link">How it works</a>
    <a href="#pricing" class="nav-link">Pricing</a>
    @auth
        <a href="{{ route('mail.dashboard') }}" class="nav-btn">Dashboard</a>
    @else
        <a href="{{ route('login') }}" class="nav-login">Sign in</a>
        <a href="{{ route('auth.register') }}" class="nav-btn">Get started</a>
    @endauth
</aside>
