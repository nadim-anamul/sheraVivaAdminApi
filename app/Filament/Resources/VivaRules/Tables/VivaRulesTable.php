<?php

namespace App\Filament\Resources\VivaRules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VivaRulesTable
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
                    ->color(fn (string $state): string => match (true) {
                        str_contains($state, 'dont') => 'danger',
                        str_contains($state, 'do') => 'success',
                        str_contains($state, 'bcs') => 'primary',
                        str_contains($state, 'bank') => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
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
                        default => $state,
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
