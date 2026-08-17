<?php

namespace App\Filament\Candidate\Pages;

use App\Models\VivaSessionLog;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class MyVivaSessionsPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'My Viva Session Logs';

    protected static ?string $title = 'My Viva Session History & Scorecards';

    protected string $view = 'filament.candidate.pages.my-viva-sessions';

    public $sessions = [];

    public function mount(): void
    {
        $user = auth()->user();
        if ($user) {
            $this->sessions = VivaSessionLog::where('user_id', $user->id)
                ->orderBy('id', 'desc')
                ->get();
        }
    }
}
