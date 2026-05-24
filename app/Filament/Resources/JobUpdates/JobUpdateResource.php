<?php

namespace App\Filament\Resources\JobUpdates;

use App\Filament\Resources\JobUpdates\Pages\CreateJobUpdate;
use App\Filament\Resources\JobUpdates\Pages\EditJobUpdate;
use App\Filament\Resources\JobUpdates\Pages\ListJobUpdates;
use App\Filament\Resources\JobUpdates\Schemas\JobUpdateForm;
use App\Filament\Resources\JobUpdates\Tables\JobUpdatesTable;
use App\Models\JobUpdate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JobUpdateResource extends Resource
{
    protected static ?string $model = JobUpdate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return JobUpdateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobUpdatesTable::configure($table);
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
            'index' => ListJobUpdates::route('/'),
            'create' => CreateJobUpdate::route('/create'),
            'edit' => EditJobUpdate::route('/{record}/edit'),
        ];
    }
}
