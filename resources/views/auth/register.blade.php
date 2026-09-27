@extends('layouts.app')

@section('title', 'ক্যান্ডিডেট নিবন্ধন | সেরা ভাইভা')

@section('content')
<div class="auth-card" style="text-align: center; max-width: 440px;">
    <div style="width: 56px; height: 56px; background: rgba(15, 118, 110, 0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; color: #0f766e; font-size: 24px;">
        <i class="fa-solid fa-user-plus"></i>
    </div>

    <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 6px;" class="text-white">নতুন অ্যাকাউন্ট নিবন্ধন করুন</h2>
    <p class="subtitle" style="font-size: 13px; margin-bottom: 24px; line-height: 1.5;">
        জিমেইল অ্যাকাউন্ট দিয়ে দ্রুত সাইন আপ করুন এবং ১টি ফ্রি এআই মক ভাইভা ক্রেডিট পান।
    </p>

    @if($errors->any())
        <div class="alert-error" style="margin-bottom: 20px; text-align: left;">
            <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
        </div>
    @endif

    <a href="{{ route('auth.google') }}" class="btn-primary" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 12px; padding: 14px 20px; border-radius: 12px; font-weight: 700; text-decoration: none; font-size: 15px; transition: all 0.2s;">
        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" style="width: 20px; height: 20px; background: #ffffff; border-radius: 50%; padding: 2px;" alt="Google Logo">
        <span>জিমেইল দিয়ে নিবন্ধিত হন (Google Sign Up)</span>
    </a>

    <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid rgba(226, 232, 240, 0.2); font-size: 12px; color: #6b7280;">
        পূর্বেই অ্যাকাউন্ট তৈরি করা আছে?
        <a href="/login" style="color: #0f766e; font-weight: 700; text-decoration: none; margin-left: 4px;">এখানে সাইন ইন করুন <i class="fa-solid fa-arrow-right-long"></i></a>
    </div>
</div>
@endsection
