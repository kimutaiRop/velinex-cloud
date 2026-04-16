@extends('layouts.guest')

@section('title', 'Sign In')

@section('content')
    <div class="w-full max-w-[420px] animate-vc-fade-up rounded-[18px] border border-border-strong bg-surface p-9 shadow-sm">
        <div class="mb-7">
            <img src="{{ asset('logo.svg') }}" alt="Velinex Cloud" class="block h-auto w-40 max-w-full">
        </div>

        <h1 class="mb-1 font-sans text-[22px] font-bold tracking-wide text-foreground">Client portal login</h1>
        <p class="mb-6 text-[13px] text-muted">Sign in to manage your domains, DNS setup, and business mailboxes.</p>

        @if(session('status'))
            <x-ui.alert variant="success" class="!mb-[18px]">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                {{ session('status') }}
            </x-ui.alert>
        @endif

        @if($errors->any())
            <x-ui.alert variant="error" class="!mb-[18px]">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </x-ui.alert>
        @endif

        <form method="post" action="{{ route('auth.login.attempt') }}">
            @csrf
            <x-ui.field
                label="Email or Username"
                name="login"
                class="mb-3.5"
                value="{{ old('login') }}"
                placeholder="you@example.com or username"
                required
                autofocus
                :error="$errors->first('login')"
            />
            <x-ui.field
                label="Password"
                name="password"
                type="password"
                class="mb-6"
                placeholder="••••••••"
                required
                :error="$errors->first('password')"
            />

            <x-ui.button variant="primary" type="submit" class="!w-full !py-2.5 !text-sm">
                Sign In
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                </svg>
            </x-ui.button>
        </form>

        <p class="mt-[18px] text-center text-[12.5px] text-muted">
            New client?
            <a href="{{ route('auth.register') }}" class="font-medium text-accent hover:text-accent-hover">Create account</a>
        </p>
    </div>
@endsection
