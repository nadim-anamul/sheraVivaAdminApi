<?php

namespace App\Filament\Resources\VivaPackages\Pages;

use App\Filament\Resources\VivaPackages\VivaPackageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVivaPackages extends ListRecords
{
    protected static string $resource = VivaPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
