<?php

namespace App\Filament\Resources\VivaSessionLogs\Pages;

use App\Filament\Resources\VivaSessionLogs\VivaSessionLogResource;
use Filament\Resources\Pages\ViewRecord;

class ViewVivaSessionLog extends ViewRecord
{
    protected static string $resource = VivaSessionLogResource::class;

    protected static string $view = 'filament.resources.viva-session-logs.view-viva-session-log';
}
