<?php

namespace App\Filament\Resources\VivaRules\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VivaRuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Select::make('category')
                    ->options([
                        'general' => 'General Guidelines',
                        'do' => 'Do\'s (Generic)',
                        'dont' => 'Don\'ts (Generic)',
                        'bcs' => 'BCS Guidelines',
                        'bcs_do' => 'BCS Do\'s',
                        'bcs_dont' => 'BCS Don\'ts',
                        'bank' => 'Bank Guidelines',
                        'bank_do' => 'Bank Do\'s',
                        'bank_dont' => 'Bank Don\'ts',
                        'primary' => 'Primary Guidelines',
                        'primary_do' => 'Primary Do\'s',
                        'primary_dont' => 'Primary Don\'ts',
                    ])
                    ->required()
                    ->default('general'),
                TagsInput::make('rules')
                    ->label('Rules List')
                    ->placeholder('Add a rule and press enter'),
                Toggle::make('is_active')
                    ->label('Is Active')
                    ->default(true),
                Textarea::make('content')
                    ->rows(6)
                    ->columnSpanFull(),
            ]);
    }
}
