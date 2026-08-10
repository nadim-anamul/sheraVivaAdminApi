<?php

namespace App\Filament\Resources\VivaRules\Pages;

use App\Filament\Resources\VivaRules\VivaRuleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVivaRules extends ListRecords
{
    protected static string $resource = VivaRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
