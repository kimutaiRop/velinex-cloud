@extends('layouts.guest')

@section('title', 'Sign In')

@section('content')
<div class="auth-card">

    <div class="auth-brand">
        <img src="{{ asset('logo.svg') }}" alt="Velinex Cloud" class="brand-mark">
    </div>

    <div class="auth-title">Client portal login</div>
    <div class="auth-sub">Sign in to manage your domains, DNS setup, and business mailboxes.</div>

    @if(session('status'))
        <div class="alert alert-success" style="margin-bottom: 18px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error" style="margin-bottom: 18px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    <form method="post" action="{{ route('auth.login.attempt') }}">
        @csrf
        <div class="form-group" style="margin-bottom: 14px;">
            <label for="login" class="form-label">Email or Username</label>
            <input id="login" name="login" type="text" required value="{{ old('login') }}"
                   placeholder="you@example.com or username" autofocus class="form-input">
            @error('login')
                <small style="color: var(--danger); font-size: 11px; margin-top: 4px;">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group" style="margin-bottom: 22px;">
            <label for="password" class="form-label">Password</label>
            <input id="password" name="password" type="password" required
                   placeholder="••••••••" class="form-input">
            @error('password')
                <small style="color: var(--danger); font-size: 11px; margin-top: 4px;">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 10px; font-size: 14px;">
            Sign In
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
            </svg>
        </button>
    </form>

    <div class="auth-footer">
        New client? <a href="{{ route('auth.register') }}">Create account</a>
    </div>

</div>
@endsection
