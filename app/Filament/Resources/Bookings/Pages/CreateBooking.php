<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['livekit_room_name'])) {
            $data['livekit_room_name'] = 'viva_room_' . Str::lower(Str::random(8));
        }

        return $data;
    }
}
