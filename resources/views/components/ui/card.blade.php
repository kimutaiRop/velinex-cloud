{{-- Legacy .card (+ optional .card-body padding 20px); use flush for full-bleed tables --}}
@props(['flush' => false])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-[var(--radius-shell-lg)] border border-border bg-card']) }}>
    @if ($flush)
        {{ $slot }}
    @else
        <div class="p-5">
            {{ $slot }}
        </div>
    @endif
</div>
