<?php

namespace App\Filament\Resources\VivaCategories\Pages;

use App\Filament\Resources\VivaCategories\VivaCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVivaCategories extends ListRecords
{
    protected static string $resource = VivaCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
