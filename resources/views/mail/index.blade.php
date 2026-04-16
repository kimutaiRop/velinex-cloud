@extends('layouts.app')

@section('title', 'Mail Dashboard')
@section('crumb', 'Mail')
@section('page-title', 'Mail Dashboard')

@section('topbar-actions')
    <x-ui.button variant="primary" href="{{ route('mail.domains.create') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Add Domain
    </x-ui.button>
    <x-ui.button variant="outline" href="{{ route('mail.domains.manage') }}">Manage All Domains</x-ui.button>
@endsection

@section('content')

    @php
        $statWrap = 'relative overflow-hidden rounded-[var(--radius-shell-lg)] border border-border bg-card px-5 py-[18px] transition-all duration-200 hover:-translate-y-0.5 hover:border-border-strong before:pointer-events-none before:absolute before:inset-x-0 before:top-0 before:h-px before:bg-gradient-to-r before:from-transparent before:to-transparent before:opacity-45';
    @endphp

    <div class="mb-6 grid grid-cols-1 gap-3.5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="{{ $statWrap }} before:via-accent">
            <div class="pointer-events-none absolute -right-10 -top-10 h-[120px] w-[120px] rounded-full bg-[radial-gradient(ellipse,rgba(0,229,255,0.08)_0%,transparent_70%)]"></div>
            <div class="relative mb-3.5 flex h-[30px] w-[30px] items-center justify-center rounded-lg bg-accent-muted text-accent">
                <svg class="h-[15px] w-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                </svg>
            </div>
            <div class="relative mb-1 font-sans text-[28px] font-normal leading-none text-foreground">{{ $totalDomains }}</div>
            <div class="relative font-mono text-[9.5px] uppercase tracking-[0.18em] text-muted">Total Domains (All)</div>
        </div>

        <div class="{{ $statWrap }} before:via-success">
            <div class="pointer-events-none absolute -right-10 -top-10 h-[120px] w-[120px] rounded-full bg-[radial-gradient(ellipse,rgba(0,229,153,0.08)_0%,transparent_70%)]"></div>
            <div class="relative mb-3.5 flex h-[30px] w-[30px] items-center justify-center rounded-lg bg-success-muted text-success">
                <svg class="h-[15px] w-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div class="relative mb-1 font-sans text-[28px] font-normal leading-none text-foreground">{{ $domains->where('status', 'verified')->count() }}</div>
            <div class="relative font-mono text-[9.5px] uppercase tracking-[0.18em] text-muted">Verified</div>
        </div>

        <div class="{{ $statWrap }} before:via-warning">
            <div class="pointer-events-none absolute -right-10 -top-10 h-[120px] w-[120px] rounded-full bg-[radial-gradient(ellipse,rgba(255,176,32,0.08)_0%,transparent_70%)]"></div>
            <div class="relative mb-3.5 flex h-[30px] w-[30px] items-center justify-center rounded-lg bg-warning-muted text-warning">
                <svg class="h-[15px] w-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <div class="relative mb-1 font-sans text-[28px] font-normal leading-none text-foreground">{{ $domains->where('status', 'pending')->count() }}</div>
            <div class="relative font-mono text-[9.5px] uppercase tracking-[0.18em] text-muted">Pending DNS</div>
        </div>

        <div class="{{ $statWrap }} before:via-purple">
            <div class="pointer-events-none absolute -right-10 -top-10 h-[120px] w-[120px] rounded-full bg-[radial-gradient(ellipse,rgba(167,139,250,0.08)_0%,transparent_70%)]"></div>
            <div class="relative mb-3.5 flex h-[30px] w-[30px] items-center justify-center rounded-lg bg-purple-muted text-purple">
                <svg class="h-[15px] w-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                </svg>
            </div>
            <div class="relative mb-1 font-sans text-[28px] font-normal leading-none text-foreground">{{ $domains->sum(fn($d) => $d->mailboxes_count ?? $d->mailboxes->count()) }}</div>
            <div class="relative font-mono text-[9.5px] uppercase tracking-[0.18em] text-muted">Mailboxes</div>
        </div>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-3.5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([
            ['v' => $analyticsSummary['domains_sent_total'], 'l' => 'Domain Sent (Total)'],
            ['v' => $analyticsSummary['domains_received_total'], 'l' => 'Domain Received (Total)'],
            ['v' => $analyticsSummary['mailboxes_sent_total'], 'l' => 'Mailbox Sent (Total)'],
            ['v' => $analyticsSummary['mailboxes_received_total'], 'l' => 'Mailbox Received (Total)'],
        ] as $row)
            <div class="{{ $statWrap }} before:via-accent">
                <div class="relative mb-1 font-sans text-[28px] font-normal leading-none text-foreground">{{ $row['v'] }}</div>
                <div class="relative font-mono text-[9.5px] uppercase tracking-[0.18em] text-muted">{{ $row['l'] }}</div>
            </div>
        @endforeach
    </div>

    <x-ui.card flush class="mb-6">
        <div class="border-b border-border p-5 pb-0">
            <x-ui.section-heading title="Recent Domains (Last 5)" />
        </div>

        @if($domains->isEmpty())
            <div class="px-5 py-14 text-center">
                <div class="mx-auto mb-4 flex h-11 w-11 items-center justify-center rounded-xl border border-border-strong bg-hover text-muted">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                </div>
                <h3 class="mb-1.5 font-sans text-[15px] font-semibold text-foreground">No domains yet</h3>
                <p class="mx-auto mb-5 max-w-[260px] text-[13px] text-muted">Register your first domain to generate DNS records and provision mailboxes.</p>
                <x-ui.button variant="primary" href="{{ route('mail.domains.create') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Add Domain
                </x-ui.button>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-border">
                            <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Domain</th>
                            <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Client</th>
                            <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Status</th>
                            <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">DNS Records</th>
                            <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Mailboxes</th>
                            <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Added</th>
                            <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Analytics</th>
                            <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($domains as $domain)
                            <tr class="border-b border-border transition-colors last:border-0 hover:bg-hover">
                                <td class="px-4 py-[11px] align-middle text-[13px] text-foreground">
                                    <span class="font-mono text-[13px]">{{ $domain->domain }}</span>
                                </td>
                                <td class="px-4 py-[11px] align-middle text-[13px] text-muted">{{ $domain->client->name }}</td>
                                <td class="px-4 py-[11px] align-middle text-[13px]">
                                    @if($domain->status === 'verified')
                                        <x-ui.badge variant="verified">verified</x-ui.badge>
                                    @else
                                        <x-ui.badge variant="pending">pending</x-ui.badge>
                                    @endif
                                </td>
                                <td class="px-4 py-[11px] align-middle text-[13px] text-muted">{{ $domain->dnsRecords->count() }}</td>
                                <td class="px-4 py-[11px] align-middle text-[13px] text-muted">{{ $domain->mailboxes->count() }}</td>
                                <td class="px-4 py-[11px] align-middle font-mono text-[13px] text-muted">{{ $domain->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-[11px] align-middle font-mono text-[13px] text-muted">
                                    @php $metric = $analyticsByDomain->get($domain->id); @endphp
                                    {{ (int) ($metric->sent_total ?? 0) }} sent / {{ (int) ($metric->received_total ?? 0) }} recv
                                </td>
                                <td class="px-4 py-[11px] align-middle text-[13px]">
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        <x-ui.button variant="outline" href="{{ route('mail.domains.show', $domain) }}" class="!gap-1 !px-3 !py-1 !text-xs">
                                            View Setup
                                            <svg class="!h-3 !w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                                            </svg>
                                        </x-ui.button>
                                        <x-ui.button variant="ghost" href="{{ route('mail.domains.mailboxes', $domain) }}" class="!ml-1 !px-3 !py-1 !text-xs">Manage Email</x-ui.button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-ui.card>

@endsection
