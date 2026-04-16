<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Velinex Cloud')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400|jetbrains-mono:400,500&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-gradient-to-br from-white from-0% via-[#f4f7ff] via-65% to-[#eef2fb] to-100% font-sans text-foreground antialiased">
    <div class="pointer-events-none fixed inset-0 bg-[radial-gradient(circle,rgba(62,236,255,0.12)_1px,transparent_1px)] bg-[length:26px_26px]" aria-hidden="true"></div>
    <div class="pointer-events-none fixed -left-[10%] -top-[20%] h-[600px] w-[600px] rounded-full bg-[radial-gradient(ellipse,rgba(62,236,255,0.16)_0%,transparent_65%)]" aria-hidden="true"></div>
    <div class="pointer-events-none fixed -bottom-[20%] -right-[10%] h-[500px] w-[500px] rounded-full bg-[radial-gradient(ellipse,rgba(124,58,237,0.08)_0%,transparent_65%)]" aria-hidden="true"></div>
    <div class="relative z-[1] flex min-h-screen items-center justify-center p-5">
        @yield('content')
    </div>
</body>
</html>
