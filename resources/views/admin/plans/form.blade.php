@extends('layouts.app')

@section('title', $plan->exists ? 'Edit Plan' : 'New Plan')
@section('crumb', 'Admin / Plans / ' . ($plan->exists ? 'Edit' : 'New'))
@section('page-title', $plan->exists ? 'Edit Plan — ' . $plan->name : 'New Plan')

@section('content')
    <div class="mx-auto max-w-[640px]">
        @if($errors->any())
            <x-ui.alert variant="error" class="!mb-5">
                <ul class="list-none space-y-1">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </x-ui.alert>
        @endif

        <x-ui.card>
            <form method="POST" action="{{ $plan->exists ? route('admin.plans.update', $plan) : route('admin.plans.store') }}">
                @csrf
                @if($plan->exists) @method('PUT') @endif

                <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <x-ui.field label="Plan name" name="name" value="{{ old('name', $plan->name) }}" placeholder="e.g. Business" required />
                    <x-ui.field label="Sort order" name="sort_order" type="number" value="{{ old('sort_order', $plan->sort_order ?? 0) }}" min="0" required />
                </div>

                <div class="mb-4">
                    <label for="description" class="mb-1.5 block text-xs font-normal text-muted">Short description</label>
                    <input id="description" name="description" type="text" value="{{ old('description', $plan->description) }}"
                           placeholder="Shown under the plan name on the pricing page"
                           class="w-full rounded-md border border-border-strong bg-background px-2.5 py-2 text-[13px] text-foreground outline-none focus:border-accent focus:ring-2 focus:ring-accent-muted" />
                </div>

                <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <x-ui.field label="Price (KES / month)" name="price_kes" type="number" value="{{ old('price_kes', $plan->price_kes ?? 0) }}" min="0" required />
                    <x-ui.field label="Storage per mailbox (MB)" name="storage_mb" type="number" value="{{ old('storage_mb', $plan->storage_mb ?? 100) }}" min="1" required />
                    <div class="flex flex-col gap-1.5">
                        <label for="max_domains" class="text-xs font-normal text-muted">Max domains <span class="text-dim">(blank = ∞)</span></label>
                        <input id="max_domains" name="max_domains" type="number" value="{{ old('max_domains', $plan->max_domains) }}" min="1"
                               placeholder="Leave blank for unlimited"
                               class="w-full rounded-md border border-border-strong bg-background px-2.5 py-2 text-[13px] text-foreground outline-none focus:border-accent focus:ring-2 focus:ring-accent-muted" />
                    </div>
                </div>

                <div class="mb-6">
                    <label for="features" class="mb-1.5 block text-xs font-normal text-muted">Features <span class="font-light text-dim">(one per line)</span></label>
                    <textarea id="features" name="features" rows="8" required
                        class="w-full resize-y rounded-md border border-border-strong bg-background px-2.5 py-2 text-[13px] leading-relaxed text-foreground outline-none focus:border-accent focus:ring-2 focus:ring-accent-muted">{{ old('features', is_array($plan->features) ? implode("\n", $plan->features) : '') }}</textarea>
                </div>

                <div class="mb-6 flex flex-wrap gap-6">
                    <label class="flex cursor-pointer items-center gap-2 text-[13px] font-light text-muted">
                        <input type="checkbox" name="is_featured" value="1" class="h-3.5 w-3.5 rounded border-border-strong" {{ old('is_featured', $plan->is_featured) ? 'checked' : '' }}>
                        Mark as "Popular" (highlighted)
                    </label>
                    <label class="flex cursor-pointer items-center gap-2 text-[13px] font-light text-muted">
                        <input type="checkbox" name="is_active" value="1" class="h-3.5 w-3.5 rounded border-border-strong" {{ old('is_active', $plan->exists ? $plan->is_active : true) ? 'checked' : '' }}>
                        Active (visible on pricing page)
                    </label>
                </div>

                <div class="flex items-center gap-3">
                    <x-ui.button variant="primary" type="submit" class="!px-5 !py-2 !text-[13px]">
                        {{ $plan->exists ? 'Save changes' : 'Create plan' }}
                    </x-ui.button>
                    <a href="{{ route('admin.plans.index') }}" class="text-[13px] text-dim hover:text-foreground">Cancel</a>
                </div>
            </form>
        </x-ui.card>
    </div>
@endsection
