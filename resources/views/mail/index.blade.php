@extends('layouts.app')

@section('title', 'Dashboard')
@section('crumb', 'Mail')
@section('page-title', 'Domain Dashboard')

@section('topbar-actions')
    <a href="{{ route('mail.domains.create') }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Add Domain
    </a>
@endsection

@section('content')

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card" style="--s-accent: var(--accent); --s-glow: rgba(0,229,255,0.08);">
            <div class="stat-glow"></div>
            <div class="stat-icon" style="background: var(--accent-dim); color: var(--accent);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                </svg>
            </div>
            <div class="stat-value">{{ $domains->count() }}</div>
            <div class="stat-label">Total Domains</div>
        </div>

        <div class="stat-card" style="--s-accent: var(--success); --s-glow: rgba(0,229,153,0.08);">
            <div class="stat-glow"></div>
            <div class="stat-icon" style="background: var(--success-dim); color: var(--success);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div class="stat-value">{{ $domains->where('status', 'verified')->count() }}</div>
            <div class="stat-label">Verified</div>
        </div>

        <div class="stat-card" style="--s-accent: var(--warning); --s-glow: rgba(255,176,32,0.08);">
            <div class="stat-glow"></div>
            <div class="stat-icon" style="background: var(--warning-dim); color: var(--warning);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <div class="stat-value">{{ $domains->where('status', 'pending')->count() }}</div>
            <div class="stat-label">Pending DNS</div>
        </div>

        <div class="stat-card" style="--s-accent: var(--purple); --s-glow: rgba(167,139,250,0.08);">
            <div class="stat-glow"></div>
            <div class="stat-icon" style="background: var(--purple-dim); color: var(--purple);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                </svg>
            </div>
            <div class="stat-value">{{ $domains->sum(fn($d) => $d->mailboxes_count ?? $d->mailboxes->count()) }}</div>
            <div class="stat-label">Mailboxes</div>
        </div>
    </div>

    {{-- Domains Table --}}
    <div class="card">
        <div class="card-body" style="padding-bottom: 0;">
            <div class="section-header">
                <span class="section-title">All Domains</span>
            </div>
        </div>

        @if($domains->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                </div>
                <h3>No domains yet</h3>
                <p>Register your first domain to generate DNS records and provision mailboxes.</p>
                <a href="{{ route('mail.domains.create') }}" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Add Domain
                </a>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Domain</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>DNS Records</th>
                            <th>Mailboxes</th>
                            <th>Added</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($domains as $domain)
                            <tr>
                                <td>
                                    <span class="mono" style="font-size: 13px; color: var(--text);">{{ $domain->domain }}</span>
                                </td>
                                <td style="color: var(--text-muted);">{{ $domain->client->name }}</td>
                                <td>
                                    @if($domain->status === 'verified')
                                        <span class="badge badge-verified">
                                            <span class="badge-dot"></span> verified
                                        </span>
                                    @else
                                        <span class="badge badge-pending">
                                            <span class="badge-dot"></span> pending
                                        </span>
                                    @endif
                                </td>
                                <td style="color: var(--text-muted);">{{ $domain->dnsRecords->count() }}</td>
                                <td style="color: var(--text-muted);">{{ $domain->mailboxes->count() }}</td>
                                <td style="color: var(--text-muted);" class="mono">{{ $domain->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('mail.domains.show', $domain) }}" class="btn btn-outline" style="font-size: 12px; padding: 5px 12px;">
                                        View Setup
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;">
                                            <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection
