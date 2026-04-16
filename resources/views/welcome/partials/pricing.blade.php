<!-- Pricing -->
<section id="pricing" class="pricing">
    <div class="wrap">
        <div class="pricing-head reveal">
            <div class="section-eyebrow">Pricing</div>
            <h2 class="section-h2">Simple, transparent pricing.</h2>
            <p class="section-sub">Host with us and get <strong>unlimited mailboxes per domain</strong> on every plan. Works with Gmail, Outlook, and Apple Mail on mobile and desktop — no custom app required.</p>
            <div class="pricing-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Unlimited mailboxes included on all plans — no per-seat fees, no custom app lock-in
            </div>
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
            $maxFeatureRows = $normalizedFeaturesByPlan->max(function ($items) {
                return $items->count();
            }) ?? 0;
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

        <div class="pricing-grid-scroll reveal">
        <div class="pricing-grid" style="--plan-count: {{ $plans->count() }};">
            @for($dividerIndex = 1; $dividerIndex < $planCount; $dividerIndex++)
                <div class="plan-column-divider" style="left: {{ ($dividerIndex / $planCount) * 100 }}%;"></div>
            @endfor

            @foreach($plansList as $plan)
            <div class="plan-card {{ $plan->is_featured ? 'featured' : '' }}" @if($loop->last) style="border-right:none;" @endif>
                <div class="plan-head">
                    @if($plan->is_featured)
                        <div class="plan-badge">Most popular</div>
                    @endif

                    <div class="plan-name">{{ $plan->name }}</div>
                    <div class="plan-desc">{{ $plan->description }}</div>

                    <div class="plan-price">
                        @if($plan->price_kes === 0)
                            <div class="plan-price-val">Free</div>
                            <div class="plan-price-period">No credit card needed</div>
                            <div class="plan-price-period">Also available yearly</div>
                        @else
                            <div class="plan-price-val"><small>KES </small>{{ number_format($plan->price_kes) }}</div>
                            <div class="plan-price-period">per year, billed yearly</div>
                            <div class="plan-price-period"><small style="font-size:10px;">KES </small>{{ number_format($plan->price_kes / 12) }} estimated monthly equivalent</div>
                        @endif
                    </div>

                    <div class="plan-storage">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
                        {{ $plan->storage_label }} / mailbox
                    </div>
                </div>
            </div>
            @endforeach

            @foreach($sortedFeatureRows as $rowMeta)
                @php $rowIndex = $rowMeta['rowIndex']; @endphp
                @php $columnIndex = 0; @endphp
                @while($columnIndex < $planCount)
                    @php
                        $rowFeature = $normalizedFeaturesByPlan->get($columnIndex)?->get($rowIndex);
                        $spanCount = 1;
                        while ($columnIndex + $spanCount < $planCount && ($normalizedFeaturesByPlan->get($columnIndex + $spanCount)?->get($rowIndex) === $rowFeature)) {
                            $spanCount++;
                        }
                    @endphp

                    @if($rowFeature === null)
                        <div class="feature-gap" style="grid-column: {{ $columnIndex + 1 }} / span {{ $spanCount }};"></div>
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
                        <div class="feature-pill {{ $spansFeaturedPlan ? 'feature-pill-featured' : '' }}"
                             style="grid-column: {{ $columnIndex + 1 }} / span {{ $spanCount }};">
                            <span class="plan-check">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            </span>
                            {{ $rowFeature }}
                        </div>
                    @endif

                    @php $columnIndex += $spanCount; @endphp
                @endwhile
            @endforeach

            @foreach($plansList as $plan)
            <div class="plan-foot" @if($loop->last) style="border-right:none;" @endif>
                <a href="{{ route('auth.register') }}"
                   class="plan-cta {{ $plan->is_featured ? 'plan-cta-white' : 'plan-cta-outline' }}">
                    {{ $plan->price_kes === 0 ? 'Start for free' : 'Get started' }}
                </a>
            </div>
            @endforeach
        </div>
        </div>

        <div class="pricing-mobile reveal">
            @foreach($plansList as $plan)
                @php
                    $planFeatureList = $normalizedFeaturesByPlan->get($loop->index, collect())
                        ->filter()
                        ->values();
                @endphp
                <div class="mobile-plan-card">
                    <div class="mobile-plan-name">{{ $plan->name }}</div>
                    @if($plan->price_kes === 0)
                        <div class="mobile-plan-price">Free</div>
                        <div class="mobile-plan-meta">No credit card needed</div>
                    @else
                        <div class="mobile-plan-price">KES {{ number_format($plan->price_kes) }}</div>
                        <div class="mobile-plan-meta">per year, billed yearly</div>
                    @endif
                    <a href="{{ route('auth.register') }}"
                       class="plan-cta {{ $plan->is_featured ? 'plan-cta-white' : 'plan-cta-outline' }}">
                        {{ $plan->price_kes === 0 ? 'Start for free' : 'Get started' }}
                    </a>
                    @if($planFeatureList->isNotEmpty())
                        <ul class="mobile-plan-features">
                            @foreach($planFeatureList as $planFeature)
                                <li>
                                    <span class="mobile-plan-check">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
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

        <p class="reveal" style="text-align:center;font-size:12.5px;font-weight:300;color:var(--text-3);margin-top:32px;">
            All plans include auto-configured SPF, DKIM & DMARC records and unlimited mailboxes per domain.
            Need a custom plan? <a href="mailto:hello@velinexlabs.com" style="color:var(--blue);">Contact us</a>.
        </p>
    </div>
</section>
