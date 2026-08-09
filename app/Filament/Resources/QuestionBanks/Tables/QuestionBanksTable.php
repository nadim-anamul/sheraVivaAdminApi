<?php

namespace App\Filament\Resources\QuestionBanks\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QuestionBanksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('exam_type')->badge()->sortable()->searchable(),
                TextColumn::make('title')->limit(40)->searchable(),
                TextColumn::make('edition'),
                TextColumn::make('subject')->searchable(),
                TextColumn::make('board')->limit(30),
                TextColumn::make('experience_rating')->badge(),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('exam_type')
                    ->options([
                        'BCS' => 'BCS',
                        'Bank' => 'Bank',
                        'Primary' => 'Primary',
                    ]),
            ]);
    }
}
