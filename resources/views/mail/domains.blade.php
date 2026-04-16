@extends('layouts.app')

@section('title', 'Manage Domains')
@section('crumb', 'Mail / Domains')
@section('page-title', 'All Domains')

@section('topbar-actions')
    <a href="{{ route('mail.dashboard') }}" class="btn btn-ghost">Dashboard</a>
    <a href="{{ route('mail.domains.create') }}" class="btn btn-primary">Add Domain</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body" style="padding-bottom: 0;">
            <div class="section-header">
                <span class="section-title">Domain Management</span>
                <span style="font-size:12px;color:var(--text-muted);">{{ $domains->count() }} total</span>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Domain</th>
                        <th>Status</th>
                        <th>Mailboxes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($domains as $domain)
                        <tr>
                            <td class="mono">{{ $domain->domain }}</td>
                            <td>
                                @if($domain->status === 'verified')
                                    <span class="badge badge-verified"><span class="badge-dot"></span> verified</span>
                                @elseif($domain->status === 'disabled')
                                    <span class="badge badge-fail"><span class="badge-dot"></span> disabled</span>
                                @else
                                    <span class="badge badge-pending"><span class="badge-dot"></span> pending</span>
                                @endif
                            </td>
                            <td>{{ $domain->mailboxes->count() }}</td>
                            <td>
                                <div class="action-row">
                                    <a href="{{ route('mail.domains.show', $domain) }}" class="btn btn-outline">DNS</a>
                                    <a href="{{ route('mail.domains.mailboxes', $domain) }}" class="btn btn-ghost">Email</a>
                                    <form method="post" action="{{ route('mail.domains.toggle', $domain) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-ghost">{{ $domain->status === 'disabled' ? 'Enable' : 'Disable' }}</button>
                                    </form>
                                    <form method="post" action="{{ route('mail.domains.destroy', $domain) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="force_delete" value="{{ $domain->mailboxes->isNotEmpty() ? 1 : 0 }}">
                                        <button type="submit" class="btn btn-danger-ghost">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding:20px;color:var(--text-muted);">No domains found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

