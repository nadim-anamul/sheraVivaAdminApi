<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Interviewer;
use App\Models\LiveVivaBooking;
use App\Models\PaymentTransaction;
use App\Models\Slot;
use App\Models\SystemSetting;
use App\Models\VivaPackage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function showPackagesPage()
    {
        $packages = VivaPackage::where('is_active', true)->get();
        $user = auth()->user();
        $merchantBkash = SystemSetting::get('bkash_merchant_number', '01700000000');
        $personalBkash = SystemSetting::get('bkash_personal_number', '01800000000');
        $transactions = PaymentTransaction::where('user_id', $user->id)
            ->with('package')
            ->orderBy('id', 'desc')
            ->get();

        $interviewers = Interviewer::where('is_active', true)
            ->with(['slots' => function ($q) {
                $q->where('status', 'available')->with('availabilityBlock');
            }])
            ->get();

        return view('candidate.packages', compact('packages', 'user', 'merchantBkash', 'personalBkash', 'transactions', 'interviewers'));
    }

    public function submitBkashPayment(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:viva_packages,id',
            'bkash_number' => 'required|string|min:11|max:14',
            'trx_id' => 'required|string|min:6|max:20|unique:payment_transactions,trx_id',
            'interviewer_id' => 'nullable|exists:interviewers,id',
            'exam_type' => 'nullable|string|max:255',
            'target_position' => 'nullable|string|max:255',
            'slot_id' => 'nullable|exists:slots,id',
        ]);

        $package = VivaPackage::findOrFail($request->package_id);
        $submittedTrxId = strtoupper(trim($request->trx_id));

        $paymentTx = PaymentTransaction::create([
            'user_id' => auth()->id(),
            'package_id' => $package->id,
            'type' => $package->type === 'live_human' ? 'live_viva' : 'ai_package',
            'amount_bdt' => $package->price_bdt,
            'payment_method' => 'bKash Send Money',
            'bkash_number' => $request->bkash_number,
            'trx_id' => $submittedTrxId,
            'status' => 'pending',
        ]);

        if ($package->type === 'live_human' && $request->interviewer_id && $request->slot_id) {
            $interviewer = Interviewer::find($request->interviewer_id);
            $slot = Slot::with('availabilityBlock')->find($request->slot_id);
            if ($slot) {
                $dateStr = $slot->availabilityBlock?->date ? $slot->availabilityBlock->date->format('Y-m-d') : now()->addDay()->format('Y-m-d');
                $scheduledAt = Carbon::parse($dateStr . ' ' . $slot->start_time);

                LiveVivaBooking::create([
                    'candidate_id' => auth()->id(),
                    'interviewer_id' => $interviewer?->id,
                    'payment_transaction_id' => $paymentTx->id,
                    'exam_type' => $request->exam_type ?: '46th BCS Cadre Viva',
                    'target_position' => $request->target_position ?: 'General Board',
                    'scheduled_at' => $scheduledAt,
                    'status' => 'pending_payment',
                ]);

                $slot->update(['status' => 'booked']);
            }
        }

        return redirect()->back()->with('success', "bKash Payment submitted for {$package->name}! Admin will verify TrxID: {$submittedTrxId} and activate your credits/session shortly.");
    }
}
