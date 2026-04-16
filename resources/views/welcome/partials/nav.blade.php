<nav class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur">
    <div class="mx-auto flex h-14 w-full max-w-6xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="/" class="flex items-center">
            <img src="{{ asset('logo.svg') }}" alt="Velinex Cloud" class="h-auto w-28">
        </a>
        <div class="hidden items-center gap-1 md:flex">
            <a href="#services" class="rounded px-3 py-1.5 text-sm font-light text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Services</a>
            <a href="#features" class="rounded px-3 py-1.5 text-sm font-light text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Features</a>
            <a href="#how" class="rounded px-3 py-1.5 text-sm font-light text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">How it works</a>
            <a href="#pricing" class="rounded px-3 py-1.5 text-sm font-light text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Pricing</a>
            @auth
                <a href="{{ route('mail.dashboard') }}" class="ml-1 rounded-md bg-[#3EECFF] px-4 py-1.5 text-sm font-medium text-cyan-950 transition hover:bg-[#19C7DC]">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="rounded px-3 py-1.5 text-sm font-light text-slate-600 transition hover:text-slate-900">Sign in</a>
                <a href="{{ route('auth.register') }}" class="ml-1 rounded-md bg-[#3EECFF] px-4 py-1.5 text-sm font-medium text-cyan-950 transition hover:bg-[#19C7DC]">Get started</a>
            @endauth
        </div>
        <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-md border border-slate-300 text-slate-800 md:hidden" id="nav-menu-open" aria-label="Open menu" aria-expanded="false" aria-controls="nav-drawer">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="h-5 w-5"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></svg>
        </button>
    </div>
</nav>
<div class="pointer-events-none fixed inset-0 z-[60] hidden bg-slate-900/40 opacity-0 transition-opacity duration-200" id="nav-drawer-backdrop" aria-hidden="true"></div>
<aside class="pointer-events-none fixed right-0 top-0 z-[70] flex h-full w-[86vw] max-w-xs translate-x-full flex-col gap-2 overflow-y-auto border-l border-slate-200 bg-white p-6 pt-16 shadow-xl transition-transform duration-200" id="nav-drawer" role="dialog" aria-modal="true" aria-label="Site menu" aria-hidden="true">
    <p class="mb-1 border-l-2 border-slate-300 pl-2 font-mono text-[10px] font-normal uppercase tracking-[0.22em] text-slate-500">Menu</p>
    <a href="#services" class="rounded px-3 py-2 text-sm text-slate-700 hover:bg-slate-100">Services</a>
    <a href="#features" class="rounded px-3 py-2 text-sm text-slate-700 hover:bg-slate-100">Features</a>
    <a href="#how" class="rounded px-3 py-2 text-sm text-slate-700 hover:bg-slate-100">How it works</a>
    <a href="#pricing" class="rounded px-3 py-2 text-sm text-slate-700 hover:bg-slate-100">Pricing</a>
    @auth
        <a href="{{ route('mail.dashboard') }}" class="mt-1 rounded-md bg-[#3EECFF] px-4 py-2 text-center text-sm font-medium text-cyan-950">Dashboard</a>
    @else
        <a href="{{ route('login') }}" class="mt-1 rounded-md border border-slate-300 px-4 py-2 text-center text-sm text-slate-700">Sign in</a>
        <a href="{{ route('auth.register') }}" class="rounded-md bg-[#3EECFF] px-4 py-2 text-center text-sm font-medium text-cyan-950">Get started</a>
    @endauth
</aside>
