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
                        <input name="quota_mb" type="number" min="128" value="1024" required class="form-input">
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
                            <td colspan="6" style="padding:20px;color:var(--text-muted);">No mailboxes yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

