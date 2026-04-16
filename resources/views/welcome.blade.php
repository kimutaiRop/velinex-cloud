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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-900 antialiased">

@include('welcome.partials.nav')
@include('welcome.partials.hero')

<div class="border-y border-slate-200 bg-white">
    <div class="mx-auto grid max-w-6xl grid-cols-1 divide-y divide-slate-200 px-4 sm:grid-cols-2 sm:divide-y-0 sm:divide-x lg:grid-cols-4 lg:px-8">
        <div class="px-4 py-8 text-center">
            <div class="text-3xl font-light tracking-tight text-slate-900">99<span class="text-[#19C7DC]">.97%</span></div>
            <div class="mt-1 text-xs text-slate-500">Uptime guarantee</div>
        </div>
        <div class="px-4 py-8 text-center">
            <div class="text-3xl font-light tracking-tight text-slate-900">&lt;<span class="text-[#19C7DC]">5ms</span></div>
            <div class="mt-1 text-xs text-slate-500">DNS propagation</div>
        </div>
        <div class="px-4 py-8 text-center">
            <div class="text-3xl font-light tracking-tight text-slate-900">24<span class="text-[#19C7DC]">/7</span></div>
            <div class="mt-1 text-xs text-slate-500">Expert support</div>
        </div>
        <div class="px-4 py-8 text-center">
            <div class="text-3xl font-light tracking-tight text-slate-900"><span class="text-[#19C7DC]">∞</span></div>
            <div class="mt-1 text-xs text-slate-500">Mailboxes per domain</div>
        </div>
    </div>
</div>

<section id="services" class="py-16 md:py-20">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10">
            <p class="mb-3 border-l-2 border-[#19C7DC] pl-3 font-mono text-[10px] font-normal uppercase tracking-[0.22em] text-slate-500">What we offer</p>
            <h2 class="text-3xl font-medium tracking-tight text-slate-900">Two services, one platform.</h2>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">Everything your business needs to host and communicate — managed from a single dashboard.</p>
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="mb-5 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-cyan-100 text-cyan-700">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <h3 class="text-xl font-medium text-slate-900">Web Hosting</h3>
                <p class="mt-2 text-sm leading-7 text-slate-600">High-performance hosting powered by nginx. SSD storage, HTTP/3, automatic SSL, and global CDN edge caching for sub-50ms TTFB worldwide.</p>
                <ul class="mt-5 space-y-2 text-sm text-slate-600">
                    <li class="flex items-start gap-2.5"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600"><polyline points="20 6 9 17 4 12"/></svg>Automatic SSL via Let's Encrypt</li>
                    <li class="flex items-start gap-2.5"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600"><polyline points="20 6 9 17 4 12"/></svg>PHP 8.3, Node.js 20, Python runtimes</li>
                    <li class="flex items-start gap-2.5"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600"><polyline points="20 6 9 17 4 12"/></svg>Daily backups, 30-day retention</li>
                    <li class="flex items-start gap-2.5"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600"><polyline points="20 6 9 17 4 12"/></svg>One-click staging environments</li>
                </ul>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="mb-5 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-violet-100 text-violet-700">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <h3 class="text-xl font-medium text-slate-900">Business Email</h3>
                <p class="mt-2 text-sm leading-7 text-slate-600">Self-hosted iRedMail with full DNS control. Your domain, your data — SPF, DKIM, and DMARC configured automatically in under a minute.</p>
                <ul class="mt-5 space-y-2 text-sm text-slate-600">
                    <li class="flex items-start gap-2.5"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600"><polyline points="20 6 9 17 4 12"/></svg>Auto-generated SPF, DKIM & DMARC</li>
                    <li class="flex items-start gap-2.5"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600"><polyline points="20 6 9 17 4 12"/></svg>Unlimited mailboxes per domain</li>
                    <li class="flex items-start gap-2.5"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600"><polyline points="20 6 9 17 4 12"/></svg>Webmail + IMAP/SMTP/POP3</li>
                    <li class="flex items-start gap-2.5"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600"><polyline points="20 6 9 17 4 12"/></svg>Spam filtering & virus scanning</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="features" class="bg-slate-50 py-16 md:py-20">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10">
            <p class="mb-3 border-l-2 border-[#19C7DC] pl-3 font-mono text-[10px] font-normal uppercase tracking-[0.22em] text-slate-500">Platform</p>
            <h2 class="text-3xl font-medium tracking-tight text-slate-900">Built for professionals.</h2>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">The infrastructure capabilities that matter to teams running real workloads.</p>
        </div>
        <div class="grid gap-4 lg:grid-cols-3">
            <div class="rounded-xl bg-[#3EECFF] p-8 lg:row-span-2">
                <div class="mb-8 inline-flex h-11 w-11 items-center justify-center rounded-lg bg-white/30 text-cyan-900">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3 class="text-2xl font-medium text-cyan-950">Zero-compromise security</h3>
                <p class="mt-3 text-sm leading-7 text-cyan-900/80">TLS 1.3 everywhere, hardened server configurations, automated vulnerability scanning, and fail2ban protection across all entry points. Built to withstand production threats.</p>
            </div>
            @php
                $featureCards = [
                    ['Live monitoring', 'Real-time visibility into uptime, mail queues, and DNS propagation.', 'bg-emerald-100 text-emerald-600', 'activity'],
                    ['DNS management', 'Records auto-generated on creation. One-click verification.', 'bg-violet-100 text-violet-700', 'globe'],
                    ['99.97% uptime SLA', 'Guaranteed availability backed by redundant infrastructure.', 'bg-amber-100 text-amber-600', 'clock'],
                    ['REST API', 'Automate domain, mailbox, and DNS management via API.', 'bg-rose-100 text-rose-600', 'code'],
                    ['Multi-tenant', 'Manage multiple client organizations from one dashboard.', 'bg-cyan-100 text-cyan-600', 'users'],
                ];
            @endphp
            @foreach($featureCards as [$title, $desc, $iconClass, $icon])
                <div class="rounded-xl border border-slate-200 bg-white p-6">
                    <div class="mb-3 inline-flex h-8 w-8 items-center justify-center rounded-lg {{ $iconClass }}">
                        @switch($icon)
                            @case('activity')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="h-[15px] w-[15px] shrink-0"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                @break
                            @case('globe')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="h-[15px] w-[15px] shrink-0"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                @break
                            @case('clock')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="h-[15px] w-[15px] shrink-0"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                @break
                            @case('code')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="h-[15px] w-[15px] shrink-0"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                                @break
                            @case('users')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="h-[15px] w-[15px] shrink-0"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                @break
                        @endswitch
                    </div>
                    <h4 class="text-sm font-medium text-slate-900">{{ $title }}</h4>
                    <p class="mt-1 text-sm leading-6 text-slate-600">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<div class="border-y border-slate-200 bg-slate-50 py-10">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center gap-x-8 gap-y-2 px-4 sm:px-6 lg:px-8">
        <span class="border-l border-slate-300 pl-3 font-mono text-[10px] font-normal uppercase tracking-[0.18em] text-slate-500">Powering businesses at</span>
        <span class="text-sm text-slate-500">Acme Digital</span>
        <span class="text-sm text-slate-500">RunFast Agency</span>
        <span class="text-sm text-slate-500">BuildLabs</span>
        <span class="text-sm text-slate-500">Skyline Group</span>
        <span class="text-sm text-slate-500">NovaTech</span>
    </div>
