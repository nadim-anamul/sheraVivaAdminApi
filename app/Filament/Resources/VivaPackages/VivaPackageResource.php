<?php

namespace App\Filament\Resources\VivaPackages;

use App\Filament\Resources\VivaPackages\Pages\CreateVivaPackage;
use App\Filament\Resources\VivaPackages\Pages\EditVivaPackage;
use App\Filament\Resources\VivaPackages\Pages\ListVivaPackages;
use App\Models\VivaPackage;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class VivaPackageResource extends Resource
{
    protected static ?string $model = VivaPackage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingBag;

    protected static UnitEnum|string|null $navigationGroup = 'Monetization & Billing';

    protected static ?string $navigationLabel = 'AI & Live Viva Packages';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->placeholder('e.g. Starter AI Viva Bundle'),

                Select::make('type')
                    ->options([
                        'ai_mock' => 'AI Mock Viva Credits',
                        'live_human' => '1-on-1 Human Expert Live Viva',
                    ])
                    ->required(),

                TextInput::make('credits')
                    ->numeric()
                    ->default(10)
                    ->required()
                    ->label('AI Credits Granted'),

                TextInput::make('price_bdt')
                    ->numeric()
                    ->prefix('BDT ৳')
                    ->default(100.00)
                    ->required(),

                Toggle::make('is_active')
                    ->default(true),

                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ai_mock' => 'info',
                        'live_human' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('credits')
                    ->label('Credits')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('price_bdt')
                    ->label('Price (BDT)')
                    ->money('BDT')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVivaPackages::route('/'),
            'create' => CreateVivaPackage::route('/create'),
            'edit' => EditVivaPackage::route('/{record}/edit'),
        ];
    }
}
