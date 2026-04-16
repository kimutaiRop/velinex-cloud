<section class="relative overflow-hidden bg-gradient-to-br from-white via-slate-50 to-cyan-50 py-16 md:py-20">
    <div class="pointer-events-none absolute -right-28 -top-28 h-[28rem] w-[28rem] rounded-full border border-cyan-200/70"></div>
    <div class="pointer-events-none absolute -right-12 -top-12 h-80 w-80 rounded-full border border-cyan-100"></div>
    <div class="mx-auto grid max-w-6xl gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:gap-14 lg:px-8">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-cyan-200 bg-cyan-50 px-3 py-1 text-xs font-medium text-cyan-700">
                <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-cyan-500"></span>
                Enterprise infrastructure
            </div>
            <h1 class="mt-5 text-4xl font-medium leading-tight tracking-tight text-slate-900 md:text-5xl">
                Web hosting and<br>
                business email that<br>
                <strong class="text-[#19C7DC]">just works.</strong>
            </h1>
            <p class="mt-5 max-w-md text-sm leading-7 text-slate-600 md:text-base">
                Production-grade hosting and self-hosted email built for teams that need reliability, deliverability, and full control over their infrastructure.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('auth.register') }}" class="inline-flex items-center gap-2 rounded-md bg-[#3EECFF] px-5 py-2.5 text-sm font-medium text-cyan-950 transition hover:bg-[#19C7DC]">
                    Start for free
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="#services" class="inline-flex items-center rounded-md border border-slate-300 px-5 py-2.5 text-sm font-light text-slate-700 transition hover:border-cyan-300 hover:bg-cyan-50 hover:text-cyan-700">View services</a>
            </div>
            <div class="mt-8 flex items-center gap-4 border-t border-slate-200 pt-5">
                <div class="flex">
                    <div class="-ml-2 flex h-7 w-7 items-center justify-center rounded-full border-2 border-white bg-[#3EECFF] text-[9px] font-medium text-cyan-950 first:ml-0">AK</div>
                    <div class="-ml-2 flex h-7 w-7 items-center justify-center rounded-full border-2 border-white bg-violet-600 text-[9px] font-medium text-white">SM</div>
                    <div class="-ml-2 flex h-7 w-7 items-center justify-center rounded-full border-2 border-white bg-emerald-600 text-[9px] font-medium text-white">JN</div>
                    <div class="-ml-2 flex h-7 w-7 items-center justify-center rounded-full border-2 border-white bg-amber-500 text-[9px] font-medium text-white">RO</div>
                </div>
                <div class="text-xs text-slate-500">
                    Trusted by <strong class="font-medium text-slate-700">40+ businesses</strong> across East Africa
                </div>
            </div>
        </div>

        <div class="relative">
            <div class="absolute -left-1 top-3 z-10 flex items-center gap-2 rounded-lg border border-slate-200 bg-white p-3 shadow">
                <div class="flex h-7 w-7 items-center justify-center rounded-md bg-emerald-50 text-emerald-600">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-slate-900">99.97%</div>
                    <div class="text-[10px] uppercase tracking-wide text-slate-400">Uptime SLA</div>
                </div>
            </div>
            <div class="relative rounded-xl border border-slate-200 bg-white p-3 shadow-xl">
                <div class="flex items-center justify-between rounded-md border border-slate-200 bg-slate-50 px-3 py-2">
                    <div class="flex items-center gap-2">
                        <div class="h-2 w-2 rounded-full bg-[#3EECFF]"></div>
                        <span class="text-xs text-slate-600">Mail Domains</span>
                    </div>
                    <div class="font-mono text-[10px] text-slate-400">cloud.velinexlabs.com</div>
                </div>
                <div class="mt-3 grid grid-cols-3 gap-2">
                    <div class="rounded-md border border-slate-200 bg-slate-50 p-3">
                        <div class="text-lg font-medium text-slate-900">12</div>
                        <div class="text-[10px] uppercase tracking-wide text-slate-400">Domains</div>
                    </div>
                    <div class="rounded-md border border-slate-200 bg-slate-50 p-3">
                        <div class="text-lg font-medium text-emerald-600">9</div>
                        <div class="text-[10px] uppercase tracking-wide text-slate-400">Verified</div>
                    </div>
                    <div class="rounded-md border border-slate-200 bg-slate-50 p-3">
                        <div class="text-lg font-medium text-slate-900">48</div>
                        <div class="text-[10px] uppercase tracking-wide text-slate-400">Mailboxes</div>
                    </div>
                </div>
                <table class="mt-3 w-full border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 text-[10px] uppercase tracking-widest text-slate-400">
                            <th class="px-2 py-2 text-left font-normal">Domain</th>
                            <th class="px-2 py-2 text-left font-normal">Status</th>
                            <th class="px-2 py-2 text-left font-normal">DNS</th>
                            <th class="px-2 py-2 text-left font-normal">Mail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $rows = [['acme.co.ke','verified','7','12'],['runfast.io','verified','7','6'],['buildlabs.dev','pending','3','0'],['skyline.co.ke','verified','7','9']]; @endphp
                        @foreach($rows as $r)
                        <tr class="border-b border-slate-100 text-slate-600 last:border-b-0">
                            <td class="px-2 py-2 font-mono text-[11px] text-slate-800">{{ $r[0] }}</td>
                            <td class="px-2 py-2">
                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] {{ $r[1] === 'verified' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                    <span class="h-1 w-1 rounded-full bg-current"></span>{{ $r[1] }}
                                </span>
                            </td>
                            <td class="px-2 py-2">{{ $r[2] }}</td>
                            <td class="px-2 py-2">{{ $r[3] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3 inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 shadow">
                <div class="flex h-7 w-7 items-center justify-center rounded-md bg-cyan-50 text-cyan-600">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-slate-900">48 active</div>
                    <div class="text-[10px] uppercase tracking-wide text-slate-400">Mailboxes</div>
                </div>
            </div>
        </div>
    </div>
</section>
