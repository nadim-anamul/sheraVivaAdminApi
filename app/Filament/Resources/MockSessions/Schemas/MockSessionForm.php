<?php

namespace App\Filament\Resources\MockSessions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

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
                DateTimePicker::make('viva_date')
                    ->required(),
                
                Repeater::make('transcript')
                    ->label('Mock Session Conversation Transcript')
                    ->schema([
                        Select::make('speaker')
                            ->options([
                                'Chairman' => 'Chairman',
                                'Board Member 1' => 'Board Member 1',
                                'Board Member 2' => 'Board Member 2',
                                'Candidate' => 'Candidate',
                                'External Examiner' => 'External Examiner',
                            ])
                            ->required()
                            ->default('Chairman'),
                        Textarea::make('text')
                            ->label('Statement / Response')
                            ->required()
                            ->rows(3),
                    ])
                    ->collapsible()
                    ->cloneable()
                    ->reorderable()
                    ->itemLabel(fn (array $state): ?string => ($state['speaker'] ?? 'Speaker') . ': ' . (isset($state['text']) ? Str::limit($state['text'], 50) : ''))
                    ->columnSpanFull()
            ]);
    }
}
