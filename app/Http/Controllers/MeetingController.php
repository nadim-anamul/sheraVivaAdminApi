<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Agence104\LiveKit\AccessToken;
use Agence104\LiveKit\AccessTokenOptions;
use Agence104\LiveKit\VideoGrant;
use Carbon\Carbon;

class MeetingController extends Controller
{
    /**
     * Show the meeting join form.
     */
    public function showJoinForm()
    {
        return view('viva.join');
    }

    /**
     * Handle the meeting join form submission.
     */
    public function handleJoinForm(Request $request)
    {
        $request->validate([
            'meeting_code' => 'required|string',
        ]);

        $code = trim($request->input('meeting_code'));

        // Check if booking exists
        $booking = Booking::where('meeting_code', $code)->first();

        if (!$booking) {
            return back()->withErrors(['meeting_code' => 'Invalid meeting code. Please check and try again.'])->withInput();
        }

        return redirect()->route('viva.meeting', ['meeting_code' => $code]);
    }

    /**
     * Securely join the LiveKit room.
     */
    public function join($meeting_code)
    {
        $user = Auth::user();

        // 1. Fetch booking
        $booking = Booking::with(['slot.availabilityBlock', 'interviewer', 'candidate'])
            ->where('meeting_code', $meeting_code)
            ->firstOrFail();

        // 2. Authorize user (Must be the candidate or the interviewer)
        $isExaminer = false;

        if ($user->email === $booking->interviewer->email) {
            $isExaminer = true;
        } elseif ($user->id !== $booking->candidate_id) {
            abort(403, 'You are not authorized to join this live viva session.');
        }

        // 3. Ensure payment is completed
        if ($booking->payment_status !== 'success') {
            return redirect()->route('dashboard')->withErrors([
                'message' => 'Payment has not been completed for this viva slot.'
            ]);
        }

        // 4. Validate time window (Bypass in local/testing envs)
        $now = now();
        $dateStr = $booking->slot->availabilityBlock->date->format('Y-m-d');
        $startTime = Carbon::parse($dateStr . ' ' . $booking->slot->start_time);
        $endTime = Carbon::parse($dateStr . ' ' . $booking->slot->end_time);

        // Allow joining 15 minutes early
        $bufferStartTime = $startTime->copy()->subMinutes(15);

        if (app()->environment() === 'production') {
            if ($now->lt($bufferStartTime)) {
                return redirect()->route('dashboard')->withErrors([
                    'message' => 'The viva session is not active yet. You can join starting 15 minutes before the scheduled time (' . $startTime->format('h:i A') . ').'
                ]);
            }

            if ($now->gt($endTime)) {
                return redirect()->route('dashboard')->withErrors([
                    'message' => 'This viva session has already expired.'
                ]);
            }
        }

        // 5. Generate LiveKit JWT Token
        try {
            $apiKey = env('LIVEKIT_API_KEY', 'devkey');
            $apiSecret = env('LIVEKIT_API_SECRET', 'secret_key_must_be_at_least_32_chars_long');
            $livekitUrl = env('LIVEKIT_URL', 'http://localhost:7880');

            $identity = $isExaminer ? 'examiner_' . $user->id : 'candidate_' . $user->id;
            $displayName = $isExaminer 
                ? 'Board Panelist (' . $booking->interviewer->name . ')' 
                : 'Candidate (' . $user->name . ')';

            $tokenOptions = (new AccessTokenOptions())
                ->setIdentity($identity)
                ->setName($displayName);

            $videoGrant = (new VideoGrant())
                ->setRoomJoin(true)
                ->setRoomName($booking->livekit_room_name)
                ->setCanPublish(true)
                ->setCanSubscribe(true)
                ->setCanPublishData(true);

            if ($isExaminer) {
                $videoGrant->setRoomAdmin(true);
            }

            $token = (new AccessToken($apiKey, $apiSecret))
                ->init($tokenOptions)
                ->setGrant($videoGrant)
                ->toJwt();

            $role = $isExaminer ? 'examiner' : 'candidate';

            return view('viva.meeting', compact('booking', 'token', 'livekitUrl', 'role', 'isExaminer'));

        } catch (\Exception $e) {
            abort(500, 'Failed to initialize LiveKit token: ' . $e->getMessage());
        }
    }
}
