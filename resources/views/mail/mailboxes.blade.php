@extends('layouts.app')

@section('title', $domain->domain . ' Email Management')
@section('crumb', 'Mail / Domains / Email')
@section('page-title', 'Manage Domain Email')

@section('topbar-actions')
    <x-ui.button variant="ghost" href="{{ route('mail.domains.manage') }}">All Domains</x-ui.button>
    <x-ui.button variant="outline" href="{{ route('mail.domains.show', $domain) }}">DNS Setup</x-ui.button>
@endsection

@section('content')
    <x-ui.card class="mb-5">
        <x-ui.section-heading :title="$domain->domain.' Mailbox Provisioning'">
            <x-slot name="aside">Plan: {{ $domain->mailPlan?->name ?? 'Unassigned' }}</x-slot>
        </x-ui.section-heading>

        @if(session('generated_mailbox_password'))
            <x-ui.alert variant="success">
                Generated credentials (shown once): <strong>{{ session('generated_mailbox_email') }}</strong>
                <span class="font-mono">{{ session('generated_mailbox_password') }}</span>
            </x-ui.alert>
        @endif

        @if($errors->has('domain_delete'))
            <x-ui.alert variant="error">{{ $errors->first('domain_delete') }}</x-ui.alert>
        @endif

        <form method="post" action="{{ route('mail.mailboxes.store', $domain) }}">
            @csrf
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-ui.field label="Local Part" name="local_part" placeholder="username" required />
                <x-ui.field label="Display Name" name="display_name" placeholder="Full Name" required />
                <div class="flex flex-col gap-1.5 sm:col-span-2">
                    <span class="font-mono text-[9.5px] uppercase tracking-[0.16em] text-muted">Password Mode</span>
                    <select name="password_mode" required class="w-full rounded-lg border border-border-strong bg-background px-3 py-2 font-mono text-[13px] text-foreground focus:border-accent focus:outline-none focus:ring-[3px] focus:ring-accent-muted">
                        <option value="manual">Admin sets password</option>
                        <option value="generated">Generate random password</option>
                        <option value="generated_email">Generate random + send to secondary email</option>
                    </select>
                </div>
                <x-ui.field label="Password (manual mode)" name="password" type="password" placeholder="Set manual password" />
                <x-ui.field label="Secondary Email (delivery mode)" name="secondary_email" type="email" placeholder="owner@example.com" />
                <x-ui.field
                    label="Quota (MB)"
                    name="quota_mb"
                    type="number"
                    value="{{ min(1024, (int) ($domain->mailPlan?->storage_mb ?? 1024)) }}"
                    min="128"
                    :max="$domain->mailPlan?->storage_mb ?? 1024"
                    required
                />
            </div>
            <p class="mb-3 text-[11px] text-muted">Plan limit per mailbox: {{ $domain->mailPlan?->storage_label ?? 'N/A' }}</p>
            <label class="mb-4 flex cursor-pointer items-center gap-2 text-xs text-muted">
                <input type="checkbox" name="require_initial_reset" value="1" class="rounded border-border-strong">
                Force user to reset password on first login
            </label>
            <x-ui.button variant="primary" type="submit" class="!w-full sm:!w-auto">Create Mailbox</x-ui.button>
        </form>
    </x-ui.card>

    <x-ui.card class="mb-5">
        <x-ui.section-heading title="Aliases & Forwarding" />

        @if($canManageRouting)
            <form method="post" action="{{ route('mail.aliases.store', $domain) }}" class="mb-4">
                @csrf
                <div class="grid grid-cols-1 items-end gap-2.5 sm:grid-cols-[1fr_1fr_auto]">
                    <x-ui.field label="Alias Local Part" name="alias_local_part" placeholder="sales" required />
                    <x-ui.field label="Destinations" name="destinations" placeholder="ceo@{{ $domain->domain }}, team@gmail.com" required />
                    <x-ui.button variant="primary" type="submit" class="!w-full sm:!w-auto">Create Alias</x-ui.button>
                </div>
            </form>

            <p class="mb-2 text-xs text-muted">Existing aliases</p>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-border">
                            <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Alias</th>
                            <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Destinations</th>
                            <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Status</th>
                            <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aliases as $alias)
                            <tr class="border-b border-border transition-colors last:border-0 hover:bg-hover">
                                <td class="px-4 py-[11px] font-mono text-[13px]">{{ $alias['address'] }}</td>
                                <td class="px-4 py-[11px] font-mono text-[13px]">{{ implode(', ', $alias['destinations']) }}</td>
                                <td class="px-4 py-[11px] text-[13px]">{{ $alias['active'] ? 'active' : 'disabled' }}</td>
                                <td class="px-4 py-[11px]">
                                    <form method="post" action="{{ route('mail.aliases.destroy', [$domain, $alias['address']]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.button variant="danger-ghost" type="submit">Remove</x-ui.button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-[13px] text-muted">No aliases configured for this domain yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <x-ui.alert variant="error" class="!mt-2">
                This domain plan does not include mail aliases & forwarding. Upgrade the domain plan to unlock these routing features.
            </x-ui.alert>
        @endif
    </x-ui.card>

    <x-ui.card flush>
        <div class="border-b border-border p-5 pb-0">
            <x-ui.section-heading title="Existing Mailboxes">
                <x-slot name="aside">{{ $mailboxes->count() }} total</x-slot>
            </x-ui.section-heading>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b border-border">
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Email</th>
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Mode</th>
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Delivery</th>
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Reset Required</th>
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Status</th>
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Forwarding</th>
                        <th class="whitespace-nowrap px-4 py-2.5 text-left font-mono text-[9px] font-normal uppercase tracking-[0.2em] text-muted">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mailboxes as $mailbox)
                        <tr class="border-b border-border transition-colors last:border-0 hover:bg-hover">
                            <td class="px-4 py-[11px] font-mono text-[13px]">{{ $mailbox->email }}</td>
                            <td class="px-4 py-[11px] text-[13px]">{{ $mailbox->password_mode }}</td>
                            <td class="px-4 py-[11px] text-[13px]">{{ $mailbox->password_delivery_status ?? 'n/a' }}</td>
                            <td class="px-4 py-[11px] text-[13px]">{{ $mailbox->require_initial_reset ? 'yes' : 'no' }}</td>
                            <td class="px-4 py-[11px] text-[13px]">{{ $mailbox->active ? 'active' : 'suspended' }}</td>
                            <td class="px-4 py-[11px] text-[13px]">
                                @if($canManageRouting)
                                    <form method="post" action="{{ route('mail.mailboxes.forwarding', $mailbox) }}" class="flex flex-wrap items-center gap-2">
                                        @csrf
                                        <input type="text" name="forward_to" placeholder="ops@gmail.com, team@other.com"
                                               class="w-[220px] rounded-lg border border-border-strong bg-background px-3 py-1.5 font-mono text-xs text-foreground focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent-muted"
                                               value="{{ implode(', ', $forwardingByMailbox[$mailbox->id] ?? []) }}">
                                        <label class="flex items-center gap-1.5 text-xs text-muted">
                                            <input type="checkbox" name="keep_copy" value="1" checked class="rounded border-border-strong">
                                            Keep local copy
                                        </label>
                                        <x-ui.button variant="outline" type="submit">Save</x-ui.button>
                                    </form>
                                @else
                                    <span class="text-xs text-muted">Not in plan</span>
                                @endif
                            </td>
                            <td class="px-4 py-[11px]">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <form method="post" action="{{ route('mail.mailboxes.toggle', $mailbox) }}">
                                        @csrf
                                        <x-ui.button variant="ghost" type="submit">{{ $mailbox->active ? 'Suspend' : 'Activate' }}</x-ui.button>
                                    </form>
                                    <form method="post" action="{{ route('mail.mailboxes.password', $mailbox) }}" class="flex flex-wrap items-center gap-1.5">
                                        @csrf
                                        <input type="password" name="password" placeholder="New password" required
                                               class="w-[150px] rounded-lg border border-border-strong bg-background px-2 py-1.5 font-mono text-xs focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent-muted">
                                        <x-ui.button variant="outline" type="submit">Reset Password</x-ui.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-5 text-[13px] text-muted">No mailboxes yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.card>
@endsection
