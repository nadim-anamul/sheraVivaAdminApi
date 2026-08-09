<?php

namespace App\Filament\Resources\Bookings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('candidate.name')
                    ->label('Candidate')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('interviewer.name')
                    ->label('Interviewer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount_paid')
                    ->label('Amount')
                    ->suffix(' BDT')
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('payment_trx_id')
                    ->label('Trx ID')
                    ->searchable(),
                TextColumn::make('livekit_room_name')
                    ->label('Room')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('meeting_code')
                    ->label('Meeting Code')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('grade_score')
                    ->label('Score')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
