@extends('layouts.app')

@section('title', 'Mail Plans')
@section('crumb', 'Admin / Plans')
@section('page-title', 'Mail Plans')

@section('topbar-actions')
    <x-ui.button variant="primary" href="{{ route('admin.plans.create') }}">
        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        New Plan
    </x-ui.button>
@endsection

@section('content')
    @if(session('success'))
        <x-ui.alert variant="success" class="!mb-5">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </x-ui.alert>
    @endif

    <x-ui.card flush>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b border-border">
                        @foreach (['Order', 'Plan', 'Price / mo', 'Storage', 'Domains', 'Status', 'Actions'] as $h)
                            <th @class([
                                'whitespace-nowrap px-4 py-2.5 text-left font-mono text-[11px] font-normal uppercase tracking-wide text-dim',
                                'text-right' => $h === 'Actions',
                            ])>{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                        <tr class="border-b border-border transition-colors last:border-0 hover:bg-hover">
                            <td class="px-4 py-3 text-[13px] text-dim">{{ $plan->sort_order }}</td>
                            <td class="px-4 py-3">
                                <div class="text-sm font-normal text-foreground">
                                    {{ $plan->name }}
                                    @if($plan->is_featured)
                                        <span class="ml-1.5 inline-block rounded-full bg-blue-500/10 px-1.5 py-0.5 text-[10px] text-accent">Popular</span>
                                    @endif
                                </div>
                                <div class="mt-0.5 text-xs font-light text-dim">{{ $plan->description }}</div>
                            </td>
                            <td class="px-4 py-3 text-[13px] text-foreground">{{ $plan->price_label }}</td>
                            <td class="px-4 py-3 text-[13px] text-muted">{{ $plan->storage_label }} / mailbox</td>
                            <td class="px-4 py-3 text-[13px] text-muted">{{ $plan->max_domains_label }}</td>
                            <td class="px-4 py-3">
                                @if($plan->is_active)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-success-muted px-2 py-0.5 text-[11px] text-success">
                                        <span class="h-1 w-1 rounded-full bg-current"></span>Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-black/[0.04] px-2 py-0.5 text-[11px] text-dim">
                                        <span class="h-1 w-1 rounded-full bg-current"></span>Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.plans.edit', $plan) }}" class="mr-3 text-xs text-accent hover:text-accent-hover">Edit</a>
                                <form method="POST" action="{{ route('admin.plans.destroy', $plan) }}" class="inline" onsubmit="return confirm('Delete plan {{ $plan->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="cursor-pointer border-0 bg-transparent p-0 text-xs text-danger hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-8 py-8 text-center text-[13px] text-dim">
                                No plans yet. <a href="{{ route('admin.plans.create') }}" class="text-accent hover:text-accent-hover">Create one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.card>
@endsection
