@extends('layouts.app')

@section('title', 'ক্যান্ডিডেট ড্যাশবোর্ড | সেরা ভাইভা')

@section('content')
<div class="max-w-[1200px] mx-auto px-6 py-10 w-full">
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-primary-emerald/15 to-accent-blue/10 border border-border-glow rounded-2xl p-8 mb-8 relative overflow-hidden">
    <h1 class="font-display text-2xl lg:text-3xl font-extrabold mb-2 text-white">স্বাগতম, {{ Auth::user()->name }}!</h1>
    <p class="text-text-muted text-sm lg:text-base mb-5">আপনার এআই ক্রেডিট, বুকিং স্লট এবং পারফরম্যান্স রিপোর্ট পর্যালোচনা করুন।</p>
    
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('viva.practice') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition inline-flex items-center gap-2 no-underline">
            <i class="fa-solid fa-play"></i> এআই মক ভাইভা শুরু করুন
        </a>
        <a href="{{ route('candidate.library') }}" class="bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition inline-flex items-center gap-2 no-underline">
            <i class="fa-solid fa-book-bookmark"></i> প্রশ্ন ও স্টাডি লাইব্রেরি
        </a>
        <a href="{{ route('candidate.guidelines') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition inline-flex items-center gap-2 no-underline">
            <i class="fa-solid fa-gavel"></i> গাইডলাইন ও নিয়মাবলি
        </a>
        <a href="{{ route('candidate.packages') }}" class="bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition inline-flex items-center gap-2 no-underline">
            <i class="fa-solid fa-coins"></i> {{ Auth::user()->ai_viva_credits }}টি ক্রেডিট (প্যাকেজ ক্রয়)
        </a>
        <a href="{{ route('candidate.live_vivas') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition inline-flex items-center gap-2 no-underline">
            <i class="fa-solid fa-video"></i> লাইভ ভাইভা স্লট
        </a>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
    <div class="bg-bg-card border border-border-glow rounded-2xl p-6 backdrop-blur-md flex items-center gap-5 hover:translate-y-[-3px] transition-all duration-300">
        <div class="w-13 h-13 rounded-xl bg-primary-emerald/10 text-primary-emerald flex items-center justify-center text-2xl">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-display text-2xl lg:text-3xl font-extrabold text-white leading-none">{{ $totalBookings }}</h3>
            <p class="text-[10px] text-text-muted uppercase tracking-wider mt-1.5">মোট বুকিং সেশন</p>
        </div>
    </div>
    
    <div class="bg-bg-card border border-border-glow rounded-2xl p-6 backdrop-blur-md flex items-center gap-5 hover:translate-y-[-3px] transition-all duration-300">
        <div class="w-13 h-13 rounded-xl bg-accent-blue/10 text-accent-blue flex items-center justify-center text-2xl">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-display text-2xl lg:text-3xl font-extrabold text-white leading-none">{{ $completedCount }}</h3>
            <p class="text-[10px] text-text-muted uppercase tracking-wider mt-1.5">সম্পন্ন ভাইভা বোর্ড</p>
        </div>
    </div>

    <div class="bg-bg-card border border-border-glow rounded-2xl p-6 backdrop-blur-md flex items-center gap-5 hover:translate-y-[-3px] transition-all duration-300">
        <div class="w-13 h-13 rounded-xl bg-accent-orange/10 text-accent-orange flex items-center justify-center text-2xl">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-display text-2xl lg:text-3xl font-extrabold text-white leading-none">{{ $averageScore ? $averageScore . '%' : 'N/A' }}</h3>
            <p class="text-[10px] text-text-muted uppercase tracking-wider mt-1.5">গড় পারফরম্যান্স</p>
        </div>
    </div>
</div>

