<?php

namespace App\Filament\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\SessionGuard;

/**
 * Break Hostinger/browser redirect loops caused by a sticky session or remember
 * cookie for a user who cannot access the current panel.
 *
 * Usage: ->login(Login::class) on a Filament panel provider.
 */
class Login extends BaseLogin
{
    public function mount(): void
    {
        /** @var SessionGuard $guard */
        $guard = Filament::auth();
        $user = $guard->user();

        if ($user) {
            $panel = Filament::getCurrentOrDefaultPanel();
            $canAccess = $user instanceof FilamentUser && $user->canAccessPanel($panel);

            if (!$canAccess) {
                $guard->logout();

                if (request()->hasSession()) {
                    request()->session()->invalidate();
                    request()->session()->regenerateToken();
                }
            } else {
                redirect()->intended(Filament::getUrl());

                return;
            }
        }

        $this->form->fill();
    }
}
