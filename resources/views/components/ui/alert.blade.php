{{-- Legacy .alert / .alert-success / .alert-error from app.css.bak --}}
@props(['variant' => 'success'])

@php
    $c = match ($variant) {
        'success' => 'border border-[rgba(0,229,153,0.2)] bg-success-muted text-success',
        'error' => 'border border-[rgba(255,77,106,0.22)] bg-danger-muted text-danger',
        default => '',
    };
@endphp

<div
    {{ $attributes->merge(['class' => 'mb-5 flex items-start gap-2.5 rounded-[var(--radius-shell)] px-4 py-[11px] text-[13px] [&_svg]:mt-0.5 [&_svg]:h-[15px] [&_svg]:w-[15px] [&_svg]:shrink-0 ' . $c]) }}
    role="alert"
>
    {{ $slot }}
</div>
