<?php

namespace App\Filament\Resources\QuestionBanks\Tables;

use App\Models\QuestionBank;
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
                TextColumn::make('edition')->searchable(),
                TextColumn::make('year')->sortable()->searchable(),
                TextColumn::make('subject')->searchable(),
                TextColumn::make('board')->limit(30)->searchable(),
                TextColumn::make('district')->searchable(),
                TextColumn::make('experience_rating')->badge(),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('exam_type')
                    ->options([
                        'BCS' => 'BCS',
                        'Bank' => 'Bank',
                        'Primary' => 'Primary',
                        'Other' => 'Other',
                    ]),
                SelectFilter::make('board')
                    ->options(fn () => QuestionBank::whereNotNull('board')
                        ->where('board', '!=', '')
                        ->distinct()
                        ->pluck('board', 'board')
                        ->toArray()
                    )
                    ->searchable(),
                SelectFilter::make('subject')
                    ->options(fn () => QuestionBank::whereNotNull('subject')
                        ->where('subject', '!=', '')
                        ->distinct()
                        ->pluck('subject', 'subject')
                        ->toArray()
                    )
                    ->searchable(),
                SelectFilter::make('edition')
                    ->options(fn () => QuestionBank::whereNotNull('edition')
                        ->where('edition', '!=', '')
                        ->distinct()
                        ->pluck('edition', 'edition')
                        ->toArray()
                    )
                    ->searchable(),
                SelectFilter::make('year')
                    ->options(fn () => QuestionBank::whereNotNull('year')
                        ->where('year', '!=', '')
                        ->distinct()
                        ->pluck('year', 'year')
                        ->toArray()
                    )
                    ->searchable(),
                SelectFilter::make('district')
                    ->options(fn () => QuestionBank::whereNotNull('district')
                        ->where('district', '!=', '')
                        ->distinct()
                        ->pluck('district', 'district')
                        ->toArray()
                    )
                    ->searchable(),
                SelectFilter::make('experience_rating')
                    ->options([
                        'Good' => 'Good',
                        'Excellent' => 'Excellent',
                        'Average' => 'Average',
                    ]),
            ]);
    }
}
