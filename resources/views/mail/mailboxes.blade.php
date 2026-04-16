@extends('layouts.app')

@section('title', $domain->domain . ' Email Management')
@section('crumb', 'Mail / Domains / Email')
@section('page-title', 'Manage Domain Email')

@section('topbar-actions')
    <a href="{{ route('mail.domains.manage') }}" class="btn btn-ghost">All Domains</a>
    <a href="{{ route('mail.domains.show', $domain) }}" class="btn btn-outline">DNS Setup</a>
@endsection

@section('content')
    <div class="card" style="margin-bottom:20px;">
        <div class="card-body">
            <div class="section-header">
                <span class="section-title">{{ $domain->domain }} Mailbox Provisioning</span>
                <span style="font-size:12px;color:var(--text-muted);">Plan: {{ $domain->mailPlan?->name ?? 'Unassigned' }}</span>
            </div>

            @if(session('generated_mailbox_password'))
                <div class="alert alert-success">
                    Generated credentials (shown once): <strong>{{ session('generated_mailbox_email') }}</strong>
                    <span class="mono">{{ session('generated_mailbox_password') }}</span>
                </div>
            @endif

            @if($errors->has('domain_delete'))
                <div class="alert alert-error">{{ $errors->first('domain_delete') }}</div>
            @endif

            <form method="post" action="{{ route('mail.mailboxes.store', $domain) }}">
                @csrf
                <div class="mailbox-form" style="border-top:none;padding:0;background:transparent;">
                    <div class="form-group">
                        <label class="form-label">Local Part</label>
                        <input name="local_part" type="text" placeholder="username" required class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Display Name</label>
                        <input name="display_name" type="text" placeholder="Full Name" required class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password Mode</label>
                        <select name="password_mode" class="form-input" required>
                            <option value="manual">Admin sets password</option>
                            <option value="generated">Generate random password</option>
                            <option value="generated_email">Generate random + send to secondary email</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password (manual mode)</label>
                        <input name="password" type="password" placeholder="Set manual password" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Secondary Email (delivery mode)</label>
                        <input name="secondary_email" type="email" placeholder="owner@example.com" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Quota (MB)</label>
                        <input name="quota_mb"
                               type="number"
                               min="128"
                               max="{{ $domain->mailPlan?->storage_mb ?? 1024 }}"
                               value="{{ min(1024, (int) ($domain->mailPlan?->storage_mb ?? 1024)) }}"
                               required
                               class="form-input">
                        <div style="font-size:11px;color:var(--text-muted);margin-top:6px;">
                            Plan limit per mailbox: {{ $domain->mailPlan?->storage_label ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Initial Reset</label>
                        <label style="display:flex;align-items:center;gap:8px;font-size:12px;color:var(--text-muted);">
                            <input type="checkbox" name="require_initial_reset" value="1">
                            Force user to reset password on first login
                        </label>
                    </div>
                    <div class="form-group" style="align-self:end;">
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Create Mailbox</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card" style="margin-bottom:20px;">
        <div class="card-body">
            <div class="section-header">
                <span class="section-title">Aliases & Forwarding</span>
            </div>

            @if($canManageRouting)
                <form method="post" action="{{ route('mail.aliases.store', $domain) }}">
                    @csrf
                    <div class="mailbox-form" style="border-top:none;padding:0;background:transparent;">
                        <div class="form-group">
                            <label class="form-label">Alias Local Part</label>
                            <input name="alias_local_part" type="text" placeholder="sales" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Destinations</label>
                            <input name="destinations" type="text" placeholder="ceo@{{ $domain->domain }}, team@gmail.com" required class="form-input">
                        </div>
                        <div class="form-group" style="align-self:end;">
                            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Create Alias</button>
                        </div>
                    </div>
                </form>

                <div style="margin-top:14px;">
                    <div style="font-size:12px;color:var(--text-muted);margin-bottom:8px;">Existing aliases</div>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Alias</th>
                                    <th>Destinations</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($aliases as $alias)
                                    <tr>
                                        <td class="mono">{{ $alias['address'] }}</td>
                                        <td class="mono">{{ implode(', ', $alias['destinations']) }}</td>
                                        <td>{{ $alias['active'] ? 'active' : 'disabled' }}</td>
                                        <td>
                                            <form method="post" action="{{ route('mail.aliases.destroy', [$domain, $alias['address']]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger-ghost">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="padding:16px;color:var(--text-muted);">No aliases configured for this domain yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="alert alert-error" style="margin-top:10px;">
                    This domain plan does not include mail aliases & forwarding. Upgrade the domain plan to unlock these routing features.
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="padding-bottom:0;">
            <div class="section-header">
                <span class="section-title">Existing Mailboxes</span>
                <span style="font-size:12px;color:var(--text-muted);">{{ $mailboxes->count() }} total</span>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Mode</th>
                        <th>Delivery</th>
                        <th>Reset Required</th>
                        <th>Status</th>
                        <th>Forwarding</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mailboxes as $mailbox)
                        <tr>
                            <td class="mono">{{ $mailbox->email }}</td>
                            <td>{{ $mailbox->password_mode }}</td>
                            <td>{{ $mailbox->password_delivery_status ?? 'n/a' }}</td>
                            <td>{{ $mailbox->require_initial_reset ? 'yes' : 'no' }}</td>
                            <td>{{ $mailbox->active ? 'active' : 'suspended' }}</td>
                            <td>
                                @if($canManageRouting)
                                    <form method="post" action="{{ route('mail.mailboxes.forwarding', $mailbox) }}" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                                        @csrf
                                        <input type="text"
                                               name="forward_to"
                                               placeholder="ops@gmail.com, team@other.com"
                                               class="form-input"
                                               style="width:220px;"
                                               value="{{ implode(', ', $forwardingByMailbox[$mailbox->id] ?? []) }}">
                                        <label style="display:flex;align-items:center;gap:6px;font-size:12px;color:var(--text-muted);">
                                            <input type="checkbox" name="keep_copy" value="1" checked>
                                            Keep local copy
                                        </label>
                                        <button type="submit" class="btn btn-outline">Save</button>
                                    </form>
                                @else
                                    <span style="font-size:12px;color:var(--text-muted);">Not in plan</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-row">
                                    <form method="post" action="{{ route('mail.mailboxes.toggle', $mailbox) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-ghost">{{ $mailbox->active ? 'Suspend' : 'Activate' }}</button>
                                    </form>
                                    <form method="post" action="{{ route('mail.mailboxes.password', $mailbox) }}">
                                        @csrf
                                        <input type="password" name="password" placeholder="New password" required class="form-input" style="width:150px;">
                                        <button type="submit" class="btn btn-outline">Reset Password</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:20px;color:var(--text-muted);">No mailboxes yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

