<?php

namespace App\Filament\Resources\VivaCategories;

use App\Filament\Resources\VivaCategories\Pages\CreateVivaCategory;
use App\Filament\Resources\VivaCategories\Pages\EditVivaCategory;
use App\Filament\Resources\VivaCategories\Pages\ListVivaCategories;
use App\Filament\Resources\VivaCategories\Schemas\VivaCategoryForm;
use App\Filament\Resources\VivaCategories\Tables\VivaCategoriesTable;
use App\Models\VivaCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class VivaCategoryResource extends Resource
{
    protected static ?string $model = VivaCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolder;

    protected static string|UnitEnum|null $navigationGroup = 'AI Viva Engine';

    protected static ?string $navigationLabel = 'Exam Viva Categories & Master Prompts';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return VivaCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VivaCategoriesTable::configure($table);
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
            'index' => ListVivaCategories::route('/'),
            'create' => CreateVivaCategory::route('/create'),
            'edit' => EditVivaCategory::route('/{record}/edit'),
        ];
    }
}
