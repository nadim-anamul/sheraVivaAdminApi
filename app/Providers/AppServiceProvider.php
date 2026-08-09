<?php

namespace App\Providers;

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
        // Automatically sync admin user in DB with .env credentials during login attempts
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Attempting::class,
            function (\Illuminate\Auth\Events\Attempting $event) {
                $credentials = $event->credentials;
                $adminEmail = config('services.admin.email');
                $adminPassword = config('services.admin.password');

                if ($adminEmail && $adminPassword && isset($credentials['email']) && $credentials['email'] === $adminEmail) {
                    if (isset($credentials['password']) && $credentials['password'] === $adminPassword) {
                        \App\Models\User::updateOrCreate(
                            ['email' => $adminEmail],
                            [
                                'name' => 'Admin Manager',
                                'password' => $adminPassword,
                            ]
                        );
                    }
                }
            }
        );
    }
}
