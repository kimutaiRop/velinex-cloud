@extends('layouts.guest')

@section('title', 'Sign In')

@section('content')
<div class="auth-card">

    <div class="auth-brand">
        <div class="brand-mark">VX</div>
        <div class="brand-text">
            <span class="brand-name">Velinex</span>
            <span class="brand-sub">Cloud</span>
        </div>
    </div>

    <div class="auth-title">Client portal login</div>
    <div class="auth-sub">Sign in to manage your domains, DNS setup, and business mailboxes.</div>

    @if($errors->any())
        <div class="alert alert-error" style="margin-bottom: 18px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="post" action="{{ route('auth.login.attempt') }}">
        @csrf
        <div class="form-group" style="margin-bottom: 14px;">
            <label for="login" class="form-label">Email or Username</label>
            <input id="login" name="login" type="text" required value="{{ old('login') }}"
                   placeholder="you@example.com or username" autofocus class="form-input">
        </div>
        <div class="form-group" style="margin-bottom: 22px;">
            <label for="password" class="form-label">Password</label>
            <input id="password" name="password" type="password" required
                   placeholder="••••••••" class="form-input">
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
