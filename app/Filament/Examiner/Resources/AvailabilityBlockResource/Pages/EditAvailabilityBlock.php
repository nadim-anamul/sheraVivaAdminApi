<?php

namespace App\Filament\Examiner\Resources\AvailabilityBlockResource\Pages;

use App\Filament\Examiner\Resources\AvailabilityBlockResource;
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
