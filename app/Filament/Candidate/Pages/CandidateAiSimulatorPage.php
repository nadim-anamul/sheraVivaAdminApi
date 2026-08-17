<?php

namespace App\Filament\Candidate\Pages;

use App\Filament\Pages\AiSimulatorPage;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class CandidateAiSimulatorPage extends AiSimulatorPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPlay;

    protected static ?string $navigationLabel = 'AI Viva Simulator';

    protected static ?string $title = 'AI Viva Board Simulator (10-20 Min Practice)';

    protected static ?string $slug = 'ai-simulator';

    protected string $view = 'filament.pages.ai-simulator';
}
