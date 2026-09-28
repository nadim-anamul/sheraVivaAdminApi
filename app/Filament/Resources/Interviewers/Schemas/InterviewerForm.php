<?php

namespace App\Filament\Resources\Interviewers\Schemas;

use App\Helpers\ImageOptimizer;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class InterviewerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('To log into the examiner panel, the examiner must register a user account with this exact email address.'),
                TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('designation')
                    ->maxLength(255)
                    ->placeholder('e.g., Ex-BPSC Board Member'),
                Textarea::make('bio')
                    ->rows(3)
                    ->maxLength(65535),
                TextInput::make('base_price')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->helperText('Viva price in BDT (e.g. 500)'),
                FileUpload::make('avatar_url')
                    ->label('Expert Avatar Picture Upload')
                    ->image()
                    ->directory('images/interviewers')
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(5120)
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, callable $get): string {
                        $name = $get('name') ? Str::slug($get('name')) : 'expert';
                        return "expert-{$name}-" . time() . '-' . Str::random(4) . '.' . $file->getClientOriginalExtension();
                    })
                    ->saveUploadedFileUsing(function (TemporaryUploadedFile $file, callable $get): string {
                        $name = $get('name') ? Str::slug($get('name')) : 'expert';
                        $originalExt = strtolower($file->getClientOriginalExtension());
                        $filename = "expert-{$name}-" . time() . '-' . Str::random(4) . '.' . $originalExt;
                        
                        $storedRelativePath = $file->storeAs('images/interviewers', $filename, 'public');
                        $fullPath = storage_path('app/public/' . $storedRelativePath);
                        
                        $optimizedFullPath = ImageOptimizer::optimizeAndConvertToWebp($fullPath, 600, 600, 85);
                        
                        return 'images/interviewers/' . basename($optimizedFullPath);
                    })
                    ->helperText('Upload profile image for expert (PNG / JPG / WEBP). Image will be automatically renamed & optimized to WebP.'),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
