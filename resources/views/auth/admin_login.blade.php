@extends('layouts.app')

@section('title', 'Admin Sign In | Shera Viva')

@section('content')
<div class="auth-card">
    <h2>Admin & Examiner Portal</h2>
    <p class="subtitle">Log in to manage mock boards, slots, and candidate evaluation metrics.</p>

    @if($errors->any())
        <div class="alert-error">
            <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
        </div>
    @endif

    <form action="/login" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@seraviva.com" required autocomplete="email" autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
        </div>

        <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; margin-top: 10px; padding: 12px 20px;">
            Sign In to Panel <i class="fa-solid fa-right-to-bracket"></i>
        </button>
    </form>
</div>
@endsection
