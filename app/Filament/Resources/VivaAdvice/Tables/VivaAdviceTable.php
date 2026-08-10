<?php

namespace App\Filament\Resources\VivaAdvice\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VivaAdviceTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'bcs' => 'success',
                        'bank' => 'warning',
                        'primary' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'bcs' => 'BCS Exam',
                        'bank' => 'Bank Exam',
                        'primary' => 'Primary Exam',
                        default => 'General',
                    })
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'general' => 'General',
                        'bcs' => 'BCS Exams',
                        'bank' => 'Bank Exams',
                        'primary' => 'Primary Exams',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
