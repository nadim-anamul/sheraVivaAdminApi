@extends('layouts.app')

@section('title', 'Register | Shera Viva')

@section('content')
<div class="auth-card">
    <h2>Get Started</h2>
    <p class="subtitle">Register to book oral mock sessions and access expert board feedback.</p>

    @if($errors->any())
        <div class="alert-error">
            <ul style="list-style: none; padding: 0;">
                @foreach($errors->all() as $error)
                    <li><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/register" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Nadim Chowdhury" required autocomplete="name" autofocus>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="e.g. nadim@example.com" required autocomplete="email">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Min. 8 characters" required autocomplete="new-password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; margin-top: 10px; padding: 12px 20px;">
            Create Account <i class="fa-solid fa-user-plus"></i>
        </button>
    </form>

    <div class="auth-footer">
        Already have an account? <a href="/login">Log In</a>
    </div>
</div>
@endsection
