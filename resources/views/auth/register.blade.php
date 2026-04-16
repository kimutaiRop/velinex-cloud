@extends('layouts.guest')

@section('title', 'Create Account')

@section('content')
<div class="auth-card auth-card-wide">

    <div class="auth-brand">
        <img src="{{ asset('logo.svg') }}" alt="Velinex Cloud" class="brand-mark">
    </div>

    <div class="auth-title">Create client account</div>
    <div class="auth-sub">Register your company and start managing hosted business mail.</div>

    @if($errors->any())
        <div class="alert alert-error" style="margin-bottom: 18px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        </div>
    @endif

    <form method="post" action="{{ route('auth.register.store') }}">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input id="name" name="name" required value="{{ old('name') }}"
                       placeholder="Jane Smith" class="form-input">
            </div>
            <div class="form-group">
                <label for="client_name" class="form-label">Company Name</label>
                <input id="client_name" name="client_name" required value="{{ old('client_name') }}"
                       placeholder="Acme Corp" class="form-input">
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" name="email" type="email" required value="{{ old('email') }}"
                       placeholder="you@example.com" class="form-input">
            </div>
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input id="username" name="username" required value="{{ old('username') }}"
                       placeholder="yourusername" class="form-input">
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" name="password" type="password" required
                       placeholder="••••••••" class="form-input">
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       placeholder="••••••••" class="form-input">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 10px; font-size: 14px;">
            Create Account
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
            </svg>
        </button>
    </form>

    <div class="auth-footer">
        Already have an account? <a href="{{ route('login') }}">Sign in</a>
    </div>

</div>
@endsection
