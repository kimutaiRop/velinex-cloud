@props(['type'])

@php
    $t = strtoupper($type);
    $c = match ($t) {
        'MX' => 'bg-[rgba(167,139,250,0.14)] text-[#A78BFA]',
        'TXT' => 'bg-[rgba(96,165,250,0.14)] text-[#60A5FA]',
        'CNAME' => 'bg-[rgba(244,114,182,0.14)] text-[#F472B6]',
        'A' => 'bg-[rgba(52,211,153,0.14)] text-[#34D399]',
        'DKIM' => 'bg-[rgba(0,229,255,0.14)] text-[#00E5FF]',
        'DMARC' => 'bg-[rgba(255,77,106,0.14)] text-[#FF4D6A]',
        'SPF' => 'bg-[rgba(253,211,77,0.14)] text-[#FCD34D]',
        default => 'bg-hover text-muted',
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded px-2 py-0.5 font-mono text-[10.5px] font-medium tracking-wide ' . $c]) }}>{{ $t }}</span>
