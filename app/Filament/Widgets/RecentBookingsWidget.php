<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentBookingsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Recent Platform Bookings';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::latest()->limit(5)->with(['candidate', 'interviewer', 'slot.availabilityBlock'])
            )
            ->columns([
                TextColumn::make('candidate.name')
                    ->label('Candidate')
                    ->searchable(),
                TextColumn::make('interviewer.name')
                    ->label('Interviewer')
                    ->searchable(),
                TextColumn::make('slot.availabilityBlock.date')
                    ->label('Slot Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('slot.start_time')
                    ->label('Start')
                    ->time('h:i A'),
                TextColumn::make('amount_paid')
                    ->label('Fee')
                    ->suffix(' BDT'),
                TextColumn::make('payment_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Booked At')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}
