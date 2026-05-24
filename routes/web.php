<?php

use Illuminate\Support\Facades\Route;

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
