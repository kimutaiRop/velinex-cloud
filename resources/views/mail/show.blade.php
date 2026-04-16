@extends('layouts.app')

@section('title', $domain->domain . ' Setup')
@section('crumb', 'Mail / Domains')
@section('page-title', 'DNS Setup')

@section('topbar-actions')
    <a href="{{ route('mail.domains.index') }}" class="btn btn-ghost">
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
            <div class="domain-hero-meta">Client: {{ $domain->client->name }} &nbsp;·&nbsp; Added {{ $domain->created_at->format('d M Y') }}</div>
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
                                <span class="mono" style="font-size: 12px; color: var(--text);">{{ $record->host ?: '@' }}</span>
                            </td>
                            <td>
                                <span class="mono-value" title="{{ $record->value }}">{{ $record->value }}</span>
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
        <div class="card-body" style="padding-bottom: 0;">
            <div class="section-header">
                <span class="section-title">Mailboxes</span>
                <span style="font-size: 12px; color: var(--text-muted);">{{ $mailboxes->count() }} accounts</span>
            </div>
        </div>

        @if($domain->status !== 'verified')
            <div style="padding: 20px; border-top: 1px solid var(--border); display: flex; align-items: center; gap: 10px; font-size: 13px; color: var(--warning);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;flex-shrink:0;">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                Verify DNS propagation first to enable mailbox provisioning.
            </div>
        @else
            {{-- Create Mailbox Form --}}
            <form method="post" action="{{ route('mail.mailboxes.store', $domain) }}">
                @csrf
                <div class="mailbox-form">
                    <div class="form-group">
                        <label class="form-label">Local Part</label>
                        <div class="email-compose">
                            <input name="local_part" type="text" placeholder="username" required class="form-input" style="font-family:'DM Mono',monospace; border-radius: 8px 0 0 8px;">
                            <span class="email-at">@</span>
                            <span class="email-domain-suffix">{{ $domain->domain }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Display Name</label>
                        <input name="display_name" type="text" placeholder="Full Name" required class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input name="password" type="password" placeholder="Secure password" required class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Quota (MB)</label>
                        <input name="quota_mb" type="number" min="128" value="1024" required class="form-input">
                    </div>
                    <div class="form-group" style="align-self: end;">
                        <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; height: 38px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            Create
                        </button>
                    </div>
                </div>
            </form>
        @endif

        @if($mailboxes->isNotEmpty())
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Quota (MB)</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mailboxes as $mailbox)
                            <tr>
                                <td>
                                    <span class="mono" style="font-size: 13px; color: var(--text);">{{ $mailbox->email }}</span>
                                </td>
                                <td class="mono" style="color: var(--text-muted);">{{ number_format($mailbox->quota_mb) }}</td>
                                <td>
                                    @if($mailbox->active)
                                        <span class="badge badge-active"><span class="badge-dot"></span> active</span>
                                    @else
                                        <span class="badge badge-suspended"><span class="badge-dot"></span> suspended</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-row">
                                        <form method="post" action="{{ route('mail.mailboxes.toggle', $mailbox) }}">
                                            @csrf
                                            <button type="submit" class="{{ $mailbox->active ? 'btn btn-danger-ghost' : 'btn btn-ghost' }}">
                                                {{ $mailbox->active ? 'Suspend' : 'Activate' }}
                                            </button>
                                        </form>
                                        <form method="post" action="{{ route('mail.mailboxes.password', $mailbox) }}" class="inline-password-form">
                                            @csrf
                                            <input type="password" name="password" placeholder="New password" required class="form-input" style="width:140px;font-size:12px;padding:5px 10px;border-radius:6px;">
                                            <button type="submit" class="btn btn-ghost">Update</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>{{-- close .table-wrap --}}
        @elseif($domain->status === 'verified')
            <div class="empty-state" style="border-top: 1px solid var(--border);">
                <div class="empty-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
                <h3>No mailboxes yet</h3>
                <p>Use the form above to create the first mailbox for this domain.</p>
            </div>
        @endif
    </div>{{-- close .card --}}

@endsection
