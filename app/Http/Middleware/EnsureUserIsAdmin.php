<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('filament.admin.auth.login');
        }

        if ($user->email !== config('services.admin.email', 'admin@seraviva.com')) {
            auth()->logout();
            return redirect()->route('filament.admin.auth.login')->withErrors([
                'email' => 'Access denied. You do not have administrator permissions.',
            ]);
        }

        return $next($request);
    }
}
