<?php

namespace App\Filament\Resources\VivaRules\Pages;

use App\Filament\Resources\VivaRules\VivaRuleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVivaRule extends EditRecord
{
    protected static string $resource = VivaRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
