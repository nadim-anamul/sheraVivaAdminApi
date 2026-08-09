<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $expectedKey = config('services.shera_viva.api_key');

        // If the key is not set or empty, allow requests in local environment as fallback
        if (empty($expectedKey)) {
            return $next($request);
        }

        // Check X-Api-Key header or api_key query param
        $apiKey = $request->header('X-Api-Key') ?? $request->query('api_key');

        if ($apiKey !== $expectedKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: Invalid or missing API Key.',
            ], 401);
        }

        return $next($request);
    }
}
