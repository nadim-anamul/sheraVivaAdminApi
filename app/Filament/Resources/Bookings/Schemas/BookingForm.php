<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('slot_id')
                    ->relationship('slot', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "Slot #{$record->id} ({$record->start_time} - {$record->end_time}) by " . ($record->interviewer->name ?? 'Unknown'))
                    ->required()
                    ->helperText('Select the specific sliced time slot.'),
                Select::make('candidate_id')
                    ->relationship('candidate', 'name')
                    ->searchable()
                    ->required()
                    ->helperText('Select the candidate user booking this slot.'),
                Select::make('interviewer_id')
                    ->relationship('interviewer', 'name')
                    ->searchable()
                    ->required()
                    ->helperText('Select the assigned interviewer.'),
                TextInput::make('amount_paid')
                    ->numeric()
                    ->prefix('BDT')
                    ->default(0.00)
                    ->required(),
                Select::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'success' => 'Success',
                        'failed' => 'Failed',
                    ])
                    ->default('pending')
                    ->required(),
                TextInput::make('payment_trx_id')
                    ->maxLength(255)
                    ->placeholder('e.g. TRX_BKASH_9988'),
                TextInput::make('livekit_room_name')
                    ->maxLength(255)
                    ->placeholder('Auto-generated if left blank')
                    ->helperText('Secure WebRTC room code.'),
                TextInput::make('grade_score')
                    ->numeric()
                    ->placeholder('Post-viva score (e.g. 85)'),
                Textarea::make('feedback_remarks')
                    ->rows(3)
                    ->maxLength(65535),
            ]);
    }
}
