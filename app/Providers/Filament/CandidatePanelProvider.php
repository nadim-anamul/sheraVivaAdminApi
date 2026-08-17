<?php

namespace App\Providers\Filament;

use App\Filament\Candidate\Pages\CandidateDashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
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

class CandidatePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('candidate')
            ->path('dashboard')
            ->login(false) // Auth is handled via candidate login/google auth routes
            ->brandLogo(fn () => view('filament.logo'))
            ->font('Instrument Sans')
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->renderHook(
                'panels::head.end',
                fn () => '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"><script src="https://cdn.tailwindcss.com"></script>'
            )
            ->navigationItems([
                NavigationItem::make('Public Home Page')
                    ->url('/')
                    ->icon('heroicon-o-home')
                    ->sort(-1),
            ])
            ->discoverPages(in: app_path('Filament/Candidate/Pages'), for: 'App\Filament\Candidate\Pages')
            ->pages([
                CandidateDashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Candidate/Widgets'), for: 'App\Filament\Candidate\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
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
