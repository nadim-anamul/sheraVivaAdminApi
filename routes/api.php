<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VivaApiController;
use App\Http\Controllers\JobUpdateApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public Authentication endpoints
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Public categories and job updates endpoints
Route::get('/viva/categories', [VivaApiController::class, 'getCategories']);
Route::get('/viva/interviewers', [VivaApiController::class, 'getInterviewers']);
Route::get('/viva/interviewers/{id}/slots', [VivaApiController::class, 'getInterviewerSlots']);
Route::get('/job-updates/circulars', [JobUpdateApiController::class, 'getCirculars']);
Route::get('/job-updates/results', [JobUpdateApiController::class, 'getResults']);

// Private, Sanctum token-secured candidate endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    Route::post('/viva/sessions', [VivaApiController::class, 'saveSession']);
    Route::get('/viva/sessions', [VivaApiController::class, 'getHistory']);
    Route::get('/viva/sessions/{id}/evaluation', [VivaApiController::class, 'getEvaluation']);
    Route::post('/viva/get-token', [VivaApiController::class, 'getLiveKitToken']);
    Route::post('/viva/bookings', [VivaApiController::class, 'createBooking']);
    Route::get('/dashboard/stats', [VivaApiController::class, 'getDashboardStats']);
});
