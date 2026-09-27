<?php

namespace App\Filament\Resources\VivaRules;

use App\Filament\Resources\VivaRules\Pages\CreateVivaRule;
use App\Filament\Resources\VivaRules\Pages\EditVivaRule;
use App\Filament\Resources\VivaRules\Pages\ListVivaRules;
use App\Filament\Resources\VivaRules\Schemas\VivaRuleForm;
use App\Filament\Resources\VivaRules\Tables\VivaRulesTable;
use App\Models\VivaRule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class VivaRuleResource extends Resource
{
    protected static ?string $model = VivaRule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static string|UnitEnum|null $navigationGroup = 'Content & Study Library';

    protected static ?string $navigationLabel = 'Viva Rules (Do & Don\'t)';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return VivaRuleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VivaRulesTable::configure($table);
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
            'index' => ListVivaRules::route('/'),
            'create' => CreateVivaRule::route('/create'),
            'edit' => EditVivaRule::route('/{record}/edit'),
        ];
    }
}
