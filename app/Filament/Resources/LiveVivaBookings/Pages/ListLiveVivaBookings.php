<?php

namespace App\Filament\Resources\LiveVivaBookings\Pages;

use App\Filament\Resources\LiveVivaBookings\LiveVivaBookingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLiveVivaBookings extends ListRecords
{
    protected static string $resource = LiveVivaBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
