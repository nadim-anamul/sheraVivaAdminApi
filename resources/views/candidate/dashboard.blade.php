@extends('layouts.app')

@section('title', 'Candidate Dashboard | Shera Viva')

@section('content')
<div class="max-w-[1200px] mx-auto px-6 py-10 w-full">
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-primary-emerald/15 to-accent-blue/10 border border-border-glow rounded-2xl p-8 mb-8 relative overflow-hidden">
    <h1 class="font-display text-2xl lg:text-3xl font-extrabold mb-2 text-white">Welcome back, {{ Auth::user()->name }}!</h1>
    <p class="text-text-muted text-sm lg:text-base">Check your booked slots, view scores and analytical feedback reviews from board panel examiners.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
    <div class="bg-bg-card border border-border-glow rounded-2xl p-6 backdrop-blur-md flex items-center gap-5 hover:translate-y-[-3px] transition-all duration-300">
        <div class="w-13 h-13 rounded-xl bg-primary-emerald/10 text-primary-emerald flex items-center justify-center text-2xl">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-display text-2xl lg:text-3xl font-extrabold text-white leading-none">{{ $totalBookings }}</h3>
            <p class="text-[10px] text-text-muted uppercase tracking-wider mt-1.5">Total Booked Vivas</p>
        </div>
    </div>
    
    <div class="bg-bg-card border border-border-glow rounded-2xl p-6 backdrop-blur-md flex items-center gap-5 hover:translate-y-[-3px] transition-all duration-300">
        <div class="w-13 h-13 rounded-xl bg-accent-blue/10 text-accent-blue flex items-center justify-center text-2xl">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-display text-2xl lg:text-3xl font-extrabold text-white leading-none">{{ $completedCount }}</h3>
            <p class="text-[10px] text-text-muted uppercase tracking-wider mt-1.5">Completed Boards</p>
        </div>
    </div>

    <div class="bg-bg-card border border-border-glow rounded-2xl p-6 backdrop-blur-md flex items-center gap-5 hover:translate-y-[-3px] transition-all duration-300">
        <div class="w-13 h-13 rounded-xl bg-accent-orange/10 text-accent-orange flex items-center justify-center text-2xl">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-display text-2xl lg:text-3xl font-extrabold text-white leading-none">{{ $averageScore ? $averageScore . '%' : 'N/A' }}</h3>
            <p class="text-[10px] text-text-muted uppercase tracking-wider mt-1.5">Average Performance</p>
        </div>
    </div>
</div>

