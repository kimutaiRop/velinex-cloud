<section class="my-10 bg-slate-900 py-16">
    <div class="mx-auto grid max-w-6xl gap-8 px-4 sm:px-6 lg:grid-cols-[1fr_auto] lg:items-center lg:px-8">
        <div>
            <h2 class="text-3xl font-medium leading-tight tracking-tight text-white">Ready to take control<br>of your infrastructure?</h2>
            <p class="mt-3 max-w-xl text-sm leading-7 text-slate-300">Join businesses across East Africa running their web and email on Velinex Cloud. Get started free — no credit card needed.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('auth.register') }}" class="inline-flex items-center gap-2 rounded-md bg-white px-5 py-2.5 text-sm font-medium text-slate-900 transition hover:bg-slate-100">
                Start for free
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
            <a href="{{ route('login') }}" class="inline-flex items-center rounded-md border border-slate-600 px-5 py-2.5 text-sm font-light text-slate-200 transition hover:border-slate-400 hover:text-white">Sign in to dashboard</a>
        </div>
    </div>
</section>

<footer class="border-t border-slate-200 py-8">
    <div class="mx-auto flex max-w-6xl flex-col gap-4 px-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
        <img src="{{ asset('logo.svg') }}" alt="Velinex Cloud" class="h-auto w-24">
        <span class="text-xs text-slate-500">© {{ date('Y') }} Velinex Labs. All rights reserved.</span>
        <div class="flex gap-5 text-xs text-slate-500">
            <a href="#" class="hover:text-slate-700">Privacy</a>
            <a href="#" class="hover:text-slate-700">Terms</a>
            <a href="{{ route('login') }}" class="hover:text-slate-700">Sign in</a>
        </div>
    </div>
</footer>
