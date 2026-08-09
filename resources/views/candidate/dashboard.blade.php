@extends('layouts.app')

@section('title', 'Candidate Dashboard | Shera Viva')

@section('styles')
<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
    }

    @media (min-width: 992px) {
        .dashboard-grid {
            grid-template-columns: 2fr 1fr;
        }
    }

    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(59, 130, 246, 0.1) 100%);
        border: 1px solid var(--border-glow);
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .welcome-banner h1 {
        font-family: var(--font-display);
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 8px;
        color: #fff;
    }

    .welcome-banner p {
        color: var(--text-muted);
        font-size: 15px;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--border-glow);
        border-radius: 16px;
        padding: 24px;
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        border-color: rgba(255, 255, 255, 0.12);
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: rgba(16, 185, 129, 0.1);
        color: var(--primary-emerald);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .stat-card.blue .stat-icon {
        background: rgba(59, 130, 246, 0.1);
        color: var(--accent-blue);
    }

    .stat-card.orange .stat-icon {
        background: rgba(245, 158, 11, 0.1);
        color: var(--accent-orange);
    }

    .stat-info h3 {
        font-family: var(--font-display);
        font-size: 26px;
        font-weight: 800;
        color: #fff;
        line-height: 1.2;
    }

    .stat-info p {
        font-size: 12px;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Countdown Panel */
    .countdown-panel {
        background: rgba(17, 24, 39, 0.85);
        border: 1px solid rgba(16, 185, 129, 0.25);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .countdown-panel::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--primary-emerald);
    }

    .countdown-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding-bottom: 12px;
    }

    .countdown-badge {
        background: rgba(16, 185, 129, 0.15);
        color: var(--primary-emerald);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .countdown-badge span {
        width: 6px;
        height: 6px;
        background: var(--primary-emerald);
        border-radius: 50%;
        animation: pulse 1.5s infinite;
    }

    .countdown-timer-wrapper {
        display: flex;
        gap: 16px;
        margin: 20px 0;
    }

    .timer-unit {
        flex: 1;
        background: rgba(0, 0, 0, 0.25);
        border: 1px solid var(--border-glow);
        border-radius: 12px;
        padding: 12px 8px;
        text-align: center;
    }

    .timer-val {
        font-family: var(--font-display);
        font-size: 28px;
        font-weight: 800;
        color: #fff;
        line-height: 1.1;
    }

    .timer-label {
        font-size: 9px;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-top: 4px;
    }

    .booking-row {
        background: var(--bg-card);
        border: 1px solid var(--border-glow);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 20px;
        transition: border-color 0.2s ease;
    }

    .booking-row:hover {
        border-color: rgba(255, 255, 255, 0.12);
    }

    .booking-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .badge-status {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .badge-status.success {
        background: rgba(16, 185, 129, 0.1);
        color: var(--primary-emerald);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .badge-status.pending {
        background: rgba(245, 158, 11, 0.1);
        color: var(--accent-orange);
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .badge-status.failed {
        background: rgba(239, 68, 68, 0.1);
        color: #F87171;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .booking-body {
        display: flex;
        gap: 20px;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .examiner-avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.08);
    }

    .examiner-info {
        flex: 1;
        min-width: 200px;
    }

    .examiner-info h4 {
        font-size: 16px;
        font-weight: 700;
        color: #fff;
    }

    .examiner-info p {
        font-size: 13px;
        color: var(--text-muted);
    }

    .slot-meta {
        display: flex;
        gap: 20px;
        font-size: 13px;
        color: var(--text-muted);
        flex-wrap: wrap;
    }

    .slot-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .slot-meta i {
        color: var(--primary-emerald);
    }

    .feedback-box {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--border-glow);
        border-radius: 12px;
        padding: 18px;
        margin-top: 16px;
    }

    .feedback-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .score-badge {
        background: linear-gradient(135deg, var(--primary-emerald), #059669);
        color: #fff;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 13px;
        font-family: var(--font-display);
    }

    .pulse-btn {
        animation: subtle-pulse 2s infinite;
    }

    @keyframes subtle-pulse {
        0% {
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4);
        }
        50% {
            box-shadow: 0 4px 24px rgba(16, 185, 129, 0.7);
        }
        100% {
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4);
        }
    }

    @keyframes pulse {
        0% {
            transform: scale(0.9);
            opacity: 0.6;
        }
        50% {
            transform: scale(1.2);
            opacity: 1;
        }
        100% {
            transform: scale(0.9);
            opacity: 0.6;
        }
    }
</style>
@endsection

@section('content')
<div class="welcome-banner">
    <h1>Welcome back, {{ Auth::user()->name }}!</h1>
    <p>Check your booked slots, view scores and analytical feedback reviews from board panel examiners.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalBookings }}</h3>
            <p>Total Booked Vivas</p>
        </div>
    </div>
    
    <div class="stat-card blue">
        <div class="stat-icon">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $completedCount }}</h3>
            <p>Completed Boards</p>
        </div>
    </div>

    <div class="stat-card orange">
        <div class="stat-icon">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $averageScore ? $averageScore . '%' : 'N/A' }}</h3>
            <p>Average Performance</p>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Left Column: Viva Bookings list -->
    <div class="left-col">
        <h2 style="font-family: var(--font-display); font-size: 22px; font-weight: 700; margin-bottom: 20px;">
            My Viva Mock Sessions
        </h2>

        @if($bookings->isEmpty())
            <div class="booking-row" style="text-align: center; padding: 40px 20px;">
                <i class="fa-solid fa-circle-info" style="font-size: 32px; color: var(--text-muted); margin-bottom: 12px;"></i>
                <h4 style="color: #fff; margin-bottom: 6px;">No bookings found</h4>
                <p style="color: var(--text-muted); font-size: 14px;">Open our mobile app to schedule your first board mock session!</p>
            </div>
        @else
            @foreach($bookings as $booking)
                <div class="booking-row">
                    <div class="booking-header">
                        <div>
                            <h3 style="font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 4px;">
                                {{ $booking->slot->availabilityBlock->interviewer->name ?? 'Special Interview' }} Board
                            </h3>
                            <div class="slot-meta">
                                <span><i class="fa-solid fa-calendar"></i> {{ $booking->slot->availabilityBlock->date?->format('F d, Y') ?? 'N/A' }}</span>
                                <span><i class="fa-solid fa-clock"></i> {{ $booking->slot ? \Carbon\Carbon::parse($booking->slot->start_time)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($booking->slot->end_time)->format('h:i A') : 'N/A' }}</span>
                                @if($booking->payment_status === 'success')
                                    <span><i class="fa-solid fa-key"></i> Code: <strong style="font-family: monospace; color: #fff; letter-spacing: 0.05em;">{{ $booking->meeting_code }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <span class="badge-status {{ $booking->payment_status }}">
                            {{ $booking->payment_status }}
                        </span>
                    </div>

                    <div class="booking-body">
                        <img class="examiner-avatar" src="{{ $booking->interviewer->avatar_url ?? 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=256&h=256&q=80' }}" alt="Examiner">
                        <div class="examiner-info">
                            <h4>{{ $booking->interviewer->name ?? 'TBD' }}</h4>
                            <p>{{ $booking->interviewer->designation ?? 'Board Panelist' }}</p>
                        </div>

                        <div>
                            @if($booking->payment_status === 'success')
                                <a href="{{ route('viva.meeting', $booking->meeting_code) }}" target="_blank" class="btn-primary pulse-btn" style="font-size: 13px; padding: 8px 16px;">
                                    <i class="fa-solid fa-video"></i> Join Live Room
                                </a>
                            @else
                                <button class="btn-secondary" style="font-size: 13px; padding: 8px 16px; opacity: 0.5; cursor: not-allowed;" title="Payment is pending. Please complete transaction in mobile app." disabled>
                                    <i class="fa-solid fa-lock"></i> Locked Room
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Evaluation details -->
                    @if($booking->grade_score !== null)
                        <div class="feedback-box">
                            <div class="feedback-header">
                                <h4 style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">
                                    <i class="fa-solid fa-square-poll-vertical"></i> Examiner Evaluation
                                </h4>
                                <span class="score-badge">Score: {{ $booking->grade_score }}/100</span>
                            </div>
                            <p style="font-size: 14px; color: var(--text-main); line-height: 1.5;">
                                "{{ $booking->feedback_remarks ?? 'No written remarks provided.' }}"
                            </p>
                        </div>
                    @elseif($booking->payment_status === 'success')
                        <div class="feedback-box" style="background: rgba(255,255,255,0.02); border-style: dashed;">
                            <p style="font-size: 13px; color: var(--text-muted); text-align: center;">
                                <i class="fa-solid fa-hourglass-half"></i> Viva session scheduled. Score and feedback evaluation report will appear here post-viva.
                            </p>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    <!-- Right Column: Upcoming Session details -->
    <div class="right-col">
        @if($upcomingBooking)
            <div class="countdown-panel">
                <div class="countdown-header">
                    <h3 style="font-family: var(--font-display); font-size: 16px; font-weight: 700; color: #fff;">
                        Next Oral Board
                    </h3>
                    <div class="countdown-badge">
                        <span></span> Upcoming
                    </div>
                </div>

                <p style="font-size: 13px; color: var(--text-muted);">Countdown to live viva with {{ $upcomingBooking->interviewer->name ?? 'Panelist' }}:</p>
                
                <div class="countdown-timer-wrapper" id="countdown-timer" data-timestamp="{{ $upcomingBooking->slot->availabilityBlock->date?->format('Y-m-d') }} {{ $upcomingBooking->slot->start_time }}">
                    <div class="timer-unit">
                        <div class="timer-val" id="cd-days">00</div>
                        <div class="timer-label">Days</div>
                    </div>
                    <div class="timer-unit">
                        <div class="timer-val" id="cd-hours">00</div>
                        <div class="timer-label">Hrs</div>
                    </div>
                    <div class="timer-unit">
                        <div class="timer-val" id="cd-mins">00</div>
                        <div class="timer-label">Mins</div>
                    </div>
                    <div class="timer-unit">
                        <div class="timer-val" id="cd-secs">00</div>
                        <div class="timer-label">Secs</div>
                    </div>
                </div>

                <div style="background: rgba(0,0,0,0.2); border: 1px solid var(--border-glow); border-radius: 12px; padding: 12px; font-size: 13px; margin-bottom: 20px;">
                    <div style="display: flex; align-items: center; gap: 8px; color: #fff; font-weight: 600; margin-bottom: 4px;">
                        <i class="fa-solid fa-circle-play" style="color: var(--primary-emerald);"></i> Room joining instruction:
                    </div>
                    Tapping the Join button will redirect you to our WebRTC portal room using code <strong style="font-family: monospace; color: var(--primary-emerald);">{{ $upcomingBooking->meeting_code }}</strong>. Make sure your microphone and webcam are functional.
                </div>

                <a href="{{ route('viva.meeting', $upcomingBooking->meeting_code) }}" target="_blank" class="btn-primary pulse-btn" style="width: 100%; justify-content: center; padding: 12px 20px;">
                    <i class="fa-solid fa-video"></i> Start Oral Viva
                </a>
            </div>
        @else
            <div class="countdown-panel" style="border-color: var(--border-glow); background: var(--bg-card);">
                <div class="countdown-header">
                    <h3 style="font-family: var(--font-display); font-size: 16px; font-weight: 700; color: #fff;">
                        Next Oral Board
                    </h3>
                </div>
                <p style="font-size: 13px; color: var(--text-muted); text-align: center; padding: 20px 0;">
                    No upcoming live mock boards scheduled.
                </p>
                <a href="/#experts" class="btn-secondary" style="width: 100%; justify-content: center; font-size: 13px;">
                    Book a Board Slot
                </a>
            </div>
        @endif

        <div class="countdown-panel" style="border-color: var(--border-glow); background: var(--bg-card); padding: 20px;">
            <h4 style="font-size: 15px; color: #fff; margin-bottom: 12px;">Get Android App</h4>
            <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 16px;">
                Download our mobile application to get instant push notifications, perform audio diagnostics, and manage payments.
            </p>
            <a href="#" class="btn-primary" style="width: 100%; justify-content: center; font-size: 12px; padding: 8px 16px; background: #1E293B; border: 1px solid var(--border-glow); box-shadow: none;">
                <i class="fa-brands fa-google-play"></i> Download APK
            </a>
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
