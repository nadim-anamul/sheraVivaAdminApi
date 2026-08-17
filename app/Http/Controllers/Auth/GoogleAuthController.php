<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect candidate to Google OAuth page.
     */
    public function redirectToGoogle()
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->route('login')->with('error', 'Google OAuth credentials (GOOGLE_CLIENT_ID & GOOGLE_CLIENT_SECRET) are missing in server .env file.');
        }

        try {
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google Login error: '.$e->getMessage());
        }
    }

    /**
     * Handle callback response from Google OAuth.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed: '.$e->getMessage());
        }

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if (!$user) {
            $freeCredits = (int) SystemSetting::get('free_ai_viva_credits', 1);

            $user = User::create([
                'google_id' => $googleUser->getId(),
                'name' => $googleUser->getName() ?? 'Candidate',
                'email' => $googleUser->getEmail(),
                'avatar' => $googleUser->getAvatar(),
                'password' => Hash::make(Str::random(16)),
                'ai_viva_credits' => $freeCredits,
                'role' => 'candidate',
            ]);
        } else {
            // Update Google ID or avatar if missing
            if (empty($user->google_id) || empty($user->avatar)) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar() ?? $user->avatar,
                ]);
            }
        }

        Auth::login($user, true);

        return redirect()->route('filament.candidate.pages.candidate-dashboard')->with('success', 'Logged in successfully via Google!');
    }
}
