<?php

namespace App\Filament\Resources\MockSessions\Pages;

use App\Filament\Resources\MockSessions\MockSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMockSessions extends ListRecords
{
    protected static string $resource = MockSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
