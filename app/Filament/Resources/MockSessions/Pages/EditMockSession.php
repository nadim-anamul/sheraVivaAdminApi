<?php

namespace App\Filament\Resources\MockSessions\Pages;

use App\Filament\Resources\MockSessions\MockSessionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMockSession extends EditRecord
{
    protected static string $resource = MockSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
