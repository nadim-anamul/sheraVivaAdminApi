<?php

namespace App\Filament\Resources\MockSessions\Pages;

use App\Filament\Resources\MockSessions\MockSessionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMockSession extends CreateRecord
{
    protected static string $resource = MockSessionResource::class;
}
