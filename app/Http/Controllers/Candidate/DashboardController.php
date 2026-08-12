<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show Candidate Dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Retrieve all bookings for this candidate
        $bookings = Booking::where('candidate_id', $user->id)
            ->with(['slot.availabilityBlock', 'interviewer'])
            ->orderBy('id', 'desc')
            ->get();

        // Calculate statistics
        $totalBookings = $bookings->count();

        $completedVivas = $bookings->filter(function ($b) {
            return $b->payment_status === 'success' && $b->grade_score !== null;
        });

        $completedCount = $completedVivas->count();
        $averageScore = $completedCount > 0 ? round($completedVivas->avg('grade_score')) : null;

        // Fetch the next upcoming viva session (success payment and slot date/time in future)
        $upcomingBooking = $bookings->filter(function ($b) {
            if ($b->payment_status !== 'success' || !$b->slot) {
                return false;
            }
            $date = $b->slot->availabilityBlock->date?->format('Y-m-d');
            $dateTime = Carbon::parse($date.' '.$b->slot->start_time);

            return $dateTime->isFuture();
        })->first();

        return view('candidate.dashboard', compact('bookings', 'totalBookings', 'completedCount', 'averageScore', 'upcomingBooking'));
    }
}
