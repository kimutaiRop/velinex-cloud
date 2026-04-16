@extends('layouts.app')

@section('title', 'Add Domain')
@section('crumb', 'Mail / Domains')
@section('page-title', 'Register Domain')

@section('topbar-actions')
    <x-ui.button variant="ghost" href="{{ route('mail.dashboard') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
        </svg>
        Back
    </x-ui.button>
@endsection

@section('content')
    <div class="max-w-[520px]">
        @if($errors->any())
            <x-ui.alert variant="error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </x-ui.alert>
        @endif

        <x-ui.card flush>
            <div class="p-5">
                <p class="mb-6 text-[13px] leading-relaxed text-muted">
                    Enter the domain you want to onboard. We'll generate all required DNS records —
                    <span class="font-mono text-accent">SPF</span>,
                    <span class="font-mono text-purple">DKIM</span>,
                    <span class="font-mono text-danger">DMARC</span>, and
                    <span class="font-mono text-[#A78BFA]">MX</span> —
                    ready to configure at your registrar.
                </p>

                <form method="post" action="{{ route('mail.domains.store') }}">
                    @csrf
                    <div class="mb-5">
                        <label for="mail_plan_id" class="mb-1.5 block font-mono text-[9.5px] uppercase tracking-[0.16em] text-muted">Mail Plan</label>
                        <select id="mail_plan_id" name="mail_plan_id" required
                                class="w-full rounded-lg border border-border-strong bg-background px-3.5 py-2.5 font-mono text-[15px] text-foreground focus:border-accent focus:outline-none focus:ring-[3px] focus:ring-accent-muted">
                            <option value="">Select plan</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" @selected((string) old('mail_plan_id', $plans->firstWhere('is_featured', true)?->id) === (string) $plan->id)>
                                    {{ $plan->name }} — {{ $plan->price_label }}/year
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <x-ui.field
                        label="Domain Name"
                        name="domain"
                        class="mb-5"
                        inputClass="!px-3.5 !py-2.5 !text-[15px]"
                        value="{{ old('domain') }}"
                        placeholder="example.com"
                        required
                        autofocus
                    />

                    <x-ui.button variant="primary" type="submit" class="!w-full !justify-center !py-2.5">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Create Domain Setup
                    </x-ui.button>
                </form>
            </div>

            <div class="flex flex-wrap gap-5 border-t border-border px-5 py-3.5">
                @foreach (['SPF', 'DKIM', 'DMARC', 'MX'] as $t)
                    <div class="flex items-center gap-2 text-xs text-muted">
                        <x-ui.dns-chip :type="$t" /> auto-generated
                    </div>
                @endforeach
            </div>
        </x-ui.card>
    </div>
@endsection
