<?php

namespace App\Filament\Resources\LiveVivaBookings;

use App\Filament\Resources\LiveVivaBookings\Pages\CreateLiveVivaBooking;
use App\Filament\Resources\LiveVivaBookings\Pages\EditLiveVivaBooking;
use App\Filament\Resources\LiveVivaBookings\Pages\ListLiveVivaBookings;
use App\Models\LiveVivaBooking;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class LiveVivaBookingResource extends Resource
{
    protected static ?string $model = LiveVivaBooking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedVideoCamera;

    protected static UnitEnum|string|null $navigationGroup = 'Human Board Viva';

    protected static ?string $navigationLabel = 'Human Live Viva Bookings';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('candidate_id')
                    ->relationship('candidate', 'name')
                    ->searchable()
                    ->required()
                    ->label('Candidate'),

                Select::make('interviewer_id')
                    ->relationship('interviewer', 'name')
                    ->searchable()
                    ->label('Assigned Expert Examiner'),

                TextInput::make('exam_type')
                    ->default('BCS')
                    ->required(),

                TextInput::make('target_position')
                    ->placeholder('e.g. BCS Administration Cadre'),

                DateTimePicker::make('scheduled_at')
                    ->label('Scheduled Date & Time')
                    ->required(),

                TextInput::make('google_meet_url')
                    ->label('Google Meet Link')
                    ->placeholder('https://meet.google.com/abc-defg-hij')
                    ->url()
                    ->columnSpanFull(),

                TextInput::make('recording_url')
                    ->label('Session Video Recording URL')
                    ->placeholder('https://drive.google.com/file/d/... or YouTube unlisted link')
                    ->url()
                    ->columnSpanFull(),

                Select::make('status')
                    ->options([
                        'pending_payment' => 'Pending bKash Payment',
                        'scheduled' => 'Scheduled & Meet Link Ready',
                        'completed' => 'Session Completed & Scorecard Uploaded',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),

                TextInput::make('overall_score')
                    ->numeric()
                    ->label('Overall Score (out of 100)'),

                Textarea::make('board_feedback')
                    ->label('Examiner Board Rationale & Feedback')
                    ->columnSpanFull(),

                Textarea::make('recommendations')
                    ->label('Strategic Recommendations for Candidate')
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
                    ->weight('bold'),

                TextColumn::make('interviewer.name')
                    ->label('Assigned Examiner')
                    ->default('Unassigned')
                    ->searchable(),

                TextColumn::make('exam_type')
                    ->sortable(),

                TextColumn::make('scheduled_at')
                    ->label('Slot Time')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'scheduled' => 'info',
                        'pending_payment' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('google_meet_url')
                    ->label('Google Meet Link')
                    ->copyable()
                    ->limit(25),

                TextColumn::make('recording_url')
                    ->label('Recording URL')
                    ->copyable()
                    ->limit(25),

                TextColumn::make('overall_score')
                    ->label('Score')
                    ->badge()
                    ->color('success'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLiveVivaBookings::route('/'),
            'create' => CreateLiveVivaBooking::route('/create'),
            'edit' => EditLiveVivaBooking::route('/{record}/edit'),
        ];
    }
}
