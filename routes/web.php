<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CandidateAuthController;
use App\Http\Controllers\Candidate\DashboardController;

Route::get('/', function () {
    $interviewers = \App\Models\Interviewer::where('is_active', true)
        ->withCount(['slots' => function($q) {
            $q->where('status', 'available');
        }])
        ->get();

    $circulars = \App\Models\JobUpdate::where('type', 'circular')
        ->orderBy('published_date', 'desc')
        ->limit(4)
        ->get();

    $results = \App\Models\JobUpdate::where('type', 'result')
        ->orderBy('published_date', 'desc')
        ->limit(4)
        ->get();

    return view('welcome', compact('interviewers', 'circulars', 'results'));
});

// Candidate Authentication Routes
Route::get('/login', [CandidateAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [CandidateAuthController::class, 'login']);
Route::get('/register', [CandidateAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [CandidateAuthController::class, 'register']);
Route::post('/logout', [CandidateAuthController::class, 'logout'])->name('logout');

// Candidate Dashboard & Features Routes (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/viva/practice', [App\Http\Controllers\Candidate\PracticeController::class, 'showPracticePage'])->name('viva.practice');
    Route::get('/library', [App\Http\Controllers\Candidate\PracticeController::class, 'showLibraryPage'])->name('candidate.library');
    Route::get('/job-updates', [App\Http\Controllers\Candidate\PracticeController::class, 'showJobUpdatesPage'])->name('candidate.job_updates');
    Route::get('/viva/join', [App\Http\Controllers\MeetingController::class, 'showJoinForm'])->name('viva.join.form');
    Route::post('/viva/join', [App\Http\Controllers\MeetingController::class, 'handleJoinForm'])->name('viva.join.handle');
    Route::get('/viva/meeting/{meeting_code}', [App\Http\Controllers\MeetingController::class, 'join'])->name('viva.meeting');
});
