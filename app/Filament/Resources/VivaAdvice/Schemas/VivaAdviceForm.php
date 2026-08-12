<?php

namespace App\Filament\Resources\VivaAdvice\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VivaAdviceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Select::make('category')
                    ->options([
                        'general' => 'General / Generic',
                        'bcs' => 'BCS Exams',
                        'bank' => 'Bank Exams',
                        'primary' => 'Primary Teacher Exams',
                    ])
                    ->required()
                    ->default('general'),
                TagsInput::make('tips')
                    ->label('Bullet Tips / Points')
                    ->placeholder('Add a tip and press enter'),
                Toggle::make('is_active')
                    ->label('Is Active')
                    ->default(true),
                Textarea::make('content')
                    ->rows(6)
                    ->columnSpanFull(),
            ]);
    }
}
