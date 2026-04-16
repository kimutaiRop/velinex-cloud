@extends('layouts.app')

@section('title', $domain->domain . ' Setup')
@section('crumb', 'Mail / Domains')
@section('page-title', 'DNS Setup')

@section('topbar-actions')
    <x-ui.button variant="ghost" href="{{ route('mail.domains.manage') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
        </svg>
        All Domains
    </x-ui.button>
    <form method="post" action="{{ route('mail.domains.verify', $domain) }}" class="inline">
        @csrf
        <x-ui.button variant="outline" type="submit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            Verify DNS
        </x-ui.button>
    </form>
    @if($domain->status === 'verified')
        <x-ui.button variant="primary" href="{{ route('mail.domains.mailboxes', $domain) }}">Manage Email</x-ui.button>
    @endif
@endsection

@section('content')

    <div class="relative mb-6 flex flex-wrap items-start justify-between gap-4 overflow-hidden rounded-[var(--radius-shell-lg)] border border-border bg-card p-5 md:p-6">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-accent to-transparent opacity-40"></div>
        <div>
            <div class="flex flex-wrap items-center gap-2.5 font-mono text-lg font-medium text-foreground">
                <svg class="h-[18px] w-[18px] shrink-0 text-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/>
                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                </svg>
                {{ $domain->domain }}
                @if($domain->status === 'verified')
                    <x-ui.badge variant="verified">verified</x-ui.badge>
                @else
                    <x-ui.badge variant="pending">pending</x-ui.badge>
                @endif
            </div>
            <div class="mt-1.5 font-mono text-xs text-muted">
                Client: {{ $domain->client->name }}
                &nbsp;·&nbsp; Plan: {{ $domain->mailPlan?->name ?? 'Unassigned' }}
                &nbsp;·&nbsp; Added {{ $domain->created_at->format('d M Y') }}
            </div>
        </div>

        @if($domain->status !== 'verified')
            <div class="max-w-[280px] rounded-lg border border-[rgba(255,176,32,0.18)] bg-warning-muted px-3.5 py-2.5 text-xs leading-relaxed text-warning">
                <strong>Action required:</strong> Add the DNS records below to your registrar, then click Verify DNS.
            </div>
        @endif
    </div>

    <x-ui.card flush class="mb-6">
        <div class="border-b border-border p-5 pb-0">
            <x-ui.section-heading title="Required DNS Records">
                <x-slot name="aside">{{ $domain->dnsRecords->count() }} records</x-slot>
            </x-ui.section-heading>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b border-border">
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Type</th>
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Host / Name</th>
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Value</th>
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Priority</th>
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">TTL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($domain->dnsRecords as $record)
                        <tr class="border-b border-border transition-colors last:border-0 hover:bg-hover">
                            <td class="px-4 py-[11px] align-middle text-[13px]">
                                <x-ui.dns-chip :type="$record->type" />
                            </td>
                            <td class="px-4 py-[11px] align-middle text-[13px]">
                                <div class="flex items-center gap-2">
                                    <span class="copyable-field cursor-pointer font-mono text-xs text-foreground" data-copy-value="{{ $record->host ?: '@' }}" title="Double-click to expand">{{ $record->host ?: '@' }}</span>
                                    <x-ui.button variant="ghost" size="icon" type="button" class="copy-btn" data-copy-value="{{ $record->host ?: '@' }}" aria-label="Copy host" title="Copy host">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                        </svg>
                                    </x-ui.button>
                                </div>
                            </td>
                            <td class="px-4 py-[11px] align-middle text-[13px]">
                                <div class="flex items-center gap-2">
                                    <span class="copyable-field mono-value block max-w-[300px] cursor-pointer truncate font-mono text-[11.5px] text-muted" data-copy-value="{{ $record->value }}" title="{{ $record->value }}&#10;Double-click to expand">{{ $record->value }}</span>
                                    <x-ui.button variant="ghost" size="icon" type="button" class="copy-btn shrink-0" data-copy-value="{{ $record->value }}" aria-label="Copy value" title="Copy value">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                        </svg>
                                    </x-ui.button>
                                </div>
                            </td>
                            <td class="px-4 py-[11px] font-mono text-[13px] text-muted">{{ $record->priority ?? '—' }}</td>
                            <td class="px-4 py-[11px] font-mono text-[13px] text-muted">{{ $record->ttl }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-ui.card>

    @if(!empty($verificationResults))
        <x-ui.card flush class="mb-6">
            <div class="border-b border-border p-5 pb-0">
                <x-ui.section-heading title="Latest Verification">
                    <x-slot name="aside">
                        @php
                            $passed = collect($verificationResults)->where('valid', true)->count();
                            $total  = count($verificationResults);
                        @endphp
                        {{ $passed }}/{{ $total }} passing
                    </x-slot>
                </x-ui.section-heading>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-border">
                            <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Type</th>
                            <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Host</th>
                            <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Expected Value</th>
                            <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($verificationResults as $result)
                            <tr class="border-b border-border transition-colors last:border-0 hover:bg-hover">
                                <td class="px-4 py-[11px]"><x-ui.dns-chip :type="$result['type']" /></td>
                                <td class="px-4 py-[11px] font-mono text-xs">{{ $result['host'] }}</td>
                                <td class="px-4 py-[11px] font-mono text-[11.5px] text-muted" title="{{ $result['expected'] }}">{{ $result['expected'] }}</td>
                                <td class="px-4 py-[11px]">
                                    @if($result['valid'])
                                        <x-ui.badge variant="pass">
                                            <svg class="h-2.5 w-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                            pass
                                        </x-ui.badge>
                                    @else
                                        <x-ui.badge variant="fail">
                                            <svg class="h-2.5 w-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                            missing
                                        </x-ui.badge>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-ui.card>
    @endif

    <x-ui.card>
        <x-ui.section-heading title="Domain Operations">
            <x-slot name="aside">{{ $mailboxes->count() }} accounts</x-slot>
        </x-ui.section-heading>
        <p class="mb-4 text-[13px] text-muted">Mailbox lifecycle management now has a dedicated page for this domain.</p>
        <div class="flex flex-wrap items-center gap-1.5">
            @if($domain->status === 'verified')
                <x-ui.button variant="primary" href="{{ route('mail.domains.mailboxes', $domain) }}">Open Email Management</x-ui.button>
            @else
                <div class="rounded-lg border border-border px-3.5 py-2 text-[12px] text-muted">
                    Verify DNS to unlock email management.
                </div>
            @endif
            <form method="post" action="{{ route('mail.domains.toggle', $domain) }}">
                @csrf
                <x-ui.button variant="ghost" type="submit">{{ $domain->status === 'disabled' ? 'Enable Domain' : 'Disable Domain' }}</x-ui.button>
            </form>
            <form method="post" action="{{ route('mail.domains.destroy', $domain) }}" onsubmit="return confirm('Delete this domain?');">
                @csrf
                @method('DELETE')
                <input type="hidden" name="force_delete" value="{{ $mailboxes->isNotEmpty() ? 1 : 0 }}">
                <x-ui.button variant="danger-ghost" type="submit">Delete Domain</x-ui.button>
            </form>
        </div>
    </x-ui.card>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const copyExpandClass = 'w-full min-w-[230px] max-w-[560px] rounded-md border border-border-strong bg-card px-2 py-1.5 font-mono text-[11.5px] leading-snug text-foreground outline-none focus:border-accent focus:ring-2 focus:ring-accent-muted';

    document.querySelectorAll('.copy-btn').forEach((button) => {
        button.addEventListener('click', async () => {
            const textToCopy = button.getAttribute('data-copy-value') || '';
            const iconMarkup = button.innerHTML;
            try {
                await navigator.clipboard.writeText(textToCopy);
                button.innerHTML = 'Copied';
            } catch (error) {
                const fallback = document.createElement('textarea');
                fallback.value = textToCopy;
                document.body.appendChild(fallback);
                fallback.select();
                document.execCommand('copy');
                document.body.removeChild(fallback);
                button.innerHTML = 'Copied';
            }
            setTimeout(() => { button.innerHTML = iconMarkup; }, 1200);
        });
    });

    document.querySelectorAll('.copyable-field').forEach((field) => {
        field.addEventListener('dblclick', () => {
            const value = field.getAttribute('data-copy-value') || field.textContent.trim();
            const input = document.createElement('input');
            input.type = 'text';
            input.className = copyExpandClass;
            input.value = value;
            input.readOnly = true;
            const closeEditor = () => {
                if (input.parentNode) input.parentNode.replaceChild(field, input);
            };
            input.addEventListener('blur', closeEditor);
            input.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' || event.key === 'Enter') {
                    event.preventDefault();
                    closeEditor();
                }
            });
            field.parentNode.replaceChild(input, field);
            input.focus();
            input.select();
        });
    });
});
</script>
@endpush
