<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobUpdateApiController;
use App\Http\Controllers\VivaApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Wrap all API endpoints under custom API Key protection middleware
Route::middleware('api.key')->group(function () {

    // Public Authentication endpoints
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Public categories, library, rules, and job updates endpoints
    Route::get('/viva/categories', [VivaApiController::class, 'getCategories']);
    Route::get('/viva/library', [VivaApiController::class, 'getQuestionLibrary']);
    Route::get('/viva/library/{id}', [VivaApiController::class, 'getQuestionBankItem']);
    Route::get('/viva/advice', [VivaApiController::class, 'getAdvice']);
    Route::get('/viva/rules', [VivaApiController::class, 'getRules']);
    Route::get('/viva/interviewers', [VivaApiController::class, 'getInterviewers']);
    Route::get('/viva/interviewers/{id}/slots', [VivaApiController::class, 'getInterviewerSlots']);
    Route::get('/job-updates/circulars', [JobUpdateApiController::class, 'getCirculars']);
    Route::get('/job-updates/results', [JobUpdateApiController::class, 'getResults']);

    // Gemini AI Viva & Evaluation endpoints (Public & Auth accessible)
    Route::post('/viva/ai/generate-question', [VivaApiController::class, 'generateAiQuestion']);
    Route::post('/viva/ai/evaluate-answer', [VivaApiController::class, 'evaluateAnswer']);

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

});
