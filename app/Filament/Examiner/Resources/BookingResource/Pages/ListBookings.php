<?php

namespace App\Filament\Examiner\Resources\BookingResource\Pages;

use App\Filament\Examiner\Resources\BookingResource;
use Filament\Resources\Pages\ListRecords;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
