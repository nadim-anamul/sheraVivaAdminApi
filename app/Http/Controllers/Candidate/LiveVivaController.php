<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\LiveVivaBooking;

class LiveVivaController extends Controller
{
    public function showLiveVivasPage()
    {
        $user = auth()->user();
        $liveVivas = LiveVivaBooking::where('candidate_id', $user->id)
            ->with('interviewer')
            ->orderBy('id', 'desc')
            ->get();

        return view('candidate.live-vivas', compact('user', 'liveVivas'));
    }
}
