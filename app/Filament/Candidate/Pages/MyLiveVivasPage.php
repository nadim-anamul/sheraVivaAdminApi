<?php

namespace App\Filament\Candidate\Pages;

use App\Models\Interviewer;
use App\Models\LiveVivaBooking;
use App\Models\PaymentTransaction;
use App\Models\Slot;
use App\Models\SystemSetting;
use BackedEnum;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class MyLiveVivasPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedVideoCamera;

    protected static ?string $navigationLabel = 'Live Expert Viva & Feedback';

    protected static ?string $title = '1-on-1 Live Expert Board Viva & Feedback';

    protected string $view = 'filament.candidate.pages.my-live-vivas';

    public $liveVivas = [];

    public $user;

    public $interviewers = [];

    public $merchantBkash = '';

    public $personalBkash = '';

    public $showBookingModal = false;

    public $selectedInterviewerId = null;

    public $examType = '46th BCS Cadre Viva';

    public $targetPosition = 'BCS (Administration)';

    public $selectedSlotId = null;

    public $bkashNumber = '';

    public $trxId = '';

    public $availableSlots = [];

    public function mount(): void
    {
        $this->user = auth()->user();
        if ($this->user) {
            $this->liveVivas = LiveVivaBooking::where('candidate_id', $this->user->id)
                ->with(['interviewer', 'paymentTransaction'])
                ->orderBy('id', 'desc')
                ->get();
        }

        $this->interviewers = Interviewer::where('is_active', true)
            ->withCount(['slots' => fn ($q) => $q->where('status', 'available')])
            ->get();

        $this->merchantBkash = SystemSetting::get('bkash_merchant_number', '01700000000');
        $this->personalBkash = SystemSetting::get('bkash_personal_number', '01800000000');
    }

    public function openBookingModal($interviewerId = null): void
    {
        $this->showBookingModal = true;
        if ($interviewerId) {
            $this->selectedInterviewerId = $interviewerId;
        } elseif (!$this->selectedInterviewerId && count($this->interviewers) > 0) {
            $this->selectedInterviewerId = $this->interviewers->first()->id;
        }

        $this->loadSlots();
    }

    public function closeBookingModal(): void
    {
        $this->showBookingModal = false;
    }

    public function updatedSelectedInterviewerId($value): void
    {
        $this->selectedSlotId = null;
        $this->loadSlots();
    }

    public function loadSlots(): void
    {
        if ($this->selectedInterviewerId) {
            $slots = Slot::where('interviewer_id', $this->selectedInterviewerId)
                ->where('status', 'available')
                ->with('availabilityBlock')
                ->get();

            $this->availableSlots = $slots->map(function ($slot) {
                $dateStr = $slot->availabilityBlock?->date ? $slot->availabilityBlock->date->format('D, d M Y') : 'Upcoming';
                $startTime = Carbon::parse($slot->start_time)->format('h:i A');
                $endTime = Carbon::parse($slot->end_time)->format('h:i A');

                return [
                    'id' => $slot->id,
                    'label' => "{$dateStr} | {$startTime} - {$endTime}",
                ];
            })->toArray();
        } else {
            $this->availableSlots = [];
        }
    }

    public function submitBooking(): void
    {
        $this->validate([
            'selectedInterviewerId' => 'required|exists:interviewers,id',
            'examType' => 'required|string|max:255',
            'targetPosition' => 'nullable|string|max:255',
            'selectedSlotId' => 'required|exists:slots,id',
            'bkashNumber' => 'required|string|min:11|max:14',
            'trxId' => 'required|string|min:6|max:20|unique:payment_transactions,trx_id',
        ]);

        $interviewer = Interviewer::findOrFail($this->selectedInterviewerId);
        $slot = Slot::with('availabilityBlock')->findOrFail($this->selectedSlotId);

        $dateStr = $slot->availabilityBlock?->date ? $slot->availabilityBlock->date->format('Y-m-d') : now()->addDay()->format('Y-m-d');
        $scheduledAt = Carbon::parse($dateStr . ' ' . $slot->start_time);

        $submittedTrxId = strtoupper(trim($this->trxId));

        $livePackage = \App\Models\VivaPackage::where('type', 'live_human')->first();

        $paymentTx = PaymentTransaction::create([
            'user_id' => auth()->id(),
            'package_id' => $livePackage?->id,
            'type' => 'live_viva',
            'amount_bdt' => $interviewer->base_price ?: 500,
            'payment_method' => 'bKash Send Money',
            'bkash_number' => $this->bkashNumber,
            'trx_id' => $submittedTrxId,
            'status' => 'pending',
        ]);

        LiveVivaBooking::create([
            'candidate_id' => auth()->id(),
            'interviewer_id' => $interviewer->id,
            'payment_transaction_id' => $paymentTx->id,
            'exam_type' => $this->examType,
            'target_position' => $this->targetPosition ?: 'General Board',
            'scheduled_at' => $scheduledAt,
            'status' => 'pending_payment',
        ]);

        $slot->update(['status' => 'booked']);

        $this->showBookingModal = false;
        $this->trxId = '';
        $this->bkashNumber = '';
        $this->mount();

        Notification::make()
            ->success()
            ->title('Live Viva Session Booked')
            ->body("Your 1-on-1 session with {$interviewer->name} on " . $scheduledAt->format('d M Y, h:i A') . " has been submitted! Admin will verify TrxID: {$submittedTrxId}.")
            ->send();
    }
}
