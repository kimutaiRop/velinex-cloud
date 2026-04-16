@extends('layouts.app')

@section('title', $plan->exists ? 'Edit Plan' : 'New Plan')
@section('crumb', 'Admin / Plans / ' . ($plan->exists ? 'Edit' : 'New'))
@section('page-title', $plan->exists ? 'Edit Plan — ' . $plan->name : 'New Plan')

@section('content')
<div style="max-width:640px;">

@if($errors->any())
    <div class="alert" style="margin-bottom:20px;background:rgba(220,38,38,.06);border:1px solid rgba(220,38,38,.15);border-radius:8px;padding:14px 16px;color:#dc2626;font-size:13px;">
        <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:4px;">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="card" style="padding:28px;">
    <form method="POST" action="{{ $plan->exists ? route('admin.plans.update', $plan) : route('admin.plans.store') }}">
        @csrf
        @if($plan->exists) @method('PUT') @endif

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
            <div>
                <label style="display:block;font-size:12px;font-weight:400;color:var(--text-2);margin-bottom:5px;">Plan name</label>
                <input type="text" name="name" value="{{ old('name', $plan->name) }}" required
                    style="width:100%;padding:8px 11px;border:1px solid var(--border-hi);border-radius:6px;font-size:13px;font-family:inherit;outline:none;"
                    placeholder="e.g. Business">
            </div>
            <div>
                <label style="display:block;font-size:12px;font-weight:400;color:var(--text-2);margin-bottom:5px;">Sort order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $plan->sort_order ?? 0) }}" min="0" required
                    style="width:100%;padding:8px 11px;border:1px solid var(--border-hi);border-radius:6px;font-size:13px;font-family:inherit;outline:none;">
            </div>
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-size:12px;font-weight:400;color:var(--text-2);margin-bottom:5px;">Short description</label>
            <input type="text" name="description" value="{{ old('description', $plan->description) }}"
                style="width:100%;padding:8px 11px;border:1px solid var(--border-hi);border-radius:6px;font-size:13px;font-family:inherit;outline:none;"
                placeholder="Shown under the plan name on the pricing page">
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:16px;">
            <div>
                <label style="display:block;font-size:12px;font-weight:400;color:var(--text-2);margin-bottom:5px;">Price (KES / month)</label>
                <input type="number" name="price_kes" value="{{ old('price_kes', $plan->price_kes ?? 0) }}" min="0" required
                    style="width:100%;padding:8px 11px;border:1px solid var(--border-hi);border-radius:6px;font-size:13px;font-family:inherit;outline:none;">
            </div>
            <div>
                <label style="display:block;font-size:12px;font-weight:400;color:var(--text-2);margin-bottom:5px;">Storage per mailbox (MB)</label>
                <input type="number" name="storage_mb" value="{{ old('storage_mb', $plan->storage_mb ?? 100) }}" min="1" required
                    style="width:100%;padding:8px 11px;border:1px solid var(--border-hi);border-radius:6px;font-size:13px;font-family:inherit;outline:none;">
            </div>
            <div>
                <label style="display:block;font-size:12px;font-weight:400;color:var(--text-2);margin-bottom:5px;">Max domains <span style="color:var(--text-3);">(blank = ∞)</span></label>
                <input type="number" name="max_domains" value="{{ old('max_domains', $plan->max_domains) }}" min="1"
                    style="width:100%;padding:8px 11px;border:1px solid var(--border-hi);border-radius:6px;font-size:13px;font-family:inherit;outline:none;"
                    placeholder="Leave blank for unlimited">
            </div>
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-size:12px;font-weight:400;color:var(--text-2);margin-bottom:5px;">
                Features <span style="color:var(--text-3);font-weight:300;">(one per line)</span>
            </label>
            <textarea name="features" rows="8" required
                style="width:100%;padding:8px 11px;border:1px solid var(--border-hi);border-radius:6px;font-size:13px;font-family:inherit;outline:none;resize:vertical;line-height:1.6;">{{ old('features', is_array($plan->features) ? implode("\n", $plan->features) : '') }}</textarea>
        </div>

        <div style="display:flex;gap:24px;margin-bottom:24px;">
            <label style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:300;color:var(--text-2);cursor:pointer;">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $plan->is_featured) ? 'checked' : '' }}
                    style="width:14px;height:14px;">
                Mark as "Popular" (highlighted)
            </label>
            <label style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:300;color:var(--text-2);cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->exists ? $plan->is_active : true) ? 'checked' : '' }}
                    style="width:14px;height:14px;">
                Active (visible on pricing page)
            </label>
        </div>

        <div style="display:flex;align-items:center;gap:12px;">
            <button type="submit" class="btn-primary" style="padding:9px 22px;font-size:13px;">
                {{ $plan->exists ? 'Save changes' : 'Create plan' }}
            </button>
            <a href="{{ route('admin.plans.index') }}" style="font-size:13px;color:var(--text-3);">Cancel</a>
        </div>
    </form>
</div>
</div>
@endsection
