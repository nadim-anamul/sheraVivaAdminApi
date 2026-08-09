@extends('layouts.app')

@section('title', 'Login | Shera Viva')

@section('content')
<div class="auth-card">
    <h2>Welcome Back</h2>
    <p class="subtitle">Log in to check your slots, scores, and join live boards.</p>

    @if($errors->any())
        <div class="alert-error">
            <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
        </div>
    @endif

    <form action="/login" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="candidate@seraviva.com" required autocomplete="email" autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
        </div>

        <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; margin-top: 10px; padding: 12px 20px;">
            Log In <i class="fa-solid fa-right-to-bracket"></i>
        </button>
    </form>

    <div class="auth-footer">
        Don't have an account? <a href="/register">Create Account</a>
    </div>
</div>
@endsection
