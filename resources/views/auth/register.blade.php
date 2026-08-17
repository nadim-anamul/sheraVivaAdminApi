@extends('layouts.app')

@section('title', 'Candidate Registration | Shera Viva')

@section('content')
<div class="auth-card" style="text-align: center; max-width: 440px;">
    <div style="width: 56px; height: 56px; background: rgba(15, 118, 110, 0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; color: #0f766e; font-size: 24px;">
        <i class="fa-solid fa-user-plus"></i>
    </div>

    <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 6px; color: #111827;">Create Candidate Account</h2>
    <p class="subtitle" style="font-size: 13px; color: #6b7280; margin-bottom: 24px; line-height: 1.5;">
        Register instantly with your Google account to get 1 Free AI Mock Viva credit and access BPSC/Bank board prep.
    </p>

    @if($errors->any())
        <div class="alert-error" style="margin-bottom: 20px; text-align: left;">
            <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
        </div>
    @endif

    <a href="{{ route('auth.google') }}" class="btn-primary" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 12px; padding: 14px 20px; border-radius: 12px; background: #0f766e; color: #ffffff; font-weight: 700; text-decoration: none; font-size: 15px; box-shadow: 0 4px 14px rgba(15, 118, 110, 0.25); transition: all 0.2s;">
        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" style="width: 20px; height: 20px; background: #ffffff; border-radius: 50%; padding: 2px;" alt="Google Logo">
        Sign Up with Gmail (Google)
    </a>

    <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid #f3f4f6; font-size: 12px; color: #6b7280;">
        Already have an account?
        <a href="/login" style="color: #0f766e; font-weight: 700; text-decoration: none; margin-left: 4px;">Sign In with Gmail <i class="fa-solid fa-arrow-right-long"></i></a>
    </div>
</div>
@endsection
