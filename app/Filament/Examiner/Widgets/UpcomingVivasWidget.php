<?php

namespace App\Filament\Examiner\Widgets;

use App\Models\Booking;
use App\Models\Interviewer;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;

class UpcomingVivasWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'My Scheduled Mock Vivas';

    public function table(Table $table): Table
    {
        $interviewerId = Interviewer::where('email', auth()->user()->email)->value('id') ?? 0;

        return $table
            ->query(
                Booking::where('interviewer_id', $interviewerId)
                    ->where('payment_status', 'success')
                    ->with(['candidate', 'slot.availabilityBlock'])
            )
            ->columns([
                TextColumn::make('candidate.name')
                    ->label('Candidate Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slot.availabilityBlock.date')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('slot.start_time')
                    ->label('Start Time')
                    ->time('h:i A')
                    ->sortable(),
                TextColumn::make('slot.end_time')
                    ->label('End Time')
                    ->time('h:i A')
                    ->sortable(),
                TextColumn::make('livekit_room_name')
                    ->label('LiveKit Room')
                    ->copyable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('meeting_code')
                    ->label('Meeting Code')
                    ->copyable()
                    ->searchable(),
                TextColumn::make('grade_score')
                    ->label('Score')
                    ->default('Pending')
                    ->sortable(),
            ])
            ->actions([
                Action::make('join')
                    ->label('Join Viva')
                    ->icon('heroicon-m-video-camera')
                    ->color('success')
                    ->url(fn ($record) => route('viva.meeting', $record->meeting_code))
                    ->openUrlInNewTab(),
            ]);
    }
}