</div>

<section id="how" class="py-16 md:py-20">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10">
            <p class="mb-3 border-l-2 border-[#19C7DC] pl-3 font-mono text-[10px] font-normal uppercase tracking-[0.22em] text-slate-500">Getting started</p>
            <h2 class="text-3xl font-medium tracking-tight text-slate-900">Three steps to go live.</h2>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">No servers to configure. No command line required.</p>
        </div>
        <div class="grid gap-5 md:grid-cols-3">
            <div class="rounded-xl border border-slate-200 bg-white p-6">
                <div class="mb-4 font-mono text-[11px] font-medium tracking-[0.2em] text-slate-400">01</div>
                <h3 class="text-base font-medium text-slate-900">Create an account</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">Register in under a minute. Your company workspace is created automatically — no card required to start.</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-6">
                <div class="mb-4 font-mono text-[11px] font-medium tracking-[0.2em] text-slate-400">02</div>
                <h3 class="text-base font-medium text-slate-900">Add your domain</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">Enter your domain. SPF, DKIM, DMARC, and MX records are generated immediately, ready to add at your registrar.</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-6">
                <div class="mb-4 font-mono text-[11px] font-medium tracking-[0.2em] text-slate-400">03</div>
                <h3 class="text-base font-medium text-slate-900">Verify and launch</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">Click Verify DNS — propagation is checked automatically. Once confirmed, provision mailboxes and you're live.</p>
            </div>
        </div>
    </div>
</section>

@include('welcome.partials.pricing')
@include('welcome.partials.cta-footer')

@include('welcome.partials.scripts')
</body>
</html>
