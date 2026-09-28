<?php

namespace App\Filament\Resources\VivaCategories\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VivaCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Category Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('group_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'major' => 'info',
                        'subcategory' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('parent.title')
                    ->label('Parent Major')
                    ->default('Top Level')
                    ->sortable(),

                TextColumn::make('master_direction')
                    ->label('AI Master Direction')
                    ->limit(50)
                    ->default('Default System Prompt'),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }
}
