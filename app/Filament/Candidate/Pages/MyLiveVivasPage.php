<?php

namespace App\Filament\Candidate\Pages;

use App\Models\LiveVivaBooking;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class MyLiveVivasPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedVideoCamera;

    protected static ?string $navigationLabel = 'Human Live Vivas & Meet';

    protected static ?string $title = '1-on-1 Human Board Live Vivas & Video Recordings';

    protected string $view = 'filament.candidate.pages.my-live-vivas';

    public $liveVivas = [];

    public $user;

    public function mount(): void
    {
        $this->user = auth()->user();
        if ($this->user) {
            $this->liveVivas = LiveVivaBooking::where('candidate_id', $this->user->id)
                ->with('interviewer')
                ->orderBy('id', 'desc')
                ->get();
        }
    }
}
