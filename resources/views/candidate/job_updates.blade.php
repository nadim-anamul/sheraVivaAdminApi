@extends('layouts.app')

@section('title', 'চাকরির সার্কুলার ও ফলাফল | সেরা ভাইভা')

@section('content')
<div class="max-w-[1280px] mx-auto px-6 py-10 w-full space-y-8">
    
    <!-- Hero Header Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 border border-white/10 rounded-2xl p-6 lg:p-8 text-white shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="space-y-2">
            <span class="bg-emerald-500/20 text-emerald-300 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full border border-emerald-500/30">
                <i class="fa-solid fa-bell"></i> লাইভ ক্যারিয়ার আপডেট
            </span>
            <h1 class="text-2xl lg:text-3xl font-extrabold">সরকারী ও ব্যাংক চাকরির সার্কুলার এবং ফলাফল</h1>
            <p class="text-gray-300 text-xs sm:text-sm max-w-xl">
                বিসিএস, বাংলাদেশ ব্যাংক, সরকারী ব্যাংক, প্রাইমারী ও কর্পোরেট সেক্টরের সর্বশেষ নিয়োগ বিজ্ঞপ্তি এবং চূড়ান্ত ভাইভা সুপারিশ তালিকা এক নজরে দেখুন।
            </p>
        </div>
        <div class="bg-white/10 backdrop-blur-md px-4 py-3 rounded-xl border border-white/15 text-center min-w-[180px]">
            <span class="text-xs font-bold text-gray-300 uppercase block">সর্বমোট আপডেট</span>
            <span class="text-2xl font-black text-emerald-400 mt-1">{{ count($circulars) + count($results) }} টি নোটিশ</span>
        </div>
    </div>

    <!-- 2-Column Parallel Grid Layout for Circulars & Results (Req #6) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        
        <!-- Left Column: Circulars -->
        <div class="space-y-5">
            <div class="flex items-center justify-between border-b border-emerald-500/30 pb-3">
                <h2 class="font-display text-lg lg:text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2.5">
                    <i class="fa-solid fa-briefcase text-emerald-500"></i> সর্বশেষ চাকরির সার্কুলার
                </h2>
                <span class="text-xs font-bold bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 px-3 py-1 rounded-full">
                    {{ count($circulars) }} টি বিজ্ঞপ্তি
                </span>
            </div>

            <div class="space-y-4">
                @forelse($circulars as $circ)
                    <div class="bg-white dark:bg-bg-card border border-slate-200 dark:border-border-glow rounded-2xl p-5 flex flex-col gap-3 backdrop-blur-md hover:border-emerald-500/50 shadow-sm transition">
                        <div class="flex items-center justify-between">
                            <span class="bg-indigo-50 dark:bg-accent-blue/15 text-indigo-700 dark:text-accent-blue px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide border border-indigo-200 dark:border-indigo-500/20">
                                {{ $circ->organization }}
                            </span>
                            <span class="text-[11px] font-medium text-slate-500 dark:text-text-muted">
                                <i class="fa-solid fa-calendar-day mr-1 text-emerald-500"></i> {{ $circ->published_date?->format('d M, Y') }}
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white leading-snug">
                            {{ $circ->title }}
                        </h3>
                        <div class="pt-2 flex items-center justify-between">
                            <a href="{{ $circ->file_url }}" target="_blank" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-2.5 rounded-xl transition flex items-center justify-center gap-2 shadow-sm no-underline">
                                <i class="fa-solid fa-download"></i> ডাউনলোড PDF ({{ $circ->file_size }})
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-bg-card border border-slate-200 dark:border-border-glow rounded-2xl p-8 text-center text-slate-500 dark:text-text-muted text-xs">
                        কোনো সার্কুলার পাওয়া যায়নি।
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right Column: Results -->
        <div class="space-y-5">
            <div class="flex items-center justify-between border-b border-amber-500/30 pb-3">
                <h2 class="font-display text-lg lg:text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2.5">
                    <i class="fa-solid fa-award text-amber-500"></i> পরীক্ষার ফলাফল ও সুপারিশ তালিকা
                </h2>
                <span class="text-xs font-bold bg-amber-500/15 text-amber-700 dark:text-amber-300 px-3 py-1 rounded-full">
                    {{ count($results) }} টি ফলাফল
                </span>
            </div>

            <div class="space-y-4">
                @forelse($results as $res)
                    <div class="bg-white dark:bg-bg-card border border-slate-200 dark:border-border-glow rounded-2xl p-5 flex flex-col gap-3 backdrop-blur-md hover:border-amber-500/50 shadow-sm transition">
                        <div class="flex items-center justify-between">
                            <span class="bg-amber-50 dark:bg-accent-orange/15 text-amber-800 dark:text-accent-orange px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide border border-amber-200 dark:border-amber-500/20">
                                {{ $res->organization }}
                            </span>
                            <span class="text-[11px] font-medium text-slate-500 dark:text-text-muted">
                                <i class="fa-solid fa-calendar-check mr-1 text-amber-500"></i> {{ $res->published_date?->format('d M, Y') }}
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white leading-snug">
                            {{ $res->title }}
                        </h3>
                        <div class="pt-2 flex items-center justify-between">
                            <a href="{{ $res->file_url }}" target="_blank" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs py-2.5 rounded-xl transition flex items-center justify-center gap-2 shadow-sm no-underline">
                                <i class="fa-solid fa-file-pdf"></i> রেজাল্ট শিট দেখুন ({{ $res->file_size }})
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-bg-card border border-slate-200 dark:border-border-glow rounded-2xl p-8 text-center text-slate-500 dark:text-text-muted text-xs">
                        কোনো ফলাফল পাওয়া যায়নি।
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
