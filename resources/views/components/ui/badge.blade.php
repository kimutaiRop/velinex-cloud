{{-- Legacy .badge variants from app.css.bak --}}
@props(['variant' => 'verified'])

@php
    $c = match ($variant) {
        'verified' => 'border border-[rgba(0,229,153,0.18)] bg-success-muted text-success',
        'active' => 'border border-[rgba(0,229,153,0.18)] bg-success-muted text-success',
        'pending' => 'border border-[rgba(255,176,32,0.18)] bg-warning-muted text-warning',
        'pass' => 'border border-[rgba(0,229,153,0.18)] bg-success-muted text-success',
        'fail', 'suspended' => 'border border-[rgba(255,77,106,0.18)] bg-danger-muted text-danger',
        default => 'border border-border bg-hover text-muted',
    };

    $dotPulse = in_array($variant, ['verified', 'active'], true);
    $dotStatic = in_array($variant, ['pending', 'fail'], true);
@endphp

<span
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-[5px] rounded-full px-[9px] py-[3px] font-mono text-[10px] font-semibold uppercase tracking-[0.06em] ' . $c]) }}
>
    @if ($dotPulse)
        <span class="h-[5px] w-[5px] shrink-0 animate-vc-pulse-dot rounded-full bg-current"></span>
    @elseif ($dotStatic)
        <span class="h-[5px] w-[5px] shrink-0 rounded-full bg-current"></span>
    @endif
    {{ $slot }}
</span>
