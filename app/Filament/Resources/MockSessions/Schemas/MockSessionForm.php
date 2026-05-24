<?php

namespace App\Filament\Resources\MockSessions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MockSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('viva_category_id')
                    ->relationship('vivaCategory', 'title')
                    ->required(),
                TextInput::make('transcript')
                    ->required(),
                DateTimePicker::make('viva_date')
                    ->required(),
            ]);
    }
}
