<?php

namespace App\Filament\Resources\AvailabilityBlocks\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class AvailabilityBlockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('interviewer_id')
                    ->relationship('interviewer', 'name')
                    ->searchable()
                    ->required()
                    ->helperText('Select the interviewer who is declaring availability.'),
                DatePicker::make('date')
                    ->required()
                    ->helperText('Select the date for this availability block.'),
                TimePicker::make('start_time')
                    ->required()
                    ->seconds(false)
                    ->helperText('Select the start time (e.g. 16:00 for 4 PM).'),
                TimePicker::make('end_time')
                    ->required()
                    ->seconds(false)
                    ->helperText('Select the end time (e.g. 18:00 for 6 PM).'),
                TextInput::make('slot_duration_minutes')
                    ->numeric()
                    ->default(20)
                    ->required()
                    ->helperText('Individual interview duration (e.g., 20 minutes) to split this block into.'),
            ]);
    }
}
