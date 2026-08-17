<?php

namespace App\Filament\Candidate\Pages;

use App\Models\LiveVivaBooking;
use App\Models\MockSession;
use App\Models\SessionEvaluation;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class CandidateDashboard extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $navigationLabel = 'Candidate Dashboard';

    protected static ?string $title = 'Candidate Portal Dashboard';

    protected string $view = 'filament.candidate.pages.candidate-dashboard';

    public int $aiCredits = 0;

    public int $totalSessions = 0;

    public int $averageScore = 0;

    public int $liveBookingsCount = 0;

    public $recentSessions = [];

    public function mount(): void
    {
        $user = auth()->user();
        if ($user) {
            $this->aiCredits = (int) $user->ai_viva_credits;

            $this->totalSessions = MockSession::where('user_id', $user->id)->count();

            $sessionIds = MockSession::where('user_id', $user->id)->pluck('id');
            $avg = SessionEvaluation::whereIn('mock_session_id', $sessionIds)->avg('score');
            $this->averageScore = $avg ? (int) round($avg) : 0;

            $this->liveBookingsCount = LiveVivaBooking::where('candidate_id', $user->id)->count();

            $this->recentSessions = MockSession::where('user_id', $user->id)
                ->with(['vivaCategory', 'evaluation'])
                ->orderBy('id', 'desc')
                ->limit(5)
                ->get();
        }
    }
}
