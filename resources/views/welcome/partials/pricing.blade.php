{{-- Matrix-style pricing board (registrar-style columns) + stacked cards on small screens --}}
<section id="pricing" class="relative overflow-hidden bg-gradient-to-b from-white to-[#f8fbff] py-[70px] md:py-[88px]">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 md:px-[22px] lg:px-8">
        <div class="mb-7 md:mb-14">
            <p class="mb-3 border-l-2 border-[#19C7DC] pl-3 font-mono text-[10px] font-normal uppercase tracking-[0.22em] text-slate-500">Pricing</p>
            <h2 class="text-3xl font-medium tracking-tight text-slate-900">Simple, transparent pricing.</h2>
            <p class="mt-3 max-w-3xl text-sm font-light leading-7 text-slate-600 md:text-[15px] md:leading-relaxed">
                Host with us and get <strong class="font-medium text-slate-800">unlimited mailboxes per domain</strong> on every plan. Works with Gmail, Outlook, and Apple Mail on mobile and desktop — no custom app required.
            </p>
            <p class="mt-4 max-w-3xl border-l border-slate-200 pl-3 text-sm leading-relaxed text-slate-600">
                <span class="font-mono text-[10px] uppercase tracking-[0.16em] text-slate-400">Included</span>
                — Unlimited mailboxes on every plan; no per-seat pricing and no proprietary mail client required.
            </p>
        </div>

        @if($plans->isNotEmpty())
            @php
                $plansList = $plans->values();
                $planCount = $plansList->count();
                $normalizedFeaturesByPlan = $plansList->map(function ($plan) {
                    return collect($plan->features)->map(function ($feature) {
                        $normalizedFeature = preg_replace('/\bunlimited\s+domains?\b/i', 'Domain service', $feature);
                        $normalizedFeature = preg_replace('/\bup to\s+\d+\s+domains?\b/i', 'Domain service', $normalizedFeature);
                        return preg_replace('/\b\d+\s+domains?\b/i', 'Domain service', $normalizedFeature);
                    })->values();
                })->values();
                $maxFeatureRows = $normalizedFeaturesByPlan->max(fn ($items) => $items->count()) ?? 0;
                $sortedFeatureRows = collect(range(0, max($maxFeatureRows - 1, 0)))->map(function ($rowIndex) use ($normalizedFeaturesByPlan, $planCount) {
                    $maxSpan = 0;
                    $columnIndex = 0;
                    while ($columnIndex < $planCount) {
                        $rowFeature = $normalizedFeaturesByPlan->get($columnIndex)?->get($rowIndex);
                        $spanCount = 1;
                        while ($columnIndex + $spanCount < $planCount && ($normalizedFeaturesByPlan->get($columnIndex + $spanCount)?->get($rowIndex) === $rowFeature)) {
                            $spanCount++;
                        }
                        if ($rowFeature !== null) {
                            $maxSpan = max($maxSpan, $spanCount);
                        }
                        $columnIndex += $spanCount;
                    }
                    return ['rowIndex' => $rowIndex, 'maxSpan' => $maxSpan];
                })->sortByDesc('maxSpan')->values();
            @endphp

            {{-- Desktop: horizontal scroll on medium, full board on lg+ --}}
            <div class="hidden md:block">
                <div class="overflow-x-auto pb-1 lg:overflow-visible">
                    <div
                        class="relative grid min-w-[calc(var(--plan-count)*220px)] rounded-2xl border border-slate-200/90 bg-white shadow-sm [grid-template-columns:repeat(var(--plan-count),minmax(0,1fr))] xl:min-w-[calc(var(--plan-count)*235px)]"
                        style="--plan-count: {{ $planCount }};"
                    >
                        @for($dividerIndex = 1; $dividerIndex < $planCount; $dividerIndex++)
                            <div
                                class="pointer-events-none absolute bottom-0 top-0 z-[3] w-px bg-slate-200"
                                style="left: {{ ($dividerIndex / $planCount) * 100 }}%;"
                                aria-hidden="true"
                            ></div>
                        @endfor

                        @foreach($plansList as $plan)
                            <div class="relative z-[1] {{ $loop->last ? '' : 'border-r border-slate-200' }} {{ $plan->is_featured ? 'bg-gradient-to-b from-cyan-400/[0.09] to-cyan-500/[0.16]' : 'bg-transparent' }}">
                                <div class="relative z-[1] flex min-h-[240px] flex-col border-b border-slate-200 bg-slate-50/70 p-5 md:min-h-[255px] {{ $plan->is_featured ? 'border-b-cyan-400/30 bg-cyan-400/10' : '' }}">
                                    @if($plan->is_featured)
                                        <div class="absolute right-3 top-3 z-[2] rounded border border-slate-200 bg-slate-900 px-2 py-0.5 text-[10px] font-medium uppercase tracking-wide text-white">
                                            Most popular
                                        </div>
                                    @endif
                                    <div class="mb-1 text-[17px] font-medium tracking-[-0.02em] text-slate-900 md:text-[17px]">{{ $plan->name }}</div>
                                    <p class="mb-3 min-h-9 text-xs font-light leading-snug text-slate-500">{{ $plan->description }}</p>
                                    <div class="mb-3 min-h-[74px]">
                                        @if($plan->price_kes === 0)
                                            <div class="text-[27px] font-normal leading-none tracking-[-0.03em] text-slate-900">Free</div>
                                            <div class="mt-0.5 text-[11px] font-light text-slate-500">No credit card needed</div>
                                            <div class="mt-px text-[11px] font-light text-slate-500">Also available yearly</div>
                                        @else
                                            <div class="text-[27px] font-normal leading-none tracking-[-0.03em] text-slate-900">
                                                <small class="align-super text-xs font-normal tracking-normal">KES </small>{{ number_format($plan->price_kes) }}
                                            </div>
                                            <div class="mt-0.5 text-[11px] font-light text-slate-500">per year, billed yearly</div>
                                            <div class="mt-px text-[11px] font-light text-slate-500">
                                                <span class="text-[10px]">KES </span>{{ number_format($plan->price_kes / 12) }} estimated monthly equivalent
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mt-auto inline-flex items-center gap-1.5 rounded-md border border-slate-200 bg-white px-2.5 py-1 text-[11px] font-normal text-slate-600 {{ $plan->is_featured ? 'border-cyan-400/40 bg-cyan-50/80 text-cyan-950' : '' }}">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-2.5 w-2.5 shrink-0"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/></svg>
                                        {{ $plan->storage_label }} / mailbox
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @foreach($sortedFeatureRows as $rowMeta)
                            @php $rowIndex = $rowMeta['rowIndex']; $columnIndex = 0; @endphp
                            @while($columnIndex < $planCount)
                                @php
                                    $rowFeature = $normalizedFeaturesByPlan->get($columnIndex)?->get($rowIndex);
                                    $spanCount = 1;
                                    while ($columnIndex + $spanCount < $planCount && ($normalizedFeaturesByPlan->get($columnIndex + $spanCount)?->get($rowIndex) === $rowFeature)) {
                                        $spanCount++;
                                    }
                                @endphp
                                @if($rowFeature === null)
                                    <div class="min-h-[34px]" style="grid-column: {{ $columnIndex + 1 }} / span {{ $spanCount }};"></div>
                                @else
                                    @php
                                        $spansFeaturedPlan = false;
                                        for ($featureCol = $columnIndex; $featureCol < $columnIndex + $spanCount; $featureCol++) {
                                            if ($plansList->get($featureCol)?->is_featured) {
                                                $spansFeaturedPlan = true;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div
                                        class="z-[1] m-2 mt-2.5 flex items-center gap-2 rounded-md border border-slate-200 bg-slate-50/80 px-2.5 py-1.5 text-xs font-light leading-snug text-slate-600 {{ $spansFeaturedPlan ? 'border-cyan-400/25 bg-cyan-50/40' : '' }}"
                                        style="grid-column: {{ $columnIndex + 1 }} / span {{ $spanCount }};"
                                    >
                                        <span class="inline-flex h-[15px] w-[15px] shrink-0 items-center justify-center rounded-sm bg-[rgba(255,96,67,0.1)] text-[#f2573e]">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="h-[7px] w-[7px]"><polyline points="20 6 9 17 4 12"/></svg>
                                        </span>
                                        {{ $rowFeature }}
                                    </div>
                                @endif
                                @php $columnIndex += $spanCount; @endphp
                            @endwhile
                        @endforeach

                        @foreach($plansList as $plan)
                            <div class="z-[1] border-t border-slate-200 p-4 pt-3.5 md:px-[18px] md:pb-[18px] md:pt-3.5 {{ $loop->last ? '' : 'border-r border-slate-200' }}">
                                <a
                                    href="{{ route('auth.register') }}"
                                    class="block rounded-lg py-2.5 text-center text-[12.5px] font-medium transition hover:-translate-y-px {{ $plan->is_featured ? 'border border-transparent bg-[#3EECFF] text-white shadow-[0_5px_18px_rgba(25,199,220,0.2)] hover:bg-[#19C7DC] hover:shadow-[0_8px_24px_rgba(25,199,220,0.28)]' : 'border border-slate-300/90 bg-white text-slate-600 hover:border-cyan-400 hover:bg-cyan-50 hover:text-cyan-700' }}"
                                >
                                    {{ $plan->price_kes === 0 ? 'Start for free' : 'Get started' }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Mobile: stacked cards (< md) --}}
            <div class="space-y-2.5 md:hidden">
                @foreach($plansList as $plan)
                    @php
                        $planFeatureList = $normalizedFeaturesByPlan->get($loop->index, collect())->filter()->values();
                    @endphp
                    <div class="rounded-xl border border-slate-200 bg-white p-3.5">
                        <div class="text-[15px] font-medium text-slate-900">{{ $plan->name }}</div>
                        @if($plan->price_kes === 0)
                            <div class="my-1 text-xl font-medium text-slate-900">Free</div>
                            <div class="mb-2.5 text-[11px] text-slate-500">No credit card needed</div>
                        @else
                            <div class="my-1 text-xl font-medium text-slate-900">KES {{ number_format($plan->price_kes) }}</div>
                            <div class="mb-2.5 text-[11px] text-slate-500">per year, billed yearly</div>
                        @endif
                        <a
                            href="{{ route('auth.register') }}"
                            class="mb-3 block rounded-lg py-2.5 text-center text-[12.5px] font-medium transition {{ $plan->is_featured ? 'border border-transparent bg-[#3EECFF] text-white shadow-[0_5px_18px_rgba(25,199,220,0.2)]' : 'border border-slate-300/90 bg-white text-slate-600' }}"
                        >
                            {{ $plan->price_kes === 0 ? 'Start for free' : 'Get started' }}
                        </a>
                        @if($planFeatureList->isNotEmpty())
                            <ul class="mt-3 flex list-none flex-col gap-1.5 p-0">
                                @foreach($planFeatureList as $planFeature)
                                    <li class="flex items-start gap-1.5 text-xs font-light leading-snug text-slate-600">
                                        <span class="mt-px inline-flex h-[15px] w-[15px] shrink-0 items-center justify-center rounded-sm bg-[rgba(255,96,67,0.1)] text-[#f2573e]">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="h-[7px] w-[7px]"><polyline points="20 6 9 17 4 12"/></svg>
                                        </span>
                                        {{ $planFeature }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <p class="mt-8 text-center text-[12.5px] font-light text-slate-500">
            All plans include auto-configured SPF, DKIM & DMARC records and unlimited mailboxes per domain.
            Need a custom plan? <a href="mailto:hello@velinexlabs.com" class="text-cyan-600 hover:text-cyan-500">Contact us</a>.
        </p>
    </div>
</section>
