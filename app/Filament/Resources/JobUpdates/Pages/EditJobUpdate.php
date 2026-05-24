<?php

namespace App\Filament\Resources\JobUpdates\Pages;

use App\Filament\Resources\JobUpdates\JobUpdateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJobUpdate extends EditRecord
{
    protected static string $resource = JobUpdateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
