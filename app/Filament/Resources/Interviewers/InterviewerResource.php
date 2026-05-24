<?php

namespace App\Filament\Resources\Interviewers;

use App\Filament\Resources\Interviewers\Pages\CreateInterviewer;
use App\Filament\Resources\Interviewers\Pages\EditInterviewer;
use App\Filament\Resources\Interviewers\Pages\ListInterviewers;
use App\Filament\Resources\Interviewers\Schemas\InterviewerForm;
use App\Filament\Resources\Interviewers\Tables\InterviewersTable;
use App\Models\Interviewer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InterviewerResource extends Resource
{
    protected static ?string $model = Interviewer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return InterviewerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InterviewersTable::configure($table);
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
            'index' => ListInterviewers::route('/'),
            'create' => CreateInterviewer::route('/create'),
            'edit' => EditInterviewer::route('/{record}/edit'),
        ];
    }
}
