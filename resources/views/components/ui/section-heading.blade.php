@props(['title'])

<div {{ $attributes->merge(['class' => 'mb-3.5 flex items-center justify-between gap-4']) }}>
    <h2 class="flex items-center gap-2 font-sans text-sm font-medium text-foreground after:h-px after:w-6 after:rounded-sm after:bg-accent after:content-['']">
        {{ $title }}
    </h2>
    @isset($aside)
        <div class="shrink-0 text-xs text-muted">{{ $aside }}</div>
    @endisset
</div>
