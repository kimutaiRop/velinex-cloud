<section class="relative overflow-hidden bg-[linear-gradient(160deg,#fff_0%,#f4f7ff_60%,#eef2fb_100%)] py-16 pb-20 md:py-[88px] md:pb-20">
    {{-- Large geometric rings (top-right) --}}
    <div class="pointer-events-none absolute -right-[120px] -top-[120px] size-[560px] rounded-full border-[1.5px] border-cyan-400/10" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -right-[60px] -top-[60px] size-[380px] rounded-full border border-cyan-400/[0.07]" aria-hidden="true"></div>
    <div class="pointer-events-none absolute right-5 top-5 size-[200px] rounded-full border border-cyan-400/5 md:right-5 md:top-5" aria-hidden="true"></div>
    {{-- Diagonal accent --}}
    <div
        class="pointer-events-none absolute -bottom-10 -left-[60px] h-[220px] w-[500px] max-w-[90vw] bg-gradient-to-br from-cyan-400/[0.06] to-transparent [transform:skewY(-8deg)]"
        aria-hidden="true"
    ></div>

    <div class="relative z-[1] mx-auto grid max-w-6xl gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:gap-14 lg:px-8">
        <div>
            <p class="mb-5 border-l-2 border-[#19C7DC] pl-3 font-mono text-[10px] font-normal uppercase tracking-[0.22em] text-slate-500">
                Enterprise infrastructure
            </p>
            <h1 class="mb-[18px] text-[34px] font-normal leading-[1.13] tracking-[-0.025em] text-slate-900 md:text-[42px]">
                Web hosting and<br>
                business email that<br>
                <strong class="font-medium text-[#19C7DC]">just works.</strong>
            </h1>
            <p class="mb-8 max-w-[400px] text-[15px] font-light leading-[1.68] text-slate-600 md:mb-[34px]">
                Production-grade hosting and self-hosted email built for teams that need reliability, deliverability, and full control over their infrastructure.
            </p>
            <div class="mb-8 flex flex-wrap items-center gap-2.5 md:mb-10">
                <a href="{{ route('auth.register') }}" class="inline-flex items-center gap-1.5 rounded-md bg-[#3EECFF] px-[22px] py-2.5 text-[13px] font-normal text-cyan-950 shadow-[0_2px_10px_rgba(25,199,220,0.25)] transition hover:-translate-y-px hover:bg-[#19C7DC] hover:shadow-[0_4px_18px_rgba(25,199,220,0.35)]">
                    Start for free
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-[13px] w-[13px]"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="#services" class="inline-flex items-center rounded-md border border-slate-300/90 bg-transparent px-5 py-2.5 text-[13px] font-light text-slate-600 transition hover:border-cyan-400 hover:bg-cyan-400/10 hover:text-cyan-700">View services</a>
            </div>
            <div class="flex items-center gap-4 border-t border-slate-200/90 pt-[22px]">
                <div class="flex">
                    <div class="-ml-[7px] flex h-[26px] w-[26px] items-center justify-center rounded-full border-2 border-white bg-[#3EECFF] text-[9px] font-normal text-cyan-950 first:ml-0">AK</div>
                    <div class="-ml-[7px] flex h-[26px] w-[26px] items-center justify-center rounded-full border-2 border-white bg-violet-600 text-[9px] font-normal text-white">SM</div>
                    <div class="-ml-[7px] flex h-[26px] w-[26px] items-center justify-center rounded-full border-2 border-white bg-emerald-600 text-[9px] font-normal text-white">JN</div>
                    <div class="-ml-[7px] flex h-[26px] w-[26px] items-center justify-center rounded-full border-2 border-white bg-amber-500 text-[9px] font-normal text-white">RO</div>
                </div>
                <div class="text-xs font-light text-slate-500">
                    Trusted by <strong class="font-normal text-slate-600">40+ businesses</strong> across East Africa
                </div>
            </div>
        </div>

        {{-- Product mockup: perspective tilt + floating chips (outside tilt) --}}
        <div class="group relative min-h-[280px] [perspective:1400px] lg:min-h-0 lg:pt-6 lg:pr-8 lg:pb-8">
            {{-- Uptime chip — floats outside tilted card --}}
            <div class="relative z-20 mb-3 flex items-center gap-2.5 rounded-[10px] border border-slate-200/90 bg-white p-2.5 pl-3.5 shadow-md md:absolute md:left-0 md:top-3 md:mb-0 md:whitespace-nowrap md:shadow-[0_8px_24px_rgba(15,23,42,0.08)]">
                <div class="flex size-7 shrink-0 items-center justify-center rounded-md bg-emerald-50 text-emerald-600">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div>
                    <div class="text-sm font-normal text-slate-900">99.97%</div>
                    <div class="text-[9.5px] font-light uppercase tracking-[0.06em] text-slate-400">Uptime SLA</div>
                </div>
            </div>

            <div
                class="origin-center transition-transform duration-500 ease-out [transform:perspective(1400px)_rotateX(6deg)_rotateY(-14deg)_rotateZ(1deg)] will-change-transform group-hover:[transform:perspective(1400px)_rotateX(3deg)_rotateY(-7deg)_rotateZ(0.5deg)]"
            >
                <div class="overflow-hidden rounded-xl border border-slate-200/90 bg-white shadow-[0_24px_60px_rgba(0,0,0,0.11),0_4px_16px_rgba(0,0,0,0.06)]">
                    <div class="flex items-center justify-between border-b border-slate-200 bg-slate-50 px-3.5 py-2.5">
                        <div class="flex items-center gap-1.5">
                            <div class="size-[7px] shrink-0 rounded-full bg-[#3EECFF]"></div>
                            <span class="text-[11px] font-normal text-slate-600">Mail Domains</span>
                        </div>
                        <div class="font-mono text-[9.5px] font-light tracking-wide text-slate-400">cloud.velinexlabs.com</div>
                    </div>
                    <div class="p-3.5">
                        <div class="mb-3.5 grid grid-cols-3 gap-2">
                            <div class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5">
                                <div class="text-xl font-normal leading-none text-slate-900">12</div>
                                <div class="mt-0.5 text-[9.5px] font-light uppercase tracking-wide text-slate-400">Domains</div>
                            </div>
                            <div class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5">
                                <div class="text-xl font-normal leading-none text-emerald-600">9</div>
                                <div class="mt-0.5 text-[9.5px] font-light uppercase tracking-wide text-slate-400">Verified</div>
                            </div>
                            <div class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5">
                                <div class="text-xl font-normal leading-none text-slate-900">48</div>
                                <div class="mt-0.5 text-[9.5px] font-light uppercase tracking-wide text-slate-400">Mailboxes</div>
                            </div>
                        </div>
                        <table class="w-full border-collapse text-left text-[11.5px] font-light text-slate-600">
                            <thead>
                                <tr class="border-b border-slate-200">
                                    <th class="px-2 py-1.5 text-[9px] font-light uppercase tracking-[0.12em] text-slate-400">Domain</th>
                                    <th class="px-2 py-1.5 text-[9px] font-light uppercase tracking-[0.12em] text-slate-400">Status</th>
                                    <th class="px-2 py-1.5 text-[9px] font-light uppercase tracking-[0.12em] text-slate-400">DNS</th>
                                    <th class="px-2 py-1.5 text-[9px] font-light uppercase tracking-[0.12em] text-slate-400">Mail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $rows = [['acme.co.ke','verified','7','12'],['runfast.io','verified','7','6'],['buildlabs.dev','pending','3','0'],['skyline.co.ke','verified','7','9']]; @endphp
                                @foreach($rows as $r)
                                    <tr class="border-b border-slate-100 transition-colors last:border-b-0 hover:bg-slate-50">
                                        <td class="px-2 py-2 font-mono text-[11px] font-normal text-slate-900">{{ $r[0] }}</td>
                                        <td class="px-2 py-2">
                                            <span class="inline-flex items-center gap-0.5 rounded-full px-1.5 py-0.5 text-[9.5px] font-normal {{ $r[1] === 'verified' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                                <span class="size-1 rounded-full bg-current"></span>{{ $r[1] }}
                                            </span>
                                        </td>
                                        <td class="px-2 py-2">{{ $r[2] }}</td>
                                        <td class="px-2 py-2">{{ $r[3] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Mailboxes chip — bottom-right, outside tilt --}}
            <div class="relative z-20 mt-3 flex items-center gap-2.5 rounded-[10px] border border-slate-200/90 bg-white p-2.5 pl-3.5 shadow-md md:absolute md:bottom-2 md:right-0 md:mt-0 md:whitespace-nowrap md:shadow-[0_8px_24px_rgba(15,23,42,0.08)] lg:-right-2">
                <div class="flex size-7 shrink-0 items-center justify-center rounded-md bg-cyan-50 text-cyan-600">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <div>
                    <div class="text-sm font-normal text-slate-900">48 active</div>
                    <div class="text-[9.5px] font-light uppercase tracking-[0.06em] text-slate-400">Mailboxes</div>
                </div>
            </div>
        </div>
    </div>
</section>
