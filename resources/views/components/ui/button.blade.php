{{--
  Legacy .btn / .btn-* / .copy-btn-icon from app.css.bak
--}}
@props([
    'variant' => 'primary',
    'type' => 'button',
    'size' => 'md',
])

@php
    $base = 'inline-flex items-center justify-center whitespace-nowrap rounded-lg font-sans font-medium transition-all duration-[140ms] [&_svg]:shrink-0';

    if ($size === 'icon') {
        $base .= ' h-[26px] w-7 gap-0 p-0 [&_svg]:h-3 [&_svg]:w-3';
    } elseif ($variant === 'ghost' || $variant === 'danger-ghost') {
        $base .= ' gap-[7px] px-[10px] py-[5px] text-xs [&_svg]:h-3.5 [&_svg]:w-3.5';
    } else {
        $base .= ' gap-[7px] px-[14px] py-[7px] text-[13px] [&_svg]:h-3.5 [&_svg]:w-3.5';
    }

    $v = match ($variant) {
        'primary' =>
            'border-0 bg-accent text-white shadow-accent hover:-translate-y-px hover:bg-accent-hover hover:shadow-accent-lg',
        'outline' =>
            'border border-border-strong bg-transparent text-muted hover:border-accent hover:bg-accent-muted hover:text-accent',
        'ghost' =>
            'border border-border bg-transparent text-muted hover:bg-hover hover:text-foreground',
        'danger-ghost' =>
            'border border-border bg-transparent text-muted hover:border-[rgba(255,77,106,0.4)] hover:bg-danger-muted hover:text-danger',
        default => '',
    };

    $classes = trim("{$base} {$v}");
@endphp

@if ($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
