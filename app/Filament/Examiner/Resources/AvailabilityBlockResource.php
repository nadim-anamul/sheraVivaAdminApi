<?php

namespace App\Filament\Examiner\Resources;

use App\Filament\Examiner\Resources\AvailabilityBlockResource\Pages\CreateAvailabilityBlock;
use App\Filament\Examiner\Resources\AvailabilityBlockResource\Pages\EditAvailabilityBlock;
use App\Filament\Examiner\Resources\AvailabilityBlockResource\Pages\ListAvailabilityBlocks;
use App\Models\AvailabilityBlock;
use App\Models\Interviewer;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AvailabilityBlockResource extends Resource
{
    protected static ?string $model = AvailabilityBlock::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationLabel = 'My Availability';

    protected static ?string $modelLabel = 'Availability';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('interviewer_id')
                    ->default(fn () => Interviewer::where('email', auth()->user()->email)->value('id')),
                DatePicker::make('date')
                    ->required()
                    ->native(false)
                    ->helperText('Select the date for this availability block.'),
                TimePicker::make('start_time')
                    ->required()
                    ->seconds(false)
                    ->helperText('Select the start time.'),
                TimePicker::make('end_time')
                    ->required()
                    ->seconds(false)
                    ->helperText('Select the end time.'),
                TextInput::make('slot_duration_minutes')
                    ->numeric()
                    ->default(20)
                    ->required()
                    ->helperText('Individual slot duration in minutes.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('start_time')
                    ->time('h:i A')
                    ->sortable(),
                TextColumn::make('end_time')
                    ->time('h:i A')
                    ->sortable(),
                TextColumn::make('slot_duration_minutes')
                    ->label('Duration')
                    ->suffix(' mins')
                    ->sortable(),
                TextColumn::make('slots_count')
                    ->label('Total Slots')
                    ->counts('slots'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $interviewerId = Interviewer::where('email', auth()->user()->email)->value('id') ?? 0;

        return parent::getEloquentQuery()->where('interviewer_id', $interviewerId);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAvailabilityBlocks::route('/'),
            'create' => CreateAvailabilityBlock::route('/create'),
            'edit' => EditAvailabilityBlock::route('/{record}/edit'),
        ];
    }
}
