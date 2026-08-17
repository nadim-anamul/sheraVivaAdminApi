<?php

namespace App\Filament\Resources\VivaPackages\Pages;

use App\Filament\Resources\VivaPackages\VivaPackageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVivaPackage extends EditRecord
{
    protected static string $resource = VivaPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
