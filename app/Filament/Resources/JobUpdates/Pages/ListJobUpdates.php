<?php

namespace App\Filament\Resources\JobUpdates\Pages;

use App\Filament\Resources\JobUpdates\JobUpdateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJobUpdates extends ListRecords
{
    protected static string $resource = JobUpdateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
