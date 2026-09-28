@extends('layouts.app')

@section('title', 'সেরা ভাইভা | বিসিএস ও ব্যাংক মক ভাইভা এবং এআই পোর্টাল')

@section('content')
<!-- Hero Section -->
<section class="pt-16 pb-16 relative overflow-hidden">
    <!-- Subtle Background Glow Effects -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-emerald-500/10 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 w-full grid grid-cols-1 lg:grid-cols-[1.1fr_0.9fr] gap-10 lg:gap-12 items-center relative z-10">
        
        <!-- Hero Content Left -->
        <div class="text-left">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 mb-5">
                <i class="fa-solid fa-sparkles text-amber-500"></i>
                <span>বাংলাদেশের প্রথম এআই স্মার্ট ভাইভা ও লাইভ ফিডব্যাক পোর্টাল</span>
            </span>

            <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold leading-tight text-slate-900 dark:text-white mb-5 tracking-tight">
                <span>আপনার ভাইভা বোর্ডের সর্বোচ্চ প্রস্তুতি নিন</span> <br>
                <span class="bg-gradient-to-r from-emerald-500 via-teal-400 to-indigo-500 bg-clip-text text-transparent">এআই সিমুলেটর ও লাইভ সেশনের সাথে</span>
            </h1>

            <p class="text-slate-600 dark:text-slate-300 text-base lg:text-lg mb-8 max-w-[560px] leading-relaxed">
                বিসিএস, বাংলাদেশ ব্যাংক এডিসহ সরকারি ও কর্পোরেট চাকরির ভাইভার জন্য সেরা প্রস্তুতি। ক্যাটাগরিভিত্তিক এআই মাস্টার ডিরেকশনে অনুশীলন করুন অথবা ক্যাডার অফিসার ও বিশেষজ্ঞদের সাথে সরাসরি লাইভ ভাইভা দিন।
            </p>

            <div class="flex items-center gap-3 sm:gap-4 mb-7 flex-wrap">
                <a href="{{ route('auth.google') }}" class="btn-primary py-3.5 px-6 text-sm flex items-center gap-2.5 shadow-lg shadow-emerald-500/20 no-underline hover:scale-[1.02] transition">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" style="width: 18px; height: 18px; background: #ffffff; border-radius: 50%; padding: 1px;" alt="Google">
                    <span>গুগল দিয়ে প্রবেশ করুন (১টি ফ্রি ক্রেডিট)</span>
                </a>
                <a href="/live-vivas" class="px-5 py-3.5 rounded-xl font-bold text-sm bg-indigo-600 hover:bg-indigo-700 text-white flex items-center gap-2 no-underline shadow-md shadow-indigo-600/20 transition hover:scale-[1.02]">
                    <i class="fa-solid fa-video"></i>
                    <span>লাইভ এক্সপার্ট ভাইভা</span>
                </a>
            </div>

            <div class="inline-flex items-center gap-2 bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-300 text-xs px-3.5 py-1.5 rounded-full font-bold mb-8">
                <i class="fa-solid fa-shield-check text-emerald-500"></i>
                <span>ইনস্ট্যান্ট বিকাশ পেমেন্ট • ১-ক্লিক গুগল মিট জয়েন • রিয়েল-টাইম এআই রিপোর্ট</span>
            </div>
            
            <div class="grid grid-cols-3 gap-6 border-t border-slate-200 dark:border-white/10 pt-6">
                <div>
                    <h3 class="font-display text-2xl lg:text-3xl font-extrabold text-slate-900 dark:text-white mb-0.5">{{ number_format(($stats['total_sessions'] ?? 25000) / 1000, 0) }}k+</h3>
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-0 uppercase tracking-wider">মক ভাইভা সেশন</p>
                </div>
                <div>
                    <h3 class="font-display text-2xl lg:text-3xl font-extrabold text-slate-900 dark:text-white mb-0.5">{{ $stats['total_questions'] ?? 120 }}+</h3>
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-0 uppercase tracking-wider">প্রশ্নব্যাংক সংকলন</p>
                </div>
                <div>
                    <h3 class="font-display text-2xl lg:text-3xl font-extrabold text-slate-900 dark:text-white mb-0.5">৩টি প্রধান</h3>
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-0 uppercase tracking-wider">পরীক্ষা ক্যাটাগরি</p>
                </div>
            </div>
        </div>

        <!-- Right Side: High-Tech Hero UI Dashboard Image Showcase -->
        <div class="relative flex justify-center items-center group mt-6 lg:mt-0">
            <!-- Decorative Ambient Glow Background -->
            <div class="absolute -inset-4 rounded-3xl bg-gradient-to-tr from-emerald-500/30 via-teal-500/20 to-indigo-500/30 blur-2xl opacity-80 group-hover:opacity-100 transition duration-500"></div>

            <!-- Main Floating Glass Image Showcase -->
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-200/80 dark:border-white/10 group-hover:scale-[1.01] transition duration-500 bg-[#090D1A]">
                <img src="{{ asset('images/hero_ai_viva_dashboard.png') }}" alt="Shera Viva AI Dashboard & Board Simulator" class="w-full h-auto max-w-[580px] object-cover rounded-3xl shadow-2xl">
            </div>

            <!-- Floating Pill Badge 1: Top Right -->
            <div class="absolute -top-4 -right-2 sm:-right-4 z-20 bg-slate-900/90 text-white border border-emerald-500/30 rounded-2xl px-3.5 py-2 shadow-2xl backdrop-blur-xl flex items-center gap-2.5 animate-bounce-subtle">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></div>
                <div class="flex flex-col">
                    <span class="text-[10px] text-emerald-400 font-extrabold uppercase tracking-wider">এআই ভয়েস ডায়াগনস্টিক</span>
                    <span class="text-xs font-bold text-white flex items-center gap-1">
                        ৯৮% একুরেসি রিপোর্ট
                        <i class="fa-solid fa-microphone text-emerald-400 text-[10px]"></i>
                    </span>
                </div>
            </div>

            <!-- Floating Pill Badge 2: Bottom Left -->
            <div class="absolute -bottom-4 -left-2 sm:-left-4 z-20 bg-slate-900/90 text-white border border-indigo-500/30 rounded-2xl px-3.5 py-2 shadow-2xl backdrop-blur-xl flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-xl bg-indigo-500/20 border border-indigo-500/40 text-indigo-400 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-video"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] text-indigo-400 font-extrabold uppercase tracking-wider">১-অন-১ লাইভ বোর্ড সেশন</span>
                    <span class="text-xs font-bold text-white">গুগল মিট জয়েন রেডি</span>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-16 border-t border-slate-200 dark:border-white/5 bg-slate-50 dark:bg-bg-obsidian">
    <div class="max-w-[1200px] mx-auto px-6 w-full">
        <div class="text-center mb-12">
            <h2 class="font-display text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-white mb-3">প্রধান সুবিধাসমূহ</h2>
            <p class="text-slate-600 dark:text-text-muted text-sm lg:text-base max-w-[600px] mx-auto">
                সেরা ভাইভা দিচ্ছে আপনাকে ভাইভা বোর্ডে সফল হওয়ার জন্য সর্বাধুনিক প্রযুক্তি ও গাইডলাইন।
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-bg-card border border-slate-200 dark:border-border-glow rounded-2xl p-8 hover:translate-y-[-5px] hover:border-emerald-500/40 hover:shadow-2xl transition-all duration-300">
                <div class="w-12 h-12 bg-emerald-500/10 text-emerald-600 dark:text-primary-emerald rounded-xl flex items-center justify-center text-xl mb-6">
                    <i class="fa-solid fa-robot"></i>
                </div>
                <h3 class="font-display text-lg font-bold text-slate-900 dark:text-white mb-3">এআই সিমুলেটেড বোর্ড</h3>
                <p class="text-sm text-slate-600 dark:text-text-muted leading-relaxed">
                    Gemini AI প্রযুক্তি দিয়ে তৈরি ডাইনামিক প্রশ্নে ভয়েস সিমুলেশন ও তাৎক্ষণিক স্কোরকার্ড মূল্যায়ন।
                </p>
            </div>

            <div class="bg-white dark:bg-bg-card border border-slate-200 dark:border-border-glow rounded-2xl p-8 hover:translate-y-[-5px] hover:border-emerald-500/40 hover:shadow-2xl transition-all duration-300">
                <div class="w-12 h-12 bg-emerald-500/10 text-emerald-600 dark:text-primary-emerald rounded-xl flex items-center justify-center text-xl mb-6">
                    <i class="fa-solid fa-video"></i>
                </div>
                <h3 class="font-display text-lg font-bold text-slate-900 dark:text-white mb-3">লাইভ ভাইভা সেশন</h3>
                <p class="text-sm text-slate-600 dark:text-text-muted leading-relaxed">
                    অভিজ্ঞ ক্যাডার অফিসার ও সাবেক ভাইভা বোর্ড সদস্যদের সাথে সরাসরি ভিডিও ভাইভা।
                </p>
            </div>

            <div class="bg-white dark:bg-bg-card border border-slate-200 dark:border-border-glow rounded-2xl p-8 hover:translate-y-[-5px] hover:border-emerald-500/40 hover:shadow-2xl transition-all duration-300">
                <div class="w-12 h-12 bg-emerald-500/10 text-emerald-600 dark:text-primary-emerald rounded-xl flex items-center justify-center text-xl mb-6">
                    <i class="fa-solid fa-book-open-reader"></i>
                </div>
                <h3 class="font-display text-lg font-bold text-slate-900 dark:text-white mb-3">প্রশ্নব্যাংক ও গাইডলাইন</h3>
                <p class="text-sm text-slate-600 dark:text-text-muted leading-relaxed">
                    বিসিএস ও ব্যাংক চাকরির আসল ভাইভা অভিজ্ঞতা, বোর্ড ম্যানার ও ড্রেসকোড গাইডলাইন।
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Expert Panel Section -->
<section id="experts" class="py-16 bg-white dark:bg-white/[0.01] border-t border-slate-200 dark:border-white/5">
    <div class="max-w-[1200px] mx-auto px-6 w-full">
        <div class="text-center mb-10">
            <h2 class="font-display text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-white mb-3">বোর্ড প্যানেল বিশেষজ্ঞগণ</h2>
            <p class="text-slate-600 dark:text-text-muted text-sm lg:text-base max-w-[600px] mx-auto mb-6">
                অভিজ্ঞ সাবেক আমলা, ক্যাডার অফিসার ও ব্যাংকারদের সাথে লাইভ ভাইভা স্লট বুক করুন।
            </p>

            <div class="flex justify-center gap-2.5 mb-8 flex-wrap">
                <button onclick="filterExpertsCategory('all')" id="btn-expert-all" class="expert-cat-btn text-xs font-bold py-2 px-4 rounded-full border border-emerald-500 bg-emerald-600 text-white cursor-pointer transition">সব</button>
                <button onclick="filterExpertsCategory('bcs')" id="btn-expert-bcs" class="expert-cat-btn text-xs font-bold py-2 px-4 rounded-full border border-slate-300 dark:border-white/10 bg-slate-100 dark:bg-white/5 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-white/10 cursor-pointer transition">বিসিএস</button>
                <button onclick="filterExpertsCategory('govt')" id="btn-expert-govt" class="expert-cat-btn text-xs font-bold py-2 px-4 rounded-full border border-slate-300 dark:border-white/10 bg-slate-100 dark:bg-white/5 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-white/10 cursor-pointer transition">সরকারী চাকরি</button>
                <button onclick="filterExpertsCategory('corporate')" id="btn-expert-corporate" class="expert-cat-btn text-xs font-bold py-2 px-4 rounded-full border border-slate-300 dark:border-white/10 bg-slate-100 dark:bg-white/5 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-white/10 cursor-pointer transition">কর্পোরেট</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="experts-grid">
            @forelse($interviewers as $interviewer)
                <div class="expert-card bg-white dark:bg-bg-card border border-slate-200 dark:border-border-glow rounded-2xl overflow-hidden hover:translate-y-[-5px] hover:border-blue-500/40 transition-all duration-300 flex flex-col flex-1 shadow-lg" data-designation="{{ strtolower($interviewer->designation) }}">
                    <div class="p-7 flex-1">
                        <div class="flex items-center gap-4 mb-5">
                            <img class="w-16 h-16 rounded-full object-cover border border-slate-200 dark:border-white/5" src="{{ $interviewer->avatar_url ?? 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=256&h=256&q=80' }}" alt="Examiner">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">{{ $interviewer->name }}</h3>
                                <p class="text-xs text-emerald-600 dark:text-primary-emerald font-semibold">{{ $interviewer->designation }}</p>
                            </div>
                        </div>
                        <p class="text-xs lg:text-sm text-slate-600 dark:text-text-muted leading-relaxed mb-6">{{ $interviewer->bio }}</p>
                        
                        <div class="flex items-center justify-between border-t border-slate-200 dark:border-white/5 pt-5">
                            <div class="text-left">
                                <h4 class="font-display text-lg font-bold text-slate-900 dark:text-white">৳ {{ number_format($interviewer->base_price, 0) }}</h4>
                                <span class="text-[10px] text-slate-500 dark:text-text-muted">প্রতি ২০ মিনিট সেশন</span>
                            </div>
                            <div class="bg-blue-500/10 text-blue-600 dark:text-accent-blue px-2.5 py-1 rounded-md text-[10px] font-semibold flex items-center gap-1.5 shrink-0">
                                <i class="fa-solid fa-calendar-check text-[10px]"></i> {{ $interviewer->slots_count }} টি স্লট খালি আছে
                            </div>
                        </div>
                    </div>
                    <a href="/login" class="bg-slate-50 dark:bg-white/3 border-t border-slate-200 dark:border-white/5 text-center py-4 text-slate-800 dark:text-text-main font-semibold text-xs no-underline hover:bg-emerald-600 hover:text-white transition-colors duration-200 block">
                        লাইভ ভাইভা বুক করুন <i class="fa-solid fa-arrow-right-long text-[10px] ml-1.5"></i>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center text-slate-500 dark:text-text-muted py-10 bg-white dark:bg-bg-card border border-dashed border-slate-300 dark:border-border-glow rounded-2xl">
                    বর্তমানে কোনো ভাইভা বোর্ড বিশেষজ্ঞ খালি নেই।
                </div>
            @endforelse
        </div>

        <div class="text-center mt-10">
            <a href="/login" class="btn-primary py-3 px-8 text-sm inline-flex items-center gap-2.5 shadow-lg no-underline">
                <i class="fa-solid fa-users"></i>
                <span>আরও বিশেষজ্ঞ দেখুন (See More Experts)</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Packages & Pricing Section (Dynamic Admin Data) -->
