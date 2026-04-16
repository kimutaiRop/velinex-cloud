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
<body class="bg-background font-sans text-sm text-foreground antialiased">
    <div class="grid min-h-screen grid-cols-1 md:grid-cols-[var(--spacing-sidebar)_minmax(0,1fr)]">

        <aside class="sticky top-0 flex h-screen flex-col overflow-hidden border-border bg-surface md:border-r">
            <div class="mx-2 mt-2 border-0 bg-transparent px-4 pb-2.5 pt-3.5">
                <img src="{{ asset('logo.svg') }}" alt="Velinex Cloud" class="block h-auto w-44 max-w-full">
            </div>

            <nav class="flex flex-1 flex-col gap-0.5 overflow-y-auto px-2.5 py-3.5">
                <span class="px-2 pb-1.5 pt-3.5 font-mono text-[9px] uppercase tracking-[0.22em] text-dim">Mail</span>

                @php
                    $navDash = request()->routeIs('mail.dashboard');
                    $navManage = request()->routeIs('mail.domains.manage');
                    $navCreate = request()->routeIs('mail.domains.create');
                    $navAdminPlans = request()->routeIs('admin.plans.*');
                @endphp

                <a href="{{ route('mail.dashboard') }}"
                   @class([
                       'relative flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-[13px] font-medium transition-all duration-150',
                       'bg-accent-muted text-accent' => $navDash,
                       'text-muted hover:bg-hover hover:text-foreground' => ! $navDash,
                   ])>
                    @if($navDash)
                        <span class="absolute left-0 top-1/2 h-[60%] w-0.5 -translate-y-1/2 rounded-r-sm bg-accent shadow-[0_0_8px_#3eecff]" aria-hidden="true"></span>
                    @endif
                    <svg class="h-[15px] w-[15px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('mail.domains.manage') }}"
                   @class([
                       'relative flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-[13px] font-medium transition-all duration-150',
                       'bg-accent-muted text-accent' => $navManage,
                       'text-muted hover:bg-hover hover:text-foreground' => ! $navManage,
                   ])>
                    @if($navManage)
                        <span class="absolute left-0 top-1/2 h-[60%] w-0.5 -translate-y-1/2 rounded-r-sm bg-accent shadow-[0_0_8px_#3eecff]" aria-hidden="true"></span>
                    @endif
                    <svg class="h-[15px] w-[15px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18"/><path d="M3 12h18"/><path d="M3 18h18"/>
                    </svg>
                    Manage Domains
                </a>

                <a href="{{ route('mail.domains.create') }}"
                   @class([
                       'relative flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-[13px] font-medium transition-all duration-150',
                       'bg-accent-muted text-accent' => $navCreate,
                       'text-muted hover:bg-hover hover:text-foreground' => ! $navCreate,
                   ])>
                    @if($navCreate)
                        <span class="absolute left-0 top-1/2 h-[60%] w-0.5 -translate-y-1/2 rounded-r-sm bg-accent shadow-[0_0_8px_#3eecff]" aria-hidden="true"></span>
                    @endif
                    <svg class="h-[15px] w-[15px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/>
                    </svg>
                    Add Domain
                </a>

                @if(request()->routeIs('mail.domains.show', 'mail.domains.mailboxes'))
                    <a href="{{ url()->current() }}"
                       class="relative flex items-center gap-2.5 rounded-lg bg-accent-muted py-2 pl-7 pr-2.5 text-xs font-medium text-accent">
                        <span class="absolute left-0 top-1/2 h-[60%] w-0.5 -translate-y-1/2 rounded-r-sm bg-accent shadow-[0_0_8px_#3eecff]" aria-hidden="true"></span>
                        <svg class="h-[15px] w-[15px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9"/><path d="M12 8v4l3 3"/>
                        </svg>
                        DNS Setup
                    </a>
                @endif

                @if(auth()->user()?->is_admin)
                    <span class="mt-3 px-2 pb-1.5 pt-3.5 font-mono text-[9px] uppercase tracking-[0.22em] text-dim">Admin</span>

                    <a href="{{ route('admin.plans.index') }}"
                       @class([
                           'relative flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-[13px] font-medium transition-all duration-150',
                           'bg-accent-muted text-accent' => $navAdminPlans,
                           'text-muted hover:bg-hover hover:text-foreground' => ! $navAdminPlans,
                       ])>
                        @if($navAdminPlans)
                            <span class="absolute left-0 top-1/2 h-[60%] w-0.5 -translate-y-1/2 rounded-r-sm bg-accent shadow-[0_0_8px_#3eecff]" aria-hidden="true"></span>
                        @endif
                        <svg class="h-[15px] w-[15px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                        </svg>
                        Mail Plans
                    </a>
                @endif
            </nav>

            <div class="flex flex-col gap-2.5 border-t border-border px-3 py-3">
                <div class="flex min-w-0 items-center gap-2.5">
                    <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full border border-cyan-400/20 bg-accent-muted text-[11px] font-bold uppercase text-accent">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="truncate text-xs font-medium text-foreground">{{ auth()->user()->name }}</div>
                        <div class="truncate font-mono text-[10px] text-muted">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <form method="post" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex w-full items-center gap-2 rounded-md border border-border bg-transparent px-2.5 py-1.5 font-sans text-xs font-medium text-muted transition-all duration-150 hover:border-[rgba(255,77,106,0.4)] hover:bg-danger-muted hover:text-danger">
                        <svg class="h-[13px] w-[13px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        Sign out
                    </button>
                </form>
            </div>
        </aside>

        <div class="relative flex min-h-screen flex-col">
            <div class="pointer-events-none fixed inset-0 left-0 z-0 bg-[radial-gradient(circle,rgba(62,236,255,0.10)_1px,transparent_1px)] bg-[length:26px_26px] md:left-[var(--spacing-sidebar)]" aria-hidden="true"></div>

            <header class="relative z-[2] flex h-[var(--spacing-topbar)] shrink-0 items-center justify-between border-b border-border px-7">
                <div class="flex flex-col">
                    <span class="mb-px font-mono text-[9px] uppercase tracking-[0.18em] text-dim">@yield('crumb', 'Velinex / Cloud')</span>
                    <span class="font-sans text-[15px] font-medium tracking-wide text-foreground">@yield('page-title', 'Dashboard')</span>
                </div>
                <div class="flex items-center gap-2">
                    @yield('topbar-actions')
                </div>
            </header>

            <main class="relative z-[1] flex-1 px-7 py-6">
                @if(session('status'))
                    <x-ui.alert variant="success" class="mb-5">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        {{ session('status') }}
                    </x-ui.alert>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
