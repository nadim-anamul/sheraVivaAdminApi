<?php

namespace App\Filament\Resources\Interviewers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InterviewerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('designation')
                    ->maxLength(255)
                    ->placeholder('e.g., Ex-BPSC Board Member'),
                Textarea::make('bio')
                    ->rows(3)
                    ->maxLength(65535),
                TextInput::make('base_price')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->helperText('Viva price in BDT (e.g. 500)'),
                TextInput::make('avatar_url')
                    ->url()
                    ->maxLength(255),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
