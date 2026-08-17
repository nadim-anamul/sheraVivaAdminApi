<?php

use App\Http\Controllers\Auth\CandidateAuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Candidate\LiveVivaController;
use App\Http\Controllers\Candidate\PackageController;
use App\Http\Controllers\Candidate\PracticeController;
use App\Http\Controllers\MeetingController;
use App\Models\Interviewer;
use App\Models\JobUpdate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $interviewers = Interviewer::where('is_active', true)
        ->withCount(['slots' => function ($q) {
            $q->where('status', 'available');
        }])
        ->get();

    $circulars = JobUpdate::where('type', 'circular')
        ->orderBy('published_date', 'desc')
        ->limit(4)
        ->get();

    $results = JobUpdate::where('type', 'result')
        ->orderBy('published_date', 'desc')
        ->limit(4)
        ->get();

    return view('welcome', compact('interviewers', 'circulars', 'results'));
});

// Legal & Google OAuth Compliance Routes
Route::get('/privacy-policy', fn () => view('privacy'))->name('privacy.policy');
Route::get('/terms-of-service', fn () => view('terms'))->name('terms.service');

// Candidate Authentication Routes
Route::get('/login', [CandidateAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [CandidateAuthController::class, 'login']);
Route::get('/register', [CandidateAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [CandidateAuthController::class, 'register']);
Route::post('/logout', [CandidateAuthController::class, 'logout'])->name('logout');

// Google OAuth Authentication Routes
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Filament Admin & Examiner Override Authentication Routes
Route::get('admin/login', [CandidateAuthController::class, 'showAdminLogin'])->name('filament.admin.auth.login');
Route::get('examiner/login', [CandidateAuthController::class, 'showAdminLogin'])->name('filament.examiner.auth.login');

// Candidate Dashboard & Features Routes (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn () => redirect()->route('filament.candidate.pages.candidate-dashboard'))->name('dashboard');
    Route::get('/viva/practice', fn () => redirect()->route('filament.candidate.pages.ai-simulator'))->name('viva.practice');
    Route::get('/viva/sessions/{id}', [PracticeController::class, 'showSessionReviewPage'])->name('viva.session.review');
    Route::get('/library', [PracticeController::class, 'showLibraryPage'])->name('candidate.library');
    Route::get('/library/{id}', [PracticeController::class, 'showLibraryItemDetailPage'])->name('candidate.library.item');
    Route::get('/job-updates', [PracticeController::class, 'showJobUpdatesPage'])->name('candidate.job_updates');
    Route::get('/guidelines', [PracticeController::class, 'showGuidelinesPage'])->name('candidate.guidelines');
    Route::get('/packages', [PackageController::class, 'showPackagesPage'])->name('candidate.packages');
    Route::post('/packages/bkash-submit', [PackageController::class, 'submitBkashPayment'])->name('candidate.payment.submit');
    Route::get('/live-vivas', [LiveVivaController::class, 'showLiveVivasPage'])->name('candidate.live_vivas');
    Route::get('/viva/join', [MeetingController::class, 'showJoinForm'])->name('viva.join.form');
    Route::post('/viva/join', [MeetingController::class, 'handleJoinForm'])->name('viva.join.handle');
    Route::get('/viva/meeting/{meeting_code}', [MeetingController::class, 'join'])->name('viva.meeting');
});
