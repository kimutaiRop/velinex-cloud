@extends('layouts.guest')

@section('title', 'Create Account')

@section('content')
    <div class="w-full max-w-[580px] animate-vc-fade-up rounded-[18px] border border-border-strong bg-surface p-9 shadow-sm">
        <div class="mb-7">
            <img src="{{ asset('logo.svg') }}" alt="Velinex Cloud" class="block h-auto w-40 max-w-full">
        </div>

        <h1 class="mb-1 font-sans text-[22px] font-bold tracking-wide text-foreground">Create client account</h1>
        <p class="mb-6 text-[13px] text-muted">Register your company and start managing hosted business mail.</p>

        @if($errors->any())
            <x-ui.alert variant="error" class="!mb-[18px]">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <div>
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            </x-ui.alert>
        @endif

        <form method="post" action="{{ route('auth.register.store') }}">
            @csrf
            <div class="mb-3.5 grid grid-cols-1 gap-3.5 sm:grid-cols-2">
                <x-ui.field label="Full Name" name="name" value="{{ old('name') }}" placeholder="Jane Smith" required />
                <x-ui.field label="Company Name" name="client_name" value="{{ old('client_name') }}" placeholder="Acme Corp" required />
                <x-ui.field label="Email" name="email" type="email" value="{{ old('email') }}" placeholder="you@example.com" required />
                <x-ui.field label="Username" name="username" value="{{ old('username') }}" placeholder="yourusername" required />
                <x-ui.field label="Password" name="password" type="password" placeholder="••••••••" required />
                <div class="sm:col-span-2">
                    <x-ui.field label="Confirm Password" name="password_confirmation" type="password" placeholder="••••••••" required />
                </div>
            </div>

            <x-ui.button variant="primary" type="submit" class="!mt-2 !w-full !py-2.5 !text-sm">
                Create Account
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                </svg>
            </x-ui.button>
        </form>

        <p class="mt-[18px] text-center text-[12.5px] text-muted">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium text-accent hover:text-accent-hover">Sign in</a>
        </p>
    </div>
@endsection
