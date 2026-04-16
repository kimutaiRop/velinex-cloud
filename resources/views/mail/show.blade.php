@extends('layouts.app')

@section('title', $domain->domain . ' Setup')
@section('crumb', 'Mail / Domains')
@section('page-title', 'DNS Setup')

@section('topbar-actions')
    <a href="{{ route('mail.domains.manage') }}" class="btn btn-ghost">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
        </svg>
        All Domains
    </a>
    <form method="post" action="{{ route('mail.domains.verify', $domain) }}" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-outline">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            Verify DNS
        </button>
    </form>
    <a href="{{ route('mail.domains.mailboxes', $domain) }}" class="btn btn-primary">Manage Email</a>
@endsection

@section('content')

    {{-- Domain Hero --}}
    <div class="domain-hero">
        <div>
            <div class="domain-hero-name">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;color:var(--accent);">
                    <circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/>
                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                </svg>
                {{ $domain->domain }}
                @if($domain->status === 'verified')
                    <span class="badge badge-verified"><span class="badge-dot"></span> verified</span>
                @else
                    <span class="badge badge-pending"><span class="badge-dot"></span> pending</span>
                @endif
            </div>
            <div class="domain-hero-meta">
                Client: {{ $domain->client->name }}
                &nbsp;·&nbsp; Plan: {{ $domain->mailPlan?->name ?? 'Unassigned' }}
                &nbsp;·&nbsp; Added {{ $domain->created_at->format('d M Y') }}
            </div>
        </div>

        @if($domain->status !== 'verified')
            <div style="font-size: 12px; color: var(--warning); background: var(--warning-dim); border: 1px solid rgba(255,176,32,0.18); border-radius: 8px; padding: 10px 14px; max-width: 280px; line-height: 1.5;">
                <strong>Action required:</strong> Add the DNS records below to your registrar, then click Verify DNS.
            </div>
        @endif
    </div>

    {{-- DNS Records --}}
    <div class="card" style="margin-bottom: 22px;">
        <div class="card-body" style="padding-bottom: 0;">
            <div class="section-header">
                <span class="section-title">Required DNS Records</span>
                <span style="font-size: 12px; color: var(--text-muted);">{{ $domain->dnsRecords->count() }} records</span>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Host / Name</th>
                        <th>Value</th>
                        <th>Priority</th>
                        <th>TTL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($domain->dnsRecords as $record)
                        <tr>
                            <td>
                                <span class="dns-chip dns-{{ $record->type }}">{{ $record->type }}</span>
                            </td>
                            <td>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span class="mono copyable-field"
                                          data-copy-value="{{ $record->host ?: '@' }}"
                                          title="Double-click to expand"
                                          style="font-size: 12px; color: var(--text); cursor: pointer;">{{ $record->host ?: '@' }}</span>
                                    <button type="button"
                                            class="btn btn-ghost copy-btn copy-btn-icon"
                                            data-copy-value="{{ $record->host ?: '@' }}"
                                            aria-label="Copy host"
                                            title="Copy host">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span class="mono-value copyable-field"
                                          data-copy-value="{{ $record->value }}"
                                          title="{{ $record->value }}&#10;Double-click to expand"
                                          style="cursor: pointer;">{{ $record->value }}</span>
                                    <button type="button"
                                            class="btn btn-ghost copy-btn copy-btn-icon"
                                            data-copy-value="{{ $record->value }}"
                                            aria-label="Copy value"
                                            title="Copy value">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td class="mono" style="color: var(--text-muted);">{{ $record->priority ?? '—' }}</td>
                            <td class="mono" style="color: var(--text-muted);">{{ $record->ttl }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Verification Results --}}
    @if(!empty($verificationResults))
        <div class="card" style="margin-bottom: 22px;">
            <div class="card-body" style="padding-bottom: 0;">
                <div class="section-header">
                    <span class="section-title">Latest Verification</span>
                    @php
                        $passed = collect($verificationResults)->where('valid', true)->count();
                        $total  = count($verificationResults);
                    @endphp
                    <span style="font-size: 12px; color: var(--text-muted);">{{ $passed }}/{{ $total }} passing</span>
                </div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Host</th>
                            <th>Expected Value</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($verificationResults as $result)
                            <tr>
                                <td><span class="dns-chip dns-{{ $result['type'] }}">{{ $result['type'] }}</span></td>
                                <td><span class="mono" style="font-size: 12px;">{{ $result['host'] }}</span></td>
                                <td><span class="mono-value" title="{{ $result['expected'] }}">{{ $result['expected'] }}</span></td>
                                <td>
                                    @if($result['valid'])
                                        <span class="badge badge-pass">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:10px;height:10px;"><polyline points="20 6 9 17 4 12"/></svg>
                                            pass
                                        </span>
                                    @else
                                        <span class="badge badge-fail">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:10px;height:10px;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                            missing
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Mailboxes --}}
    <div class="card">
        <div class="card-body">
            <div class="section-header">
                <span class="section-title">Domain Operations</span>
                <span style="font-size: 12px; color: var(--text-muted);">{{ $mailboxes->count() }} accounts</span>
            </div>
            <p style="font-size:13px;color:var(--text-muted);margin-bottom:16px;">
                Mailbox lifecycle management now has a dedicated page for this domain.
            </p>
            <div class="action-row">
                <a href="{{ route('mail.domains.mailboxes', $domain) }}" class="btn btn-primary">Open Email Management</a>
                <form method="post" action="{{ route('mail.domains.toggle', $domain) }}">
                    @csrf
                    <button type="submit" class="btn btn-ghost">{{ $domain->status === 'disabled' ? 'Enable Domain' : 'Disable Domain' }}</button>
                </form>
                <form method="post" action="{{ route('mail.domains.destroy', $domain) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="force_delete" value="{{ $mailboxes->isNotEmpty() ? 1 : 0 }}">
                    <button type="submit" class="btn btn-danger-ghost">Delete Domain</button>
                </form>
            </div>
        </div>
    </div>{{-- close .card --}}

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const copyButtons = document.querySelectorAll('.copy-btn');
    const copyableFields = document.querySelectorAll('.copyable-field');

    copyButtons.forEach((button) => {
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

            setTimeout(() => {
                button.innerHTML = iconMarkup;
            }, 1200);
        });
    });

    copyableFields.forEach((field) => {
        field.addEventListener('dblclick', () => {
            const value = field.getAttribute('data-copy-value') || field.textContent.trim();
            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'copy-expand-input';
            input.value = value;
            input.readOnly = true;

            const closeEditor = () => {
                if (input.parentNode) {
                    input.parentNode.replaceChild(field, input);
                }
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
