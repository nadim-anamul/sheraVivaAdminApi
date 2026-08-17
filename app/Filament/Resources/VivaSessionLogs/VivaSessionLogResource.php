<?php

namespace App\Filament\Resources\VivaSessionLogs;

use App\Filament\Resources\VivaSessionLogs\Pages\ListVivaSessionLogs;
use App\Filament\Resources\VivaSessionLogs\Tables\VivaSessionLogsTable;
use App\Models\VivaSessionLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VivaSessionLogResource extends Resource
{
    protected static ?string $model = VivaSessionLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $navigationLabel = 'Viva Sessions & Results';

    protected static ?string $modelLabel = 'Viva Session Log';

    protected static ?string $pluralModelLabel = 'Viva Session Logs';

    public static function table(Table $table): Table
    {
        return VivaSessionLogsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVivaSessionLogs::route('/'),
        ];
    }
}
