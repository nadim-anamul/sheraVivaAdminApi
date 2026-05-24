<?php

namespace App\Filament\Resources\MockSessions;

use App\Filament\Resources\MockSessions\Pages\CreateMockSession;
use App\Filament\Resources\MockSessions\Pages\EditMockSession;
use App\Filament\Resources\MockSessions\Pages\ListMockSessions;
use App\Filament\Resources\MockSessions\Schemas\MockSessionForm;
use App\Filament\Resources\MockSessions\Tables\MockSessionsTable;
use App\Models\MockSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MockSessionResource extends Resource
{
    protected static ?string $model = MockSession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MockSessionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MockSessionsTable::configure($table);
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
            'index' => ListMockSessions::route('/'),
            'create' => CreateMockSession::route('/create'),
            'edit' => EditMockSession::route('/{record}/edit'),
        ];
    }
}
