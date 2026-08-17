<?php

namespace App\Filament\Resources\VivaSessionLogs\Tables;

use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VivaSessionLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->label('ID'),
                TextColumn::make('candidate_name')
                    ->searchable()
                    ->sortable()
                    ->label('Candidate Name'),
                TextColumn::make('exam_type')
                    ->badge()
                    ->color(fn (string $state): string => match (strtoupper($state)) {
                        'BCS' => 'success',
                        'BANK' => 'info',
                        'PRIMARY' => 'danger',
                        default => 'warning',
                    })
                    ->searchable()
                    ->sortable()
                    ->label('Exam Category'),
                TextColumn::make('position')
                    ->searchable()
                    ->label('Target Position'),
                TextColumn::make('overall_score')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => $state >= 75 ? 'success' : ($state >= 60 ? 'warning' : 'danger'))
                    ->formatStateUsing(fn (int $state): string => "{$state} / 100")
                    ->label('Overall Score'),
                TextColumn::make('verdict')
                    ->searchable()
                    ->label('Verdict / Result'),
                TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Completed At'),
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->defaultSort('completed_at', 'desc');
    }
}
