@props(['label' => null, 'name'])

@php
    $inputClass =
        'w-full rounded-lg border border-border-strong bg-background px-3 py-2 font-mono text-[13px] text-foreground outline-none transition-[border-color,box-shadow] duration-[140ms] focus:border-accent focus:shadow-[0_0_0_3px_var(--color-accent-muted)]';
@endphp

<div class="flex flex-col gap-1.5">
    @if ($label)
        <label for="{{ $name }}" class="font-mono text-[9.5px] uppercase tracking-[0.16em] text-muted">{{ $label }}</label>
    @endif

    <select id="{{ $name }}" name="{{ $name }}" {{ $attributes->merge(['class' => $inputClass]) }}>{{ $slot }}</select>
</div>
