<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Interviewer;
use App\Models\LiveVivaBooking;
use App\Models\PaymentTransaction;
use App\Models\Slot;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LiveVivaController extends Controller
{
    public function showLiveVivasPage()
    {
        $user = auth()->user();
        $liveVivas = LiveVivaBooking::where('candidate_id', $user->id)
            ->with(['interviewer', 'paymentTransaction'])
            ->orderBy('id', 'desc')
            ->get();

        $interviewers = Interviewer::where('is_active', true)
            ->with(['slots' => function ($q) {
                $q->where('status', 'available')->with('availabilityBlock');
            }])
            ->get();

        $merchantBkash = SystemSetting::get('bkash_merchant_number', '01700000000');
        $personalBkash = SystemSetting::get('bkash_personal_number', '01800000000');

        return view('candidate.live-vivas', compact('user', 'liveVivas', 'interviewers', 'merchantBkash', 'personalBkash'));
    }

    public function submitLiveVivaBooking(Request $request)
    {
        $request->validate([
            'interviewer_id' => 'required|exists:interviewers,id',
            'exam_type' => 'required|string|max:255',
            'target_position' => 'nullable|string|max:255',
            'slot_id' => 'required|exists:slots,id',
            'bkash_number' => 'required|string|min:11|max:14',
            'trx_id' => 'required|string|min:6|max:20|unique:payment_transactions,trx_id',
        ]);

        $interviewer = Interviewer::findOrFail($request->interviewer_id);
        $slot = Slot::with('availabilityBlock')->findOrFail($request->slot_id);

        $dateStr = $slot->availabilityBlock?->date ? $slot->availabilityBlock->date->format('Y-m-d') : now()->addDay()->format('Y-m-d');
        $scheduledAt = Carbon::parse($dateStr . ' ' . $slot->start_time);

        $submittedTrxId = strtoupper(trim($request->trx_id));

        $livePackage = \App\Models\VivaPackage::where('type', 'live_human')->first();

        $paymentTx = PaymentTransaction::create([
            'user_id' => auth()->id(),
            'package_id' => $livePackage?->id,
            'type' => 'live_viva',
            'amount_bdt' => $interviewer->base_price ?: 500,
            'payment_method' => 'bKash Send Money',
            'bkash_number' => $request->bkash_number,
            'trx_id' => $submittedTrxId,
            'status' => 'pending',
        ]);

        LiveVivaBooking::create([
            'candidate_id' => auth()->id(),
            'interviewer_id' => $interviewer->id,
            'payment_transaction_id' => $paymentTx->id,
            'exam_type' => $request->exam_type,
            'target_position' => $request->target_position ?: 'General Board',
            'scheduled_at' => $scheduledAt,
            'status' => 'pending_payment',
        ]);

        $slot->update(['status' => 'booked']);

        return redirect()->back()->with('success', "Live Viva session booked with {$interviewer->name} on " . $scheduledAt->format('d M Y, h:i A') . "! Admin will verify your bKash TrxID: {$submittedTrxId}.");
    }
}
