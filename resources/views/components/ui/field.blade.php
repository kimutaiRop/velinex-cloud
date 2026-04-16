@props(['label' => null, 'name', 'error' => null, 'class' => null, 'inputClass' => null])

@php
    $inputBase =
        'w-full rounded-lg border border-border-strong bg-background px-3 py-2 font-mono text-[13px] text-foreground outline-none transition-[border-color,box-shadow] duration-[140ms] placeholder:text-dim placeholder:font-sans focus:border-accent focus:shadow-[0_0_0_3px_var(--color-accent-muted)]';
    $inputClasses = trim($inputBase . ' ' . ($inputClass ?? ''));
@endphp

<div @class(['flex flex-col gap-1.5', $class])>
    @if ($label)
        <label for="{{ $name }}" class="font-mono text-[9.5px] uppercase tracking-[0.16em] text-muted">{{ $label }}</label>
    @endif

    <input name="{{ $name }}" id="{{ $name }}" {{ $attributes->merge(['class' => $inputClasses]) }} />

    @if ($error)
        <p class="mt-1 text-[11px] text-danger">{{ $error }}</p>
    @endif
</div>