<!-- Main Dashboard Split Layout -->
<div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-8">
    
    <!-- Left Column: Viva Bookings List -->
    <div>
        <h2 class="font-display text-xl lg:text-2xl font-bold mb-5 text-white">
            My Viva Mock Sessions
        </h2>

        @if($bookings->isEmpty())
            <div class="bg-bg-card border border-border-glow rounded-2xl p-10 text-center">
                <i class="fa-solid fa-circle-info text-3xl text-text-muted mb-3"></i>
                <h4 class="text-white font-bold mb-1.5">No bookings found</h4>
                <p class="text-text-muted text-sm">Open our mobile app to schedule your first board mock session!</p>
            </div>
        @else
            @foreach($bookings as $booking)
                <div class="bg-bg-card border border-border-glow rounded-2xl p-6 mb-5 hover:border-white/12 transition-all duration-200">
                    <div class="flex justify-between items-start flex-wrap gap-3 mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-white mb-1">
                                {{ $booking->slot->availabilityBlock->interviewer->name ?? 'Special Interview' }} Board
                            </h3>
                            <div class="flex gap-5 text-xs lg:text-sm text-text-muted flex-wrap">
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-calendar text-primary-emerald"></i> {{ $booking->slot->availabilityBlock->date?->format('F d, Y') ?? 'N/A' }}</span>
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-clock text-primary-emerald"></i> {{ $booking->slot ? \Carbon\Carbon::parse($booking->slot->start_time)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($booking->slot->end_time)->format('h:i A') : 'N/A' }}</span>
                                @if($booking->payment_status === 'success')
                                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-key text-primary-emerald"></i> Code: <strong class="font-mono text-white tracking-wide">{{ $booking->meeting_code }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wide border @if($booking->payment_status === 'success') bg-primary-emerald/10 text-primary-emerald border-primary-emerald/20 @elseif($booking->payment_status === 'pending') bg-accent-orange/10 text-accent-orange border-accent-orange/20 @else bg-red-500/10 text-red-400 border-red-500/20 @endif">
                            {{ $booking->payment_status }}
                        </span>
                    </div>

                    <div class="flex gap-5 items-center flex-wrap mb-4">
                        <img class="w-13 h-13 rounded-full object-cover border-2 border-white/8" src="{{ $booking->interviewer->avatar_url ?? 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=256&h=256&q=80' }}" alt="Examiner">
                        <div class="flex-1 min-w-[200px]">
                            <h4 class="text-base font-bold text-white">{{ $booking->interviewer->name ?? 'TBD' }}</h4>
                            <p class="text-sm text-text-muted">{{ $booking->interviewer->designation ?? 'Board Panelist' }}</p>
                        </div>

                        <div>
                            @if($booking->payment_status === 'success')
                                <a href="{{ route('viva.meeting', $booking->meeting_code) }}" target="_blank" class="btn-primary animate-pulse-subtle text-xs lg:text-sm py-2 px-4">
                                    <i class="fa-solid fa-video"></i> Join Live Room
                                </a>
                            @else
                                <button class="btn-secondary text-xs lg:text-sm py-2 px-4 opacity-50 cursor-not-allowed" title="Payment is pending. Please complete transaction in mobile app." disabled>
                                    <i class="fa-solid fa-lock"></i> Locked Room
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Evaluation details -->
                    @if($booking->grade_score !== null)
                        <div class="bg-black/20 border border-border-glow rounded-xl p-4.5 mt-4">
                            <div class="flex justify-between items-center mb-2.5">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-text-muted flex items-center gap-1.5">
                                    <i class="fa-solid fa-square-poll-vertical"></i> Examiner Evaluation
                                </h4>
                                <span class="bg-gradient-to-r from-primary-emerald to-emerald-600 text-white font-extrabold px-2.5 py-1 rounded-md text-xs font-display">Score: {{ $booking->grade_score }}/100</span>
                            </div>
                            <p class="text-sm text-text-main line-height-normal italic">
                                "{{ $booking->feedback_remarks ?? 'No written remarks provided.' }}"
                            </p>
                        </div>
                    @elseif($booking->payment_status === 'success')
                        <div class="bg-white/2 border border-dashed border-border-glow rounded-xl p-4.5 mt-4 text-center">
                            <p class="text-xs text-text-muted">
                                <i class="fa-solid fa-hourglass-half"></i> Viva session scheduled. Score and feedback evaluation report will appear here post-viva.
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
                    <h3 class="font-display text-base font-bold text-white">Next Oral Board</h3>
                    <div class="bg-primary-emerald/15 text-primary-emerald px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-primary-emerald rounded-full animate-pulse-custom"></span> Upcoming
                    </div>
                </div>

                <p class="text-xs text-text-muted mb-3">Countdown to live viva with {{ $upcomingBooking->interviewer->name ?? 'Panelist' }}:</p>
                
                <div class="flex gap-4 my-5" id="countdown-timer" data-timestamp="{{ $upcomingBooking->slot->availabilityBlock->date?->format('Y-m-d') }} {{ $upcomingBooking->slot->start_time }}">
                    <div class="flex-1 bg-black/25 border border-border-glow rounded-xl py-3 px-2 text-center">
                        <div class="font-display text-2xl lg:text-3xl font-extrabold text-white leading-none" id="cd-days">00</div>
                        <div class="text-[9px] text-text-muted uppercase tracking-widest mt-1">Days</div>
                    </div>
                    <div class="flex-1 bg-black/25 border border-border-glow rounded-xl py-3 px-2 text-center">
                        <div class="font-display text-2xl lg:text-3xl font-extrabold text-white leading-none" id="cd-hours">00</div>
                        <div class="text-[9px] text-text-muted uppercase tracking-widest mt-1">Hrs</div>
                    </div>
                    <div class="flex-1 bg-black/25 border border-border-glow rounded-xl py-3 px-2 text-center">
                        <div class="font-display text-2xl lg:text-3xl font-extrabold text-white leading-none" id="cd-mins">00</div>
                        <div class="text-[9px] text-text-muted uppercase tracking-widest mt-1">Mins</div>
                    </div>
                    <div class="flex-1 bg-black/25 border border-border-glow rounded-xl py-3 px-2 text-center">
                        <div class="font-display text-2xl lg:text-3xl font-extrabold text-white leading-none" id="cd-secs">00</div>
                        <div class="text-[9px] text-text-muted uppercase tracking-widest mt-1">Secs</div>
                    </div>
                </div>

                <div class="bg-black/20 border border-border-glow rounded-xl p-3 text-xs mb-5">
                    <div class="flex items-center gap-2 text-white font-semibold mb-1">
                        <i class="fa-solid fa-circle-play text-primary-emerald"></i> Room joining instruction:
                    </div>
                    Tapping the Join button will redirect you to our WebRTC portal room using code <strong class="font-mono text-primary-emerald">{{ $upcomingBooking->meeting_code }}</strong>. Make sure your microphone and webcam are functional.
                </div>

                <a href="{{ route('viva.meeting', $upcomingBooking->meeting_code) }}" target="_blank" class="btn-primary animate-pulse-subtle w-full justify-center py-3 px-5">
                    <i class="fa-solid fa-video"></i> Start Oral Viva
                </a>
            </div>
        @else
            <div class="bg-bg-card border border-border-glow rounded-2xl p-6 mb-8">
                <div class="flex justify-between items-center mb-5 border-b border-white/5 pb-3">
                    <h3 class="font-display text-base font-bold text-white">Next Oral Board</h3>
                </div>
                <p class="text-xs text-text-muted text-center py-5">
                    No upcoming live mock boards scheduled.
                </p>
                <a href="/#experts" class="btn-secondary w-full justify-center text-xs">
                    Book a Board Slot
                </a>
            </div>
        @endif

        <div class="bg-bg-card border border-border-glow rounded-2xl p-5 mb-8">
            <h4 class="text-sm font-bold text-white mb-2">Get Android App</h4>
            <p class="text-xs text-text-muted mb-4">
                Download our mobile application to get instant push notifications, perform audio diagnostics, and manage payments.
            </p>
            <a href="#" class="btn-primary w-full justify-center text-xs py-2 px-4 bg-slate-800 hover:bg-slate-700 border border-white/5 shadow-none">
                <i class="fa-brands fa-google-play"></i> Download APK
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
