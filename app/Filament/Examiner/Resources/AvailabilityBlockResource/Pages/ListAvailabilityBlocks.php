<?php

namespace App\Filament\Examiner\Resources\AvailabilityBlockResource\Pages;

use App\Filament\Examiner\Resources\AvailabilityBlockResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAvailabilityBlocks extends ListRecords
{
    protected static string $resource = AvailabilityBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
