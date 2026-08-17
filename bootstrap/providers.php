<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\Filament\CandidatePanelProvider;
use App\Providers\Filament\ExaminerPanelProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
    ExaminerPanelProvider::class,
    CandidatePanelProvider::class,
];
