<?php

namespace App\Filament\Resources\VivaAdvice;

use App\Filament\Resources\VivaAdvice\Pages\CreateVivaAdvice;
use App\Filament\Resources\VivaAdvice\Pages\EditVivaAdvice;
use App\Filament\Resources\VivaAdvice\Pages\ListVivaAdvice;
use App\Filament\Resources\VivaAdvice\Schemas\VivaAdviceForm;
use App\Filament\Resources\VivaAdvice\Tables\VivaAdviceTable;
use App\Models\VivaAdvice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class VivaAdviceResource extends Resource
{
    protected static ?string $model = VivaAdvice::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLightBulb;

    protected static string|UnitEnum|null $navigationGroup = 'Content & Study Library';

    protected static ?string $navigationLabel = 'Viva Advice & Tips';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return VivaAdviceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VivaAdviceTable::configure($table);
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
            'index' => ListVivaAdvice::route('/'),
            'create' => CreateVivaAdvice::route('/create'),
            'edit' => EditVivaAdvice::route('/{record}/edit'),
        ];
    }
}
