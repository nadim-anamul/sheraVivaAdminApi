<?php

namespace App\Filament\Resources\JobUpdates\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class JobUpdateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->options(['circular' => 'Circular', 'result' => 'Result'])
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('organization')
                    ->required(),
                TextInput::make('vacancies'),
                TextInput::make('qualifications'),
                TextInput::make('file_url')
                    ->url()
                    ->required()
                    ->reactive(),
                FileUpload::make('file_upload_field')
                    ->label('Or Upload Circular PDF Manually')
                    ->directory('circulars')
                    ->disk('public')
                    ->acceptedFileTypes(['application/pdf'])
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $set('file_url', asset('storage/' . $state));
                            $set('file_size', '1.0 MB'); // Default fallback size for manual uploads
                        }
                    })
                    ->dehydrated(false),
                TextInput::make('file_size')
                    ->required(),
                DatePicker::make('published_date')
                    ->required(),
                DatePicker::make('application_deadline'),
                Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
