<?php

namespace App\Filament\Examiner\Widgets;

use App\Models\Booking;
use App\Models\Interviewer;
use App\Models\Slot;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ExaminerStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $interviewerId = Interviewer::where('email', auth()->user()->email)->value('id') ?? 0;

        $totalBookings = Booking::where('interviewer_id', $interviewerId)
            ->where('payment_status', 'success')
            ->count();

        $totalSlots = Slot::where('interviewer_id', $interviewerId)->count();

        $totalEarnings = Booking::where('interviewer_id', $interviewerId)
            ->where('payment_status', 'success')
            ->sum('amount_paid');

        return [
            Stat::make('Total Bookings', $totalBookings)
                ->description('Active scheduled mock sessions')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('success'),
            Stat::make('Declared Slots', $totalSlots)
                ->description('Total availability blocks generated')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
            Stat::make('Total Earnings', number_format($totalEarnings).' BDT')
                ->description('Revenue from successful bookings')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
        ];
    }
}
