<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Interviewer;
use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $adminEmail = 'admin@seraviva.com';
        $examinerEmails = Interviewer::pluck('email')->toArray();
        
        $totalCandidates = User::where('email', '!=', $adminEmail)
            ->whereNotIn('email', $examinerEmails)
            ->count();

        $totalExaminers = Interviewer::count();
        $totalBookings = Booking::count();
        
        $totalRevenue = Booking::where('payment_status', 'success')
            ->sum('amount_paid');

        return [
            Stat::make('Registered Candidates', $totalCandidates)
                ->description('Active job aspirants')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
            Stat::make('Expert Panelists', $totalExaminers)
                ->description('Active oral board examiners')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),
            Stat::make('Total Bookings', $totalBookings)
                ->description('Total slots requested')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('primary'),
            Stat::make('System Revenue', number_format($totalRevenue) . ' BDT')
                ->description('Paid checkout sessions')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
        ];
    }
}
