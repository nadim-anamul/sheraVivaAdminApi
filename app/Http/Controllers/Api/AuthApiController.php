<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthApiController extends Controller
{
    /**
     * Authenticate or register candidate via Mobile App Google Auth token/profile.
     */
    public function handleMobileGoogleLogin(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'google_id' => 'required|string',
            'avatar' => 'nullable|string',
        ]);

        $user = User::where('google_id', $request->google_id)
            ->orWhere('email', $request->email)
            ->first();

        if (!$user) {
            $freeCredits = (int) SystemSetting::get('free_ai_viva_credits', 1);

            $user = User::create([
                'google_id' => $request->google_id,
                'name' => $request->name,
                'email' => $request->email,
                'avatar' => $request->avatar,
                'password' => Hash::make(Str::random(16)),
                'ai_viva_credits' => $freeCredits,
                'role' => 'candidate',
            ]);
        } else {
            if (empty($user->google_id) || empty($user->avatar)) {
                $user->update([
                    'google_id' => $request->google_id,
                    'avatar' => $request->avatar ?? $user->avatar,
                ]);
            }
        }

        $token = $user->createToken('mobile_app_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'ai_viva_credits' => $user->ai_viva_credits,
                'role' => $user->role,
            ],
        ]);
    }

    /**
     * Get candidate credit balance and user profile.
     */
    public function getProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'ai_viva_credits' => $user->ai_viva_credits,
                'role' => $user->role,
            ],
        ]);
    }
}
