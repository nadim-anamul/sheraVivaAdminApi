<?php

namespace App\Filament\Resources\JobUpdates\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class JobUpdateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->options(['circular' => 'Circular', 'result' => 'Result'])
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('organization')
                    ->required(),
                TextInput::make('file_url')
                    ->url()
                    ->required(),
                TextInput::make('file_size')
                    ->required(),
                DatePicker::make('published_date')
                    ->required(),
            ]);
    }
}
