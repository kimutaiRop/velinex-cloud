<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — Velinex Cloud</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500|jetbrains-mono:400,500&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>
<div class="shell">

    {{-- ─── Sidebar ─── --}}
    <aside class="sidebar">
        <div class="flex items-center bg-transparent border-0" style="padding: 14px 16px 10px; margin: 8px 8px 0;">
            <img src="{{ asset('logo.svg') }}" alt="Velinex Cloud" style="display:block; width:176px; height:auto;">
        </div>

        <nav class="sidebar-nav">
            <span class="nav-section">Mail</span>

            <a href="{{ route('mail.dashboard') }}"
               class="nav-item {{ request()->routeIs('mail.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('mail.domains.manage') }}"
               class="nav-item {{ request()->routeIs('mail.domains.manage') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18"/><path d="M3 12h18"/><path d="M3 18h18"/>
                </svg>
                Manage Domains
            </a>

            <a href="{{ route('mail.domains.create') }}"
               class="nav-item {{ request()->routeIs('mail.domains.create') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="9"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/>
                </svg>
                Add Domain
            </a>

            @if(request()->routeIs('mail.domains.show', 'mail.domains.mailboxes'))
                <a href="{{ url()->current() }}"
                   class="nav-item active" style="padding-left:28px; font-size:12px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9"/><path d="M12 8v4l3 3"/>
                    </svg>
                    DNS Setup
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="user-row">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-meta">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-email">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <form method="post" action="{{ route('auth.logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Sign out
                </button>
            </form>
        </div>
    </aside>

    {{-- ─── Main ─── --}}
    <div class="main">
        <header class="topbar">
            <div class="topbar-left">
                <span class="topbar-crumb">@yield('crumb', 'Velinex / Cloud')</span>
                <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
            </div>
            <div class="topbar-actions">
                @yield('topbar-actions')
            </div>
        </header>

        <div class="content">
            @if(session('status'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

</div>
@stack('scripts')
</body>
</html>
