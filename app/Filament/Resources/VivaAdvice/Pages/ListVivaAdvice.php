<?php

namespace App\Filament\Resources\VivaAdvice\Pages;

use App\Filament\Resources\VivaAdvice\VivaAdviceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVivaAdvice extends ListRecords
{
    protected static string $resource = VivaAdviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
