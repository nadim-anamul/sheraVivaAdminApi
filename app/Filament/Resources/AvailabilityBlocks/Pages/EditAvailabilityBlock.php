<?php

namespace App\Filament\Resources\AvailabilityBlocks\Pages;

use App\Filament\Resources\AvailabilityBlocks\AvailabilityBlockResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAvailabilityBlock extends EditRecord
{
    protected static string $resource = AvailabilityBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
