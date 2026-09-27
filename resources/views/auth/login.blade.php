@extends('layouts.app')

@section('title', 'ক্যান্ডিডেট সাইন ইন | সেরা ভাইভা')

@section('content')
<div class="auth-card" style="text-align: center; max-width: 440px;">
    <div style="width: 56px; height: 56px; background: rgba(15, 118, 110, 0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; color: #0f766e; font-size: 24px;">
        <i class="fa-solid fa-graduation-cap"></i>
    </div>

    <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 6px;" class="text-white">ক্যান্ডিডেট প্রবেশ করুন</h2>
    <p class="subtitle" style="font-size: 13px; margin-bottom: 24px; line-height: 1.5;">
        এআই মক ভাইভা অনুশীলন শুরু করতে আপনার জিমেইল অ্যাকাউন্ট দিয়ে প্রবেশ করুন এবং ১টি বিনামূল্যে ভাইভা ক্রেডিট পান।
    </p>

    @if($errors->any())
        <div class="alert-error" style="margin-bottom: 20px; text-align: left;">
            <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
        </div>
    @endif

    <!-- Lighter Google Login Button (Req #7) -->
    <a href="{{ route('auth.google') }}" class="btn-secondary" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 12px; padding: 13px 20px; border-radius: 12px; font-weight: 700; text-decoration: none; font-size: 14px; transition: all 0.2s;">
        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" style="width: 20px; height: 20px; background: #ffffff; border-radius: 50%; padding: 2px;" alt="Google Logo">
        <span>জিমেইল (Google Login) দিয়ে প্রবেশ করুন</span>
    </a>

    <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid rgba(226, 232, 240, 0.2); font-size: 12px; color: #6b7280;">
        সিস্টেম এডমিন বা ভাইভা বোর্ড পরীক্ষক?
        <a href="/admin/login" style="color: #0f766e; font-weight: 700; text-decoration: none; margin-left: 4px;">এডমিন ও পরীক্ষক সাইন ইন <i class="fa-solid fa-arrow-right-long"></i></a>
    </div>
</div>
@endsection
