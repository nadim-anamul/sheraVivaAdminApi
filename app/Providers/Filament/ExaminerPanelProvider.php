<?php

namespace App\Providers\Filament;

use App\Filament\Auth\Login;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ExaminerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('examiner')
            ->path('examiner')
            ->login(Login::class)
            ->brandLogo(fn () => view('filament.logo'))
            ->font('Instrument Sans')
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->navigationItems([
                NavigationItem::make('Go to Front Portal')
                    ->url('/')
                    ->icon('heroicon-o-home')
                    ->sort(-1),
            ])
            ->discoverResources(in: app_path('Filament/Examiner/Resources'), for: 'App\Filament\Examiner\Resources')
            ->discoverPages(in: app_path('Filament/Examiner/Pages'), for: 'App\Filament\Examiner\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Examiner/Widgets'), for: 'App\Filament\Examiner\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                // AuthenticateSession intentionally omitted: with remember cookies +
                // password sync it causes ERR_TOO_MANY_REDIRECTS on Hostinger.
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
