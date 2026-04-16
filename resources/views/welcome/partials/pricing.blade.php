<section id="pricing" class="bg-gradient-to-b from-white to-slate-50 py-16 md:py-20">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10">
            <div class="text-xs font-medium uppercase tracking-[0.14em] text-cyan-600">Pricing</div>
            <h2 class="mt-2 text-3xl font-medium tracking-tight text-slate-900">Simple, transparent pricing.</h2>
            <p class="mt-3 max-w-3xl text-sm leading-7 text-slate-600">Host with us and get <strong>unlimited mailboxes per domain</strong> on every plan. Works with Gmail, Outlook, and Apple Mail on mobile and desktop — no custom app required.</p>
            <div class="mt-4 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs text-emerald-700">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3"><polyline points="20 6 9 17 4 12"/></svg>
                Unlimited mailboxes included on all plans — no per-seat fees, no custom app lock-in
            </div>
        </div>

        @if($plans->isNotEmpty())
            @php
                $plansList = $plans->values();
                $normalizedFeaturesByPlan = $plansList->map(function ($plan) {
                    return collect($plan->features)->map(function ($feature) {
                        $normalizedFeature = preg_replace('/\bunlimited\s+domains?\b/i', 'Domain service', $feature);
                        $normalizedFeature = preg_replace('/\bup to\s+\d+\s+domains?\b/i', 'Domain service', $normalizedFeature);
                        return preg_replace('/\b\d+\s+domains?\b/i', 'Domain service', $normalizedFeature);
                    })->filter()->values();
                })->values();
            @endphp

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($plansList as $plan)
                    @php
                        $planFeatureList = $normalizedFeaturesByPlan->get($loop->index, collect());
                    @endphp
                    <div class="flex h-full flex-col rounded-xl border {{ $plan->is_featured ? 'border-cyan-300 bg-cyan-50/40 shadow-lg shadow-cyan-100/50' : 'border-slate-200 bg-white' }}">
                        <div class="flex-1 p-5">
                            <div class="mb-2 flex items-center justify-between gap-2">
                                <div class="text-lg font-medium text-slate-900">{{ $plan->name }}</div>
                                @if($plan->is_featured)
                                    <span class="rounded-full border border-cyan-300 bg-cyan-100 px-2 py-0.5 text-[10px] font-medium uppercase tracking-wide text-cyan-700">Most popular</span>
                                @endif
                            </div>
                            <p class="min-h-[2.5rem] text-xs leading-5 text-slate-500">{{ $plan->description }}</p>

                            <div class="mt-3">
                                @if($plan->price_kes === 0)
                                    <div class="text-3xl font-medium leading-none text-slate-900">Free</div>
                                    <div class="mt-1 text-xs text-slate-500">No credit card needed</div>
                                @else
                                    <div class="text-3xl font-medium leading-none text-slate-900">KES {{ number_format($plan->price_kes) }}</div>
                                    <div class="mt-1 text-xs text-slate-500">per year, billed yearly</div>
                                    <div class="text-[11px] text-slate-400">KES {{ number_format($plan->price_kes / 12) }} estimated monthly equivalent</div>
                                @endif
                            </div>

                            <div class="mt-4 inline-flex items-center gap-1 rounded-full border border-slate-200 bg-white px-3 py-1 text-xs text-slate-600">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/></svg>
                                {{ $plan->storage_label }} / mailbox
                            </div>

                            @if($planFeatureList->isNotEmpty())
                                <ul class="mt-4 space-y-2">
                                    @foreach($planFeatureList as $planFeature)
                                        <li class="flex items-start gap-2 text-sm text-slate-600">
                                            <span class="mt-0.5 inline-flex h-4 w-4 items-center justify-center rounded-full bg-rose-100 text-rose-500">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="h-2.5 w-2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                            </span>
                                            <span>{{ $planFeature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="border-t border-slate-200 p-4">
                            <a href="{{ route('auth.register') }}" class="block rounded-md {{ $plan->is_featured ? 'bg-[#3EECFF] text-cyan-950 hover:bg-[#19C7DC]' : 'border border-slate-300 text-slate-700 hover:border-cyan-300 hover:bg-cyan-50 hover:text-cyan-700' }} px-4 py-2 text-center text-sm font-medium transition">
                                {{ $plan->price_kes === 0 ? 'Start for free' : 'Get started' }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <p class="mt-8 text-center text-xs text-slate-500">
            All plans include auto-configured SPF, DKIM & DMARC records and unlimited mailboxes per domain.
            Need a custom plan? <a href="mailto:hello@velinexlabs.com" class="text-cyan-700 hover:text-cyan-600">Contact us</a>.
        </p>
    </div>
</section>
