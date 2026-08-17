<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use App\Models\SystemSetting;
use App\Models\VivaPackage;
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

        return view('candidate.packages', compact('packages', 'user', 'merchantBkash', 'personalBkash', 'transactions'));
    }

    public function submitBkashPayment(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:viva_packages,id',
            'bkash_number' => 'required|string|min:11|max:14',
            'trx_id' => 'required|string|min:6|max:20|unique:payment_transactions,trx_id',
        ]);

        $package = VivaPackage::findOrFail($request->package_id);

        PaymentTransaction::create([
            'user_id' => auth()->id(),
            'package_id' => $package->id,
            'type' => $package->type === 'live_human' ? 'live_viva' : 'ai_package',
            'amount_bdt' => $package->price_bdt,
            'payment_method' => 'bKash Send Money',
            'bkash_number' => $request->bkash_number,
            'trx_id' => strtoupper(trim($request->trx_id)),
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', "bKash Payment submitted for {$package->name}! Admin will verify TrxID: ".strtoupper(trim($request->trx_id)).' and activate your credits shortly.');
    }
}
