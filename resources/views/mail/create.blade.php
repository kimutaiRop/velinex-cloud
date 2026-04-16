@extends('layouts.app')

@section('title', 'Add Domain')
@section('crumb', 'Mail / Domains')
@section('page-title', 'Register Domain')

@section('topbar-actions')
    <a href="{{ route('mail.dashboard') }}" class="btn btn-ghost">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
        </svg>
        Back
    </a>
@endsection

@section('content')

    <div style="max-width: 520px;">

        @if($errors->any())
            <div class="alert alert-error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 22px; line-height: 1.6;">
                    Enter the domain you want to onboard. We'll generate all required DNS records —
                    <span class="mono" style="color: var(--accent);">SPF</span>,
                    <span class="mono" style="color: var(--purple);">DKIM</span>,
                    <span class="mono" style="color: var(--danger);">DMARC</span>, and
                    <span class="mono" style="color: #A78BFA;">MX</span> —
                    ready to configure at your registrar.
                </p>

                <form method="post" action="{{ route('mail.domains.store') }}">
                    @csrf
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="mail_plan_id" class="form-label">Mail Plan</label>
                        <select id="mail_plan_id" name="mail_plan_id" required class="form-input" style="font-size: 15px; padding: 11px 14px;">
                            <option value="">Select plan</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" @selected((string) old('mail_plan_id', $plans->firstWhere('is_featured', true)?->id) === (string) $plan->id)>
                                    {{ $plan->name }} — {{ $plan->price_label }}/year
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="domain" class="form-label">Domain Name</label>
                        <input
                            id="domain"
                            name="domain"
                            type="text"
                            placeholder="example.com"
                            value="{{ old('domain') }}"
                            required
                            autofocus
                            class="form-input"
                            style="font-size: 15px; padding: 11px 14px;"
                        >
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 10px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Create Domain Setup
                    </button>
                </form>
            </div>

            <div style="padding: 14px 20px; border-top: 1px solid var(--border); display: flex; gap: 20px;">
                <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted);">
                    <span class="dns-chip dns-SPF">SPF</span> auto-generated
                </div>
                <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted);">
                    <span class="dns-chip dns-DKIM">DKIM</span> auto-generated
                </div>
                <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted);">
                    <span class="dns-chip dns-DMARC">DMARC</span> auto-generated
                </div>
                <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted);">
                    <span class="dns-chip dns-MX">MX</span> auto-generated
                </div>
            </div>
        </div>

    </div>

@endsection
