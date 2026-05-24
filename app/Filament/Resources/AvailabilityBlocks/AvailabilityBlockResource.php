<?php

namespace App\Filament\Resources\AvailabilityBlocks;

use App\Filament\Resources\AvailabilityBlocks\Pages\CreateAvailabilityBlock;
use App\Filament\Resources\AvailabilityBlocks\Pages\EditAvailabilityBlock;
use App\Filament\Resources\AvailabilityBlocks\Pages\ListAvailabilityBlocks;
use App\Filament\Resources\AvailabilityBlocks\Schemas\AvailabilityBlockForm;
use App\Filament\Resources\AvailabilityBlocks\Tables\AvailabilityBlocksTable;
use App\Models\AvailabilityBlock;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AvailabilityBlockResource extends Resource
{
    protected static ?string $model = AvailabilityBlock::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    public static function form(Schema $schema): Schema
    {
        return AvailabilityBlockForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AvailabilityBlocksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
