{{-- CTA: angled panel + geometric lines + rings (matches legacy cta-section) --}}
<section
    class="relative my-10 overflow-hidden bg-[#0d1117] py-[74px] [clip-path:polygon(0_32px,100%_0,100%_calc(100%-32px),0_100%)] md:py-[100px]"
    aria-labelledby="cta-heading"
>
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <svg
            class="absolute right-0 top-0 h-full w-[420px] max-w-[55vw] opacity-[0.06]"
            viewBox="0 0 420 400"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            preserveAspectRatio="xMaxYMid slice"
        >
            <line x1="0" y1="0" x2="420" y2="400" stroke="white" stroke-width="1"/>
            <line x1="60" y1="0" x2="420" y2="340" stroke="white" stroke-width="1"/>
            <line x1="120" y1="0" x2="420" y2="280" stroke="white" stroke-width="1"/>
            <line x1="180" y1="0" x2="420" y2="220" stroke="white" stroke-width="1"/>
            <line x1="240" y1="0" x2="420" y2="160" stroke="white" stroke-width="1"/>
            <line x1="300" y1="0" x2="420" y2="100" stroke="white" stroke-width="1"/>
            <line x1="360" y1="0" x2="420" y2="40" stroke="white" stroke-width="1"/>
            <circle cx="380" cy="80" r="60" stroke="white" stroke-width="1" fill="none"/>
            <circle cx="380" cy="80" r="110" stroke="white" stroke-width="1" fill="none"/>
        </svg>
    </div>
    <div class="pointer-events-none absolute -bottom-20 -left-20 size-80 rounded-full border-[1.5px] border-white/[0.08]" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -bottom-[30px] -left-[30px] size-[180px] rounded-full border border-white/5" aria-hidden="true"></div>

    <div class="relative z-10 mx-auto grid max-w-6xl gap-8 px-4 sm:px-6 lg:grid-cols-[1fr_auto] lg:items-center lg:gap-12 lg:px-8">
        <div>
            <h2 id="cta-heading" class="mb-2.5 text-2xl font-normal leading-[1.2] tracking-[-0.02em] text-white md:text-[30px]">
                Ready to take control<br>of your infrastructure?
            </h2>
            <p class="max-w-[420px] text-[13px] font-light leading-relaxed text-white/50">
                Join businesses across East Africa running their web and email on Velinex Cloud. Get started free — no credit card needed.
            </p>
        </div>
        <div class="flex shrink-0 flex-row flex-wrap gap-2 min-[1081px]:flex-col min-[1081px]:flex-nowrap">
            <a
                href="{{ route('auth.register') }}"
                class="inline-flex items-center justify-center gap-1.5 whitespace-nowrap rounded-md bg-white px-6 py-2.5 text-[13px] font-normal text-[#0d1117] shadow-none transition hover:bg-slate-100 hover:shadow-[0_2px_12px_rgba(0,0,0,0.14)]"
            >
                Start for free
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-[13px] w-[13px] shrink-0"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
            <a
                href="{{ route('login') }}"
                class="inline-flex items-center justify-center whitespace-nowrap rounded-md border border-white/[0.14] bg-transparent px-5 py-2.5 text-[13px] font-light text-white/55 transition hover:border-white/40 hover:text-white"
            >
                Sign in to dashboard →
            </a>
        </div>
    </div>
</section>

<footer class="border-t border-slate-200 py-8">
    <div class="mx-auto flex max-w-6xl flex-col gap-4 px-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
        <img src="{{ asset('logo.svg') }}" alt="Velinex Cloud" class="h-auto w-[102px]">
        <span class="text-xs font-light text-slate-500">© {{ date('Y') }} Velinex Labs. All rights reserved.</span>
        <div class="flex gap-5 text-xs font-light text-slate-500">
            <a href="#" class="transition hover:text-slate-700">Privacy</a>
            <a href="#" class="transition hover:text-slate-700">Terms</a>
            <a href="{{ route('login') }}" class="transition hover:text-slate-700">Sign in</a>
        </div>
    </div>
</footer>
