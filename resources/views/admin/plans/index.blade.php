@extends('layouts.app')

@section('title', 'Mail Plans')
@section('crumb', 'Admin / Plans')
@section('page-title', 'Mail Plans')

@section('topbar-actions')
    <a href="{{ route('admin.plans.create') }}" class="btn-primary" style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;font-size:13px;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:13px;height:13px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        New Plan
    </a>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success" style="margin-bottom:20px;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
@endif

<div class="card" style="overflow:hidden;">
    <table class="data-table" style="width:100%;border-collapse:collapse;">
        <thead>
            <tr>
                <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:400;color:var(--text-3);text-transform:uppercase;letter-spacing:.08em;border-bottom:1px solid var(--border);">Order</th>
                <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:400;color:var(--text-3);text-transform:uppercase;letter-spacing:.08em;border-bottom:1px solid var(--border);">Plan</th>
                <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:400;color:var(--text-3);text-transform:uppercase;letter-spacing:.08em;border-bottom:1px solid var(--border);">Price / mo</th>
                <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:400;color:var(--text-3);text-transform:uppercase;letter-spacing:.08em;border-bottom:1px solid var(--border);">Storage</th>
                <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:400;color:var(--text-3);text-transform:uppercase;letter-spacing:.08em;border-bottom:1px solid var(--border);">Domains</th>
                <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:400;color:var(--text-3);text-transform:uppercase;letter-spacing:.08em;border-bottom:1px solid var(--border);">Status</th>
                <th style="padding:10px 16px;text-align:right;font-size:11px;font-weight:400;color:var(--text-3);text-transform:uppercase;letter-spacing:.08em;border-bottom:1px solid var(--border);">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($plans as $plan)
            <tr style="border-bottom:1px solid var(--border);">
                <td style="padding:12px 16px;font-size:13px;color:var(--text-3);">{{ $plan->sort_order }}</td>
                <td style="padding:12px 16px;">
                    <div style="font-size:14px;font-weight:400;color:var(--text);">
                        {{ $plan->name }}
                        @if($plan->is_featured)
                            <span style="display:inline-block;margin-left:6px;padding:1px 7px;background:rgba(26,108,240,.09);color:var(--blue);font-size:10px;border-radius:99px;">Popular</span>
                        @endif
                    </div>
                    <div style="font-size:12px;font-weight:300;color:var(--text-3);margin-top:2px;">{{ $plan->description }}</div>
                </td>
                <td style="padding:12px 16px;font-size:13px;font-weight:400;color:var(--text);">{{ $plan->price_label }}</td>
                <td style="padding:12px 16px;font-size:13px;color:var(--text-2);">{{ $plan->storage_label }} / mailbox</td>
                <td style="padding:12px 16px;font-size:13px;color:var(--text-2);">{{ $plan->max_domains_label }}</td>
                <td style="padding:12px 16px;">
                    @if($plan->is_active)
                        <span style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;background:var(--green-dim);color:var(--green);border-radius:99px;font-size:11px;">
                            <span style="width:4px;height:4px;border-radius:50%;background:currentColor;"></span>Active
                        </span>
                    @else
                        <span style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;background:rgba(0,0,0,.04);color:var(--text-3);border-radius:99px;font-size:11px;">
                            <span style="width:4px;height:4px;border-radius:50%;background:currentColor;"></span>Inactive
                        </span>
                    @endif
                </td>
                <td style="padding:12px 16px;text-align:right;">
                    <a href="{{ route('admin.plans.edit', $plan) }}" style="font-size:12px;color:var(--blue);margin-right:12px;">Edit</a>
                    <form method="POST" action="{{ route('admin.plans.destroy', $plan) }}" style="display:inline;"
                          onsubmit="return confirm('Delete plan {{ $plan->name }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="font-size:12px;color:#dc2626;background:none;border:none;cursor:pointer;padding:0;">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding:32px;text-align:center;font-size:13px;color:var(--text-3);">No plans yet. <a href="{{ route('admin.plans.create') }}" style="color:var(--blue);">Create one</a></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
