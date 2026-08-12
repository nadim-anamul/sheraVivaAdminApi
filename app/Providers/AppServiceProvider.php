<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Sync admin user from .env only when missing or password drifted.
        // Avoid re-hashing on every attempt (breaks AuthenticateSession / remember cookies).
        Event::listen(Attempting::class, function (Attempting $event): void {
            $credentials = $event->credentials;
            $adminEmail = config('services.admin.email');
            $adminPassword = config('services.admin.password');

            if (!$adminEmail || !$adminPassword) {
                return;
            }

            if (($credentials['email'] ?? null) !== $adminEmail) {
                return;
            }

            if (($credentials['password'] ?? null) !== $adminPassword) {
                return;
            }

            $admin = User::query()->where('email', $adminEmail)->first();

            if ($admin && Hash::check($adminPassword, $admin->password)) {
                return;
            }

            User::query()->updateOrCreate(
                ['email' => $adminEmail],
                [
                    'name' => 'Admin Manager',
                    'password' => $adminPassword,
                ]
            );
        });
    }
}
