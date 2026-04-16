@extends('layouts.app')

@section('title', 'Manage Domains')
@section('crumb', 'Mail / Domains')
@section('page-title', 'All Domains')

@section('topbar-actions')
    <x-ui.button variant="ghost" href="{{ route('mail.dashboard') }}">Dashboard</x-ui.button>
    <x-ui.button variant="primary" href="{{ route('mail.domains.create') }}">Add Domain</x-ui.button>
@endsection

@section('content')
    <x-ui.card flush>
        <div class="border-b border-border p-5 pb-0">
            <x-ui.section-heading title="Domain Management">
                <x-slot name="aside">{{ $domains->count() }} total</x-slot>
            </x-ui.section-heading>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b border-border">
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Domain</th>
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Plan</th>
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Status</th>
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Mailboxes</th>
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($domains as $domain)
                        <tr class="border-b border-border transition-colors last:border-0 hover:bg-hover">
                            <td class="px-4 py-[11px] align-middle font-mono text-[13px] text-foreground">{{ $domain->domain }}</td>
                            <td class="px-4 py-[11px] align-middle text-[13px] text-foreground">{{ $domain->mailPlan?->name ?? 'Unassigned' }}</td>
                            <td class="px-4 py-[11px] align-middle text-[13px]">
                                @if($domain->status === 'verified')
                                    <x-ui.badge variant="verified">verified</x-ui.badge>
                                @elseif($domain->status === 'disabled')
                                    <x-ui.badge variant="fail">disabled</x-ui.badge>
                                @else
                                    <x-ui.badge variant="pending">pending</x-ui.badge>
                                @endif
                            </td>
                            <td class="px-4 py-[11px] align-middle text-[13px] text-foreground">{{ $domain->mailboxes->count() }}</td>
                            <td class="px-4 py-[11px] align-middle text-[13px]">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <x-ui.button variant="outline" href="{{ route('mail.domains.show', $domain) }}">DNS</x-ui.button>
                                    <x-ui.button variant="ghost" href="{{ route('mail.domains.mailboxes', $domain) }}">Email</x-ui.button>
                                    <form method="post" action="{{ route('mail.domains.plan', $domain) }}" class="flex items-center gap-1.5">
                                        @csrf
                                        <select name="mail_plan_id" class="h-8 w-[130px] rounded-lg border border-border-strong bg-background px-2 py-1 font-mono text-xs text-foreground focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent-muted">
                                            @foreach($plans as $plan)
                                                <option value="{{ $plan->id }}" @selected($domain->mail_plan_id === $plan->id)>{{ $plan->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-ui.button variant="outline" type="submit">Update Plan</x-ui.button>
                                    </form>
                                    <form method="post" action="{{ route('mail.domains.toggle', $domain) }}">
                                        @csrf
                                        <x-ui.button variant="ghost" type="submit">{{ $domain->status === 'disabled' ? 'Enable' : 'Disable' }}</x-ui.button>
                                    </form>
                                    <form method="post" action="{{ route('mail.domains.destroy', $domain) }}" onsubmit="return confirm('Delete this domain?');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="force_delete" value="{{ $domain->mailboxes->isNotEmpty() ? 1 : 0 }}">
                                        <x-ui.button variant="danger-ghost" type="submit">Delete</x-ui.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-5 text-[13px] text-muted">No domains found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.card>
@endsection