<section id="packages" class="py-16 border-t border-slate-200 dark:border-white/5 bg-slate-50 dark:bg-bg-obsidian">
    <div class="max-w-[1200px] mx-auto px-6 w-full">
        <div class="text-center mb-12">
            <span class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-primary-emerald text-xs px-3.5 py-1.5 rounded-full font-bold uppercase tracking-wider mb-3 inline-block">
                <i class="fa-solid fa-tags"></i> প্যাকেজ ও প্রাইসিং
            </span>
            <h2 class="font-display text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-white mb-3">আপনার সুবিধার প্যাকেজটি নির্বাচন করুন</h2>
            <p class="text-slate-600 dark:text-text-muted text-sm lg:text-base max-w-[600px] mx-auto">
                এডমিন প্যানেলে সংযুক্ত সকল এআই মক ভাইভা ও ১-অন-১ লাইভ ভাইভা অফারসমূহ।
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($packages as $pkg)
                <div class="bg-white dark:bg-bg-card border border-slate-200 dark:border-border-glow rounded-2xl p-6 flex flex-col justify-between hover:translate-y-[-5px] hover:border-emerald-500/40 transition-all duration-300 relative overflow-hidden shadow-lg">
                    @if($pkg->credits >= 25 && $pkg->type === 'ai_mock')
                        <div class="absolute top-3 right-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-[9px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow">
                            Best Value
                        </div>
                    @endif
                    
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wide {{ $pkg->type === 'live_human' ? 'bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20' : 'bg-emerald-500/15 text-emerald-600 dark:text-primary-emerald border border-emerald-500/20' }}">
                                {{ $pkg->type === 'live_human' ? 'লাইভ ভাইভা' : 'এআই মক' }}
                            </span>
                        </div>
                        
                        <h3 class="font-display text-lg font-bold text-slate-900 dark:text-white mb-2">{{ $pkg->name }}</h3>
                        <p class="text-xs text-slate-600 dark:text-text-muted mb-4 min-h-[36px]">{{ $pkg->description }}</p>
                        
                        <div class="bg-slate-50 dark:bg-white/3 border border-slate-200 dark:border-white/5 rounded-xl p-4 mb-5 text-center">
                            <div class="text-2xl font-extrabold text-slate-900 dark:text-white font-display mb-0.5">৳ {{ number_format($pkg->price_bdt, 0) }}</div>
                            <span class="text-[11px] text-emerald-600 dark:text-primary-emerald font-bold">
                                {{ $pkg->credits }} টি {{ $pkg->type === 'live_human' ? 'সেশন' : 'ক্রেডিট' }}
                            </span>
                        </div>
                    </div>

                    <a href="/login" class="btn-primary w-full justify-center text-xs py-2.5 no-underline">
                        এখনই শুরু করুন <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center text-slate-500 dark:text-text-muted py-8 bg-white dark:bg-bg-card border border-dashed border-slate-300 dark:border-border-glow rounded-2xl">
                    বর্তমানে কোনো ভাইভা প্যাকেজ পাওয়া যায়নি।
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Question Bank & Experience Library Highlights Section (Dynamic Admin Data) -->
<section id="library" class="py-16 border-t border-slate-200 dark:border-white/5 bg-white dark:bg-white/[0.01]">
    <div class="max-w-[1200px] mx-auto px-6 w-full">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <span class="bg-blue-500/10 border border-blue-500/20 text-blue-600 dark:text-accent-blue text-xs px-3.5 py-1.5 rounded-full font-bold uppercase tracking-wider mb-3 inline-block">
                    <i class="fa-solid fa-book-open-reader"></i> প্রশ্ন ও স্টাডি লাইব্রেরি
                </span>
                <h2 class="font-display text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-white mb-2">আসল ভাইভার প্রশ্ন ও অভিজ্ঞতা</h2>
                <p class="text-slate-600 dark:text-text-muted text-sm max-w-[550px]">
                    বিসিএস, ব্যাংক ও সরকারি ভাইভা বোর্ডের বাস্তব অভিজ্ঞতার নতুন সংকলন।
                </p>
            </div>
            <div>
                <a href="/library" class="btn-secondary text-xs py-2.5 px-4 no-underline inline-flex items-center gap-2">
                    <span>সকল প্রশ্নব্যাংক দেখুন ({{ $stats['total_questions'] ?? 120 }}+)</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($sampleQuestions as $item)
                <div class="bg-white dark:bg-bg-card border border-slate-200 dark:border-border-glow rounded-2xl p-6 flex flex-col justify-between hover:translate-y-[-5px] hover:border-blue-500/40 transition-all duration-300 shadow-md">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="bg-emerald-500/15 text-emerald-600 dark:text-primary-emerald px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide">
                                {{ $item->exam_type }} {{ $item->edition }}
                            </span>
                            @if($item->result)
                                <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20">
                                    {{ $item->result }}
                                </span>
                            @endif
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white leading-snug mb-3">
                            <a href="/library/{{ $item->id }}" class="hover:text-emerald-600 dark:hover:text-primary-emerald transition text-slate-900 dark:text-white no-underline">
                                {{ $item->title }}
                            </a>
                        </h3>
                        <div class="flex flex-wrap gap-3 text-xs text-slate-500 dark:text-text-muted mb-4">
                            @if($item->subject) 
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-book text-emerald-600 dark:text-primary-emerald"></i> {{ $item->subject }}</span> 
                            @endif
                            @if($item->board) 
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-user-tie text-emerald-600 dark:text-primary-emerald"></i> {{ Str::limit($item->board, 22) }}</span> 
                            @endif
                        </div>
                    </div>
                    <a href="/library/{{ $item->id }}" class="w-full bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 text-emerald-600 dark:text-emerald-400 border border-slate-200 dark:border-white/10 font-bold text-xs py-2 px-3 rounded-xl transition flex items-center justify-center gap-2 no-underline mt-2">
                        <i class="fa-solid fa-eye"></i> বিস্তারিত পড়ুন &rarr;
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center text-slate-500 dark:text-text-muted py-8 bg-white dark:bg-bg-card border border-dashed border-slate-300 dark:border-border-glow rounded-2xl">
                    কোনো ভাইভা প্রশ্নব্যাংক পাওয়া যায়নি।
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Viva Advice & Guidelines Section (Dynamic Admin Data) -->
<section id="guidelines" class="py-16 border-t border-slate-200 dark:border-white/5 bg-slate-50 dark:bg-bg-obsidian">
    <div class="max-w-[1200px] mx-auto px-6 w-full">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <span class="bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-accent-orange text-xs px-3.5 py-1.5 rounded-full font-bold uppercase tracking-wider mb-3 inline-block">
                    <i class="fa-solid fa-lightbulb"></i> ভাইভা পরামর্শ ও নির্দেশিকা
                </span>
                <h2 class="font-display text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-white mb-2">ভাইভা বোর্ডের করণীয় ও পরামর্শ</h2>
                <p class="text-slate-600 dark:text-text-muted text-sm max-w-[550px]">
                    অভিজ্ঞ ভাইভা বোর্ড বিশেষজ্ঞদের সংগৃহীত পরামর্শ এবং বোর্ডের নিয়মাবলি পড়ুন।
                </p>
            </div>
            <div>
                <a href="/guidelines" class="btn-secondary text-xs py-2.5 px-4 no-underline inline-flex items-center gap-2">
                    <span>পূর্ণাঙ্গ গাইডলাইন দেখুন</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($advices as $adv)
                <div class="bg-white dark:bg-bg-card border border-slate-200 dark:border-border-glow rounded-2xl p-6 hover:border-amber-500/30 transition-all duration-300 flex flex-col justify-between shadow-md">
                    <div>
                        <div class="flex justify-between items-start mb-3 gap-2">
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ $adv->title }}</h3>
                            <span class="text-[9px] font-extrabold uppercase py-1 px-2.5 rounded-full bg-blue-500/15 text-blue-600 dark:text-accent-blue border border-blue-500/20">
                                {{ $adv->category }}
                            </span>
                        </div>
                        @if(!empty($adv->tips) && is_array($adv->tips))
                            <ul class="list-none pl-0 flex flex-col gap-2 my-3">
                                @foreach(array_slice($adv->tips, 0, 3) as $tip)
                                    <li class="text-xs text-slate-600 dark:text-text-muted flex items-start gap-2 leading-snug">
                                        <i class="fa-solid fa-check text-emerald-600 dark:text-primary-emerald text-[10px] mt-1 shrink-0"></i>
                                        <span>{{ $tip }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <a href="/guidelines" class="text-xs text-emerald-600 dark:text-primary-emerald font-bold hover:underline flex items-center gap-1 mt-4 no-underline">
                        আরও জানুন &rarr;
                    </a>
                </div>
            @endforeach

            @foreach($rules as $rule)
                <div class="bg-white dark:bg-bg-card border border-slate-200 dark:border-border-glow rounded-2xl p-6 hover:border-emerald-500/30 transition-all duration-300 flex flex-col justify-between shadow-md">
                    <div>
                        <div class="flex justify-between items-start mb-3 gap-2">
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ $rule->title }}</h3>
                            <span class="text-[9px] font-extrabold uppercase py-1 px-2.5 rounded-full {{ str_contains($rule->category, 'dont') ? 'bg-red-500/15 text-red-500' : 'bg-emerald-500/15 text-emerald-600 dark:text-primary-emerald' }}">
                                {{ $rule->category }}
                            </span>
                        </div>
                        @if(!empty($rule->rules) && is_array($rule->rules))
                            <ul class="list-none pl-0 flex flex-col gap-2 my-3">
                                @foreach(array_slice($rule->rules, 0, 3) as $r)
                                    <li class="text-xs text-slate-600 dark:text-text-muted flex items-start gap-2 leading-snug">
                                        <i class="fa-solid text-[10px] mt-1 shrink-0 {{ str_contains($rule->category, 'dont') ? 'fa-xmark text-red-500' : 'fa-check text-emerald-600 dark:text-primary-emerald' }}"></i>
                                        <span>{{ $r }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <a href="/guidelines" class="text-xs text-emerald-600 dark:text-primary-emerald font-bold hover:underline flex items-center gap-1 mt-4 no-underline">
                        নিয়মাবলি পড়ুন &rarr;
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Scraped Jobs Portal Section -->
<section id="jobs" class="py-16 border-t border-slate-200 dark:border-white/5 bg-white dark:bg-white/[0.01]">
    <div class="max-w-[1200px] mx-auto px-6 w-full">
        <div class="text-center mb-10">
            <h2 class="font-display text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-white mb-3">সরকারি চাকরির ক্যারিয়ার আপডেটস</h2>
            <p class="text-slate-600 dark:text-text-muted text-sm lg:text-base max-w-[600px] mx-auto mb-8">
                রিয়েল-টাইম সার্কুলার নোটিশ, বোর্ড সুপারিশ তালিকা এবং সাম্প্রতিক ফলাফলের সারসংক্ষেপ।
            </p>
            
            <div class="max-w-[500px] mx-auto relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input id="job-search-input" onkeyup="filterJobs()" type="text" class="w-full bg-white dark:bg-[#111827]/50 border border-slate-300 dark:border-border-glow rounded-xl py-3.5 pl-11 pr-4 text-slate-900 dark:text-white text-sm outline-none transition-all focus:border-emerald-500 focus:shadow-[0_0_15px_rgba(16,185,129,0.1)]" placeholder="প্রতিষ্ঠানের নাম বা পদের নাম দিয়ে খুঁজুন...">
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Left: Job Circulars -->
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-display text-lg lg:text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2.5 mb-0">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> সর্বশেষ সার্কুলার নোটিশ
                    </h3>
                    <a href="/job-updates" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 hover:underline flex items-center gap-1 no-underline">
                        <span>সব দেখুন (See All)</span> &rarr;
                    </a>
                </div>
                
                <div class="flex flex-col gap-4">
                    @foreach($circulars as $circ)
                        <div class="bg-white dark:bg-bg-card border border-slate-200 dark:border-border-glow rounded-xl p-5 hover:border-slate-300 dark:hover:border-white/15 hover:bg-slate-50 dark:hover:bg-[#111827]/90 transition-all duration-200 flex items-start justify-between gap-5 search-target shadow-sm">
                            <div class="flex-1 text-left">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-text-muted py-0.5 px-2 rounded text-[10px] font-semibold job-badge">{{ $circ->organization }}</span>
                                    <span class="bg-blue-500/15 text-blue-600 dark:text-accent-blue py-0.5 px-2 rounded text-[10px] font-bold uppercase tracking-wider">সার্কুলার</span>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white leading-snug mb-3 job-title">{{ $circ->title }}</h4>
                                <div class="flex items-center gap-4 text-[11px] text-slate-500 dark:text-text-muted">
                                    <span><i class="fa-solid fa-calendar-day mr-1"></i> প্রকাশের তারিখ: {{ $circ->published_date?->format('d M, Y') }}</span>
                                </div>
                            </div>
                            <button onclick='openJobModal({!! json_encode($circ) !!})' class="w-10 h-10 bg-slate-100 dark:bg-white/3 border border-slate-200 dark:border-border-glow rounded-xl flex items-center justify-center text-slate-500 dark:text-text-muted hover:bg-emerald-600 hover:border-emerald-600 hover:text-white transition-all duration-200 cursor-pointer">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right: Results -->
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-display text-lg lg:text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2.5 mb-0">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> পরীক্ষার ফলাফল ও সুপারিশ
                    </h3>
                    <a href="/job-updates" class="text-xs font-bold text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1 no-underline">
                        <span>সব দেখুন (See All)</span> &rarr;
                    </a>
                </div>
                
                <div class="flex flex-col gap-4">
                    @foreach($results as $res)
                        <div class="bg-white dark:bg-bg-card border border-slate-200 dark:border-border-glow rounded-xl p-5 hover:border-slate-300 dark:hover:border-white/15 hover:bg-slate-50 dark:hover:bg-[#111827]/90 transition-all duration-200 flex items-start justify-between gap-5 search-target shadow-sm">
                            <div class="flex-1 text-left">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-text-muted py-0.5 px-2 rounded text-[10px] font-semibold job-badge">{{ $res->organization }}</span>
                                    <span class="bg-emerald-500/15 text-emerald-600 dark:text-primary-emerald py-0.5 px-2 rounded text-[10px] font-bold uppercase tracking-wider">রেজাল্ট</span>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white leading-snug mb-3 job-title">{{ $res->title }}</h4>
                                <div class="flex items-center gap-4 text-[11px] text-slate-500 dark:text-text-muted">
                                    <span><i class="fa-solid fa-calendar-day mr-1"></i> প্রকাশের তারিখ: {{ $res->published_date?->format('d M, Y') }}</span>
                                </div>
                            </div>
                            <button onclick='openJobModal({!! json_encode($res) !!})' class="w-10 h-10 bg-slate-100 dark:bg-white/3 border border-slate-200 dark:border-border-glow rounded-xl flex items-center justify-center text-slate-500 dark:text-text-muted hover:bg-blue-600 hover:border-blue-600 hover:text-white transition-all duration-200 cursor-pointer">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mobile App Showcase Section -->
<section id="app" class="py-16 border-t border-slate-200 dark:border-white/5 bg-gradient-to-b from-transparent to-emerald-500/[0.04]">
    <div class="max-w-[1200px] mx-auto px-6 grid grid-cols-1 lg:grid-cols-[0.95fr_1.05fr] gap-16 items-center">
        <!-- Mockup Left -->
        <div class="relative flex justify-center order-2 lg:order-1">
            <div class="w-[280px] h-[540px] bg-slate-900 border-8 border-slate-800 rounded-[36px] shadow-2xl p-2.5 relative overflow-hidden">
                <div class="w-[120px] height-[18px] bg-slate-800 absolute top-0 left-1/2 -translate-x-1/2 rounded-b-xl z-10"></div>
                <div class="bg-slate-950 w-full h-full rounded-[24px] overflow-hidden flex flex-col border border-white/5 p-4 relative text-left">
                    <div class="flex items-center justify-between mb-5 pt-2">
                        <h5 class="text-xs font-bold text-white">Shera Viva</h5>
                        <i class="fa-solid fa-circle text-emerald-400 text-[6px] animate-pulse"></i>
                    </div>
                    <div class="bg-white/5 border border-white/10 rounded-xl p-3.5 mb-3 text-left">
                        <h6 class="text-[9px] text-slate-400 mb-1 uppercase tracking-wider">গড় এআই স্কোর</h6>
                        <p class="text-sm font-bold text-white mb-0">৮৭%</p>
                    </div>
                    <div class="grid grid-cols-2 gap-2 mb-3">
                        <div class="bg-white/5 border border-white/10 rounded-xl p-2.5 text-left">
                            <h6 class="text-[8px] text-slate-400 mb-0.5 uppercase tracking-wider">সম্পন্ন সেশন</h6>
                            <p class="text-xs font-bold text-white leading-none">১২টি সেশন</p>
                        </div>
                        <div class="bg-white/5 border border-white/10 rounded-xl p-2.5 text-left">
                            <h6 class="text-[8px] text-slate-400 mb-0.5 uppercase tracking-wider">পরবর্তী বোর্ড</h6>
                            <p class="text-xs font-bold text-blue-400 leading-none">আজ বিকাল ৪টা</p>
                        </div>
                    </div>
                    <div class="bg-emerald-500/15 border border-emerald-500/30 rounded-xl p-3 text-[10px] text-emerald-400 text-center font-bold mt-auto">
                        <i class="fa-solid fa-microphone"></i> এক্টিভ রুম চ্যানেল
                    </div>
                </div>
            </div>
            
            <div class="absolute bottom-[-20px] right-0 lg:right-10 bg-white dark:bg-bg-card border border-slate-200 dark:border-border-glow rounded-2xl p-4 flex flex-col items-center gap-2.5 shadow-2xl transition-transform duration-200 hover:scale-105 select-none">
                <div class="w-20 h-20 bg-white rounded-lg flex items-center justify-center text-slate-900 text-4xl border border-slate-200">
                    <i class="fa-solid fa-qrcode"></i>
                </div>
                <span class="text-[9px] font-bold text-slate-500 dark:text-text-muted uppercase tracking-wider">APK কোড স্ক্যান করুন</span>
            </div>
        </div>

        <!-- Showcase content Right -->
        <div class="text-left order-1 lg:order-2">
            <h2 class="font-display text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-white mb-4">আমাদের মোবাইল অ্যাপ নিয়ে যেকোনো জায়গা থেকে প্রস্তুতি নিন</h2>
            <p class="text-slate-600 dark:text-text-muted text-sm lg:text-base mb-7">
                Shera Viva অ্যান্ড্রয়েড অ্যাপ ডাউনলোড করে তাৎক্ষণিক পুশ নোটিফিকেশন এলার্ট পান, অডিও ডায়াগনস্টিক রেকর্ড করুন এবং স্লট বুকিং পরিচালনা করুন।
            </p>
            
            <div class="flex flex-col gap-4 mb-9">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 bg-emerald-500/10 text-emerald-600 dark:text-primary-emerald rounded-full flex items-center justify-center text-[10px] mt-1 shrink-0">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-900 dark:text-white mb-0.5">তাৎক্ষণিক পুশ নোটিফিকেশন</h4>
                        <p class="text-xs text-slate-600 dark:text-text-muted">ভাইভা বোর্ডের মূল্যায়ন রিপোর্ট প্রকাশের সাথে সাথে অ্যালার্ট পান।</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 bg-emerald-500/10 text-emerald-600 dark:text-primary-emerald rounded-full flex items-center justify-center text-[10px] mt-1 shrink-0">
                        <i class="fa-solid fa-volume-high"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-900 dark:text-white mb-0.5">ভয়েস রেসপন্স রেকর্ডিং</h4>
                        <p class="text-xs text-slate-600 dark:text-text-muted">আপনার উত্তরের অডিও রেকর্ড করে এআই স্পিচ অ্যানালিটিক্স পান।</p>
                    </div>
                </div>
            </div>

            <a href="#" class="btn-primary py-3 px-6 text-sm border-none inline-flex no-underline">
                <i class="fa-brands fa-google-play mr-2"></i> APK ইনস্টলার ডাউনলোড করুন
            </a>
        </div>
    </div>
</section>

<!-- Job Details Modal Overlay Markup -->
<div id="job-modal" class="modal-overlay" onclick="closeJobModal(event)">
    <div class="modal-content bg-white dark:bg-[#111827] text-slate-900 dark:text-white" onclick="event.stopPropagation()">
        <button class="modal-close" onclick="closeJobModal(event)"><i class="fa-solid fa-xmark"></i></button>
        <div class="flex gap-2 items-center">
            <span id="modal-badge" class="bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-text-muted py-0.5 px-2 rounded text-[10px] font-semibold">BPSC</span>
            <span id="modal-type" class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wide">Circular</span>
        </div>
        <h3 id="modal-title" class="font-display text-lg lg:text-xl font-bold text-slate-900 dark:text-white my-4 leading-snug">Job Title</h3>
        
        <p id="modal-description" class="text-xs lg:text-sm text-slate-600 dark:text-text-muted mb-5 leading-relaxed border-b border-slate-200 dark:border-white/5 pb-4 min-h-[40px]">Job Description Summary...</p>
        
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <div class="text-[10px] font-bold text-slate-500 dark:text-text-muted uppercase tracking-wider">Vacancies</div>
                <div id="modal-vacancies" class="text-sm font-semibold text-slate-900 dark:text-white mt-1">1026 posts</div>
            </div>
            <div>
                <div class="text-[10px] font-bold text-slate-500 dark:text-text-muted uppercase tracking-wider">Qualifications</div>
                <div id="modal-qualifications" class="text-sm font-semibold text-slate-900 dark:text-white mt-1">Graduation</div>
            </div>
            <div>
                <div class="text-[10px] font-bold text-slate-500 dark:text-text-muted uppercase tracking-wider">Published Date</div>
                <div id="modal-published" class="text-sm font-semibold text-slate-900 dark:text-white mt-1">Aug 10, 2026</div>
            </div>
            <div>
                <div class="text-[10px] font-bold text-slate-500 dark:text-text-muted uppercase tracking-wider">Application Deadline</div>
                <div id="modal-deadline" class="text-sm font-semibold text-blue-600 dark:text-accent-blue mt-1">Aug 30, 2026</div>
            </div>
        </div>
        
        <a id="modal-download-link" href="#" target="_blank" class="btn-primary w-full justify-center text-xs lg:text-sm py-2.5 no-underline">
            <i class="fa-solid fa-download"></i> Download / View PDF Notice
        </a>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Board Panel Expert Category filter
    function filterExpertsCategory(category) {
        const buttons = document.querySelectorAll('.expert-cat-btn');
        buttons.forEach(btn => {
            btn.className = 'expert-cat-btn text-xs font-bold py-2 px-4 rounded-full border border-slate-300 bg-slate-100 text-slate-700 hover:bg-slate-200 cursor-pointer transition';
        });
        
        const activeBtn = document.getElementById('btn-expert-' + category);
        if (activeBtn) {
            activeBtn.className = 'expert-cat-btn text-xs font-bold py-2 px-4 rounded-full border border-primary-emerald bg-primary-emerald text-white cursor-pointer transition';
        }

        const cards = document.querySelectorAll('.expert-card');
        cards.forEach(card => {
            const desig = (card.dataset.designation || '').toLowerCase();
            if (category === 'all') {
                card.style.display = '';
            } else if (category === 'bcs' && (desig.includes('bcs') || desig.includes('cadre') || desig.includes('বিসিএস') || desig.includes('admin') || desig.includes('executive'))) {
                card.style.display = '';
            } else if (category === 'govt' && (desig.includes('govt') || desig.includes('officer') || desig.includes('সরকারি') || desig.includes('bpsc') || desig.includes('secretary'))) {
                card.style.display = '';
            } else if (category === 'corporate' && (desig.includes('bank') || desig.includes('manager') || desig.includes('corporate') || desig.includes('ব্যাংক') || desig.includes('financial'))) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Live Client-side Job search filter
    function filterJobs() {
        const input = document.getElementById('job-search-input');
        const filter = input.value.toLowerCase();
        const items = document.getElementsByClassName('search-target');

        for (let i = 0; i < items.length; i++) {
            const title = items[i].getElementsByClassName('job-title')[0].innerText.toLowerCase();
            const badge = items[i].getElementsByClassName('job-badge')[0].innerText.toLowerCase();
            if (title.indexOf(filter) > -1 || badge.indexOf(filter) > -1) {
                items[i].style.display = "";
            } else {
                items[i].style.display = "none";
            }
        }
    }

    // Job details modal handlers
    function openJobModal(job) {
        document.getElementById('modal-badge').innerText = job.organization;
        
        const typeBadge = document.getElementById('modal-type');
        typeBadge.innerText = job.type === 'circular' ? 'Circular' : 'Result';
        typeBadge.className = job.type === 'circular' 
            ? 'px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wide bg-accent-blue/15 text-accent-blue' 
            : 'px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wide bg-primary-emerald/15 text-primary-emerald';
        
        document.getElementById('modal-title').innerText = job.title;
        document.getElementById('modal-description').innerText = job.description || 'No description summary details provided.';
        document.getElementById('modal-vacancies').innerText = job.vacancies || 'N/A';
        document.getElementById('modal-qualifications').innerText = job.qualifications || 'N/A';
        
        if (job.published_date) {
            const pubDate = new Date(job.published_date);
            document.getElementById('modal-published').innerText = pubDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        } else {
            document.getElementById('modal-published').innerText = 'N/A';
        }
        
        const deadlineEl = document.getElementById('modal-deadline');
        if (job.application_deadline) {
            const deadDate = new Date(job.application_deadline);
            deadlineEl.innerText = deadDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            deadlineEl.className = 'text-sm font-semibold text-primary-emerald mt-1';
        } else {
            deadlineEl.innerText = 'N/A';
            deadlineEl.className = 'text-sm font-semibold text-text-muted mt-1';
        }
        
        const downloadBtn = document.getElementById('modal-download-link');
        if (job.file_url) {
            downloadBtn.href = job.file_url;
            downloadBtn.style.display = 'flex';
        } else {
            downloadBtn.style.display = 'none';
        }
        
        document.getElementById('job-modal').classList.add('active');
    }

    function closeJobModal(e) {
        document.getElementById('job-modal').classList.remove('active');
    }
</script>
@endsection
