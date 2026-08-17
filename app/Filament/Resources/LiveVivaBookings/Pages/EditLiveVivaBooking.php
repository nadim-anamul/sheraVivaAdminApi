<?php

namespace App\Filament\Resources\LiveVivaBookings\Pages;

use App\Filament\Resources\LiveVivaBookings\LiveVivaBookingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLiveVivaBooking extends EditRecord
{
    protected static string $resource = LiveVivaBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
