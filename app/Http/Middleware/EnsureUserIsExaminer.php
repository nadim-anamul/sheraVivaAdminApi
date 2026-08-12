<?php

namespace App\Http\Middleware;

use App\Models\Interviewer;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsExaminer
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('filament.examiner.auth.login');
        }

        // Verify if user's email matches an active interviewer
        $exists = Interviewer::where('email', $user->email)->where('is_active', true)->exists();
        if (!$exists) {
            auth()->logout();

            return redirect()->route('filament.examiner.auth.login')->withErrors([
                'email' => 'Access denied. Your email is not registered as an active examiner.',
            ]);
        }

        return $next($request);
    }
}
