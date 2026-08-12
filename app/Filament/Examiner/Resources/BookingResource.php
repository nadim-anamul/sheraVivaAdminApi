<?php

namespace App\Filament\Examiner\Resources;

use App\Filament\Examiner\Resources\BookingResource\Pages\EditBooking;
use App\Filament\Examiner\Resources\BookingResource\Pages\ListBookings;
use App\Models\Booking;
use App\Models\Interviewer;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationLabel = 'My Booked Vivas';

    protected static ?string $modelLabel = 'Viva Booking';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('candidate_name')
                    ->label('Candidate Name')
                    ->default(fn ($record) => $record->candidate->name ?? 'N/A')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('candidate_email')
                    ->label('Candidate Email')
                    ->default(fn ($record) => $record->candidate->email ?? 'N/A')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('slot_time')
                    ->label('Scheduled Time')
                    ->default(fn ($record) => $record->slot ? "{$record->slot->start_time} - {$record->slot->end_time} on ".($record->slot->availabilityBlock->date?->format('Y-m-d') ?? 'N/A') : 'N/A')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('livekit_room_name')
                    ->label('LiveKit Room')
                    ->disabled(),
                TextInput::make('meeting_code')
                    ->label('Meeting Code')
                    ->disabled(),
                TextInput::make('payment_status')
                    ->label('Payment Status')
                    ->disabled(),
                TextInput::make('grade_score')
                    ->label('Grade Score')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->helperText('Award a score out of 100 post-viva.'),
                Textarea::make('feedback_remarks')
                    ->label('Feedback & Remarks')
                    ->rows(5)
                    ->helperText('Write your review and recommendations for the candidate.')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('candidate.name')
                    ->label('Candidate')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('candidate.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('slot.availabilityBlock.date')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('slot.start_time')
                    ->label('Start')
                    ->time('h:i A')
                    ->sortable(),
                TextColumn::make('slot.end_time')
                    ->label('End')
                    ->time('h:i A')
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('grade_score')
                    ->label('Score')
                    ->default('Pending')
                    ->sortable(),
                TextColumn::make('livekit_room_name')
                    ->label('Room')
                    ->copyable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('meeting_code')
                    ->label('Meeting Code')
                    ->copyable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()->label('Evaluate'),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $interviewerId = Interviewer::where('email', auth()->user()->email)->value('id') ?? 0;

        return parent::getEloquentQuery()->where('interviewer_id', $interviewerId);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookings::route('/'),
            'edit' => EditBooking::route('/{record}/edit'),
        ];
    }
}
