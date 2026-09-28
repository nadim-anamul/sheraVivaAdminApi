<?php

namespace App\Filament\Resources\VivaCategories\Pages;

use App\Filament\Resources\VivaCategories\VivaCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVivaCategory extends EditRecord
{
    protected static string $resource = VivaCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