<!-- Requirement #8 Prominent Questions & Study Library Section -->
<div class="bg-gradient-to-r from-emerald-900/30 to-teal-900/30 border border-emerald-500/30 rounded-2xl p-6 mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
    <div class="space-y-1">
        <h3 class="font-display text-lg font-bold text-white flex items-center gap-2">
            <i class="fa-solid fa-book-open-reader text-emerald-400"></i> প্রশ্ন ও স্টাডি লাইব্রেরি (Questions & Study Library)
        </h3>
        <p class="text-xs text-text-muted max-w-2xl">
            ১২০+ বিসিএস, ব্যাংক এবং প্রাথমিক শিক্ষক নিয়োগ ভাইভার বাস্তব অভিজ্ঞতার ট্রান্সক্রিপ্ট ও ক্যাডার চয়েস প্রশ্ন ব্যাংক পড়ুন।
        </p>
    </div>
    <div class="flex items-center gap-3 shrink-0">
        <a href="{{ route('candidate.library') }}" class="btn-primary py-2.5 px-5 text-xs no-underline flex items-center gap-2 shadow-lg">
            <i class="fa-solid fa-layer-group"></i> লাইব্রেরি প্রবেশ করুন &rarr;
        </a>
    </div>
</div>

<!-- Main Dashboard Split Layout -->
<div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-8">
    
    <!-- Left Column: Viva Bookings List -->
    <div>
        <h2 class="font-display text-xl lg:text-2xl font-bold mb-5 text-white">
            আমার মক ভাইভা সেশনসমূহ
        </h2>

        @if($bookings->isEmpty())
            <div class="bg-bg-card border border-border-glow rounded-2xl p-10 text-center">
                <i class="fa-solid fa-circle-info text-3xl text-text-muted mb-3"></i>
                <h4 class="text-white font-bold mb-1.5">কোনো বুকিং পাওয়া যায়নি</h4>
                <p class="text-text-muted text-sm">আপনার প্রথম সেশন বুক করতে আমাদের লাইভ ভাইভা তালিকায় যান!</p>
            </div>
        @else
            @foreach($bookings as $booking)
                <div class="bg-bg-card border border-border-glow rounded-2xl p-6 mb-5 hover:border-white/12 transition-all duration-200">
                    <div class="flex justify-between items-start flex-wrap gap-3 mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-white mb-1">
                                {{ $booking->slot->availabilityBlock->interviewer->name ?? 'বিশেষ ভাইভা' }} বোর্ড
                            </h3>
                            <div class="flex gap-5 text-xs lg:text-sm text-text-muted flex-wrap">
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-calendar text-primary-emerald"></i> {{ $booking->slot->availabilityBlock->date?->format('d M, Y') ?? 'N/A' }}</span>
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-clock text-primary-emerald"></i> {{ $booking->slot ? \Carbon\Carbon::parse($booking->slot->start_time)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($booking->slot->end_time)->format('h:i A') : 'N/A' }}</span>
                                @if($booking->payment_status === 'success')
                                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-key text-primary-emerald"></i> কোড: <strong class="font-mono text-white tracking-wide">{{ $booking->meeting_code }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wide border @if($booking->payment_status === 'success') bg-primary-emerald/10 text-primary-emerald border-primary-emerald/20 @elseif($booking->payment_status === 'pending') bg-accent-orange/10 text-accent-orange border-accent-orange/20 @else bg-red-500/10 text-red-400 border-red-500/20 @endif">
                            {{ $booking->payment_status === 'success' ? 'সফল' : ($booking->payment_status === 'pending' ? 'অপেক্ষমাণ' : $booking->payment_status) }}
                        </span>
                    </div>

                    <div class="flex gap-5 items-center flex-wrap mb-4">
                        <img class="w-13 h-13 rounded-full object-cover border-2 border-white/8" src="{{ $booking->interviewer->avatar_url ?? 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=256&h=256&q=80' }}" alt="Examiner">
                        <div class="flex-1 min-w-[200px]">
                            <h4 class="text-base font-bold text-white">{{ $booking->interviewer->name ?? 'TBD' }}</h4>
                            <p class="text-sm text-text-muted">{{ $booking->interviewer->designation ?? 'বোর্ড প্যানেলিস্ট' }}</p>
                        </div>

                        <div>
                            @if($booking->payment_status === 'success')
                                <a href="{{ route('viva.meeting', $booking->meeting_code) }}" target="_blank" class="btn-primary animate-pulse-subtle text-xs lg:text-sm py-2 px-4 no-underline">
                                    <i class="fa-solid fa-video"></i> লাইভ রুমে যুক্ত হন
                                </a>
                            @else
                                <button class="btn-secondary text-xs lg:text-sm py-2 px-4 opacity-50 cursor-not-allowed" title="পেমেন্ট অপশন সম্পন্ন করুন" disabled>
                                    <i class="fa-solid fa-lock"></i> রুম বন্ধ
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Evaluation details -->
                    @if($booking->grade_score !== null)
                        <div class="bg-black/20 border border-border-glow rounded-xl p-4.5 mt-4">
                            <div class="flex justify-between items-center mb-2.5">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-text-muted flex items-center gap-1.5">
                                    <i class="fa-solid fa-square-poll-vertical"></i> পরীক্ষকের মূল্যায়ন
                                </h4>
                                <span class="bg-gradient-to-r from-primary-emerald to-emerald-600 text-white font-extrabold px-2.5 py-1 rounded-md text-xs font-display">স্কোর: {{ $booking->grade_score }}/১০০</span>
                            </div>
                            <p class="text-sm text-text-main line-height-normal italic">
                                "{{ $booking->feedback_remarks ?? 'কোনো লিখিত মন্তব্য প্রদান করা হয়নি।' }}"
                            </p>
                        </div>
                    @elseif($booking->payment_status === 'success')
                        <div class="bg-white/2 border border-dashed border-border-glow rounded-xl p-4.5 mt-4 text-center">
                            <p class="text-xs text-text-muted">
                                <i class="fa-solid fa-hourglass-half"></i> ভাইভা সেশন নির্ধারিত হয়েছে। সেশন শেষে মূল্যায়ন রিপোর্ট এখানে প্রদর্শিত হবে।
                            </p>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    <!-- Right Column: Upcoming Session details -->
    <div>
        @if($upcomingBooking)
            <div class="bg-bg-card border border-primary-emerald/25 border-l-4 border-l-primary-emerald rounded-2xl p-6 mb-8 relative overflow-hidden">
                <div class="flex justify-between items-center mb-5 border-b border-white/5 pb-3">
                    <h3 class="font-display text-base font-bold text-white">পরবর্তী লাইভ ভাইভা</h3>
                    <div class="bg-primary-emerald/15 text-primary-emerald px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-primary-emerald rounded-full animate-pulse-custom"></span> আসন্ন
                    </div>
                </div>

                <p class="text-xs text-text-muted mb-3">{{ $upcomingBooking->interviewer->name ?? 'প্যানেলিস্ট' }} এর সাথে লাইভ ভাইভার সময় বাকি:</p>
                
                <div class="flex gap-4 my-5" id="countdown-timer" data-timestamp="{{ $upcomingBooking->slot->availabilityBlock->date?->format('Y-m-d') }} {{ $upcomingBooking->slot->start_time }}">
                    <div class="flex-1 bg-black/25 border border-border-glow rounded-xl py-3 px-2 text-center">
                        <div class="font-display text-2xl lg:text-3xl font-extrabold text-white leading-none" id="cd-days">00</div>
                        <div class="text-[9px] text-text-muted uppercase tracking-widest mt-1">দিন</div>
                    </div>
                    <div class="flex-1 bg-black/25 border border-border-glow rounded-xl py-3 px-2 text-center">
                        <div class="font-display text-2xl lg:text-3xl font-extrabold text-white leading-none" id="cd-hours">00</div>
                        <div class="text-[9px] text-text-muted uppercase tracking-widest mt-1">ঘণ্টা</div>
                    </div>
                    <div class="flex-1 bg-black/25 border border-border-glow rounded-xl py-3 px-2 text-center">
                        <div class="font-display text-2xl lg:text-3xl font-extrabold text-white leading-none" id="cd-mins">00</div>
                        <div class="text-[9px] text-text-muted uppercase tracking-widest mt-1">মিঃ</div>
                    </div>
                    <div class="flex-1 bg-black/25 border border-border-glow rounded-xl py-3 px-2 text-center">
                        <div class="font-display text-2xl lg:text-3xl font-extrabold text-white leading-none" id="cd-secs">00</div>
                        <div class="text-[9px] text-text-muted uppercase tracking-widest mt-1">সেঃ</div>
                    </div>
                </div>

                <div class="bg-black/20 border border-border-glow rounded-xl p-3 text-xs mb-5">
                    <div class="flex items-center gap-2 text-white font-semibold mb-1">
                        <i class="fa-solid fa-circle-play text-primary-emerald"></i> রুমে জয়েন করার নির্দেশিকা:
                    </div>
                    বাটনে ক্লিক করলে মিটিং কোড <strong class="font-mono text-primary-emerald">{{ $upcomingBooking->meeting_code }}</strong> দিয়ে ওয়েব-আরটিসি লাইভ রুমে নিয়ে যাওয়া হবে। আপনার মাইক্রোফোন ও ক্যামেরা সচল আছে কিনা নিশ্চিত করুন।
                </div>

                <a href="{{ route('viva.meeting', $upcomingBooking->meeting_code) }}" target="_blank" class="btn-primary animate-pulse-subtle w-full justify-center py-3 px-5 no-underline">
                    <i class="fa-solid fa-video"></i> ভাইভা রুমে যোগ দিন
                </a>
            </div>
        @else
            <div class="bg-bg-card border border-border-glow rounded-2xl p-6 mb-8">
                <div class="flex justify-between items-center mb-5 border-b border-white/5 pb-3">
                    <h3 class="font-display text-base font-bold text-white">পরবর্তী ভাইভা বোর্ড</h3>
                </div>
                <p class="text-xs text-text-muted text-center py-5">
                    বর্তমানে নির্ধারিত কোনো লাইভ ভাইভা নেই।
                </p>
                <a href="/live-vivas" class="btn-secondary w-full justify-center text-xs no-underline">
                    ভাইভা স্লট বুক করুন
                </a>
            </div>
        @endif

        <div class="bg-bg-card border border-border-glow rounded-2xl p-5 mb-8">
            <h4 class="text-sm font-bold text-white mb-2">অ্যান্ড্রয়েড অ্যাপ ইনস্টল করুন</h4>
            <p class="text-xs text-text-muted mb-4">
                পুশ নোটিফিকেশন অ্যালার্ট পেতে ও অডিও ডায়াগনস্টিক ফিচার ব্যবহার করতে মোবাইল অ্যাপ ব্যবহার করুন।
            </p>
            <a href="#" class="btn-primary w-full justify-center text-xs py-2 px-4 border border-white/5 shadow-none no-underline">
                <i class="fa-brands fa-google-play mr-2"></i> APK ডাউনলোড করুন
            </a>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const timerContainer = document.getElementById('countdown-timer');
        if (!timerContainer) return;

        const targetTimeString = timerContainer.dataset.timestamp; // e.g. "2026-06-04 16:00:00"
        
        // Parse date correctly across browsers
        const targetDate = new Date(targetTimeString.replace(/-/g, '/')).getTime();

        const cdDays = document.getElementById('cd-days');
        const cdHours = document.getElementById('cd-hours');
        const cdMins = document.getElementById('cd-mins');
        const cdSecs = document.getElementById('cd-secs');

        function updateCountdown() {
            const now = new Date().getTime();
            const difference = targetDate - now;

            if (difference <= 0) {
                clearInterval(intervalId);
                cdDays.textContent = '00';
                cdHours.textContent = '00';
                cdMins.textContent = '00';
                cdSecs.textContent = '00';
                return;
            }

            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);

            cdDays.textContent = String(days).padStart(2, '0');
            cdHours.textContent = String(hours).padStart(2, '0');
            cdMins.textContent = String(minutes).padStart(2, '0');
            cdSecs.textContent = String(seconds).padStart(2, '0');
        }

        updateCountdown();
        const intervalId = setInterval(updateCountdown, 1000);
    });
</script>
@endsection
