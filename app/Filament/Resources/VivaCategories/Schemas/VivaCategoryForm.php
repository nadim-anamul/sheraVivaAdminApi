<?php

namespace App\Filament\Resources\VivaCategories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VivaCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Category Title')
                    ->placeholder('e.g. বিসিএস (BCS) or Primary Teacher')
                    ->required()
                    ->maxLength(255),

                TextInput::make('subtitle')
                    ->label('Subtitle / Tagline')
                    ->placeholder('e.g. Assistant Commissioner & Executive Magistrate')
                    ->maxLength(255),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Select::make('group_type')
                    ->label('Category Level / Group Type')
                    ->options([
                        'major' => 'Major Category (মেজর ক্যাটাগরি)',
                        'subcategory' => 'Subcategory (সাবক্যাটাগরি)',
                    ])
                    ->default('major')
                    ->required(),

                Select::make('parent_id')
                    ->label('Parent Major Category (If Subcategory)')
                    ->relationship('parent', 'title')
                    ->searchable()
                    ->nullable()
                    ->helperText('Select parent major category if this item is a subcategory (e.g. Bank AD under Bank & Govt Jobs)'),

                Textarea::make('master_direction')
                    ->label('AI Master Direction / System Prompt')
                    ->placeholder('Enter specific instructions, board interrogation style, focus topics, or guidelines for Gemini AI when generating questions for this category...')
                    ->rows(6)
                    ->columnSpanFull()
                    ->helperText('This Master Direction is fed directly into Gemini AI during viva question generation & AI Knowledge Synthesis for this exam category.'),

                Textarea::make('description')
                    ->label('Detailed Category Description')
                    ->rows(3)
                    ->columnSpanFull(),

                TextInput::make('icon_name')
                    ->label('Icon Name / Code')
                    ->default('gavel_rounded')
                    ->maxLength(255),

                TextInput::make('color_hex')
                    ->label('Badge Color Hex')
                    ->default('#0F766E')
                    ->maxLength(255),

                Toggle::make('is_active')
                    ->label('Is Active')
                    ->default(true),
            ]);
    }
}
