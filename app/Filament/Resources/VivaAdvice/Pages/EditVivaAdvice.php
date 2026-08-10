<?php

namespace App\Filament\Resources\VivaAdvice\Pages;

use App\Filament\Resources\VivaAdvice\VivaAdviceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVivaAdvice extends EditRecord
{
    protected static string $resource = VivaAdviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
